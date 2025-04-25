<?php
include('config.php');  // Kết nối với database
include('oriented/header.php');  // Đưa phần header vào giao diện
?>
<title>Quản lý Hệ thống</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<style>
   body {
    font-family: 'Roboto', sans-serif;
    background-color: #F4F4F4; /* Nền sáng */
    color: black; /* Chữ đen */
    margin: 0;
    padding: 0;
}

header {
    background-color: #222; /* Nền tối cho header */
    color: white;
    text-align: center;
    padding: 20px 0;
}

h1 {
    font-size: 2.5em;
}

.container {
    width: 80%;
    margin: 40px auto;
    background-color: white; /* Nền trắng cho container */
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
}

.section {
    margin-bottom: 40px;
    padding: 20px;
    border-radius: 8px;
    background-color: #FFFFFF; /* Nền sáng hơn cho từng phần */
}

.section h2 {
    font-size: 1.8em;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #888; /* Dưới mỗi tiêu đề có đường kẻ */
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

table th, table td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
}

table th {
    background-color: #F4F4F4; /* Nền sáng cho header bảng */
    font-weight: bold;
}

.btn-container {
    display: flex;
    gap: 15px;
    margin-bottom: 20px; /* Tạo khoảng cách dưới cho các nút */
}

.btn {
    padding: 10px 20px;
    background-color: #333; /* Nền tối cho các nút */
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 1em;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #555; /* Màu tối hơn khi hover */
}

.btn-save {
    background-color: #28a745; /* Nền xanh lá cho nút Lưu */
}

.btn-save:hover {
    background-color: #218838;
}

.btn-delete {
    background-color: #dc3545; /* Nền đỏ cho nút Xóa */
}

.btn-delete:hover {
    background-color: #c82333;
}

.btn-edit {
    background-color: #ffc107; /* Nền vàng cho nút Sửa */
}

.btn-edit:hover {
    background-color: #e0a800;
}

.logo-preview {
    max-width: 300px;
    margin: 20px 0; /* Tạo khoảng cách giữa logo và các thành phần xung quanh */
}

.input-file {
    margin: 20px 0;
}

.input-file input {
    font-size: 16px;
    padding: 10px;
    width: 100%;
    border-radius: 5px;
    border: 1px solid #ddd;
}

.form-container {
    margin-top: 20px;
    display: flex;
    gap: 20px;
    justify-content: flex-start;
}

.form-container input {
    padding: 10px;
    font-size: 16px;
    width: 300px;
    border-radius: 5px;
    border: 1px solid #ddd;
}

.form-container button {
    padding: 10px 20px;
    background-color: #28a745; /* Nền xanh lá cho nút Lưu */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.form-container button:hover {
    background-color: #218838;
}

.checkbox-item {
    margin-right: 10px;
}

.checkbox-select-all {
    margin-right: 20px;
}

.input-file {
    margin-bottom: 20px;
}

input[type="file"], input[type="text"] {
    margin-bottom: 10px;
}

input[type="file"] {
    padding: 10px;
    font-size: 16px;
}

input[type="text"] {
    padding: 10px;
    width: 100%;
    font-size: 16px;
    border-radius: 5px;
    border: 1px solid #ddd;
}

/* Cập nhật logo */
.input-file, .form-container {
    gap: 20px; /* Khoảng cách giữa các phần tử */
}

.input-file input, .form-container input {
    width: 100%;
    max-width: 300px;
}

img{
    padding: 10px 10px;
}

</style>

