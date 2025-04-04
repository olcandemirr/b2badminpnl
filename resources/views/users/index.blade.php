@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kullanıcı Yönetimi</h3>
                </div>
                <div class="card-body">
                    <!-- Bildirim Alanı -->
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Filtreler -->
                    <div class="d-flex justify-content-between mb-4">
                        <form method="GET" action="{{ route('users.index') }}" class="d-flex gap-2 flex-grow-1 me-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Aranacak bilgi girin..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Ara
                                </button>
                            </div>
                        </form>
                        <div class="d-flex gap-2">
                            <a href="{{ route('users.create') }}" class="btn btn-success">
                                <i class="fas fa-user-plus"></i> Yeni Kullanıcı
                            </a>
                            <a href="{{ route('users.export') }}" class="btn btn-secondary">
                                <i class="fas fa-file-excel"></i> Excele Aktar
                            </a>
                        </div>
                    </div>

                    <!-- Tablo -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </div>
                                    </th>
                                    <th>ID</th>
                                    <th>Kullanıcı Adı</th>
                                    <th>E-posta</th>
                                    <th>Ad Soyad</th>
                                    <th>Tipi</th>
                                    <th>Durumu</th>
                                    <th class="text-center">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                <tr>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $user->id }}">
                                        </div>
                                    </td>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->full_name }}</td>
                                    <td>{{ $user->user_type_text }}</td>
                                    <td>
                                        <span class="badge {{ $user->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $user->status_text }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary" title="Düzenle">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger delete-user" data-id="{{ $user->id }}" title="Sil">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Kullanıcı bulunamadı</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Sayfalama -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            @if ($users->total() > 0)
                                {{ ($users->currentPage() - 1) * $users->perPage() + 1 }} ile 
                                {{ min($users->currentPage() * $users->perPage(), $users->total()) }} arası gösteriliyor
                                (Toplam: {{ $users->total() }} kayıt)
                            @else
                                0 kayıt
                            @endif
                        </div>
                        <div>
                            {{ $users->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Silme İşlemi Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Kullanıcı Silme Onayı</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Bu kullanıcıyı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
        <button type="button" class="btn btn-danger" id="confirmDelete">Evet, Sil</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.card-title {
    margin-bottom: 0;
    font-size: 1.1rem;
    font-weight: 600;
}

.table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    white-space: nowrap;
    font-size: 0.9rem;
}

.table td {
    vertical-align: middle;
    white-space: nowrap;
}

.pagination {
    margin-bottom: 0;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Tüm checkbox'ları seçme/kaldırma
    $('#selectAll').change(function() {
        $('tbody input[type="checkbox"]').prop('checked', $(this).prop('checked'));
    });
    
    // Kullanıcı silme işlemi
    let userIdToDelete = null;
    
    $('.delete-user').click(function() {
        userIdToDelete = $(this).data('id');
        $('#deleteModal').modal('show');
    });
    
    $('#confirmDelete').click(function() {
        if (userIdToDelete) {
            $.ajax({
                url: `/users/${userIdToDelete}`,
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    if (response.success) {
                        // Başarılı silme işlemi
                        location.reload();
                    } else {
                        alert(response.message || 'Silme işlemi sırasında bir hata oluştu.');
                    }
                },
                error: function() {
                    $('#deleteModal').modal('hide');
                    alert('Silme işlemi sırasında bir hata oluştu.');
                }
            });
        }
    });
    
    // Bildirim otomatik kapanma
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
});
</script>
@endpush 