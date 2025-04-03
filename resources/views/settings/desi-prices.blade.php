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
                        
                        <!-- Desi Fiyat Ekle -->
                        <div class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Ülke</label>
                                    <select class="form-select" name="country">
                                        <option value="">Seçiniz</option>
                                        <option value="TR">Türkiye</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Şehir</label>
                                    <select class="form-select" name="city">
                                        <option value="">Seçiniz</option>
                                        <option value="ISTANBUL">İSTANBUL</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Desi veya Adet Baş.</label>
                                    <input type="number" class="form-control" name="desi_start">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Desi veya Adet Bit.</label>
                                    <input type="number" class="form-control" name="desi_end">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Fiyat</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="price" step="0.01">
                                        <select class="form-select" name="currency" style="max-width: 80px;">
                                            <option value="TL">TL</option>
                                            <option value="USD">USD</option>
                                            <option value="EUR">EUR</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i> Ekle
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Desi Fiyat Listesi -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ülke</th>
                                        <th>Şehir</th>
                                        <th>Desi/Adet Baş.</th>
                                        <th>Desi/Adet Bit.</th>
                                        <th>Fiyat</th>
                                        <th>Düz.</th>
                                        <th>Sil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Veriler buraya gelecek -->
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