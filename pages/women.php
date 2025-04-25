<?php include('includes/header.php'); ?>  <!-- Kế thừa phần header -->
<?php include('includes/nav.php'); ?>     <!-- Kế thừa phần nav -->
 <!-- Tải font Roboto từ Google Fonts -->
 <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
 <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400&display=swap" rel="stylesheet">

</head>
<body>
<style>
    /* Căn giữa các phần tử */
    .e4 {
    display: flex;
    flex-wrap: wrap; /* Cho phép phần tử tràn ra dòng mới khi cần thiết */
    justify-content: center; /* Căn giữa các phần tử */
    gap: 20px; /* Khoảng cách giữa các bộ sưu tập */
    margin: 0 auto; /* Căn giữa container */
    max-width: 1200px; /* Giới hạn chiều rộng container */
}

/* Mỗi phần tử trong bộ sưu tập */
.e5 {
    width: calc(33.33% - 20px); /* Chia đều mỗi phần tử thành 3 cột, trừ khoảng cách */
    box-sizing: border-box; /* Bao gồm cả padding và border trong kích thước */
    border-radius: 10px; /* Bo góc cho các phần tử */
    overflow: hidden; /* Ẩn các phần bị tràn ra ngoài */
    text-align: center; /* Căn giữa nội dung trong phần tử */
    margin-bottom: 20px; /* Khoảng cách dưới mỗi bộ sưu tập */
}

/* Đảm bảo ảnh trong mỗi phần tử không bị lệch hoặc méo */
.e5 img {
    width: 80%; /* Giảm kích thước ảnh xuống 80% */
    height: auto;
    display: block;
    margin: 5px; /* Căn giữa ảnh và giảm khoảng cách giữa các ảnh */
    border-radius: 10px; /* Bo góc cho ảnh */
}

/* Tiêu đề trong bộ sưu tập */
.e2 {
    text-align: center; /* Căn giữa tiêu đề */
    text-decoration: none; /* Loại bỏ gạch chân */
    font-size: 1.2em; /* Kích thước chữ lớn hơn */
    margin-top: 10px; /* Khoảng cách giữa ảnh và tiêu đề */
}

/* Loại bỏ gạch chân cho mô tả */
.e3 {
    text-align: center;
    text-decoration: none; /* Loại bỏ gạch chân */
    font-size: 1em; /* Kích thước chữ nhỏ hơn */
    color: #555; /* Màu chữ cho mô tả */
    margin-top: 5px; /* Khoảng cách giữa mô tả và tiêu đề */
}

/* Điều chỉnh kích thước cho các màn hình nhỏ hơn */
@media screen and (max-width: 768px) {
    .e5 {
        width: calc(50% - 20px); /* 2 cột trên màn hình nhỏ */
    }
}

@media screen and (max-width: 480px) {
    .e5 {
        width: 100%; /* 1 cột trên màn hình nhỏ nhất */
    }
}
</style>
<section class="banner-title">
    Đồng hồ nữ đẹp chính hãng, cao cấp, mẫu mới 2025
</section>

<section class="banner-container mx-auto mt-4">
    <!-- Ảnh Banner -->
    <img alt="Main Banner with watch straps submerged in water" src="/Watch_Store_Manage/images/women1.png" />
</section>



     <!-- Phần nội dung mà bạn muốn thiết kế -->
     <div class="custom-content">
        <p>Thiên đường mẫu mã đồng hồ nữ đến từ nhà mốt Saga. Cập nhật xu hướng đồng hồ nữ mới nhất với nhiều phiên bản đính đá, đính kim cương, charm và kiểu dáng mặt số độc đáo. Thể hiện cá tính và phong cách thời trang của bạn chỉ với một món phụ kiện.</p>
    </div>


    <div class="e4">
    <div class="e5">
        <img src="/Watch_Store_Manage/images/bstn1.png" alt="Stella">
    </div>
    <div class="e5">
        <img src="/Watch_Store_Manage/images/bstn2.png" alt="Stella Rectangle">
    </div>
    <div class="e5">
        <img src="/Watch_Store_Manage/images/bstn3.png" alt="Stella Chance">
    </div>
    <div class="e5">
        <img src="/Watch_Store_Manage/images/bstn4.png" alt="MOP Diamonds">
    </div>
    <div class="e5">
        <img src="/Watch_Store_Manage/images/bstn5.png" alt="Lunar">
    </div>
    <div class="e5">
        <img src="/Watch_Store_Manage/images/bstn6.png" alt="Dancing Heart">
    </div>
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

<?php include("connect.php"); ?>

<div class="product-list">
    <?php
    $sql = "SELECT * FROM dongho_nu";
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