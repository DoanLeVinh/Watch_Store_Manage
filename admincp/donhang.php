<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: DN.php");
    exit();
}

// Bật hiển thị lỗi để debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('config.php');
include('oriented/header.php');

// Kiểm tra kết nối database
if ($link->connect_error) {
    die("Kết nối database thất bại: " . $link->connect_error);
}

// Xử lý AJAX request để lấy chi tiết đơn hàng
if (isset($_POST['action']) && $_POST['action'] == 'get_order_details') {
    $order_id = $_POST['order_id'];
    
    $sql = "SELECT * FROM dh WHERE MaDH = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
        
        $formatted_date = date("d/m/Y H:i", strtotime($order["NgayTao"]));
        $formatted_total = number_format($order["TongTien"], 0, ',', '.') . 'đ';
        
        $status_class = '';
        switch ($order["TinhTrang"]) {
            case 'Chờ xác nhận': $status_class = 'status-pending'; break;
            case 'xác nhận': $status_class = 'status-confirmed'; break;
            case 'đang giao': $status_class = 'status-shipping'; break;
            case 'hoàn thành': $status_class = 'status-completed'; break;
        }
        
        $response = '
        <div class="order-info-section">
            <h3><i class="fas fa-info-circle"></i> Thông tin chung</h3>
            <div class="order-info-grid">
                <div class="info-item">
                    <span class="info-label">Trạng thái</span>
                    <div class="info-value status-badge '.$status_class.'">'.$order["TinhTrang"].'</div>
                </div>
                <div class="info-item">
                    <span class="info-label">Ngày tạo</span>
                    <div class="info-value">'.$formatted_date.'</div>
                </div>
                <div class="info-item">
                    <span class="info-label">Phương thức vận chuyển</span>
                    <div class="info-value">'.$order["PhuongThucVanChuyen"].'</div>
                </div>
                <div class="info-item">
                    <span class="info-label">Voucher</span>
                    <div class="info-value">'.($order["Voucher"] ? $order["Voucher"] : 'Không có').'</div>
                </div>
            </div>
        </div>
        
        <div class="order-info-section">
            <h3><i class="fas fa-user"></i> Thông tin khách hàng</h3>
            <div class="order-info-grid">
                <div class="info-item">
                    <span class="info-label">Họ tên</span>
                    <div class="info-value">'.$order["HoTen"].'</div>
                </div>
                <div class="info-item">
                    <span class="info-label">Số điện thoại</span>
                    <div class="info-value">'.$order["SDT"].'</div>
                </div>
                <div class="info-item">
                    <span class="info-label">Địa chỉ</span>
                    <div class="info-value">'.$order["DiaChi"].'</div>
                </div>
                <div class="info-item">
                    <span class="info-label">Lời nhắn</span>
                    <div class="info-value">'.($order["LoiNhan"] ? $order["LoiNhan"] : 'Không có lời nhắn').'</div>
                </div>
            </div>
        </div>
        
        <div class="order-info-section">
            <h3><i class="fas fa-box-open"></i> Sản phẩm</h3>
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>'.$order["TenSP"].'</td>
                        <td>'.$order["SoLuong"].'</td>
                        <td>'.number_format($order["TongTien"] / $order["SoLuong"], 0, ',', '.').'đ</td>
                        <td>'.$formatted_total.'</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="order-info-section">
            <h3><i class="fas fa-receipt"></i> Thanh toán</h3>
            <div style="max-width: 300px; margin-left: auto;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span>Tổng tiền hàng:</span>
                    <span>'.$formatted_total.'</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span>Phí vận chuyển:</span>
                    <span>30,000đ</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span>Giảm giá voucher:</span>
                    <span>-50,000đ</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-weight: 600; font-size: 16px; margin-top: 15px;">
                    <span>Tổng thanh toán:</span>
                    <span>'.number_format($order["TongTien"] - 50000 + 30000, 0, ',', '.').'đ</span>
                </div>
            </div>
        </div>';
        
        echo $response;
    } else {
        echo '<p>Không tìm thấy thông tin đơn hàng</p>';
    }
    exit;
}

