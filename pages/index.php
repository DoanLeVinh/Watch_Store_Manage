<?php include('includes/header.php'); ?>
<?php include('includes/nav.php'); ?>

<!-- Liên kết tối ưu hóa -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<style>
  /* Biến CSS để dễ quản lý */
  :root {
    --primary-color: #e60023;
    --text-color: #333;
    --text-secondary: #555;
    --text-light: #888;
    --bg-light: #f9f9f9;
    --white: #ffffff;
    --shadow: 0 4px 10px rgba(0,0,0,0.1);
    --shadow-hover: 0 8px 20px rgba(0,0,0,0.2);
    --transition: all 0.3s ease;
  }

  /* Reset và base styles */
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  body {
    font-family: 'Roboto', sans-serif;
    line-height: 1.6;
    color: var(--text-color);
    background-color: var(--bg-light);
  }

  img {
    max-width: 100%;
    height: auto;
    align-items: center;
  }

  a {
    text-decoration: none;
    color: inherit;
  }

  /* Layout */
  .container {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
  }

  /* Animation */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  /* ------------------- Banner ------------------- */
  .banner-container {
    margin-left: auto;
    margin-right: auto;
    border-radius: 10px;
    object-fit: cover;
    padding-top: 20px;
  }

  .banner-container img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    transition: var(--transition);
  }


  /* ------------------- Bài viết ------------------- */
  .article-container {
    max-width: 1200px;
    margin: 40px auto;
    background: var(--white);
    padding: 30px;
    border-radius: 10px;
    box-shadow: var(--shadow);
    animation: fadeIn 1s ease-in;
  }

  .article-title {
    font-size: clamp(1.8rem, 3vw, 2.5rem);
    color: var(--text-color);
    margin-bottom: 10px;
    text-align: center;
    line-height: 1.3;
  }

  .article-meta {
    color: var(--text-light);
    font-size: 0.95em;
    margin-bottom: 20px;
    text-align: center;
    font-style: italic;
  }

  .article-image {
    width: 100%;
    height: 400px;
    margin-bottom: 25px;
    border-radius: 8px;
    object-fit: cover;
    transition: var(--transition);
  }

  .article-image:hover {
    transform: scale(1.01);
  }

  .article-content {
    font-size: 1.1em;
    color: var(--text-secondary);
  }

  .article-content p {
    margin-bottom: 1.2em;
    text-align: justify;
  }

  .article-content .highlight {
    color: var(--primary-color);
    font-weight: 500;
  }

  /* ------------------- Các tính năng ------------------- */
  .features-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin: 40px auto;
    max-width: 1300px;
    padding: 20px;
  }

  .feature {
    background: var(--white);
    border-radius: 10px;
    box-shadow: var(--shadow);
    padding: 25px 20px;
    text-align: center;
    transition: var(--transition);
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .feature img {
    width: 80px;
    height: 80px;
    margin-bottom: 15px;
    object-fit: contain;
  }

  .feature h3 {
    font-size: 1.3em;
    margin-bottom: 15px;
    color: var(--text-color);
  }

  .feature p {
    font-size: 1em;
    color: var(--text-secondary);
    text-align: center;
  }

  .feature:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-hover);
  }

  /* ------------------- Tiêu đề nhỏ ------------------- */
  .section-title {
    font-size: clamp(1.5rem, 3vw, 2.2rem);
    color: var(--text-secondary);
    text-align: center;
    margin: 40px 0 20px;
    transition: var(--transition);
    position: relative;
    display: inline-block;
    width: 100%;
  }

  .section-title:hover {
    color: var(--text-color);
  }

  .section-title::after {
    content: '';
    display: block;
    width: 80px;
    height: 3px;
    background: var(--primary-color);
    margin: 10px auto 0;
    transition: var(--transition);
  }

  .section-title:hover::after {
    width: 120px;
  }

  /* ------------------- Danh sách sản phẩm ------------------- */
  .product-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
    margin: 30px 0 50px;
    padding: 0 20px;
  }

  .product-item {
    background: var(--white);
    border-radius: 10px;
    overflow: hidden;
    box-shadow: var(--shadow);
    display: flex;
    flex-direction: column;
    transition: var(--transition);
    position: relative;
  }

  .product-item:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-hover);
  }

  .product-item img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    background: #f2f2f2;
  }

  .product-info {
    padding: 15px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    flex-grow: 1;
  }

  .product-info h2 {
    font-size: 1.1em;
    color: var(--text-color);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 3em;
    line-height: 1.4;
  }

  .product-info p {
    font-size: 0.9em;
    color: var(--text-light);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 3em;
  }

  .price {
    font-weight: bold;
    color: var(--primary-color);
    font-size: 1.2em;
    margin-top: auto;
  }

  /* ------------------- Bộ sưu tập ------------------- */
  .collection-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    padding: 40px 20px;
    max-width: 1200px;
    margin: 0 auto;
  }

  .collection-item {
    position: relative;
    height: 250px;
    background-size: cover;
    background-position: center;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    box-shadow: var(--shadow);
    transition: var(--transition);
  }

  .collection-item.large {
    grid-column: span 2;
    grid-row: span 2;
    height: 520px;
  }

  .collection-item.medium {
    height: 250px;
    grid-column: span 2;
  }

  .collection-item:hover {
    transform: scale(1.03);
    box-shadow: var(--shadow-hover);
  }

  .collection-item .overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.35);
    z-index: 1;
    transition: var(--transition);
  }

  .collection-item:hover .overlay {
    background-color: rgba(0, 0, 0, 0.5);
  }

  .collection-item .text {
    position: absolute;
    z-index: 2;
    color: white;
    text-align: center;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    padding: 0 20px;
  }

  .collection-item .text h2 {
    font-size: clamp(1.2rem, 2vw, 1.5rem);
    margin-bottom: 10px;
    letter-spacing: 1px;
    text-transform: uppercase;
  }

  .collection-item .text p {
    font-size: 0.9rem;
    background-color: rgba(255, 255, 255, 0.15);
    padding: 6px 12px;
    border-radius: 20px;
    display: inline-block;
    font-weight: 500;
    transition: var(--transition);
  }

  .collection-item:hover .text p {
    background-color: rgba(255, 255, 255, 0.25);
  }

  /* ------------------- Responsive ------------------- */
  @media (max-width: 1024px) {
    .collection-container {
      grid-template-columns: repeat(3, 1fr);
    }
    
    .collection-item.large {
      grid-column: span 3;
      height: 400px;
    }
    
    .collection-item.medium {
      grid-column: span 1;
    }
  }

  @media (max-width: 768px) {
    .features-container {
      grid-template-columns: 1fr;
      gap: 20px;
    }
    
    .collection-container {
      grid-template-columns: 1fr 1fr;
    }
    
    .collection-item.large {
      grid-column: span 2;
      height: 300px;
    }
    
    .product-list {
      grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    }
    
    .article-image {
      height: 300px;
    }
  }

  @media (max-width: 480px) {
    .collection-container {
      grid-template-columns: 1fr;
    }
    
    .collection-item.large,
    .collection-item.medium {
      grid-column: span 1;
      height: 250px;
    }
    
    .article-container {
      padding: 20px;
    }
    
    .banner-container img {
      height: 250px;
    }
  }
