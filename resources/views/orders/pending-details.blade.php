@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bekleyen Siparişler Detay</h3>
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

                    <!-- Siparişler Detay Tablosu -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Det</th>
                                    <th>Yaz</th>
                                    <th>ID</th>
                                    <th>SipNo</th>
                                    <th>Tarih</th>
                                    <th>Ünvan</th>
                                    <th>AdSoyad</th>
                                    <th>Durum</th>
                                    <th>ÜrünKodu</th>
                                    <th>Ürün</th>
                                    <th>Adet</th>
                                    <th>Fiyat</th>
                                    <th>Tutar</th>
                                    <th>İskonto</th>
                                    <th>Nettutar</th>
                                    <th>SiparisTutar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderDetails ?? [] as $detail)
                                <tr>
                                    <td>
                                        <span class="badge bg-warning">Delay</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-secondary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </td>
                                    <td>{{ $detail->id ?? '' }}</td>
                                    <td>{{ $detail->order->order_number ?? '' }}</td>
                                    <td>{{ $detail->created_at ? $detail->created_at->format('Y-m-d') : '' }}</td>
                                    <td>{{ $detail->order->company_title ?? '' }}</td>
                                    <td>{{ $detail->order->customer_name ?? '' }}</td>
                                    <td>{{ $detail->status ?? '' }}</td>
                                    <td>{{ $detail->product_code ?? '' }}</td>
                                    <td>{{ $detail->product_name ?? '' }}</td>
                                    <td>{{ $detail->quantity ?? '' }}</td>
                                    <td>{{ number_format($detail->price ?? 0, 2) }} TL</td>
                                    <td>{{ number_format($detail->total ?? 0, 2) }} TL</td>
                                    <td>{{ number_format($detail->discount ?? 0, 2) }} TL</td>
                                    <td>{{ number_format($detail->net_total ?? 0, 2) }} TL</td>
                                    <td>{{ number_format($detail->order->total ?? 0, 2) }} TL</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            Gösteriliyor {{ $orderDetails->firstItem() ?? 0 }} ile {{ $orderDetails->lastItem() ?? 0 }} arası {{ $orderDetails->total() ?? 0 }} toplam
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
        
        window.location.href = `/orders/pending/details/export?start_date=${startDate}&end_date=${endDate}&search=${searchQuery}`;
    });
});
</script>
@endpush 