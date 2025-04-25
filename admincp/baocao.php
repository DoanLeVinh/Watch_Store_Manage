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
    .btn-detail { background-color: #6c757d; }
  </style>
</head>
<body>
  <?php include("oriented/header.php"); ?>
  <div class="container">
    <?php include("oriented/sidebar.php"); ?>
    <main>
      <h2 class="section-header">📊 Báo cáo tổng hợp</h2>

      <div class="filter-bar">
        <select id="reportType">
          <option value="">Chọn loại báo cáo</option>
          <option value="revenue">Doanh số</option>
          <option value="customers">Lượng khách</option>
          <option value="products">Sản phẩm bán chạy/chậm</option>
          <option value="finance">Thống kê thu chi</option>
          <option value="feedback">Đánh giá & phản hồi</option>
        </select>
        <input type="date" id="startDate">
        <input type="date" id="endDate">
        <button onclick="filterReports()">Lọc</button>
      </div>

      <div id="reportContent">
        <!-- Nội dung báo cáo sẽ hiển thị ở đây -->
        <p>Vui lòng chọn loại báo cáo và khoảng thời gian để xem thống kê.</p>
      </div>
    </main>
  </div>

  <script>
    function filterReports() {
      const type = document.getElementById("reportType").value;
      const start = document.getElementById("startDate").value;
      const end = document.getElementById("endDate").value;
      const content = document.getElementById("reportContent");

      content.innerHTML = "";

      if (!type) {
        content.innerHTML = "<p>Vui lòng chọn loại báo cáo.</p>";
        return;
      }

      let html = "";

      switch(type) {
        case "revenue":
          html = `
            <h3>📈 Báo cáo doanh số</h3>
            <table>
              <thead><tr><th>Ngày</th><th>Doanh số Online</th><th>Doanh số Offline</th><th>Tổng</th></tr></thead>
              <tbody>
                <tr><td>18/04/2025</td><td>3.500.000đ</td><td>5.000.000đ</td><td>8.500.000đ</td></tr>
                <tr><td>19/04/2025</td><td>4.200.000đ</td><td>4.800.000đ</td><td>9.000.000đ</td></tr>
              </tbody>
            </table>`;
          break;
        case "customers":
          html = `
            <h3>👥 Báo cáo lượng khách</h3>
            <table>
              <thead><tr><th>Ngày</th><th>Khách đặt hàng</th><th>Khách tại cửa hàng</th></tr></thead>
              <tbody>
                <tr><td>18/04/2025</td><td>25</td><td>18</td></tr>
                <tr><td>19/04/2025</td><td>32</td><td>22</td></tr>
              </tbody>
            </table>`;
          break;
        case "products":
          html = `
            <h3>🔥 Sản phẩm bán chạy & 🧊 Sản phẩm bán chậm</h3>
            <table>
              <thead><tr><th>Sản phẩm</th><th>Số lượng bán</th><th>Loại</th></tr></thead>
              <tbody>
                <tr><td>Đồng hồ A</td><td>120</td><td>Bán chạy</td></tr>
                <tr><td>Đồng hồ B</td><td>5</td><td>Bán chậm</td></tr>
              </tbody>
            </table>`;
          break;
        case "finance":
          html = `
            <h3>📒 Thống kê thu chi</h3>
            <table>
              <thead><tr><th>Ngày</th><th>Thu</th><th>Chi</th><th>Chênh lệch</th></tr></thead>
              <tbody>
                <tr><td>18/04/2025</td><td>5.000.000đ</td><td>2.000.000đ</td><td>+3.000.000đ</td></tr>
                <tr><td>19/04/2025</td><td>6.500.000đ</td><td>3.200.000đ</td><td>+3.300.000đ</td></tr>
              </tbody>
            </table>`;
          break;
        case "feedback":
          html = `
            <h3>⭐ Thống kê đánh giá & phản hồi</h3>
            <table>
              <thead><tr><th>Ngày</th><th>Lượt đánh giá</th><th>Điểm trung bình</th><th>Phản hồi</th></tr></thead>
              <tbody>
                <tr><td>18/04/2025</td><td>12</td><td>4.5</td><td>"Chất lượng tốt, giao hàng nhanh"</td></tr>
                <tr><td>19/04/2025</td><td>9</td><td>4.2</td><td>"Phục vụ tốt nhưng giao hàng hơi chậm"</td></tr>
              </tbody>
            </table>`;
          break;
      }

      content.innerHTML = html;
    }
  </script>
</body>
</html>
