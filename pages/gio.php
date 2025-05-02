<?php 
session_start();

include('includes/header.php');
include('includes/nav.php');

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Xử lý các yêu cầu AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    
    // Xử lý thay đổi số lượng
    if (isset($_POST['id']) && isset($_POST['change'])) {
        $id = $_POST['id'];
        $change = (int)$_POST['change'];
        
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                $item['quantity'] = max(1, $item['quantity'] + $change);
                break;
            }
        }
        
        echo json_encode(['status' => 'success', 'cart' => $_SESSION['cart']]);
        exit;
    }
    
    // Xử lý xóa sản phẩm
    if (isset($_POST['items'])) {
        $itemsToDelete = explode(",", $_POST['items']);
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($itemsToDelete) {
            return !in_array($item['id'], $itemsToDelete);
        });
        
        echo json_encode(['status' => 'success', 'cart' => $_SESSION['cart']]);
        exit;
    }
    
    // Xử lý cập nhật số lượng trực tiếp
    if (isset($_POST['update_item'])) {
        $id = $_POST['id'];
        $quantity = max(1, (int)$_POST['quantity']);
        
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                $item['quantity'] = $quantity;
                break;
            }
        }
        
        echo json_encode(['status' => 'success', 'cart' => $_SESSION['cart']]);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng - <?= htmlspecialchars($storeName) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* CSS đã tối ưu */
        :root {
            --primary-color: #2563eb;
            --danger-color: #dc2626;
            --success-color: #16a34a;
            --gray-color: #6b7280;
            --light-gray: #f3f4f6;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
        }
        
        .cart-container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }
        
        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .cart-title {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
        }
        
        .cart-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 10px 16px;
            border-radius: var(--border-radius);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }
        
        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--gray-color);
            color: var(--gray-color);
        }
        
        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .btn i {
            font-size: 14px;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        
        th {
            background-color: var(--light-gray);
            font-weight: 600;
            color: #334155;
        }
        
        tr:hover {
            background-color: #f8fafc;
        }
        
        .product-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }
        
        .product-name {
            font-weight: 500;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .quantity-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--light-gray);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
        }
        
        .quantity-btn:hover {
            background-color: #e2e8f0;
        }
        
        .quantity-input {
            width: 50px;
            text-align: center;
            padding: 5px;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
        }
        
        .price {
            font-weight: 500;
            color: #1e293b;
        }
        
        .total-price {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .checkout-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
        
        .grand-total {
            font-size: 20px;
            font-weight: 600;
        }
        
        .empty-cart {
            text-align: center;
            padding: 40px 0;
            color: var(--gray-color);
        }
        
        .empty-cart i {
            font-size: 50px;
            margin-bottom: 15px;
            color: #cbd5e1;
        }
        
        .empty-cart p {
            margin-bottom: 20px;
        }
        
        .hidden {
            display: none !important;
        }
        
        .message {
            padding: 12px 15px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeIn 0.3s;
        }
        
        .message-success {
            background-color: #dcfce7;
            color: var(--success-color);
            border: 1px solid #bbf7d0;
        }
        
        .message-error {
            background-color: #fee2e2;
            color: var(--danger-color);
            border: 1px solid #fecaca;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .checkbox-cell {
            width: 40px;
        }
        
        .checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            .cart-container {
                width: 95%;
                padding: 15px;
            }
            
            th, td {
                padding: 8px 10px;
                font-size: 14px;
            }
            
            .product-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            
            .product-img {
                width: 40px;
                height: 40px;
            }
            
            .btn {
                padding: 8px 12px;
                font-size: 14px;
            }
            
            .checkout-summary {
                flex-direction: column;
                gap: 15px;
                align-items: flex-end;
            }
        }
        
        @media (max-width: 576px) {
            .cart-actions {
                flex-direction: column;
                width: 100%;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            table {
                display: block;
            }
            
            thead {
                display: none;
            }
            
            tr {
                display: block;
                margin-bottom: 15px;
                border: 1px solid #e2e8f0;
                border-radius: var(--border-radius);
                padding: 10px;
                position: relative;
            }
            
            td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                border: none;
            }
            
            td::before {
                content: attr(data-label);
                font-weight: 600;
                margin-right: 15px;
                color: #64748b;
            }
            
            .checkbox-cell {
                position: absolute;
                top: 10px;
                right: 10px;
            }
            
            .quantity-control {
                justify-content: flex-end;
            }
        }
    </style>
