@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Havale Hesapları</h3>
                    <a href="{{ route('payments.bank-accounts.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Yeni Hesap Ekle
                    </a>
                </div>
                <div class="card-body">
                    <!-- Arama Formu -->
                    <form action="{{ route('payments.bank-accounts') }}" method="GET" class="mb-4">
                        <div class="row g-3">
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

                    <!-- Havale Hesapları Tablosu -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px">Düz</th>
                                    <th style="width: 80px">ID</th>
                                    <th>Banka</th>
                                    <th>Hesap Adı</th>
                                    <th>Şube Adı</th>
                                    <th>Şube Kodu</th>
                                    <th>Hesap No</th>
                                    <th>IBAN No</th>
                                    <th style="width: 100px">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Veriler veritabanından gelecek -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Gösterilen: 1 ile 1 arası, toplam 1
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