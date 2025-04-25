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
      margin-left: 10px; /* 250px sidebar + 10px khoảng cách */
      padding: 20px;
      min-height: 100vh;
    }

    .order-header {
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

    .order-table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
      overflow: hidden;
    }

    .order-table th,
    .order-table td {
      padding: 12px 15px;
      border-bottom: 1px solid #ddd;
      text-align: left;
      font-size: 14px;
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
  </style>
</head>
<body>

  <?php include("oriented/header.php"); ?>
  <div class="container">
    <?php include("oriented/sidebar.php"); ?>

    <main>
      <h2 class="order-header">📦 Quản lý đơn hàng</h2>

      <div class="filter-bar">
        <input type="text" id="searchInput" placeholder="🔍 Tìm theo mã đơn hoặc tên khách hàng...">
        <select id="statusFilter">
          <option value="">Tất cả trạng thái</option>
          <option value="Chờ xác nhận">Chờ xác nhận</option>
          <option value="Đã xác nhận">Đã xác nhận</option>
          <option value="Đang giao">Đang giao</option>
          <option value="Hoàn thành">Hoàn thành</option>
          <option value="Đã huỷ">Đã huỷ</option>
        </select>
        <button onclick="filterOrders()">Lọc</button>
      </div>

      <table class="order-table" id="orderTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Mã đơn</th>
            <th>Khách hàng</th>
            <th>Ngày đặt</th>
            <th>Tổng tiền</th>
            <th>Thanh toán</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>DH001</td>
            <td>Nguyễn Văn A</td>
            <td>19/04/2025</td>
            <td>1.500.000đ</td>
            <td>MoMo</td>
            <td><span class="status pending">Chờ xác nhận</span></td>
            <td>
              <button class="action-btn btn-view">Xem</button>
              <button class="action-btn btn-confirm">Xác nhận</button>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>DH002</td>
            <td>Trần Thị B</td>
            <td>18/04/2025</td>
            <td>2.100.000đ</td>
            <td>COD</td>
            <td><span class="status shipping">Đang giao</span></td>
            <td>
              <button class="action-btn btn-view">Xem</button>
            </td>
          </tr>
        </tbody>
      </table>
    </main>
  </div>

  <script>
    function filterOrders() {
      const input = document.getElementById("searchInput").value.toLowerCase();
      const status = document.getElementById("statusFilter").value;
      const rows = document.querySelectorAll("#orderTable tbody tr");

      rows.forEach(row => {
        const orderCode = row.cells[1].textContent.toLowerCase();
        const customer = row.cells[2].textContent.toLowerCase();
        const currentStatus = row.cells[6].textContent.trim();

        const matchSearch = orderCode.includes(input) || customer.includes(input);
        const matchStatus = !status || currentStatus === status;

        row.style.display = (matchSearch && matchStatus) ? "" : "none";
      });
    }
  </script>
</body>
</html>
