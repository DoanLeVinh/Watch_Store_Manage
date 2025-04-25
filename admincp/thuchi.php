<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="assets/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Be Vietnam Pro', sans-serif;
      margin: 0;
      background-color: #f4f4f4;
    }

    main {
      margin-left: 260px;
      padding: 20px;
      min-height: 100vh;
    }

    .section-header {
      margin-bottom: 20px;
    }

    .filter-bar {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 20px;
    }

    .filter-bar input,
    .filter-bar select,
    .filter-bar button {
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .filter-bar button {
      background-color: #1a1a1a;
      color: white;
      border: none;
      cursor: pointer;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 12px 15px;
      border-bottom: 1px solid #ddd;
      text-align: left;
      font-size: 14px;
    }

    th {
      background-color: #eee;
    }

    .status {
      font-weight: bold;
      padding: 4px 8px;
      border-radius: 5px;
    }

    .status.pending { color: orange; }
    .status.confirmed { color: green; }
    .status.shipping { color: blue; }
    .status.completed { color: gray; }
    .status.canceled { color: red; }

    .action-btn {
      padding: 5px 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      color: white;
    }

    .btn-view { background-color: #007bff; }
    .btn-confirm { background-color: #28a745; }
    .btn-edit { background-color: #ffc107; color: black; }
  </style>
</head>
<body>

  <?php include("oriented/header.php"); ?>
  <div class="container">
    <?php include("oriented/sidebar.php"); ?>

    <main>
      <h2 class="section-header">💰 Quản lý thu chi</h2>

      <div class="filter-bar">
        <input type="text" id="searchFinance" placeholder="🔍 Tìm theo nội dung hoặc ngày...">
        <select id="typeFilter">
          <option value="">Tất cả loại</option>
          <option value="Thu">Thu</option>
          <option value="Chi">Chi</option>
        </select>
        <button onclick="filterFinance()">Lọc</button>
      </div>

      <table id="financeTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Ngày</th>
            <th>Loại</th>
            <th>Nội dung</th>
            <th>Số tiền</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>19/04/2025</td>
            <td>Thu</td>
            <td>Bán hàng</td>
            <td>3.000.000đ</td>
            <td><button class="action-btn btn-edit">Chỉnh sửa</button></td>
          </tr>
          <tr>
            <td>2</td>
            <td>18/04/2025</td>
            <td>Chi</td>
            <td>Nhập hàng</td>
            <td>2.200.000đ</td>
            <td><button class="action-btn btn-edit">Chỉnh sửa</button></td>
          </tr>
        </tbody>
      </table>
    </main>
  </div>

  <script>
    function filterFinance() {
      const input = document.getElementById("searchFinance").value.toLowerCase();
      const type = document.getElementById("typeFilter").value;
      const rows = document.querySelectorAll("#financeTable tbody tr");

      rows.forEach(row => {
        const date = row.cells[1].textContent.toLowerCase();
        const typeVal = row.cells[2].textContent.trim();
        const content = row.cells[3].textContent.toLowerCase();

        const matchSearch = date.includes(input) || content.includes(input);
        const matchType = !type || typeVal === type;

        row.style.display = (matchSearch && matchType) ? "" : "none";
      });
    }
  </script>
</body>
</html>