<div class="container">

    <!-- Quản lý Header -->
    <div class="section">
        <h2>Quản lý Header</h2>
        <div class="btn-container">
            <button class="btn btn-edit" onclick="editHeader()">Sửa</button>
            <button class="btn btn-delete" onclick="deleteSelected()">Xóa đã chọn</button>
            <button class="btn btn-save" onclick="saveChanges()">Lưu</button>
        </div>
        <table>
            <tr>
                <th><input type="checkbox" class="checkbox-select-all" onclick="selectAllHeaders()"></th>
                <th>ID</th>
                <th>Nội dung Header</th>
            </tr>
            <?php
                $query = "SELECT * FROM header_texts";  // Lấy dữ liệu từ bảng header_texts
                $result = $link->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td><input type='checkbox' class='checkbox-item' data-id='" . $row['id'] . "'></td>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['text_content'] . "</td>
                          </tr>";
                }
            ?>
        </table>
    </div>

    <!-- Quản lý Navigation -->
    <div class="section">
        <h2>Quản lý Navigation</h2>
        <div class="btn-container">
            <button class="btn btn-edit" onclick="editNav()">Sửa</button>
            <button class="btn btn-delete" onclick="deleteSelected()">Xóa đã chọn</button>
            <button class="btn btn-save" onclick="saveChanges()">Lưu</button>
        </div>
        <table>
            <tr>
                <th><input type="checkbox" class="checkbox-select-all" onclick="selectAllNav()"></th>
                <th>ID</th>
                <th>Name</th>
                <th>URL</th>
            </tr>
            <?php
                $query = "SELECT * FROM navigation";  // Lấy dữ liệu từ bảng navigation
                $result = $link->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td><input type='checkbox' class='checkbox-item' data-id='" . $row['id'] . "'></td>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['name'] . "</td>
                            <td>" . $row['url'] . "</td>
                          </tr>";
                }
            ?>
        </table>

        <!-- Cập nhật logo -->
        <div class="logo-preview">
            <h3>Logo hiện tại:</h3>
            <img src="/Watch_Store_Manage/images/Logo.png" alt="Logo preview" />
        </div>

        <div class="input-file">
            <h3>Cập nhật logo:</h3>
            <form action="upload_logo.php" method="post" enctype="multipart/form-data">
                <input type="file" name="logo" accept="image/*" />
                <button type="submit" class="btn btn-save">Tải lên logo</button>
            </form>
            <p>Hoặc nhập URL của logo mới:</p>
            <form action="update_logo.php" method="post">
                <input type="text" name="logo_url" placeholder="Nhập URL logo mới" />
                <button type="submit" class="btn btn-save">Cập nhật URL logo</button>
            </form>
        </div>
    </div>

    <!-- Quản lý Footer -->
    <div class="section">
        <h2>Quản lý Footer</h2>
        <div class="btn-container">
            <button class="btn btn-edit" onclick="editFooter()">Sửa</button>
            <button class="btn btn-delete" onclick="deleteSelected()">Xóa đã chọn</button>
            <button class="btn btn-save" onclick="saveChanges()">Lưu</button>
        </div>
        <table>
            <tr>
                <th><input type="checkbox" class="checkbox-select-all" onclick="selectAllFooter()"></th>
                <th>ID</th>
                <th>Title</th>
                <th>Link</th>
            </tr>
            <?php
                $query = "SELECT * FROM chinhsach";  // Lấy dữ liệu từ bảng chinhsach
                $result = $link->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td><input type='checkbox' class='checkbox-item' data-id='" . $row['id'] . "'></td>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['title'] . "</td>
                            <td>" . $row['link'] . "</td>
                          </tr>";
                }
            ?>
        </table>
    </div>

</div>

<script>
    // Chọn tất cả các checkbox
    function selectAllHeaders() {
        const checkboxes = document.querySelectorAll('.checkbox-item');
        checkboxes.forEach(checkbox => checkbox.checked = event.target.checked);
    }

    function selectAllNav() {
        const checkboxes = document.querySelectorAll('.checkbox-item');
        checkboxes.forEach(checkbox => checkbox.checked = event.target.checked);
    }

    function selectAllFooter() {
        const checkboxes = document.querySelectorAll('.checkbox-item');
        checkboxes.forEach(checkbox => checkbox.checked = event.target.checked);
    }

    // Xóa các mục đã chọn
    function deleteSelected() {
        const selectedItems = document.querySelectorAll('.checkbox-item:checked');
        const ids = [];
        selectedItems.forEach(item => ids.push(item.dataset.id));

        // Gửi dữ liệu xóa qua AJAX hoặc PHP
        alert("Đang xóa các mục có ID: " + ids.join(', '));
    }

    // Lưu các thay đổi
    function saveChanges() {
        alert("Đã lưu thay đổi");
        // Bạn có thể thêm AJAX hoặc một phương thức gửi dữ liệu qua PHP để lưu thay đổi.
    }
</script>

</body>
</html>
