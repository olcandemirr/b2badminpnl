@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ request('super_dealer') ? 'Super Dealer Ekle' : 'Bayi Ekle' }}</h3>
                </div>
                <div class="card-body">
                    <!-- Uyarılar -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('dealers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Bayi Tipi -->
                        <div class="section-title">BAYİ TİPİ</div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="dealer_type" id="anaBayi" value="Ana Bayi" checked>
                                    <label class="form-check-label" for="anaBayi">Ana Bayi</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="dealer_type" id="altBayi" value="Alt Bayi">
                                    <label class="form-check-label" for="altBayi">Alt Bayi</label>
                                </div>
                                @if (!empty($mainDealers))
                                <div class="mt-2" id="mainDealerSelect" style="display: none;">
                                    <label>Ana Bayi Seçin:</label>
                                    <select name="main_dealer" class="form-select">
                                        <option value="">Seçiniz</option>
                                        @foreach($mainDealers as $id => $title)
                                            <option value="{{ $id }}">{{ $title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_super_dealer" id="isSuperDealer" {{ request('super_dealer') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isSuperDealer">Super Dealer</label>
                                    <small class="form-text text-muted d-block">Super Dealer ekstra yetkilere sahip olacaktır.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Giriş Bilgileri -->
                        <div class="section-title">GİRİŞ BİLGİLERİ</div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label>Kullanıcı Adı</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" name="username" value="{{ old('username') }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Şifre</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>E-Mail</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label>Program Kodu</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-code"></i></span>
                                    <input type="text" class="form-control" name="program_code" value="{{ old('program_code') }}">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label>Kullanıcı Aktif</label>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" checked>
                                </div>
                            </div>
                        </div>

                        <!-- Genel Bilgiler -->
                        <div class="section-title">GENEL BİLGİLER</div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label>Ad</label>
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label>Soyad</label>
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label>Ünvan</label>
                                <input type="text" class="form-control" name="company_title" value="{{ old('company_title') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label>Ülke</label>
                                <input type="text" class="form-control" name="country" value="{{ old('country', 'Türkiye') }}">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label>İl</label>
                                <input type="text" class="form-control" name="city" value="{{ old('city') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label>İlçe</label>
                                <input type="text" class="form-control" name="district" value="{{ old('district') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label>Posta Kodu</label>
                                <input type="text" class="form-control" name="postal_code" value="{{ old('postal_code') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Adres Adı</label>
                                <input type="text" class="form-control" name="address_title" value="{{ old('address_title') }}">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label>Adres</label>
                                <textarea class="form-control" name="address" rows="3" required>{{ old('address') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label>Adres Tarifi</label>
                                <textarea class="form-control" name="address_description" rows="3">{{ old('address_description') }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label>Tel</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label>Vergi Dairesi</label>
                                <input type="text" class="form-control" name="tax_office" value="{{ old('tax_office') }}">
                            </div>
                            <div class="col-md-4">
                                <label>Vergi No</label>
                                <input type="text" class="form-control" name="tax_number" value="{{ old('tax_number') }}">
                            </div>
                        </div>

                        <!-- Evraklar -->
                        <div class="section-title">EVRAKLAR</div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label>Vergi Levhası (PDF veya JPG Formatında)</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="tax_document">
                                    <div class="form-check ms-2 mt-2">
                                        <input class="form-check-input" type="checkbox" name="tax_document_required">
                                        <label class="form-check-label">Zorunlu Yap</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>İmza Sirküleri (PDF veya JPG Formatında)</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="signature_circular">
                                    <div class="form-check ms-2 mt-2">
                                        <input class="form-check-input" type="checkbox" name="signature_circular_required">
                                        <label class="form-check-label">Zorunlu Yap</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label>Ticari Sicil Gazetesi (PDF veya JPG Formatında)</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="trade_registry">
                                    <div class="form-check ms-2 mt-2">
                                        <input class="form-check-input" type="checkbox" name="trade_registry_required">
                                        <label class="form-check-label">Zorunlu Yap</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Findex Risk Raporu (PDF veya JPG Formatında)</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="findeks_report">
                                    <div class="form-check ms-2 mt-2">
                                        <input class="form-check-input" type="checkbox" name="findeks_report_required">
                                        <label class="form-check-label">Zorunlu Yap</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ödeme Sistemi -->
                        <div class="section-title">ÖDEME SİSTEMİ</div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label>Bakiye</label>
                                <input type="number" class="form-control" name="balance" step="0.01" value="{{ old('balance', 0) }}">
                            </div>
                            <div class="col-md-4">
                                <label>Sipariş Limiti</label>
                                <input type="number" class="form-control" name="order_limit" step="0.01" value="{{ old('order_limit', 0) }}">
                            </div>
                            <div class="col-md-4">
                                <label>Yıllık Hedef</label>
                                <input type="number" class="form-control" name="yearly_target" step="0.01" value="{{ old('yearly_target', 0) }}">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="has_debt_order_block" {{ old('has_debt_order_block') ? 'checked' : '' }}>
                                    <label class="form-check-label">Borçlu Sipariş Kapalı</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="has_free_payment" {{ old('has_free_payment') ? 'checked' : '' }}>
                                    <label class="form-check-label">Serbest Ödeme</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cash_only" {{ old('cash_only') ? 'checked' : '' }}>
                                    <label class="form-check-label">Sadece Cari Ödeme</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="card_payment" {{ old('card_payment') ? 'checked' : '' }}>
                                    <label class="form-check-label">Kartla Öde</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="check_payment" {{ old('check_payment') ? 'checked' : '' }}>
                                    <label class="form-check-label">Çek ile Öde</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cash_payment" {{ old('cash_payment') ? 'checked' : '' }}>
                                    <label class="form-check-label">Cari Öde</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pay_at_door" {{ old('pay_at_door') ? 'checked' : '' }}>
                                    <label class="form-check-label">Kapıda Öde</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="include_vat" {{ old('include_vat') ? 'checked' : '' }}>
                                    <label class="form-check-label">KDV Dahil</label>
                                </div>
                            </div>
                        </div>

                        <!-- Diğer Özellikler -->
                        <div class="row mb-4">
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="campaign_news" {{ old('campaign_news') ? 'checked' : '' }}>
                                    <label class="form-check-label">Kampanya Haber</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="contract" {{ old('contract') ? 'checked' : '' }}>
                                    <label class="form-check-label">Sözleşme</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="kvkk" {{ old('kvkk') ? 'checked' : '' }}>
                                    <label class="form-check-label">KVKK</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="separate_warehouse" {{ old('separate_warehouse') ? 'checked' : '' }}>
                                    <label class="form-check-label">Ayrı Depo</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gift_passive" {{ old('gift_passive') ? 'checked' : '' }}>
                                    <label class="form-check-label">Hediye Pasif</label>
                                </div>
                            </div>
                        </div>

                        <!-- Temsilci Bilgileri -->
                        <div class="section-title">TEMSİLCİ BİLGİLERİ</div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label>Temsilci Seçin</label>
                                <select class="form-select" name="representative">
                                    <option value="">Seçiniz</option>
                                    <!-- Temsilciler buraya gelecek -->
                                </select>
                            </div>
                        </div>

                        <!-- Dil Bilgileri -->
                        <div class="section-title">DİL BİLGİLERİ</div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label>Dil Seçin</label>
                                <select class="form-select" name="language">
                                    <option value="Türkçe" {{ old('language') == 'Türkçe' ? 'selected' : '' }}>Türkçe</option>
                                    <option value="English" {{ old('language') == 'English' ? 'selected' : '' }}>English</option>
                                </select>
                            </div>
                        </div>

                        <!-- Fiyat Bilgileri -->
                        <div class="section-title">FİYAT BİLGİLERİ</div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label>Para Birimi</label>
                                <select class="form-select" name="currency" required>
                                    <option value="">Seçiniz</option>
                                    <option value="TRY" {{ old('currency') == 'TRY' ? 'selected' : '' }}>TL</option>
                                    <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                    <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Fiyat Tipi</label>
                                <select class="form-select" name="price_type" required>
                                    <option value="">Seçiniz</option>
                                    <option value="perakende" {{ old('price_type') == 'perakende' ? 'selected' : '' }}>Perakende</option>
                                    <option value="toptan" {{ old('price_type') == 'toptan' ? 'selected' : '' }}>Toptan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Genel İskonto</label>
                                <input type="number" class="form-control" name="general_discount" step="0.01" value="{{ old('general_discount', 0) }}" min="0" max="100">
                            </div>
                            <div class="col-md-3">
                                <label>+ İskonto</label>
                                <input type="number" class="form-control" name="additional_discount" step="0.01" value="{{ old('additional_discount', 0) }}" min="0" max="100">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label>++ İskonto</label>
                                <input type="number" class="form-control" name="extra_discount" step="0.01" value="{{ old('extra_discount', 0) }}" min="0" max="100">
                            </div>
                            <div class="col-md-3">
                                <label>İskonto Profili</label>
                                <select class="form-select" name="discount_profile">
                                    <option value="">Seçiniz</option>
                                    <!-- İskonto profilleri buraya gelecek -->
                                </select>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Bayiyi Kaydet</button>
                            <a href="{{ route('dealers.index') }}" class="btn btn-secondary ms-2">İptal</a>
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
.section-title {
    font-size: 1.1rem;
    font-weight: bold;
    margin: 1.5rem 0 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #dee2e6;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Ana Bayi / Alt Bayi seçimi değiştiğinde
    $('input[name="dealer_type"]').change(function() {
        if ($(this).val() === 'Alt Bayi') {
            $('#mainDealerSelect').show();
        } else {
            $('#mainDealerSelect').hide();
        }
    });
    
    // Super Dealer seçildiğinde Ana/Alt Bayi seçimini güncelle
    $('#isSuperDealer').change(function() {
        if ($(this).is(':checked')) {
            $('#anaBayi').prop('checked', true);
            $('#mainDealerSelect').hide();
        }
    });
    
    // Sayfa yüklendiğinde Alt Bayi seçili ise ana bayi seçim alanını göster
    if ($('#altBayi').is(':checked')) {
        $('#mainDealerSelect').show();
    } else {
        $('#mainDealerSelect').hide();
    }
});
</script>
@endpush 