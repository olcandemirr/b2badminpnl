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
                    <!-- Validasyon Hataları -->
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        
                        <!-- Kullanıcı Tipi -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">KULLANICI TİPİ</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="user_type" id="typeAdmin" value="admin" {{ old('user_type') == 'admin' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="typeAdmin">Yönetici</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="user_type" id="typeStaff" value="staff" {{ old('user_type') == 'staff' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="typeStaff">Personel</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="user_type" id="typeDealer" value="dealer" {{ old('user_type') == 'dealer' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="typeDealer">Bayi</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="user_type" id="typeCustomer" value="customer" {{ old('user_type', 'customer') == 'customer' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="typeCustomer">Müşteri</label>
                                </div>
                            </div>
                        </div>

                        <!-- Kullanıcı Bilgiler -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">KULLANICI BİLGİLER</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Kullanıcı Adı <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="full_name" class="form-label">Ad Soyad <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">E-posta <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Şifre <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Şifre Tekrar <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ old('status', '1') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status">Kullanıcı Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left me-1"></i> İptal
                            </a>
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