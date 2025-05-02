<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: DN.php");
    exit();
}

include('config.php');
include('oriented/header.php');

// Xử lý thêm sản phẩm
if (isset($_POST['addProduct'])) {
    $table = $_POST['target_table'];
    $fields = ['TenSP', 'Ma', 'Kichthuoc', 'May', 'Xuatxu', 'Content', 'Gia', 'Hinhanh', 'Kinh'];
    $data = [];
    foreach ($fields as $field) {
        $data[$field] = $_POST[$field] ?? '';
    }

    if (in_array($table, ['dongho_nam', 'dongho_nu', 'trangsuc'])) {
        $stmt = $link->prepare("INSERT INTO `$table` (TenSP, Ma, Kichthuoc, May, Xuatxu, Content, Gia, Hinhanh, Kinh) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssiss", $data['TenSP'], $data['Ma'], $data['Kichthuoc'], $data['May'], $data['Xuatxu'], $data['Content'], $data['Gia'], $data['Hinhanh'], $data['Kinh']);
        if ($stmt->execute()) {
            $message = "Thêm sản phẩm thành công!";
        } else {
            $error = "Lỗi thêm sản phẩm: " . $stmt->error;
        }
    } else {
        $error = "Bảng không hợp lệ!";
    }
}

// Xử lý cập nhật sản phẩm
if (isset($_POST['updateProduct'])) {
    $id = $_POST['id'];
    $table = $_POST['table'];
    $fields = ['TenSP', 'Ma', 'Kichthuoc', 'May', 'Xuatxu', 'Content', 'Gia', 'Hinhanh', 'Kinh'];
    $data = [];
    foreach ($fields as $field) {
        $data[$field] = $_POST[$field] ?? '';
    }

    if (in_array($table, ['dongho_nam', 'dongho_nu', 'trangsuc'])) {
        $stmt = $link->prepare("UPDATE `$table` SET TenSP=?, Ma=?, Kichthuoc=?, May=?, Xuatxu=?, Content=?, Gia=?, Hinhanh=?, Kinh=? WHERE Ma=?");
        $stmt->bind_param("ssssssissi", $data['TenSP'], $data['Ma'], $data['Kichthuoc'], $data['May'], $data['Xuatxu'], $data['Content'], $data['Gia'], $data['Hinhanh'], $data['Kinh'], $id);
        
        if ($stmt->execute()) {
            $message = "Cập nhật sản phẩm thành công!";
        } else {
            $error = "Lỗi cập nhật sản phẩm: " . $stmt->error;
        }
    } else {
        $error = "Bảng không hợp lệ!";
    }
}

// Xử lý xóa sản phẩm
if (isset($_POST['deleteProducts'])) {
    $ids = explode(',', $_POST['ids']);
    $table = $_POST['table'];
    
    if (!empty($ids) && in_array($table, ['dongho_nam', 'dongho_nu', 'trangsuc'])) {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $link->prepare("DELETE FROM `$table` WHERE Ma IN ($placeholders)");
        $stmt->bind_param(str_repeat('s', count($ids)), ...$ids);
        
        if ($stmt->execute()) {
            $message = "Đã xóa " . count($ids) . " sản phẩm thành công!";
        } else {
            $error = "Lỗi xóa sản phẩm: " . $stmt->error;
        }
    } else {
        $error = "Dữ liệu không hợp lệ!";
    }
}

// Lấy danh sách sản phẩm
$category = $_GET['category'] ?? '';
$keyword = $_GET['keyword'] ?? '';
$products = [];
$link->set_charset("utf8");

$searchTerm = "%$keyword%";
$tables = $category ? [$category] : ['dongho_nam', 'dongho_nu', 'trangsuc'];

