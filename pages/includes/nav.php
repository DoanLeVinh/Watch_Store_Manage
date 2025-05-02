<?php
// Kết nối cơ sở dữ liệu với try-catch
try {
    $link = new mysqli("localhost", "root", "", "project-watch");
    $link->set_charset("utf8mb4");
    
    // Truy vấn navigation
    $navItems = [];
    $navResult = $link->query("SELECT name, url, logo FROM navigation");
    if ($navResult) {
        while ($row = $navResult->fetch_assoc()) {
            $navItems[] = $row;
        }
    }

    // Truy vấn tất cả sản phẩm từ 3 bảng
    $products = [];
    $tables = ['dongho_nam', 'dongho_nu', 'trangsuc'];
    
    foreach ($tables as $table) {
        $res = $link->query("SELECT Ma, TenSP FROM $table");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $products[] = [
                    'id' => $row['Ma'],
                    'name' => $row['TenSP']
                ];
            }
        }
    }
    
    $link->close();
} catch (Exception $e) {
    die("Lỗi kết nối database: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh Tìm Kiếm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #8B0000;
            --text-color: #333;
            --light-gray: #f5f5f5;
            --border-color: #ccc;
            --hover-color: #eee;
            --nav-height: 60px;
            --logo-height: 40px;
            --mobile-breakpoint: 768px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Be Vietnam Pro', sans-serif;
        }

        body {
            background: white;
        }

        .nav-container {
            background-color: white;
            position: relative;
            padding: 10px 20px;
        }

        .nav-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            position: relative;
            padding-bottom: 10px;
        }

        .nav-logo {
            order: 2;
            flex: 1 0 100%;
            text-align: center;
            margin: 10px 0;
        }

        .nav-logo img {
            height: var(--logo-height);
            max-width: 100%;
            object-fit: contain;
        }

        .nav-left {
            display: flex;
            align-items: center;
            order: 1;
            width: 100%;
            justify-content: flex-end;
        }

        .search-box {
            position: relative;
            display: flex;
            align-items: center;
            background: var(--light-gray);
            padding: 8px 15px;
            border-radius: 20px;
            width: 100%;
            max-width: 300px;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            padding: 5px;
            font-size: 14px;
            width: 100%;
            color: var(--text-color);
        }

        .search-box i {
            color: #888;
            margin-left: 8px;
            cursor: pointer;
        }

        .suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid var(--border-color);
            border-top: none;
            border-radius: 0 0 8px 8px;
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: none;
        }

        .suggestions.show {
            display: block;
        }

        .suggestion-item {
            padding: 10px 15px;
            cursor: pointer;
            transition: background-color 0.2s;
            border-bottom: 1px solid var(--light-gray);
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        .suggestion-item:hover {
            background-color: var(--hover-color);
        }

        .cart-icon {
            font-size: 18px;
            color: var(--text-color);
            text-decoration: none;
            margin-left: 20px;
            display: flex;
            align-items: center;
            padding: 8px;
        }

        .cart-icon:hover {
            color: var(--primary-color);
        }

        .nav-bottom {
            padding-top: 15px;
        }

        .nav-menu {
            list-style: none;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin: 0;
            padding: 0;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-color);
            font-size: 15px;
            font-weight: 500;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color);
        }

        .nav-link::after {
            content: "";
            display: block;
            width: 0;
            height: 2px;
            background-color: var(--primary-color);
            transition: width 0.3s;
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-logo-img {
            width: 18px;
            height: auto;
            margin-right: 8px;
            object-fit: contain;
        }

        /* Mobile menu toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: var(--text-color);
            cursor: pointer;
            padding: 10px;
        }

        @media (max-width: 768px) {
            .nav-top {
                flex-direction: row;
                align-items: center;
                padding-bottom: 0;
            }

            .nav-logo {
                order: 1;
                flex: 0 1 auto;
                margin: 0;
            }

            .nav-left {
                order: 2;
                width: auto;
                justify-content: flex-end;
            }

            .search-box {
                max-width: 200px;
            }

            .mobile-menu-toggle {
                display: block;
                order: 3;
            }

            .nav-bottom {
                display: none;
                padding-top: 10px;
            }

            .nav-bottom.active {
                display: block;
            }

            .nav-menu {
                flex-direction: column;
                align-items: center;
                gap: 5px;
            }

            .nav-link {
                padding: 8px 10px;
            }
        }

        @media (max-width: 480px) {
            .nav-container {
                padding: 10px;
            }

            .search-box {
                max-width: 150px;
                padding: 6px 10px;
            }

            .cart-icon {
                margin-left: 10px;
            }
        }
    </style>
</head>
<body>

<div class="nav-container">
    <div class="nav-top">
        <div class="nav-left">
            <div class="search-box">
                <input type="text" id="search-box" placeholder="Tìm sản phẩm hoặc thương hiệu" aria-label="Tìm kiếm sản phẩm">
                <i class="fas fa-search" id="search-icon"></i>
                <div id="suggestion-box" class="suggestions"></div>
            </div>
            <a href="/Watch_Store_Manage/pages/gio.php" class="cart-icon" aria-label="Giỏ hàng">
                <i class="fas fa-shopping-bag"></i>
            </a>
        </div>
        
        <div class="nav-logo">
            <img src="/Watch_Store_Manage/images/Logo.png" alt="Logo cửa hàng" loading="lazy">
        </div>
        
        <button class="mobile-menu-toggle" id="menu-toggle" aria-label="Menu">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="nav-bottom" id="nav-bottom">
        <nav>
            <ul class="nav-menu">
                <?php foreach ($navItems as $item): ?>
                    <li class="nav-item">
                        <a href="<?= htmlspecialchars($item['url']) ?>" class="nav-link">
                            <?php if (!empty($item['logo'])): ?>
                                <img src="<?= htmlspecialchars($item['logo']) ?>" 
                                     alt="<?= htmlspecialchars($item['name']) ?>" 
                                     class="nav-logo-img" 
                                     loading="lazy">
                            <?php endif; ?>
                            <?= htmlspecialchars($item['name']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-box');
        const suggestionBox = document.getElementById('suggestion-box');
        const menuToggle = document.getElementById('menu-toggle');
        const navBottom = document.getElementById('nav-bottom');
        const products = <?= json_encode($products) ?>;
        let debounceTimer;

        // Tìm kiếm với debounce
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const keyword = this.value.trim().toLowerCase();
                suggestionBox.innerHTML = '';
                suggestionBox.classList.remove('show');

                if (keyword.length < 2) return;

                const filtered = products.filter(p => 
                    p.name.toLowerCase().includes(keyword)
                ).slice(0, 10); // Giới hạn 10 kết quả

                if (filtered.length > 0) {
                    filtered.forEach(product => {
                        const div = document.createElement('div');
                        div.className = 'suggestion-item';
                        div.textContent = product.name;
                        div.onclick = () => {
                            window.location.href = 'infor.php?masp=' + encodeURIComponent(product.id);
                        };
                        suggestionBox.appendChild(div);
                    });
                    suggestionBox.classList.add('show');
                }
            }, 300);
        });

        // Đóng suggestion box khi click bên ngoài
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionBox.contains(e.target)) {
                suggestionBox.classList.remove('show');
            }
        });

        // Toggle mobile menu
        menuToggle.addEventListener('click', function() {
            navBottom.classList.toggle('active');
        });

        // Tìm kiếm khi nhấn Enter
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && this.value.trim()) {
                window.location.href = 'search.php?q=' + encodeURIComponent(this.value.trim());
            }
        });
    });
</script>

</body>
</html>