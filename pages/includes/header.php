<!-- includes/header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Bạn có thể thêm liên kết tới file CSS ở đây -->
    <!-- Tải font Roboto từ Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <script src="js/script.js" defer></script> <!-- Bạn có thể thêm JavaScript ở đây -->
    <link href="/Watch_Store_Manage/css/index.css" rel="stylesheet">
    <link href="/Watch_Store_Manage/css/contact.css" rel="stylesheet">
    <link href="/Watch_Store_Manage/css/men.css" rel="stylesheet">
    <link href="/Watch_Store_Manage/css/women.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: white;
        }
        .header, .nav {
            width: 100%;
            box-sizing: border-box;
        }
        .header {
            border-bottom: 1px solid #e5e5e5;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header a {
            color: #555;
            text-decoration: none;
            font-size: 18px;
        }
        .nav {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav a {
            color: #333;
            text-decoration: none;
            font-size: 18px;
            margin: 0 10px;
        }
        .nav input {
            border: 1px solid #ccc;
            border-radius: 25px;
            padding: 5px 15px;
            font-size: 16px;
        }
        .banner {
            width: 100%;
            margin-top: 20px;
        }
        .banner img {
            width: 100%;
            height: auto;
        }
        .chat-support {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: rgba(230, 0, 157, 0.5);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            display: flex;
            align-items: center;
        }
        .chat-support i {
            margin-left: 10px;
        }
    </style>
</head>
<body>
   <!-- Header -->
   <div class="header">
       <div id="header-text" class="fade">Quyền được an tâm</div>
   </div>

   <script>
       const texts = [
           "Quyền được an tâm",
           "Bộ sưu tập đồng hồ mới nhất",
           "Nghe tư vấn từ chuyên gia",
           "Đăng kí để nhận thêm nhiều ưu đãi",
           "Luôn cập nhật xu hướng thị trường"
       ];

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

       setInterval(changeHeaderText, 3000);
   </script>

   <style>
       @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&display=swap');

       .header {
           background-color: #f2f2f2; /* Nền xám nhẹ */
           color: #333; /* Màu chữ đậm */
           text-align: center;
           height: 30px; /* Header mỏng hơn */
           display: flex;
           justify-content: center;
           align-items: center;
           font-family: 'Playfair Display', serif; /* Font sang trọng */
           font-size: 16px; /* Giảm kích thước chữ */
           font-weight: 500;
           line-height: 1.2; /* Cân đối khoảng cách chữ */
       }

       #header-text {
           transition: opacity 0.3s ease-in-out;
       }
   </style>
</body>
</html>
