<!-- men.php -->
<?php include('includes/header.php'); ?>  <!-- Kế thừa phần header -->
<?php include('includes/nav.php'); ?>     <!-- Kế thừa phần nav -->
 <!-- Tải font Roboto từ Google Fonts -->
 <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<main>
    <?php include("connect.php"); ?>
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
         <a class="a1" href="/Watch_Store_Manage/pages/men.php">
        <div class="collection-item" style="background-image: url('/Watch_Store_Manage/images/dhmen.png');">
            <div class="overlay"></div>
            <div class="text">
                <h2>NAM</h2>
                <p>Xem ngay</p>
            </div>
        </div>
        </a>
        
        <!-- Đồng hồ nữ -->
         <a class="a1" href="/Watch_Store_Manage/pages/women.php">
        <div class="collection-item" style="background-image: url('/Watch_Store_Manage/images/dhnu.png');">
            <div class="overlay"></div>
            <div class="text">
                <h2>NỮ</h2>
                <p>Xem ngay</p>
            </div>
        </div>
        </a>

        <!-- Đồng hồ đôi -->
        <div class="collection-item medium" style="background-image: url('/Watch_Store_Manage/images/bst.png');">
            <div class="overlay"></div>
            <div class="text">
                <h2>TRANG SỨC</h2>
                <p>Xem ngay</p>
            </div>
        </div>
    </div>


    <style>
        .bst{
            font-size: 35px;
            color:rgb(135, 134, 134) ;
            text-align: center;
            margin-top: 20px;
        }

        .xn{
            text-align: center;
            font-style: italic;
            font-weight: 400;
            color:rgb(135, 134, 134) ;
        }

        .a1{
            text-decoration: none;
        }

        .bst:hover{
            color: black;
            font-style: italic;
        }


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
    margin: 10px auto; /* Căn giữa ảnh và giảm khoảng cách giữa các ảnh */
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

    <!-- Phần riêng biệt của giao diện -->
<a class="e1" href="/Watch_Store_Manage/pages/women.php">
    <h2 class="e2">Bộ sưu tập đồng hồ nữ </h2>
    <p class="e3">xem ngay</p>
</a>

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

<a class="e1" href="/Watch_Store_Manage/pages/jewelry.php">
    <h2 class="e2">Bộ sưu tập trang sức-phụ kiện</h2>
    <p class="e3">xem ngay</p>
</a>
<!-- Phần riêng biệt của giao diện -->

<div class="e4">
    <div class="e5">
        <img src="/Watch_Store_Manage/images/bstts1.png" alt="Stella">
    </div>
    <div class="e5">
        <img src="/Watch_Store_Manage/images/bstts2.png" alt="Stella Rectangle">
    </div>
    <div class="e5">
        <img src="/Watch_Store_Manage/images/bstts3.png" alt="Stella Chance">
    </div>
    <div class="e5">
        <img src="/Watch_Store_Manage/images/bstts4.png" alt="MOP Diamonds">
    </div>
    <div class="e5">
        <img src="/Watch_Store_Manage/images/bstts5.png" alt="Lunar">
    </div>
    <div class="e5">
        <img src="/Watch_Store_Manage/images/bstn6.png" alt="Dancing Heart">
    </div>
</div>


    <h2 class="bst">Mẫu đồng hồ gợi ý cho bạn</h2>



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
        <a href="/Watch_Store_Manage/pages/infor.php?masp=<?php echo $masp; ?>" style="text-decoration: none; color: inherit;">
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
</main>
<?php include('includes/footer.php'); ?> <!-- Kế thừa phần footer -->
