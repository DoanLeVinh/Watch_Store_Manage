<?php
session_start();  // Bắt đầu session nếu cần

// Kết nối đến cơ sở dữ liệu
include('connect.php');

// Kiểm tra xem dữ liệu có được gửi từ AJAX hay không
if (isset($_POST['product_img']) && isset($_POST['product_id']) && isset($_POST['product_name']) && isset($_POST['product_price'])) {
    
    // Lấy thông tin sản phẩm từ AJAX
    $productImg = $_POST['product_img'];
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    
    // Truy vấn để thêm sản phẩm vào bảng giohang
    $sql = "INSERT INTO giohang (TenSP, Ma, Gia, Hinhanh) VALUES (?, ?, ?, ?)";
    
    // Chuẩn bị và thực thi truy vấn
    if ($stmt = $link->prepare($sql)) {
        $stmt->bind_param("ssss", $productName, $productId, $productPrice, $productImg);
        if ($stmt->execute()) {
            echo "Sản phẩm đã được thêm vào giỏ hàng!";
        } else {
            echo "Lỗi khi thêm sản phẩm vào giỏ hàng!";
        }
        $stmt->close();
    }
} else {
    echo "Dữ liệu không hợp lệ!";
}

// Đóng kết nối cơ sở dữ liệu
$link->close();
?>
