@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Kullanıcı Listesi</a></li>
                    <li class="breadcrumb-item active">Kullanıcı Ekle</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kullanıcı Ekle</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        
                        <!-- Kullanıcı Tipi -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">KULLANICI TİPİ</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" id="typeYonetici" value="yonetici">
                                    <label class="form-check-label" for="typeYonetici">Yönetici</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" id="typeTemsilci" value="temsilci">
                                    <label class="form-check-label" for="typeTemsilci">Temsilci</label>
                                </div>
                            </div>
                        </div>

                        <!-- Kullanıcı Bilgiler -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">KULLANICI BİLGİLER</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="username" placeholder="Kullanıcı Adı">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="fullname" placeholder="Ad Soyad">
                                </div>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password" placeholder="Şifre">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked>
                                        <label class="form-check-label" for="isActive">Kullanıcı Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- İletişim Bilgileri -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">İLETİŞİM BİLGİLERİ</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" placeholder="E-mail">
                                </div>
                                <div class="col-md-6">
                                    <input type="tel" class="form-control" name="phone" placeholder="Tel">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="gsm" placeholder="Gsm">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="program_id" placeholder="Program ID">
                                </div>
                            </div>
                        </div>

                        <!-- Yetkiler -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">YETKİLER</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Modül</th>
                                            <th>Görüntüleme Yetkisi</th>
                                            <th>Ekleme Yetkisi</th>
                                            <th>Düzenleme Yetkisi</th>
                                            <th>Silme Yetkisi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Kullanıcı Yönetimi</td>
                                            <td><input type="checkbox" name="permissions[user][view]"></td>
                                            <td><input type="checkbox" name="permissions[user][create]"></td>
                                            <td><input type="checkbox" name="permissions[user][edit]"></td>
                                            <td><input type="checkbox" name="permissions[user][delete]"></td>
                                        </tr>
                                        <tr>
                                            <td>Ürün Yönetimi</td>
                                            <td><input type="checkbox" name="permissions[product][view]"></td>
                                            <td><input type="checkbox" name="permissions[product][create]"></td>
                                            <td><input type="checkbox" name="permissions[product][edit]"></td>
                                            <td><input type="checkbox" name="permissions[product][delete]"></td>
                                        </tr>
                                        <tr>
                                            <td>Sipariş Yönetimi</td>
                                            <td><input type="checkbox" name="permissions[order][view]"></td>
                                            <td><input type="checkbox" name="permissions[order][create]"></td>
                                            <td><input type="checkbox" name="permissions[order][edit]"></td>
                                            <td><input type="checkbox" name="permissions[order][delete]"></td>
                                        </tr>
                                        <tr>
                                            <td>Ödeme Yönetimi</td>
                                            <td><input type="checkbox" name="permissions[payment][view]"></td>
                                            <td><input type="checkbox" name="permissions[payment][create]"></td>
                                            <td><input type="checkbox" name="permissions[payment][edit]"></td>
                                            <td><input type="checkbox" name="permissions[payment][delete]"></td>
                                        </tr>
                                        <tr>
                                            <td>Tanım Yönetimi</td>
                                            <td><input type="checkbox" name="permissions[definition][view]"></td>
                                            <td><input type="checkbox" name="permissions[definition][create]"></td>
                                            <td><input type="checkbox" name="permissions[definition][edit]"></td>
                                            <td><input type="checkbox" name="permissions[definition][delete]"></td>
                                        </tr>
                                        <tr>
                                            <td>Bayi</td>
                                            <td><input type="checkbox" name="permissions[dealer][view]"></td>
                                            <td><input type="checkbox" name="permissions[dealer][create]"></td>
                                            <td><input type="checkbox" name="permissions[dealer][edit]"></td>
                                            <td><input type="checkbox" name="permissions[dealer][delete]"></td>
                                        </tr>
                                        <tr>
                                            <td>Mesaj</td>
                                            <td><input type="checkbox" name="permissions[message][view]"></td>
                                            <td><input type="checkbox" name="permissions[message][create]"></td>
                                            <td><input type="checkbox" name="permissions[message][edit]"></td>
                                            <td><input type="checkbox" name="permissions[message][delete]"></td>
                                        </tr>
                                        <tr>
                                            <td>Kod</td>
                                            <td><input type="checkbox" name="permissions[code][view]"></td>
                                            <td><input type="checkbox" name="permissions[code][create]"></td>
                                            <td><input type="checkbox" name="permissions[code][edit]"></td>
                                            <td><input type="checkbox" name="permissions[code][delete]"></td>
                                        </tr>
                                        <tr>
                                            <td>Rapor</td>
                                            <td><input type="checkbox" name="permissions[report][view]"></td>
                                            <td><input type="checkbox" name="permissions[report][create]"></td>
                                            <td><input type="checkbox" name="permissions[report][edit]"></td>
                                            <td><input type="checkbox" name="permissions[report][delete]"></td>
                                        </tr>
                                        <tr>
                                            <td>Genel Ayarlar</td>
                                            <td><input type="checkbox" name="permissions[settings][view]"></td>
                                            <td><input type="checkbox" name="permissions[settings][create]"></td>
                                            <td><input type="checkbox" name="permissions[settings][edit]"></td>
                                            <td><input type="checkbox" name="permissions[settings][delete]"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Kullanıcıyı Ekle
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

.table td:first-child {
    text-align: left;
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