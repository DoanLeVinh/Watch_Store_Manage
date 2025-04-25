<?php 
session_start();
include('includes/header.php');
include('includes/nav.php');
?>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<style>
  body {
    font-family: 'Segoe UI', sans-serif;
    background: #f1f3f6;
    margin: 0;
    padding: 0;
  }

  .c1 {
    max-width: 900px;
    margin: 30px auto;
    padding: 20px;
    background: white;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    border-radius: 12px;
  }

  .c2 {
    margin-bottom: 30px;
  }

  .c3 {
    font-size: 20px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
  }

  .c5, .c9 {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    margin-top: 5px;
  }

  .c6 input[type="radio"] {
    margin-right: 8px;
  }

  .c7 {
    display: flex;
    justify-content: space-between;
    margin: 10px 0;
    font-size: 16px;
  }

  .c8 {
    font-weight: bold;
    font-size: 18px;
    color: #d9534f;
  }

  .c10 {
    display: none;
    margin-top: 10px;
  }

  .c11 {
    padding: 12px 25px;
    background:rgb(36, 36, 36);
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 5px;
  }

  .c11:hover {
    background: black;
    color: white;
  }

  .c12 {
    text-align: center;
    font-size: 16px;
    margin-top: 15px;
    color: green;
    font-weight: bold;
  }

  .product-row {
    display: flex;
    align-items: center;
    padding: 12px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #fff;
  }

  .product-row img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 15px;
    flex-shrink: 0;
  }

  .product-details {
    padding: 0 10px;
    font-size: 15px;
    flex-shrink: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .product-details.name {
    flex: 2;
  }

  .product-details.quantity,
  .product-details.price,
  .product-details.subtotal {
    flex: 1;
    text-align: center;
  }

  #voucher-suggestions li {
    list-style: none;
    padding: 6px;
    cursor: pointer;
    border-bottom: 1px solid #ddd;
  }

  #voucher-suggestions li:hover {
    background-color: #f0f0f0;
  }

  @media (max-width: 600px) {
    .c1 {
      padding: 15px;
    }

    .c11 {
      width: 100%;
    }
  }
</style>

<div class="c1">
  <div class="c2">
    <h2 class="c3">Thông tin sản phẩm</h2>
    <div id="product-list">
      <?php 
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            $totalProductPrice = 0;
            foreach ($_SESSION['cart'] as $product) {
                echo "
                    <div class='product-row'>
                        <img src='" . $product['Hinhanh'] . "' alt='" . $product['TenSP'] . "'>
                        <div class='product-details name'>" . $product['TenSP'] . "</div>
                        <div class='product-details quantity'>" . $product['soluong'] . "</div>
                        <div class='product-details price'>" . number_format($product['Gia'], 0, ',', '.') . "₫</div>
                        <div class='product-details subtotal' data-price='" . $product['Gia'] * $product['soluong'] . "'>" . number_format($product['Gia'] * $product['soluong'], 0, ',', '.') . "₫</div>
                    </div>
                ";
                $totalProductPrice += $product['Gia'] * $product['soluong'];
            }
        } else {
            echo "<p>Giỏ hàng của bạn chưa có sản phẩm nào.</p>";
        }
      ?>
    </div>
    <label for="c14">Lời nhắn cho hãng:</label><br>
    <textarea id="c14" class="c5" rows="3"></textarea>
  </div>

  <div class="c2">
    <h2 class="c3">Phương thức vận chuyển</h2>
    <div class="c6">
      <label><input type="radio" name="shipping" value="30000" checked> Tiết kiệm - 30,000₫</label><br>
      <label><input type="radio" name="shipping" value="50000"> Nhanh - 50,000₫</label><br>
      <label><input type="radio" name="shipping" value="80000"> Hỏa tốc - 80,000₫</label>
    </div>
  </div>

  <div class="c2">
    <h2 class="c3">Voucher giảm giá</h2>
    <input type="text" id="c15" class="c9" placeholder="Nhập mã giảm giá" onfocus="showVoucherHints()" oninput="filterVoucherHints()">
    <ul id="voucher-suggestions" style="margin-top: 5px; display: none; padding-left: 20px;"></ul>
    <button class="c11" onclick="applyVoucher()">Áp dụng</button>
    <p id="c16" style="margin-top: 5px;"></p>
  </div>

  <div class="c2">
    <h2 class="c3">Tổng thanh toán</h2>
    <div class="c7"><span>Tổng tiền sản phẩm:</span><span id="c17"><?php echo number_format($totalProductPrice, 0, ',', '.') . "₫"; ?></span></div>
    <div class="c7"><span>Phí vận chuyển:</span><span id="c18">30,000₫</span></div>
    <div class="c7"><span>Giảm giá:</span><span id="c19">0₫</span></div>
    <div class="c7 c8"><span>Thành tiền cần thanh toán:</span><span id="c20"><?php echo number_format($totalProductPrice + 30000, 0, ',', '.') . "₫"; ?></span></div>
  </div>

  <div class="c2">
    <h2 class="c3">Thông tin khách hàng</h2>
    <input type="text" id="c21" class="c9" placeholder="Họ tên">
    <input type="text" id="c22" class="c9" placeholder="Số điện thoại">
    <input type="text" id="c23" class="c9" placeholder="Địa chỉ giao hàng">
  </div>

  <div class="c2">
    <h2 class="c3">Hình thức thanh toán</h2>
    <div class="c6">
      <label><input type="radio" name="payment" value="cod" checked> Thanh toán khi nhận hàng</label><br>
      <label><input type="radio" name="payment" value="momo"> Thanh toán bằng MoMo</label><br>
      <label><input type="radio" name="payment" value="bank"> Thanh toán qua Ngân hàng</label>
    </div>

    <div id="c24" class="c10" style="text-align: center;">
      <h4>Thông tin chuyển khoản</h4>
      <img src="https://img.vietqr.io/image/970422-123456789-compact2.jpg" width="200" alt="QR thanh toán" style="display: block; margin: 0 auto;">
      <p style="margin-top: 10px;">Chủ tài khoản: CUA HANG DONG HO<br>Ngân hàng: MB Bank<br>SĐT MoMo: 0909xxxxxx</p>
    </div>
  </div>

  <div class="c2" style="text-align: center;">
    <button class="c11" onclick="placeOrder()">Đặt hàng</button>
    <p id="c25" class="c12"></p>
  </div>
