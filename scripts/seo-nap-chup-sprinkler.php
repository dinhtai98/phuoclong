<?php
/**
 * SEO cho từ khóa "chụp bảo vệ đầu phun sprinkler".
 * Chạy: cd httpdocs && wp eval-file seo-nap-chup-sprinkler.php
 * (wp = /opt/plesk/php/8.2/bin/php $(which wp) — xem DEPLOY.md)
 *
 * Làm 4 việc, chạy lại nhiều lần an toàn (idempotent):
 *  1. Viết lại trang sản phẩm /san-pham/nap-chup-bao-ve-dau-phun/ (title + nội dung dài + meta Rank Math + ảnh).
 *  2. Đăng bài blog "Nắp chụp đầu phun Sprinkler: công dụng, phân loại & cách lắp đặt".
 *  3. Chèn link nội bộ từ bài "Hệ thống chữa cháy Sprinkler" sang trang sản phẩm.
 *  4. Thêm link "Xem thêm" từ 2 sản phẩm nắp chụp anh em về trang chính.
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	fwrite( STDERR, "Chạy bằng WP-CLI: wp eval-file seo-nap-chup-sprinkler.php\n" );
	exit( 1 );
}

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$home    = home_url();
$UP      = $home . '/wp-content/uploads/2026/06/';
$svc     = $home . '/dich-vu/';
$contact = $home . '/lien-he/';
$shop    = $home . '/san-pham/';

$url_main      = $shop . 'nap-chup-bao-ve-dau-phun/';
$url_doi       = $shop . 'nap-chup-dau-phun-protector-doi-dn15/';
$url_chen      = $shop . 'nap-chup-dau-phun-chen-hang-vn/';
$url_ty325     = $shop . 'dau-phun-huong-xuong-tyco-dn15-k5-6-68c-ty325/';
$url_ty3551    = $shop . 'dau-phun-nuoc-chua-chay-am-tran-dn15-k5-6-68c-ty3551/';
$url_blog_spr  = $home . '/he-thong-chua-chay-sprinkler/';
$url_blog_nap  = $home . '/nap-chup-dau-phun-sprinkler/';
$img_doi       = $UP . 'nap-chup-au-phun-protector-oi-dn15.jpeg';
$img_chen      = $UP . 'nap-chup-au-phun-chen-hang-vn.jpeg';

/** Gán ảnh đại diện từ Media Library (không tải trùng). */
function pl_set_thumb( $post_id, $img_url, $alt ) {
	if ( has_post_thumbnail( $post_id ) ) {
		return;
	}
	$aid = attachment_url_to_postid( $img_url );
	if ( ! $aid ) {
		$aid = media_sideload_image( $img_url, $post_id, $alt, 'id' );
	}
	if ( ! is_wp_error( $aid ) && $aid ) {
		set_post_thumbnail( $post_id, $aid );
		update_post_meta( $aid, '_wp_attachment_image_alt', $alt );
	}
}

/* ------------------------------------------------------------------ */
/* 1. TRANG SẢN PHẨM CHÍNH                                             */
/* ------------------------------------------------------------------ */

$kw_main = 'chụp bảo vệ đầu phun sprinkler';

$content_main = '
<p><strong>Nắp chụp bảo vệ đầu phun sprinkler</strong> (chụp che đầu phun, escutcheon) là phụ kiện lắp quanh vị trí đầu phun chữa cháy: che kín lỗ khoét trần cho thẩm mỹ, đồng thời bảo vệ đầu phun khỏi va đập, bụi bẩn trong thi công và vận hành. PCCC Phước Long sẵn kho nắp chụp <strong>đơn, đôi (kép), chén</strong> cho đầu phun DN15, DN20 — giá tốt cho nhà thầu, giao nhanh toàn quốc.</p>

<h2>Công dụng của chụp bảo vệ đầu phun sprinkler</h2>
<ul>
<li><strong>Bảo vệ đầu phun</strong> khỏi va chạm cơ học, bụi bẩn, sơn bám khi hoàn thiện công trình — nguyên nhân phổ biến khiến đầu phun kích hoạt sai hoặc bị bít không phun được.</li>
<li><strong>Che lỗ khoét trần</strong> quanh chân đầu phun, giấu khe hở giữa trần thạch cao và đường ống cấp nước.</li>
<li><strong>Tăng thẩm mỹ</strong> cho trần văn phòng, khách sạn, showroom khi lắp đầu phun hướng xuống hoặc âm trần.</li>
</ul>