foreach ($tables as $table) {
    $stmt = $link->prepare("SELECT *, '$table' AS table_name FROM `$table` WHERE TenSP LIKE ? OR Ma LIKE ?");
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý sản phẩm</title>
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Be Vietnam Pro', sans-serif; margin: 0; background-color: #f4f4f4; }
    main { padding: 20px; max-width: 1600px; margin: 0 auto; }
    .order-header { margin-bottom: 20px; font-size: 24px; display: flex; align-items: center; gap: 10px; }
    .filter-bar {
      display: flex; flex-wrap: wrap; gap: 10px;
      margin-bottom: 20px; align-items: center;
      background: white; padding: 15px; border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .filter-bar input, .filter-bar select {
      padding: 10px; border-radius: 5px;
      border: 1px solid #ddd; font-family: inherit;
      min-width: 200px;
    }
    .filter-bar button {
      padding: 10px 15px; border-radius: 5px;
      border: none; cursor: pointer; font-family: inherit;
      transition: all 0.3s ease;
    }
    .filter-bar button[type="submit"] {
      background-color: #1a1a1a; color: white;
    }
    .filter-bar button[type="submit"]:hover {
      background-color: #333;
    }
    .order-table-container {
      background: white; border-radius: 10px;
      padding: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      overflow-x: auto;
    }
    .order-table {
      width: 100%; border-collapse: collapse;
      min-width: 1200px;
    }
    .order-table th {
      background-color: #f8f9fa; position: sticky; top: 0;
    }
    .order-table th, .order-table td {
      padding: 12px 15px; border-bottom: 1px solid #eee;
      font-size: 14px; text-align: left;
      vertical-align: middle;
    }
    .order-table tr:hover {
      background-color: #f9f9f9;
    }
    .order-table img { 
      width: 60px; height: 60px; object-fit: cover;
      border-radius: 5px; border: 1px solid #eee;
    }
    .modal {
      display: none; position: fixed; z-index: 100;
      left: 0; top: 0; width: 100%; height: 100%;
      overflow: auto; background-color: rgba(0,0,0,0.4);
    }
    .modal-content {
      background-color: #fefefe; margin: 5% auto;
      padding: 25px; border-radius: 8px;
      width: 80%; max-width: 700px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }
    .form-group {
      margin-bottom: 15px;
    }
    .form-group label {
      display: block; margin-bottom: 5px;
      font-weight: 500;
    }
    .form-control {
      width: 100%; padding: 10px;
      border: 1px solid #ddd; border-radius: 4px;
      font-family: inherit;
    }
    textarea.form-control {
      min-height: 100px; resize: vertical;
    }
    .btn {
      padding: 10px 20px; border-radius: 5px;
      border: none; cursor: pointer;
      font-family: inherit; font-weight: 500;
      transition: all 0.3s ease;
    }
    .btn-primary {
      background-color: #007bff; color: white;
    }
    .btn-primary:hover {
      background-color: #0069d9;
    }
    .btn-success {
      background-color: #28a745; color: white;
    }
    .btn-success:hover {
      background-color: #218838;
    }
    .btn-danger {
      background-color: #dc3545; color: white;
    }
    .btn-danger:hover {
      background-color: #c82333;
    }
    .btn-secondary {
      background-color: #6c757d; color: white;
    }
    .btn-secondary:hover {
      background-color: #5a6268;
    }
    .btn-sm {
      padding: 5px 10px; font-size: 13px;
    }
    .action-buttons {
      display: flex; gap: 5px;
    }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .sticky-actions {
      position: sticky; right: 0; background: white;
      box-shadow: -2px 0 5px rgba(0,0,0,0.05);
    }
    .content-preview {
      max-width: 300px; white-space: nowrap;
      overflow: hidden; text-overflow: ellipsis;
    }
    .close {
      float: right; font-size: 24px;
      font-weight: bold; cursor: pointer;
      color: #aaa;
    }
    .close:hover {
      color: #333;
    }
    #deleteBtn {
      margin-bottom: 15px;
    }
    .alert {
      padding: 15px; margin-bottom: 20px;
      border: 1px solid transparent; border-radius: 4px;
    }
    .alert-success {
      color: #155724; background-color: #d4edda;
      border-color: #c3e6cb;
    }
    .alert-danger {
      color: #721c24; background-color: #f8d7da;
      border-color: #f5c6cb;
    }
    @media (max-width: 768px) {
      .filter-bar {
        flex-direction: column; align-items: stretch;
      }
      .filter-bar input, .filter-bar select {
        width: 100%; min-width: auto;
      }
      .modal-content {
        width: 95%; margin: 10% auto;
      }
    }
  </style>
</head>
<body>
<div class="container">
  <main>
    <h2 class="order-header">📦 Quản lý sản phẩm</h2>

    <?php if (isset($message)): ?>
      <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="filter-bar">
      <form method="GET" class="search-form">
        <input type="text" name="keyword" placeholder="Tìm theo tên hoặc mã sản phẩm..." value="<?= htmlspecialchars($keyword) ?>">
        <select name="category">
          <option value="">Tất cả loại sản phẩm</option>
          <option value="dongho_nam" <?= $category === 'dongho_nam' ? 'selected' : '' ?>>Đồng hồ nam</option>
          <option value="dongho_nu" <?= $category === 'dongho_nu' ? 'selected' : '' ?>>Đồng hồ nữ</option>
          <option value="trangsuc" <?= $category === 'trangsuc' ? 'selected' : '' ?>>Trang sức</option>
        </select>
        <button type="submit">Lọc</button>
      </form>
      <button class="btn btn-success" onclick="document.getElementById('addProductModal').style.display='block'">➕ Thêm sản phẩm</button>
    </div>
    
    <form method="post" id="deleteForm">
      <input type="hidden" name="ids" id="deleteIds">
      <input type="hidden" name="table" id="deleteTable">
      <input type="hidden" name="deleteProducts" value="1">
      <button type="button" class="btn btn-danger" id="deleteBtn" style="display:none;" onclick="confirmDelete()">🗑️ Xóa sản phẩm đã chọn</button>
    </form>

    <div class="order-table-container">
      <table class="order-table">
        <thead>
          <tr>
            <th width="40"><input type="checkbox" id="selectAll" onclick="toggleAll(this)"></th>
            <th width="50">STT</th>
            <th>Tên SP</th>
            <th>Mã</th>
            <th>Kích thước</th>
            <th>Máy</th>
            <th>Xuất xứ</th>
            <th>Mô tả</th>
            <th>Giá</th>
            <th>Hình ảnh</th>
            <th>Kính</th>
            <th class="sticky-actions">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($products)): ?>
            <tr><td colspan="12" class="text-center">Không tìm thấy sản phẩm nào</td></tr>
          <?php else: ?>
            <?php foreach ($products as $i => $p): ?>
              <tr data-id="<?= htmlspecialchars($p['Ma']) ?>" data-table="<?= htmlspecialchars($p['table_name']) ?>">
                <td><input type="checkbox" class="product-checkbox" value="<?= htmlspecialchars($p['Ma']) ?>"></td>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($p['TenSP']) ?></td>
                <td><?= htmlspecialchars($p['Ma']) ?></td>
                <td><?= htmlspecialchars($p['Kichthuoc']) ?></td>
                <td><?= htmlspecialchars($p['May']) ?></td>
                <td><?= htmlspecialchars($p['Xuatxu']) ?></td>
                <td class="content-preview" title="<?= htmlspecialchars($p['Content']) ?>"><?= htmlspecialchars($p['Content']) ?></td>
                <td><?= number_format($p['Gia']) ?></td>
                <td><img src="<?= htmlspecialchars($p['Hinhanh']) ?>" alt="Ảnh sản phẩm"></td>
                <td><?= htmlspecialchars($p['Kinh']) ?></td>
                <td class="sticky-actions">
                  <div class="action-buttons">
                    <button class="btn btn-primary btn-sm" onclick="editProduct('<?= $i ?>')">✏️</button>
                    <button class="btn btn-danger btn-sm" onclick="confirmDeleteSingle('<?= htmlspecialchars($p['Ma']) ?>', '<?= htmlspecialchars($p['table_name']) ?>')">🗑️</button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<!-- Modal Thêm sản phẩm -->
