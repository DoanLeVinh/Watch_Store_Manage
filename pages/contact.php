<?php include('includes/header.php'); ?>  
<?php include('includes/nav.php'); ?>  

<!-- Fonts và Icons -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<!-- Contact Section -->
<style>
  body {
    font-family: 'Roboto', sans-serif;
    background-color: #f9f9f9;
    color: #333;
  }

  .e1 { /* container chính */
    max-width: 1100px;
    margin: 50px auto;
    padding: 30px;
    background-color: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
  }

  .e2 { /* slogan */
    text-align: center;
    margin-bottom: 10px;
  }

  .e2 h2 {
    font-size: 1.8rem;
    font-weight: 500;
    color: #666;
    margin-bottom: 10px;
  }

  .e1 h1 {
    text-align: center;
    font-size: 2.5rem;
    color: #222;
    margin-bottom: 10px;
  }

  .e1 p.e3 { /* đoạn mô tả chính */
    text-align: center;
    color: #666;
    margin-bottom: 30px;
    font-size: 1rem;
  }

  .e4 { /* vùng các lựa chọn liên hệ */
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 20px;
  }

  .e5 { /* từng ô lựa chọn */
    flex: 1 1 30%;
    background-color: #fafafa;
    border: 1px solid #eee;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    transition: all 0.3s ease;
  }

  .e5:hover {
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
    transform: translateY(-5px);
    background-color: #fff;
  }

  .e5 h3 {
    font-size: 1.4rem;
    margin-bottom: 10px;
    color: #111;
  }

  .e5 p {
    font-size: 0.95rem;
    color: #555;
    margin-bottom: 20px;
    line-height: 1.6;
  }

  .e6 { /* nút liên hệ */
    padding: 10px 20px;
    background-color: #000;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 0.95rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .e6:hover {
    background-color: #333;
  }

  @media screen and (max-width: 768px) {
    .e4 {
      flex-direction: column;
    }

    .e5 {
      flex: 1 1 100%;
    }
  }
</style>

<section class="e1">
  <div class="e2">
    <h2>Quyền được an tâm</h2>
  </div>

  <h1>Liên Hệ Với Chúng Tôi</h1>
  <p class="e3">Chúng tôi luôn sẵn sàng hỗ trợ bạn! Hãy chọn phương thức dưới đây để liên lạc với chúng tôi.</p>

  <div class="e4">
    <div class="e5">
      <h3>Trò Chuyện Ẩn Danh</h3>
      <p>Chia sẻ yêu cầu của bạn một cách riêng tư và bảo mật.</p>
      <button class="e6" onclick="window.location.href='https://chatwebsite.com'">
        <i class="fas fa-user-secret"></i> Trò Chuyện
      </button>
    </div>

    <div class="e5">
      <h3>Gọi Cho Chuyên Viên</h3>
      <p>Liên hệ trực tiếp để được tư vấn và hỗ trợ tận tình.</p>
      <button class="e6" onclick="window.location.href='tel:+1234567890'">
        <i class="fas fa-phone-alt"></i> Gọi Ngay
      </button>
    </div>

    <div class="e5">
      <h3>Chat Trực Tiếp</h3>
      <p>Đội ngũ của chúng tôi luôn sẵn sàng trò chuyện cùng bạn.</p>
      <button class="e6" onclick="window.location.href='https://livechat.com'">
        <i class="fas fa-comments"></i> Chat Ngay
      </button>
    </div>
  </div>
</section>

<!-- Chat Widget -->
<div id="chat-widget">
    <div id="chat-messages">
        <!-- Tin nhắn sẽ hiển thị ở đây -->
    </div>
    <input type="text" id="chat-input" placeholder="Nhập câu hỏi...">
    <button id="send-btn">Gửi</button>
</div>

<!-- Nhúng script JavaScript -->
<script src="js/chatbot-ui.js"></script>


<?php include('includes/footer.php'); ?> 
