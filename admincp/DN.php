<?php
session_start(); // Đảm bảo session được khởi tạo

include('config.php'); // Kết nối cơ sở dữ liệu

// Kiểm tra nếu form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = $_POST['password'];

    // Truy vấn để lấy mật khẩu từ cơ sở dữ liệu
    $sql = "SELECT password FROM users WHERE username='$username'";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $password_from_db = $row['password']; // Mật khẩu trong cơ sở dữ liệu

        // Sử dụng password_verify nếu mật khẩu được mã hóa
        if ($password == $password_from_db) {
            // Mật khẩu đúng, đăng nhập thành công
            $_SESSION['username'] = $username;
            $_SESSION['admin_logged_in'] = true; // Thiết lập session đăng nhập thành công
            header("Location: /Watch_Store_Manage/admincp/index.php"); // Chuyển hướng đến giao diện index.php của admin
            exit();
        } else {
            // Mật khẩu sai
            echo "<p class='error'>Tên đăng nhập hoặc mật khẩu không đúng!</p>";
        }
    } else {
        // Tên đăng nhập không tồn tại
        echo "<p class='error'>Tên đăng nhập không tồn tại!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin</title>
    <style>
       body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #333; /* Màu nền tối */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #fff; /* Màu nền trắng cho form đăng nhập */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        h2 {
            color: #333; /* Màu chữ tiêu đề */
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            color: #333;
            transition: all 0.3s ease;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #5cb85c; /* Đổi màu border khi focus */
            outline: none;
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c; /* Màu khi hover */
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Đăng nhập Admin</h2>
        <form action="DN.php" method="POST">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" value="Đăng nhập">
        </form>
    </div>

</body>
</html>
