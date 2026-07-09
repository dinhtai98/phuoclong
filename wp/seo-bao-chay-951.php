<?php
/**
 * SEO cho 4 từ khóa: "hệ thống báo cháy thường", "hệ thống báo cháy địa chỉ",
 * "fsp-951", "fst951 / fst-951".
 * Chạy: cd httpdocs && wp eval-file seo-bao-chay-951.php
 * (wp = /opt/plesk/php/8.2/bin/php $(which wp) — xem DEPLOY.md)
 *
 * Làm 5 việc, chạy lại nhiều lần an toàn (idempotent):
 *  1. Viết lại trang sản phẩm FSP-951 (title chứa đúng mã "FSP-951" + nội dung dài + meta).
 *  2. Viết lại trang sản phẩm FST-951 (kèm biến thể "FST951" trong bài).
 *  3. Đăng bài pillar "Hệ thống báo cháy thường".
 *  4. Đăng bài pillar "Hệ thống báo cháy địa chỉ".
 *  5. Bài so sánh cũ: đổi focus keyword sang cụm so sánh (tránh giẫm từ khóa
 *     với 2 bài pillar mới) + chèn link sang 2 bài pillar.
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	fwrite( STDERR, "Chạy bằng WP-CLI: wp eval-file seo-bao-chay-951.php\n" );
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

$url_fsp      = $shop . 'dau-bao-chay-khoi-loai-dia-chi-de-fsp-951/';
$url_fst      = $shop . 'dau-bao-nhiet-loai-dia-chi-de-fst-951/';
$url_hcv      = $shop . 'trung-tam-bao-chay-2-4-8-kenh-hcv/';
$url_yunyang  = $shop . 'trung-tam-bao-chay-yunyang/';
$url_2wb      = $shop . 'dau-bao-khoi-thuong-de-2w-b/';
$url_ydd      = $shop . 'dau-bao-nhiet-thuong-de-ydd-s02a/';
$url_module   = $shop . 'module-giam-sat-cho-dau-bao-thuong-model-dcp-czm/';
$cat_notifier = $home . '/danh-muc-san-pham/thiet-bi-bao-chay-notifier/';
$url_ss       = $home . '/he-thong-bao-chay-dia-chi-va-thuong/';
$url_thuong   = $home . '/he-thong-bao-chay-thuong/';
$url_dia_chi  = $home . '/he-thong-bao-chay-dia-chi/';
$img_fsp      = $UP . 'fsp-951.png';
$img_fst      = $UP . 'fst-951.png';
$img_hcv      = $UP . 'hcv-2-4-8.webp';

/** Gán ảnh đại diện từ Media Library (không tải trùng). */
function pl3_set_thumb( $post_id, $img_url, $alt ) {
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

/** Đăng/cập nhật 1 bài blog theo slug. */
function pl3_publish_post( $slug, $title, $desc, $body, $img, $alt, $kw, $cat_id ) {
	$body     = '<!-- wp:image --><figure class="wp-block-image size-large"><img src="'
		. esc_url( $img ) . '" alt="' . esc_attr( $alt ) . '"/></figure><!-- /wp:image -->'
		. "\n\n" . trim( $body );
	$existing = get_page_by_path( $slug, OBJECT, 'post' );
	$postarr  = array(
		'post_type'    => 'post',
		'post_status'  => 'publish',
		'post_name'    => $slug,
		'post_title'   => $title,
		'post_excerpt' => $desc,
		'post_content' => $body,
	);
	if ( $existing ) {
		$postarr['ID'] = $existing->ID;
		$id            = wp_update_post( $postarr, true );
	} else {
		$id = wp_insert_post( $postarr, true );
	}
	if ( is_wp_error( $id ) ) {
		WP_CLI::warning( "Lỗi đăng $slug: " . $id->get_error_message() );
		return 0;
	}
	if ( $cat_id ) {
		wp_set_post_categories( $id, array( $cat_id ) );
	}
	pl3_set_thumb( $id, $img, $alt );
	update_post_meta( $id, 'rank_math_focus_keyword', $kw );
	update_post_meta( $id, 'rank_math_title', $title . ' | PCCC Phước Long' );
	update_post_meta( $id, 'rank_math_description', $desc );
	WP_CLI::log( "✓ $title (ID $id)" );
	return $id;
}

$term   = term_exists( 'Kiến thức PCCC', 'category' );
if ( ! $term ) {
	$term = wp_insert_term( 'Kiến thức PCCC', 'category' );
}
$cat_id = ( ! is_wp_error( $term ) ) ? ( is_array( $term ) ? (int) $term['term_id'] : (int) $term ) : 0;

$footer_sp = '<!-- wp:paragraph --><p>Xem thêm sản phẩm cùng nhóm: <a href="' . $cat_notifier . '">THIẾT BỊ BÁO CHÁY NOTIFIER</a> · <a href="' . $contact . '">Liên hệ tư vấn &amp; báo giá</a></p><!-- /wp:paragraph -->';

/* ------------------------------------------------------------------ */
/* 1. SẢN PHẨM FSP-951                                                 */
/* ------------------------------------------------------------------ */

$content_fsp = '<!-- wp:image --><figure class="wp-block-image size-large"><img src="' . esc_url( $img_fsp ) . '" alt="đầu báo khói địa chỉ Notifier FSP-951"/></figure><!-- /wp:image -->

<p><strong>FSP-951</strong> (còn viết FSP 951) là đầu báo khói quang địa chỉ dòng 951 của Notifier (tập đoàn Honeywell) — dòng đầu báo thông dụng nhất cho <a href="' . $url_dia_chi . '">hệ thống báo cháy địa chỉ</a> tại các cao ốc, khách sạn, trung tâm thương mại. Mỗi đầu báo mang một địa chỉ riêng trên loop, giúp tủ trung tâm hiển thị chính xác vị trí điểm cháy thay vì chỉ báo theo khu vực.</p>

<h3>Điểm mạnh của đầu báo khói FSP-951</h3>
<ul>
<li><strong>Định vị chính xác từng điểm:</strong> tủ trung tâm đọc đúng địa chỉ đầu báo kích hoạt — rút ngắn thời gian xác minh và xử lý cháy.</li>
<li><strong>Cảm biến quang thông minh</strong> với chức năng bù trôi (drift compensation): tự bù độ nhiễm bụi của buồng quang theo thời gian, giảm báo giả và cảnh báo khi cần vệ sinh/bảo dưỡng.</li>
<li><strong>Đặt địa chỉ bằng núm xoay</strong> ngay trên thân đầu báo, thi công và thay thế nhanh, không cần thiết bị lập trình riêng.</li>
<li>Đèn LED báo trạng thái nhìn được 360°, kèm đế lắp chuẩn của hãng.</li>
</ul>

<h3>Thông số kỹ thuật</h3>
<ul>
<li>Model: FSP-951 — đầu báo khói quang địa chỉ (addressable photoelectric)</li>
<li>Hãng: Notifier by Honeywell — xuất xứ Thái Lan</li>
<li>Cấp nguồn trực tiếp từ loop tín hiệu của tủ trung tâm Notifier</li>
<li>Kèm đế địa chỉ; tương thích các tủ báo cháy địa chỉ Notifier</li>
<li>Đầu báo cùng dòng: <a href="' . $url_fst . '">đầu báo nhiệt địa chỉ FST-951</a> cho khu vực nhiều khói bụi, hơi nước</li>
<li><em>(Dải điện áp loop, dòng tiêu thụ chi tiết: đối chiếu datasheet theo lô hàng)</em></li>
</ul>

<h3>Ứng dụng</h3>
<p>Văn phòng, hành lang, sảnh, phòng khách sạn, trung tâm thương mại, bệnh viện — mọi khu vực cần phát hiện khói sớm và định vị chính xác. Công trình nhỏ dùng <a href="' . $url_thuong . '">hệ báo cháy thường</a> có thể chọn <a href="' . $url_2wb . '">đầu báo khói thường 2W-B</a> để tiết kiệm chi phí.</p>

' . $footer_sp;

$fsp = get_page_by_path( 'dau-bao-chay-khoi-loai-dia-chi-de-fsp-951', OBJECT, 'sanpham' );
if ( $fsp ) {
	$r = wp_update_post( array(
		'ID'           => $fsp->ID,
		'post_title'   => 'Đầu báo khói địa chỉ Notifier FSP-951 kèm đế',
		'post_name'    => $fsp->post_name, // giữ slug cũ
		'post_content' => $content_fsp,
	), true );
	if ( is_wp_error( $r ) ) {
		WP_CLI::warning( 'Lỗi FSP-951: ' . $r->get_error_message() );
	} else {
		update_post_meta( $fsp->ID, 'rank_math_focus_keyword', 'fsp-951,fsp 951,đầu báo khói fsp-951' );
		update_post_meta( $fsp->ID, 'rank_math_title', 'Đầu báo khói địa chỉ Notifier FSP-951 kèm đế – Giá tốt | PCCC Phước Long' );
		update_post_meta( $fsp->ID, 'rank_math_description', 'FSP-951: đầu báo khói quang địa chỉ Notifier (Honeywell) kèm đế, bù trôi giảm báo giả, đặt địa chỉ núm xoay. Hàng chính hãng, giá tốt: 0798 285 114.' );
		pl3_set_thumb( $fsp->ID, $img_fsp, 'đầu báo khói địa chỉ Notifier FSP-951' );
		WP_CLI::log( "✓ Cập nhật sản phẩm FSP-951 (ID {$fsp->ID})" );
	}
} else {
	WP_CLI::warning( 'Không tìm thấy sản phẩm FSP-951' );
}

/* ------------------------------------------------------------------ */
/* 2. SẢN PHẨM FST-951                                                 */
/* ------------------------------------------------------------------ */

$content_fst = '<!-- wp:image --><figure class="wp-block-image size-large"><img src="' . esc_url( $img_fst ) . '" alt="đầu báo nhiệt địa chỉ Notifier FST-951"/></figure><!-- /wp:image -->

<p><strong>FST-951</strong> (hay viết <strong>FST951</strong>, FST 951) là đầu báo nhiệt địa chỉ dòng 951 của Notifier (Honeywell), dùng cho những khu vực mà đầu báo khói dễ báo giả — bếp, garage, phòng máy phát, kho có bụi hoặc hơi nước. Mỗi đầu mang một địa chỉ riêng trên loop, tủ trung tâm xác định chính xác vị trí điểm quá nhiệt.</p>

<h3>Điểm mạnh của đầu báo nhiệt FST-951</h3>
<ul>
<li><strong>Cảm biến nhiệt điện tử</strong> (thermistor) phản ứng nhanh, chính xác hơn kiểu cơ khí truyền thống.</li>
<li><strong>Địa chỉ hóa từng điểm:</strong> báo đúng vị trí trên màn hình tủ trung tâm, phối hợp cùng <a href="' . $url_fsp . '">đầu báo khói FSP-951</a> trong cùng một loop.</li>
<li><strong>Đặt địa chỉ bằng núm xoay</strong> trên thân, thi công thay thế nhanh.</li>
<li>Đèn LED trạng thái 360°, kèm đế lắp chuẩn của hãng.</li>
</ul>

<h3>Thông số kỹ thuật</h3>
<ul>
<li>Model: FST-951 — đầu báo nhiệt địa chỉ (addressable heat detector)</li>
<li>Hãng: Notifier by Honeywell — xuất xứ Thái Lan</li>
<li>Ngưỡng kích hoạt nhiệt cố định theo tiêu chuẩn hãng (dòng 951 có thêm phiên bản gia tăng theo tốc độ tăng nhiệt)</li>
<li>Cấp nguồn trực tiếp từ loop tín hiệu; kèm đế địa chỉ, tương thích tủ báo cháy địa chỉ Notifier</li>
<li><em>(Ngưỡng nhiệt, dải điện áp chi tiết: đối chiếu datasheet theo lô hàng)</em></li>
</ul>

<h3>Ứng dụng</h3>
<p>Bếp nhà hàng, khu giặt là, garage, phòng kỹ thuật, kho — nơi nhiều khói bụi, hơi nước khiến đầu báo khói không phù hợp. Lắp trong <a href="' . $url_dia_chi . '">hệ thống báo cháy địa chỉ</a> cho cao ốc, khách sạn; công trình nhỏ dùng hệ thường có thể chọn <a href="' . $url_ydd . '">đầu báo nhiệt thường YDD-S02A</a>.</p>

' . $footer_sp;

$fst = get_page_by_path( 'dau-bao-nhiet-loai-dia-chi-de-fst-951', OBJECT, 'sanpham' );
if ( $fst ) {
	$r = wp_update_post( array(
		'ID'           => $fst->ID,
		'post_title'   => 'Đầu báo nhiệt địa chỉ Notifier FST-951 kèm đế',
		'post_name'    => $fst->post_name,
		'post_content' => $content_fst,
	), true );
	if ( is_wp_error( $r ) ) {
		WP_CLI::warning( 'Lỗi FST-951: ' . $r->get_error_message() );
	} else {
		update_post_meta( $fst->ID, 'rank_math_focus_keyword', 'fst951,fst-951,đầu báo nhiệt fst-951' );
		update_post_meta( $fst->ID, 'rank_math_title', 'Đầu báo nhiệt địa chỉ Notifier FST-951 (FST951) kèm đế | PCCC Phước Long' );
		update_post_meta( $fst->ID, 'rank_math_description', 'FST-951 (FST951): đầu báo nhiệt địa chỉ Notifier (Honeywell) kèm đế, cảm biến thermistor, cho bếp, garage, kho nhiều bụi. Chính hãng, giá tốt: 0798 285 114.' );
		pl3_set_thumb( $fst->ID, $img_fst, 'đầu báo nhiệt địa chỉ Notifier FST-951' );
		WP_CLI::log( "✓ Cập nhật sản phẩm FST-951 (ID {$fst->ID})" );
	}
} else {
	WP_CLI::warning( 'Không tìm thấy sản phẩm FST-951' );
}

/* ------------------------------------------------------------------ */
/* 3. BÀI PILLAR "HỆ THỐNG BÁO CHÁY THƯỜNG"                            */
/* ------------------------------------------------------------------ */

$desc_thuong = 'Hệ thống báo cháy thường (quy ước) là gì, cấu tạo, nguyên lý theo zone và phù hợp công trình nào? Tư vấn lắp đặt trọn gói: 0798 285 114.';
$body_thuong = '
<p><strong>Hệ thống báo cháy thường</strong> (báo cháy quy ước — conventional) là giải pháp báo cháy kinh tế nhất cho công trình vừa và nhỏ: nhà xưởng, văn phòng vài tầng, cửa hàng, nhà trọ. Bài viết giải thích cấu tạo, nguyên lý và cách chọn thiết bị.</p>

<h2>Hệ thống báo cháy thường là gì?</h2>
<p>Là hệ báo cháy chia công trình thành các <strong>khu vực (zone)</strong>, mỗi zone gom một nhóm đầu báo về một kênh của tủ trung tâm. Khi có cháy, tủ chỉ báo <em>zone nào</em> đang cháy chứ không chỉ ra chính xác đầu báo nào kích hoạt — người trực phải đến khu vực đó xác minh.</p>

<h2>Cấu tạo hệ thống báo cháy thường</h2>
<ul>
<li><strong>Tủ trung tâm theo kênh:</strong> 2 – 4 – 8 – 16 kênh tùy quy mô, như <a href="' . $url_hcv . '">trung tâm báo cháy Hochiki HCV 2-4-8 kênh</a> hoặc <a href="' . $url_yunyang . '">trung tâm báo cháy Yunyang</a>.</li>
<li><strong>Đầu báo cháy thường:</strong> <a href="' . $url_2wb . '">đầu báo khói 2W-B</a> cho khu vực chung; <a href="' . $url_ydd . '">đầu báo nhiệt YDD-S02A</a> cho bếp, garage, kho bụi.</li>
<li><strong>Nút nhấn khẩn, chuông – còi – đèn báo cháy</strong> bố trí tại hành lang, lối thoát nạn.</li>
<li>Nguồn dự phòng ắc quy duy trì hệ hoạt động khi mất điện.</li>
</ul>

<h2>Ưu và nhược điểm</h2>
<ul>
<li><strong>Ưu:</strong> chi phí thiết bị thấp, thi công đơn giản, dễ vận hành, thay thế đầu báo rẻ.</li>
<li><strong>Nhược:</strong> chỉ báo theo khu vực nên công trình lớn tìm điểm cháy chậm; mỗi zone chạy dây riêng về tủ nên nhiều tầng, nhiều khu vực sẽ tốn dây và khó mở rộng.</li>
</ul>

<h2>Công trình nào nên dùng báo cháy thường?</h2>
<p>Nhà xưởng nhỏ, văn phòng dưới ~5 tầng, cửa hàng, quán ăn, nhà trọ, karaoke mini — nơi số zone ít, người trực có thể xác minh nhanh. Công trình lớn, nhiều tầng, yêu cầu định vị chính xác từng điểm thì nên dùng <a href="' . $url_dia_chi . '">hệ thống báo cháy địa chỉ</a> — xem thêm bài <a href="' . $url_ss . '">so sánh báo cháy địa chỉ và báo cháy thường</a>.</p>

<h2>Lắp đặt hệ thống báo cháy thường trọn gói</h2>
<p>PCCC Phước Long <a href="' . $svc . '">khảo sát, thiết kế và thi công</a> hệ báo cháy thường đạt nghiệm thu, cung cấp thiết bị Hochiki, Yunyang chính hãng. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để nhận báo giá trong 24h.</p>
';

pl3_publish_post(
	'he-thong-bao-chay-thuong',
	'Hệ thống báo cháy thường: cấu tạo, nguyên lý & khi nào dùng',
	$desc_thuong,
	$body_thuong,
	$img_hcv,
	'hệ thống báo cháy thường',
	'hệ thống báo cháy thường,báo cháy quy ước',
	$cat_id
);

/* ------------------------------------------------------------------ */
/* 4. BÀI PILLAR "HỆ THỐNG BÁO CHÁY ĐỊA CHỈ"                           */
/* ------------------------------------------------------------------ */

$desc_dc = 'Hệ thống báo cháy địa chỉ là gì, cấu tạo, ưu điểm so với báo cháy thường và dùng thiết bị nào (Notifier FSP-951, FST-951)? Tư vấn: 0798 285 114.';
$body_dc = '
<p><strong>Hệ thống báo cháy địa chỉ</strong> (addressable) là chuẩn báo cháy cho công trình lớn: mỗi đầu báo, nút nhấn mang một địa chỉ riêng, tủ trung tâm hiển thị chính xác thiết bị nào đang báo cháy — thay vì chỉ biết khu vực như hệ thường.</p>

<h2>Hệ thống báo cháy địa chỉ là gì?</h2>
<p>Toàn bộ thiết bị đấu chung trên một <strong>mạch vòng (loop)</strong>; tủ trung tâm liên tục "hỏi vòng" từng địa chỉ để giám sát trạng thái. Khi một đầu báo kích hoạt, màn hình tủ hiện đúng địa chỉ và tên vị trí đã lập trình (ví dụ: "Tầng 5 – phòng 502"), giúp xử lý cháy và sơ tán nhanh hơn hẳn.</p>

<h2>Cấu tạo và thiết bị chính</h2>
<ul>
<li><strong>Tủ trung tâm báo cháy địa chỉ</strong> quản lý một hoặc nhiều loop, mỗi loop hàng trăm địa chỉ.</li>
<li><strong>Đầu báo khói địa chỉ</strong> như <a href="' . $url_fsp . '">Notifier FSP-951</a> — cảm biến quang thông minh, bù trôi giảm báo giả.</li>
<li><strong>Đầu báo nhiệt địa chỉ</strong> như <a href="' . $url_fst . '">Notifier FST-951</a> cho bếp, garage, khu nhiều bụi và hơi nước.</li>
<li><strong>Module giám sát / điều khiển</strong> như <a href="' . $url_module . '">module DCP-CZM</a> — ghép cả đầu báo thường vào hệ địa chỉ, hoặc điều khiển quạt, thang máy, cửa chống cháy.</li>
<li>Nút nhấn địa chỉ, chuông còi đèn, nguồn dự phòng. Xem đầy đủ <a href="' . $cat_notifier . '">thiết bị báo cháy Notifier</a>.</li>
</ul>

<h2>Ưu điểm so với báo cháy thường</h2>
<ul>
<li><strong>Định vị chính xác từng điểm cháy</strong> — yếu tố sống còn với nhà cao tầng, khách sạn có hàng trăm phòng.</li>
<li><strong>Giám sát liên tục từng thiết bị:</strong> đầu báo bẩn, mất kết nối, lỗi đều hiện cảnh báo riêng — bảo trì chủ động.</li>
<li><strong>Tiết kiệm dây:</strong> một loop chạy xuyên nhiều tầng thay cho hàng chục tuyến dây zone.</li>
<li><strong>Dễ mở rộng, tích hợp:</strong> thêm thiết bị chỉ cần gán địa chỉ mới; liên động xả khí, thang máy, âm thanh sơ tán.</li>
</ul>
<p>Đổi lại, chi phí thiết bị cao hơn hệ thường — công trình nhỏ nên cân nhắc <a href="' . $url_thuong . '">hệ thống báo cháy thường</a>. Xem bài <a href="' . $url_ss . '">so sánh chi tiết hai loại</a> để chọn đúng.</p>

<h2>Công trình nào nên dùng báo cháy địa chỉ?</h2>
<p>Nhà cao tầng, chung cư, khách sạn, bệnh viện, trung tâm thương mại, nhà máy lớn — các công trình mà quy chuẩn yêu cầu hoặc việc xác minh cháy thủ công quá chậm.</p>

<h2>Thiết kế, thi công hệ báo cháy địa chỉ</h2>
<p>PCCC Phước Long <a href="' . $svc . '">thiết kế, thi công và nghiệm thu</a> hệ báo cháy địa chỉ Notifier trọn gói: bản vẽ, lập trình địa chỉ, liên động, đào tạo vận hành. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để được tư vấn miễn phí.</p>
';

pl3_publish_post(
	'he-thong-bao-chay-dia-chi',
	'Hệ thống báo cháy địa chỉ: cấu tạo, ưu điểm & thiết bị',
	$desc_dc,
	$body_dc,
	$img_fsp,
	'hệ thống báo cháy địa chỉ',
	'hệ thống báo cháy địa chỉ,báo cháy addressable',
	$cat_id
);

/* ------------------------------------------------------------------ */
/* 5. BÀI SO SÁNH CŨ: ĐỔI FOCUS KEYWORD + CHÈN LINK 2 BÀI PILLAR       */
/* ------------------------------------------------------------------ */

$ss = get_page_by_path( 'he-thong-bao-chay-dia-chi-va-thuong', OBJECT, 'post' );
if ( $ss ) {
	// Nhường từ khóa chính cho 2 bài pillar, bài này giữ cụm so sánh.
	update_post_meta( $ss->ID, 'rank_math_focus_keyword', 'báo cháy địa chỉ và báo cháy thường,so sánh báo cháy địa chỉ và thường' );
	if ( false === strpos( $ss->post_content, $url_thuong ) ) {
		$needle = '<h2>So sánh nhanh</h2>';
		if ( false !== strpos( $ss->post_content, $needle ) ) {
			$new = str_replace(
				$needle,
				'<p>Xem chi tiết từng loại: <a href="' . $url_thuong . '">hệ thống báo cháy thường</a> và <a href="' . $url_dia_chi . '">hệ thống báo cháy địa chỉ</a>.</p>' . "\n\n" . $needle,
				$ss->post_content
			);
			wp_update_post( array( 'ID' => $ss->ID, 'post_content' => $new ) );
			WP_CLI::log( "✓ Cập nhật bài so sánh (ID {$ss->ID}): đổi keyword + chèn link" );
		} else {
			WP_CLI::warning( 'Không tìm thấy vị trí chèn link trong bài so sánh — chỉ đổi keyword.' );
		}
	} else {
		WP_CLI::log( "• Bài so sánh đã có link — chỉ cập nhật keyword (ID {$ss->ID})." );
	}
} else {
	WP_CLI::warning( 'Không tìm thấy bài so sánh he-thong-bao-chay-dia-chi-va-thuong' );
}

WP_CLI::success( 'Xong. Nhớ purge cache (LiteSpeed) và Request Indexing 4 URL trong Google Search Console.' );