</div>

<script>
  const voucherCodes = {
    "GIAM10": 0.1,
    "FREESHIP": 50000,
  };

  function formatCurrency(n) {
    return n.toLocaleString('vi-VN') + '₫';
  }

  function calculateTotal() {
    const subtotals = document.querySelectorAll(".subtotal");
    let productTotal = 0;
    subtotals.forEach(item => {
      productTotal += parseInt(item.dataset.price);
    });
    document.getElementById("c17").innerText = formatCurrency(productTotal);

    const shipping = parseInt(document.querySelector('input[name="shipping"]:checked').value);
    document.getElementById("c18").innerText = formatCurrency(shipping);

    const discount = parseInt(document.getElementById("c19").innerText.replace(/[^0-9]/g, '')) || 0;
    const final = productTotal + shipping - discount;
    document.getElementById("c20").innerText = formatCurrency(final);
  }

  function applyVoucher() {
    const code = document.getElementById("c15").value.trim().toUpperCase();
    let productTotal = parseInt(document.getElementById("c17").innerText.replace(/[^0-9]/g, ''));
    let discount = 0;
    if (voucherCodes[code]) {
      discount = typeof voucherCodes[code] === 'number' && voucherCodes[code] < 1
        ? Math.floor(productTotal * voucherCodes[code])
        : voucherCodes[code];
      document.getElementById("c16").innerText = `Áp dụng mã thành công: -${formatCurrency(discount)}`;
      document.getElementById("c16").style.color = "green";
    } else {
      discount = 0;
      document.getElementById("c16").innerText = "Mã giảm giá không hợp lệ";
      document.getElementById("c16").style.color = "red";
    }
    document.getElementById("c19").innerText = formatCurrency(discount);
    calculateTotal();
  }

  function showVoucherHints() {
    const suggestionBox = document.getElementById("voucher-suggestions");
    suggestionBox.style.display = "block";
    suggestionBox.innerHTML = Object.keys(voucherCodes).map(code => `<li onclick="selectVoucher('${code}')">${code}</li>`).join('');
  }

  function filterVoucherHints() {
    const input = document.getElementById("c15").value.toUpperCase();
    const suggestionBox = document.getElementById("voucher-suggestions");
    suggestionBox.innerHTML = Object.keys(voucherCodes)
      .filter(code => code.includes(input))
      .map(code => `<li onclick="selectVoucher('${code}')">${code}</li>`)
      .join('');
  }

  function selectVoucher(code) {
    document.getElementById("c15").value = code;
    applyVoucher();
    document.getElementById("voucher-suggestions").style.display = "none";
  }

  document.querySelectorAll('input[name="shipping"]').forEach(input => {
    input.addEventListener('change', calculateTotal);
  });

  document.querySelectorAll('input[name="payment"]').forEach(input => {
    input.addEventListener('change', () => {
      const qrBox = document.getElementById("c24");
      qrBox.style.display = (input.value === "momo" || input.value === "bank") ? "block" : "none";
    });
  });

  function placeOrder() {
    const name = document.getElementById("c21").value.trim();
    const phone = document.getElementById("c22").value.trim();
    const address = document.getElementById("c23").value.trim();
    if (!name || !phone || !address) {
      alert("Vui lòng điền đầy đủ thông tin khách hàng!");
      return;
    }
    document.getElementById("c25").innerText = "🎉 Đặt hàng thành công! Cảm ơn bạn đã mua hàng.";
  }

  // Khởi tạo
  calculateTotal();
</script>

<?php include('includes/footer.php'); ?>
