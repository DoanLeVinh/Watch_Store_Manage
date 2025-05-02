<!-- men.php -->
<?php include('includes/header.php'); ?> <!-- Kế thừa phần header -->
<?php include('includes/nav.php'); ?>     <!-- Kế thừa phần nav -->

<!-- Tải font từ Google Fonts và Font Awesome -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<style>
  /* Các phần CSS cơ bản */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Roboto', sans-serif;
    background-color: #f8f8f8;
    color: #333;
    line-height: 1.6;
  }

  h1, h3 {
    font-family: 'Playfair Display', serif;
    font-weight: bold;
  }

  h1 {
    font-size: 3rem;
    color: white;
    margin-bottom: 0.5rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
  }

  .d1 {
    background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('/Watch_Store_Manage/images/new1.png') no-repeat center/cover;
    color: white;
    text-align: center;
    padding: 4rem 2rem;
    border-radius: 20px;
    margin: 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  }

  .d1 p {
    font-size: 1.2rem;
    color: #f1f1f1;
  }

  .d2 {
    background-color: #ffffff;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding: 1.2rem;
    gap: 1rem;
    border-bottom: 1px solid #eee;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  .d2 button {
    padding: 0.6rem 1.4rem;
    border: 1px solid #ccc;
    background-color: #fff;
    border-radius: 30px;
    cursor: pointer;
    font-weight: 500;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    color: #333;
  }

  .d2 button:hover {
    background-color: #000;
    color: #fff;
    border-color: #000;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }

  .d3 {
    padding: 2rem 1rem;
    max-width: 1200px;
    margin: auto;
  }

  .d4 {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
  }

  .d5 {
    background-color: #fff;
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .d5:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
  }

  .d5 img {
    width: 100%;
    height: 250px;
    object-fit: cover;
  }

  .d6 {
    padding: 1rem;
  }

  .d6 h3 {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
    color: #111;
  }

  .d6 p {
    font-size: 0.95rem;
    color: #555;
  }

  .d6 .date {
    font-size: 0.85rem;
    color: #999;
    margin-bottom: 0.5rem;
    font-style: italic;
  }

  .d7 {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    padding: 2rem 0;
  }

  .d7 button {
    padding: 0.5rem 1rem;
    background-color: #222;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 0.95rem;
    cursor: pointer;
    transition: background-color 0.2s ease;
  }

  .d7 button:hover {
    background-color: #000;
  }

  /* Mới thêm phần bài viết chi tiết */
  .article-container {
    background-color: #fff;
    padding: 2rem;
    margin: 2rem 0;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }

  .article-container h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
  }

  .article-container p {
    font-size: 1.1rem;
    color: #555;
    line-height: 1.8;
  }

  .article-container .image {
    width: 100%;
    height: 300px;
    background-color: #f2f2f2;
    margin-bottom: 1rem;
  }

  .article-container .link {
    font-size: 1rem;
    color: #007BFF;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .article-container .link:hover {
    color: #0056b3;
  }
</style>

