@extends('layouts.app')

@section('styles')
<style>
    .stat-card {
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        color: white;
    }

    .stat-card i {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .menu-item {
        background: white;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        text-decoration: none;
        color: #333;
        transition: transform 0.3s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .menu-item:hover {
        transform: translateY(-5px);
    }

    .menu-item i {
        font-size: 2rem;
        margin-bottom: 10px;
        color: #0d6efd;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="stat-card bg-dark">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-shopping-bag"></i>
                        <h6>Bekleyen Siparişler</h6>
                        <div class="stat-number">1</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-calendar-day"></i>
                        <h6>Bugünkü Siparişler</h6>
                        <div class="stat-number">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-purple" style="background-color: #6f42c1;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-envelope"></i>
                        <h6>Gelen Mesajlar</h6>
                        <div class="stat-number">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-users"></i>
                        <h6>Bugünkü Girişler</h6>
                        <div class="stat-number">2</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Grid -->
    <div class="menu-grid">
        <a href="{{ route('products.index') }}" class="menu-item">
            <i class="fas fa-box"></i>
            <h5>Ürün Yönetimi</h5>
        </a>
        <a href="#" class="menu-item">
            <i class="fas fa-shopping-cart"></i>
            <h5>Sipariş Yönetimi</h5>
        </a>
        <a href="#" class="menu-item">
            <i class="fas fa-users"></i>
            <h5>Bayi Yönetimi</h5>
        </a>
        <a href="#" class="menu-item">
            <i class="fas fa-code"></i>
            <h5>Kod Yönetimi</h5>
        </a>
        <a href="#" class="menu-item">
            <i class="fas fa-file-alt"></i>
            <h5>İçerik Yönetimi</h5>
        </a>
        <a href="#" class="menu-item">
            <i class="fas fa-user-cog"></i>
            <h5>Kullanıcı Yönetimi</h5>
        </a>
        <a href="#" class="menu-item">
            <i class="fas fa-chart-bar"></i>
            <h5>Raporlar</h5>
        </a>
        <a href="#" class="menu-item">
            <i class="fas fa-cog"></i>
            <h5>Ayarlar</h5>
        </a>
    </div>
</div>
@endsection 