<h2>Các loại nắp chụp đầu phun sprinkler</h2>
<h3>Nắp chụp đơn</h3>
<p>Vòng tròn một lớp có lỗ giữa cho thân đầu phun xuyên qua, ốp sát trần che vết khoét. Loại thông dụng và kinh tế nhất, dùng cho đầu phun hướng xuống lắp trần thạch cao, trần thả.</p>
<h3>Nắp chụp đôi (kép)</h3>
<p>Gồm hai lớp lồng nhau, ôm khít thân đầu phun và trượt bù được sai lệch cốt trần — đường ống lệch vài milimet vẫn ốp kín, đẹp. Tham khảo <a href="' . $url_doi . '">nắp chụp đầu phun Protector loại đôi DN15</a>.</p>
<h3>Nắp chụp chén (escutcheon)</h3>
<p>Dạng chén sâu che phần thân đầu phun lắp thụt vào trong trần (recessed). Xem <a href="' . $url_chen . '">nắp chụp đầu phun loại chén — hàng Việt Nam</a>.</p>
<h3>Lồng bảo vệ đầu phun (sprinkler guard)</h3>
<p>Khung thép bao quanh đầu phun tại kho hàng, tầng hầm, nhà xưởng — nơi xe nâng, hàng hóa dễ va vào đầu phun hở. Liên hệ để đặt theo số lượng công trình.</p>

<h2>Thông số kỹ thuật</h2>
<ul>
<li>Loại: đơn / đôi (kép) / chén (escutcheon)</li>
<li>Dùng cho đầu phun: DN15 (1/2 inch), DN20 (3/4 inch)</li>
<li>Chất liệu: inox / thép mạ crôm sáng bóng, không gỉ sét</li>
<li>Màu: trắng bạc; nhận đặt màu sơn tĩnh điện theo màu trần</li>
<li>Xuất xứ: Việt Nam</li>
<li>Đơn vị tính: cái / bộ</li>
</ul>

<h2>Khi nào cần lắp chụp bảo vệ đầu phun?</h2>
<p>Mọi công trình lắp <a href="' . $url_blog_spr . '">hệ thống chữa cháy sprinkler</a> có trần hoàn thiện đều nên dùng nắp chụp cho đầu phun hướng xuống như <a href="' . $url_ty325 . '">Tyco TY325</a>; đầu phun âm trần như <a href="' . $url_ty3551 . '">Tyco TY3551</a> đã kèm nắp che riêng của hãng. Khu vực kho, tầng hầm có nguy cơ va chạm thì bổ sung lồng thép bảo vệ. Xem thêm bài <a href="' . $url_blog_nap . '">nắp chụp đầu phun sprinkler: công dụng, phân loại &amp; cách lắp</a>.</p>

<h2>Mua chụp bảo vệ đầu phun sprinkler giá tốt tại PCCC Phước Long</h2>
<p>Chúng tôi cung cấp nắp chụp cùng đầu phun Tyco, Protector chính hãng — đồng bộ vật tư, chiết khấu số lượng lớn cho nhà thầu, kèm dịch vụ <a href="' . $svc . '">thi công hệ thống PCCC</a> trọn gói. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để nhận báo giá trong ngày.</p>
';

$prod = get_page_by_path( 'nap-chup-bao-ve-dau-phun', OBJECT, 'sanpham' );
if ( $prod ) {
	$r = wp_update_post( array(
		'ID'           => $prod->ID,
		'post_title'   => 'Nắp chụp bảo vệ đầu phun Sprinkler (đơn, đôi, chén)',
		'post_name'    => 'nap-chup-bao-ve-dau-phun', // giữ nguyên slug
		'post_content' => trim( $content_main ),
	), true );
	if ( is_wp_error( $r ) ) {
		WP_CLI::warning( 'Lỗi cập nhật sản phẩm: ' . $r->get_error_message() );
	} else {
		update_post_meta( $prod->ID, 'rank_math_focus_keyword', $kw_main . ',nắp chụp đầu phun sprinkler,nắp chụp bảo vệ đầu phun' );
		update_post_meta( $prod->ID, 'rank_math_title', 'Nắp chụp bảo vệ đầu phun Sprinkler (đơn, đôi, chén) – Giá tốt | PCCC Phước Long' );
		update_post_meta( $prod->ID, 'rank_math_description', 'Chụp bảo vệ đầu phun sprinkler: nắp chụp đơn, đôi, chén inox cho đầu phun DN15, DN20. Che lỗ trần, chống va đập, giá tốt cho nhà thầu: 0798 285 114.' );
		pl_set_thumb( $prod->ID, $img_doi, $kw_main );
		WP_CLI::log( "✓ Cập nhật trang sản phẩm (ID {$prod->ID})" );
	}
} else {
	WP_CLI::warning( 'Không tìm thấy sản phẩm slug nap-chup-bao-ve-dau-phun' );
}

