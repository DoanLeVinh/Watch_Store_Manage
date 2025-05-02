<!-- men.php -->
<?php include('includes/header.php'); ?>  <!-- Kế thừa phần header -->
<?php include('includes/nav.php'); ?>     <!-- Kế thừa phần nav -->
 <!-- Tải font Roboto từ Google Fonts -->
 <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>
<body>
    <style>

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

/* Cải thiện độ ưu tiên với ID hoặc class cha nếu cần */
#product-section .product-list {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 30px;
  background: #f9f9f9;
  padding: 40px 20px;
}

#product-section .product-item {
  background: #ffffff;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  width: 250px;
  height: 430px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

  
    </style>
<?php include("connect.php"); ?>

<section class="banner-title">
    Đồng hồ nam đẹp chính hãng, cao cấp, mẫu mới 2025
</section>

<section class="banner-container mx-auto mt-4">
    <!-- Ảnh Banner -->
    <img alt="Main Banner with watch straps submerged in water" src="/Watch_Store_Manage/images/men1.png" />
</section>

 <!-- Phần nội dung mà bạn muốn thiết kế -->
 <div class="custom-content">
        <p>Đồng hồ là món phụ kiện đồng hành không chỉ phản ánh rõ thực tế mà còn thể hiện phong cách cá nhân của phái mạnh. Saga nam cung cấp cho bạn những mẫu mã từ cổ điển, thanh lịch đến thể thao, khoẻ khoắn trên nền chất liệu cao cấp và bộ máy chuẩn Swiss Movt do nhà mốt gốc Mỹ hơn 70 năm lựa chọn.</p>
    </div>


<!-- Nút "Bộ lọc" -->
<button id="toggleFilterButton">
    <i class="fa fa-filter"></i> <span>Bộ lọc</span>
</button>

<!-- Bộ lọc và các liên kết tìm kiếm -->
<section class="filter-container" id="filterContainer">
    <div class="filter-title">Tìm kiếm liên quan:</div>
    <div class="related-search">
        <a href="#">Đồng hồ cơ – Automatic</a>
        <a href="#">Đồng hồ Open Heart</a>
        <a href="#">Đồng hồ 42mm</a>
    </div>

    <div class="filter-options">
        <!-- Bộ lọc với các dropdowns và buttons -->
        <select>
            <option>LOẠI THEO GIÁ</option>
            <option>Giá cao đến thấp</option>
            <option>Giá thấp đến cao</option>
        </select>
        <select>
            <option>HÌNH DẠNG MẶT SỐ</option>
            <option>Tròn</option>
            <option>Chữ nhật</option>
        </select>
        <select>
            <option>KÍCH THƯỚC MẶT SỐ</option>
            <option>36mm</option>
            <option>40mm</option>
            <option>42mm</option>
        </select>
        <select>
            <option>CHẤT LIỆU DÂY</option>
            <option>Thép không gỉ</option>
            <option>Da</option>
            <option>Cao su</option>
        </select>
        <select>
            <option>CHẤT LIỆU MẶT KÍNH</option>
            <option>Khoáng</option>
            <option>Sapphire</option>
        </select>
        <select>
            <option>MỨC CHỐNG NƯỚC</option>
            <option>50m</option>
            <option>100m</option>
            <option>200m</option>
        </select>
        <select>
            <option>BỘ MÁY & NĂNG LƯỢNG</option>
            <option>Quartz</option>
            <option>Automatic</option>
        </select>
        <select>
            <option>MÀU MẶT SỐ</option>
            <option>Đen</option>
            <option>Trắng</option>
            <option>Xanh</option>
        </select>
        <select>
            <option>BỘ SƯU TẬP</option>
            <option>Classic</option>
            <option>Sport</option>
        </select>
        <select>
            <option>PHIÊN BẢN ĐẶC BIỆT</option>
            <option>Limited Edition</option>
        </select>
        <select>
            <option>Thứ tự theo điểm đánh giá</option>
            <option>Điểm cao nhất</option>
            <option>Điểm thấp nhất</option>
        </select>
    </div>
</section>


<script>
    // Lấy phần tử nút và bộ lọc
    const toggleButton = document.getElementById('toggleFilterButton');
    const filterContainer = document.getElementById('filterContainer');

    // Lắng nghe sự kiện click trên nút "Bộ lọc"
    toggleButton.addEventListener('click', () => {
        // Toggle trạng thái hiển thị của bộ lọc
        if (filterContainer.style.display === 'none' || filterContainer.style.display === '') {
            filterContainer.style.display = 'block'; // Hiển thị bộ lọc
        } else {
            filterContainer.style.display = 'none'; // Ẩn bộ lọc
        }
    });
</script>
<div class="product-list">
    <?php
    $sql = "SELECT * FROM dongho_nam";
    $result = $link->query($sql);

    while ($row = $result->fetch_assoc()) {
        $masp = $row['Ma'];
        $tensp = $row['TenSP'];
        $kichthuoc = $row['Kichthuoc'];
        $may = $row['May'];
        $kinh = $row['Kinh'];
        $gia = number_format($row['Gia'], 0, ',', '.');
        $hinhanh = $row['Hinhanh']; // URL của hình ảnh
    ?>
        <!-- Link sẽ dẫn đến infor.php với tham số masp -->
        <a href="http://localhost/Watch_Store_Manage/pages/infor.php?masp=<?php echo $masp; ?>" style="text-decoration: none; color: inherit;">
            <div class="product-item">
                <img src="<?php echo $hinhanh; ?>" alt="<?php echo $tensp; ?>" />
                <div class="product-info">
                    <h2><?php echo $tensp; ?></h2>
                    <p><?php echo ucfirst($row['sex']); ?> - <?php echo "$may - $kinh - Kích thước: $kichthuoc"; ?></p>
                    <span class="price"><?php echo $gia; ?> đ</span>
                </div>
            </div>
        </a>
    <?php } ?>
</div> 



<?php include('includes/footer.php'); ?> <!-- Kế thừa phần footer -->
