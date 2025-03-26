<!-- index.php -->
<?php include('includes/header.php'); ?>  <!-- Kế thừa header -->
<?php include('includes/nav.php'); ?>     <!-- Kế thừa navigation -->

<!-- Nội dung trang chính (index) -->
<main>
    <!-- Main Banner -->
    <section class="banner-container mx-auto mt-4">
    <img alt="Main Banner with watch straps submerged in water" class="w-full" height="400" src="/Watch_Store_Manage/images/baner.png" width="100%"/>
  </section>
<!-- Nội dung giá trị cốt lõi -->
  <section class="features-container">
  <div class="feature">
    <img src="/Watch_Store_Manage/images/item1.png" alt="Sang trọng và tinh tế" />
    <h3>SANG TRỌNG VÀ TINH TẾ</h3>
    <p>Saga luôn giữ vững giá trị cốt lõi là sự sang trọng và tinh tế trong từng sản phẩm. Mỗi chiếc đồng hồ là một tác phẩm nghệ thuật, nói lên phong cách và gu thẩm mỹ đẳng cấp của thương hiệu.</p>
  </div>
  <div class="feature">
    <img src="/Watch_Store_Manage/images/item2.png" alt="Chất lượng và uy tín" />
    <h3>CHẤT LƯỢNG VÀ UY TÍN</h3>
    <p>Chất lượng là giá trị quan trọng nhất mà Saga cam kết với khách hàng, luôn đảm bảo mọi sản phẩm đều đạt tiêu chuẩn cao về chất lượng, từ vật liệu đến quy trình sản xuất, đảm bảo uy tín thương hiệu.</p>
  </div>
  <div class="feature">
    <img src="/Watch_Store_Manage/images/item3.png" alt="Sáng tạo và đổi mới" />
    <h3>SÁNG TẠO VÀ ĐỔI MỚI</h3>
    <p>Liên tục sáng tạo, đổi mới trong thiết kế & công nghệ để mang đến những sản phẩm độc đáo và khác biệt. Thiết kế của Saga luôn là sự kết hợp hài hòa của giá trị truyền thống và xu hướng trong thời trang.</p>
  </div>
</section>

<!-- Container chính -->
<div class="collection-container">
        <!-- Bộ sưu tập lớn -->
        <div class="collection-item large" style="background-image: url('/Watch_Store_Manage/images/bst1.png');">
            <div class="overlay"></div>
            <div class="text">
                <h2>BỘ SƯU TẬP MỚI</h2>
                <p>Xem ngay</p>
            </div>
        </div>
        
        <!-- Đồng hồ nam -->
        <div class="collection-item" style="background-image: url('/Watch_Store_Manage/images/dhmen.png');">
            <div class="overlay"></div>
            <div class="text">
                <h2>NAM</h2>
                <p>Xem ngay</p>
            </div>
        </div>
        
        <!-- Đồng hồ nữ -->
        <div class="collection-item" style="background-image: url('/Watch_Store_Manage/images/dhnu.png');">
            <div class="overlay"></div>
            <div class="text">
                <h2>NỮ</h2>
                <p>Xem ngay</p>
            </div>
        </div>

        <!-- Đồng hồ đôi -->
        <div class="collection-item medium" style="background-image: url('/Watch_Store_Manage/images/bst.png');">
            <div class="overlay"></div>
            <div class="text">
                <h2>TRANG SỨC</h2>
                <p>Xem ngay</p>
            </div>
        </div>
    </div>
<!-- bố cục ảnh -->
    <div class="image-gallery">
    <div class="image-item">
        <img src="/Watch_Store_Manage/images/wm1.png" alt="Đồng hồ nữ" />
        
    </div>
    <div class="image-item">
        <img src="/Watch_Store_Manage/images/m1.png" alt="Đồng hồ nam" />
      
    </div>
    <div class="image-item">
        <img src="/Watch_Store_Manage/images/ts.png" alt="Trang sức" />
       
    </div>
</div>

    
</main>

<?php include('includes/footer.php'); ?> <!-- Kế thừa footer -->