/* ------------------------------------------------------------------ */
/* 2. BÀI BLOG HỖ TRỢ                                                  */
/* ------------------------------------------------------------------ */

$kw_blog  = 'nắp chụp đầu phun sprinkler';
$seo_desc = 'Nắp chụp đầu phun sprinkler là gì, có mấy loại (đơn, đôi, chén), khi nào cần lồng bảo vệ và cách lắp đúng? Sẵn hàng giá tốt: 0798 285 114.';

$content_blog = '
<p><strong>Nắp chụp đầu phun sprinkler</strong> là phụ kiện nhỏ nhưng gần như bắt buộc ở mọi công trình có trần hoàn thiện: vừa che lỗ khoét trần quanh đầu phun chữa cháy, vừa bảo vệ đầu phun khỏi bụi bẩn, va đập. Bài viết giúp bạn phân biệt các loại nắp chụp và chọn đúng cho công trình.</p>

<h2>Nắp chụp đầu phun sprinkler là gì, vì sao cần?</h2>
<p>Khi thi công <a href="' . $url_blog_spr . '">hệ thống chữa cháy sprinkler</a>, đầu phun được lắp xuyên qua trần thạch cao, để lại lỗ khoét và khe hở quanh thân đầu phun. Nắp chụp (escutcheon) ốp kín vị trí này. Ngoài thẩm mỹ, nắp chụp còn giúp:</p>
<ul>
<li>Chắn bụi bẩn, sơn nước bám vào bầu thủy tinh và miệng phun trong giai đoạn hoàn thiện — bụi sơn bít miệng phun có thể làm đầu phun mất tác dụng khi có cháy.</li>
<li>Giảm va chạm nhẹ vào thân đầu phun khi vệ sinh, sửa chữa trần.</li>
<li>Giữ đúng lỗ mở tiêu chuẩn quanh đầu phun để tia nước tỏa đều theo thiết kế.</li>
</ul>
<p><em>Lưu ý:</em> nắp bảo vệ nhựa mà nhà sản xuất bọc sẵn trên đầu phun chỉ dùng khi vận chuyển, lắp đặt — phải tháo ra trước khi bàn giao hệ thống, không thay được nắp chụp trang trí.</p>

<h2>Các loại nắp chụp đầu phun sprinkler</h2>
<ul>
<li><strong>Nắp chụp đơn:</strong> vòng một lớp ốp sát trần, kinh tế nhất, dùng cho trần phẳng đúng cốt.</li>
<li><strong>Nắp chụp đôi (kép):</strong> hai lớp lồng nhau, trượt bù được sai lệch cốt trần nên luôn ốp kín — phổ biến nhất với trần thạch cao. Tham khảo <a href="' . $url_doi . '">nắp chụp Protector loại đôi DN15</a>.</li>
<li><strong>Nắp chụp chén:</strong> chén sâu che thân đầu phun lắp thụt vào trần (recessed), xem <a href="' . $url_chen . '">nắp chụp chén hàng Việt Nam</a>.</li>
<li><strong>Lồng bảo vệ (sprinkler guard):</strong> khung thép bao quanh đầu phun hở tại kho, tầng hầm, nhà xưởng — chống va đập do xe nâng, hàng hóa.</li>
</ul>
<p>Chọn theo cỡ ren đầu phun: DN15 (1/2 inch) cho đầu phun K5.6 thông dụng, DN20 (3/4 inch) cho đầu phun lưu lượng lớn. Xem đầy đủ tại trang <a href="' . $url_main . '">nắp chụp bảo vệ đầu phun sprinkler</a>.</p>

<h2>Cách lắp nắp chụp đúng kỹ thuật</h2>
<ol>
<li>Lắp đầu phun vào cút ren, thử kín nước xong mới đóng trần.</li>
<li>Khoét lỗ trần vừa đủ theo hướng dẫn của loại nắp chụp (thường lớn hơn thân đầu phun 5–10 mm).</li>
<li>Luồn nắp chụp qua thân đầu phun, đẩy ốp sát mặt trần; loại đôi thì chỉnh lớp trượt cho khít.</li>
<li>Không sơn đè lên đầu phun và bầu thủy tinh; chỉ sơn nắp chụp khi tháo rời.</li>
</ol>

<h2>Mua nắp chụp đầu phun sprinkler ở đâu?</h2>
<p>PCCC Phước Long sẵn kho <a href="' . $url_main . '">nắp chụp đơn, đôi, chén</a> cùng <a href="' . $shop . '">đầu phun sprinkler Tyco, Protector</a> chính hãng — mua đồng bộ đỡ lệch cỡ ren, chiết khấu tốt cho nhà thầu. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để được báo giá nhanh.</p>
';

