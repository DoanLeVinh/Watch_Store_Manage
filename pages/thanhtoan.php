<?php 
ob_start(); // Bật output buffering ngay từ đầu
session_start();
require_once('includes/header.php');
require_once('includes/nav.php');
require_once('connect.php');

// Kiểm tra kết nối database
if (!$link) {
    die("<script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi hệ thống',
                text: 'Không thể kết nối đến cơ sở dữ liệu. Vui lòng thử lại sau.',
                confirmButtonText: 'Đóng'
            }).then(() => {
                window.location.href='index.php';
            });
         </script>");
}

// Kiểm tra giỏ hàng
if (empty($_SESSION['cart'])) {
    echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Giỏ hàng trống!',
                text: 'Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán',
                confirmButtonText: 'Mua sắm ngay',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href='san-pham.php';
                }
            });
          </script>";
    exit;
}

// Xử lý dữ liệu giỏ hàng
$cartItems = $_SESSION['cart'];
$totalPrice = 0;
$productNames = [];

foreach ($cartItems as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
    $productNames[] = $item['name'];
}

$productList = implode(", ", $productNames);

// Phí vận chuyển
$shippingCost = 20000; // Mặc định
$shippingMethod = 'economy';
if (!empty($_POST['shipping'])) {
    $shippingMethod = $_POST['shipping'];
    $shippingCost = [
        'economy' => 20000,
        'fast' => 50000,
        'express' => 100000
    ][$shippingMethod] ?? 20000;
}

// Xử lý voucher
$voucherDiscount = 0;
$voucher = $_POST['voucher'] ?? 'none';
$voucherText = 'Không sử dụng voucher';

if ($voucher === '10off') {
    $voucherDiscount = $totalPrice * 0.1;
    $voucherText = 'Giảm 10% tổng đơn';
} elseif ($voucher === 'freedelivery') {
    $shippingCost = 0;
    $voucherText = 'Miễn phí vận chuyển';
}

$totalAmount = $totalPrice - $voucherDiscount + $shippingCost;

// Xử lý đặt hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    // Lấy và validate dữ liệu
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $note = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_STRING) ?? '';
    $paymentMethod = $_POST['payment_method'] ?? 'cod';
    
    // Biến để kiểm tra lỗi
    $hasError = false;
    $errorMessage = '';

    // Validate bắt buộc
    if (empty($name) || empty($phone) || empty($address)) {
        $hasError = true;
        $errorMessage = 'Vui lòng điền đầy đủ thông tin bắt buộc';
    } 
    // Validate số điện thoại
    elseif (!preg_match('/^(0|\+84)[1-9][0-9]{8}$/', $phone)) {
        $hasError = true;
        $errorMessage = 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại đúng định dạng Việt Nam';
    }
    
    if ($hasError) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: '".addslashes($errorMessage)."',
                    confirmButtonText: 'Đóng'
                }).then(() => {
                    window.scrollTo({top: 0, behavior: 'smooth'});
                });
              </script>";
    } else {
        // Lưu đơn hàng vào database
        try {
            $link->begin_transaction();
            
            $sql = "INSERT INTO dh (HoTen, SDT, DiaChi, TenSP, TongTien, PhuongThucVanChuyen, Voucher, LoiNhan, TinhTrang, NgayDat, PhuongThucThanhToan) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Chờ xác nhận', NOW(), ?)";
            
            $stmt = $link->prepare($sql);
            
            if (!$stmt) {
                throw new Exception("Lỗi chuẩn bị câu lệnh: " . $link->error);
            }
            
            $totalAmountStr = number_format($totalAmount, 2, '.', '');
            
            $stmt->bind_param(
                "ssssdssss", 
                $name, 
                $phone, 
                $address, 
                $productList, 
                $totalAmountStr,
                $shippingMethod, 
                $voucher, 
                $note,
                $paymentMethod
            );
            
            if (!$stmt->execute()) {
                throw new Exception("Lỗi thực thi câu lệnh: " . $stmt->error);
            }
            
            $orderId = $link->insert_id;
            $link->commit();
            
            // Xóa giỏ hàng
            unset($_SESSION['cart']);
            
            // Tạo HTML thông báo thành công
            $successHTML = addslashes('
                <div class="text-left">
                    <div class="mb-3">
                        <h3 class="text-lg font-semibold text-blue-600">Thông tin đơn hàng</h3>
                        <p><strong>Mã đơn hàng:</strong> #'.$orderId.'</p>
                        <p><strong>Người nhận:</strong> '.$name.'</p>
                        <p><strong>SĐT:</strong> '.$phone.'</p>
                        <p><strong>Địa chỉ:</strong> '.$address.'</p>
                    </div>
                    <div class="mt-4 pt-4 border-t">
                        <p class="text-lg font-bold text-right">
                            <strong>Tổng thanh toán:</strong> '.number_format($totalAmount, 0, ',', '.').'₫
                        </p>
                    </div>
                </div>
            ');
            
            // Xóa mọi output trước đó
            ob_clean();
            
            echo <<<HTML
            <!DOCTYPE html>
            <html>
            <head>
                <title>Đặt hàng thành công</title>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            </head>
            <body>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Đặt hàng thành công!',
                            html: '$successHTML',
                            confirmButtonText: 'Về trang chủ',
                            allowOutsideClick: false,
                            customClass: {
                                popup: 'rounded-lg',
                                confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded'
                            }
                        }).then(() => {
                            window.location.href = 'index.php';
                        });
                    });
                </script>
            </body>
            </html>
