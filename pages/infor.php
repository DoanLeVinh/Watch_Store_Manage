<?php 
session_start(); // Start session at the very beginning

include('includes/header.php');  // Kế thừa phần header
include('includes/nav.php');     // Kế thừa phần nav
?>
 <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

 <?php
include('connect.php');          // Bao gồm kết nối cơ sở dữ liệu

// Kiểm tra xem giỏ hàng có tồn tại trong session không
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Lấy mã sản phẩm từ yêu cầu GET
$masp = $_GET['masp'] ?? '';  // Nếu có tham số masp trong URL thì lấy giá trị, nếu không có thì để trống

// Kiểm tra nếu có mã sản phẩm
if ($masp) {
    // Truy vấn chi tiết sản phẩm từ cơ sở dữ liệu
    $sql = "SELECT * FROM dongho_nam WHERE Ma = ? 
            UNION
            SELECT * FROM dongho_nu WHERE Ma = ? 
            UNION
            SELECT * FROM trangsuc WHERE Ma = ?";
    
    $stmt = $link->prepare($sql);
    $stmt->bind_param("sss", $masp, $masp, $masp);  // Liên kết tham số masp với truy vấn
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();  // Lấy thông tin sản phẩm đầu tiên
    
    // Nếu không có sản phẩm, hiển thị thông báo
    if (!$product) {
        echo "Không tìm thấy sản phẩm!";
        exit;
    }
} else {
    echo "Không có mã sản phẩm!";
    exit;
}
?>
    <title>Sản phẩm - Chi tiết</title>
    <style>
         body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .product-container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .product-images {
            flex: 1;
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 cột */
            gap: 20px;
            max-width: 50%;
        }

        .product-images img {
            width: 100%;
            object-fit: cover;
            border-radius: 10px;
            height: 250px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .product-images img:hover {
            transform: scale(1.05);
        }

        .product-details {
            flex: 1;
            padding-left: 30px;
            max-width: 45%;
        }

        .product-details h1 {
            font-size: 28px;
            font-weight: 500;
            color: #333;
        }

        .product-details p {
            color: #555;
            margin: 10px 0;
            font-size: 16px;
            line-height: 1.6;
        }

        .price {
            font-size: 24px;
            font-weight: 600;
            color: #ff6a00;
            margin: 20px 0;
        }

        .add-to-cart {
            padding: 10px 20px;
            background-color: #ff6a00;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .add-to-cart:hover {
            background-color: #e55a00;
        }

        .product-info {
            margin-top: 20px;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }

        .product-info h3 {
            margin-top: 0;
            color: #333;
            font-size: 18px;
        }

        .product-info .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .info-row label {
            font-weight: 600;
            color: #333;
        }

        .info-row span {
            color: #555;
        }

        @media (max-width: 768px) {
            .product-container {
                flex-direction: column;
                align-items: center;
            }

            .product-details {
                padding-left: 0;
                margin-top: 20px;
                max-width: 100%;
            }

            .product-images {
                grid-template-columns: repeat(1, 1fr);
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="product-container">
        <!-- Product Images -->
        <div class="product-images">
            <img src="<?php echo $product['Hinhanh']; ?>" alt="Sản phẩm 1">
            <img src="<?php echo $product['Hinhanh']; ?>" alt="Sản phẩm 2">
            <img src="<?php echo $product['Hinhanh']; ?>" alt="Sản phẩm 3">
            <img src="<?php echo $product['Hinhanh']; ?>" alt="Sản phẩm 4">
        </div>
        
        <!-- Product Details -->
        <div class="product-details">
            <h1><?php echo $product['TenSP']; ?></h1>
            <p><?php echo $product['Content']; ?></p>
            
            <div class="price"><?php echo number_format($product['Gia'], 0, ',', '.'); ?> đ</div>
            <button class="add-to-cart" 
                data-img="<?php echo htmlspecialchars($product['Hinhanh']); ?>" 
                data-id="<?php echo htmlspecialchars($product['Ma']); ?>" 
                data-name="<?php echo htmlspecialchars($product['TenSP']); ?>" 
                data-price="<?php echo htmlspecialchars($product['Gia']); ?>">
            THÊM VÀO GIỎ HÀNG
            </button>
            
            <div class="product-info">
                <h3>Thông tin sản phẩm</h3>
                <div class="info-row">
                    <label>Xuất xứ:</label>
                    <span><?php echo $product['Xuatxu']; ?></span>
                </div>
                <div class="info-row">
                    <label>Giới tính:</label>
                    <span><?php echo ucfirst($product['sex']); ?></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('.add-to-cart').addEventListener('click', function() {
            const productImg = this.getAttribute('data-img');
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            const productPrice = this.getAttribute('data-price');
            
            // Gửi thông tin sản phẩm đến giỏ hàng
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'add_to_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert(xhr.responseText);  // Hiển thị thông báo từ PHP
                }
            };
            
            // Gửi thông tin sản phẩm qua phương thức POST
            xhr.send('product_img=' + productImg + '&product_id=' + productId + '&product_name=' + productName + '&product_price=' + productPrice);
        });
    </script>

    <?php include('includes/footer.php'); ?>

</body>
</html>