</style>

<main>
    <div class="container">
        <?php include("connect.php"); ?>

        <!-- Banner Section -->
        <section class="banner-container">
            <img src="/Watch_Store_Manage/images/baner.png" alt="Main Banner" loading="lazy">
        </section>

        <!-- Article Section -->
        <article class="article-container">
            <h1 class="article-title">SAGA – Biểu tượng của phong cách và sự tinh tế trong thế giới đồng hồ</h1>
            <div class="article-meta">Đăng ngày: 27/04/2025 | Tác giả: Nguyễn Mai</div>
            <img src="/Watch_Store_Manage/images/banner2.png" alt="Đồng hồ SAGA" class="article-image" loading="lazy">
            <div class="article-content">
                <p>SAGA, thương hiệu đồng hồ nổi tiếng đến từ Mỹ, từ lâu đã khẳng định vị thế của mình trong ngành đồng hồ cao cấp trên toàn cầu. Với những thiết kế tinh tế và chất lượng vượt trội, SAGA không chỉ là một chiếc đồng hồ, mà là biểu tượng của sự sang trọng và đẳng cấp.</p>

                <p>Mỗi chiếc đồng hồ SAGA là sự kết hợp hoàn hảo giữa nghệ thuật và kỹ thuật. Chúng không chỉ đơn giản là một công cụ đo thời gian, mà còn là một tác phẩm nghệ thuật được chế tác tỉ mỉ từ những nguyên liệu cao cấp. SAGA sử dụng những chất liệu độc đáo như đá Swarovski chính hãng, kim loại không gỉ và các vật liệu cao cấp khác để tạo nên sản phẩm vừa bền bỉ, vừa đẹp mắt. Các mẫu đồng hồ của SAGA luôn đi đầu trong xu hướng thiết kế hiện đại, đồng thời vẫn giữ được sự tinh tế cổ điển, phù hợp với mọi đối tượng khách hàng từ các doanh nhân thành đạt cho đến những tín đồ yêu thích thời trang.</p>

                <p>Với triết lý "<span class="highlight">Đồng hồ không chỉ để xem giờ, mà còn là tuyên ngôn cá tính</span>", mỗi sản phẩm của SAGA đều mang trong mình thông điệp mạnh mẽ về sự độc lập và cá tính. SAGA không chỉ giúp bạn quản lý thời gian, mà còn thể hiện được phong cách sống và sự tự tin của người sở hữu. Cho dù là trong một cuộc họp quan trọng, hay một buổi tối dạo chơi cùng bạn bè, đồng hồ SAGA luôn là điểm nhấn hoàn hảo, tôn lên vẻ đẹp và gu thẩm mỹ của người đeo.</p>
            </div>
        </article>

        <!-- Features Section -->
        <section class="features-container">
            <div class="feature">
                <img src="/Watch_Store_Manage/images/item1.png" alt="Sang trọng và tinh tế" loading="lazy">
                <h3>SANG TRỌNG VÀ TINH TẾ</h3>
                <p>Saga luôn giữ vững giá trị cốt lõi là sự sang trọng và tinh tế trong từng sản phẩm</p>
            </div>
            <div class="feature">
                <img src="/Watch_Store_Manage/images/item2.png" alt="Chất lượng và uy tín" loading="lazy">
                <h3>CHẤT LƯỢNG VÀ UY TÍN</h3>
                <p>Chất lượng là giá trị quan trọng nhất mà Saga cam kết với khách hàng</p>
            </div>
            <div class="feature">
                <img src="/Watch_Store_Manage/images/item3.png" alt="Sáng tạo và đổi mới" loading="lazy">
                <h3>SÁNG TẠO VÀ ĐỔI MỚI</h3>
                <p>Liên tục sáng tạo, đổi mới trong thiết kế & công nghệ để mang đến những sản phẩm</p>
            </div>
        </section>

        <!-- Featured Collections -->
        <div class="collection-container">
            <div class="collection-item large" style="background-image: url('/Watch_Store_Manage/images/bst1.png');">
                <div class="overlay"></div>
                <div class="text">
                    <h2>BỘ SƯU TẬP MỚI</h2>
                    <p>Xem ngay</p>
                </div>
            </div>
            <a href="/Watch_Store_Manage/pages/men.php" class="collection-item" style="background-image: url('/Watch_Store_Manage/images/dhmen.png');">
                <div class="overlay"></div>
                <div class="text">
                    <h2>NAM</h2>
                    <p>Xem ngay</p>
                </div>
            </a>
            <a href="/Watch_Store_Manage/pages/women.php" class="collection-item" style="background-image: url('/Watch_Store_Manage/images/dhnu.png');">
                <div class="overlay"></div>
                <div class="text">
                    <h2>NỮ</h2>
                    <p>Xem ngay</p>
                </div>
            </a>
            <div class="collection-item medium" style="background-image: url('/Watch_Store_Manage/images/bst.png');">
                <div class="overlay"></div>
                <div class="text">
                    <h2>TRANG SỨC</h2>
                    <p>Xem ngay</p>
                </div>
            </div>
        </div>

        <!-- Product List -->
        <h2 class="section-title">Mẫu đồng hồ gợi ý cho bạn</h2>
        <div class="product-list">
        <?php 
    $sql = "SELECT * FROM dongho_nam LIMIT 8"; // Giới hạn số sản phẩm để tối ưu
    $result = $link->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { 
            $product_name = htmlspecialchars($row['TenSP']);
            $product_desc = htmlspecialchars(ucfirst($row['sex'])) . " - " . 
                          htmlspecialchars($row['May']) . " - " . 
                          htmlspecialchars($row['Kinh']) . " - Kích thước: " . 
                          htmlspecialchars($row['Kichthuoc']);
            $product_price = number_format($row['Gia'], 0, ',', '.');
?>
            <a href="/Watch_Store_Manage/pages/infor.php?masp=<?php echo $row['Ma']; ?>">
                <div class="product-item">
                    <img src="<?php echo htmlspecialchars($row['Hinhanh']); ?>" alt="<?php echo $product_name; ?>" loading="lazy">
                    <div class="product-info">
                        <h2><?php echo $product_name; ?></h2>
                        <p><?php echo $product_desc; ?></p>
                        <span class="price"><?php echo $product_price; ?> đ</span>
                    </div>
                </div>
            </a>
<?php 
        }
    } else {
        echo '<p class="no-products">Không có sản phẩm nào</p>';
    }
?>
        </div>
    </div>
</main>

<?php include('includes/footer.php'); ?>