$term   = term_exists( 'Kiến thức PCCC', 'category' );
if ( ! $term ) {
	$term = wp_insert_term( 'Kiến thức PCCC', 'category' );
}
$cat_id = ( ! is_wp_error( $term ) ) ? ( is_array( $term ) ? (int) $term['term_id'] : (int) $term ) : 0;

$blog_body = '<!-- wp:image --><figure class="wp-block-image size-large"><img src="'
	. esc_url( $img_chen ) . '" alt="' . esc_attr( $kw_blog ) . '"/></figure><!-- /wp:image -->'
	. "\n\n" . trim( $content_blog );

$existing = get_page_by_path( 'nap-chup-dau-phun-sprinkler', OBJECT, 'post' );
$postarr  = array(
	'post_type'    => 'post',
	'post_status'  => 'publish',
	'post_name'    => 'nap-chup-dau-phun-sprinkler',
	'post_title'   => 'Nắp chụp đầu phun Sprinkler: công dụng, phân loại & cách lắp',
	'post_excerpt' => $seo_desc,
	'post_content' => $blog_body,
);
if ( $existing ) {
	$postarr['ID'] = $existing->ID;
	$blog_id       = wp_update_post( $postarr, true );
} else {
	$blog_id = wp_insert_post( $postarr, true );
}
if ( is_wp_error( $blog_id ) ) {
	WP_CLI::warning( 'Lỗi đăng blog: ' . $blog_id->get_error_message() );
} else {
	if ( $cat_id ) {
		wp_set_post_categories( $blog_id, array( $cat_id ) );
	}
	pl_set_thumb( $blog_id, $img_chen, $kw_blog );
	update_post_meta( $blog_id, 'rank_math_focus_keyword', $kw_blog . ',chụp bảo vệ đầu phun sprinkler' );
	update_post_meta( $blog_id, 'rank_math_title', 'Nắp chụp đầu phun Sprinkler: công dụng, phân loại & cách lắp | PCCC Phước Long' );
	update_post_meta( $blog_id, 'rank_math_description', $seo_desc );
	WP_CLI::log( "✓ Bài blog nắp chụp (ID $blog_id)" );
}

/* ------------------------------------------------------------------ */
/* 3. LINK NỘI BỘ TỪ BÀI SPRINKLER HIỆN CÓ                             */
/* ------------------------------------------------------------------ */

$spr = get_page_by_path( 'he-thong-chua-chay-sprinkler', OBJECT, 'post' );
if ( $spr && false === strpos( $spr->post_content, $url_main ) ) {
	$needle = 'văn phòng, khách sạn cần thẩm mỹ.';
	if ( false !== strpos( $spr->post_content, $needle ) ) {
		$new = str_replace(
			$needle,
			'văn phòng, khách sạn cần thẩm mỹ — hoàn thiện bằng <a href="' . $url_main . '">nắp chụp bảo vệ đầu phun sprinkler</a>.',
			$spr->post_content
		);
		wp_update_post( array( 'ID' => $spr->ID, 'post_content' => $new ) );
		WP_CLI::log( "✓ Chèn link nội bộ vào bài Sprinkler (ID {$spr->ID})" );
	} else {
		WP_CLI::warning( 'Không tìm thấy vị trí chèn link trong bài Sprinkler — bỏ qua.' );
	}
} elseif ( $spr ) {
	WP_CLI::log( '• Bài Sprinkler đã có link — bỏ qua.' );
}

/* ------------------------------------------------------------------ */
/* 4. LINK "XEM THÊM" TỪ 2 SẢN PHẨM NẮP CHỤP ANH EM                    */
/* ------------------------------------------------------------------ */

$see_more = "\n" . '<p>Xem thêm các loại: <a href="' . $url_main . '">nắp chụp bảo vệ đầu phun sprinkler (đơn, đôi, chén)</a>.</p>';
foreach ( array( 'nap-chup-dau-phun-protector-doi-dn15', 'nap-chup-dau-phun-chen-hang-vn' ) as $slug ) {
	$p = get_page_by_path( $slug, OBJECT, 'sanpham' );
	if ( ! $p ) {
		WP_CLI::warning( "Không tìm thấy sản phẩm $slug" );
		continue;
	}
	if ( false !== strpos( $p->post_content, $url_main ) ) {
		WP_CLI::log( "• $slug đã có link — bỏ qua." );
		continue;
	}
	wp_update_post( array( 'ID' => $p->ID, 'post_content' => $p->post_content . $see_more ) );
	WP_CLI::log( "✓ Thêm link Xem thêm vào $slug (ID {$p->ID})" );
}

WP_CLI::success( 'Xong. Nhớ purge cache (LiteSpeed) và Request Indexing 2 URL trong Google Search Console.' );
