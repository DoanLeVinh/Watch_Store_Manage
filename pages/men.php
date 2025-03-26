<!-- men.php -->
<?php include('includes/header.php'); ?>  <!-- Kế thừa phần header -->
<?php include('includes/nav.php'); ?>     <!-- Kế thừa phần nav -->
 <!-- Tải font Roboto từ Google Fonts -->
 <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>
<body>

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
    <div class="product-item">
        <img src="/Watch_Store_Manage/images/men/Saga1.png" alt="Saga Long Xing Da Da" />
        <div class="product-info">
            <h2>Saga Long Xing Da Da 13665-SVPEBK-3LH</h2>
            <p>Nam - Đồng hồ Rồng Vàng Giới hạn 999 chiếc - Automatic, lộ cơ</p>
            <span class="price">16.880.000 đ</span>
        </div>
    </div>
    <div class="product-item">
        <img src="/Watch_Store_Manage/images/men/Saga2.png" alt="Saga Signature 13703-SVBDK-3" />
        <div class="product-info">
            <h2>Saga Signature 13703-SVBDK-3</h2>
            <p>Nam - Automatic - Lộ cơ triết lý Âm-Dương trên bề mặt số</p>
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
