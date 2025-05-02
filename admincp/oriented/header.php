<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
            --gray-color: #94a3b8;
            --danger-color: #dc2626;
            --success-color: #16a34a;
            --border-radius: 8px;
            --transition: all 0.3s ease;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: #334155;
        }

        .admin-header {
            background-color: white;
            box-shadow: var(--shadow-md);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            display: flex;
            align-items: center;
        }

        .logo-icon {
            color: var(--primary-color);
            margin-right: 10px;
            font-size: 1.8rem;
        }

        .nav-container {
            display: flex;
            align-items: center;
            height: 100%;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .nav-item {
            position: relative;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .nav-link {
            color: var(--dark-color);
            text-decoration: none;
            padding: 0 1.25rem;
            height: 100%;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: var(--transition);
            border-bottom: 3px solid transparent;
        }

        .nav-link:hover {
            color: var(--primary-color);
            background-color: rgba(37, 99, 235, 0.05);
        }

        .nav-link.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        .nav-link i {
            font-size: 1.1rem;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: white;
            min-width: 220px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: var(--transition);
            z-index: 100;
        }

        .nav-item:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: block;
            padding: 0.75rem 1.5rem;
            color: var(--dark-color);
            text-decoration: none;
            transition: var(--transition);
            border-left: 3px solid transparent;
        }

        .dropdown-item:hover {
            background-color: rgba(37, 99, 235, 0.05);
            color: var(--primary-color);
            border-left-color: var(--primary-color);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
            color: var(--gray-color);
        }

        .dropdown-item:hover i {
            color: var(--primary-color);
        }

        .dropdown-divider {
            height: 1px;
            background-color: #e2e8f0;
            margin: 0.5rem 0;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .notification-badge {
            position: relative;
            cursor: pointer;
            color: var(--dark-color);
        }

        .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        .username {
            font-weight: 500;
            color: var(--dark-color);
        }

        .main-content {
            margin-top: 70px;
            padding: 2rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .admin-header {
                padding: 0 1rem;
            }
            
            .nav-link {
                padding: 0 0.75rem;
                font-size: 0.9rem;
            }
            
            .logo-text {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .nav-container {
                position: fixed;
                top: 70px;
                left: 0;
                width: 100%;
                background-color: white;
                box-shadow: var(--shadow-md);
                height: auto;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
            }
            
            .nav-container.active {
                max-height: 500px;
                padding: 1rem 0;
            }
            
            .nav-menu {
                flex-direction: column;
                height: auto;
            }
            
            .nav-item {
                height: auto;
                width: 100%;
            }
            
            .nav-link {
                padding: 0.75rem 1.5rem;
                border-bottom: none;
                border-left: 3px solid transparent;
            }
            
            .nav-link.active {
                border-left-color: var(--primary-color);
                border-bottom: none;
            }
            
            .dropdown-menu {
                position: static;
                box-shadow: none;
                opacity: 1;
                visibility: visible;
                transform: none;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
            }
            
            .nav-item:hover .dropdown-menu {
                max-height: 500px;
                padding: 0.5rem 0;
            }
            
            .menu-toggle {
                display: block;
                font-size: 1.5rem;
                cursor: pointer;
                color: var(--dark-color);
            }
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="logo-container">
            <div class="logo">
                <i class="fas fa-cog logo-icon"></i>
                <span class="logo-text">Admin Dashboard</span>
            </div>
        </div>

        <div class="nav-container" id="navContainer">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-box-open"></i>
                        <span>Sản phẩm</span>
                    </a>
                    <div class="dropdown-menu">
                        <a href="/Watch_Store_Manage/admincp/index.php" class="dropdown-item">
                            <i class="fas fa-list"></i>
                            Quản lý sản phẩm
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-tags"></i>
                            Danh mục
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-chart-line"></i>
                            Tồn kho
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Đơn hàng</span>
                    </a>
                    <div class="dropdown-menu">
                        <a href="/Watch_Store_Manage/admincp/donhang.php" class="dropdown-item">
                            <i class="fas fa-list-ul"></i>
                            Danh sách đơn hàng
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-exchange-alt"></i>
                            Đơn hoàn trả
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-chart-pie"></i>
                            Thống kê
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-globe"></i>
                        <span>Giao diện</span>
                    </a>
                    <div class="dropdown-menu">
                        <a href="/Watch_Store_Manage/admincp/QL-header.php" class="dropdown-item">
                            <i class="fas fa-heading"></i>
                            Header
                        </a>
                        <a href="/Watch_Store_Manage/admincp/QL-footer.php" class="dropdown-item">
                            <i class="fas fa-window-minimize"></i>
                            Footer
                        </a>
                        <a href="/Watch_Store_Manage/admincp/QL-nav.php" class="dropdown-item">
                            <i class="fas fa-bars"></i>
                            Navigation
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Người dùng</span>
                    </a>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user-shield"></i>
                            Quản trị viên
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user-friends"></i>
                            Khách hàng
                        </a>
                    </div>
                </li>
            </ul>
        </div>

        <div class="user-menu">
            <div class="notification-badge">
                <i class="fas fa-bell"></i>
                <span class="badge">3</span>
            </div>
            <div class="user-profile">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User" class="avatar">
                <span class="username">Admin</span>
            </div>
            <i class="fas fa-bars menu-toggle" id="menuToggle"></i>
        </div>
    </header>

    <div class="main-content">
        <!-- Nội dung chính sẽ được thêm vào đây -->
    </div>

    <script>
        // Toggle menu mobile
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('navContainer').classList.toggle('active');
        });

        // Đóng menu khi click ra ngoài (cho mobile)
        document.addEventListener('click', function(event) {
            const navContainer = document.getElementById('navContainer');
            const menuToggle = document.getElementById('menuToggle');
            
            if (!navContainer.contains(event.target) && event.target !== menuToggle) {
                navContainer.classList.remove('active');
            }
        });

        // Thêm active class cho menu item khi click
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.parentElement.querySelector('.dropdown-menu')) {
                    e.preventDefault();
                }
                
                document.querySelectorAll('.nav-link').forEach(item => {
                    item.classList.remove('active');
                });
                
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>