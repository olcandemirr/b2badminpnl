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
            overflow-y: auto;
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

        #sidebar .p-4 {
            height: 100vh;
            overflow-y: auto;
        }

        #sidebar .p-4::-webkit-scrollbar {
            width: 5px;
        }

        #sidebar .p-4::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        #sidebar .p-4::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 5px;
        }

        #sidebar .p-4::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
    @yield('styles')
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
                        <li><a href="{{ route('orders.pending') }}">Bekleyen Siparişler</a></li>
                        <li><a href="{{ route('orders.pending.details') }}">Bekleyen Siparişler Detay</a></li>
                        <li><a href="{{ route('orders.approved') }}">Onaylanan Siparişler</a></li>
                        <li><a href="{{ route('orders.approved.details') }}">Onaylanan Siparişler Detay</a></li>
                        <li><a href="{{ route('orders.cancelled') }}">İptal Siparişler</a></li>
                        <li><a href="{{ route('orders.cancelled.details') }}">İptal Siparişler Detay</a></li>
                        <li><a href="#">Sepet Hatırlat</a></li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#urunSubmenu" class="sidebar-link dropdown-toggle" data-bs-toggle="collapse">
                        <i class="fas fa-box"></i> Ürün Yönetimi
                    </a>
                    <ul class="collapse sidebar-submenu" id="urunSubmenu">
                        <li><a href="{{ route('products.index') }}">Ürünler</a></li>
                        <li><a href="{{ route('products.create') }}">Ürün Ekle</a></li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#bayiSubmenu" class="sidebar-link dropdown-toggle" data-bs-toggle="collapse">
                        <i class="fas fa-users"></i> Bayi Yönetimi
                    </a>
                    <ul class="collapse sidebar-submenu" id="bayiSubmenu">
                        <li><a href="{{ route('dealers.index') }}">Bayi Listesi</a></li>
                        <li><a href="{{ route('dealers.create') }}">Bayi Ekle</a></li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#mesajSubmenu" class="sidebar-link dropdown-toggle" data-bs-toggle="collapse">
                        <i class="fas fa-envelope"></i> Mesaj & Şikayetler
                    </a>
                    <ul class="collapse sidebar-submenu" id="mesajSubmenu">
                        <li><a href="{{ route('messages.create') }}">Mesaj Yaz</a></li>
                        <li><a href="{{ route('messages.inbox') }}">Gelen Kutusu</a></li>
                        <li><a href="{{ route('messages.sent') }}">Giden Kutusu</a></li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#tanimlarSubmenu" class="sidebar-link dropdown-toggle" data-bs-toggle="collapse">
                        <i class="fas fa-cog"></i> Tanımlar
                    </a>
                    <ul class="collapse sidebar-submenu" id="tanimlarSubmenu">
                        <li><a href="{{ route('definitions.sections') }}">Bölüm Ekle</a></li>
                        <li><a href="{{ route('definitions.categories') }}">Kategori Ekle</a></li>
                        <li><a href="{{ route('definitions.slides') }}">Slayt Ekle</a></li>
                        <li><a href="{{ route('definitions.contents') }}">İçerik Ekle</a></li>
                        <li><a href="{{ route('definitions.contents.list') }}">İçerik Listesi</a></li>
                        <li><a href="{{ route('definitions.discount-codes') }}">İskonto Kod Tanım</a></li>
                        <li><a href="{{ route('definitions.discount-types') }}">İskonto Tip Ekle</a></li>
                        <li><a href="{{ route('definitions.discount-types.list') }}">İskonto Tip Listesi</a></li>
                        <li><a href="{{ route('definitions.transfer') }}">Aktarım</a></li>
                        <li><a href="{{ route('definitions.file-import') }}">Dosyadan Aktar</a></li>
                        <li><a href="{{ route('definitions.photo-upload') }}">Foto Yükle</a></li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" data-bs-toggle="collapse" data-bs-target="#reportsSubmenu">
                        <i class="fas fa-chart-bar"></i>
                        <span>Raporlar</span>
                        <i class="fas fa-angle-down ms-auto"></i>
                    </a>
                    <ul class="collapse sidebar-submenu"id="reportsSubmenu">
                        <li class="nav-item">
                            <a href="#" class="nav-link">Rapor Özet</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Log Raporu</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Bayi Raporu</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Günlük Bayi Satış</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Yıllık Bayi Satış</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Yıllık Satış</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Temsilci Hakediş Raporu</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Stok Raporu Detay</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Stok Raporu Özet</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Sipariş Raporu</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" data-bs-toggle="collapse" data-bs-target="#userManagementSubmenu">
                        <i class="fas fa-users"></i>
                        <span>Kullanıcı Yönetimi</span>
                        <i class="fas fa-angle-down ms-auto"></i>
                    </a>
                    <ul class="collapse sidebar-submenu" id="userManagementSubmenu">
                        <li class="nav-item">
                            <a href="#" class="nav-link">Kullanıcı Listesi</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Kullanıcı Ekle</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" data-bs-toggle="collapse" data-bs-target="#codeManagementSubmenu">
                        <i class="fas fa-code"></i>
                        <span>Kod Yönetimi</span>
                        <i class="fas fa-angle-down ms-auto"></i>
                    </a>
                    <ul class="collapse sidebar-submenu" id="codeManagementSubmenu">
                        <li class="nav-item">
                            <a href="#" class="nav-link">Kod Ekle</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Kod Listesi</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Kullanılan Kod Listesi</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" data-bs-toggle="collapse" data-bs-target="#paymentSettingsSubmenu">
                        <i class="fas fa-money-bill"></i>
                        <span>Ödeme Ayar & List</span>
                        <i class="fas fa-angle-down ms-auto"></i>
                    </a>
                    <ul class="collapse sidebar-submenu" id="paymentSettingsSubmenu">
                        <li class="nav-item">
                            <a href="#" class="nav-link">Havale Hesapları</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Havale Hesabı Ekle</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Sanal Poslar</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Sanal Pos Ödeme Listesi</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" data-bs-toggle="collapse" data-bs-target="#settingsSubmenu">
                        <i class="fas fa-cog"></i>
                        <span>Ayarlar</span>
                        <i class="fas fa-angle-down ms-auto"></i>
                    </a>
                    <ul class="collapse sidebar-submenu" id="settingsSubmenu">
                        <li class="nav-item">
                            <a href="#" class="nav-link">Genel Ayarlar</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Desi Fiyatları</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Parametreler</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Anket Yönetim</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Page Content -->
    <div id="content">
        <!-- Navbar -->
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
        </nav>

        <!-- Main Content -->
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
                $('.overlay').toggleClass('active');
            });

            $('.overlay').on('click', function() {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            $('.dropdown-toggle').on('click', function() {
                const submenu = $(this).next('.sidebar-submenu');
                $('.sidebar-submenu').not(submenu).removeClass('show');
                submenu.toggleClass('show');
            });
        });
    </script>
    @yield('scripts')
</body>
</html> 