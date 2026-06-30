<?php
/**
 * Đặt Focus Keyword (Rank Math) cho mọi Trang / Dự án / Sản phẩm / Bài viết
 * còn THIẾU từ khóa trọng tâm. Keyword = tiêu đề bài (đã giải mã &amp; …).
 * Chạy:  wp eval-file scripts/set-rankmath-keywords.php
 * An toàn để chạy lại nhiều lần — bỏ qua mục đã có keyword.
 */
$types = ['page', 'duan', 'sanpham', 'post'];
$posts = get_posts([
    'post_type'   => $types,
    'post_status' => 'publish',
    'numberposts' => -1,
]);

$n = 0;
foreach ($posts as $p) {
    if (get_post_meta($p->ID, 'rank_math_focus_keyword', true)) {
        continue; // đã có → bỏ qua
    }
    $kw = trim(html_entity_decode($p->post_title, ENT_QUOTES, 'UTF-8'));
    if ($kw === '') {
        continue;
    }
    update_post_meta($p->ID, 'rank_math_focus_keyword', $kw);
    echo $p->post_type . ' #' . $p->ID . '  =>  ' . $kw . "\n";
    $n++;
}
echo "==> Đã đặt focus keyword cho {$n} mục.\n";
