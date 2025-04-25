<?php
// Kết nối tới cơ sở dữ liệu
$host = "localhost";
$username = "root";
$password = "";
$dbname = "project-watch"; // Tên cơ sở dữ liệu của bạn

$link = new mysqli($host, $username, $password, $dbname);

if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// Truy vấn dữ liệu từ bảng header_texts
$query = "SELECT text_content FROM header_texts";
$result = $link->query($query);

// Lấy các văn bản thay đổi và lưu vào một mảng
$texts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $texts[] = $row['text_content'];
    }
}

// Đóng kết nối cơ sở dữ liệu
$link->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="js/script.js" defer></script> <!-- Bạn có thể thêm JavaScript ở đây -->
    <link href="/Watch_Store_Manage/css/contact.css" rel="stylesheet">
    <link href="/Watch_Store_Manage/css/men.css" rel="stylesheet">
    <link href="/Watch_Store_Manage/css/women.css" rel="stylesheet">
    <link href="/Watch_Store_Manage/css/jewelry.css" rel="stylesheet">
    <link href="/Watch_Store_Manage/css/index.css" rel="stylesheet">
    
    <style>
        *{
            font-family: 'Be Vietnam Pro';
        }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
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
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 500;
            line-height: 1.2;
        }

        #header-text {
            transition: opacity 0.3s ease-in-out;
        }
    </style>
</head>
<body>

   <div class="header">
       <div id="header-text" class="fade">
           <?php
           // Hiển thị văn bản thay đổi từ mảng $texts
           echo $texts[0]; // Mặc định hiển thị văn bản đầu tiên
           ?>
       </div>
   </div>

   <script>
       const texts = <?php echo json_encode($texts); ?>; // Chuyển mảng PHP sang JavaScript

       let index = 0;
       function changeHeaderText() {
           const headerText = document.getElementById("header-text");

           // Ẩn nội dung cũ
           headerText.style.opacity = 0;

           setTimeout(() => {
               // Cập nhật nội dung mới
               index = (index + 1) % texts.length;
               headerText.textContent = texts[index];

               // Hiển thị nội dung mới
               headerText.style.opacity = 1;
           }, 500); // Đợi 0.5s để mờ đi rồi mới đổi nội dung
       }

       setInterval(changeHeaderText, 3000); // Cập nhật mỗi 3 giây
   </script>

</body>
</html>
