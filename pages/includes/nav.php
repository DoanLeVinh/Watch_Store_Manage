<!-- includes/nav.php -->
<div class="nav-container">
    <!-- Hàng trên: Giỏ hàng, tìm kiếm, logo -->

<style>
    .cart-icon{
        margin: 10px;
    }
    
</style>
    <div class="nav-top">
        <div class="nav-left">
            <div class="search-box">
                <input type="text" placeholder="Tìm sản phẩm hoặc thương hiệu">
                <i class="fas fa-search"></i>
            </div>
            <a href="/Watch_Store_Manage/pages/giohang.php" class="cart-icon"><i class="fas fa-shopping-bag"></i></a>
        </div>
        <div class="nav-logo">
            <img src="/Watch_Store_Manage/images/Logo.png" alt="Logo Thương Hiệu">
        </div>
        <div class="nav-right"></div> <!-- Khoảng trống để cân bằng bố cục -->
    </div>

    <!-- Hàng dưới: Menu điều hướng (Căn giữa) -->
    <div class="nav-bottom">
        <nav>
            <ul>
                 <!-- Liên kết trang chủ -->
                 <li><a href="/Watch_Store_Manage/pages/index.php">TRANG CHỦ</a></li>

                 <!-- Liên kết đến trang Nam -->
                 <li><a href="/Watch_Store_Manage/pages/men.php">NAM</a></li>

                 <!-- Liên kết đến trang Nữ -->
                 <li><a href="/Watch_Store_Manage/pages/women.php">NỮ</a></li>

                 <!-- Liên kết đến trang Trang Sức -->
                 <li><a href="/Watch_Store_Manage/pages/jewelry.php">TRANG SỨC</a></li>

                 <!-- Liên kết đến trang Phụ Kiện -->
                 <li><a href="/Watch_Store_Manage/pages/accessory.php">PHỤ KIỆN</a></li>

                 <!-- Liên kết đến trang Tin Tức -->
                 <li><a href="/Watch_Store_Manage/pages/new.php">TIN TỨC</a></li>

                 <!-- Liên kết đến trang Liên Hệ -->
                 <li><a href="/Watch_Store_Manage/pages/contact.php">LIÊN HỆ</a></li>
            </ul>
        </nav>
    </div>
</div>


<!-- Font Awesome Icons -->
<script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&display=swap');

    /* Container chính */
    .nav-container {
        font-family: 'Playfair Display', serif;
        background-color: white;
        padding: 10px 20px;
    }

    /* Hàng trên: Giỏ hàng, tìm kiếm, logo */
    .nav-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 10px;
    }

    /* Logo chính giữa */
    .nav-logo {
        position: absolute;
        left: 50%;
        transform: translateX(-50%); /* Đưa logo về chính giữa */
        margin-top: 50px; /* Khoảng cách 1cm với header */
        margin-bottom: 20px; /* Khoảng cách 1cm với menu */
    }

    .nav-logo img {
        height: 40px; /* Giảm chiều cao logo xuống nhỏ hơn */
        max-width: 1000px; /* Giới hạn chiều rộng để logo không quá to */
    }

    /* Giỏ hàng & tìm kiếm sang phải */
    .nav-left {
        display: flex;
        align-items: center;
        margin-left: auto; /* Đẩy về bên phải */
    }

    /* Tìm kiếm */
    .search-box {
        display: flex;
        align-items: center;
        background: #f5f5f5;
        padding: 5px 10px;
        border-radius: 20px;
        margin-left: 10px;
    }

    .search-box input {
        border: none;
        background: transparent;
        outline: none;
        padding: 5px;
        font-size: 14px;
        width: 180px;
    }

    .search-box i {
        color: #888;
        margin-left: 8px;
    }

    /* Giỏ hàng */
    .cart-icon {
        font-size: 18px;
        color: #333;
        text-decoration: none;
        transition: color 0.3s;
    }

    .cart-icon:hover {
        color:rgb(0, 0, 0); /* Đỏ trầm */
    }

    /* Hàng dưới: Menu điều hướng */
    .nav-bottom {
        text-align: center;
        padding-top: 30px;
    }

    .nav-bottom nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
        gap: 20px;
    }

    .nav-bottom nav ul li {
        display: inline-block;
    }

    /* Màu chữ & hiệu ứng hover */
    .nav-bottom nav ul li a {
        text-decoration: none;
        color: #333;
        font-size: 16px;
        font-weight: 500;
        padding: 10px 15px;
        transition: color 0.3s ease-in-out;
        position: relative;
    }

    .nav-bottom nav ul li a:hover {
        color: #8B0000; /* Đỏ trầm */
    }

    /* Hiệu ứng gạch chân khi hover */
    .nav-bottom nav ul li a::after {
        content: "";
        display: block;
        width: 0;
        height: 2px;
        background-color:rgb(88, 63, 63); /* Đỏ trầm */
        transition: width 0.3s ease-in-out;
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
    }

    .nav-bottom nav ul li a:hover::after {
        width: 100%;
    }
</style>
