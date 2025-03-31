<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B2B Yönetim Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            background: #f8f9fa;
            transition: all 0.3s;
            position: fixed;
            top: 0;
            left: -250px;
            z-index: 1000;
        }

        #sidebar.active {
            left: 0;
        }

        #content {
            width: 100%;
            padding: 20px;
            transition: all 0.3s;
            margin-left: 0;
        }

        .overlay {
            display: none;
            position: fixed;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: all 0.5s ease-in-out;
        }

        .overlay.active {
            display: block;
            opacity: 1;
        }

        .sidebar-link {
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: 0.3s;
        }

        .sidebar-link:hover {
            background: #e9ecef;
        }

        .sidebar-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .sidebar-submenu {
            list-style: none;
            padding-left: 35px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .sidebar-submenu.show {
            max-height: 500px;
        }

        .sidebar-submenu a {
            padding: 8px 15px;
            color: #666;
            text-decoration: none;
            display: block;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .sidebar-submenu a:hover {
            color: #333;
            background: #e9ecef;
        }

        .sidebar-item {
            position: relative;
        }

        .sidebar-item.active {
            background: #e9ecef;
        }

        .sidebar-item.active > .sidebar-link {
            color: #0d6efd;
        }

        .dropdown-toggle::after {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
        }

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

        .menu-button {
            background: none;
            border: none;
            color: #333;
            padding: 10px;
        }

        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            padding: 3px 6px;
            border-radius: 50%;
            background: #dc3545;
            color: white;
            font-size: 0.7rem;
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
</head>
<body>
    <!-- Sidebar -->
    <div class="overlay"></div>
    <nav id="sidebar">
        <div class="p-4">
            <img src="/logo.png" alt="Logo" class="img-fluid mb-4">
            <ul class="list-unstyled">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-home"></i> Anasayfa
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#siparisSubmenu" class="sidebar-link dropdown-toggle" data-bs-toggle="collapse">
                        <i class="fas fa-shopping-cart"></i> Sipariş Yönetimi
                    </a>
                    <ul class="collapse sidebar-submenu" id="siparisSubmenu">
                        <li><a href="#">Bekleyen Siparişler</a></li>
                        <li><a href="#">Bekleyen Siparişler Detay</a></li>
                        <li><a href="#">Onaylanan Siparişler</a></li>
                        <li><a href="#">Onay Siparişler Detay</a></li>
                        <li><a href="#">İptal Siparişler</a></li>
                        <li><a href="#">İptal Siparişler Detay</a></li>
                        <li><a href="#">Sepet Hatırlat</a></li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#urunSubmenu" class="sidebar-link dropdown-toggle" data-bs-toggle="collapse">
                        <i class="fas fa-box"></i> Ürün Yönetimi
                    </a>
                    <ul class="collapse sidebar-submenu" id="urunSubmenu">
                        <li><a href="#">Ürünler</a></li>
                        <li><a href="#">Ürün Ekle</a></li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#bayiSubmenu" class="sidebar-link dropdown-toggle" data-bs-toggle="collapse">
                        <i class="fas fa-users"></i> Bayi Yönetimi
                    </a>
                    <ul class="collapse sidebar-submenu" id="bayiSubmenu">
                        <li><a href="#">Bayi Listesi</a></li>
                        <li><a href="#">Bayi Ekle</a></li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#mesajSubmenu" class="sidebar-link dropdown-toggle" data-bs-toggle="collapse">
                        <i class="fas fa-envelope"></i> Mesaj & Şikayetler
                    </a>
                    <ul class="collapse sidebar-submenu" id="mesajSubmenu">
                        <li><a href="#">Mesaj Yaz</a></li>
                        <li><a href="#">Gelen Kutusu</a></li>
                        <li><a href="#">Giden Kutusu</a></li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#tanimlarSubmenu" class="sidebar-link dropdown-toggle" data-bs-toggle="collapse">
                        <i class="fas fa-cog"></i> Tanımlar
                    </a>
                    <ul class="collapse sidebar-submenu" id="tanimlarSubmenu">
                        <li><a href="#">Bölüm Ekle</a></li>
                        <li><a href="#">Kategori Ekle</a></li>
                        <li><a href="#">Slayt Ekle</a></li>
                        <li><a href="#">İçerik Ekle</a></li>
                        <li><a href="#">İçerik Listesi</a></li>
                        <li><a href="#">İskonto Kod Tanım</a></li>
                        <li><a href="#">İskonto Tip Ekle</a></li>
                        <li><a href="#">İskonto Tip Listesi</a></li>
                        <li><a href="#">Aktarım</a></li>
                        <li><a href="#">Dosyadan Aktar</a></li>
                        <li><a href="#">Foto Yükle</a></li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#raporlarSubmenu" class="sidebar-link dropdown-toggle" data-bs-toggle="collapse">
                        <i class="fas fa-chart-bar"></i> Raporlar
                    </a>
                    <ul class="collapse sidebar-submenu" id="raporlarSubmenu">
                        <li><a href="#">Rapor Özet</a></li>
                        <li><a href="#">Log Raporu</a></li>
                        <li><a href="#">Bayi Raporu</a></li>
                        <li><a href="#">Günlük Bayi Satış</a></li>
                        <li><a href="#">Yıllık Bayi Satış</a></li>
                        <li><a href="#">Yıllık Satış</a></li>
                        <li><a href="#">Temsilci Hakediş Raporu</a></li>
                        <li><a href="#">Stok Raporu Detay</a></li>
                        <li><a href="#">Stok Raporu Özet</a></li>
                        <li><a href="#">Sipariş Raporu</a></li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#kullaniciSubmenu" class="sidebar-link dropdown-toggle" data-bs-toggle="collapse">
                        <i class="fas fa-user-cog"></i> Kullanıcı Yönetimi
                    </a>
                    <ul class="collapse sidebar-submenu" id="kullaniciSubmenu">
                        <li><a href="#">Kullanıcı Listesi</a></li>
                        <li><a href="#">Kullanıcı Ekle</a></li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#kodSubmenu" class="sidebar-link dropdown-toggle" data-bs-toggle="collapse">
                        <i class="fas fa-code"></i> Kod Yönetimi
                    </a>
                    <ul class="collapse sidebar-submenu" id="kodSubmenu">
                        <li><a href="#">Kod Ekle</a></li>
                        <li><a href="#">Kod Listesi</a></li>
                        <li><a href="#">Kullanılan Kod Listesi</a></li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#odemeSubmenu" class="sidebar-link dropdown-toggle" data-bs-toggle="collapse">
                        <i class="fas fa-credit-card"></i> Ödeme Ayar & List
                    </a>
                    <ul class="collapse sidebar-submenu" id="odemeSubmenu">
                        <li><a href="#">Havale Hesapları</a></li>
                        <li><a href="#">Havale Hesabı Ekle</a></li>
                        <li><a href="#">Sanal Poslar</a></li>
                        <li><a href="#">Sanal Pos Ödeme Listesi</a></li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#ayarlarSubmenu" class="sidebar-link dropdown-toggle" data-bs-toggle="collapse">
                        <i class="fas fa-wrench"></i> Ayarlar
                    </a>
                    <ul class="collapse sidebar-submenu" id="ayarlarSubmenu">
                        <li><a href="#">Genel Ayarlar</a></li>
                        <li><a href="#">Desi Fiyatları</a></li>
                        <li><a href="#">Parametreler</a></li>
                        <li><a href="#">Anket Yönetim</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-fluid">
            <button type="button" id="sidebarCollapse" class="menu-button">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand ms-3" href="#">B2B Yönetim Paneli</a>
            
            <!-- Arama Çubuğu -->
            <div class="d-flex mx-4" style="width: 300px;">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" placeholder="Ürün Arayın..." aria-label="Arama">
                    <button class="btn btn-outline-secondary btn-sm" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            
            <div class="d-flex align-items-center ms-auto">
                <div class="position-relative me-3">
                    <button class="menu-button" id="notificationDropdown" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">1</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                        <h6 class="dropdown-header">Bildirimler</h6>
                        <a class="dropdown-item" href="#">Yeni sipariş geldi</a>
                        <a class="dropdown-item" href="#">Yeni mesaj var</a>
                    </div>
                </div>
                
                <div class="dropdown d-flex align-items-center">
                    <button class="menu-button d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-2"></i>
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle me-2"></i>Hesabım</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Çıkış Yap
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div id="content">
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
            <a href="#" class="menu-item">
                <i class="fas fa-shopping-cart"></i>
                <h5>Sipariş Yönetimi</h5>
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-box"></i>
                <h5>Ürün Yönetimi</h5>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            const overlay = document.querySelector('.overlay');
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

            sidebarCollapse.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });

            // Aktif menü öğesini işaretleme
            const sidebarItems = document.querySelectorAll('.sidebar-item');
            sidebarItems.forEach(item => {
                item.addEventListener('click', function() {
                    sidebarItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html> 