<div id="addProductModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="document.getElementById('addProductModal').style.display='none'">&times;</span>
    <h3>Thêm sản phẩm mới</h3>
    <form method="post">
      <div class="form-group">
        <label for="target_table">Loại sản phẩm</label>
        <select class="form-control" name="target_table" required>
          <option value="">-- Chọn loại --</option>
          <option value="dongho_nam">Đồng hồ nam</option>
          <option value="dongho_nu">Đồng hồ nữ</option>
          <option value="trangsuc">Trang sức</option>
        </select>
      </div>
      
      <div class="form-group">
        <label for="TenSP">Tên sản phẩm</label>
        <input type="text" class="form-control" name="TenSP" required>
      </div>
      
      <div class="form-group">
        <label for="Ma">Mã sản phẩm</label>
        <input type="text" class="form-control" name="Ma" required>
      </div>
      
      <div style="display: flex; gap: 10px;">
        <div class="form-group" style="flex: 1;">
          <label for="Kichthuoc">Kích thước</label>
          <input type="text" class="form-control" name="Kichthuoc">
        </div>
        <div class="form-group" style="flex: 1;">
          <label for="May">Loại máy</label>
          <input type="text" class="form-control" name="May">
        </div>
      </div>
      
      <div style="display: flex; gap: 10px;">
        <div class="form-group" style="flex: 1;">
          <label for="Xuatxu">Xuất xứ</label>
          <input type="text" class="form-control" name="Xuatxu">
        </div>
        <div class="form-group" style="flex: 1;">
          <label for="Gia">Giá (VNĐ)</label>
          <input type="number" class="form-control" name="Gia" required>
        </div>
      </div>
      
      <div class="form-group">
        <label for="Hinhanh">URL hình ảnh</label>
        <input type="text" class="form-control" name="Hinhanh">
      </div>
      
      <div class="form-group">
        <label for="Kinh">Loại kính</label>
        <input type="text" class="form-control" name="Kinh">
      </div>
      
      <div class="form-group">
        <label for="Content">Mô tả sản phẩm</label>
        <textarea class="form-control" name="Content" rows="3"></textarea>
      </div>
      
      <div class="text-right">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('addProductModal').style.display='none'">Đóng</button>
        <button type="submit" class="btn btn-primary" name="addProduct">Lưu sản phẩm</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Chỉnh sửa sản phẩm -->
