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