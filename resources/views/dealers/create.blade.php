@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bayi Ekle</h3>
                </div>
                <div class="card-body">
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
                            </div>
                        </div>

                        <!-- Giriş Bilgileri -->
                        <div class="section-title">GİRİŞ BİLGİLERİ</div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label>Kullanıcı Adı</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" name="username" required>
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
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label>Program Kodu</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-code"></i></span>
                                    <input type="text" class="form-control" name="program_code">
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
                                <input type="text" class="form-control" name="first_name" required>
                            </div>
                            <div class="col-md-3">
                                <label>Soyad</label>
                                <input type="text" class="form-control" name="last_name" required>
                            </div>
                            <div class="col-md-3">
                                <label>Ünvan</label>
                                <input type="text" class="form-control" name="company_title" required>
                            </div>
                            <div class="col-md-3">
                                <label>Ülke</label>
                                <input type="text" class="form-control" name="country" value="Türkiye">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label>İl</label>
                                <input type="text" class="form-control" name="city" required>
                            </div>
                            <div class="col-md-3">
                                <label>İlçe</label>
                                <input type="text" class="form-control" name="district" required>
                            </div>
                            <div class="col-md-3">
                                <label>Posta Kodu</label>
                                <input type="text" class="form-control" name="postal_code">
                            </div>
                            <div class="col-md-3">
                                <label>Adres Adı</label>
                                <input type="text" class="form-control" name="address_title">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label>Adres</label>
                                <textarea class="form-control" name="address" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label>Adres Tarifi</label>
                                <textarea class="form-control" name="address_description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label>Tel</label>
                                <input type="text" class="form-control" name="phone" required>
                            </div>
                            <div class="col-md-4">
                                <label>Vergi Dairesi</label>
                                <input type="text" class="form-control" name="tax_office">
                            </div>
                            <div class="col-md-4">
                                <label>Vergi No</label>
                                <input type="text" class="form-control" name="tax_number">
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
                                <input type="number" class="form-control" name="balance" step="0.01">
                            </div>
                            <div class="col-md-4">
                                <label>Sipariş Limiti</label>
                                <input type="number" class="form-control" name="order_limit" step="0.01">
                            </div>
                            <div class="col-md-4">
                                <label>Yıllık Hedef</label>
                                <input type="number" class="form-control" name="yearly_target" step="0.01">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="has_debt_order_block">
                                    <label class="form-check-label">Borçlu Sipariş Kapalı</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="has_free_payment">
                                    <label class="form-check-label">Serbest Ödeme</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cash_only">
                                    <label class="form-check-label">Sadece Cari Ödeme</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="card_payment">
                                    <label class="form-check-label">Kartla Öde</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="check_payment">
                                    <label class="form-check-label">Çek ile Öde</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cash_payment">
                                    <label class="form-check-label">Cari Öde</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pay_at_door">
                                    <label class="form-check-label">Kapıda Öde</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="include_vat">
                                    <label class="form-check-label">KDV Dahil</label>
                                </div>
                            </div>
                        </div>

                        <!-- Diğer Özellikler -->
                        <div class="row mb-4">
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="campaign_news">
                                    <label class="form-check-label">Kampanya Haber</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="contract">
                                    <label class="form-check-label">Sözleşme</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="kvkk">
                                    <label class="form-check-label">KVKK</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="separate_warehouse">
                                    <label class="form-check-label">Ayrı Depo</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gift_passive">
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
                                    <option value="Türkçe">Türkçe</option>
                                    <option value="English">English</option>
                                </select>
                            </div>
                        </div>

                        <!-- Fiyat Bilgileri -->
                        <div class="section-title">FİYAT BİLGİLERİ</div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label>Para Birimi</label>
                                <select class="form-select" name="currency">
                                    <option value="">Seçiniz</option>
                                    <option value="TRY">TL</option>
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Fiyat Tipi</label>
                                <select class="form-select" name="price_type">
                                    <option value="">Seçiniz</option>
                                    <option value="perakende">Perakende</option>
                                    <option value="toptan">Toptan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Genel İskonto</label>
                                <input type="number" class="form-control" name="general_discount" step="0.01">
                            </div>
                            <div class="col-md-3">
                                <label>+ İskonto</label>
                                <input type="number" class="form-control" name="additional_discount" step="0.01">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label>++ İskonto</label>
                                <input type="number" class="form-control" name="extra_discount" step="0.01">
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
            // Ana bayi seçim alanını göster
        } else {
            // Ana bayi seçim alanını gizle
        }
    });
});
</script>
@endpush 