<div id="editProductModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="document.getElementById('editProductModal').style.display='none'">&times;</span>
    <h3>Chỉnh sửa sản phẩm</h3>
    <form method="post" id="editForm">
      <input type="hidden" name="updateProduct" value="1">
      <input type="hidden" name="id" id="editId">
      <input type="hidden" name="table" id="editTable">
      
      <div class="form-group">
        <label for="editTenSP">Tên sản phẩm</label>
        <input type="text" class="form-control" name="TenSP" id="editTenSP" required>
      </div>
      
      <div class="form-group">
        <label for="editMa">Mã sản phẩm</label>
        <input type="text" class="form-control" name="Ma" id="editMa" required>
      </div>
      
      <div style="display: flex; gap: 10px;">
        <div class="form-group" style="flex: 1;">
          <label for="editKichthuoc">Kích thước</label>
          <input type="text" class="form-control" name="Kichthuoc" id="editKichthuoc">
        </div>
        <div class="form-group" style="flex: 1;">
          <label for="editMay">Loại máy</label>
          <input type="text" class="form-control" name="May" id="editMay">
        </div>
      </div>
      
      <div style="display: flex; gap: 10px;">
        <div class="form-group" style="flex: 1;">
          <label for="editXuatxu">Xuất xứ</label>
          <input type="text" class="form-control" name="Xuatxu" id="editXuatxu">
        </div>
        <div class="form-group" style="flex: 1;">
          <label for="editGia">Giá (VNĐ)</label>
          <input type="number" class="form-control" name="Gia" id="editGia" required>
        </div>
      </div>
      
      <div class="form-group">
        <label for="editHinhanh">URL hình ảnh</label>
        <input type="text" class="form-control" name="Hinhanh" id="editHinhanh">
      </div>
      
      <div class="form-group">
        <label for="editKinh">Loại kính</label>
        <input type="text" class="form-control" name="Kinh" id="editKinh">
      </div>
      
      <div class="form-group">
        <label for="editContent">Mô tả sản phẩm</label>
        <textarea class="form-control" name="Content" id="editContent" rows="3"></textarea>
      </div>
      
      <div class="text-right">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('editProductModal').style.display='none'">Đóng</button>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Xác nhận xóa -->
