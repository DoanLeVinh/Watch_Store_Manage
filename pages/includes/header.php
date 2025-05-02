<?php
// Kết nối tới cơ sở dữ liệu
$host = "localhost";
$username = "root";
$password = "";
$dbname = "project-watch";

$link = new mysqli($host, $username, $password, $dbname);
if ($link->connect_error) {
    die("Kết nối thất bại: " . $link->connect_error);
}

// Truy vấn dữ liệu từ bảng header_texts
$query = "SELECT text_content FROM header_texts";
$result = $link->query($query);

// Lưu các văn bản vào mảng
$texts = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $texts[] = $row['text_content'];
    }
}

$link->close(); // Đóng kết nối
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header Thay Đổi Văn Bản</title>

    <!-- Fonts & CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="/Watch_Store_Manage/css/contact.css" rel="stylesheet">
    <link href="/Watch_Store_Manage/css/men.css" rel="stylesheet">
    <link href="/Watch_Store_Manage/css/women.css" rel="stylesheet">
    <link href="/Watch_Store_Manage/css/jewelry.css" rel="stylesheet">
    <link href="/Watch_Store_Manage/css/index.css" rel="stylesheet">

    <!-- Script -->
    <script src="js/script.js" defer></script>

    <!-- Style nội bộ -->
    <style>
        * {
            font-family: 'Be Vietnam Pro', sans-serif;
        }

        body {
            margin: 0;
            background-color: white;
        }

        .header {
            background-color: #f2f2f2;
            color: #333;
            text-align: center;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 16px;
            font-weight: 500;
        }

        #header-text {
            transition: opacity 0.3s ease-in-out;
        }
    </style>
</head>

<body>

    <!-- Vùng hiển thị văn bản động -->
    <div class="header">
        <div id="header-text">
            <?php
            // Hiển thị văn bản đầu tiên nếu có
            echo $texts[0] ?? 'Chào mừng đến với Watch Store!';
            ?>
        </div>
    </div>

    <!-- Script thay đổi văn bản theo chu kỳ -->
    <script>
        const texts = <?php echo json_encode($texts); ?>;
        let index = 0;

        function changeHeaderText() {
            const headerText = document.getElementById("header-text");
            headerText.style.opacity = 0;

            setTimeout(() => {
                index = (index + 1) % texts.length;
                headerText.textContent = texts[index];
                headerText.style.opacity = 1;
            }, 500);
        }

        // Chạy hàm mỗi 2 giây
        setInterval(changeHeaderText, 2000);
    </script>

</body>
</html>
