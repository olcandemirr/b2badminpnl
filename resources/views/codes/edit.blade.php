@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('codes.index') }}">Kod Listesi</a></li>
                    <li class="breadcrumb-item active">Kod Düzenle</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kod Düzenle: {{ $code->code }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('codes.update', $code->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Kod Bilgileri -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">KOD BİLGİLERİ</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code', $code->code) }}" placeholder="Kod">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select @error('type') is-invalid @enderror" name="type">
                                        <option value="">Kod Tipi Seçiniz</option>
                                        <option value="genel" {{ old('type', $code->type) == 'genel' ? 'selected' : '' }}>Genel</option>
                                        <option value="ozel" {{ old('type', $code->type) == 'ozel' ? 'selected' : '' }}>Özel</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description', $code->description) }}" placeholder="Açıklama">
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" {{ old('is_active', $code->is_active) ? 'checked' : '' }}>
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
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date', $code->start_date ? $code->start_date->format('Y-m-d') : '') }}" placeholder="Başlangıç Tarihi">
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date', $code->end_date ? $code->end_date->format('Y-m-d') : '') }}" placeholder="Bitiş Tarihi">
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control @error('usage_limit') is-invalid @enderror" name="usage_limit" value="{{ old('usage_limit', $code->usage_limit) }}" placeholder="Kullanım Limiti">
                                    @error('usage_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control @error('min_order_amount') is-invalid @enderror" name="min_order_amount" value="{{ old('min_order_amount', $code->min_order_amount) }}" placeholder="Minimum Sipariş Tutarı" step="0.01">
                                    @error('min_order_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Kullanım Bilgileri -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">KULLANIM BİLGİLERİ</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="alert alert-info">
                                        <strong>Kullanım Sayısı:</strong> {{ $code->usage_count }} kez
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                        </div>

                        <!-- İndirim Bilgileri -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">İNDİRİM BİLGİLERİ</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <select class="form-select @error('discount_type') is-invalid @enderror" name="discount_type">
                                        <option value="">İndirim Tipi Seçiniz</option>
                                        <option value="percentage" {{ old('discount_type', $code->discount_type) == 'percentage' ? 'selected' : '' }}>Yüzde</option>
                                        <option value="fixed" {{ old('discount_type', $code->discount_type) == 'fixed' ? 'selected' : '' }}>Sabit Tutar</option>
                                    </select>
                                    @error('discount_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control @error('discount_amount') is-invalid @enderror" name="discount_amount" value="{{ old('discount_amount', $code->discount_amount) }}" placeholder="İndirim Miktarı" step="0.01">
                                    @error('discount_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                                <select class="form-select @error('category_id') is-invalid @enderror" name="category_id">
                                                    <option value="">Kategori Seçiniz</option>
                                                    @foreach($categories as $id => $name)
                                                        <option value="{{ $id }}" {{ old('category_id', $code->category_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <select class="form-select @error('product_id') is-invalid @enderror" name="product_id">
                                                    <option value="">Ürün Seçiniz</option>
                                                    @foreach($products as $id => $name)
                                                        <option value="{{ $id }}" {{ old('product_id', $code->product_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('product_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <select class="form-select @error('dealer_id') is-invalid @enderror" name="dealer_id">
                                                    <option value="">Bayi Seçiniz</option>
                                                    @foreach($dealers as $id => $name)
                                                        <option value="{{ $id }}" {{ old('dealer_id', $code->dealer_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('dealer_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city', $code->city) }}" placeholder="Şehir">
                                                @error('city')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text" class="form-control @error('region') is-invalid @enderror" name="region" value="{{ old('region', $code->region) }}" placeholder="Bölge">
                                                @error('region')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Kodu Güncelle
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