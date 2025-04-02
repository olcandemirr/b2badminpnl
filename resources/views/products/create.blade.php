@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Yeni Ürün Ekle</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- Sol Kolon -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_passive" id="is_passive">
                                        <label class="form-check-label" for="is_passive">Pasif</label>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_closed" id="is_closed">
                                        <label class="form-check-label" for="is_closed">Siparişe Kapalı</label>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_out_of_stock" id="is_out_of_stock">
                                        <label class="form-check-label" for="is_out_of_stock">Stoksuz</label>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="type">Tür <span class="text-danger">*</span></label>
                                    <select class="form-select" name="type" id="type" required>
                                        <option value="">Seçiniz</option>
                                        <option value="Elektronik">Elektronik</option>
                                        <option value="Giyim">Giyim</option>
                                        <option value="Ev">Ev</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="category">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select" name="category" id="category" required>
                                        <option value="">Seçiniz</option>
                                        <option value="Telefon">Telefon</option>
                                        <option value="Bilgisayar">Bilgisayar</option>
                                        <option value="Tablet">Tablet</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="brand">Marka</label>
                                    <select class="form-select" name="brand" id="brand">
                                        <option value="">Seçiniz</option>
                                        <option value="Apple">Apple</option>
                                        <option value="Samsung">Samsung</option>
                                        <option value="Xiaomi">Xiaomi</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="product_code">Ürün Kodu</label>
                                    <input type="text" class="form-control" name="product_code" id="product_code">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="name">Ürün Adı</label>
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="name_en">Ürün Adı (EN)</label>
                                    <input type="text" class="form-control" name="name_en" id="name_en">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="unit">Birim</label>
                                    <select class="form-select" name="unit" id="unit">
                                        <option value="">Seçiniz</option>
                                        <option value="adet">Adet</option>
                                        <option value="kg">KG</option>
                                        <option value="lt">LT</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="vat_rate">KDV Oranı</label>
                                    <select class="form-select" name="vat_rate" id="vat_rate">
                                        <option value="">Seçiniz</option>
                                        <option value="0">%0</option>
                                        <option value="1">%1</option>
                                        <option value="8">%8</option>
                                        <option value="18">%18</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="box_content">Koli İçeriği</label>
                                    <input type="text" class="form-control" name="box_content" id="box_content">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="order">Sıra</label>
                                    <input type="number" class="form-control" name="order" id="order">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="desi">Desi</label>
                                    <input type="number" step="0.01" class="form-control" name="desi" id="desi">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="points">Puan</label>
                                    <input type="number" class="form-control" name="points" id="points">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="barcode">Barkod</label>
                                    <input type="text" class="form-control" name="barcode" id="barcode">
                                </div>
                            </div>

                            <!-- Sağ Kolon -->
                            <div class="col-md-6">
                                <!-- Fiyat Alanları -->
                                <div class="price-group mb-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <label for="price1">Fiyat 1</label>
                                            <input type="number" step="0.01" class="form-control" name="price1" id="price1">
                                        </div>
                                        <div class="col-4">
                                            <label for="currency1">Para Birimi</label>
                                            <select class="form-select" name="currency1" id="currency1">
                                                <option value="TRY">TL</option>
                                                <option value="USD">USD</option>
                                                <option value="EUR">EUR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Diğer fiyat alanları için aynı yapıyı tekrarlayın -->
                                @for($i = 2; $i <= 5; $i++)
                                <div class="price-group mb-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <label for="price{{$i}}">Fiyat {{$i}}</label>
                                            <input type="number" step="0.01" class="form-control" name="price{{$i}}" id="price{{$i}}">
                                        </div>
                                        <div class="col-4">
                                            <label for="currency{{$i}}">Para Birimi</label>
                                            <select class="form-select" name="currency{{$i}}" id="currency{{$i}}">
                                                <option value="TRY">TL</option>
                                                <option value="USD">USD</option>
                                                <option value="EUR">EUR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @endfor

                                <div class="price-group mb-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <label for="discounted_price">İndirimli Fiyat</label>
                                            <input type="number" step="0.01" class="form-control" name="discounted_price" id="discounted_price">
                                        </div>
                                        <div class="col-4">
                                            <label for="discounted_currency">Para Birimi</label>
                                            <select class="form-select" name="discounted_currency" id="discounted_currency">
                                                <option value="TRY">TL</option>
                                                <option value="USD">USD</option>
                                                <option value="EUR">EUR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="cost">Maliyet</label>
                                    <input type="number" step="0.01" class="form-control" name="cost" id="cost">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="discount_rate">İndirim Oranı</label>
                                    <input type="number" step="0.01" class="form-control" name="discount_rate" id="discount_rate">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="additional_discount">+İskonto</label>
                                    <input type="number" step="0.01" class="form-control" name="additional_discount" id="additional_discount">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="discount_group_code">İskonto Grup Kodu</label>
                                    <input type="text" class="form-control" name="discount_group_code" id="discount_group_code">
                                </div>

                                <!-- Konum -->
                                <div class="form-group mb-3">
                                    <label>Konum</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_showcase" id="is_showcase">
                                        <label class="form-check-label" for="is_showcase">Vitrin</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_bestseller" id="is_bestseller">
                                        <label class="form-check-label" for="is_bestseller">Çok Satan</label>
                                    </div>
                                </div>

                                <!-- Özellikler -->
                                <div class="form-group mb-3">
                                    <label>Özellikler</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_campaign" id="is_campaign">
                                        <label class="form-check-label" for="is_campaign">Kampanya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="has_gift" id="has_gift">
                                        <label class="form-check-label" for="has_gift">Hediye Kampanya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_new" id="is_new">
                                        <label class="form-check-label" for="is_new">Yeni</label>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="min_order">Minimum Sipariş</label>
                                    <input type="number" class="form-control" name="min_order" id="min_order">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="increment">Artış Adet</label>
                                    <input type="number" class="form-control" name="increment" id="increment">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="max_order">Maximum Sipariş</label>
                                    <input type="number" class="form-control" name="max_order" id="max_order">
                                </div>

                                <!-- İndirim Sayaç -->
                                <div class="form-group mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="has_counter" id="has_counter">
                                        <label class="form-check-label" for="has_counter">İndirim Sayaç</label>
                                    </div>
                                    <div class="mt-2" id="counter_date_group" style="display: none;">
                                        <label for="counter_date">Sayaç Tarihi</label>
                                        <input type="datetime-local" class="form-control" name="counter_date" id="counter_date">
                                    </div>
                                </div>

                                <!-- İndirim Stok -->
                                <div class="form-group mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="has_discount_stock" id="has_discount_stock">
                                        <label class="form-check-label" for="has_discount_stock">İndirim Stok</label>
                                    </div>
                                    <div class="mt-2" id="discount_stock_date_group" style="display: none;">
                                        <label for="discount_stock_date">İndirim Stok Tarihi</label>
                                        <input type="datetime-local" class="form-control" name="discount_stock_date" id="discount_stock_date">
                                    </div>
                                </div>

                                <!-- Depo Stokları -->
                                <div class="form-group mb-3">
                                    <label for="warehouse1_stock">Depo 1 Stok</label>
                                    <input type="number" class="form-control" name="warehouse1_stock" id="warehouse1_stock">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="warehouse2_stock">Depo 2 Stok</label>
                                    <input type="number" class="form-control" name="warehouse2_stock" id="warehouse2_stock">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="warehouse3_stock">Depo 3 Stok</label>
                                    <input type="number" class="form-control" name="warehouse3_stock" id="warehouse3_stock">
                                </div>

                                <!-- Fotoğraf -->
                                <div class="form-group mb-3">
                                    <label for="photo">Fotoğraf</label>
                                    <input type="file" class="form-control" name="photo" id="photo" accept="image/*">
                                </div>

                                <!-- Açıklamalar -->
                                <div class="form-group mb-3">
                                    <label for="description">Ürün Açıklaması</label>
                                    <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description_en">Ürün Açıklaması (EN)</label>
                                    <textarea class="form-control" name="description_en" id="description_en" rows="3"></textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="search_tags">Arama Etiketleri</label>
                                    <input type="text" class="form-control" name="search_tags" id="search_tags" placeholder="Etiketleri virgülle ayırın">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Ürün Ekle</button>
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">İptal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // İndirim Sayaç kontrolü
    const hasCounter = document.getElementById('has_counter');
    const counterDateGroup = document.getElementById('counter_date_group');
    
    hasCounter.addEventListener('change', function() {
        counterDateGroup.style.display = this.checked ? 'block' : 'none';
    });

    // İndirim Stok kontrolü
    const hasDiscountStock = document.getElementById('has_discount_stock');
    const discountStockDateGroup = document.getElementById('discount_stock_date_group');
    
    hasDiscountStock.addEventListener('change', function() {
        discountStockDateGroup.style.display = this.checked ? 'block' : 'none';
    });
});
</script>
@endpush
@endsection 