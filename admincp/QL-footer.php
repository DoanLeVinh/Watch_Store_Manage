<?php
// Kết nối với database
$host = 'localhost';  // Địa chỉ server
$username = 'root';   // Tên người dùng
$password = '';       // Mật khẩu
$dbname = 'project-watch'; // Tên database

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Xử lý các hành động Thêm, Sửa, Xóa
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';  // Sử dụng toán tử null coalescing để tránh lỗi Undefined array key
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $link = $_POST['link'] ?? '';

    switch ($action) {
        case 'add':
            $table = 'chinh_sach';  // Table mặc định
            $sql = "INSERT INTO $table (name, link) VALUES ('$name', '$link')";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => $conn->error]);
            }
            break;

        case 'update':
            $table = 'chinh_sach';  // Table mặc định
            $sql = "UPDATE $table SET name='$name', link='$link' WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => $conn->error]);
            }
            break;

        case 'delete':
            $table = 'chinh_sach';  // Table mặc định
            $sql = "DELETE FROM $table WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => $conn->error]);
            }
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET['action'] == 'edit' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $table = 'chinh_sach';  // Table mặc định
        $sql = "SELECT * FROM $table WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo json_encode($row);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Footer</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<h1>Quản lý Footer</h1>

<!-- Bộ lọc -->
<select id="table_filter" onchange="filterTable()">
    <option value="">Chọn bảng</option>
    <option value="chinh_sach">Chính sách</option>
    <option value="hethongdaili">Hệ thống đại lý</option>
    <option value="social">Social</option>
    <option value="thamkhao">Tham khảo</option>
    <option value="thongtin">Thông tin</option>
    <option value="vechungtoi">Về chúng tôi</option>
</select>

<!-- Bảng dữ liệu footer -->
<table id="footer_table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Link</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $table = isset($_GET['table']) ? $_GET['table'] : 'chinhsach';
        $sql = "SELECT * FROM $table";
        $result = $conn->query($sql);
        
        while($row = $result->fetch_assoc()) {
            echo "<tr id='row_{$row['id']}'>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['link']}</td>
                    <td>
                        <button onclick='editFooter({$row['id']})'>Sửa</button>
                        <button onclick='deleteFooter({$row['id']})'>Xóa</button>
                    </td>
                  </tr>";
        }
        ?>
    </tbody>
</table>

<!-- Form thêm, sửa footer -->
<div id="footer_form" style="display:none;">
    <h3 id="form_title">Thêm mới Footer</h3>
    <form id="footer_form_action">
        <input type="hidden" id="footer_id">
        <label>Tên:</label>
        <input type="text" id="footer_name">
        <br>
        <label>Link:</label>
        <input type="text" id="footer_link">
        <br>
        <button type="submit">Lưu</button>
    </form>
</div>

<script>
    // Bộ lọc bảng
    function filterTable() {
        var table = document.getElementById("table_filter").value;
        window.location.href = "footer_management.php?table=" + table;
    }

    // Chỉnh sửa Footer
    function editFooter(id) {
        $.ajax({
            url: 'footer_management.php',
            method: 'GET',
            data: { action: 'edit', id: id },
            success: function(response) {
                var data = JSON.parse(response);
                $('#footer_id').val(data.id);
                $('#footer_name').val(data.name);
                $('#footer_link').val(data.link);
                $('#form_title').text('Chỉnh sửa Footer');
                $('#footer_form').show();
            }
        });
    }

    // Xóa Footer
    function deleteFooter(id) {
        if (confirm("Bạn có chắc chắn muốn xóa footer này?")) {
            $.ajax({
                url: 'footer_management.php',
                method: 'POST',
                data: { action: 'delete', id: id },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        alert("Đã xóa footer thành công!");
                        $('#row_' + id).remove();
                    } else {
                        alert("Có lỗi xảy ra khi xóa footer.");
                    }
                }
            });
        }
    }

    // Thêm mới hoặc Cập nhật Footer
    $('#footer_form_action').on('submit', function(event) {
        event.preventDefault();
        var id = $('#footer_id').val();
        var name = $('#footer_name').val();
        var link = $('#footer_link').val();

        $.ajax({
            url: 'footer_management.php',
            method: 'POST',
            data: { action: (id ? 'update' : 'add'), id: id, name: name, link: link },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    alert("Đã lưu footer thành công!");
                    window.location.reload();
                } else {
                    alert("Có lỗi xảy ra khi lưu footer.");
                }
            }
        });
    });
</script>

</body>
</html>