HTML;
            exit;
            
        } catch (Exception $e) {
            $link->rollback();
            
            error_log("[".date('Y-m-d H:i:s')."] Lỗi đặt hàng: " . $e->getMessage());
            
            $errorDetail = "Mã lỗi: " . substr(md5(microtime()), 0, 8);
            $errorHTML = addslashes('
                <div class="text-left">
                    <p>Đã xảy ra lỗi khi xử lý đơn hàng. Vui lòng thử lại sau.</p>
                    <p class="mt-2 text-sm text-gray-600">Nếu lỗi vẫn tiếp diễn, vui lòng cung cấp mã lỗi sau cho bộ phận hỗ trợ:</p>
                    <p class="text-sm font-mono bg-gray-100 p-2 rounded mt-1">'.$errorDetail.'</p>
                </div>
            ');
            
            ob_clean();
            echo <<<HTML
            <!DOCTYPE html>
            <html>
            <head>
                <title>Lỗi đặt hàng</title>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            </head>
            <body>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi hệ thống',
                            html: '$errorHTML',
                            confirmButtonText: 'Đóng',
                            customClass: {
                                popup: 'rounded-lg',
                                confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded'
                            }
                        });
                    });
                </script>
            </body>
            </html>
HTML;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            if (isset($link) && !$link->connect_errno) {
                $link->close();
            }
        }
    }
}

