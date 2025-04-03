@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Yıllık Satış</h3>
                </div>
                <div class="card-body">
                    <!-- Filtreler -->
                    <form method="GET" action="{{ route('reports.yearly-sales') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <select name="year" class="form-select">
                                    <option value="2025">2025</option>
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="type" class="form-select">
                                    <option value="">Seçiniz</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Aranacak bilgi girin..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> SORGULA
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-secondary" id="exportExcel">
                                    <i class="fas fa-file-excel"></i> Excele Aktar
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Tablo -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <i class="fas fa-sort"></i>
                                    </th>
                                    <th>OCAK</th>
                                    <th>ŞUBAT</th>
                                    <th>MART</th>
                                    <th>NİSAN</th>
                                    <th>MAYIS</th>
                                    <th>HAZİRAN</th>
                                    <th>TEMMUZ</th>
                                    <th>AĞUSTOS</th>
                                    <th>EYLÜL</th>
                                    <th>EKİM</th>
                                    <th>KASIM</th>
                                    <th>ARALIK</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>BRÜT TUTAR</th>
                                    <th>BRÜT TUTAR</th>
                                    <th>BRÜT TUTAR</th>
                                    <th>BRÜT TUTAR</th>
                                    <th>BRÜT TUTAR</th>
                                    <th>BRÜT TUTAR</th>
                                    <th>BRÜT TUTAR</th>
                                    <th>BRÜT TUTAR</th>
                                    <th>BRÜT TUTAR</th>
                                    <th>BRÜT TUTAR</th>
                                    <th>BRÜT TUTAR</th>
                                    <th>BRÜT TUTAR</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>İSKONTO</th>
                                    <th>İSKONTO</th>
                                    <th>İSKONTO</th>
                                    <th>İSKONTO</th>
                                    <th>İSKONTO</th>
                                    <th>İSKONTO</th>
                                    <th>İSKONTO</th>
                                    <th>İSKONTO</th>
                                    <th>İSKONTO</th>
                                    <th>İSKONTO</th>
                                    <th>İSKONTO</th>
                                    <th>İSKONTO</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>NET TUTAR</th>
                                    <th>NET TUTAR</th>
                                    <th>NET TUTAR</th>
                                    <th>NET TUTAR</th>
                                    <th>NET TUTAR</th>
                                    <th>NET TUTAR</th>
                                    <th>NET TUTAR</th>
                                    <th>NET TUTAR</th>
                                    <th>NET TUTAR</th>
                                    <th>NET TUTAR</th>
                                    <th>NET TUTAR</th>
                                    <th>NET TUTAR</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>KDV DAHİL</th>
                                    <th>KDV DAHİL</th>
                                    <th>KDV DAHİL</th>
                                    <th>KDV DAHİL</th>
                                    <th>KDV DAHİL</th>
                                    <th>KDV DAHİL</th>
                                    <th>KDV DAHİL</th>
                                    <th>KDV DAHİL</th>
                                    <th>KDV DAHİL</th>
                                    <th>KDV DAHİL</th>
                                    <th>KDV DAHİL</th>
                                    <th>KDV DAHİL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Veriler veritabanından gelecek -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Sayfalama -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            0 kayıttan 0 ile 0 arası gösteriliyor
                        </div>
                        <nav>
                            <ul class="pagination mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Önceki</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item disabled">
                                    <a class="page-link" href="#">Sonraki</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
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
    text-align: center;
}

.table td {
    vertical-align: middle;
    white-space: nowrap;
    text-align: right;
}

.pagination {
    margin-bottom: 0;
}

.page-link {
    padding: 0.375rem 0.75rem;
}

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.fa-sort {
    cursor: pointer;
}

.fa-sort:hover {
    color: #0d6efd;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Excel export butonu
    $('#exportExcel').click(function() {
        // Excel export işlemi burada yapılacak
        alert('Excel export özelliği eklenecek');
    });

    // Sıralama işlemi
    $('.fa-sort').click(function() {
        // Sıralama işlemi burada yapılacak
        alert('Sıralama özelliği eklenecek');
    });
});
</script>
@endpush 