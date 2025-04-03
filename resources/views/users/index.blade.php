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
                    <!-- Filtreler -->
                    <form method="GET" action="{{ route('users.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-10">
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
                                    <th>Düz</th>
                                    <th>No</th>
                                    <th>Tipi</th>
                                    <th>Kullanıcı Adı</th>
                                    <th>Ad Soyad</th>
                                    <th>Durumu</th>
                                    <th class="text-center">İşlemler</th>
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
    text-align: left;
}

.table td:last-child {
    text-align: center;
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

.status-active {
    color: #198754;
    background-color: #d1e7dd;
    border-color: #badbcc;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}

.status-inactive {
    color: #dc3545;
    background-color: #f8d7da;
    border-color: #f5c2c7;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}

.edit-button {
    color: #0d6efd;
    cursor: pointer;
}

.edit-button:hover {
    color: #0a58ca;
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