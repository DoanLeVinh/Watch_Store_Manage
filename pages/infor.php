<?php 
session_start();
include('includes/header.php');
include('includes/nav.php');
include('connect.php');

// Kiểm tra giỏ hàng
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$masp = $_GET['masp'] ?? '';

if ($masp) {
    // Sử dụng prepared statement để tránh SQL injection
    $sql = "SELECT * FROM dongho_nam WHERE Ma = ? 
            UNION
            SELECT * FROM dongho_nu WHERE Ma = ? 
            UNION
            SELECT * FROM trangsuc WHERE Ma = ?";
    
    $stmt = $link->prepare($sql);
    $stmt->bind_param("sss", $masp, $masp, $masp);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    
    if (!$product) {
        echo "<div class='error-message'>Không tìm thấy sản phẩm!</div>";
        include('includes/footer.php');
        exit;
    }
} else {
    echo "<div class='error-message'>Không có mã sản phẩm!</div>";
    include('includes/footer.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['TenSP']); ?> - Chi tiết sản phẩm</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ff6a00;
            --primary-hover: #e55a00;
            --secondary-color: #333;
            --text-color: #555;
            --light-bg: #f9f9f9;
            --white: #fff;
            --shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
            line-height: 1.6;
        }

        /* Error message */
        .error-message {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: var(--white);
            box-shadow: var(--shadow);
            border-radius: var(--border-radius);
            text-align: center;
            color: #d9534f;
            font-weight: 500;
        }

        /* Product container */
        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 20px;
            max-width: 1200px;
            margin: 40px auto;
            background-color: var(--white);
            box-shadow: var(--shadow);
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        /* Product images */
        .product-images {
            flex: 1 1 50%;
            min-width: 300px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .product-images img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
        }

        .product-images img:hover {
            transform: scale(1.02);
            opacity: 0.9;
        }

        /* Main product image */
        .main-image {
            grid-column: span 2;
            height: 350px;
        }

        /* Product details */
        .product-details {
            flex: 1 1 45%;
            min-width: 300px;
            padding: 0 20px;
        }

        .product-details h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .product-description {
            color: var(--text-color);
            margin: 1.5rem 0;
            text-align: justify;
        }

        .price {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 1.5rem 0;
        }

        /* Add to cart button */
        .add-to-cart {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px 25px;
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            width: 100%;
            margin: 1.5rem 0;
            transition: var(--transition);
        }

        .add-to-cart:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
        }

        .add-to-cart i {
            font-size: 1.2rem;
        }

        /* Product info */
        .product-info {
            margin-top: 2rem;
            background-color: var(--light-bg);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .product-info h3 {
            margin-bottom: 1rem;
            color: var(--secondary-color);
            font-size: 1.2rem;
            font-weight: 600;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid #eee;
        }

        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .info-row label {
            font-weight: 600;
            color: var(--secondary-color);
        }

        /* Quantity selector */
        .quantity-selector {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            background-color: #f0f0f0;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .quantity-btn:hover {
            background-color: #e0e0e0;
        }

        .quantity-input {
            width: 60px;
            height: 40px;
            text-align: center;
            border: 1px solid #ddd;
            margin: 0 5px;
            font-size: 1rem;
        }

        /* Toast notification */
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 15px 25px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            z-index: 1000;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .product-container {
                flex-direction: column;
                margin: 20px 10px;
                padding: 15px;
            }

            .product-images {
                grid-template-columns: 1fr;
            }

            .main-image {
                grid-column: span 1;
            }

            .product-details {
                padding: 0;
                margin-top: 20px;
            }

            .product-details h1 {
                font-size: 1.5rem;
            }

            .price {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .product-images img {
                height: 200px;
            }

            .main-image {
                height: 250px;
            }

            .add-to-cart {
                padding: 12px 20px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

    <div class="product-container">
        <!-- Product Images -->
        <div class="product-images">
            <img src="<?php echo htmlspecialchars($product['Hinhanh']); ?>" alt="<?php echo htmlspecialchars($product['TenSP']); ?>" class="main-image">
            <img src="<?php echo htmlspecialchars($product['Hinhanh']); ?>" alt="<?php echo htmlspecialchars($product['TenSP']); ?>">
            <img src="<?php echo htmlspecialchars($product['Hinhanh']); ?>" alt="<?php echo htmlspecialchars($product['TenSP']); ?>">
        </div>
        
        <!-- Product Details -->
        <div class="product-details">
            <h1><?php echo htmlspecialchars($product['TenSP']); ?></h1>
            <p class="product-description"><?php echo htmlspecialchars($product['Content']); ?></p>
            
            <div class="price"><?php echo number_format($product['Gia'], 0, ',', '.'); ?> đ</div>
            
            <!-- Quantity Selector -->
            <div class="quantity-selector">
                <button class="quantity-btn minus">-</button>
                <input type="number" class="quantity-input" value="1" min="1">
                <button class="quantity-btn plus">+</button>
            </div>
            
            <button class="add-to-cart" 
                data-img="<?php echo htmlspecialchars($product['Hinhanh']); ?>" 
                data-id="<?php echo htmlspecialchars($product['Ma']); ?>" 
                data-name="<?php echo htmlspecialchars($product['TenSP']); ?>" 
                data-price="<?php echo htmlspecialchars($product['Gia']); ?>">
                <i class="fas fa-shopping-cart"></i> THÊM VÀO GIỎ HÀNG
            </button>
            
            <div class="product-info">
                <h3>Thông tin sản phẩm</h3>
                <div class="info-row">
                    <label>Xuất xứ:</label>
                    <span><?php echo htmlspecialchars($product['Xuatxu']); ?></span>
                </div>
                <div class="info-row">
                    <label>Giới tính:</label>
                    <span><?php echo ucfirst(htmlspecialchars($product['sex'])); ?></span>
                </div>
                <div class="info-row">
                    <label>Mã sản phẩm:</label>
                    <span><?php echo htmlspecialchars($product['Ma']); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast"></div>

    <script>
        // Quantity selector functionality
        document.querySelector('.minus').addEventListener('click', function() {
            const input = document.querySelector('.quantity-input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        });

        document.querySelector('.plus').addEventListener('click', function() {
            const input = document.querySelector('.quantity-input');
            input.value = parseInt(input.value) + 1;
        });

        // Add to cart with AJAX
        document.querySelector('.add-to-cart').addEventListener('click', function() {
            const productImg = this.getAttribute('data-img');
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            const productPrice = this.getAttribute('data-price');
            const quantity = document.querySelector('.quantity-input').value;
            
            // Show loading state
            const button = this;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ĐANG THÊM...';
            button.disabled = true;
            
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_img=${encodeURIComponent(productImg)}&product_id=${encodeURIComponent(productId)}&product_name=${encodeURIComponent(productName)}&product_price=${encodeURIComponent(productPrice)}&quantity=${encodeURIComponent(quantity)}`
            })
            .then(response => response.text())
            .then(data => {
                // Show toast notification
                const toast = document.getElementById('toast');
                toast.textContent = data;
                toast.classList.add('show');
                
                // Reset button state
                button.innerHTML = '<i class="fas fa-shopping-cart"></i> THÊM VÀO GIỎ HÀNG';
                button.disabled = false;
                
                // Hide toast after 3 seconds
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            })
            .catch(error => {
                console.error('Error:', error);
                button.innerHTML = '<i class="fas fa-exclamation-triangle"></i> LỖI';
                setTimeout(() => {
                    button.innerHTML = '<i class="fas fa-shopping-cart"></i> THÊM VÀO GIỎ HÀNG';
                    button.disabled = false;
                }, 2000);
            });
        });

        // Image gallery interaction
        const images = document.querySelectorAll('.product-images img');
        const mainImage = document.querySelector('.main-image');
        
        images.forEach(img => {
            img.addEventListener('click', function() {
                // Swap images
                const tempSrc = mainImage.src;
                mainImage.src = this.src;
                this.src = tempSrc;
                
                // Add animation
                mainImage.style.opacity = '0';
                setTimeout(() => {
                    mainImage.style.opacity = '1';
                }, 100);
            });
        });
    </script>

    <?php include('includes/footer.php'); ?>
</body>
</html>