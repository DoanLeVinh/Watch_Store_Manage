<?php
session_start();
include("includes/header.php");
include("includes/nav.php");

// Kiểm tra nếu không có sản phẩm nào trong giỏ hàng
if (empty($_SESSION['cart'])) {
    echo '<script>window.location.href="gio.php";</script>';
exit();
}

// Xử lý khi nhấn nút đặt hàng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
    // Lấy dữ liệu từ form
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $note = $_POST['note'];
    $shipping_method = $_POST['shipping_method'];
    $payment_method = $_POST['payment_method'];
    $voucher = $_POST['voucher'];
    
    // Tính toán tổng tiền
    $subtotal = 0;
    $total_quantity = 0;
    $product_names = [];
    $product_ids = [];
    
    foreach ($_SESSION['cart'] as $item) {
        $subtotal += $item['price'] * $item['quantity'];
        $total_quantity += $item['quantity'];
        $product_names[] = $item['name'];
        $product_ids[] = $item['id'];
    }
    
    // Tính phí vận chuyển
    $shipping_fee = $shipping_method == 'standard' ? 20000 : 50000;
    
    // Tính giảm giá voucher (ví dụ 10%)
    $discount = $voucher == 'SALE10' ? $subtotal * 0.1 : 0;
    
    $total = $subtotal + $shipping_fee - $discount;
    
    // Kết nối database và lưu đơn hàng
    include('connect.php');
    
    try {
        // Tạo mã đơn hàng ngẫu nhiên
        $order_code = 'DH' . date('Ymd') . strtoupper(substr(uniqid(), -6));
        
        // Chuẩn bị tên sản phẩm và mã sản phẩm (lấy sản phẩm đầu tiên hoặc gộp tất cả)
        $first_product_name = !empty($product_names) ? $product_names[0] : '';
        $first_product_id = !empty($product_ids) ? $product_ids[0] : '';
        
        // Lưu thông tin đơn hàng vào bảng dh
        $stmt = $link->prepare("INSERT INTO dh (MaDH, HoTen, SDT, DiaChi, TenSP, MaSP, SoLuong, LoiNhan, PhuongThucVanChuyen, Voucher, TongTien, TinhTrang, NgayTao) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([
            $order_code,
            $fullname,
            $phone,
            $address,
            $first_product_name, // TenSP - lấy sản phẩm đầu tiên
            $first_product_id,   // MaSP - lấy mã sản phẩm đầu tiên
            $total_quantity,     // SoLuong - tổng số lượng sản phẩm
            $note,
            $shipping_method,
            $voucher,
            $total,
            'Chờ xác nhận'
        ]);
        
        // Xóa giỏ hàng sau khi đặt hàng thành công
        unset($_SESSION['cart']);
        
        // Chuyển hướng đến trang cảm ơn (đã sửa lỗi header)
        echo "<script>window.location.href='thanhtoan.php?success=" . urlencode($order_code) . "';</script>";
        exit();
    } catch (PDOException $e) {
        $error = "Lỗi khi đặt hàng: " . $e->getMessage();
    }
}

