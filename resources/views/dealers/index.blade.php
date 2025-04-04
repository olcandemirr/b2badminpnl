@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Bayi Yönetimi</h3>
                    <div class="input-group" style="width: 300px;">
                        <input type="text" class="form-control" placeholder="Bayi Arayın..." id="quickSearch">
                        <button class="btn btn-outline-secondary" type="button" id="quickSearchBtn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Session mesajları -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <!-- Üst Butonlar -->
                    <div class="mb-4">
                        <a href="{{ route('dealers.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Yeni Bayi Ekle
                        </a>
                        <a href="{{ route('dealers.create') }}?super_dealer=1" class="btn btn-primary ms-2">
                            <i class="fas fa-star"></i> Super Dealer Ekle
                        </a>
                    </div>

                    <!-- Filtreler -->
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <a href="{{ route('dealers.index') }}?dealer_type=Ana%20Bayi" class="btn btn-primary w-100" id="anaBayi">
                                Ana Bayi <span class="badge bg-light text-dark">{{ $stats['anaBayi'] }}</span>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('dealers.index') }}?dealer_type=Alt%20Bayi" class="btn btn-primary w-100" id="altBayi">
                                Alt Bayi <span class="badge bg-light text-dark">{{ $stats['altBayi'] }}</span>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('dealers.index') }}?is_super_dealer=1" class="btn btn-warning w-100" id="superDealer">
                                Super Dealer <span class="badge bg-light text-dark">{{ $stats['superDealer'] }}</span>
                            </a>
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="searchQuery" value="{{ request('search') }}" placeholder="Aranacak bilgi girin...">
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary w-100" id="searchButton">
                                <i class="fas fa-search"></i> ARA
                            </button>
                        </div>
                    </div>

                    <!-- Excel Export Butonu -->
                    <div class="mb-3">
                        <form id="exportForm" action="{{ route('dealers.export') }}" method="GET">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="dealer_type" value="{{ request('dealer_type') }}">
                            <input type="hidden" name="is_super_dealer" value="{{ request('is_super_dealer') }}">
                            <button type="submit" class="btn btn-purple">
                                <i class="fas fa-file-excel"></i> CSV'e Aktar
                            </button>
                        </form>
                    </div>

                    <!-- Bayiler Tablosu -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>İşlemler</th>
                                    <th>No</th>
                                    <th>BayiNo</th>
                                    <th>Ünvan</th>
                                    <th>KulAdı</th>
                                    <th>BayiTip</th>
                                    <th>S.Dealer</th>
                                    <th>AnaBayi</th>
                                    <th>Telefon</th>
                                    <th>Adres</th>
                                    <th>Durumu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dealers ?? [] as $dealer)
                                <tr>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="{{ route('dealers.edit', $dealer->id) }}"><i class="fas fa-edit"></i> Düzenle</a></li>
                                                @if($dealer->is_super_dealer)
                                                    <li><a class="dropdown-item" href="{{ route('dealers.remove-super-dealer', $dealer->id) }}"><i class="fas fa-star-half-alt"></i> Super Dealer Kaldır</a></li>
                                                @else
                                                    <li><a class="dropdown-item" href="{{ route('dealers.make-super-dealer', $dealer->id) }}"><i class="fas fa-star"></i> Super Dealer Yap</a></li>
                                                @endif
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger delete-dealer" href="#" data-id="{{ $dealer->id }}" data-name="{{ $dealer->company_title }}"><i class="fas fa-trash"></i> Sil</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $dealer->dealer_no ?? '' }}</td>
                                    <td>{{ $dealer->company_title ?? '' }}</td>
                                    <td>{{ $dealer->username ?? '' }}</td>
                                    <td>{{ $dealer->dealer_type ?? '' }}</td>
                                    <td>
                                        @if($dealer->is_super_dealer)
                                            <span class="badge bg-warning text-dark"><i class="fas fa-star"></i> Evet</span>
                                        @else
                                            <span class="badge bg-secondary">Hayır</span>
                                        @endif
                                    </td>
                                    <td>{{ $dealer->main_dealer ?? '' }}</td>
                                    <td>{{ $dealer->phone ?? '' }}</td>
                                    <td>{{ Str::limit($dealer->address ?? '', 20) }}</td>
                                    <td>
                                        @if($dealer->is_active ?? false)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Pasif</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="11" class="text-center">Veri Bulunamadı</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            Gösteriliyor {{ $dealers->firstItem() ?? 0 }} ile {{ $dealers->lastItem() ?? 0 }} arası {{ $dealers->total() ?? 0 }} kayıttan
                        </div>
                        <div>
                            {{ $dealers->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Silme Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Bayi Silme Onayı</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Seçilen bayiyi silmek istediğinize emin misiniz?</p>
                <p id="dealerNameToDelete" class="text-danger fw-bold"></p>
                <p>Bu işlem geri alınamaz!</p>
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
    .btn-purple {
        background-color: #6f42c1;
        color: white;
    }
    .btn-purple:hover {
        background-color: #5a32a3;
        color: white;
    }
    
    .table thead th {
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Hızlı arama işlemi
    $('#quickSearchBtn').click(function() {
        const searchQuery = $('#quickSearch').val();
        window.location.href = `{{ route('dealers.index') }}?search=${searchQuery}`;
    });
    
    $('#quickSearch').keypress(function(e) {
        if (e.which === 13) {
            const searchQuery = $(this).val();
            window.location.href = `{{ route('dealers.index') }}?search=${searchQuery}`;
        }
    });

    // Detaylı arama butonu tıklama
    $('#searchButton').click(function() {
        const searchQuery = $('#searchQuery').val();
        window.location.href = `{{ route('dealers.index') }}?search=${searchQuery}`;
    });
    
    // Enter tuşu ile arama yapma
    $('#searchQuery').keypress(function(e) {
        if (e.which === 13) {
            const searchQuery = $(this).val();
            window.location.href = `{{ route('dealers.index') }}?search=${searchQuery}`;
        }
    });

    // Silme işlemi
    $('.delete-dealer').click(function(e) {
        e.preventDefault();
        const dealerId = $(this).data('id');
        const dealerName = $(this).data('name');
        
        $('#dealerNameToDelete').text(dealerName);
        $('#confirmDelete').data('id', dealerId);
        $('#deleteModal').modal('show');
    });
    
    $('#confirmDelete').click(function() {
        const dealerId = $(this).data('id');
        
        $.ajax({
            url: `/dealers/${dealerId}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#deleteModal').modal('hide');
                    window.location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Silme işlemi sırasında bir hata oluştu.');
            }
        });
    });
});
</script>
@endpush 
