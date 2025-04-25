<?php
include('config.php');  // Kết nối với database

// Kiểm tra yêu cầu POST (Cập nhật Header)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    // Thêm Header
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $id = $_POST['id'];
        $text_content = $_POST['text_content'];

        if (empty($id) || empty($text_content)) {
            echo json_encode(['success' => false, 'message' => 'ID và nội dung không được để trống.']);
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

    // Xóa Header
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = $_POST['id'];

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

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý sản phẩm - Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Be Vietnam Pro', sans-serif; margin: 0; background-color: #f4f4f4; }
    main { padding: 20px; }
    .order-header { margin-bottom: 20px; font-size: 24px; }
    .filter-bar {
      display: flex; flex-wrap: wrap; gap: 10px;
      margin-bottom: 20px; align-items: center;
    }
    .filter-bar input, .filter-bar select, .filter-bar button {
      padding: 10px; border-radius: 5px;
      border: 1px solid #ccc; font-family: inherit;
    }
    .filter-bar button {
      background-color: #1a1a1a; color: white; border: none; cursor: pointer;
    }
    .order-table {
      width: 100%; border-collapse: collapse; background: white;
      border-radius: 10px; overflow: hidden;
    }
    .order-table th, .order-table td {
      padding: 12px 15px; border-bottom: 1px solid #ddd;
      font-size: 14px; text-align: left;
    }
    .order-table img { width: 50px; border-radius: 5px; }
    #addProductForm {
      display: none; background: #fff; padding: 20px;
      border-radius: 10px; margin-top: 20px;
    }
    #addProductForm input, #addProductForm select, #addProductForm textarea {
      width: 100%; padding: 10px; margin: 8px 0;
      border-radius: 5px; border: 1px solid #ccc;
      font-family: inherit;
    }
    #addProductForm button {
      padding: 10px 20px; background-color: #007bff;
      color: white; border: none; border-radius: 5px;
      cursor: pointer;
    }
    .btn-add {
      background-color: #28a745; color: white;
      border: none; border-radius: 5px;
      padding: 10px 15px; cursor: pointer;
      margin-left: auto;
    }
    .btn-delete {
  padding: 10px 15px;
  border-radius: 5px;
  border: none;
  color: white;
  background-color: red;
  cursor: pointer;
}

  </style>
</head>
<body>
<?php include("config.php");?>
<?php include("oriented/header.php"); ?>
<div class="container">
  <main>
    <h2 class="order-header">📦 Quản lý sản phẩm</h2>

    <div class="filter-bar">
      <form method="GET" style="display: flex; gap: 10px;">
        <input type="text" name="keyword" placeholder="🔍 Tìm theo sản phẩm..." value="<?= $_GET['keyword'] ?? '' ?>">
        <select name="category">
          <option value="">Chọn loại sản phẩm:</option>
          <option value="dongho_nam" <?= ($_GET['category'] ?? '') === 'dongho_nam' ? 'selected' : '' ?>>Đồng hồ nam</option>
          <option value="dongho_nu" <?= ($_GET['category'] ?? '') === 'dongho_nu' ? 'selected' : '' ?>>Đồng hồ nữ</option>
          <option value="trangsuc" <?= ($_GET['category'] ?? '') === 'trangsuc' ? 'selected' : '' ?>>Trang sức</option>
        </select>
        <button type="submit">Lọc</button>
      </form>
      <button class="btn-add" onclick="document.getElementById('addProductForm').style.display='block'">➕ Thêm sản phẩm</button>
    </div>
    <button class="btn-delete" id="deleteBtn" style="display:none; background-color: red;">🗑️ Xóa sản phẩm đã chọn</button>


    <div id="addProductForm">
      <h3>📝 Thêm sản phẩm mới</h3>
      <form method="POST">
        <select name="target_table" required>
          <option value="">--Chọn bảng--</option>
          <option value="dongho_nam">Đồng hồ nam</option>
          <option value="dongho_nu">Đồng hồ nữ</option>
          <option value="trangsuc">Trang sức</option>
        </select>
        <input type="text" name="TenSP" placeholder="Tên sản phẩm" required>
        <input type="text" name="Ma" placeholder="Mã sản phẩm" required>
        <input type="text" name="Kichthuoc" placeholder="Kích thước">
        <input type="text" name="May" placeholder="Loại máy">
        <input type="text" name="Xuatxu" placeholder="Xuất xứ">
        <textarea name="Content" placeholder="Mô tả sản phẩm"></textarea>
        <input type="number" name="Gia" placeholder="Giá" required>
        <input type="text" name="Hinhanh" placeholder="URL hình ảnh">
        <input type="text" name="Kinh" placeholder="Loại kính">
        <button type="submit" name="addProduct">💾 Lưu</button>
      </form>
    </div>

    <?php
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
          echo "<script>alert('Thêm sản phẩm thành công'); location.href=location.href;</script>";
        } else {
          echo "<p style='color:red;'>Lỗi thêm sản phẩm: " . $stmt->error . "</p>";
        }
      } else {
        echo "<p style='color:red;'>Bảng không hợp lệ.</p>";
      }
    }
    ?>

    <table class="order-table">
      <thead>
        <tr>
          <th><input type="checkbox" onclick="toggleAll(this)"></th>
          <th>STT</th>
          <th>Tên SP</th>
          <th>Mã</th>
          <th>Kích thước</th>
          <th>Máy</th>
          <th>Xuất xứ</th>
          <th>Mô tả</th>
          <th>Giá</th>
          <th>Hình ảnh</th>
          <th>Kính</th>
          <th>Thao tác</th>
        </tr>
      </thead>
      <tbody>
        <?php
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

          foreach ($products as $i => $p) {
            $rowId = "row_$i";
            echo "<tr id='$rowId'>
                <td><input type='checkbox' class='product-checkbox' data-id='{$p['Ma']}' data-table='{$p['table_name']}'></td>
                <td>" . ($i + 1) . "</td>
                <td data-field='TenSP'>{$p['TenSP']}</td>
                <td data-field='Ma'>{$p['Ma']}</td>
                <td data-field='Kichthuoc'>{$p['Kichthuoc']}</td>
                <td data-field='May'>{$p['May']}</td>
                <td data-field='Xuatxu'>{$p['Xuatxu']}</td>
                <td data-field='Content'>{$p['Content']}</td>
                <td data-field='Gia'>" . number_format($p['Gia']) . "</td>
                <td data-field='Hinhanh'><img src='{$p['Hinhanh']}' alt='Ảnh'></td>
                <td data-field='Kinh'>{$p['Kinh']}</td>
                <td>
                    <button class='btn-edit' onclick=\"enableEdit('$rowId')\">✏️</button>
                    <button class='btn-save' onclick=\"saveEdit('$rowId', '{$p['Ma']}', '{$p['table_name']}')\" style='display:none;'>💾</button>
                </td>
            </tr>";
        }
        

          if (empty($products)) {
            echo "<tr><td colspan='11'>Không có sản phẩm phù hợp.</td></tr>";
          }
        ?>
      </tbody>
    </table>
  </main>
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
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Đã thêm header mới.");
                location.reload();  // Tải lại trang để cập nhật danh sách
            } else {
                alert("Có lỗi khi thêm header.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Đã có lỗi xảy ra.");
        });
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
                alert("Đã lưu thay đổi.");
                location.reload();  // Tải lại trang để cập nhật danh sách
            } else {
                alert("Có lỗi khi lưu thay đổi.");
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
                    alert("Đã xóa header.");
                    location.reload();  // Tải lại trang để cập nhật danh sách
                } else {
                    alert("Có lỗi khi xóa header.");
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
