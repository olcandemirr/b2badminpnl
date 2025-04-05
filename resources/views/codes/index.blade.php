@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Kod Listesi</h3>
                    <a href="{{ route('codes.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Yeni Kod Ekle
                    </a>
                </div>
                <div class="card-body">
                    <!-- Arama Formu -->
                    <form action="{{ route('codes.index') }}" method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Aranacak bilgi girin..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="type" class="form-select">
                                    <option value="">Tür Seçiniz</option>
                                    <option value="genel" {{ request('type') == 'genel' ? 'selected' : '' }}>Genel</option>
                                    <option value="ozel" {{ request('type') == 'ozel' ? 'selected' : '' }}>Özel</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-1"></i> Sorgula
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Kod Listesi Tablosu -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px">ID</th>
                                    <th>Kod</th>
                                    <th>Türü</th>
                                    <th>Açıklama</th>
                                    <th>Başlangıç</th>
                                    <th>Bitiş</th>
                                    <th>İndirim</th>
                                    <th>Kullanım</th>
                                    <th>Durum</th>
                                    <th style="width: 100px">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($codes as $code)
                                <tr>
                                    <td>{{ $code->id }}</td>
                                    <td>{{ $code->code }}</td>
                                    <td>{{ $code->type == 'genel' ? 'Genel' : 'Özel' }}</td>
                                    <td>{{ $code->description ?? '-' }}</td>
                                    <td>{{ $code->start_date ? $code->start_date->format('d.m.Y') : '-' }}</td>
                                    <td>{{ $code->end_date ? $code->end_date->format('d.m.Y') : '-' }}</td>
                                    <td>
                                        @if($code->discount_type == 'percentage')
                                            %{{ number_format($code->discount_amount, 0) }}
                                        @else
                                            {{ number_format($code->discount_amount, 2) }} TL
                                        @endif
                                    </td>
                                    <td>{{ $code->usage_count }} / {{ $code->usage_limit ?? '∞' }}</td>
                                    <td>
                                        @if($code->isValid())
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Pasif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('codes.edit', $code->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger delete-item" 
                                                    data-id="{{ $code->id }}" 
                                                    data-url="{{ route('codes.destroy', $code->id) }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">Henüz kod eklenmemiş</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Gösterilen: {{ $codes->firstItem() ?? 0 }} ile {{ $codes->lastItem() ?? 0 }} arası, toplam {{ $codes->total() ?? 0 }}
                        </div>
                        {{ $codes->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Silme Onay Modalı -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Kod Silme</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bu kodu silmek istediğinizden emin misiniz?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Sil</button>
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
    font-weight: 600;
    font-size: 0.9rem;
}

.table td {
    vertical-align: middle;
}

.table tr:hover {
    background-color: #f8f9fa;
}

.btn-icon {
    padding: 0.25rem 0.5rem;
    font-size: 0.9rem;
}

.pagination {
    margin-bottom: 0;
}

.page-link {
    padding: 0.375rem 0.75rem;
}
</style>
@endpush

@push('scripts')
<script>
    // Kod silme işlemi için
    $(document).ready(function() {
        let deleteUrl = '';
        
        $('.delete-item').on('click', function() {
            deleteUrl = $(this).data('url');
            $('#deleteModal').modal('show');
        });
        
        $('#confirmDelete').on('click', function() {
            if (deleteUrl) {
                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('İşlem sırasında bir hata oluştu.');
                    }
                });
            }
        });
    });
</script>
@endpush 