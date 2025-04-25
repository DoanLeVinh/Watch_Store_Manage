<?php
// Kết nối tới cơ sở dữ liệu
$host = "localhost";
$username = "root";
$password = "";
$dbname = "project-watch";

$link = new mysqli($host, $username, $password, $dbname);

if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// Truy vấn dữ liệu từ các bảng
$chinhsachQuery = "SELECT * FROM Chinhsach";
$hethongdailiQuery = "SELECT * FROM Hethongdaili";
$thongtinQuery = "SELECT * FROM Thongtin";
$vechungtoiQuery = "SELECT * FROM Vechungtoi";
$thamkhaoQuery = "SELECT * FROM Thamkhao";
$socialQuery = "SELECT * FROM social";

// Thực thi các truy vấn
$chinhsachResult = $link->query($chinhsachQuery);
$hethongdailiResult = $link->query($hethongdailiQuery);
$thongtinResult = $link->query($thongtinQuery);
$vechungtoiResult = $link->query($vechungtoiQuery);
$thamkhaoResult = $link->query($thamkhaoQuery);
$socialResult = $link->query($socialQuery);
?>

<footer class="footer">
    <!-- Phần liên hệ với icon mạng xã hội -->
    <div class="social-links">
    <?php while($social = $socialResult->fetch_assoc()) { ?>
        <a href="<?php echo $social['link']; ?>" class="social-icon <?php echo strtolower($social['platform']); ?>">
            <i class="fab fa-<?php echo strtolower($social['platform']); ?>"></i>
        </a>
    <?php } ?>
    </div>

    <div class="footer-container">
        <!-- Chính sách -->
        <div class="footer-section">
            <h3>CHÍNH SÁCH</h3>
            <ul>
                <?php while($chinhsach = $chinhsachResult->fetch_assoc()) { ?>
                    <li><a href="<?php echo $chinhsach['link']; ?>"><?php echo $chinhsach['title']; ?></a></li>
                <?php } ?>
            </ul>
        </div>

        <!-- Hệ thống đại lý -->
        <div class="footer-section">
            <h3>HỆ THỐNG ĐẠI LÝ</h3>
            <ul>
                <?php while($hethong = $hethongdailiResult->fetch_assoc()) { ?>
                    <li><a href="<?php echo $hethong['link']; ?>"><?php echo $hethong['city']; ?></a></li>
                <?php } ?>
            </ul>
        </div>

        <!-- Thông tin -->
        <div class="footer-section">
            <h3>THÔNG TIN</h3>
            <ul>
                <?php while($thongtin = $thongtinResult->fetch_assoc()) { ?>
                    <li><a href="<?php echo $thongtin['link']; ?>"><?php echo $thongtin['title']; ?></a></li>
                <?php } ?>
            </ul>
        </div>

        <!-- Về chúng tôi -->
        <div class="footer-section">
            <h3>VỀ CHÚNG TÔI</h3>
            <ul>
                <?php while($vechungtoi = $vechungtoiResult->fetch_assoc()) { ?>
                    <li><a href="<?php echo $vechungtoi['link']; ?>"><?php echo $vechungtoi['title']; ?></a></li>
                <?php } ?>
            </ul>
        </div>

        <!-- Tham khảo -->
        <div class="footer-section">
            <h3>THAM KHẢO</h3>
            <ul>
                <?php while($thamkhao = $thamkhaoResult->fetch_assoc()) { ?>
                    <li><a href="<?php echo $thamkhao['link']; ?>"><?php echo $thamkhao['title']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <img src="/Watch_Store_Manage/images/footer.png" alt="Logo">
        <span>Đã thông báo Bộ Công Thương</span>
    </div>
</footer>

<style>
    .footer {
        background-color: #f4f4f4;
        padding: 20px 0;
        font-family: Arial, sans-serif;
    }

    .footer-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: nowrap;
    }

    .footer-section {
        width: 18%;
        padding: 0 20px;
    }

    .footer-section h3 {
        font-weight: bold;
        margin-bottom: 15px;
    }

    .footer-section ul {
        list-style-type: none;
        padding: 0;
    }

    .footer-section ul li {
        margin-bottom: 10px;
    }

    .footer-section ul li a {
        text-decoration: none;
        color: #333;
    }

    .footer-section ul li a:hover {
        text-decoration: underline;
    }

    .footer-bottom {
        background-color: #fff;
        padding: 15px;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    .footer-bottom img {
        margin-right: 10px;
    }

    .footer-bottom span {
        font-size: 14px;
        color: #777;
    }

    /* Phần icon mạng xã hội */
    .social-links {
        text-align: center;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .social-icon {
        font-size: 24px;
        margin: 0 10px;
        text-decoration: none;
        color: #333;
    }

    .social-icon:hover {
        color: #ff5733; /* Thay đổi màu khi hover */
    }

    .social-icon.facebook:hover {
        color: #3b5998; /* Màu Facebook */
    }

    .social-icon.instagram:hover {
        color: #e4405f; /* Màu Instagram */
    }

    .social-icon.twitter:hover {
        color: #1da1f2; /* Màu Twitter */
    }

    .social-icon.tiktok:hover {
        color: #000000; /* Màu TikTok */
    }
</style>

<?php
$link->close();
?>
