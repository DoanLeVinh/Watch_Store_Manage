<?php
// Nhận tin nhắn từ người dùng
$msg = $_POST['msg'] ?? '';
$response = "Xin chào! Tôi chưa hiểu câu hỏi của bạn.";

// Trả lời đơn giản theo từ khóa
if (stripos($msg, 'giá') !== false) {
    $response = "Bạn đang quan tâm sản phẩm nào để mình báo giá?";
} elseif (stripos($msg, 'mở cửa') !== false) {
    $response = "Shop mở cửa từ 8h sáng đến 9h tối hàng ngày.";
}

echo $response;
?>
