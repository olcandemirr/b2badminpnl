@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kullanıcı Detay</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.account.update') }}" method="POST">
                        @csrf
                        
                        <!-- KULLANICI TİPİ -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">KULLANICI TİPİ</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="user_type" id="typeAdmin" value="admin" {{ $user->type == 'admin' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="typeAdmin">Yönetici</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="user_type" id="typeRep" value="representative" {{ $user->type == 'representative' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="typeRep">Temsilci</label>
                                </div>
                            </div>
                        </div>

                        <!-- KULLANICI BİLGİLER -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">KULLANICI BİLGİLER</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Kullanıcı Adı</label>
                                    <input type="text" class="form-control" name="username" value="{{ $user->username }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Ad Soyad</label>
                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Şifre</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kullanıcı Aktif</label>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" class="form-check-input" name="is_active" id="isActive" {{ $user->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="isActive">Aktif</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">E-mail</label>
                                    <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tel</label>
                                    <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">GSM</label>
                                    <input type="text" class="form-control" name="gsm" value="{{ $user->gsm }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Program ID</label>
                                    <input type="text" class="form-control" name="program_id" value="{{ $user->program_id }}">
                                </div>
                            </div>
                        </div>

                        <!-- YETKİLER -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">YETKİLER</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Görüntüleme Yetkisi</th>
                                            <th>Ekleme Yetkisi</th>
                                            <th>Düzenleme Yetkisi</th>
                                            <th>Silme Yetkisi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Ürün Yönetimi</td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[product][view]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[product][create]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[product][edit]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[product][delete]"></td>
                                        </tr>
                                        <tr>
                                            <td>Sipariş Yönetimi</td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[order][view]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[order][create]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[order][edit]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[order][delete]"></td>
                                        </tr>
                                        <tr>
                                            <td>Ödeme Yönetimi</td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[payment][view]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[payment][create]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[payment][edit]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[payment][delete]"></td>
                                        </tr>
                                        <tr>
                                            <td>Tanım Yönetimi</td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[definition][view]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[definition][create]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[definition][edit]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[definition][delete]"></td>
                                        </tr>
                                        <tr>
                                            <td>Kullanıcı Yönetimi</td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[user][view]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[user][create]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[user][edit]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[user][delete]"></td>
                                        </tr>
                                        <tr>
                                            <td>Bayi</td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[dealer][view]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[dealer][create]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[dealer][edit]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[dealer][delete]"></td>
                                        </tr>
                                        <tr>
                                            <td>Mesaj</td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[message][view]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[message][create]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[message][edit]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[message][delete]"></td>
                                        </tr>
                                        <tr>
                                            <td>KDŞ</td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[kds][view]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[kds][create]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[kds][edit]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[kds][delete]"></td>
                                        </tr>
                                        <tr>
                                            <td>Rapor</td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[report][view]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[report][create]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[report][edit]"></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[report][delete]"></td>
                                        </tr>
                                        <tr>
                                            <td>Genel Ayarlar</td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[settings][view]"></td>
                                            <td></td>
                                            <td><input type="checkbox" class="form-check-input" name="permissions[settings][edit]"></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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

.form-label {
    color: #666;
    margin-bottom: 0.5rem;
}

.form-label.fw-bold {
    color: #333;
    font-size: 1rem;
    margin-bottom: 1rem;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.table td, .table th {
    vertical-align: middle;
}

.form-check-input {
    cursor: pointer;
}
</style>
@endpush 