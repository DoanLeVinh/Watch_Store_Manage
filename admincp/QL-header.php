<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: DN.php");
    exit();
}

include('config.php');
include('oriented/header.php');

// Xử lý thêm mới
if (isset($_POST['add_item'])) {
    $text_content = $_POST['text_content'];
    
    $stmt = $link->prepare("INSERT INTO header_texts (text_content) VALUES (?)");
    if ($stmt) {
        $stmt->bind_param("s", $text_content);
        if ($stmt->execute()) {
            $message = "Thêm mới thành công!";
        } else {
            $error = "Lỗi: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Lỗi prepare: " . $link->error;
    }
}

// Xử lý cập nhật
if (isset($_POST['update_item'])) {
    $id = $_POST['id'];
    $text_content = $_POST['text_content'];
    
    $stmt = $link->prepare("UPDATE header_texts SET text_content=? WHERE id=?");
    if ($stmt) {
        $stmt->bind_param("si", $text_content, $id);
        if ($stmt->execute()) {
            $message = "Cập nhật thành công!";
        } else {
            $error = "Lỗi: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Lỗi prepare: " . $link->error;
    }
}

// Xử lý xóa
if (isset($_POST['delete_item'])) {
    $id = $_POST['id'];
    
    $stmt = $link->prepare("DELETE FROM header_texts WHERE id=?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $message = "Xóa thành công!";
        } else {
            $error = "Lỗi: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Lỗi prepare: " . $link->error;
    }
}

// Xử lý xóa nhiều
if (isset($_POST['delete_selected'])) {
    $ids = $_POST['ids'] ?? [];
    
    if (!empty($ids)) {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        $sql = "DELETE FROM header_texts WHERE id IN ($placeholders)";
        
        $stmt = $link->prepare($sql);
        if ($stmt) {
            $stmt->bind_param($types, ...$ids);
            if ($stmt->execute()) {
                $message = "Đã xóa " . count($ids) . " mục thành công!";
            } else {
                $error = "Lỗi: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Lỗi prepare: " . $link->error;
        }
    }
}

// Lấy dữ liệu từ bảng
$headerItems = [];
$result = $link->query("SELECT * FROM header_texts");
if ($result) {
    $headerItems = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
} else {
    $error = "Lỗi truy vấn: " . $link->error;
}

// Đóng kết nối (sẽ thực hiện ở cuối file)
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Header</title>
    <style>
        :root {
            --primary-color: #000000;
            --secondary-color: #333333;
            --light-color: #f5f5f5;
            --white-color: #ffffff;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--white-color);
            color: var(--primary-color);
        }
        
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: var(--white-color);
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-weight: 600;
        }
        
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            background-color: var(--light-color);
            border-radius: 4px;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: var(--primary-color);
            color: var(--white-color);
            font-weight: 500;
        }
        
        tr:hover {
            background-color: var(--light-color);
        }
        
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
        }
        
        .btn-danger {
            background-color: #d32f2f;
            color: var(--white-color);
        }
        
        .btn-danger:hover {
            background-color: #b71c1c;
        }
        
        .btn-success {
            background-color: #388e3c;
            color: var(--white-color);
        }
        
        .btn-success:hover {
            background-color: #2e7d32;
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            color: var(--white-color);
        }
        
        .btn-secondary:hover {
            background-color: #555;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: var(--white-color);
            margin: 5% auto;
            padding: 25px;
            width: 50%;
            max-width: 600px;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        
        .close {
            color: var(--secondary-color);
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover {
            color: var(--primary-color);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--primary-color);
        }
        
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        
        .form-group input:focus, .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
        }
        
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }
        
        .alert-danger {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }
        
        .checkbox-cell {
            width: 40px;
            text-align: center;
        }
        
        .checkbox-cell input {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            
            .modal-content {
                width: 90%;
                margin: 10% auto;
            }
            
            .action-buttons {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>QUẢN LÝ HEADER</h1>
        
        <?php if (isset($message)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="post" id="headerForm">
            <input type="hidden" name="table" value="header_texts">
            
            <div class="action-bar">
                <div class="action-buttons">
                    <button type="button" class="btn btn-success" onclick="openAddModal()">
                        Thêm mới
                    </button>
                    <button type="button" class="btn btn-primary" onclick="editSelected()">
                        Sửa
                    </button>
                    <button type="submit" name="delete_selected" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa các mục đã chọn?')">
                        Xóa
                    </button>
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th class="checkbox-cell">
                            <input type="checkbox" id="selectAll" onclick="toggleAllCheckboxes()">
                        </th>
                        <th>ID</th>
                        <th>Nội dung Header</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($headerItems as $item): ?>
                        <tr data-id="<?= htmlspecialchars($item['id']) ?>">
                            <td class="checkbox-cell">
                                <input type="checkbox" name="ids[]" value="<?= $item['id'] ?>">
                            </td>
                            <td><?= htmlspecialchars($item['id']) ?></td>
                            <td><?= htmlspecialchars($item['text_content']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    </div>
    
    <!-- Modal Thêm mới -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addModal')">&times;</span>
            <h2>Thêm mới Header</h2>
            <form method="post">
                <div class="form-group">
                    <label for="addContent">Nội dung Header</label>
                    <textarea id="addContent" name="text_content" rows="4" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addModal')">Đóng</button>
                    <button type="submit" name="add_item" class="btn btn-success">Lưu</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Modal Chỉnh sửa -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <h2>Chỉnh sửa Header</h2>
            <form method="post">
                <input type="hidden" name="id" id="editId">
                <div class="form-group">
                    <label for="editContent">Nội dung Header</label>
                    <textarea id="editContent" name="text_content" rows="4" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">Đóng</button>
                    <button type="submit" name="update_item" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Chọn/bỏ chọn tất cả
        function toggleAllCheckboxes() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('input[name="ids[]"]');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        }
        
        // Mở modal thêm mới
        function openAddModal() {
            document.getElementById('addModal').style.display = 'block';
            document.getElementById('addContent').value = '';
            document.getElementById('addContent').focus();
        }
        
        // Chỉnh sửa mục đã chọn
        function editSelected() {
            const form = document.getElementById('headerForm');
            const checkboxes = form.querySelectorAll('input[name="ids[]"]:checked');
            
            if (checkboxes.length === 0) {
                alert('Vui lòng chọn ít nhất 1 mục để sửa');
                return;
            }
            
            if (checkboxes.length > 1) {
                alert('Vui lòng chỉ chọn 1 mục để sửa');
                return;
            }
            
            const row = checkboxes[0].closest('tr');
            const id = checkboxes[0].value;
            const content = row.cells[2].textContent;
            
            document.getElementById('editId').value = id;
            document.getElementById('editContent').value = content.trim();
            document.getElementById('editModal').style.display = 'block';
        }
        
        // Đóng modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        
        // Đóng modal khi click bên ngoài
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                document.querySelectorAll('.modal').forEach(modal => {
                    modal.style.display = 'none';
                });
            }
        }
    </script>
</body>
</html>
<?php
// Đóng kết nối database
$link->close();
?>