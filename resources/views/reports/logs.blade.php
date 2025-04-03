@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Log Raporları</h3>
                </div>
                <div class="card-body">
                    <!-- Filtreler -->
                    <form method="GET" action="{{ route('reports.logs') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
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
                                    <th>ID</th>
                                    <th>Tarih</th>
                                    <th>KulNo</th>
                                    <th>KulAdı</th>
                                    <th>IP</th>
                                    <th>AdSoyad</th>
                                    <th>Unvan</th>
                                    <th>İşlem</th>
                                    <th>Kelime</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log['id'] }}</td>
                                    <td>{{ $log['tarih'] }}</td>
                                    <td>{{ $log['kulNo'] }}</td>
                                    <td>{{ $log['kulAdi'] }}</td>
                                    <td>{{ $log['ip'] }}</td>
                                    <td>{{ $log['adSoyad'] }}</td>
                                    <td>{{ $log['unvan'] }}</td>
                                    <td>{{ $log['islem'] }}</td>
                                    <td>{{ $log['kelime'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Sayfalama -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            Gösteriliyor 1 ile 3 arası 3 toplam
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
}

.table td {
    vertical-align: middle;
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
$(document).ready(function() {
    // Excel export butonu
    $('#exportExcel').click(function() {
        // Excel export işlemi burada yapılacak
        alert('Excel export özelliği eklenecek');
    });
});
</script>
@endpush 