<?php 
include('includes/header.php');  // Kế thừa phần header
include('includes/nav.php');     // Kế thừa phần nav
?>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<?php
// Kết nối đến cơ sở dữ liệu
$link = mysqli_connect("localhost", "root", "", "project-watch");

if (!$link) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Kiểm tra yêu cầu cập nhật số lượng
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && isset($_GET['change'])) {
    $id = $_GET['id'];
    $change = $_GET['change'];

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    $sql = "UPDATE giohang SET soluong = soluong + $change WHERE id = $id";
    mysqli_query($link, $sql);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Kiểm tra yêu cầu xóa sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['items'])) {
    $items = explode(",", $_GET['items']); // Lấy các sản phẩm đã chọn từ GET

    // Lặp qua từng sản phẩm và xóa khỏi cơ sở dữ liệu
    foreach ($items as $item) {
        $sqlDelete = "DELETE FROM giohang WHERE id = $item";
        mysqli_query($link, $sqlDelete);
    }

    // Trả về phản hồi JSON để cập nhật lại giao diện
    echo json_encode(['status' => 'success']);
    exit;
}

// Lấy dữ liệu giỏ hàng
$sql = "SELECT * FROM giohang";
$result = mysqli_query($link, $sql);

mysqli_close($link); // Đảm bảo chỉ đóng kết nối một lần
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
        }

        .cart-container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        button {
            padding: 10px 20px;
            margin: 10px;
            background-color: #000;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            font-weight: bold;
        }

        button:hover {
            background-color: #333;
        }

        .deleteCheckbox {
            display: inline;
        }

        .total-price {
            font-size: 18px;
            margin-top: 20px;
            font-weight: bold;
        }

        .hidden {
            display: none;
        }

        .message {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            margin-top: 10px;
            display: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <h2>Giỏ Hàng</h2>
        <!-- Thông báo xóa sản phẩm -->
        <div id="message" class="message">Sản phẩm đã được xóa khỏi giỏ hàng.</div>
        
        <!-- Nút Sửa và Xóa ở trên -->
        <button id="editBtn">Sửa</button>
        <button id="deleteBtn" class="hidden">Xóa</button>
        <button id="finishBtn" class="hidden">Xong</button>
        <table id="cartTable">
            <thead>
                <tr>
                    <th>Chọn</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                </tr>
            </thead>
            <tbody id="cartItems">
                <?php
                $totalPrice = 0;
                // Hiển thị các sản phẩm trong giỏ hàng
                while ($row = mysqli_fetch_assoc($result)) {
                    $productTotal = $row['Gia'] * $row['soluong'];
                    $totalPrice += $productTotal;
                    echo "<tr data-id='" . $row['id'] . "'>";
                    echo "<td><input type='checkbox' class='deleteCheckbox' data-id='" . $row['id'] . "' data-price='" . $row['Gia'] . "' data-quantity='" . $row['soluong'] . "'></td>";
                    echo "<td><img src='" . $row['Hinhanh'] . "' alt='" . $row['TenSP'] . "' width='50'></td>";
                    echo "<td>" . $row['TenSP'] . "</td>";
                    echo "<td><button class='decrease' data-id='" . $row['id'] . "'>-</button>" . $row['soluong'] . "<button class='increase' data-id='" . $row['id'] . "'>+</button></td>";
                    echo "<td>" . number_format($row['Gia'], 0, ',', '.') . " VNĐ</td>";
                    echo "<td>" . number_format($productTotal, 0, ',', '.') . " VNĐ</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="total-price" id="totalPrice">Tổng tiền: <?php echo number_format($totalPrice, 0, ',', '.') . " VNĐ"; ?></div>
        <!-- Nút Đặt hàng dưới tổng tiền -->
        <a href="/Watch_Store_Manage/pages/thanhtoan.php?order=true&items=<?php echo implode(",", array_column(mysqli_fetch_all($result, MYSQLI_ASSOC), 'id')); ?>">
            <button id="orderBtn">Đặt Hàng</button>
        </a>
    </div>

    <script>
        // Hiển thị hoặc ẩn các nút "Xóa" và "Xong"
        document.getElementById("editBtn").addEventListener("click", function() {
            document.getElementById("deleteBtn").classList.remove("hidden");
            document.getElementById("finishBtn").classList.remove("hidden");
            this.classList.add("hidden");
        });

        document.getElementById("finishBtn").addEventListener("click", function() {
            document.getElementById("deleteBtn").classList.add("hidden");
            document.getElementById("finishBtn").classList.add("hidden");
            document.getElementById("editBtn").classList.remove("hidden");
        });

        // Xóa các sản phẩm đã chọn
        document.getElementById("deleteBtn").addEventListener("click", function() {
            const checkedItems = [];
            document.querySelectorAll(".deleteCheckbox:checked").forEach(function(checkbox) {
                checkedItems.push(checkbox.dataset.id);
            });

            if (checkedItems.length > 0) {
                // Gửi yêu cầu xóa đến server
                fetch(`?items=${checkedItems.join(",")}`)
                    .then(response => response.json()) // Nhận phản hồi JSON
                    .then(data => {
                        if (data.status === 'success') {
                            // Cập nhật lại giỏ hàng mà không cần tải lại trang
                            checkedItems.forEach(itemId => {
                                const row = document.querySelector(`tr[data-id='${itemId}']`);
                                row.parentNode.removeChild(row);
                            });
                            // Hiển thị thông báo đã xóa
                            document.getElementById("message").style.display = 'block';
                            // Cập nhật lại tổng tiền
                            updateTotalPrice();
                        }
                    });
            }
        });

        // Cập nhật lại tổng tiền sau khi xóa sản phẩm
        function updateTotalPrice() {
            let total = 0;
            document.querySelectorAll("tbody tr").forEach(function(row) {
                const price = parseInt(row.querySelector("td:nth-child(5)").innerText.replace(' VNĐ', '').replace(',', ''));
                const quantity = parseInt(row.querySelector("td:nth-child(4)").innerText.replace(/[^0-9]/g, ''));
                total += price * quantity;
            });
            document.getElementById("totalPrice").innerText = "Tổng tiền: " + total.toLocaleString() + " VNĐ";
        }

        // Tăng số lượng sản phẩm
        document.querySelectorAll(".increase").forEach(function(button) {
            button.addEventListener("click", function() {
                const id = this.dataset.id;
                updateQuantity(id, 1);  // Gửi yêu cầu tăng số lượng
            });
        });

        // Giảm số lượng sản phẩm
        document.querySelectorAll(".decrease").forEach(function(button) {
            button.addEventListener("click", function() {
                const id = this.dataset.id;
                updateQuantity(id, -1);  // Gửi yêu cầu giảm số lượng
            });
        });

        // Cập nhật số lượng trong cơ sở dữ liệu
        function updateQuantity(id, change) {
            fetch(`?id=${id}&change=${change}`)  // Gửi yêu cầu GET đến server với id sản phẩm và thay đổi số lượng
                .then(response => response.text())
                .then(data => {
                    location.reload();  // Làm mới trang để cập nhật lại giỏ hàng
                });
        }
    </script>

<?php include('includes/footer.php'); ?>
</body>
</html>
<?php 
include('includes/header.php');  // Kế thừa phần header
include('includes/nav.php');     // Kế thừa phần nav
?>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<?php
// Kết nối đến cơ sở dữ liệu
$link = mysqli_connect("localhost", "root", "", "project-watch");

if (!$link) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Kiểm tra yêu cầu cập nhật số lượng
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && isset($_GET['change'])) {
    $id = $_GET['id'];
    $change = $_GET['change'];

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    $sql = "UPDATE giohang SET soluong = soluong + $change WHERE id = $id";
    mysqli_query($link, $sql);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Kiểm tra yêu cầu xóa sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['items'])) {
    $items = explode(",", $_GET['items']); // Lấy các sản phẩm đã chọn từ GET

    // Lặp qua từng sản phẩm và xóa khỏi cơ sở dữ liệu
    foreach ($items as $item) {
        $sqlDelete = "DELETE FROM giohang WHERE id = $item";
        mysqli_query($link, $sqlDelete);
    }

    // Trả về phản hồi JSON để cập nhật lại giao diện
    echo json_encode(['status' => 'success']);
    exit;
}

