<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            --warning-color: #f59e0b;
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

        /* Header styles (giữ nguyên từ thiết kế trước) */
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

        /* Main content styles */
        .main-content {
            margin-top: 70px;
            padding: 2rem;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-color);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--gray-color);
        }

        .breadcrumb a {
            color: var(--gray-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb a:hover {
            color: var(--primary-color);
        }

        .breadcrumb .divider {
            color: var(--gray-color);
            font-size: 0.8rem;
        }

        /* Stats cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .stat-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-3px);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stat-title {
            font-size: 0.9rem;
            color: var(--gray-color);
            font-weight: 500;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .stat-icon.primary {
            background-color: rgba(37, 99, 235, 0.1);
            color: var(--primary-color);
        }

        .stat-icon.success {
            background-color: rgba(22, 163, 74, 0.1);
            color: var(--success-color);
        }

        .stat-icon.warning {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }

        .stat-icon.danger {
            background-color: rgba(220, 38, 38, 0.1);
            color: var(--danger-color);
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .stat-change {
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .stat-change.positive {
            color: var(--success-color);
        }

        .stat-change.negative {
            color: var(--danger-color);
        }

        /* Charts section */
        .charts-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .chart-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .chart-actions {
            display: flex;
            gap: 10px;
        }

        .chart-btn {
            background: none;
            border: none;
            color: var(--gray-color);
            cursor: pointer;
            transition: var(--transition);
        }

        .chart-btn:hover {
            color: var(--primary-color);
        }

        .chart-placeholder {
            height: 300px;
            background-color: #f8fafc;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-color);
        }

        /* Recent orders table */
        .recent-orders {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .view-all {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .view-all:hover {
            text-decoration: underline;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table th {
            text-align: left;
            padding: 0.75rem 1rem;
            font-weight: 600;
            color: var(--gray-color);
            border-bottom: 1px solid #e2e8f0;
        }

        .orders-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .order-id {
            font-weight: 500;
            color: var(--primary-color);
            text-decoration: none;
        }

        .order-id:hover {
            text-decoration: underline;
        }

        .customer-name {
            font-weight: 500;
        }

        .order-status {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-completed {
            background-color: rgba(22, 163, 74, 0.1);
            color: var(--success-color);
        }

        .status-pending {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }

        .status-processing {
            background-color: rgba(37, 99, 235, 0.1);
            color: var(--primary-color);
        }

        .status-cancelled {
            background-color: rgba(220, 38, 38, 0.1);
            color: var(--danger-color);
        }

        .order-actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            background: none;
            border: none;
            color: var(--gray-color);
            cursor: pointer;
            transition: var(--transition);
        }

        .action-btn:hover {
            color: var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .charts-section {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }
            
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .orders-table {
                display: block;
                overflow-x: auto;
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
                    <a href="#" class="nav-link active">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
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
        <div class="dashboard-header">
            <h1 class="page-title">Dashboard</h1>
            <div class="breadcrumb">
                <a href="#">Home</a>
                <span class="divider">/</span>
                <span>Dashboard</span>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Tổng doanh thu</h3>
                    <div class="stat-icon primary">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
                <div class="stat-value">$24,780</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>12.5% so với tháng trước</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Đơn hàng</h3>
                    <div class="stat-icon success">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
                <div class="stat-value">1,245</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>8.2% so với tháng trước</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Khách hàng</h3>
                    <div class="stat-icon warning">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-value">2,890</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>5.7% so với tháng trước</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Tỷ lệ hoàn trả</h3>
                    <div class="stat-icon danger">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                </div>
                <div class="stat-value">4.8%</div>
                <div class="stat-change negative">
                    <i class="fas fa-arrow-down"></i>
                    <span>1.2% so với tháng trước</span>
                </div>
            </div>
        </div>

        <div class="charts-section">
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">Doanh thu theo tháng</h3>
                    <div class="chart-actions">
                        <button class="chart-btn">Tuần</button>
                        <button class="chart-btn">Tháng</button>
                        <button class="chart-btn active">Năm</button>
                    </div>
                </div>
                <div class="chart-placeholder">
                    <i class="fas fa-chart-line" style="font-size: 2rem; margin-right: 10px;"></i>
                    Biểu đồ doanh thu sẽ được hiển thị ở đây
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">Phân loại sản phẩm bán chạy</h3>
                    <div class="chart-actions">
                        <button class="chart-btn">Xuất</button>
                    </div>
                </div>
                <div class="chart-placeholder">
                    <i class="fas fa-chart-pie" style="font-size: 2rem; margin-right: 10px;"></i>
                    Biểu đồ phân loại sẽ được hiển thị ở đây
                </div>
            </div>
        </div>

        <div class="recent-orders">
            <div class="section-header">
                <h3 class="section-title">Đơn hàng gần đây</h3>
                <a href="/Watch_Store_Manage/admincp/donhang.php" class="view-all">Xem tất cả</a>
            </div>
            
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="#" class="order-id">#ORD-2023-001</a></td>
                        <td class="customer-name">Nguyễn Văn A</td>
                        <td>15/10/2023</td>
                        <td>$1,245</td>
                        <td><span class="order-status status-completed">Hoàn thành</span></td>
                        <td>
                            <div class="order-actions">
                                <button class="action-btn" title="Xem chi tiết"><i class="fas fa-eye"></i></button>
                                <button class="action-btn" title="In hóa đơn"><i class="fas fa-print"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="#" class="order-id">#ORD-2023-002</a></td>
                        <td class="customer-name">Trần Thị B</td>
                        <td>14/10/2023</td>
                        <td>$890</td>
                        <td><span class="order-status status-processing">Đang xử lý</span></td>
                        <td>
                            <div class="order-actions">
                                <button class="action-btn" title="Xem chi tiết"><i class="fas fa-eye"></i></button>
                                <button class="action-btn" title="In hóa đơn"><i class="fas fa-print"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="#" class="order-id">#ORD-2023-003</a></td>
                        <td class="customer-name">Lê Văn C</td>
                        <td>13/10/2023</td>
                        <td>$2,150</td>
                        <td><span class="order-status status-pending">Chờ xác nhận</span></td>
                        <td>
                            <div class="order-actions">
                                <button class="action-btn" title="Xem chi tiết"><i class="fas fa-eye"></i></button>
                                <button class="action-btn" title="In hóa đơn"><i class="fas fa-print"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="#" class="order-id">#ORD-2023-004</a></td>
                        <td class="customer-name">Phạm Thị D</td>
                        <td>12/10/2023</td>
                        <td>$1,780</td>
                        <td><span class="order-status status-completed">Hoàn thành</span></td>
                        <td>
                            <div class="order-actions">
                                <button class="action-btn" title="Xem chi tiết"><i class="fas fa-eye"></i></button>
                                <button class="action-btn" title="In hóa đơn"><i class="fas fa-print"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="#" class="order-id">#ORD-2023-005</a></td>
                        <td class="customer-name">Hoàng Văn E</td>
                        <td>11/10/2023</td>
                        <td>$3,245</td>
                        <td><span class="order-status status-cancelled">Đã hủy</span></td>
                        <td>
                            <div class="order-actions">
                                <button class="action-btn" title="Xem chi tiết"><i class="fas fa-eye"></i></button>
                                <button class="action-btn" title="In hóa đơn"><i class="fas fa-print"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
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

        // Xử lý active cho các nút chọn khoảng thời gian biểu đồ
        document.querySelectorAll('.chart-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.chart-btn').forEach(b => {
                    b.classList.remove('active');
                });
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>