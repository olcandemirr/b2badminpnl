@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Genel Ayarlar</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.general.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- GENEL BİLGİLER -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">GENEL BİLGİLER</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Logo</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="logo">
                                        <button type="button" class="btn btn-danger" onclick="removeLogo()">Logo Göster</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Logo Zil Renk</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="logo_zil">
                                        <button type="button" class="btn btn-danger" onclick="removeLogoZil()">Logo Göster</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Site Adı</label>
                                    <input type="text" class="form-control" name="site_name">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Site Adı En</label>
                                    <input type="text" class="form-control" name="site_name_en">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Site Açıklaması</label>
                                    <textarea class="form-control" name="site_description" rows="3"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Site Açıklaması En</label>
                                    <textarea class="form-control" name="site_description_en" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- GOOGLE BİLGİLERİ -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">GOOGLE BİLGİLERİ</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Head Head Arası Kod</label>
                                    <textarea class="form-control" name="head_code" rows="3"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Body Body Arası Kod</label>
                                    <textarea class="form-control" name="body_code" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- FİRMA BİLGİLERİ -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">FİRMA BİLGİLERİ</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Firma Adı</label>
                                    <input type="text" class="form-control" name="company_name">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Adres</label>
                                    <input type="text" class="form-control" name="address">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tel</label>
                                    <input type="text" class="form-control" name="phone">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tel1</label>
                                    <input type="text" class="form-control" name="phone1">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">WhatsApp</label>
                                    <input type="text" class="form-control" name="whatsapp">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Web</label>
                                    <input type="text" class="form-control" name="website">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Sistem Mail Adresi</label>
                                    <input type="email" class="form-control" name="system_email">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Diğer Mail Adresleri (virgülle ayırınız)</label>
                                    <input type="text" class="form-control" name="other_emails">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Bayilik Mail Adresi</label>
                                    <input type="email" class="form-control" name="dealer_email">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Altyapı Mail Adresi</label>
                                    <input type="email" class="form-control" name="infrastructure_email">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Mail Server</label>
                                    <input type="text" class="form-control" name="mail_server">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Mail Şifre</label>
                                    <input type="password" class="form-control" name="mail_password">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Port</label>
                                    <input type="text" class="form-control" name="mail_port">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="ssl_enabled" id="sslEnabled">
                                        <label class="form-check-label" for="sslEnabled">SSL</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Facebook Sayfası</label>
                                    <input type="text" class="form-control" name="facebook_page">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Twitter Sayfası</label>
                                    <input type="text" class="form-control" name="twitter_page">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Instagram Sayfası</label>
                                    <input type="text" class="form-control" name="instagram_page">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Linkedin Sayfası</label>
                                    <input type="text" class="form-control" name="linkedin_page">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Sipariş Mail Mesajı</label>
                                    <textarea class="form-control" name="order_mail_message" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- STOK AYARLARI -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">STOK AYARLARI</label>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="kdv_included" id="kdvIncluded">
                                        <label class="form-check-label" for="kdvIncluded">KDV Dahil</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Kdv Oranı</label>
                                    <select class="form-select" name="kdv_rate">
                                        <option value="20">20</option>
                                        <option value="18">18</option>
                                        <option value="10">10</option>
                                        <option value="8">8</option>
                                        <option value="1">1</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="stock_control" id="stockControl">
                                        <label class="form-check-label" for="stockControl">Stok Kontrol</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="show_available" id="showAvailable">
                                        <label class="form-check-label" for="showAvailable">Mevcut Gizle</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="show_all_products" id="showAllProducts">
                                        <label class="form-check-label" for="showAllProducts">Tüm Ürünleri Göster</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="product_photo_preview" id="productPhotoPreview">
                                        <label class="form-check-label" for="productPhotoPreview">Ürün Foto Önizleme</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SİPARİŞ AYARLARI -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">SİPARİŞ AYARLARI</label>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Min Sipariş Tutarı</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="min_order_amount" step="0.01">
                                        <select class="form-select" name="min_order_currency" style="max-width: 80px;">
                                            <option value="TL">TL</option>
                                            <option value="USD">USD</option>
                                            <option value="EUR">EUR</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Ücretsiz Kargo</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="free_shipping_amount" step="0.01">
                                        <select class="form-select" name="free_shipping_currency" style="max-width: 80px;">
                                            <option value="TL">TL</option>
                                            <option value="USD">USD</option>
                                            <option value="EUR">EUR</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Kredi Kartı İndirimi</label>
                                    <input type="number" class="form-control" name="credit_card_discount" value="0">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Havale İndirimi</label>
                                    <input type="number" class="form-control" name="bank_transfer_discount" value="3">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Mail Order İndirimi</label>
                                    <input type="number" class="form-control" name="mail_order_discount" value="1">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Sadece Çek Ödeme</label>
                                    <input type="number" class="form-control" name="check_only_payment" value="0">
                                </div>
                            </div>
                        </div>

                        <!-- Ödeme Seçenekleri -->
                        <div class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="cash_payment" id="cashPayment" checked>
                                        <label class="form-check-label" for="cashPayment">Çoklu Para Birimi ile Öde</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="coupon_system" id="couponSystem" checked>
                                        <label class="form-check-label" for="couponSystem">Kupon Sistemi Aktif</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="shipping_system" id="shippingSystem">
                                        <label class="form-check-label" for="shippingSystem">Kargo Sistemi Aktif</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="shipping_integration" id="shippingIntegration">
                                        <label class="form-check-label" for="shippingIntegration">Kargo Sistemi Desi</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="credit_card_payment" id="creditCardPayment" checked>
                                        <label class="form-check-label" for="creditCardPayment">Kart ile Öde</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="mail_order_payment" id="mailOrderPayment" checked>
                                        <label class="form-check-label" for="mailOrderPayment">Mail Order ile Öde</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="bank_transfer_payment" id="bankTransferPayment" checked>
                                        <label class="form-check-label" for="bankTransferPayment">Havale ile Öde</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="check_payment" id="checkPayment" checked>
                                        <label class="form-check-label" for="checkPayment">Çek ile Öde</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="cash_on_delivery" id="cashOnDelivery" checked>
                                        <label class="form-check-label" for="cashOnDelivery">Kapıda Öde</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="order_delivery_type" id="orderDeliveryType" checked>
                                        <label class="form-check-label" for="orderDeliveryType">Sipariş Teslimat Şekli</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="order_file_upload" id="orderFileUpload" checked>
                                        <label class="form-check-label" for="orderFileUpload">Sipariş Dosya Yükleme</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Diğer Seçenekler -->
                        <div class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="order_project_type" id="orderProjectType">
                                        <label class="form-check-label" for="orderProjectType">Sipariş Proje Tipi</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="discount_approval_passive" id="discountApprovalPassive" checked>
                                        <label class="form-check-label" for="discountApprovalPassive">İskont Onay Pasif</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="payment_approval_active" id="paymentApprovalActive" checked>
                                        <label class="form-check-label" for="paymentApprovalActive">Serbest Ödeme Aktif</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="closed_order_approval" id="closedOrderApproval">
                                        <label class="form-check-label" for="closedOrderApproval">Borçlu Sipariş Kapalı</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="analysis_buttons_passive" id="analysisButtonsPassive">
                                        <label class="form-check-label" for="analysisButtonsPassive">Anasayfa Butonlar Pasif</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="sequential_order_sending" id="sequentialOrderSending" checked>
                                        <label class="form-check-label" for="sequentialOrderSending">Sıramalı Sipariş Gönderimi</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
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

.form-label {
    color: #666;
    margin-bottom: 0.5rem;
}

.form-label.fw-bold {
    color: #333;
    font-size: 1rem;
    margin-bottom: 1rem;
}

.form-check-label {
    color: #666;
}
</style>
@endpush

@push('scripts')
<script>
function removeLogo() {
    alert('Logo silme işlemi başlatılacak');
}

function removeLogoZil() {
    alert('Logo zil silme işlemi başlatılacak');
}
</script>
@endpush 