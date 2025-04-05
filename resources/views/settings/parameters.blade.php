@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Parametreler</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.parameters.update') }}" method="POST">
                        @csrf
                        
                        <!-- Parametreler -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <p class="text-muted mb-3">
                                    Sistemde kullanılan değişkenleri ayarlayabilirsiniz. Bu parametreler çeşitli raporlar ve hesaplamalar için kullanılır.
                                </p>
                            </div>
                            
                            <!-- Sipariş Parametreleri -->
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title mb-0">Sipariş Parametreleri</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Minimum Sipariş Miktarı</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="min_order_quantity" value="{{ $parameters['min_order_quantity'] ?? 1 }}">
                                                <span class="input-group-text">adet</span>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Maksimum Sipariş Miktarı</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="max_order_quantity" value="{{ $parameters['max_order_quantity'] ?? 1000 }}">
                                                <span class="input-group-text">adet</span>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Artış Miktarı</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="order_increment" value="{{ $parameters['order_increment'] ?? 1 }}">
                                                <span class="input-group-text">adet</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Kargo Parametreleri -->
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title mb-0">Kargo Parametreleri</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Varsayılan Kargo Firması</label>
                                            <select class="form-select" name="default_shipping_company">
                                                <option value="yurtici" {{ ($parameters['default_shipping_company'] ?? '') == 'yurtici' ? 'selected' : '' }}>Yurtiçi Kargo</option>
                                                <option value="aras" {{ ($parameters['default_shipping_company'] ?? '') == 'aras' ? 'selected' : '' }}>Aras Kargo</option>
                                                <option value="mng" {{ ($parameters['default_shipping_company'] ?? '') == 'mng' ? 'selected' : '' }}>MNG Kargo</option>
                                                <option value="ptt" {{ ($parameters['default_shipping_company'] ?? '') == 'ptt' ? 'selected' : '' }}>PTT Kargo</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Kargo Takip URL</label>
                                            <input type="text" class="form-control" name="shipping_tracking_url" value="{{ $parameters['shipping_tracking_url'] ?? '' }}">
                                            <small class="form-text text-muted">Kargo takip URL'inde {tracking_code} ifadesi yerine takip kodu yerleştirilecektir.</small>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="show_shipping_tracking" id="showShippingTracking" {{ $parameters['show_shipping_tracking'] ?? false ? 'checked' : '' }}>
                                                <label class="form-check-label" for="showShippingTracking">Kargo Takip Göster</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Para Birimi Parametreleri -->
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title mb-0">Para Birimi Parametreleri</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Varsayılan Para Birimi</label>
                                            <select class="form-select" name="default_currency">
                                                <option value="TL" {{ ($parameters['default_currency'] ?? '') == 'TL' ? 'selected' : '' }}>Türk Lirası (TL)</option>
                                                <option value="USD" {{ ($parameters['default_currency'] ?? '') == 'USD' ? 'selected' : '' }}>ABD Doları (USD)</option>
                                                <option value="EUR" {{ ($parameters['default_currency'] ?? '') == 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">USD Kuru</label>
                                            <div class="input-group">
                                                <span class="input-group-text">₺</span>
                                                <input type="number" class="form-control" name="usd_exchange_rate" value="{{ $parameters['usd_exchange_rate'] ?? '30.75' }}" step="0.01">
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">EUR Kuru</label>
                                            <div class="input-group">
                                                <span class="input-group-text">₺</span>
                                                <input type="number" class="form-control" name="eur_exchange_rate" value="{{ $parameters['eur_exchange_rate'] ?? '33.50' }}" step="0.01">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Sistem Parametreleri -->
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title mb-0">Sistem Parametreleri</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Sayfa Başına Kayıt Sayısı</label>
                                            <select class="form-select" name="records_per_page">
                                                <option value="10" {{ ($parameters['records_per_page'] ?? '') == '10' ? 'selected' : '' }}>10</option>
                                                <option value="25" {{ ($parameters['records_per_page'] ?? '') == '25' ? 'selected' : '' }}>25</option>
                                                <option value="50" {{ ($parameters['records_per_page'] ?? '') == '50' ? 'selected' : '' }}>50</option>
                                                <option value="100" {{ ($parameters['records_per_page'] ?? '') == '100' ? 'selected' : '' }}>100</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Tarih Formatı</label>
                                            <select class="form-select" name="date_format">
                                                <option value="d.m.Y" {{ ($parameters['date_format'] ?? '') == 'd.m.Y' ? 'selected' : '' }}>31.12.2023</option>
                                                <option value="d/m/Y" {{ ($parameters['date_format'] ?? '') == 'd/m/Y' ? 'selected' : '' }}>31/12/2023</option>
                                                <option value="Y-m-d" {{ ($parameters['date_format'] ?? '') == 'Y-m-d' ? 'selected' : '' }}>2023-12-31</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Zaman Dilimi</label>
                                            <select class="form-select" name="timezone">
                                                <option value="Europe/Istanbul" {{ ($parameters['timezone'] ?? '') == 'Europe/Istanbul' ? 'selected' : '' }}>Europe/Istanbul</option>
                                                <option value="UTC" {{ ($parameters['timezone'] ?? '') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Değişiklikleri Kaydet
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
</style>
@endpush 