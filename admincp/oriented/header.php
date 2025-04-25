
<title>Quản lý Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #222;
        color: white;
        padding: 15px 0;
        position: relative;
    }

    header .logo {
        font-size: 1.8em;
        font-weight: bold;
        margin-left: 20px;
    }

    .menu {
        display: flex;
        justify-content: flex-start;
        margin-right: 20px;
    }

    .menu-item {
        position: relative;
        padding: 15px;
        font-size: 1.2em;
        cursor: pointer;
        color: white;
        text-align: center;
        background-color: #333;
        margin: 0 10px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .menu-item:hover {
        background-color: #555;
    }

    .sub-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #333;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0px 8px 10px rgba(0, 0, 0, 0.2);
    }

    .sub-menu a {
        color: white;
        padding: 8px 20px;
        display: block;
        text-decoration: none;
        font-size: 1em;
        transition: background-color 0.3s;
    }

    .sub-menu a:hover {
        background-color: #555;
    }

    .menu-item:hover .sub-menu {
        display: block;
    }

    .main-content {
        padding: 20px;
        background-color: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        margin: 20px;
    }
</style>

<header>
    <div class="logo">Admin Dashboard</div>
    <div class="menu">
        <div class="menu-item">
            Quản lý
            <div class="sub-menu">
                <a href="/Watch_Store_Manage/admincp/index.php">Quản lý sản phẩm</a>
                <a href="#">Quản lí đơn hàng</a>
                <a href="#">Quản lý doanh thu</a>
            </div>
        </div>
        <div class="menu-item">
            Chăm sóc hệ thống
            <div class="sub-menu">
                <a href="/Watch_Store_Manage/admincp/QL-header.php">Quản lý Header</a>
                <a href="/Watch_Store_Manage/admincp/QL-footer.php">Quản lý Footer</a>
                <a href="/Watch_Store_Manage/admincp/QL-nav.php">Quản lý Navigation</a>
                <a href="#">Nội dung khác</a>
            </div>
        </div>
        <div class="menu-item">
            Cài đặt
            <div class="sub-menu">
                <a href="#">Cài đặt chung</a>
                <a href="#">Quản lý người dùng</a>
            </div>
        </div>
    </div>
</header>

<script>
    // Thêm hiệu ứng di chuột vào các menu
    document.querySelectorAll('.menu-item').forEach(item => {
        item.addEventListener('mouseenter', () => {
            item.querySelector('.sub-menu').style.display = 'block';
        });

        item.addEventListener('mouseleave', () => {
            item.querySelector('.sub-menu').style.display = 'none';
        });
    });
</script>

</body>
</html>
