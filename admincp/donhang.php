<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: DN.php");
    exit();
}
include('config.php');
include('oriented/header.php');

// Kiểm tra nếu có yêu cầu cập nhật trạng thái
if (isset($_POST['update_status'])) {
    $MaDH = $_POST['MaDH'];
    $TinhTrang = $_POST['TinhTrang'];
    
    // Kiểm tra trạng thái hợp lệ
    $validStatuses = ['Chờ xác nhận', 'Xác nhận', 'Đang giao', 'Hoàn thành'];
    if (!in_array($TinhTrang, $validStatuses)) {
        echo json_encode(['success' => false, 'message' => 'Trạng thái không hợp lệ']);
        exit;
    }

    // Cập nhật trạng thái vào cơ sở dữ liệu
    $sql = "UPDATE dh SET TinhTrang = ? WHERE MaDH = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("si", $TinhTrang, $MaDH);

    // Sửa lại phần kiểm tra kết quả
    if ($stmt->execute()) {
        // Kiểm tra xem có bản ghi nào được cập nhật không
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Cập nhật trạng thái thành công!']);
        } else {
            // Không có bản ghi nào được cập nhật (có thể mã đơn hàng không tồn tại)
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy đơn hàng hoặc trạng thái không thay đổi']);
        }
    } else {
        // Lỗi khi thực thi query
        echo json_encode(['success' => false, 'message' => 'Lỗi cơ sở dữ liệu: ' . $stmt->error]);
    }
    exit;
}

// Truy vấn lấy thông tin đơn hàng với sắp xếp theo thời gian (giả định có trường NgayTao)
$sql = "SELECT MaDH, HoTen, SDT, DiaChi, TenSP, Loinhan, PhuongThucVanChuyen, Voucher, Tongtien, TinhTrang 
        FROM dh 
        ORDER BY 
            CASE 
                WHEN TinhTrang = 'Chờ xác nhận' THEN 1
                WHEN TinhTrang = 'Xác nhận' THEN 2
                WHEN TinhTrang = 'Đang giao' THEN 3
                WHEN TinhTrang = 'Hoàn thành' THEN 4
                ELSE 5
            END, MaDH DESC";
$result = $link->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Đơn Hàng</title>
    <style>
    /* CSS giữ nguyên như cũ */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
        background-color: #f8f8f8;
        color: #333;
        line-height: 1.6;
    }
    
    .container {
        max-width: 95%;
        margin: 30px auto;
        padding: 20px;
        background-color: white;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
    }
    
    h1 {
        color: #222;
        text-align: center;
        margin-bottom: 30px;
        font-weight: 600;
        letter-spacing: 1px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    /* Bảng đơn hàng */
    #orderTable {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 14px;
    }
    
    #orderTable thead {
        background-color: #222;
        color: white;
    }
    
    #orderTable th {
        padding: 15px;
        text-align: left;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    
    #orderTable tbody tr {
        border-bottom: 1px solid #eee;
        transition: all 0.2s ease;
    }
    
    #orderTable tbody tr:hover {
        background-color: #f9f9f9;
    }
    
    #orderTable td {
        padding: 15px;
        vertical-align: top;
    }
    
    /* Dropdown trạng thái */
    .status-selector {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: white;
        color: #333;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
        min-width: 120px;
    }
    
    .status-selector:focus {
        outline: none;
        border-color: #555;
        box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1);
    }
    
    .status-selector option {
        padding: 8px;
    }
    
    /* Màu sắc cho các trạng thái */
    .status-pending {
        color: #ff9800;
        font-weight: bold;
    }
    
    .status-confirmed {
        color: #2196f3;
        font-weight: bold;
    }
    
    .status-shipping {
        color: #4caf50;
        font-weight: bold;
    }
    
    .status-completed {
        color: #9c27b0;
        font-weight: bold;
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .container {
            max-width: 100%;
            margin: 10px;
            padding: 10px;
        }
        
        #orderTable {
            display: block;
            overflow-x: auto;
        }
    }
    
    /* Hiệu ứng và chi tiết sang trọng */
    #orderTable th:first-child {
        border-top-left-radius: 6px;
    }
    
    #orderTable th:last-child {
        border-top-right-radius: 6px;
    }
    
    #orderTable tr:last-child {
        border-bottom: none;
    }
    
    .MaDH {
        font-weight: 600;
        color: #222;
    }
    
    /* Style cho số tiền */
    td:nth-child(9) {
        font-weight: 600;
        color: #222;
    }
    
    /* Disabled state */
    .status-selector:disabled {
        background-color: #f5f5f5;
        color: #666;
        cursor: not-allowed;
    }
    
    /* Badge cho trạng thái */
    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        margin-left: 5px;
    }
    
    .pending-badge {
        background-color: #fff3e0;
        color: #ff9800;
    }
    
    .confirmed-badge {
        background-color: #e3f2fd;
        color: #2196f3;
    }
    
    .shipping-badge {
        background-color: #e8f5e9;
        color: #4caf50;
    }
    
    .completed-badge {
        background-color: #f3e5f5;
        color: #9c27b0;
    }