// Lấy dữ liệu giỏ hàng
$sql = "SELECT * FROM giohang";
$result = mysqli_query($link, $sql);

mysqli_close($link); // Đảm bảo chỉ đóng kết nối một lần
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
        }

        .cart-container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        button {
            padding: 10px 20px;
            margin: 10px;
            background-color: #000;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            font-weight: bold;
        }

        button:hover {
            background-color: #333;
        }

        .deleteCheckbox {
            display: inline;
        }

        .total-price {
            font-size: 18px;
            margin-top: 20px;
            font-weight: bold;
        }

        .hidden {
            display: none;
        }

        .message {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            margin-top: 10px;
            display: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <h2>Giỏ Hàng</h2>
        <!-- Thông báo xóa sản phẩm -->
        <div id="message" class="message">Sản phẩm đã được xóa khỏi giỏ hàng.</div>
        
        <!-- Nút Sửa và Xóa ở trên -->
        <button id="editBtn">Sửa</button>
        <button id="deleteBtn" class="hidden">Xóa</button>
        <button id="finishBtn" class="hidden">Xong</button>
        <table id="cartTable">
            <thead>
                <tr>
                    <th>Chọn</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                </tr>
            </thead>
            <tbody id="cartItems">
                <?php
                $totalPrice = 0;
                // Hiển thị các sản phẩm trong giỏ hàng
                while ($row = mysqli_fetch_assoc($result)) {
                    $productTotal = $row['Gia'] * $row['soluong'];
                    $totalPrice += $productTotal;
                    echo "<tr data-id='" . $row['id'] . "'>";
                    echo "<td><input type='checkbox' class='deleteCheckbox' data-id='" . $row['id'] . "' data-price='" . $row['Gia'] . "' data-quantity='" . $row['soluong'] . "'></td>";
                    echo "<td><img src='" . $row['Hinhanh'] . "' alt='" . $row['TenSP'] . "' width='50'></td>";
                    echo "<td>" . $row['TenSP'] . "</td>";
                    echo "<td><button class='decrease' data-id='" . $row['id'] . "'>-</button>" . $row['soluong'] . "<button class='increase' data-id='" . $row['id'] . "'>+</button></td>";
                    echo "<td>" . number_format($row['Gia'], 0, ',', '.') . " VNĐ</td>";
                    echo "<td>" . number_format($productTotal, 0, ',', '.') . " VNĐ</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="total-price" id="totalPrice">Tổng tiền: <?php echo number_format($totalPrice, 0, ',', '.') . " VNĐ"; ?></div>
        <!-- Nút Đặt hàng dưới tổng tiền -->
        <a href="/Watch_Store_Manage/pages/thanhtoan.php?order=true&items=<?php echo implode(",", array_column(mysqli_fetch_all($result, MYSQLI_ASSOC), 'id')); ?>">
            <button id="orderBtn">Đặt Hàng</button>
        </a>
    </div>

    <script>
        // Hiển thị hoặc ẩn các nút "Xóa" và "Xong"
        document.getElementById("editBtn").addEventListener("click", function() {
            document.getElementById("deleteBtn").classList.remove("hidden");
            document.getElementById("finishBtn").classList.remove("hidden");
            this.classList.add("hidden");
        });

        document.getElementById("finishBtn").addEventListener("click", function() {
            document.getElementById("deleteBtn").classList.add("hidden");
            document.getElementById("finishBtn").classList.add("hidden");
            document.getElementById("editBtn").classList.remove("hidden");
        });

        // Xóa các sản phẩm đã chọn
        document.getElementById("deleteBtn").addEventListener("click", function() {
            const checkedItems = [];
            document.querySelectorAll(".deleteCheckbox:checked").forEach(function(checkbox) {
                checkedItems.push(checkbox.dataset.id);
            });

            if (checkedItems.length > 0) {
                // Gửi yêu cầu xóa đến server
                fetch(`?items=${checkedItems.join(",")}`)
                    .then(response => response.json()) // Nhận phản hồi JSON
                    .then(data => {
                        if (data.status === 'success') {
                            // Cập nhật lại giỏ hàng mà không cần tải lại trang
                            checkedItems.forEach(itemId => {
                                const row = document.querySelector(`tr[data-id='${itemId}']`);
                                row.parentNode.removeChild(row);
                            });
                            // Hiển thị thông báo đã xóa
                            document.getElementById("message").style.display = 'block';
                            // Cập nhật lại tổng tiền
                            updateTotalPrice();
                        }
                    });
            }
        });

        // Cập nhật lại tổng tiền sau khi xóa sản phẩm
        function updateTotalPrice() {
            let total = 0;
            document.querySelectorAll("tbody tr").forEach(function(row) {
                const price = parseInt(row.querySelector("td:nth-child(5)").innerText.replace(' VNĐ', '').replace(',', ''));
                const quantity = parseInt(row.querySelector("td:nth-child(4)").innerText.replace(/[^0-9]/g, ''));
                total += price * quantity;
            });
            document.getElementById("totalPrice").innerText = "Tổng tiền: " + total.toLocaleString() + " VNĐ";
        }

        // Tăng số lượng sản phẩm
        document.querySelectorAll(".increase").forEach(function(button) {
            button.addEventListener("click", function() {
                const id = this.dataset.id;
                updateQuantity(id, 1);  // Gửi yêu cầu tăng số lượng
            });
        });

        // Giảm số lượng sản phẩm
        document.querySelectorAll(".decrease").forEach(function(button) {
            button.addEventListener("click", function() {
                const id = this.dataset.id;
                updateQuantity(id, -1);  // Gửi yêu cầu giảm số lượng
            });
        });

        // Cập nhật số lượng trong cơ sở dữ liệu
        function updateQuantity(id, change) {
            fetch(`?id=${id}&change=${change}`)  // Gửi yêu cầu GET đến server với id sản phẩm và thay đổi số lượng
                .then(response => response.text())
                .then(data => {
                    location.reload();  // Làm mới trang để cập nhật lại giỏ hàng
                });
        }
    </script>

<?php include('includes/footer.php'); ?>
</body>
</html>