</head>
<body>

  <!-- Tiêu đề và phần banner -->
  <section class="d1">
    <h1>Khám Phá Thế Giới Đồng Hồ</h1>
    <p>Cập nhật tin tức, bài viết và xu hướng mới nhất về đồng hồ cao cấp</p>
  </section>

  <!-- Các nút bộ lọc hoặc chức năng khác -->
  <section class="d2">
    <button>Giới thiệu bộ máy đồng hồ</button>
    <button>Chọn dây da cho đồng hồ</button>
    <button>Mặt kính đồng hồ: Những điều cần biết</button>
    <button>Xu hướng đồng hồ năm 2025</button>
  </section>

  <!-- Các bài viết chi tiết về đồng hồ -->
  <section class="d3">
    <h2 style="text-align: center; margin-bottom: 2rem;">Thông Tin Về Đồng Hồ</h2>

    <!-- Bài viết 1: Bộ máy đồng hồ -->
    <div class="article-container">
      <div class="image" style="background-image: url('/Watch_Store_Manage/images/new1.png'); background-size: cover; background-position: center;"></div>
      <h2>Bộ Máy Đồng Hồ: Những Điều Bạn Cần Biết</h2>
      <p>Bộ máy đồng hồ là trái tim của mỗi chiếc đồng hồ, chịu trách nhiệm về sự chính xác trong việc đo thời gian. Đồng hồ cơ khí sử dụng các bánh răng và các bộ phận chuyển động cơ học để hoạt động, trong khi đó đồng hồ quartz sử dụng pin để điều khiển hoạt động. Hiện nay, các bộ máy đồng hồ càng ngày càng được cải tiến với độ chính xác và tính năng vượt trội. Việc lựa chọn bộ máy phù hợp không chỉ giúp chiếc đồng hồ hoạt động chính xác mà còn thể hiện gu thẩm mỹ và đẳng cấp của người sở hữu.</p>
      <a href="/Watch_Store_Manage/pages/details.php" class="link">Tìm hiểu thêm về bộ máy đồng hồ</a>
    </div>

    <!-- Bài viết 2: Dây da đồng hồ -->
    <div class="article-container">
      <div class="image" style="background-image: url('/Watch_Store_Manage/images/new2.png'); background-size: cover; background-position: center;"></div>
      <h2>Lý Do Chọn Dây Da Cho Đồng Hồ</h2>
      <p>Dây da là một trong những yếu tố quan trọng giúp đồng hồ của bạn thêm phần sang trọng và cá tính. Những chiếc dây da cao cấp được làm từ các chất liệu như da bò, da cá sấu, mang lại cảm giác êm ái và độ bền cao. Bên cạnh đó, dây da cũng có thể được thay đổi dễ dàng để phù hợp với từng dịp, từ những chiếc dây da đơn giản cho đến những dây da được chế tác thủ công với họa tiết độc đáo.</p>
      <a href="/Watch_Store_Manage/pages/details.php" class="link">Tìm hiểu thêm về dây da đồng hồ</a>
    </div>

    <!-- Bài viết 3: Mặt kính đồng hồ -->
    <div class="article-container">
      <div class="image" style="background-image: url('/Watch_Store_Manage/images/new3.png'); background-size: cover; background-position: center;"></div>
      <h2>Mặt Kính Đồng Hồ: Sapphire, Khoáng Hay Acrylic?</h2>
      <p>Mặt kính đồng hồ là phần tiếp xúc với môi trường ngoài, vì vậy nó cần phải có độ bền và khả năng chống trầy xước cao. Các loại mặt kính phổ biến nhất là kính khoáng, kính sapphire và kính acrylic. Kính sapphire nổi bật nhờ độ cứng và khả năng chống trầy xước vượt trội, trong khi kính khoáng lại có giá thành thấp hơn nhưng vẫn khá bền. Kính acrylic, mặc dù mềm hơn nhưng lại dễ gia công và sửa chữa. Lựa chọn mặt kính phù hợp sẽ giúp đồng hồ của bạn bền lâu theo thời gian.</p>
      <a href="/Watch_Store_Manage/pages/details.php" class="link">Tìm hiểu thêm về mặt kính đồng hồ</a>
    </div>

    <!-- Bài viết 4: Xu hướng đồng hồ năm 2025 -->
    <div class="article-container">
      <div class="image" style="background-image: url('/Watch_Store_Manage/images/new4.png'); background-size: cover; background-position: center;"></div>
      <h2>Xu Hướng Đồng Hồ Mới Nhất Năm 2025</h2>
      <p>Với sự phát triển không ngừng của công nghệ, đồng hồ ngày nay không chỉ đơn thuần là công cụ đo thời gian, mà còn là một món phụ kiện thể hiện cá tính và phong cách sống. Trong năm 2025, các mẫu đồng hồ thông minh kết hợp với các chức năng sức khỏe, theo dõi nhịp tim, giấc ngủ, và thể thao hứa hẹn sẽ trở thành xu hướng chủ đạo. Bên cạnh đó, những mẫu đồng hồ cơ học với bộ máy cải tiến và thiết kế cổ điển sẽ luôn chiếm ưu thế trong lòng những tín đồ đồng hồ yêu thích sự hoàn hảo.</p>
      <a href="/Watch_Store_Manage/pages/details.php" class="link">Tìm hiểu thêm về xu hướng đồng hồ 2025</a>
    </div>

  </section>

  <!-- Phần bài viết nổi bật, thông tin khác, hoặc bài viết phổ biến -->
  <section class="d7">
    <button>Đọc Thêm</button>
  </section>

<?php include('includes/footer.php'); ?> <!-- Kế thừa phần footer -->

