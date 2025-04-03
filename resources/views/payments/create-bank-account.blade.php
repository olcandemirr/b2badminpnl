@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('payments.bank-accounts') }}">Hesap Listesi</a></li>
                    <li class="breadcrumb-item active">Hesap Ekle</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Hesap Ekle</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('payments.bank-accounts.store') }}" method="POST">
                        @csrf
                        
                        <!-- Banka Bilgileri -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">BANKA BİLGİLERİ</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <select name="bank" class="form-select" required>
                                        <option value="">Seçiniz</option>
                                        <option value="ziraat">Ziraat Bankası</option>
                                        <option value="garanti">Garanti Bankası</option>
                                        <option value="isbank">İş Bankası</option>
                                        <option value="akbank">Akbank</option>
                                        <option value="yapikredi">Yapı Kredi</option>
                                        <option value="halkbank">Halkbank</option>
                                        <option value="vakifbank">Vakıfbank</option>
                                        <option value="finansbank">QNB Finansbank</option>
                                        <option value="denizbank">Denizbank</option>
                                        <option value="teb">TEB</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Hesap Bilgileri -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">HESAP BİLGİLERİ</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="account_name" placeholder="Hesap Adı" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="branch_name" placeholder="Şube Adı" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="branch_code" placeholder="Şube Kodu" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="account_number" placeholder="Hesap No" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="iban" placeholder="IBAN No" required>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked>
                                        <label class="form-check-label" for="isActive">Hesap Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Hesabı Ekle
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