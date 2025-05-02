<?php
// Kết nối database với try-catch để bắt lỗi
try {
    $link = new mysqli("localhost", "root", "", "project-watch");
    $link->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Kết nối database thất bại: " . $e->getMessage());
}

// Hàm lấy dữ liệu từ database
function fetchData($link, $table) {
    $result = $link->query("SELECT * FROM $table");
    return $result ?: [];
}

// Lấy dữ liệu từ các bảng
$sections = [
    'chinhsach' => fetchData($link, 'Chinhsach'),
    'hethongdaili' => fetchData($link, 'Hethongdaili'),
    'thongtin' => fetchData($link, 'Thongtin'),
    'vechungtoi' => fetchData($link, 'Vechungtoi'),
    'thamkhao' => fetchData($link, 'Thamkhao'),
    'social' => fetchData($link, 'social')
];
?>

<footer class="footer">
    <!-- Social links -->
    <div class="social-links">
        <?php foreach ($sections['social'] as $social): ?>
            <a href="<?= htmlspecialchars($social['link']) ?>" 
               class="social-icon <?= strtolower($social['title']) ?>" 
               target="_blank" 
               rel="noopener noreferrer">
                <i class="fab fa-<?= strtolower($social['title']) ?>"></i>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="footer-container">
        <?php 
        $sectionTitles = [
            'chinhsach' => 'CHÍNH SÁCH',
            'hethongdaili' => 'HỆ THỐNG ĐẠI LÝ',
            'thongtin' => 'THÔNG TIN',
            'vechungtoi' => 'VỀ CHÚNG TÔI',
            'thamkhao' => 'THAM KHẢO'
        ];
        
        foreach ($sectionTitles as $key => $title): 
            if (!empty($sections[$key])):
        ?>
            <div class="footer-section">
                <h3><?= $title ?></h3>
                <ul>
                    <?php foreach ($sections[$key] as $item): ?>
                        <li>
                            <a href="<?= htmlspecialchars($item['link']) ?>">
                                <?= htmlspecialchars($item['title']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php 
            endif;
        endforeach; 
        ?>
    </div>

    <div class="footer-bottom">
        <img src="/Watch_Store_Manage/images/footer.png" alt="Logo công ty" loading="lazy">
        <span>Đã thông báo Bộ Công Thương</span>
    </div>
</footer>

<style>
    :root {
        --footer-bg: #f4f4f4;
        --footer-text: #333;
        --footer-hover: #ff5733;
        --footer-bottom-bg: #fff;
        --footer-bottom-text: #777;
        --social-icon-size: 24px;
    }

    .footer {
        background-color: var(--footer-bg);
        padding: 2rem 0;
        font-family: 'Roboto', sans-serif;
        line-height: 1.6;
    }

    .footer-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1.5rem;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .footer-section {
        padding: 0 0.5rem;
    }

    .footer-section h3 {
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 1rem;
        color: var(--footer-text);
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-section li {
        margin-bottom: 0.75rem;
    }

    .footer-section a {
        color: var(--footer-text);
        text-decoration: none;
        transition: color 0.3s ease;
        font-size: 0.9rem;
    }

    .footer-section a:hover {
        color: var(--footer-hover);
        text-decoration: underline;
    }

    .footer-bottom {
        background-color: var(--footer-bottom-bg);
        padding: 1rem;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1.5rem;
    }

    .footer-bottom img {
        max-width: 150px;
        height: auto;
    }

    .footer-bottom span {
        font-size: 0.8rem;
        color: var(--footer-bottom-text);
    }

    .social-links {
        text-align: center;
        margin: 1.5rem 0;
    }

    .social-icon {
        font-size: var(--social-icon-size);
        margin: 0 0.75rem;
        color: var(--footer-text);
        transition: transform 0.3s ease, color 0.3s ease;
        display: inline-block;
    }

    .social-icon:hover {
        transform: translateY(-3px);
    }

    .facebook:hover { color: #3b5998; }
    .instagram:hover { color: #e4405f; }
    .twitter:hover { color: #1da1f2; }
    .tiktok:hover { color: #000; }
    .youtube:hover { color: #ff0000; }

    @media (max-width: 768px) {
        .footer-container {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .footer-section {
            margin-bottom: 1.5rem;
        }
        
        .social-icon {
            margin: 0 0.5rem;
            font-size: calc(var(--social-icon-size) - 4px);
        }
    }

    @media (max-width: 480px) {
        .footer-container {
            grid-template-columns: 1fr;
        }
        
        .footer-section {
            text-align: center;
        }
    }
</style>

<?php $link->close(); ?>