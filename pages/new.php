<!-- men.php -->
<?php include('includes/header.php'); ?>  <!-- Kế thừa phần header -->
<?php include('includes/nav.php'); ?>     <!-- Kế thừa phần nav -->
 <!-- Tải font Roboto từ Google Fonts -->
 <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

 <style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Roboto', sans-serif;
    background-color: #ffffff;
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
    height: 200px;
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
</style>

</head>
<body>

  <section class="d1">
    <h1>Bộ Sưu Tập Mới 2025</h1>
    <p>Khám phá những thiết kế đỉnh cao từ các thương hiệu hàng đầu</p>
  </section>

  <section class="d2">
    <button>Bộ sưu tập mới</button>
    <button>Review đồng hồ</button>
    <button>Xu hướng thời trang</button>
    <button>Tin thị trường</button>
    <button>Kinh nghiệm mua</button>
  </section>

  <section class="d3">
    <div class="d4">
      <!-- Tin bài 1 -->
      <div class="d5">
        <img src="/Watch_Store_Manage/images/new1.png" alt="Tin tức 1">
        <div class="d6">
          <p class="date">12/04/2025</p>
          <h3>Xu hướng đồng hồ cổ điển quay lại</h3>
          <p>Những thiết kế cổ điển đang trở lại mạnh mẽ, chinh phục giới trẻ yêu thời trang.</p>
        </div>
      </div>

      <!-- Tin bài 2 -->
      <div class="d5">
        <img src="/Watch_Store_Manage/images/new4.png" alt="Tin tức 2">
        <div class="d6">
          <p class="date">10/04/2025</p>
          <h3>Top 5 mẫu đồng hồ nam hot nhất 2025</h3>
          <p>Danh sách đồng hồ được săn đón nhất, nổi bật về thiết kế lẫn công nghệ.</p>
        </div>
      </div>

      <!-- Tin bài 3 -->
      <div class="d5">
        <img src="/Watch_Store_Manage/images/new3.png" alt="Tin tức 3">
        <div class="d6">
          <p class="date">08/04/2025</p>
          <h3>Review: Omega Speedmaster Moonwatch</h3>
          <p>Một cái nhìn chi tiết về mẫu đồng hồ biểu tượng – tinh tế và lịch lãm.</p>
        </div>
      </div>

      <!-- Thêm bài viết khác tùy ý -->
    </div>
  </section>

<?php include('includes/footer.php'); ?> <!-- Kế thừa phần footer -->