</style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h1>Quản lý Đơn Hàng</h1>
        <table id="orderTable">
            <thead>
                <tr>
                    <th>Mã ĐH</th>
                    <th>Họ Tên</th>
                    <th>Số Điện Thoại</th>
                    <th>Địa Chỉ</th>
                    <th>Sản Phẩm</th>
                    <th>Lời Nhắn</th>
                    <th>Phương Thức VC</th>
                    <th>Voucher</th>
                    <th>Tổng Tiền</th>
                    <th>Tình Trạng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $trangThai = empty($row['TinhTrang']) ? 'Chờ xác nhận' : $row['TinhTrang'];
                        $statusClass = '';
                        
                        // Xác định class CSS dựa trên trạng thái
                        switch($trangThai) {
                            case 'Chờ xác nhận':
                                $statusClass = 'status-pending';
                                break;
                            case 'Xác nhận':
                                $statusClass = 'status-confirmed';
                                break;
                            case 'Đang giao':
                                $statusClass = 'status-shipping';
                                break;
                            case 'Hoàn thành':
                                $statusClass = 'status-completed';
                                break;
                        }
                        
                        echo '<tr data-current-status="' . htmlspecialchars($trangThai) . '">';
                        echo '<td class="MaDH">' . htmlspecialchars($row['MaDH']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['HoTen']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['SDT']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['DiaChi']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['TenSP']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Loinhan']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['PhuongThucVanChuyen']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Voucher']) . '</td>';
                        echo '<td>' . number_format($row['Tongtien'], 0, ',', '.') . ' VNĐ</td>';
                        echo '<td class="' . $statusClass . '">
                                <select class="status-selector"' . ($trangThai === 'Hoàn thành' ? ' disabled' : '') . '>
                                    <option value="Chờ xác nhận"' . ($trangThai === 'Chờ xác nhận' ? ' selected' : '') . '>Chờ xác nhận</option>
                                    <option value="Xác nhận"' . ($trangThai === 'Xác nhận' ? ' selected' : '') . '>Xác nhận</option>
                                    <option value="Đang giao"' . ($trangThai === 'Đang giao' ? ' selected' : '') . '>Đang giao</option>
                                    <option value="Hoàn thành"' . ($trangThai === 'Hoàn thành' ? ' selected' : '') . '>Hoàn thành</option>
                                </select>
                                <span class="status-badge ' . strtolower(str_replace(' ', '-', $trangThai)) . '-badge">' . $trangThai . '</span>
                              </td>';
                        echo '</tr>';
                    }
                } else {
                    echo "<tr><td colspan='10' style='text-align: center;'>Không có đơn hàng nào</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            // Xử lý thay đổi trạng thái
            $('.status-selector').change(function() {
                let orderRow = $(this).closest('tr');
                let MaDH = orderRow.find('.MaDH').text();
                let selectedStatus = $(this).val();
                let currentStatus = orderRow.data('current-status');
                
                // Hiển thị loading
                Swal.fire({
                    title: 'Đang xử lý',
                    html: 'Vui lòng chờ trong giây lát...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Kiểm tra quy trình chuyển trạng thái
                let errorMsg = '';
                let isValid = true;
                
                if (selectedStatus === 'Xác nhận' && currentStatus !== 'Chờ xác nhận') {
                    errorMsg = "Bạn chỉ có thể xác nhận đơn hàng từ trạng thái 'Chờ xác nhận'";
                    isValid = false;
                }
                else if (selectedStatus === 'Đang giao' && currentStatus !== 'Xác nhận') {
                    errorMsg = "Bạn phải 'Xác nhận' đơn hàng trước khi chuyển sang 'Đang giao'";
                    isValid = false;
                }
                else if (selectedStatus === 'Hoàn thành' && currentStatus !== 'Đang giao') {
                    errorMsg = "Bạn phải chọn 'Đang giao' trước khi chuyển sang 'Hoàn thành'";
                    isValid = false;
                }

                if (!isValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: errorMsg,
                        confirmButtonColor: '#3085d6',
                    }).then(() => {
                        $(this).val(currentStatus);
                    });
                    return false;
                }

                // Gửi AJAX để cập nhật trạng thái
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: {
                        update_status: true,
                        MaDH: MaDH,
                        TinhTrang: selectedStatus
                    },
                    dataType: 'json',
                    success: function(response) {
                        Swal.close();
                        
                        if (response.success) {
                            // Cập nhật trạng thái hiện tại
                            orderRow.data('current-status', selectedStatus);
                            
                            // Cập nhật giao diện
                            orderRow.find('.status-badge')
                                .removeClass('pending-badge confirmed-badge shipping-badge completed-badge')
                                .addClass(selectedStatus.toLowerCase().replace(' ', '-') + '-badge')
                                .text(selectedStatus);
                            
                            // Cập nhật class trạng thái
                            let newStatusClass = '';
                            switch(selectedStatus) {
                                case 'Chờ xác nhận': newStatusClass = 'status-pending'; break;
                                case 'Xác nhận': newStatusClass = 'status-confirmed'; break;
                                case 'Đang giao': newStatusClass = 'status-shipping'; break;
                                case 'Hoàn thành': newStatusClass = 'status-completed'; break;
                            }
                            orderRow.find('td:nth-child(10)').removeClass('status-pending status-confirmed status-shipping status-completed').addClass(newStatusClass);
                            
                            // Nếu là Hoàn thành thì khóa select
                            if (selectedStatus === 'Hoàn thành') {
                                orderRow.find('.status-selector').prop('disabled', true);
                            }
                            
                            // Hiển thị thông báo thành công
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: response.message,
                                confirmButtonColor: '#3085d6',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: response.message,
                                confirmButtonColor: '#3085d6',
                            });
                            orderRow.find('.status-selector').val(currentStatus);
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Có lỗi xảy ra khi cập nhật trạng thái: ' + error,
                            confirmButtonColor: '#3085d6',
                        });
                        orderRow.find('.status-selector').val(currentStatus);
                    }
                });
            });
        });
    </script>
</body>
</html>