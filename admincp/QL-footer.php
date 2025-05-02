<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: DN.php");
    exit();
}

include('config.php');
include('oriented/header.php');

// Danh sách các bảng footer
$footerTables = [
    'chinhsach' => 'Chính sách',
    'hethongdaili' => 'Hệ thống đại lý',
    'thongtin' => 'Thông tin',
    'social' => 'Mạng xã hội',
    'thamkhao' => 'Tham khảo',
    'vechungtoi' => 'Về chúng tôi'
];

// Xử lý thêm mới
if (isset($_POST['add_item'])) {
    $table = $_POST['table'];
    $title = $_POST['title'];
    $link_value = $_POST['link']; // Đổi tên biến để tránh trùng với $link kết nối
    
    if (array_key_exists($table, $footerTables)) {
        $stmt = $link->prepare("INSERT INTO `$table` (title, link) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("ss", $title, $link_value);
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
}

// Xử lý cập nhật
if (isset($_POST['update_item'])) {
    $table = $_POST['table'];
    $id = $_POST['id'];
    $title = $_POST['title'];
    $link_value = $_POST['link'];
    
    if (array_key_exists($table, $footerTables)) {
        $stmt = $link->prepare("UPDATE `$table` SET title=?, link=? WHERE id=?");
        if ($stmt) {
            $stmt->bind_param("ssi", $title, $link_value, $id);
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
}

// Xử lý xóa
if (isset($_POST['delete_item'])) {
    $table = $_POST['table'];
    $id = $_POST['id'];
    
    if (array_key_exists($table, $footerTables)) {
        $stmt = $link->prepare("DELETE FROM `$table` WHERE id=?");
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
}

// Xử lý xóa nhiều
if (isset($_POST['delete_selected'])) {
    $table = $_POST['table'];
    $ids = $_POST['ids'] ?? [];
    
    if (!empty($ids) && array_key_exists($table, $footerTables)) {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        $sql = "DELETE FROM `$table` WHERE id IN ($placeholders)";
        
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

// Lấy dữ liệu từ các bảng
$footerData = [];
foreach ($footerTables as $table => $name) {
    $result = $link->query("SELECT * FROM `$table`");
    if ($result) {
        $footerData[$table] = [
            'name' => $name,
            'items' => $result->fetch_all(MYSQLI_ASSOC)
        ];
        $result->free();
    } else {
        $error = "Lỗi truy vấn bảng $table: " . $link->error;
    }
}

// Đóng kết nối (sẽ thực hiện ở cuối file)
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Footer</title>
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
        
        .tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--secondary-color);
        }
        
        .tab {
            padding: 12px 24px;
            cursor: pointer;
            background-color: var(--white-color);
            color: var(--primary-color);
            border: 1px solid var(--secondary-color);
            border-bottom: none;
            margin-right: 5px;
            border-radius: 5px 5px 0 0;
            transition: all 0.3s ease;
        }
        
        .tab:hover {
            background-color: var(--light-color);
        }
        
        .tab.active {
            background-color: var(--primary-color);
            color: var(--white-color);
            border-color: var(--primary-color);
        }
        
        .tab-content {
            display: none;
            padding: 20px 0;
        }
        
        .tab-content.active {
            display: block;
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
        
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        
        .form-group input:focus {
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
            
            .tabs {
                flex-wrap: wrap;
            }
            
            .tab {
                flex: 1;
                min-width: 120px;
                text-align: center;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>QUẢN LÝ FOOTER</h1>
        
        <?php if (isset($message)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <div class="tabs">
            <?php foreach ($footerData as $table => $data): ?>
                <div class="tab <?= $table === 'chinhsach' ? 'active' : '' ?>" onclick="openTab('<?= $table ?>')">
                    <?= htmlspecialchars($data['name']) ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php foreach ($footerData as $table => $data): ?>
            <div id="<?= $table ?>" class="tab-content <?= $table === 'chinhsach' ? 'active' : '' ?>">
                <form method="post" id="form_<?= $table ?>">
                    <input type="hidden" name="table" value="<?= $table ?>">
                    
                    <div class="action-bar">
                        <div class="action-buttons">
                            <button type="button" class="btn btn-success" onclick="openAddModal('<?= $table ?>')">
                                Thêm mới
                            </button>
                            <button type="button" class="btn btn-primary" onclick="editSelected('<?= $table ?>')">
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
                                    <input type="checkbox" id="selectAll_<?= $table ?>" onclick="toggleAllCheckboxes('<?= $table ?>')">
                                </th>
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['items'] as $item): ?>
                                <tr>
                                    <td class="checkbox-cell">
                                        <input type="checkbox" name="ids[]" value="<?= $item['id'] ?>">
                                    </td>
                                    <td><?= htmlspecialchars($item['id']) ?></td>
                                    <td><?= htmlspecialchars($item['title']) ?></td>
                                    <td><?= htmlspecialchars($item['link']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Modal Thêm mới -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addModal')">&times;</span>
            <h2>Thêm mới</h2>
            <form method="post">
                <input type="hidden" name="table" id="addTable">
                <div class="form-group">
                    <label for="addTitle">Tiêu đề</label>
                    <input type="text" id="addTitle" name="title" required>
                </div>
                <div class="form-group">
                    <label for="addLink">Link</label>
                    <input type="text" id="addLink" name="link" required>
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
            <h2>Chỉnh sửa</h2>
            <form method="post">
                <input type="hidden" name="table" id="editTable">
                <input type="hidden" name="id" id="editId">
                <div class="form-group">
                    <label for="editTitle">Tiêu đề</label>
                    <input type="text" id="editTitle" name="title" required>
                </div>
                <div class="form-group">
                    <label for="editLink">Link</label>
                    <input type="text" id="editLink" name="link" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">Đóng</button>
                    <button type="submit" name="update_item" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Mở tab
        function openTab(tabName) {
            // Ẩn tất cả các tab content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Hiển thị tab content được chọn
            document.getElementById(tabName).classList.add('active');
            
            // Cập nhật tab active
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
        }
        
        // Mở modal thêm mới
        function openAddModal(table) {
            document.getElementById('addTable').value = table;
            document.getElementById('addModal').style.display = 'block';
            document.getElementById('addTitle').value = '';
            document.getElementById('addLink').value = '';
            document.getElementById('addTitle').focus();
        }
        
        // Chỉnh sửa mục đã chọn
        function editSelected(table) {
            const form = document.getElementById(`form_${table}`);
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
            const title = row.cells[2].textContent;
            const link = row.cells[3].textContent;
            
            document.getElementById('editTable').value = table;
            document.getElementById('editId').value = id;
            document.getElementById('editTitle').value = title.trim();
            document.getElementById('editLink').value = link.trim();
            document.getElementById('editModal').style.display = 'block';
        }
        
        // Đóng modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        
        // Chọn/bỏ chọn tất cả
        function toggleAllCheckboxes(table) {
            const form = document.getElementById(`form_${table}`);
            const selectAll = form.querySelector('#selectAll_' + table);
            const checkboxes = form.querySelectorAll('input[name="ids[]"]');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
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