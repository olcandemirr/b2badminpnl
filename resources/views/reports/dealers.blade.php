@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bayi Raporları</h3>
                </div>
                <div class="card-body">
                    <!-- Filtreler -->
                    <form method="GET" action="{{ route('reports.dealers') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <select name="dealer_type" class="form-select">
                                    <option value="">-BAYİ TİPİ SEÇİNİZ-</option>
                                    <option value="Ana Bayi" {{ request('dealer_type') == 'Ana Bayi' ? 'selected' : '' }}>Ana Bayi</option>
                                    <option value="Alt Bayi" {{ request('dealer_type') == 'Alt Bayi' ? 'selected' : '' }}>Alt Bayi</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">-DURUM-</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="passive" {{ request('status') == 'passive' ? 'selected' : '' }}>Pasif</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_super_dealer" id="isSuperDealer" {{ request('is_super_dealer') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isSuperDealer">
                                        Super Dealer
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Aranacak bilgi girin..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> SORGULA
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('reports.dealers.export') }}?{{ http_build_query(request()->except('page')) }}" class="btn btn-success w-100">
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
                                    <th>Bayi No</th>
                                    <th>Ünvan</th>
                                    <th>Bayi Tipi</th>
                                    <th>E-mail</th>
                                    <th>Telefon</th>
                                    <th>Şehir</th>
                                    <th>İlçe</th>
                                    <th>Toplam Sipariş</th>
                                    <th>Toplam Tutar</th>
                                    <th>Kayıt Tarihi</th>
                                    <th>Durum</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dealers as $dealer)
                                <tr>
                                    <td>{{ $dealer->id }}</td>
                                    <td>{{ $dealer->dealer_no }}</td>
                                    <td>{{ $dealer->company_title }}</td>
                                    <td>{{ $dealer->dealer_type }}</td>
                                    <td>{{ $dealer->email }}</td>
                                    <td>{{ $dealer->phone }}</td>
                                    <td>{{ $dealer->city }}</td>
                                    <td>{{ $dealer->district }}</td>
                                    <td>{{ $dealer->total_orders ?? 0 }}</td>
                                    <td>{{ number_format($dealer->total_amount ?? 0, 2) }} TL</td>
                                    <td>{{ $dealer->created_at->format('d.m.Y') }}</td>
                                    <td>
                                        @if($dealer->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Pasif</span>
                                        @endif
                                        @if($dealer->is_super_dealer)
                                            <span class="badge bg-primary">Super</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="12" class="text-center">Kayıt bulunamadı</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Sayfalama -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            Gösteriliyor {{ $dealers->firstItem() ?? 0 }} ile {{ $dealers->lastItem() ?? 0 }} arası, toplam {{ $dealers->total() ?? 0 }} kayıt
                        </div>
                        {{ $dealers->appends(request()->except('page'))->links() }}
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
}

.table td {
    vertical-align: middle;
    white-space: nowrap;
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
</style>
@endpush 