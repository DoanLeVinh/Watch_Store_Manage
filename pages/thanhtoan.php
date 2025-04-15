<?php include('includes/header.php'); ?>
<?php include('includes/nav.php'); ?> 
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }
        h2 {
            text-align: center;
        }
        .product-list, .customer-info, .payment-info {
            margin-bottom: 20px;
        }
        .product-list table, .payment-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .product-list th, .product-list td, .payment-info th, .payment-info td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .payment-methods input {
            margin-right: 10px;
        }
        .total {
            font-weight: bold;
            font-size: 1.2em;
            text-align: right;
        }
        .qr-code {
            text-align: center;
        }
    </style>


<div class="container">
    <h2>Trang Thanh Toán</h2>

    <!-- Thông tin sản phẩm -->
    <div class="product-list">
        <h3>Thông Tin Sản Phẩm</h3>
        <table>
            <tr>
                <th>Tên Sản Phẩm</th>
                <th>Giá</th>
                <th>Số Lượng</th>
                <th>Tổng Tiền</th>
            </tr>
            <tr>
                <td>Đồng Hồ ABC</td>
                <td>1,500,000 VNĐ</td>
                <td>2</td>
                <td>3,000,000 VNĐ</td>
            </tr>
            <tr>
                <td>Đồng Hồ XYZ</td>
                <td>2,000,000 VNĐ</td>
                <td>1</td>
                <td>2,000,000 VNĐ</td>
            </tr>
        </table>
        <p><strong>Ưu đãi:</strong> Giảm giá 200,000 VNĐ</p>
        <p class="total">Tổng Tiền Cần Thanh Toán: <span id="totalPrice">4,800,000</span> VNĐ</p>
    </div>

    <!-- Thông tin khách hàng -->
    <div class="customer-info">
        <h3>Thông Tin Khách Hàng</h3>
        <form id="customerForm">
            <label for="name">Tên Người Nhận:</label>
            <input type="text" id="name" name="name" required><br><br>
            <label for="address">Địa Chỉ:</label>
            <input type="text" id="address" name="address" required><br><br>
            <label for="phone">Số Điện Thoại:</label>
            <input type="text" id="phone" name="phone" required><br><br>
        </form>
    </div>

    <!-- Hình thức thanh toán -->
    <div class="payment-info">
        <h3>Hình Thức Thanh Toán</h3>
        <div class="payment-methods">
            <input type="radio" id="cod" name="paymentMethod" value="COD" checked>
            <label for="cod">Thanh Toán Khi Nhận Hàng</label><br>
            <input type="radio" id="online" name="paymentMethod" value="Online">
            <label for="online">Thanh Toán Ngay</label>
        </div>
        <div id="onlinePaymentOptions" style="display: none;">
            <label for="paymentMethod">Chọn Phương Thức Thanh Toán:</label><br>
            <input type="radio" id="momo" name="onlinePayment" value="Momo">
            <label for="momo">Momo</label><br>
            <input type="radio" id="bank" name="onlinePayment" value="Bank">
            <label for="bank">Ngân Hàng</label>
        </div>

        <div id="paymentDetails" style="display: none;">
            <div class="qr-code">
                <h4>QR Code Thanh Toán:</h4>
                <img src="https://via.placeholder.com/150" alt="QR Code"><br><br>
                <p><strong>Thông Tin Tài Khoản Ngân Hàng:</strong></p>
                <p>Ngân Hàng A - Số Tài Khoản: 123456789</p>
            </div>
        </div>
    </div>

    <div class="total">
        <p><strong>Số Tiền Cần Thanh Toán Khi Nhận Hàng:</strong> <span id="codAmount">4,800,000</span> VNĐ</p>
    </div>
</div>

<script>
    const codRadio = document.getElementById("cod");
    const onlineRadio = document.getElementById("online");
    const onlinePaymentOptions = document.getElementById("onlinePaymentOptions");
    const paymentDetails = document.getElementById("paymentDetails");
    const totalPrice = document.getElementById("totalPrice");
    const codAmount = document.getElementById("codAmount");

    // Khi thay đổi phương thức thanh toán
    codRadio.addEventListener('change', function() {
        if (codRadio.checked) {
            onlinePaymentOptions.style.display = "none";
            paymentDetails.style.display = "none";
            codAmount.textContent = totalPrice.textContent;
        }
    });

    onlineRadio.addEventListener('change', function() {
        if (onlineRadio.checked) {
            onlinePaymentOptions.style.display = "block";
            paymentDetails.style.display = "none";
            codAmount.textContent = "0 VNĐ";
        }
    });

    // Khi chọn phương thức thanh toán online
    document.querySelectorAll('input[name="onlinePayment"]').forEach(function(input) {
        input.addEventListener('change', function() {
            paymentDetails.style.display = "block";
        });
    });
</script>


<?php include('includes/footer.php'); ?> <!-- Kế thừa phần footer -->