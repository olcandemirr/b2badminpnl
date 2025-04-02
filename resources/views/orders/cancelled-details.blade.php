@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">İptal Siparişler</h3>
                    <div class="input-group" style="width: 300px;">
                        <input type="text" class="form-control" placeholder="Ürün Arayın...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtreler -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="startDate">
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="endDate">
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="searchQuery" placeholder="Aranacak bilgi girin...">
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary w-100" id="searchButton">
                                <i class="fas fa-search"></i> SORGULA
                            </button>
                        </div>
                    </div>

                    <!-- Excel Export Butonu -->
                    <div class="mb-3">
                        <button class="btn btn-success" id="exportExcel">
                            <i class="fas fa-file-excel"></i> Excele Aktar
                        </button>
                    </div>

                    <!-- Siparişler Detay Tablosu -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Det</th>
                                    <th>Yaz</th>
                                    <th>ID</th>
                                    <th>SipNo</th>
                                    <th>Ünvan</th>
                                    <th>AdSoyad</th>
                                    <th>Durum</th>
                                    <th>ÜrünKodu</th>
                                    <th>Ürün</th>
                                    <th>Adet</th>
                                    <th>Fiyat</th>
                                    <th>Tutar</th>
                                    <th>İskonto</th>
                                    <th>NetTutar</th>
                                    <th>SiparisTutar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orderDetails ?? [] as $detail)
                                <tr>
                                    <td>
                                        <button class="btn btn-sm btn-info">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-secondary">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </td>
                                    <td>{{ $detail->id ?? '' }}</td>
                                    <td>{{ $detail->order_number ?? '' }}</td>
                                    <td>{{ $detail->company_title ?? '' }}</td>
                                    <td>{{ $detail->customer_name ?? '' }}</td>
                                    <td>
                                        <span class="badge bg-danger">İptal</span>
                                    </td>
                                    <td>{{ $detail->product_code ?? '' }}</td>
                                    <td>{{ $detail->product_name ?? '' }}</td>
                                    <td>{{ $detail->quantity ?? '' }}</td>
                                    <td>{{ number_format($detail->unit_price ?? 0, 2) }} TL</td>
                                    <td>{{ number_format($detail->total ?? 0, 2) }} TL</td>
                                    <td>{{ number_format($detail->discount ?? 0, 2) }} TL</td>
                                    <td>{{ number_format($detail->net_total ?? 0, 2) }} TL</td>
                                    <td>{{ number_format($detail->order_total ?? 0, 2) }} TL</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="15" class="text-center">Veri Bulunamadı</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            Gösteriliyor {{ $orderDetails->firstItem() ?? 0 }} ile {{ $orderDetails->lastItem() ?? 0 }} arası {{ $orderDetails->total() ?? 0 }} kayıttan
                        </div>
                        <div>
                            {{ $orderDetails->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Tarih alanları için varsayılan değerler
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    $('#startDate').val(formattedDate);
    $('#endDate').val(formattedDate);

    // Sorgula butonu tıklama
    $('#searchButton').click(function() {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        const searchQuery = $('#searchQuery').val();
        
        window.location.href = `/orders/cancelled/details?start_date=${startDate}&end_date=${endDate}&search=${searchQuery}`;
    });

    // Excel export butonu tıklama
    $('#exportExcel').click(function() {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        const searchQuery = $('#searchQuery').val();
        
        window.location.href = `/orders/cancelled/details/export?start_date=${startDate}&end_date=${endDate}&search=${searchQuery}`;
    });
});
</script>
@endpush 