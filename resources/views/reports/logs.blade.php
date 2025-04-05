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
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" placeholder="Başlangıç Tarihi">
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" placeholder="Bitiş Tarihi">
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
                                <a href="{{ route('reports.logs.export') }}?{{ http_build_query(request()->except('page')) }}" class="btn btn-success w-100">
                                    <i class="fas fa-file-csv"></i> CSV'e Aktar
                                </a>
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
                                    <th>Detay</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                <tr>
                                    <td>{{ $log->id }}</td>
                                    <td>{{ $log->created_at->format('d.m.Y H:i:s') }}</td>
                                    <td>{{ $log->user_id }}</td>
                                    <td>{{ $log->user ? $log->user->name : 'Bilinmiyor' }}</td>
                                    <td>{{ $log->ip_address }}</td>
                                    <td>{{ $log->user ? $log->user->first_name . ' ' . $log->user->last_name : '' }}</td>
                                    <td>{{ $log->dealer ? $log->dealer->company_title : '' }}</td>
                                    <td>{{ $log->action }}</td>
                                    <td>{{ Str::limit($log->details, 30) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Kayıt bulunamadı</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Sayfalama -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            Gösteriliyor {{ $logs->firstItem() ?? 0 }} ile {{ $logs->lastItem() ?? 0 }} arası, toplam {{ $logs->total() ?? 0 }} kayıt
                        </div>
                        {{ $logs->appends(request()->except('page'))->links() }}
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