// Xử lý AJAX request để cập nhật trạng thái
if (isset($_POST['action']) && $_POST['action'] == 'update_status') {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
    $valid_statuses = ['Chờ xác nhận', 'xác nhận', 'đang giao', 'hoàn thành'];
    if (!in_array($new_status, $valid_statuses)) {
        echo json_encode(['success' => false, 'message' => 'Trạng thái không hợp lệ']);
        exit;
    }
    
    $sql = "UPDATE dh SET TinhTrang = ? WHERE MaDH = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("ss", $new_status, $order_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Cập nhật thất bại: ' . $stmt->error]);
    }
    exit;
}

// Lấy dữ liệu đơn hàng từ bảng dh
$sql = "SELECT * FROM dh ORDER BY NgayTao DESC";
$result = $link->query($sql);
$total_orders = $result->num_rows;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --light-gray: #f5f5f5;
            --medium-gray: #e0e0e0;
            --dark-gray: #333333;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
            color: var(--dark-gray);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 1px solid var(--medium-gray);
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: var(--dark-gray);
        }
        
        .search-filter {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .search-box {
            flex: 1;
            position: relative;
        }
        
        .search-box input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 1px solid var(--medium-gray);
            border-radius: 4px;
            font-size: 14px;
        }
        
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--dark-gray);
        }
        
        .filter-dropdown {
            min-width: 200px;
        }
        
        .filter-dropdown select {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--medium-gray);
            border-radius: 4px;
            font-size: 14px;
            background-color: white;
        }
        
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .orders-table th {
            background-color: var(--light-gray);
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: var(--dark-gray);
            border-bottom: 1px solid var(--medium-gray);
        }
        
        .orders-table td {
            padding: 15px;
            border-bottom: 1px solid var(--light-gray);
            vertical-align: middle;
        }
        
        .orders-table tr:last-child td {
            border-bottom: none;
        }
        
        .orders-table tr:hover {
            background-color: #f9f9f9;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-pending {
            background-color: #fff4e5;
            color: #ff9500;
        }
        
        .status-confirmed {
            background-color: #e5f6ff;
            color: #0077cc;
        }
        
        .status-shipping {
            background-color: #e5f9ff;
            color: #00a2d6;
        }
        
        .status-completed {
            background-color: #e6f7e6;
            color: #00a700;
        }
        
        .status-select {
            padding: 6px 10px;
            border-radius: 4px;
            border: 1px solid var(--medium-gray);
            font-size: 13px;
            cursor: pointer;
        }
        
        .action-btn {
            background: none;
            border: none;
            color: var(--primary-color);
            cursor: pointer;
            font-size: 14px;
            margin-right: 10px;
        }
        
        .action-btn:hover {
            text-decoration: underline;
        }
        
        .pagination {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
            gap: 5px;
        }
        
        .page-btn {
            padding: 8px 12px;
            border: 1px solid var(--medium-gray);
            background-color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .page-btn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .page-btn:hover:not(.active) {
            background-color: var(--light-gray);
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 8px;
            width: 80%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
        
        .modal-header {
            padding: 20px;
            border-bottom: 1px solid var(--medium-gray);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-header h2 {
            margin: 0;
            font-size: 20px;
            color: var(--dark-gray);
        }
        
        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--dark-gray);
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .order-info-section {
            margin-bottom: 25px;
        }
        
        .order-info-section h3 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 16px;
            color: var(--dark-gray);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .order-info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        
        .info-item {
            margin-bottom: 10px;
        }
        
        .info-label {
            font-weight: 600;
            color: var(--dark-gray);
            margin-bottom: 5px;
            display: block;
        }
        
        .info-value {
            padding: 8px 12px;
            background-color: var(--light-gray);
            border-radius: 4px;
        }
        
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .products-table th {
            background-color: var(--light-gray);
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }
        
        .products-table td {
            padding: 12px;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .modal-footer {
            padding: 15px 20px;
            border-top: 1px solid var(--medium-gray);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            border: 1px solid transparent;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-outline {
            background-color: white;
            border-color: var(--medium-gray);
            color: var(--dark-gray);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-shopping-cart"></i> Quản lý đơn hàng</h1>
            <div>
                <span id="order-count">Tổng: <?php echo $total_orders; ?> đơn hàng</span>
            </div>
        </div>
        
        <div class="search-filter">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="search-input" placeholder="Tìm kiếm đơn hàng...">
            </div>
            <div class="filter-dropdown">
                <select id="status-filter">
                    <option value="">Tất cả trạng thái</option>
                    <option value="Chờ xác nhận">Chờ xác nhận</option>
                    <option value="xác nhận">Đã xác nhận</option>
                    <option value="đang giao">Đang giao</option>
                    <option value="hoàn thành">Hoàn thành</option>
                </select>
            </div>
            <div class="filter-dropdown">
                <select id="date-filter">
                    <option value="">Tất cả ngày tạo</option>
                    <option value="today">Hôm nay</option>
                    <option value="week">Tuần này</option>
                    <option value="month">Tháng này</option>
                </select>
            </div>
        </div>
        
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Khách hàng</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Tổng tiền</th>
                    <th>Ngày tạo</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $formatted_date = date("d/m/Y", strtotime($row["NgayTao"]));
                        $formatted_total = number_format($row["TongTien"], 0, ',', '.') . 'đ';
                        
                        // Kiểm tra và đảm bảo trạng thái hợp lệ
                        $current_status = in_array($row["TinhTrang"], ['Chờ xác nhận', 'xác nhận', 'đang giao', 'hoàn thành']) 
                            ? $row["TinhTrang"] 
                            : 'Chờ xác nhận';
                        
                        $disabled_shipping = ($current_status == "Chờ xác nhận") ? "disabled" : "";
                        $disabled_completed = ($current_status == "Chờ xác nhận" || $current_status == "xác nhận") ? "disabled" : "";
                        $select_disabled = ($current_status == "hoàn thành") ? "disabled" : "";
                        
                        echo '<tr>
                            <td>'.$row["MaDH"].'</td>
                            <td>'.$row["HoTen"].'</td>
                            <td>'.$row["TenSP"].'</td>
                            <td>'.$row["SoLuong"].'</td>
                            <td>'.$formatted_total.'</td>
                            <td>'.$formatted_date.'</td>
                            <td>
                                <select class="status-select" data-order-id="'.$row["MaDH"].'" '.$select_disabled.'>
                                    <option value="Chờ xác nhận" '.($current_status == "Chờ xác nhận" ? "selected" : "").'>Chờ xác nhận</option>
                                    <option value="xác nhận" '.($current_status == "xác nhận" ? "selected" : "").'>Xác nhận</option>
                                    <option value="đang giao" '.($current_status == "đang giao" ? "selected" : "").' '.$disabled_shipping.'>Đang giao</option>
                                    <option value="hoàn thành" '.($current_status == "hoàn thành" ? "selected" : "").' '.$disabled_completed.'>Hoàn thành</option>
                                </select>
                            </td>
                            <td>
                                <button class="action-btn view-detail" data-order-id="'.$row["MaDH"].'">
                                    <i class="fas fa-eye"></i> Xem
                                </button>
                            </td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="8" style="text-align: center;">Không có đơn hàng nào</td></tr>';
                }
                ?>
            </tbody>
        </table>
        
        <div class="pagination">
            <button class="page-btn"><i class="fas fa-angle-left"></i></button>
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn"><i class="fas fa-angle-right"></i></button>
        </div>
    </div>
    
    <!-- Order Detail Modal -->
    <div class="modal" id="orderDetailModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-file-invoice"></i> Chi tiết đơn hàng #<span id="modal-order-id">DH001</span></h2>
                <button class="close-btn">&times;</button>
            </div>
            <div class="modal-body" id="modal-order-details">
                <!-- Nội dung sẽ được điền bằng JavaScript -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="print-btn"><i class="fas fa-print"></i> In hóa đơn</button>
                <button class="btn btn-primary" id="save-btn"><i class="fas fa-save"></i> Lưu thay đổi</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Mở modal chi tiết đơn hàng
            $('.view-detail').click(function() {
                const orderId = $(this).data('order-id');
                $('#modal-order-id').text(orderId);
                
                // Hiển thị loading
                $('#modal-order-details').html('<p style="text-align: center;"><i class="fas fa-spinner fa-spin"></i> Đang tải thông tin...</p>');
                $('#orderDetailModal').css('display', 'flex');
                
                // Gửi AJAX request để lấy chi tiết đơn hàng
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: { 
                        action: 'get_order_details',
                        order_id: orderId 
                    },
                    success: function(response) {
                        $('#modal-order-details').html(response);
                    },
                    error: function(xhr, status, error) {
                        $('#modal-order-details').html('<p style="color: red;">Lỗi khi tải chi tiết: ' + error + '</p>');
                    }
                });
            });
            
            // Đóng modal
            $('.close-btn').click(function() {
                $('#orderDetailModal').hide();
            });
            
            // Đóng modal khi click bên ngoài
            $(window).click(function(event) {
                if ($(event.target).is('#orderDetailModal')) {
                    $('#orderDetailModal').hide();
                }
            });
            
            // Xử lý thay đổi trạng thái đơn hàng
            $('.status-select').change(function() {
                const orderId = $(this).data('order-id');
                const newStatus = $(this).val();
                const selectElement = $(this);
                
                // Hiển thị loading
                selectElement.prop('disabled', true);
                selectElement.after('<i class="fas fa-spinner fa-spin loading-icon" style="margin-left: 5px;"></i>');
                
                // Gửi AJAX request để cập nhật trạng thái
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: { 
                        action: 'update_status',
                        order_id: orderId,
                        new_status: newStatus
                    },
                    success: function(response) {
                        $('.loading-icon').remove();
                        
                        if (response.success) {
                            // Cập nhật giao diện nếu thành công
                            alert('Cập nhật trạng thái thành công');
                            
                            // Nếu là hoàn thành thì disable select
                            if (newStatus === 'hoàn thành') {
                                selectElement.prop('disabled', true);
                            }
                            
                            // Cập nhật các option disabled dựa trên trạng thái mới
                            selectElement.find('option[value="đang giao"]').prop('disabled', newStatus === 'Chờ xác nhận');
                            selectElement.find('option[value="hoàn thành"]').prop('disabled', newStatus === 'Chờ xác nhận' || newStatus === 'xác nhận');
                        } else {
                            alert('Có lỗi khi cập nhật trạng thái: ' + (response.message || 'Không xác định'));
                            // Khôi phục giá trị cũ
                            selectElement.val(selectElement.data('old-value'));
                        }
                    },
                    error: function(xhr, status, error) {
                        $('.loading-icon').remove();
                        selectElement.prop('disabled', false);
                        alert('Lỗi kết nối: ' + error);
                        // Khôi phục giá trị cũ
                        selectElement.val(selectElement.data('old-value'));
                    },
                    dataType: 'json'
                });
            });
            
            // Lưu giá trị cũ khi bắt đầu thay đổi
            $('.status-select').focus(function() {
                $(this).data('old-value', $(this).val());
            });
            
            // Tìm kiếm đơn hàng
            $('#search-input').keyup(function() {
                const searchText = $(this).val().toLowerCase();
                $('.orders-table tbody tr').each(function() {
                    const rowText = $(this).text().toLowerCase();
                    $(this).toggle(rowText.indexOf(searchText) > -1);
                });
            });
            
            // Lọc theo trạng thái
            $('#status-filter').change(function() {
                const filterValue = $(this).val();
                if (filterValue === "") {
                    $('.orders-table tbody tr').show();
                } else {
                    $('.orders-table tbody tr').each(function() {
                        const rowStatus = $(this).find('.status-select').val();
                        $(this).toggle(rowStatus === filterValue);
                    });
                }
            });
            
            // Nút in hóa đơn
            $('#print-btn').click(function() {
                window.print();
            });
            
            // Nút lưu thay đổi
            $('#save-btn').click(function() {
                alert('Các thay đổi đã được lưu');
                $('#orderDetailModal').hide();
            });
        });
    </script>
</body>
</html>
<?php
$link->close();
?>