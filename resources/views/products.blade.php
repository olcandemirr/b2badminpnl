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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Ürün Yönetimi</h2>
        <div class="search-box w-25">
            <input type="text" class="form-control" id="searchInput" placeholder="Aranacak bilgi girin...">
            <i class="fas fa-search search-icon"></i>
        </div>
        <button class="excel-btn" id="exportExcel">
            <i class="fas fa-file-excel me-2"></i>
            Excele Aktar
        </button>
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

    <div class="filter-badges">
        <span class="badge bg-primary">Kampanyalı ({{ $stats['campaign'] }})</span>
        <span class="badge bg-success">Hediyeli ({{ $stats['gift'] }})</span>
        <span class="badge bg-info">Vitrin ({{ $stats['showcase'] }})</span>
        <span class="badge bg-warning">Çok Satan ({{ $stats['bestseller'] }})</span>
        <span class="badge bg-danger">Yeni Ürün ({{ $stats['new'] }})</span>
        <span class="badge bg-secondary">Sayaç ({{ $stats['counter'] }})</span>
        <span class="badge bg-dark">İndirim Stok ({{ $stats['discount'] }})</span>
        <span class="badge bg-light text-dark">Pasif ({{ $stats['passive'] }})</span>
        <span class="badge bg-danger">Kapalı ({{ $stats['closed'] }})</span>
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
                    <th>Alternatif</th>
                    <th>EkÜrün</th>
                    <th>Foto</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="15" class="text-center">Veri Bulunamadı</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="pagination-info">0 kayıttan 0 ile 0 arası gösteriliyor</div>
        <div>
            <button class="btn-nav me-2" id="prevPage" disabled>
                <i class="fas fa-chevron-left me-1"></i>
                Önceki
            </button>
            <button class="btn-nav" id="nextPage" disabled>
                Sonraki
                <i class="fas fa-chevron-right ms-1"></i>
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Filtre badge'lerini tıklanabilir yapma
    $('.filter-badge').click(function() {
        $(this).toggleClass('active');
        // Burada filtre işlemi yapılabilir
    });

    // Tüm checkbox'ları seçme/kaldırma
    $('#selectAll').change(function() {
        $('tbody input[type="checkbox"]').prop('checked', $(this).prop('checked'));
    });

    // Arama fonksiyonu
    $('#searchInput').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        // Burada arama işlemi yapılabilir
    });

    // Excel'e aktarma
    $('#exportExcel').click(function() {
        // Excel'e aktarma işlemi
        alert('Excel\'e aktarma işlemi başlatılıyor...');
    });

    // Sayfalama butonları
    $('#prevPage').click(function() {
        if (!$(this).prop('disabled')) {
            // Önceki sayfa işlemi
        }
    });

    $('#nextPage').click(function() {
        if (!$(this).prop('disabled')) {
            // Sonraki sayfa işlemi
        }
    });
});
</script>
@endsection 