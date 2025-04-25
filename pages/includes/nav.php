<?php
// Kết nối cơ sở dữ liệu
$host = "localhost";
$username = "root";
$password = "";
$dbname = "project-watch"; // Tên cơ sở dữ liệu của bạn

$link = new mysqli($host, $username, $password, $dbname);

if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// Truy vấn dữ liệu từ bảng navigation
$query = "SELECT name, url, logo FROM navigation";
$result = $link->query($query);

// Lưu các mục menu vào mảng
$navItems = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $navItems[] = $row;
    }
}

// Đóng kết nối cơ sở dữ liệu
$link->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation</title>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>

    <style>
        *{
            font-family: 'Be Vietnam Pro';
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: white;
        }

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
            margin-left: 20px;
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
            margin-left: 20px;
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

        /* Thêm logo vào trước text menu */
        .nav-bottom nav ul li a img.nav-logo-img {
            width: 20px; /* Kích thước logo nhỏ */
            height: auto;
            margin-right: 10px; /* Khoảng cách giữa logo và tên menu */
        }
    </style>
</head>
<body>

<div class="nav-container">
    <!-- Hàng trên: Giỏ hàng, tìm kiếm, logo -->
    <div class="nav-top">
        <div class="nav-left">
            <div class="search-box">
                <input type="text" placeholder="Tìm sản phẩm hoặc thương hiệu">
                <i class="fas fa-search"></i>
            </div>
            <a href="/Watch_Store_Manage/pages/gio.php" class="cart-icon"><i class="fas fa-shopping-bag"></i></a>
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
                <?php
                // Lặp qua mảng $navItems để hiển thị các mục menu
                foreach ($navItems as $item) {
                    echo '<li><a href="' . $item['url'] . '">';
                    if (!empty($item['logo'])) {
                        echo '<img src="' . $item['logo'] . '" alt="' . $item['name'] . '" class="nav-logo-img" />';
                    }
                    echo $item['name'] . '</a></li>';
                }
                ?>
            </ul>
        </nav>
    </div>
</div>

</body>
</html>