<div id="confirmDeleteModal" class="modal">
  <div class="modal-content" style="max-width: 500px;">
    <h3>Xác nhận xóa</h3>
    <p id="deleteMessage">Bạn có chắc chắn muốn xóa sản phẩm đã chọn?</p>
    <div class="text-right" style="margin-top: 20px;">
      <button type="button" class="btn btn-secondary" onclick="document.getElementById('confirmDeleteModal').style.display='none'">Hủy</button>
      <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Xóa</button>
    </div>
  </div>
</div>

<script>
// Chọn tất cả/bỏ chọn tất cả
function toggleAll(source) {
  const checkboxes = document.querySelectorAll('.product-checkbox');
  checkboxes.forEach(checkbox => checkbox.checked = source.checked);
  document.getElementById('deleteBtn').style.display = source.checked ? 'block' : 'none';
}

// Hiển thị nút xóa khi có sản phẩm được chọn
document.querySelectorAll('.product-checkbox').forEach(checkbox => {
  checkbox.addEventListener('change', function() {
    const checkedCount = document.querySelectorAll('.product-checkbox:checked').length;
    document.getElementById('deleteBtn').style.display = checkedCount > 0 ? 'block' : 'none';
  });
});

// Xác nhận xóa nhiều sản phẩm
function confirmDelete() {
  const checkboxes = document.querySelectorAll('.product-checkbox:checked');
  if (checkboxes.length === 0) return;
  
  const ids = Array.from(checkboxes).map(cb => cb.value);
  const table = checkboxes[0].closest('tr').dataset.table;
  
  document.getElementById('deleteIds').value = ids.join(',');
  document.getElementById('deleteTable').value = table;
  document.getElementById('deleteMessage').textContent = `Bạn có chắc chắn muốn xóa ${ids.length} sản phẩm đã chọn?`;
  
  document.getElementById('confirmDeleteModal').style.display = 'block';
  document.getElementById('confirmDeleteBtn').onclick = function() {
    document.getElementById('deleteForm').submit();
  };
}

// Xác nhận xóa 1 sản phẩm
function confirmDeleteSingle(id, table) {
  document.getElementById('deleteIds').value = id;
  document.getElementById('deleteTable').value = table;
  document.getElementById('deleteMessage').textContent = 'Bạn có chắc chắn muốn xóa sản phẩm này?';
  
  document.getElementById('confirmDeleteModal').style.display = 'block';
  document.getElementById('confirmDeleteBtn').onclick = function() {
    document.getElementById('deleteForm').submit();
  };
}

// Mở modal chỉnh sửa sản phẩm
function editProduct(index) {
  const row = document.querySelectorAll('tbody tr')[index];
  if (!row) return;
  
  document.getElementById('editId').value = row.dataset.id;
  document.getElementById('editTable').value = row.dataset.table;
  
  const cells = row.querySelectorAll('td');
  document.getElementById('editTenSP').value = cells[2].textContent.trim();
  document.getElementById('editMa').value = cells[3].textContent.trim();
  document.getElementById('editKichthuoc').value = cells[4].textContent.trim();
  document.getElementById('editMay').value = cells[5].textContent.trim();
  document.getElementById('editXuatxu').value = cells[6].textContent.trim();
  document.getElementById('editContent').value = cells[7].textContent.trim();
  document.getElementById('editGia').value = cells[8].textContent.replace(/[^\d]/g, '');
  document.getElementById('editHinhanh').value = cells[9].querySelector('img').src;
  document.getElementById('editKinh').value = cells[10].textContent.trim();
  
  document.getElementById('editProductModal').style.display = 'block';
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