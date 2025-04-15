<!-- men.php -->
<?php include('includes/header.php'); ?>  <!-- Kế thừa phần header -->
<?php include('includes/nav.php'); ?>     <!-- Kế thừa phần nav -->

 <style>

  .cart-container {
    max-width: 1000px;
    margin: 2rem auto;
    padding: 2rem;
    background-color: #f9f9f9;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
  }

  .cart-title {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 1.5rem;
    text-align: center;
  }

  .cart-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: white;
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1rem;
    box-shadow: 0 3px 10px rgba(0,0,0,0.07);
  }

  .cart-item img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
  }

  .item-info {
    flex: 1;
    margin-left: 1rem;
  }

  .item-info h4 {
    margin: 0;
    font-size: 1.1rem;
  }

  .quantity-controls {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    margin-top: 0.5rem;
  }

  .qty-btn {
    background-color: #000;
    color: white;
    border: none;
    padding: 0.2rem 0.7rem;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: bold;
    transition: background 0.2s ease;
  }

  .qty-btn:hover {
    background-color: #444;
  }

  .qty-number {
    font-size: 1rem;
    width: 30px;
    text-align: center;
  }

  .item-price {
    font-weight: bold;
    margin-right: 1rem;
    white-space: nowrap;
  }

  .remove-btn {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.2s ease;
  }

  .remove-btn:hover {
    background-color: #c0392b;
  }

  .cart-total {
    text-align: right;
    font-size: 1.3rem;
    font-weight: bold;
    margin-top: 2rem;
    color: #2c3e50;
  }

  .checkout-btn {
    margin-top: 1rem;
    background-color: #000;
    color: white;
    padding: 0.8rem 2rem;
    font-size: 1rem;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    float: right;
    transition: background 0.2s ease;
  }

  .checkout-btn:hover {
    background-color: #333;
  }
</style>

<div class="cart-container">
  <div class="cart-title">Giỏ hàng của bạn</div>

  <!-- Sản phẩm 1 -->
  <div class="cart-item" data-price="2500000">
    <img src="watch1.jpg" alt="Đồng hồ cổ điển">
    <div class="item-info">
      <h4>Đồng hồ Classic 1980</h4>
      <div class="quantity-controls">
        <button class="qty-btn decrease">−</button>
        <span class="qty-number">2</span>
        <button class="qty-btn increase">+</button>
      </div>
    </div>
    <div class="item-price">5.000.000đ</div>
    <button class="remove-btn">Xóa</button>
  </div>

  <!-- Sản phẩm 2 -->
  <div class="cart-item" data-price="3200000">
    <img src="watch2.jpg" alt="Đồng hồ thể thao">
    <div class="item-info">
      <h4>Đồng hồ Thể Thao 2025</h4>
      <div class="quantity-controls">
        <button class="qty-btn decrease">−</button>
        <span class="qty-number">1</span>
        <button class="qty-btn increase">+</button>
      </div>
    </div>
    <div class="item-price">3.200.000đ</div>
    <button class="remove-btn">Xóa</button>
  </div>

  <div class="cart-total">Tổng: <span id="total-price">8.200.000</span>đ</div>
  <a href="/Watch_Store_Manage/pages/thanhtoan.php">
  <button class="checkout-btn">Thanh toán</button>
</a>

</div>

<script>
  function formatCurrency(num) {
    return num.toLocaleString('vi-VN');
  }

  function updateTotal() {
    const items = document.querySelectorAll('.cart-item');
    let total = 0;

    items.forEach(item => {
      const unitPrice = parseInt(item.getAttribute('data-price'));
      const qty = parseInt(item.querySelector('.qty-number').textContent);
      const itemPrice = unitPrice * qty;
      item.querySelector('.item-price').textContent = formatCurrency(itemPrice) + 'đ';
      total += itemPrice;
    });

    document.getElementById('total-price').textContent = formatCurrency(total);
  }

  document.querySelectorAll('.increase').forEach(btn => {
    btn.addEventListener('click', () => {
      const qtyEl = btn.parentElement.querySelector('.qty-number');
      let qty = parseInt(qtyEl.textContent);
      qty++;
      qtyEl.textContent = qty;
      updateTotal();
    });
  });

  document.querySelectorAll('.decrease').forEach(btn => {
    btn.addEventListener('click', () => {
      const qtyEl = btn.parentElement.querySelector('.qty-number');
      let qty = parseInt(qtyEl.textContent);
      if (qty > 1) {
        qty--;
        qtyEl.textContent = qty;
        updateTotal();
      }
    });
  });

  document.querySelectorAll('.remove-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      btn.closest('.cart-item').remove();
      updateTotal();
    });
  });

  // Initial calculation
  updateTotal();
</script>

<script>
  // Lưu thông tin giỏ hàng vào localStorage khi ấn nút "Thanh toán"
  document.querySelector('.checkout-btn').addEventListener('click', () => {
    const cartItems = document.querySelectorAll('.cart-item');
    const cartData = [];

    cartItems.forEach(item => {
      const name = item.querySelector('h4').textContent;
      const qty = parseInt(item.querySelector('.qty-number').textContent);
      const price = parseInt(item.getAttribute('data-price'));
      const img = item.querySelector('img').getAttribute('src');

      cartData.push({ name, qty, price, img });
    });

    const totalPrice = document.getElementById('total-price').textContent;

    localStorage.setItem('cartData', JSON.stringify(cartData));
    localStorage.setItem('cartTotal', totalPrice);
  });
</script>


<?php include('includes/footer.php'); ?> <!-- Kế thừa phần footer -->
