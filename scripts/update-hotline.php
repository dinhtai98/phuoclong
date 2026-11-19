<?php
/**
 * Đổi hotline hiển thị từ "079 8285 114" sang 2 số:
 *   Hotline 0979 187 114 - 0798285 114
 *
 * và đổi link Zalo sang 0979187114.
 *
 * Chạy lại nhiều lần an toàn (idempotent): chỉ thay khi còn chuỗi cũ "079 8285 114"
 * hoặc link "zalo.me/0798285114".
 *
 * 1) Cập nhật nội dung trang trong DB (Trang chủ, Giới thiệu, Liên hệ...) — KHÔNG cần WP-CLI:
 *      cd ~/httpdocs && /opt/plesk/php/8.2/bin/php update-hotline.php
 *    (hoặc nếu WP-CLI chạy được: wp eval-file update-hotline.php)
 *    Sau đó xóa file này khỏi httpdocs và purge cache LiteSpeed.
 *
 * 2) Cập nhật file nguồn (theme / scripts/*.html) — không cần WordPress:
 *      php update-hotline.php file1.html file2.html ...
 */

function pl_hotline_replace( $s ) {
	$new_a = '<a href="tel:0979187114">0979 187 114</a> - <a href="tel:0798285114">0798285 114</a>';

	// Nút "📞 079 8285 114" ở hero trang chủ → tách thành 2 nút, mỗi nút gọi 1 số.
	$s = preg_replace_callback(
		'#(<!-- wp:button [^\n]*-->\s*<div class="wp-block-button[^"]*"[^>]*><a [^>]*)href="tel:0798285114">📞 079 8285 114</a></div>\s*<!-- /wp:button -->#u',
		function ( $m ) {
			$btn = $m[0];
			$b1  = str_replace(
				array( 'href="tel:0798285114">📞 079 8285 114</a>' ),
				array( 'href="tel:0979187114">📞 0979 187 114</a>' ),
				$btn
			);
			$b2  = str_replace( '📞 079 8285 114</a>', '📞 0798285 114</a>', $btn );
			return $b1 . "\n\n" . $b2;
		},
		$s
	);

	$map = array(
		// Header topbar.
		'☎ <a href="tel:0798285114">079 8285 114</a>' => '☎ Hotline ' . $new_a,
		// Trang Liên hệ — danh sách thông tin.
		'<a href="tel:0798285114">079 8285 114</a>'   => $new_a,
		// Trang Liên hệ — dòng "Hoặc gọi ngay ...".
		'<a href="tel:0798285114" style="color:#1E4FA3;font-weight:700">079 8285 114</a>'
			=> '<a href="tel:0979187114" style="color:#1E4FA3;font-weight:700">0979 187 114</a> - <a href="tel:0798285114" style="color:#1E4FA3;font-weight:700">0798285 114</a>',
		// Dải CTA cuối trang chủ.
		'📞 079 8285 114</p>' => '📞 Hotline 0979 187 114 - 0798285 114</p>',
		// Footer.
		'☎ 079 8285 114'      => '☎ Hotline 0979 187 114 - 0798285 114',
		// Mọi chỗ còn lại (bảng Giới thiệu, ...).
		'079 8285 114'        => '0979 187 114 - 0798285 114',
	);
	// Link Zalo (trang Liên hệ) → số 0979 187 114. Chạy trước bảng thay chung
	// để chữ hiển thị trong link Zalo không bị đổi thành "2 số".
	$s = preg_replace(
		'#(href="https://zalo\.me/)0798285114("[^>]*>)(?:079 8285 114|0798285 114)(</a>)#u',
		'${1}0979187114${2}0979 187 114${3}',
		$s
	);
	$s = str_replace( 'zalo.me/0798285114', 'zalo.me/0979187114', $s );

	foreach ( $map as $from => $to ) {
		$s = str_replace( $from, $to, $s );
	}
	return $s;
}

// Chỉ cho chạy từ dòng lệnh — mở qua trình duyệt thì không làm gì.
if ( PHP_SAPI !== 'cli' ) {
	http_response_code( 404 );
	exit;
}

// ---- Chế độ file (không có WordPress): php update-hotline.php <file>... ----
if ( ! defined( 'ABSPATH' ) && $argc >= 2 ) {
	foreach ( array_slice( $argv, 1 ) as $f ) {
		$old = file_get_contents( $f );
		$new = pl_hotline_replace( $old );
		if ( $new !== $old ) {
			file_put_contents( $f, $new );
			echo "Đã sửa: $f\n";
		} else {
			echo "Không đổi: $f\n";
		}
	}
	return;
}

// ---- Chế độ DB ----
// Chạy thẳng bằng PHP (không qua WP-CLI): tự nạp WordPress từ thư mục hiện tại.
if ( ! defined( 'ABSPATH' ) ) {
	$wp_load = getcwd() . '/wp-load.php';
	if ( ! file_exists( $wp_load ) ) {
		$wp_load = __DIR__ . '/wp-load.php';
	}
	if ( ! file_exists( $wp_load ) ) {
		echo "Không thấy wp-load.php. Hãy cd vào httpdocs rồi chạy lại:\n"
			. "  cd ~/httpdocs && /opt/plesk/php/8.2/bin/php update-hotline.php\n";
		exit( 1 );
	}
	$_SERVER['HTTP_HOST']      = $_SERVER['HTTP_HOST'] ?? 'localhost';
	$_SERVER['SERVER_NAME']    = $_SERVER['SERVER_NAME'] ?? $_SERVER['HTTP_HOST'];
	$_SERVER['REQUEST_URI']    = $_SERVER['REQUEST_URI'] ?? '/';
	$_SERVER['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'] ?? 'GET';
	require $wp_load;
}

global $wpdb;
$rows = $wpdb->get_results(
	"SELECT ID, post_type, post_name, post_content FROM {$wpdb->posts}
	 WHERE post_type NOT IN ('revision')
	   AND ( post_content LIKE '%079 8285 114%' OR post_content LIKE '%zalo.me/0798285114%' )"
);

if ( ! $rows ) {
	echo "Không còn gì cần đổi — đã cập nhật trước đó.\n";
	return;
}

foreach ( $rows as $r ) {
	$new = pl_hotline_replace( $r->post_content );
	if ( $new === $r->post_content ) {
		continue;
	}
	// Ghi thẳng DB để kses không cắt style/target của link.
	$wpdb->update( $wpdb->posts, array( 'post_content' => $new ), array( 'ID' => $r->ID ) );
	clean_post_cache( (int) $r->ID );
	echo "Đã cập nhật #{$r->ID} ({$r->post_type}/{$r->post_name})\n";
}

echo "Xong. Xóa file update-hotline.php khỏi httpdocs và purge cache LiteSpeed.\n";
