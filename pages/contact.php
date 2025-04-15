<!-- men.php -->
<?php include('includes/header.php'); ?>  <!-- Kế thừa phần header -->
<?php include('includes/nav.php'); ?>     <!-- Kế thừa phần nav -->
 <!-- Tải font Roboto từ Google Fonts -->
 <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<!-- Contact Section -->
<section class="contact-container">
    <!-- Thêm slogan ở đầu phần contact -->
    <div class="slogan">
        <h2>Quyền được an tâm</h2>
    </div>

    <h1>Liên Hệ Với Chúng Tôi</h1>
    <p>Chúng tôi luôn sẵn sàng hỗ trợ bạn! Hãy chọn phương thức dưới đây để liên lạc với chúng tôi.</p>

    <div class="contact-options">
        <!-- Trò chuyện ẩn danh -->
        <div class="contact-option">
            <h3>Trò Chuyện Ẩn Danh</h3>
            <p>Đừng ngần ngại chia sẻ yêu cầu của bạn với chúng tôi qua trò chuyện ẩn danh. Chúng tôi luôn sẵn sàng lắng nghe!</p>
            <button class="contact-btn" onclick="window.location.href='https://chatwebsite.com'">Bắt Đầu Trò Chuyện</button>
        </div>

        <!-- Gọi ngay cho chuyên viên -->
        <div class="contact-option">
            <h3>Gọi Ngay Cho Chuyên Viên</h3>
            <p>Muốn tư vấn nhanh chóng? Gọi ngay để được chuyên viên của chúng tôi hỗ trợ tận tình.</p>
            <button class="contact-btn" onclick="window.location.href='tel:+1234567890'">Gọi Ngay</button>
        </div>

        <!-- Chat trực tiếp -->
        <div class="contact-option">
            <h3>Chat Trực Tiếp</h3>
            <p>Chúng tôi có đội ngũ hỗ trợ trực tiếp để trả lời mọi câu hỏi của bạn. Chat ngay để nhận được sự hỗ trợ!</p>
            <button class="contact-btn" onclick="window.location.href='https://livechat.com'">Chat Ngay</button>
        </div>
    </div>
</section>


<?php include('includes/footer.php'); ?> <!-- Kế thừa phần footer -->
