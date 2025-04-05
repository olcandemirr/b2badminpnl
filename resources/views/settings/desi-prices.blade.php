@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Desi Fiyatları</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.desi-prices.update') }}" method="POST">
                        @csrf
                        
                        <!-- Desi Fiyatlandırma Tablosu -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 80px">Desi</th>
                                        <th>Fiyat (TL)</th>
                                        <th>Açıklama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= 30; $i++)
                                    <tr>
                                        <td class="text-center">{{ $i }}</td>
                                        <td>
                                            <input type="number" class="form-control" name="desi_prices[{{ $i }}]" value="{{ $desiPrices[$i] ?? 0 }}" step="0.01">
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $i }} Desi için kargo fiyatı</span>
                                        </td>
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Değişikleri Kaydet
                            </button>
                        </div>
                    </form>
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
}

.table td, .table th {
    vertical-align: middle;
}

.btn-icon {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Desi fiyat ekleme ve düzenleme işlemleri burada yapılacak
});
</script>
@endpush 