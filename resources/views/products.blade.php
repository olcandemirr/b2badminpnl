@extends('layouts.app')

@section('styles')
<style>
    .filter-badge {
        background-color: #6f42c1;
        color: white;
        padding: 5px 10px;
        border-radius: 15px;
        margin: 0 5px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .filter-badge:hover {
        background-color: #5a32a3;
    }

    .filter-badge.active {
        background-color: #5a32a3;
    }

    .table th {
        white-space: nowrap;
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }

    .table td {
        vertical-align: middle;
    }

    .search-box {
        position: relative;
        margin-bottom: 20px;
    }

    .search-box .form-control {
        padding-right: 40px;
        border-radius: 20px;
    }

    .search-box .search-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .excel-btn {
        background-color: #6f42c1;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 20px;
        transition: all 0.3s;
    }

    .excel-btn:hover {
        background-color: #5a32a3;
        color: white;
        transform: translateY(-2px);
    }

    .pagination-info {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .btn-nav {
        background-color: #6f42c1;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 20px;
        transition: all 0.3s;
    }

    .btn-nav:hover:not(:disabled) {
        background-color: #5a32a3;
        color: white;
        transform: translateY(-2px);
    }

    .btn-nav:disabled {
        background-color: #b8a2d4;
        cursor: not-allowed;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        cursor: pointer;
    }

    .action-icon {
        color: #6f42c1;
        cursor: pointer;
        margin: 0 5px;
        transition: all 0.3s;
    }

    .action-icon:hover {
        color: #5a32a3;
        transform: scale(1.2);
    }

    .text-purple {
        color: #6f42c1;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Bildirim Alanı -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Ürün Yönetimi</h2>
        <div class="search-box w-25">
            <input type="text" class="form-control" id="searchInput" placeholder="Aranacak bilgi girin...">
            <i class="fas fa-search search-icon"></i>
        </div>
        <div>
            <a href="{{ route('products.create') }}" class="btn btn-primary me-2">
                <i class="fas fa-plus me-1"></i> Ürün Ekle
            </a>
            <button class="excel-btn" id="exportExcel">
                <i class="fas fa-file-excel me-2"></i>
                Excele Aktar
            </button>
        </div>
    </div>

    @php
        $stats = Cache::get('product_stats', [
            'campaign' => 0,
            'gift' => 0,
            'showcase' => 0,
            'bestseller' => 0,
            'new' => 0,
            'counter' => 0,
            'discount' => 0,
            'passive' => 0,
            'closed' => 0
        ]);
    @endphp

    <div class="filter-badges mb-3">
        <span class="badge bg-primary filter-badge" data-filter="kampanyali">Kampanyalı ({{ $stats['campaign'] }})</span>
        <span class="badge bg-success filter-badge" data-filter="hediyeli">Hediyeli ({{ $stats['gift'] }})</span>
        <span class="badge bg-info filter-badge" data-filter="vitrin">Vitrin ({{ $stats['showcase'] }})</span>
        <span class="badge bg-warning filter-badge" data-filter="cok-satan">Çok Satan ({{ $stats['bestseller'] }})</span>
        <span class="badge bg-danger filter-badge" data-filter="yeni">Yeni Ürün ({{ $stats['new'] }})</span>
        <span class="badge bg-secondary filter-badge" data-filter="sayac">Sayaç ({{ $stats['counter'] }})</span>
        <span class="badge bg-dark filter-badge" data-filter="indirim">İndirim Stok ({{ $stats['discount'] }})</span>
        <span class="badge bg-light text-dark filter-badge" data-filter="pasif">Pasif ({{ $stats['passive'] }})</span>
        <span class="badge bg-danger filter-badge" data-filter="kapali">Kapalı ({{ $stats['closed'] }})</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                        </div>
                    </th>
                    <th>ID</th>
                    <th>Durum</th>
                    <th>Tür</th>
                    <th>Kategori</th>
                    <th>ÜrünKodu</th>
                    <th>ÜrünAdı</th>
                    <th>Fiyat</th>
                    <th>Stok</th>
                    <th>Birim</th>
                    <th>BayiFiyat</th>
                    <th>Foto</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $product->id }}">
                        </div>
                    </td>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if ($product->is_campaign)
                            <span class="badge bg-primary" title="Kampanyalı"><i class="fas fa-percentage"></i></span>
                        @endif
                        @if ($product->has_gift)
                            <span class="badge bg-success" title="Hediyeli"><i class="fas fa-gift"></i></span>
                        @endif
                        @if ($product->is_showcase)
                            <span class="badge bg-info" title="Vitrin"><i class="fas fa-star"></i></span>
                        @endif
                        @if ($product->is_bestseller)
                            <span class="badge bg-warning" title="Çok Satan"><i class="fas fa-fire"></i></span>
                        @endif
                        @if ($product->is_new)
                            <span class="badge bg-danger" title="Yeni"><i class="fas fa-bolt"></i></span>
                        @endif
                        @if ($product->has_counter)
                            <span class="badge bg-secondary" title="Sayaç"><i class="fas fa-stopwatch"></i></span>
                        @endif
                        @if ($product->has_discount_stock)
                            <span class="badge bg-dark" title="İndirim Stok"><i class="fas fa-tags"></i></span>
                        @endif
                        @if ($product->is_passive)
                            <span class="badge bg-light text-dark" title="Pasif"><i class="fas fa-pause"></i></span>
                        @endif
                        @if ($product->is_closed)
                            <span class="badge bg-danger" title="Kapalı"><i class="fas fa-ban"></i></span>
                        @endif
                    </td>
                    <td>{{ $product->type }}</td>
                    <td>{{ $product->category }}</td>
                    <td>{{ $product->product_code }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->price1, 2, ',', '.') }} {{ $product->currency1 ?? 'TL' }}</td>
                    <td>{{ $product->warehouse1_stock + $product->warehouse2_stock + $product->warehouse3_stock }}</td>
                    <td>{{ $product->unit }}</td>
                    <td>{{ number_format($product->price2, 2, ',', '.') }} {{ $product->currency2 ?? 'TL' }}</td>
                    <td>
                        @if ($product->photo)
                            <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}" width="50" height="50" class="img-thumbnail">
                        @else
                            <span class="text-muted"><i class="fas fa-image"></i></span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="action-icon edit-product" title="Düzenle">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="javascript:void(0)" class="action-icon delete-product" data-id="{{ $product->id }}" title="Sil">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="13" class="text-center">Veri Bulunamadı</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="pagination-info">
            @if ($products->total() > 0)
                {{ ($products->currentPage() - 1) * $products->perPage() + 1 }} ile 
                {{ min($products->currentPage() * $products->perPage(), $products->total()) }} arası gösteriliyor
                (Toplam: {{ $products->total() }} kayıt)
            @else
                0 kayıt
            @endif
        </div>
        <div>
            <button class="btn-nav me-2" id="prevPage" {{ $products->currentPage() == 1 ? 'disabled' : '' }}>
                <i class="fas fa-chevron-left me-1"></i>
                Önceki
            </button>
            <button class="btn-nav" id="nextPage" {{ !$products->hasMorePages() ? 'disabled' : '' }}>
                Sonraki
                <i class="fas fa-chevron-right ms-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- Silme İşlemi Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Ürün Silme Onayı</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Bu ürünü silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
        <button type="button" class="btn btn-danger" id="confirmDelete">Evet, Sil</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Filtre badge'lerini tıklanabilir yapma
    $('.filter-badge').click(function() {
        let filter = $(this).data('filter');
        $(this).toggleClass('active');
        
        // Aktif filtreleri topla
        let activeFilters = $('.filter-badge.active').map(function() {
            return $(this).data('filter');
        }).get();
        
        // URL'yi güncelle
        let url = new URL(window.location);
        url.searchParams.delete('filter');
        
        if (activeFilters.length > 0) {
            activeFilters.forEach(function(filter) {
                url.searchParams.append('filter', filter);
            });
        }
        
        window.location.href = url.toString();
    });

    // Tüm checkbox'ları seçme/kaldırma
    $('#selectAll').change(function() {
        $('tbody input[type="checkbox"]').prop('checked', $(this).prop('checked'));
    });

    // Arama fonksiyonu
    $('#searchInput').on('keyup', function(e) {
        if(e.keyCode === 13) {
            let searchTerm = $(this).val().trim();
            if (searchTerm) {
                let url = new URL(window.location);
                url.searchParams.set('search', searchTerm);
                window.location.href = url.toString();
            }
        }
    });

    // Excel'e aktarma
    $('#exportExcel').click(function() {
        window.location.href = "{{ route('products.export') }}";
    });

    // Sayfalama butonları
    $('#prevPage').click(function() {
        if (!$(this).prop('disabled')) {
            window.location.href = "{{ $products->previousPageUrl() }}";
        }
    });

    $('#nextPage').click(function() {
        if (!$(this).prop('disabled')) {
            window.location.href = "{{ $products->nextPageUrl() }}";
        }
    });
    
    // URL'den filtreleri kontrol et ve aktif et
    let urlParams = new URLSearchParams(window.location.search);
    let filterParams = urlParams.getAll('filter');
    
    filterParams.forEach(function(filter) {
        $(`.filter-badge[data-filter="${filter}"]`).addClass('active');
    });
    
    // Ürün silme işlemi
    let productIdToDelete = null;
    
    $('.delete-product').click(function() {
        productIdToDelete = $(this).data('id');
        $('#deleteModal').modal('show');
    });
    
    $('#confirmDelete').click(function() {
        if (productIdToDelete) {
            $.ajax({
                url: `/products/${productIdToDelete}`,
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
                        alert('Silme işlemi sırasında bir hata oluştu.');
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
@endsection 