<?php
include('config.php');  // Kết nối với database
include('oriented/header.php');  // Đưa phần header vào giao diện

// Kiểm tra yêu cầu POST (Thêm, Cập nhật hoặc Xóa Header)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Thêm Header
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $id = $_POST['id'];
        $text_content = $_POST['text_content'];

        // Kiểm tra nếu id và text_content không rỗng
        if (empty($id) || empty($text_content)) {
            echo json_encode(['success' => false, 'message' => 'ID và Nội dung không được để trống']);
            exit;
        }

        $query = "INSERT INTO header_texts (id, text_content) VALUES (?, ?)";
        $stmt = $link->prepare($query);
        $stmt->bind_param('is', $id, $text_content);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Đã thêm header mới.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi khi thêm header.']);
        }
        exit;
    }

    // Cập nhật Header
    if (isset($_POST['action']) && $_POST['action'] == 'update') {
        $id = $_POST['id'];
        $new_text = $_POST['new_text'];

        // Kiểm tra nếu new_text không rỗng
        if (empty($new_text)) {
            echo json_encode(['success' => false, 'message' => 'Nội dung mới không được để trống']);
            exit;
        }

        $query = "UPDATE header_texts SET text_content = ? WHERE id = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('si', $new_text, $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Đã cập nhật header.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi khi cập nhật header.']);
        }
        exit;
    }

    // Xóa Header
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = $_POST['id'];

        // Kiểm tra nếu id không rỗng
        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => 'ID không hợp lệ']);
            exit;
        }

        $query = "DELETE FROM header_texts WHERE id = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Đã xóa header.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi khi xóa header.']);
        }
        exit;
    }
}
?>

<title>Quản lý Header</title>
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
    <!-- Quản lý Header -->
    <div class="section">
        <h2>Quản lý Header</h2>

        <!-- Thêm Header -->
        <h3>Thêm Header Mới</h3>
        <div class="form-container">
            <input type="text" id="newHeaderId" placeholder="Nhập ID Header" />
            <input type="text" id="newHeaderText" placeholder="Nhập nội dung Header" />
            <button class="btn btn-save" onclick="addNewHeader()">Thêm Header</button>
        </div>

        <!-- Danh sách Header -->
        <table id="header-table">
            <tr>
                <th>ID</th>
                <th>Nội dung Header</th>
                <th>Thao tác</th>
            </tr>
            <?php
                $query = "SELECT * FROM header_texts";  // Lấy dữ liệu từ bảng header_texts
                $result = $link->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr id='header-" . $row['id'] . "'>
                            <td>" . $row['id'] . "</td>
                            <td class='editable' data-id='" . $row['id'] . "'>" . $row['text_content'] . "</td>
                            <td>
                                <button class='btn btn-edit' onclick='editHeader(" . $row['id'] . ")'>Sửa</button>
                                <button class='btn btn-delete' onclick='deleteHeader(" . $row['id'] . ")'>Xóa</button>
                            </td>
                          </tr>";
                }
            ?>
        </table>
    </div>
</div>

<script>
    // Thêm header mới
    function addNewHeader() {
    const headerId = document.getElementById('newHeaderId').value;
    const headerText = document.getElementById('newHeaderText').value;

    if (headerId.trim() === "" || headerText.trim() === "") {
        alert("Vui lòng nhập ID và nội dung header.");
        return;
    }

    // Gửi dữ liệu lên server để thêm vào database
    const formData = new FormData();
    formData.append('action', 'add');
    formData.append('id', headerId);
    formData.append('text_content', headerText);

    fetch('QL-header.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        // Kiểm tra nếu response.ok là true, nghĩa là phản hồi từ server là hợp lệ
        if (!response.ok) {
            throw new Error('Mã phản hồi mạng không hợp lệ.');
        }
        return response.json(); // Phân tích cú pháp JSON của phản hồi
    })
    .then(data => {
        if (data.success) {
            alert("Đã thêm header mới.");
            location.reload();  // Tải lại trang để cập nhật danh sách
        } else {
            alert(data.message || "Có lỗi khi thêm header.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Đã có lỗi xảy ra khi thêm header.");
    });
}


// Xóa header
    function deleteHeader(id) {
        if (confirm("Bạn có chắc chắn muốn xóa header này?")) {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);

            fetch('QL-header.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Xóa header thành công!");
                    document.getElementById('header-' + id).remove();  // Xóa dòng tương ứng trong bảng
                } else {
                    alert(data.message || "Có lỗi khi xóa header.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Đã có lỗi xảy ra khi xóa header.");
            });
        }
    }


    // Chỉnh sửa nội dung header
    function editHeader(id) {
        const cell = document.querySelector(`.editable[data-id="${id}"]`);
        const text = cell.innerText;
        const input = document.createElement('input');
        input.type = 'text';
        input.value = text;
        cell.innerHTML = '';
        cell.appendChild(input);

        // Thêm một nút lưu
        const saveButton = document.createElement('button');
        saveButton.classList.add('btn', 'btn-save');
        saveButton.innerText = 'Lưu';
        saveButton.onclick = () => saveEditedHeader(id, input.value);
        cell.appendChild(saveButton);
    }

    // Lưu chỉnh sửa header
    function saveEditedHeader(id, newText) {
        const formData = new FormData();
        formData.append('action', 'update');
        formData.append('id', id);
        formData.append('new_text', newText);

        fetch('QL-header.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message); // Hiển thị thông báo thành công từ server
                location.reload();  // Tải lại trang để cập nhật danh sách
            } else {
                alert(data.message || "Có lỗi khi lưu thay đổi.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Đã có lỗi xảy ra.");
        });
    }

    // Xóa header
    function deleteHeader(id) {
        if (confirm("Bạn có chắc chắn muốn xóa header này?")) {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);

            fetch('QL-header.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message); // Hiển thị thông báo thành công từ server
                    location.reload();  // Tải lại trang để cập nhật danh sách
                } else {
                    alert(data.message || "Có lỗi khi xóa header.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Đã có lỗi xảy ra.");
            });
        }
    }
</script>

</body>
</html>