</head>
<body>

<div class="cart-container">
    <div class="cart-header">
        <h2 class="cart-title"><i class="fas fa-shopping-cart"></i> Giỏ Hàng</h2>
        <div class="cart-actions">
            <button id="editBtn" class="btn btn-outline">
                <i class="fas fa-edit"></i> Sửa
            </button>
            <button id="deleteBtn" class="btn btn-danger hidden">
                <i class="fas fa-trash-alt"></i> Xóa
            </button>
            <button id="finishBtn" class="btn btn-outline hidden">
                <i class="fas fa-check"></i> Xong
            </button>
        </div>
    </div>
    
    <div id="message" class="message hidden"></div>
    
    <div class="table-responsive">
        <table id="cartTable">
            <thead>
                <tr>
                    <th class="checkbox-cell">Chọn</th>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng</th>
                </tr>
            </thead>
            <tbody id="cartItems">
                <?php
                $totalPrice = 0;
                $itemCount = 0;

                if (!empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $item) {
                        $total = $item['price'] * $item['quantity'];
                        $totalPrice += $total;
                        $itemCount++;
                        
                        echo "<tr data-id='" . htmlspecialchars($item['id']) . "'>";
                        echo "<td class='checkbox-cell' data-label='Chọn'><input type='checkbox' class='checkbox deleteCheckbox' data-id='" . htmlspecialchars($item['id']) . "'></td>";
                        echo "<td data-label='Sản phẩm'>
                                <div class='product-info'>
                                    <img src='" . htmlspecialchars($item['img']) . "' alt='" . htmlspecialchars($item['name']) . "' class='product-img'>
                                    <span class='product-name'>" . htmlspecialchars($item['name']) . "</span>
                                </div>
                              </td>";
                        echo "<td data-label='Giá' class='price'>" . number_format($item['price'], 0, ',', '.') . " ₫</td>";
                        echo "<td data-label='Số lượng'>
                                <div class='quantity-control'>
                                    <button class='quantity-btn decrease' data-id='" . htmlspecialchars($item['id']) . "'><i class='fas fa-minus'></i></button>
                                    <input type='number' class='quantity-input' value='" . htmlspecialchars($item['quantity']) . "' min='1' data-id='" . htmlspecialchars($item['id']) . "'>
                                    <button class='quantity-btn increase' data-id='" . htmlspecialchars($item['id']) . "'><i class='fas fa-plus'></i></button>
                                </div>
                              </td>";
                        echo "<td data-label='Tổng' class='total-price'>" . number_format($total, 0, ',', '.') . " ₫</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>
                            <div class='empty-cart'>
                                <i class='fas fa-shopping-cart'></i>
                                <h3>Giỏ hàng của bạn đang trống</h3>
                                <p>Hãy thêm sản phẩm vào giỏ hàng để bắt đầu mua sắm</p>
                                <a href='san-pham.php' class='btn btn-primary'><i class='fas fa-arrow-left'></i> Tiếp tục mua sắm</a>
                            </div>
                          </td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    
    <?php if (!empty($_SESSION['cart'])): ?>
    <div class="checkout-summary">
        <div>
            <span class="grand-total">Tổng cộng: <?= number_format($totalPrice, 0, ',', '.') ?> ₫</span>
            <p class="text-muted">(Đã bao gồm VAT nếu có)</p>
        </div>
        <a href="/Watch_Store_Manage/pages/thanhtoan.php?order=true&items=<?= htmlspecialchars(implode(",", array_column($_SESSION['cart'], 'id'))) ?>" 
           class="btn btn-primary" id="orderBtn">
            <i class="fas fa-credit-card"></i> Thanh toán
        </a>
    </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit mode toggle
    const editBtn = document.getElementById('editBtn');
    const deleteBtn = document.getElementById('deleteBtn');
    const finishBtn = document.getElementById('finishBtn');
    const checkboxes = document.querySelectorAll('.deleteCheckbox');
    const messageEl = document.getElementById('message');
    
    // Toggle edit mode
    editBtn.addEventListener('click', function() {
        deleteBtn.classList.remove('hidden');
        finishBtn.classList.remove('hidden');
        this.classList.add('hidden');
        checkboxes.forEach(cb => cb.style.display = 'block');
    });
    
    finishBtn.addEventListener('click', function() {
        deleteBtn.classList.add('hidden');
        finishBtn.classList.add('hidden');
        editBtn.classList.remove('hidden');
        checkboxes.forEach(cb => cb.checked = false);
    });
    
    // Delete selected items
    deleteBtn.addEventListener('click', function() {
        const checkedItems = Array.from(document.querySelectorAll('.deleteCheckbox:checked'))
                                .map(checkbox => checkbox.dataset.id);
        
        if (checkedItems.length === 0) {
            showMessage('Vui lòng chọn ít nhất một sản phẩm để xóa', 'error');
            return;
        }
        
        fetch('gio.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `items=${checkedItems.join(',')}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Remove deleted items from DOM
                checkedItems.forEach(id => {
                    document.querySelector(`tr[data-id="${id}"]`)?.remove();
                });
                
                // Update UI
                updateCartSummary();
                showMessage('Đã xóa sản phẩm khỏi giỏ hàng', 'success');
                
                // If cart is empty, show empty state
                if (document.querySelectorAll('#cartItems tr').length === 1) {
                    location.reload();
                }
            }
        })
        .catch(error => {
            showMessage('Có lỗi xảy ra khi xóa sản phẩm', 'error');
            console.error('Error:', error);
        });
    });
    
    // Quantity controls
    document.querySelectorAll('.increase').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            updateQuantity(id, 1);
        });
    });
    
    document.querySelectorAll('.decrease').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            updateQuantity(id, -1);
        });
    });
    
    // Direct quantity input
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const id = this.dataset.id;
            const newQuantity = parseInt(this.value);
            
            if (isNaN(newQuantity)) {
                this.value = 1;
                return;
            }
            
            updateQuantity(id, 0, newQuantity);
        });
    });
    
    // Update quantity function
    function updateQuantity(id, change = 0, newQuantity = null) {
        const formData = new URLSearchParams();
        formData.append('id', id);
        
        if (newQuantity !== null) {
            formData.append('quantity', newQuantity);
            formData.append('update_item', 'true');
        } else {
            formData.append('change', change);
        }
        
        fetch('gio.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                updateCartSummary();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
    // Update cart summary (total price)
    function updateCartSummary() {
        let total = 0;
        document.querySelectorAll('#cartItems tr').forEach(row => {
            if (!row.dataset.id) return;
            
            const price = parseInt(row.querySelector('.price').textContent.replace(/[^\d]/g, ''));
            const quantity = parseInt(row.querySelector('.quantity-input').value);
            const rowTotal = price * quantity;
            
            row.querySelector('.total-price').textContent = rowTotal.toLocaleString('vi-VN') + ' ₫';
            total += rowTotal;
        });
        
        if (document.querySelector('.grand-total')) {
            document.querySelector('.grand-total').textContent = 'Tổng cộng: ' + total.toLocaleString('vi-VN') + ' ₫';
        }
    }
    
    // Show message
    function showMessage(text, type = 'success') {
        messageEl.textContent = text;
        messageEl.className = `message message-${type}`;
        messageEl.classList.remove('hidden');
        
        setTimeout(() => {
            messageEl.classList.add('hidden');
        }, 3000);
    }
});
</script>

<?php include('includes/footer.php'); ?>
</body>
</html>