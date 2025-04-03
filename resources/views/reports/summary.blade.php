@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Rapor Özet</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Sipariş Raporları -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">{{ $summaryData['siparis']['baslik'] }}</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover">
                                        <tbody>
                                            @foreach($summaryData['siparis']['items'] as $item)
                                                <tr>
                                                    <td>{{ $item['name'] }}</td>
                                                    <td class="text-end">{{ $item['value'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Bayi Raporları -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">{{ $summaryData['bayi']['baslik'] }}</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover">
                                        <tbody>
                                            @foreach($summaryData['bayi']['items'] as $item)
                                                <tr>
                                                    <td>{{ $item['name'] }}</td>
                                                    <td class="text-end">{{ $item['value'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Ürün Raporları -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h5 class="card-title mb-0">{{ $summaryData['urun']['baslik'] }}</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover">
                                        <tbody>
                                            @foreach($summaryData['urun']['items'] as $item)
                                                <tr>
                                                    <td>{{ $item['name'] }}</td>
                                                    <td class="text-end">{{ $item['value'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.card-title {
    margin-bottom: 0;
    font-size: 1.1rem;
    font-weight: 600;
}

.table td {
    padding: 0.75rem;
    vertical-align: middle;
}

.table tr:last-child td {
    border-bottom: none;
}

.bg-primary {
    background-color: #0d6efd !important;
}

.bg-success {
    background-color: #198754 !important;
}

.bg-info {
    background-color: #0dcaf0 !important;
}

.text-end {
    text-align: right !important;
}
</style>
@endpush 