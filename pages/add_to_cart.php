<?php
session_start();  // Khởi động session

// Kiểm tra nếu giỏ hàng đã tồn tại trong session chưa
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];  // Nếu chưa, khởi tạo giỏ hàng
}

// Kiểm tra nếu có dữ liệu từ POST
if (isset($_POST['product_id']) && isset($_POST['product_name']) && isset($_POST['product_price']) && isset($_POST['product_img'])) {
    $product = [
        'id' => $_POST['product_id'],
        'name' => $_POST['product_name'],
        'price' => $_POST['product_price'],
        'img' => $_POST['product_img'],
        'quantity' => 1  // Mặc định là 1 sản phẩm mỗi lần thêm vào giỏ
    ];

    // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product['id']) {
            $item['quantity']++;  // Tăng số lượng nếu sản phẩm đã có trong giỏ
            $found = true;
            break;
        }
    }

    // Nếu sản phẩm chưa có trong giỏ, thêm vào giỏ
    if (!$found) {
        $_SESSION['cart'][] = $product;
    }

    // Trả về thông báo thành công
    echo "Sản phẩm đã được thêm vào giỏ hàng!";
} else {
    echo "Lỗi: Dữ liệu sản phẩm không hợp lệ!";
}
?>
