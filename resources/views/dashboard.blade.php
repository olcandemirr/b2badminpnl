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
                <li><a href="#" class="sidebar-link"><i class="fas fa-home"></i> Anasayfa</a></li>
                <li><a href="#" class="sidebar-link"><i class="fas fa-shopping-cart"></i> Sipariş Yönetimi</a></li>
                <li><a href="#" class="sidebar-link"><i class="fas fa-box"></i> Ürün Yönetimi</a></li>
                <li><a href="#" class="sidebar-link"><i class="fas fa-users"></i> Bayi Yönetimi</a></li>
                <li><a href="#" class="sidebar-link"><i class="fas fa-envelope"></i> Mesaj & Şikayetler</a></li>
                <li><a href="#" class="sidebar-link"><i class="fas fa-cog"></i> Tanımlar</a></li>
                <li><a href="#" class="sidebar-link"><i class="fas fa-chart-bar"></i> Raporlar</a></li>
                <li><a href="#" class="sidebar-link"><i class="fas fa-user-cog"></i> Kullanıcı Yönetimi</a></li>
                <li><a href="#" class="sidebar-link"><i class="fas fa-code"></i> Kod Yönetimi</a></li>
                <li><a href="#" class="sidebar-link"><i class="fas fa-credit-card"></i> Ödeme Ayar & List</a></li>
                <li><a href="#" class="sidebar-link"><i class="fas fa-wrench"></i> Ayarlar</a></li>
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

            sidebarCollapse.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        });
    </script>
</body>
</html> 