// Phần còn lại của HTML và JavaScript giữ nguyên như bạn đã cung cấp
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán - <?= htmlspecialchars($storeName) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
       :root {
            --primary-color: #2563eb;
            --secondary-color: #3b82f6;
            --danger-color: #dc2626;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
            --gray-color: #64748b;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f5f9;
            color: var(--dark-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .checkout-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .checkout-header h1 {
            font-size: 28px;
            color: var(--dark-color);
            margin-bottom: 10px;
        }

        .checkout-header .steps {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .checkout-header .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .checkout-header .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--secondary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 8px;
            z-index: 1;
        }

        .checkout-header .step.active .step-number {
            background-color: var(--primary-color);
        }

        .checkout-header .step.completed .step-number {
            background-color: var(--success-color);
        }

        .checkout-header .step-line {
            position: absolute;
            top: 20px;
            left: 50px;
            right: -50px;
            height: 2px;
            background-color: #cbd5e1;
            z-index: 0;
        }

        .checkout-header .step.completed .step-line {
            background-color: var(--success-color);
        }

        .checkout-header .step-label {
            font-size: 14px;
            color: var(--gray-color);
        }

        .checkout-header .step.active .step-label {
            color: var(--dark-color);
            font-weight: 500;
        }

        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
        }

        .checkout-form {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--box-shadow);
        }

        .checkout-summary {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--box-shadow);
            position: sticky;
            top: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--dark-color);
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-color);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #cbd5e1;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%232563eb' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
        }

        .cart-items {
            margin-bottom: 20px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 15px;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-name {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .cart-item-price {
            color: var(--gray-color);
            font-size: 14px;
        }

        .cart-item-quantity {
            font-weight: 500;
            color: var(--dark-color);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .summary-label {
            color: var(--gray-color);
        }

        .summary-value {
            font-weight: 500;
        }

        .summary-total {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-color);
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            border-radius: var(--border-radius);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            font-size: 16px;
            width: 100%;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            transform: translateY(-2px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .payment-methods {
            margin-top: 20px;
        }

        .payment-method {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 1px solid #e2e8f0;
            border-radius: var(--border-radius);
            margin-bottom: 10px;
            cursor: pointer;
            transition: var(--transition);
        }

        .payment-method:hover {
            border-color: var(--primary-color);
        }

        .payment-method.active {
            border-color: var(--primary-color);
            background-color: #eff6ff;
        }

        .payment-method-icon {
            width: 40px;
            height: 40px;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f1f5f9;
            border-radius: 50%;
        }

        .payment-method-info {
            flex: 1;
        }

        .payment-method-name {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .payment-method-desc {
            font-size: 13px;
            color: var(--gray-color);
        }

        /* Responsive styles */
        @media (max-width: 992px) {
            .checkout-grid {
                grid-template-columns: 1fr;
            }
            
            .checkout-summary {
                position: static;
                margin-top: 30px;
            }
        }

        @media (max-width: 768px) {
            .checkout-header .steps {
                gap: 10px;
            }
            
            .checkout-header .step-line {
                left: 30px;
                right: -30px;
            }
            
            .checkout-header .step-label {
                font-size: 12px;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding: 15px;
            }
            
            .checkout-header h1 {
                font-size: 24px;
            }
            
            .checkout-header .steps {
                flex-wrap: wrap;
            }
            
            .checkout-header .step {
                width: 50%;
                margin-bottom: 20px;
            }
            
            .checkout-header .step-line {
                display: none;
            }
            
            .checkout-form, .checkout-summary {
                padding: 20px;
            }
            
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .cart-item-img {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="checkout-header fade-in">
        <h1>Thanh Toán Đơn Hàng</h1>
        <div class="steps">
            <div class="step completed">
                <div class="step-number">1</div>
                <div class="step-line"></div>
                <div class="step-label">Giỏ hàng</div>
            </div>
            <div class="step active">
                <div class="step-number">2</div>
                <div class="step-line"></div>
                <div class="step-label">Thông tin thanh toán</div>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-label">Hoàn tất đơn hàng</div>
            </div>
        </div>
    </div>

    <form id="checkoutForm" method="POST" class="checkout-grid fade-in">
        <div class="checkout-form">
            <h2 class="section-title">Thông tin giao hàng</h2>
            
            <div class="form-group">
                <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name" class="form-control" required 
                       value="<?= !empty($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                <input type="tel" id="phone" name="phone" class="form-control" required
                       value="<?= !empty($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="address" class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                <input type="text" id="address" name="address" class="form-control" required
                       value="<?= !empty($_POST['address']) ? htmlspecialchars($_POST['address']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="note" class="form-label">Ghi chú (tuỳ chọn)</label>
                <textarea id="note" name="note" class="form-control" rows="3"><?= !empty($_POST['note']) ? htmlspecialchars($_POST['note']) : '' ?></textarea>
            </div>
            
            <h2 class="section-title" style="margin-top: 30px;">Phương thức vận chuyển</h2>
            
            <div class="form-group">
                <select id="shipping" name="shipping" class="form-control form-select" onchange="updateOrderSummary()">
                    <option value="economy" <?= ($shippingMethod === 'economy') ? 'selected' : '' ?>>Giao hàng tiết kiệm - 20.000₫ (3-5 ngày)</option>
                    <option value="fast" <?= ($shippingMethod === 'fast') ? 'selected' : '' ?>>Giao hàng nhanh - 50.000₫ (1-2 ngày)</option>
                    <option value="express" <?= ($shippingMethod === 'express') ? 'selected' : '' ?>>Giao hàng hỏa tốc - 100.000₫ (Trong ngày)</option>
                </select>
            </div>
            
            <h2 class="section-title">Mã giảm giá</h2>
            
            <div class="form-group">
                <select id="voucher" name="voucher" class="form-control form-select" onchange="updateOrderSummary()">
                    <option value="none" <?= ($voucher === 'none') ? 'selected' : '' ?>>Không sử dụng voucher</option>
                    <option value="10off" <?= ($voucher === '10off') ? 'selected' : '' ?>>Giảm 10% tổng đơn hàng</option>
                    <option value="freedelivery" <?= ($voucher === 'freedelivery') ? 'selected' : '' ?>>Miễn phí vận chuyển</option>
                </select>
                <small class="text-muted" id="voucher-text"><?= $voucherText ?></small>
            </div>
            
            <h2 class="section-title">Phương thức thanh toán</h2>
            
            <div class="payment-methods">
                <div class="payment-method active" data-method="cod">
                    <div class="payment-method-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="payment-method-info">
                        <div class="payment-method-name">Thanh toán khi nhận hàng (COD)</div>
                        <div class="payment-method-desc">Bạn chỉ thanh toán khi đã nhận được hàng</div>
                    </div>
                </div>
                
                <div class="payment-method" data-method="credit_card">
                    <div class="payment-method-icon">
                        <i class="fab fa-cc-visa"></i>
                    </div>
                    <div class="payment-method-info">
                        <div class="payment-method-name">Thẻ tín dụng/ghi nợ</div>
                        <div class="payment-method-desc">Thanh toán ngay bằng thẻ Visa, Mastercard</div>
                    </div>
                </div>
                
                <div class="payment-method" data-method="ewallet">
                    <div class="payment-method-icon">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <div class="payment-method-info">
                        <div class="payment-method-name">Ví điện tử</div>
                        <div class="payment-method-desc">Thanh toán qua Momo, ZaloPay, VNPay</div>
                    </div>
                </div>
                <input type="hidden" name="payment_method" value="cod" id="payment-method-input">
            </div>
        </div>
        
        <div class="checkout-summary">
            <h2 class="section-title">Đơn hàng của bạn</h2>
            
            <div class="cart-items">
                <?php foreach ($cartItems as $id => $item): ?>
                <div class="cart-item">
                    <img src="<?= htmlspecialchars($item['img']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="cart-item-img">
                    <div class="cart-item-info">
                        <div class="cart-item-name"><?= htmlspecialchars($item['name']) ?></div>
                        <div class="cart-item-price"><?= number_format($item['price'], 0, ',', '.') ?>₫</div>
                    </div>
                    <div class="cart-item-quantity">x<?= htmlspecialchars($item['quantity']) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="summary-row">
                <span class="summary-label">Tạm tính:</span>
                <span class="summary-value"><?= number_format($totalPrice, 0, ',', '.') ?>₫</span>
            </div>
            
            <div class="summary-row">
                <span class="summary-label">Giảm giá:</span>
                <span class="summary-value text-danger" id="discount-value">-<?= number_format($voucherDiscount, 0, ',', '.') ?>₫</span>
            </div>
            
            <div class="summary-row">
                <span class="summary-label">Phí vận chuyển:</span>
                <span class="summary-value" id="shipping-value"><?= number_format($shippingCost, 0, ',', '.') ?>₫</span>
            </div>
            
            <div class="summary-total">
                <span>Tổng cộng:</span>
                <span id="total-amount"><?= number_format($totalAmount, 0, ',', '.') ?>₫</span>
            </div>
            
            <button type="button" class="btn btn-primary mt-3" onclick="validateAndSubmit()">
                <i class="fas fa-shopping-bag me-2"></i> Đặt hàng
            </button>
            
            <div class="mt-3 text-center text-muted small">
                <i class="fas fa-lock me-1"></i> Thông tin của bạn sẽ được bảo mật
            </div>
        </div>
        
        <input type="hidden" name="place_order" value="1">
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Chọn phương thức thanh toán
    document.querySelectorAll('.payment-method').forEach(method => {
        method.addEventListener('click', function() {
            document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('payment-method-input').value = this.dataset.method;
        });
    });
    
    // Cập nhật tổng đơn hàng khi thay đổi phương thức vận chuyển/voucher
    function updateOrderSummary() {
        const formData = new FormData(document.getElementById('checkoutForm'));
        const voucher = formData.get('voucher');
        const shipping = formData.get('shipping');
        
        // Tính toán phí vận chuyển
        const shippingCosts = {
            'economy': 20000,
            'fast': 50000,
            'express': 100000
        };
        let shippingCost = shippingCosts[shipping] || 20000;
        
        // Tính toán giảm giá
        let discount = 0;
        let voucherText = 'Không sử dụng voucher';
        
        if (voucher === '10off') {
            discount = <?= $totalPrice ?> * 0.1;
            voucherText = 'Giảm 10% tổng đơn';
            shippingCost = shippingCosts[shipping] || 20000;
        } else if (voucher === 'freedelivery') {
            shippingCost = 0;
            voucherText = 'Miễn phí vận chuyển';
        }
        
        // Cập nhật giao diện
        document.getElementById('shipping-value').textContent = shippingCost.toLocaleString('vi-VN') + '₫';
        document.getElementById('discount-value').textContent = '-' + discount.toLocaleString('vi-VN') + '₫';
        document.getElementById('voucher-text').textContent = voucherText;
        
        const totalAmount = <?= $totalPrice ?> - discount + shippingCost;
        document.getElementById('total-amount').textContent = totalAmount.toLocaleString('vi-VN') + '₫';
    }
    
    // Validate số điện thoại
    function validatePhone(phone) {
        const regex = /^(0|\+84)[1-9][0-9]{8}$/;
        return regex.test(phone);
    }
    
    // Validate form trước khi submit
    function validateAndSubmit() {
        const form = document.getElementById('checkoutForm');
        const name = form.elements['name'].value.trim();
        const phone = form.elements['phone'].value.trim();
        const address = form.elements['address'].value.trim();
        
        // Kiểm tra các trường bắt buộc
        if (!name || !phone || !address) {
            Swal.fire({
                icon: 'error',
                title: 'Thiếu thông tin',
                text: 'Vui lòng điền đầy đủ thông tin bắt buộc',
                confirmButtonText: 'Đóng'
            }).then(() => {
                // Focus vào trường đầu tiên bị thiếu
                if (!name) form.elements['name'].focus();
                else if (!phone) form.elements['phone'].focus();
                else if (!address) form.elements['address'].focus();
                
                // Cuộn lên đầu form
                window.scrollTo({top: 0, behavior: 'smooth'});
            });
            return;
        }
        
        // Kiểm tra số điện thoại
        if (!validatePhone(phone)) {
            Swal.fire({
                icon: 'error',
                title: 'Số điện thoại không hợp lệ',
                text: 'Vui lòng nhập số điện thoại đúng định dạng Việt Nam (10-11 số, bắt đầu bằng 0 hoặc +84)',
                confirmButtonText: 'Đóng'
            }).then(() => {
                form.elements['phone'].focus();
                window.scrollTo({top: form.elements['phone'].offsetTop - 100, behavior: 'smooth'});
            });
            return;
        }
        
        // Hiển thị xác nhận
        confirmOrder();
    }
    
    // Xác nhận đơn hàng
    function confirmOrder() {
        const form = document.getElementById('checkoutForm');
        const name = form.elements['name'].value.trim();
        const phone = form.elements['phone'].value.trim();
        const address = form.elements['address'].value.trim();
        const paymentMethod = document.getElementById('payment-method-input').value;
        const shippingMethod = form.elements['shipping'].value;
        const voucher = form.elements['voucher'].value;
        const total = document.getElementById('total-amount').textContent;
        
        // Tạo nội dung xác nhận
        let paymentMethodText = '';
        switch(paymentMethod) {
            case 'cod':
                paymentMethodText = 'Thanh toán khi nhận hàng (COD)';
                break;
            case 'credit_card':
                paymentMethodText = 'Thẻ tín dụng/ghi nợ';
                break;
            case 'ewallet':
                paymentMethodText = 'Ví điện tử';
                break;
        }
        
        let shippingMethodText = '';
        switch(shippingMethod) {
            case 'economy':
                shippingMethodText = 'Giao hàng tiết kiệm (3-5 ngày)';
                break;
            case 'fast':
                shippingMethodText = 'Giao hàng nhanh (1-2 ngày)';
                break;
            case 'express':
                shippingMethodText = 'Giao hàng hỏa tốc (Trong ngày)';
                break;
        }
        
        let voucherText = '';
        switch(voucher) {
            case 'none':
                voucherText = 'Không sử dụng voucher';
                break;
            case '10off':
                voucherText = 'Giảm 10% tổng đơn';
                break;
            case 'freedelivery':
                voucherText = 'Miễn phí vận chuyển';
                break;
        }
        
        Swal.fire({
            title: 'Xác nhận đơn hàng',
            html: `<div class="text-left" style="max-width: 500px; margin: 0 auto;">
                     <div style="margin-bottom: 15px;">
                       <h3 style="font-size: 16px; margin-bottom: 5px; color: #2563eb;">Thông tin giao hàng</h3>
                       <p><strong>Người nhận:</strong> ${name}</p>
                       <p><strong>SĐT:</strong> ${phone}</p>
                       <p><strong>Địa chỉ:</strong> ${address}</p>
                     </div>
                     
                     <div style="margin-bottom: 15px;">
                       <h3 style="font-size: 16px; margin-bottom: 5px; color: #2563eb;">Phương thức thanh toán</h3>
                       <p>${paymentMethodText}</p>
                     </div>
                     
                     <div style="margin-bottom: 15px;">
                       <h3 style="font-size: 16px; margin-bottom: 5px; color: #2563eb;">Vận chuyển & Khuyến mãi</h3>
                       <p><strong>Phương thức vận chuyển:</strong> ${shippingMethodText}</p>
                       <p><strong>Voucher:</strong> ${voucherText}</p>
                     </div>
                     
                     <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee;">
                       <p style="font-size: 18px; font-weight: bold; text-align: right;">
                         <strong>Tổng thanh toán:</strong> ${total}
                       </p>
                     </div>
                   </div>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Xác nhận đặt hàng',
            cancelButtonText: 'Kiểm tra lại',
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#64748b',
            reverseButtons: true,
            width: '600px'
        }).then((result) => {
            if (result.isConfirmed) {
                // Hiển thị loading
                Swal.fire({
                    title: 'Đang xử lý đơn hàng...',
                    html: 'Vui lòng chờ trong giây lát',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                        // Submit form sau 1 giây để đảm bảo loading hiển thị
                        setTimeout(() => {
                            form.submit();
                        }, 1000);
                    }
                });
            }
        });
    }
    
    // Validate số điện thoại khi blur
    document.getElementById('phone').addEventListener('blur', function() {
        const phone = this.value.trim();
        if (phone && !validatePhone(phone)) {
            Swal.fire({
                icon: 'warning',
                title: 'Số điện thoại không hợp lệ',
                text: 'Vui lòng nhập số điện thoại đúng định dạng Việt Nam (10-11 số, bắt đầu bằng 0 hoặc +84)',
                confirmButtonText: 'Đóng'
            }).then(() => {
                this.focus();
            });
        }
    });
</script>

<?php 
require_once('includes/footer.php');
?>
</body>
</html>