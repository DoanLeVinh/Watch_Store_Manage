<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Admin</title>
    <link href="/Watch_Store_Manage/css/admin.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <h2 class="login-title">Đăng Nhập Admin</h2>
        <form class="login-form" action="admin_dashboard.html" method="POST">
            <div class="input-group">
                <label for="username">Tên Đăng Nhập</label>
                <input type="text" id="username" name="username" placeholder="Nhập tên đăng nhập" required>
            </div>
            <div class="input-group">
                <label for="password">Mật Khẩu</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
            </div>
            <button type="submit" class="login-btn">Đăng Nhập</button>
        </form>
        <div class="forgot-password">
             <a href="/Watch_Store_Manage/admincp/QL-header.php">Quản lý Header</a>
        </div>
    </div>
</body>
</html>
