<?php
include('config.php');  // Kết nối với database
include('oriented/header.php');
// Kiểm tra yêu cầu POST (Thêm, Cập nhật hoặc Xóa Navigation)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Thêm mới Navigation
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $url = $_POST['url'];

        // Kiểm tra nếu id, name và url không rỗng
        if (empty($id) || empty($name) || empty($url)) {
            echo json_encode(['success' => false, 'message' => 'ID, Tên và URL không được để trống']);
            exit;
        }

        $query = "INSERT INTO navigation (id, name, url) VALUES (?, ?, ?)";
        $stmt = $link->prepare($query);
        $stmt->bind_param('iss', $id, $name, $url);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Đã thêm navigation mới.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi khi thêm navigation.']);
        }
        exit;
    }

    // Cập nhật Navigation
    if (isset($_POST['action']) && $_POST['action'] == 'update') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $url = $_POST['url'];

        // Kiểm tra nếu name và url không rỗng
        if (empty($name) || empty($url)) {
            echo json_encode(['success' => false, 'message' => 'Tên và URL không được để trống']);
            exit;
        }

        $query = "UPDATE navigation SET name = ?, url = ? WHERE id = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('ssi', $name, $url, $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Đã cập nhật navigation.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi khi cập nhật navigation.']);
        }
        exit;
    }

    // Xóa Navigation
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = $_POST['id'];

        // Kiểm tra nếu id không rỗng
        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => 'ID không hợp lệ']);
            exit;
        }

        $query = "DELETE FROM navigation WHERE id = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Đã xóa navigation.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi khi xóa navigation.']);
        }
        exit;
    }
}
?>

<title>Quản lý Navigation</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #222;
        color: white;
        text-align: center;
        padding: 20px 0;
    }

    .container {
        width: 80%;
        margin: 40px auto;
        background-color: white;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .section {
        margin-bottom: 40px;
        padding: 20px;
        border-radius: 8px;
        background-color: #fff;
    }

    .section h2 {
        font-size: 1.8em;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #ccc;
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
        background-color: #f4f4f4;
    }

    .btn-container {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }

    .btn {
        padding: 10px 20px;
        background-color: #333;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1em;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #555;
    }

    .btn-save {
        background-color: #28a745;
    }

    .btn-save:hover {
        background-color: #218838;
    }

    .btn-edit {
        background-color: #ffc107;
    }

    .btn-edit:hover {
        background-color: #e0a800;
    }

    .btn-delete {
        background-color: #dc3545;
    }

    .btn-delete:hover {
        background-color: #c82333;
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
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .form-container button:hover {
        background-color: #218838;
    }
</style>

<div class="container">
    <!-- Quản lý Navigation -->
    <div class="section">
        <h2>Quản lý Navigation</h2>

        <!-- Thêm Navigation Mới -->
        <h3>Thêm Navigation Mới</h3>
        <div class="form-container">
            <input type="text" id="newNavId" placeholder="Nhập ID Navigation" />
            <input type="text" id="newNavName" placeholder="Nhập Tên Navigation" />
            <input type="text" id="newNavUrl" placeholder="Nhập URL" />
            <button class="btn btn-save" onclick="addNewNavigation()">Thêm Navigation</button>
        </div>

        <!-- Danh sách Navigation -->
        <table id="navigation-table">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>URL</th>
                <th>Thao tác</th>
            </tr>
            <?php
                $query = "SELECT * FROM navigation";  // Lấy dữ liệu từ bảng navigation
                $result = $link->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr id='nav-" . $row['id'] . "'>
                            <td class='editable' data-id='" . $row['id'] . "'>" . $row['id'] . "</td>
                            <td class='editable' data-id='" . $row['id'] . "'>" . $row['name'] . "</td>
                            <td class='editable' data-id='" . $row['id'] . "'>" . $row['url'] . "</td>
                            <td>
                                <button class='btn btn-edit' onclick='editNavigation(" . $row['id'] . ")'>Sửa</button>
                                <button class='btn btn-delete' onclick='deleteNavigation(" . $row['id'] . ")'>Xóa</button>
                            </td>
                          </tr>";
                }
            ?>
        </table>
    </div>
</div>

<script>
    // Thêm Navigation mới
    function addNewNavigation() {
        const id = document.getElementById('newNavId').value;
        const name = document.getElementById('newNavName').value;
        const url = document.getElementById('newNavUrl').value;

        if (id.trim() === "" || name.trim() === "" || url.trim() === "") {
            alert("Vui lòng nhập ID, Tên và URL.");
            return;
        }

        // Gửi dữ liệu lên server để thêm vào database
        const formData = new FormData();
        formData.append('action', 'add');
        formData.append('id', id);
        formData.append('name', name);
        formData.append('url', url);

        fetch('QL-nav.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Đã thêm navigation mới.");
                location.reload();  // Tải lại trang để cập nhật danh sách
            } else {
                alert(data.message || "Có lỗi khi thêm navigation.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Đã có lỗi xảy ra khi thêm navigation.");
        });
    }

    // Chỉnh sửa navigation
    function editNavigation(id) {
        const name = prompt("Nhập tên mới cho Navigation:");
        const url = prompt("Nhập URL mới cho Navigation:");

        if (name && url) {
            const formData = new FormData();
            formData.append('action', 'update');
            formData.append('id', id);
            formData.append('name', name);
            formData.append('url', url);

            fetch('QL-nav.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();  // Tải lại trang để cập nhật danh sách
                } else {
                    alert(data.message || "Có lỗi khi cập nhật navigation.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Đã có lỗi xảy ra khi cập nhật navigation.");
            });
        }
    }

    // Xóa navigation
    function deleteNavigation(id) {
        if (confirm("Bạn có chắc chắn muốn xóa navigation này?")) {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);

            fetch('QL-nav.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    document.getElementById('nav-' + id).remove();  // Xóa dòng tương ứng trong bảng
                } else {
                    alert(data.message || "Có lỗi khi xóa navigation.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Đã có lỗi xảy ra khi xóa navigation.");
            });
        }
    }
</script>

</body>
</html>
