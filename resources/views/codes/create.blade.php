@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('codes.index') }}">Kod Listesi</a></li>
                    <li class="breadcrumb-item active">Kod Ekle</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kod Ekle</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('codes.store') }}" method="POST">
                        @csrf
                        
                        <!-- Kod Bilgileri -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">KOD BİLGİLERİ</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="code" placeholder="Kod">
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select" name="type">
                                        <option value="">Kod Tipi Seçiniz</option>
                                        <option value="genel">Genel</option>
                                        <option value="ozel">Özel</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="description" placeholder="Açıklama">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked>
                                        <label class="form-check-label" for="isActive">Kod Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Geçerlilik Bilgileri -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">GEÇERLİLİK BİLGİLERİ</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="start_date" placeholder="Başlangıç Tarihi">
                                </div>
                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="end_date" placeholder="Bitiş Tarihi">
                                </div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="usage_limit" placeholder="Kullanım Limiti">
                                </div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="min_order_amount" placeholder="Minimum Sipariş Tutarı">
                                </div>
                            </div>
                        </div>

                        <!-- İndirim Bilgileri -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">İNDİRİM BİLGİLERİ</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <select class="form-select" name="discount_type">
                                        <option value="">İndirim Tipi Seçiniz</option>
                                        <option value="percentage">Yüzde</option>
                                        <option value="fixed">Sabit Tutar</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="discount_amount" placeholder="İndirim Miktarı">
                                </div>
                            </div>
                        </div>

                        <!-- Kullanım Koşulları -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">KULLANIM KOŞULLARI</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Kategori</th>
                                            <th>Ürün</th>
                                            <th>Bayi</th>
                                            <th>Şehir</th>
                                            <th>Bölge</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-select" name="category_id">
                                                    <option value="">Kategori Seçiniz</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select" name="product_id">
                                                    <option value="">Ürün Seçiniz</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select" name="dealer_id">
                                                    <option value="">Bayi Seçiniz</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select" name="city_id">
                                                    <option value="">Şehir Seçiniz</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select" name="region_id">
                                                    <option value="">Bölge Seçiniz</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Kodu Ekle
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

.form-label {
    color: #666;
    margin-bottom: 0.5rem;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    font-size: 0.9rem;
    text-align: center;
}

.table td {
    vertical-align: middle;
    text-align: center;
}

.breadcrumb {
    background-color: transparent;
    padding: 0.5rem 0;
    margin-bottom: 1rem;
}

.breadcrumb-item a {
    color: #0d6efd;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #6c757d;
}
</style>
@endpush 