// Hiển thị thông báo thành công nếu có
if (isset($_GET['success'])) {
    $order_code = $_GET['success'];
    include('../includes/header.php');
    include('../includes/nav.php');
    ?>
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Đặt Hàng Thành Công - <?= htmlspecialchars($storeName) ?></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
            /* CSS cho trang thành công */
            .success-container {
                width: 90%;
                max-width: 600px;
                margin: 40px auto;
                padding: 30px;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            
            .success-icon {
                font-size: 60px;
                color: #4CAF50;
                margin-bottom: 20px;
            }
            
            .success-title {
                font-size: 24px;
                margin-bottom: 15px;
                color: #333;
            }
            
            .order-code {
                font-size: 20px;
                font-weight: bold;
                color: #2196F3;
                margin: 15px 0;
            }
            
            .success-message {
                margin-bottom: 25px;
                color: #555;
                line-height: 1.6;
            }
            
            .btn-home {
                display: inline-block;
                padding: 12px 24px;
                background-color: #2196F3;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                font-weight: 500;
                transition: all 0.3s;
            }
            
            .btn-home:hover {
                background-color: #0b7dda;
                transform: translateY(-2px);
            }
        </style>
    </head>
    <body>
        <div class="success-container">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1 class="success-title">Đặt Hàng Thành Công!</h1>
            <p class="success-message">
                Cảm ơn bạn đã đặt hàng tại cửa hàng chúng tôi. Đơn hàng của bạn đã được tiếp nhận và đang được xử lý.
            </p>
            <div class="order-code">
                Mã đơn hàng: <?= htmlspecialchars($order_code) ?>
            </div>
            <p>
                Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất để xác nhận đơn hàng.
            </p>
            <a href="../index.php" class="btn-home">
                <i class="fas fa-home"></i> Về trang chủ
            </a>
        </div>
    </body>
    </html>
    <?php
    include('../includes/footer.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán - <?= htmlspecialchars($storeName) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #6b7280;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --light-gray: #f3f4f6;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
        }
        
        .checkout-container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        @media (min-width: 992px) {
            .checkout-container {
                grid-template-columns: 1fr 350px;
            }
        }
        
        .checkout-section {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 20px;
        }
        
        .section-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title i {
            color: var(--primary-color);
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #334155;
        }
        
        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e2e8f0;
            border-radius: var(--border-radius);
            font-size: 14px;
            transition: border-color 0.2s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
        }
        
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        
        .radio-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .radio-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .radio-option:hover {
            border-color: var(--primary-color);
        }
        
        .radio-option input[type="radio"] {
            margin: 0;
        }
        
        .radio-option.active {
            border-color: var(--primary-color);
            background-color: rgba(37, 99, 235, 0.05);
        }
        
        .radio-label {
            flex: 1;
        }
        
        .radio-icon {
            font-size: 20px;
            color: var(--secondary-color);
        }
        
        .voucher-input {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        
        .voucher-input input {
            flex: 1;
        }
        
        .btn {
            padding: 12px 20px;
            border-radius: var(--border-radius);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }
        
        .btn-block {
            width: 100%;
        }
        
        .order-summary-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .order-summary-item:last-child {
            border-bottom: none;
        }
        
        .order-summary-title {
            font-weight: 600;
            color: #334155;
        }
        
        .order-total {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .product-list {
            margin: 15px 0;
        }
        
        .product-item {
            display: flex;
            gap: 15px;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .product-item:last-child {
            border-bottom: none;
        }
        
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }
        
        .product-info {
            flex: 1;
        }
        
        .product-name {
            font-weight: 500;
            margin-bottom: 5px;
        }
        
        .product-price {
            color: var(--secondary-color);
            font-size: 14px;
        }
        
        .product-quantity {
            color: var(--secondary-color);
            font-size: 14px;
        }
        
        .error-message {
            color: var(--danger-color);
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }
        
        .confirmation-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background-color: white;
            border-radius: var(--border-radius);
            width: 90%;
            max-width: 500px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            animation: modalFadeIn 0.3s;
        }
        
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .modal-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .modal-message {
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .modal-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        
        .btn-cancel {
            background-color: var(--light-gray);
            color: var(--secondary-color);
        }
        
        .btn-confirm {
            background-color: var(--success-color);
            color: white;
        }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            .checkout-container {
                grid-template-columns: 1fr;
            }
            
            .section-title {
                font-size: 18px;
            }
            
            .product-img {
                width: 50px;
                height: 50px;
            }
        }
    </style>
</head>
<body>

<div class="checkout-container">
    <!-- Phần thông tin khách hàng -->
    <div class="checkout-section">
        <h2 class="section-title"><i class="fas fa-user"></i> Thông tin khách hàng</h2>
        
        <?php if (isset($error)): ?>
        <div style="color: red; margin-bottom: 15px;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form id="checkoutForm" method="POST">
            <div class="form-group">
                <label for="fullname">Họ và tên *</label>
                <input type="text" id="fullname" name="fullname" class="form-control" required>
                <div class="error-message" id="fullname-error">Vui lòng nhập họ tên</div>
            </div>
            
            <div class="form-group">
                <label for="phone">Số điện thoại *</label>
                <input type="tel" id="phone" name="phone" class="form-control" required>
                <div class="error-message" id="phone-error">Vui lòng nhập số điện thoại hợp lệ</div>
            </div>
            
            <div class="form-group">
                <label for="address">Địa chỉ nhận hàng *</label>
                <textarea id="address" name="address" class="form-control" required></textarea>
                <div class="error-message" id="address-error">Vui lòng nhập địa chỉ</div>
            </div>
            
            <div class="form-group">
                <label for="note">Lời nhắn (nếu có)</label>
                <textarea id="note" name="note" class="form-control"></textarea>
            </div>
            
            <h2 class="section-title"><i class="fas fa-truck"></i> Phương thức vận chuyển</h2>
            <div class="radio-group">
                <label class="radio-option">
                    <input type="radio" name="shipping_method" value="standard" checked>
                    <div class="radio-label">
                        <div>Giao hàng tiêu chuẩn</div>
                        <small>Nhận hàng trong 3-5 ngày</small>
                    </div>
                    <div class="radio-price">20.000 ₫</div>
                </label>
                
                <label class="radio-option">
                    <input type="radio" name="shipping_method" value="express">
                    <div class="radio-label">
                        <div>Giao hàng nhanh</div>
                        <small>Nhận hàng trong 1-2 ngày</small>
                    </div>
                    <div class="radio-price">50.000 ₫</div>
                </label>
            </div>
            
            <h2 class="section-title"><i class="fas fa-credit-card"></i> Phương thức thanh toán</h2>
            <div class="radio-group">
                <label class="radio-option active">
                    <input type="radio" name="payment_method" value="cod" checked>
                    <i class="fas fa-money-bill-wave radio-icon"></i>
                    <div class="radio-label">Thanh toán khi nhận hàng (COD)</div>
                </label>
                
                <label class="radio-option">
                    <input type="radio" name="payment_method" value="banking">
                    <i class="fas fa-university radio-icon"></i>
                    <div class="radio-label">Chuyển khoản ngân hàng</div>
                </label>
            </div>
            
            <h2 class="section-title"><i class="fas fa-tag"></i> Mã giảm giá</h2>
            <div class="form-group">
                <label for="voucher">Nhập mã giảm giá (nếu có)</label>
                <div class="voucher-input">
                    <input type="text" id="voucher" name="voucher" class="form-control" placeholder="Ví dụ: SALE10">
                    <button type="button" id="applyVoucher" class="btn btn-outline">Áp dụng</button>
                </div>
                <div id="voucher-message" style="margin-top: 5px; font-size: 14px;"></div>
            </div>
            
            <input type="hidden" name="place_order" value="1">
        </form>
    </div>
    
    <!-- Phần tóm tắt đơn hàng -->
    <div class="checkout-section">
        <h2 class="section-title"><i class="fas fa-shopping-bag"></i> Đơn hàng của bạn</h2>
        
        <div class="product-list">
            <?php 
            $subtotal = 0;
            foreach ($_SESSION['cart'] as $item): 
                $total = $item['price'] * $item['quantity'];
                $subtotal += $total;
            ?>
            <div class="product-item">
                <img src="<?= htmlspecialchars($item['img']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="product-img">
                <div class="product-info">
                    <div class="product-name"><?= htmlspecialchars($item['name']) ?></div>
                    <div class="product-price"><?= number_format($item['price'], 0, ',', '.') ?> ₫</div>
                </div>
                <div class="product-quantity">x<?= htmlspecialchars($item['quantity']) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="order-summary">
            <div class="order-summary-item">
                <span>Tạm tính:</span>
                <span id="subtotal"><?= number_format($subtotal, 0, ',', '.') ?> ₫</span>
            </div>
            <div class="order-summary-item">
                <span>Phí vận chuyển:</span>
                <span id="shipping-fee">20.000 ₫</span>
            </div>
            <div class="order-summary-item">
                <span>Giảm giá:</span>
                <span id="discount">0 ₫</span>
            </div>
            <div class="order-summary-item order-total">
                <span>Tổng cộng:</span>
                <span id="total"><?= number_format($subtotal + 20000, 0, ',', '.') ?> ₫</span>
            </div>
        </div>
        
        <button type="button" id="placeOrderBtn" class="btn btn-primary btn-block">
            <i class="fas fa-shopping-bag"></i> Đặt hàng
        </button>
    </div>
</div>

<!-- Modal xác nhận đặt hàng -->
<div class="confirmation-modal" id="confirmationModal">
    <div class="modal-content">
        <h3 class="modal-title"><i class="fas fa-check-circle"></i> Xác nhận đặt hàng</h3>
        <div class="modal-message">
            Bạn có chắc chắn muốn đặt hàng? Sau khi xác nhận, đơn hàng sẽ được xử lý và chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.
        </div>
        <div class="modal-actions">
            <button type="button" id="cancelOrderBtn" class="btn btn-cancel">Hủy bỏ</button>
            <button type="button" id="confirmOrderBtn" class="btn btn-confirm">Xác nhận</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý áp dụng voucher
    const applyVoucherBtn = document.getElementById('applyVoucher');
    const voucherInput = document.getElementById('voucher');
    const voucherMessage = document.getElementById('voucher-message');
    const discountElement = document.getElementById('discount');
    const totalElement = document.getElementById('total');
    const subtotalElement = document.getElementById('subtotal');
    const shippingFeeElement = document.getElementById('shipping-fee');
    
    let discount = 0;
    let subtotal = <?= $subtotal ?>;
    let shippingFee = 20000;
    
    applyVoucherBtn.addEventListener('click', function() {
        const voucherCode = voucherInput.value.trim();
        
        // Kiểm tra voucher (ví dụ đơn giản)
        if (voucherCode === 'SALE10') {
            discount = subtotal * 0.1; // Giảm 10%
            voucherMessage.textContent = 'Áp dụng thành công giảm 10% cho đơn hàng!';
            voucherMessage.style.color = 'green';
        } else if (voucherCode === 'FREESHIP') {
            shippingFee = 0;
            voucherMessage.textContent = 'Áp dụng thành công miễn phí vận chuyển!';
            voucherMessage.style.color = 'green';
        } else if (voucherCode === '') {
            discount = 0;
            shippingFee = 20000;
            voucherMessage.textContent = 'Đã bỏ áp dụng voucher';
            voucherMessage.style.color = 'inherit';
        } else {
            voucherMessage.textContent = 'Mã voucher không hợp lệ hoặc đã hết hạn';
            voucherMessage.style.color = 'red';
            return;
        }
        
        // Cập nhật hiển thị
        discountElement.textContent = discount.toLocaleString('vi-VN') + ' ₫';
        shippingFeeElement.textContent = shippingFee.toLocaleString('vi-VN') + ' ₫';
        totalElement.textContent = (subtotal + shippingFee - discount).toLocaleString('vi-VN') + ' ₫';
    });
    
    // Xử lý thay đổi phương thức vận chuyển
    const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
    shippingRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            shippingFee = this.value === 'standard' ? 20000 : 50000;
            shippingFeeElement.textContent = shippingFee.toLocaleString('vi-VN') + ' ₫';
            totalElement.textContent = (subtotal + shippingFee - discount).toLocaleString('vi-VN') + ' ₫';
        });
    });
    
    // Xử lý validate form
    const checkoutForm = document.getElementById('checkoutForm');
    const fullnameInput = document.getElementById('fullname');
    const phoneInput = document.getElementById('phone');
    const addressInput = document.getElementById('address');
    
    function validateForm() {
        let isValid = true;
        
        // Validate họ tên
        if (fullnameInput.value.trim() === '') {
            document.getElementById('fullname-error').style.display = 'block';
            isValid = false;
        } else {
            document.getElementById('fullname-error').style.display = 'none';
        }
        
        // Validate số điện thoại
        const phoneRegex = /(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b/;
        if (!phoneRegex.test(phoneInput.value.trim())) {
            document.getElementById('phone-error').style.display = 'block';
            isValid = false;
        } else {
            document.getElementById('phone-error').style.display = 'none';
        }
        
        // Validate địa chỉ
        if (addressInput.value.trim() === '') {
            document.getElementById('address-error').style.display = 'block';
            isValid = false;
        } else {
            document.getElementById('address-error').style.display = 'none';
        }
        
        return isValid;
    }
    
    // Xử lý nút đặt hàng
    const placeOrderBtn = document.getElementById('placeOrderBtn');
    const confirmationModal = document.getElementById('confirmationModal');
    const cancelOrderBtn = document.getElementById('cancelOrderBtn');
    const confirmOrderBtn = document.getElementById('confirmOrderBtn');
    
    placeOrderBtn.addEventListener('click', function() {
        if (validateForm()) {
            confirmationModal.style.display = 'flex';
        }
    });
    
    cancelOrderBtn.addEventListener('click', function() {
        confirmationModal.style.display = 'none';
    });
    
    confirmOrderBtn.addEventListener('click', function() {
        checkoutForm.submit();
    });
    
    // Đóng modal khi click bên ngoài
    confirmationModal.addEventListener('click', function(e) {
        if (e.target === confirmationModal) {
            confirmationModal.style.display = 'none';
        }
    });
});
</script>
<?php include('includes/footer.php');?>
</body>
</html>