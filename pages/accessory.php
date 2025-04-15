<?php include('includes/header.php'); ?>  <!-- Kế thừa phần header -->
<?php include('includes/nav.php'); ?>     <!-- Kế thừa phần nav -->
 <!-- Tải font Roboto từ Google Fonts -->
 <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
 <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400&display=swap" rel="stylesheet">

</head>
<body>

<section class="banner-title">
Hoa tai/bông tai đẹp, thời trang, xu hướng, chính hãng 100%
</section>

<section class="banner-container mx-auto mt-4">
    <!-- Ảnh Banner -->
    <img alt="Main Banner with watch straps submerged in water" src="/Watch_Store_Manage/images/accessory1.png" />
</section>



     <!-- Phần nội dung mà bạn muốn thiết kế -->
     <div class="custom-content">
        <p>Chỉ với một món phụ kiện hoa tai đến từ Saga sẽ thổi bùng phong cách cá tính của phái đẹp trong nhiều dịp quan trọng. Đặc biệt toả sáng trong các bữa tiệc tùng nhờ sự xuất hiện của đá Swarovski độ tán sắc cao, chất liệu được phủ Rhodium gia tăng độ bền cho chất liệu cùng kiểu dáng độc đáo chinh phục được cả những nàng khó tính nhất.</p>
    </div>


    <!-- Phần riêng biệt của giao diện -->

    <div class="watch-collection">
        <div class="card">
            <img src="/Watch_Store_Manage/images/accessory2.png" alt="Stella">
        </div>
        <div class="card">
            <img src="/Watch_Store_Manage/images/accessory3.png" alt="Stella Rectangle">
        </div>
        <div class="card">
            <img src="/Watch_Store_Manage/images/accessory4.png" alt="Stella Chance">
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

<div class="product-list">
    <div class="product-item">
        <img src="/Watch_Store_Manage/images/dhn1.png" alt="Saga Long Xing Da Da" />
        <div class="product-info">
            <h2>Saga Lunar 71959-GPGPGP-2 – Mặt số 20x26mm</h2>
            <p>Cảm hứng Nữ Thần Mặt Trăng – Đính đá</p>
            <span class="price">8.540.000 ₫</span>
        </div>
    </div>
    <div class="product-item">
        <img src="/Watch_Store_Manage/images/dhn2.png" alt="Saga Signature 13703-SVBDK-3" />
        <div class="product-info">
            <h2>Saga Stella 53555-SVMWSV-2</h2>
            <p>Mặt số 22.5 mm, Khảm xà cừ, dây lắc, đính đá</p>
            <span class="price">12.840.000 đ</span>
        </div>
    </div>
    <div class="product-item">
        <img src="/Watch_Store_Manage/images/men/Saga3.png" alt="Saga 53198-SVSVBK-2" />
        <div class="product-info">
            <h2>Saga 53198-SVSVBK-2</h2>
            <p>Nam - Kính Cứng - Quartz (Pin) - Giới Hạn 186 Chiếc - Kỷ niệm 30 năm thành lập Đồng Hồ Hải Triều</p>
            <span class="price">4.600.000 đ</span>
        </div>
    </div>
    <div class="product-item">
        <img src="/Watch_Store_Manage/images/men/Saga4.png" alt="Saga 13568-SVGEPUg-2" />
        <div class="product-info">
            <h2>Saga 13568-SVGEPUg-2</h2>
            <p>Nam - Kính Sapphire - Quartz (Pin) - Mặt Số 42mm, Chống nước 5ATM</p>
            <span class="price">9.550.000 đ</span>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?> <!-- Kế thừa phần footer -->