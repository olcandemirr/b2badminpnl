@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Sanal Pos Ödeme Listesi</h3>
                    <button type="button" class="btn btn-primary btn-sm" onclick="exportToExcel()">
                        <i class="fas fa-file-excel me-1"></i> Excele Aktar
                    </button>
                </div>
                <div class="card-body">
                    <!-- Arama ve Filtreleme Formu -->
                    <form action="{{ route('payments.virtual-pos.payments') }}" method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <input type="date" name="start_date" class="form-control" placeholder="Başlangıç Tarihi">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="end_date" class="form-control" placeholder="Bitiş Tarihi">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Aranacak bilgi girin...">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-1"></i> Sorgula
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Ödeme Listesi Tablosu -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px">Dekont</th>
                                    <th style="width: 80px">ID</th>
                                    <th>İşlem No</th>
                                    <th>Tarih</th>
                                    <th>Tutar</th>
                                    <th>Vadeli Tutar</th>
                                    <th>Taksit</th>
                                    <th>İşlem Bank</th>
                                    <th>Ünvan</th>
                                    <th>Ad Soyad</th>
                                    <th>İp</th>
                                    <th>Kart No</th>
                                    <th>Ödeme Şekli</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Veriler veritabanından gelecek -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">Genel Toplam:</td>
                                    <td class="fw-bold">0.00 TL</td>
                                    <td class="fw-bold">0.00 TL</td>
                                    <td colspan="7"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            0 kayıttan 0 ile 0 arası gösteriliyor
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end mb-0">
                                <li class="page-item active"><span class="page-link">1</span></li>
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
    font-weight: 600;
    font-size: 0.9rem;
    white-space: nowrap;
}

.table td {
    vertical-align: middle;
}

.table tr:hover {
    background-color: #f8f9fa;
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
function exportToExcel() {
    alert('Excel export işlemi başlatılacak');
}
</script>
@endpush 