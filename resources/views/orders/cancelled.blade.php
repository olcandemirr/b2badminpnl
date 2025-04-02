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

                    <!-- Siparişler Tablosu -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Det</th>
                                    <th>Yaz</th>
                                    <th>ID</th>
                                    <th>SipNo</th>
                                    <th>Durum</th>
                                    <th>Ödeme</th>
                                    <th>Tarih</th>
                                    <th>Saat</th>
                                    <th>Ünvan</th>
                                    <th>BayiTip</th>
                                    <th>AnaBayi</th>
                                    <th>Tutar</th>
                                    <th>Mesaj</th>
                                    <th>Onay</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders ?? [] as $order)
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
                                    <td>{{ $order->id ?? '' }}</td>
                                    <td>{{ $order->order_number ?? '' }}</td>
                                    <td>
                                        <span class="badge bg-danger">İptal</span>
                                    </td>
                                    <td>{{ $order->payment_method ?? '' }}</td>
                                    <td>{{ $order->created_at ? $order->created_at->format('Y-m-d') : '' }}</td>
                                    <td>{{ $order->created_at ? $order->created_at->format('H:i:s') : '' }}</td>
                                    <td>{{ $order->company_title ?? '' }}</td>
                                    <td>{{ $order->dealer_type ?? '' }}</td>
                                    <td>{{ $order->main_dealer ?? '' }}</td>
                                    <td>{{ number_format($order->total ?? 0, 2) }} TL</td>
                                    <td>
                                        <button class="btn btn-sm btn-info">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" disabled>
                                            <i class="fas fa-times"></i> İptal
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="14" class="text-center">Veri Bulunamadı</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            Gösteriliyor {{ $orders->firstItem() ?? 0 }} ile {{ $orders->lastItem() ?? 0 }} arası {{ $orders->total() ?? 0 }} kayıttan
                        </div>
                        <div>
                            {{ $orders->links() }}
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
        
        window.location.href = `/orders/cancelled?start_date=${startDate}&end_date=${endDate}&search=${searchQuery}`;
    });

    // Excel export butonu tıklama
    $('#exportExcel').click(function() {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        const searchQuery = $('#searchQuery').val();
        
        window.location.href = `/orders/cancelled/export?start_date=${startDate}&end_date=${endDate}&search=${searchQuery}`;
    });
});
</script>
@endpush 