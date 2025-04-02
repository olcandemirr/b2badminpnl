@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bekleyen Siparişler</h3>
                </div>
                <div class="card-body">
                    <!-- Tarih ve Arama Filtreleri -->
                    <div class="row mb-4 bg-dark text-white p-3 rounded">
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="startDate" placeholder="Başlangıç Tarihi">
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="endDate" placeholder="Bitiş Tarihi">
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
                        <button class="btn btn-purple" id="exportExcel">
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
                                @foreach($orders ?? [] as $order)
                                <tr>
                                    <td>
                                        <span class="badge bg-warning">Delay</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-secondary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </td>
                                    <td>{{ $order->id ?? '' }}</td>
                                    <td>{{ $order->order_number ?? '' }}</td>
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
                                        <button class="btn btn-sm btn-purple">
                                            <i class="fas fa-check"></i> Onay
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            Gösteriliyor {{ $orders->firstItem() ?? 0 }} ile {{ $orders->lastItem() ?? 0 }} arası {{ $orders->total() ?? 0 }} toplam
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

@push('styles')
<style>
    .btn-purple {
        background-color: #6f42c1;
        color: white;
    }
    .btn-purple:hover {
        background-color: #5a32a3;
        color: white;
    }
    .table th {
        white-space: nowrap;
        background-color: #f8f9fa;
    }
    .pagination {
        margin-bottom: 0;
    }
</style>
@endpush

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
        
        // AJAX isteği yapılacak
    });

    // Excel export butonu tıklama
    $('#exportExcel').click(function() {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        const searchQuery = $('#searchQuery').val();
        
        window.location.href = `/orders/pending/export?start_date=${startDate}&end_date=${endDate}&search=${searchQuery}`;
    });
});
</script>
@endpush 