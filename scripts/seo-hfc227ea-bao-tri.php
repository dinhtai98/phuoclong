<?php
/**
 * SEO cho 2 nhóm từ khóa: "hfc-227ea / hfc 227ea" và "bảo trì tòa nhà văn phòng".
 * Chạy: cd httpdocs && wp eval-file seo-hfc227ea-bao-tri.php
 * (wp = /opt/plesk/php/8.2/bin/php $(which wp) — xem DEPLOY.md)
 *
 * Làm 4 việc, chạy lại nhiều lần an toàn (idempotent):
 *  1. Đăng bài blog "Hệ thống chữa cháy khí HFC-227ea (FM-200)".
 *  2. Viết lại bài stub /huong-dan-bao-tri-he-thong-pccc-dinh-ky-cho-toa-nha-van-phong/
 *     thành bài chuẩn SEO cho từ khóa "bảo trì tòa nhà văn phòng" (giữ nguyên slug).
 *  3. Chèn link nội bộ từ bài "Bảo trì hệ thống PCCC" sang bài bảo trì tòa nhà.
 *  4. Chèn link từ sản phẩm trung tâm xả khí HCVR sang bài HFC-227ea.
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	fwrite( STDERR, "Chạy bằng WP-CLI: wp eval-file seo-hfc227ea-bao-tri.php\n" );
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

$url_hfc       = $home . '/he-thong-chua-chay-khi-hfc-227ea/';
$url_toa_nha   = $home . '/huong-dan-bao-tri-he-thong-pccc-dinh-ky-cho-toa-nha-van-phong/';
$url_bao_tri   = $home . '/bao-tri-he-thong-pccc/';
$url_kiem_dinh = $home . '/kiem-dinh-binh-chua-chay/';
$url_sprinkler = $home . '/he-thong-chua-chay-sprinkler/';
$url_hcvr      = $shop . 'trung-tam-dieu-khien-xa-khi-3-kenh-hcvr/';
$url_nut_kich  = $shop . 'nut-kich-hoat-xa-khi-bang-tay-hps-dak-sr/';
$url_nut_huy   = $shop . 'nut-huy-xa-khi-bang-tay-hcvr-as-r/';
$img_hcvr      = $UP . 'hcvr-3-r.webp';
$img_bao_tri   = $UP . 'fsp-951.png';

/** Gán ảnh đại diện từ Media Library (không tải trùng). */
function pl2_set_thumb( $post_id, $img_url, $alt ) {
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

$term   = term_exists( 'Kiến thức PCCC', 'category' );
if ( ! $term ) {
	$term = wp_insert_term( 'Kiến thức PCCC', 'category' );
}
$cat_id = ( ! is_wp_error( $term ) ) ? ( is_array( $term ) ? (int) $term['term_id'] : (int) $term ) : 0;

/* ------------------------------------------------------------------ */
/* 1. BÀI BLOG HFC-227ea (FM-200)                                      */
/* ------------------------------------------------------------------ */

$kw_hfc   = 'hfc-227ea';
$desc_hfc = 'HFC-227ea (HFC 227ea, FM-200) là khí chữa cháy sạch cho phòng server, phòng điện: không dẫn điện, không cặn, an toàn cho người. Tư vấn thi công: 0798 285 114.';

$body_hfc = '
<p><strong>HFC-227ea</strong> (còn viết <strong>HFC 227ea</strong>, tên thương mại quen thuộc là <strong>FM-200</strong>) là loại khí chữa cháy sạch được dùng phổ biến nhất cho phòng máy chủ, phòng điện, kho lưu trữ — những nơi tuyệt đối không được dập cháy bằng nước. Bài viết giải thích HFC-227ea là gì, ưu nhược điểm và cấu tạo một hệ thống hoàn chỉnh.</p>

<h2>HFC-227ea là khí gì?</h2>
<p>HFC-227ea là khí heptafluoropropane (công thức C3HF7), không màu, không mùi, được nén hóa lỏng trong bình chứa. Khi xả, khí hấp thụ nhiệt và cắt chuỗi phản ứng cháy, dập tắt đám cháy trong khoảng <strong>10 giây</strong> ở nồng độ thiết kế 7–9%. Hệ thống HFC-227ea tại Việt Nam được thiết kế theo TCVN 7161-9.</p>

<h2>Ưu điểm của hệ thống chữa cháy khí HFC-227ea</h2>
<ul>
<li><strong>Không dẫn điện, không để lại cặn</strong> — dập cháy thiết bị điện tử, server, tủ điện mà không phá hỏng thiết bị, không phải vệ sinh sau xả.</li>
<li><strong>An toàn cho người</strong> ở nồng độ thiết kế — nhân sự kịp sơ tán mà không nguy hiểm tính mạng như chữa cháy bằng CO2.</li>
<li><strong>Dập cháy nhanh</strong>, thể tích bình chứa nhỏ gọn hơn nhiều so với hệ khí trơ (N2, IG-541).</li>
<li>Không phá hủy tầng ozone (ODP = 0).</li>
</ul>
<p><em>Lưu ý:</em> HFC-227ea có chỉ số làm nóng lên toàn cầu (GWP) cao nên về dài hạn đang được thay thế dần ở một số nước; tại Việt Nam đây vẫn là lựa chọn phổ biến và hợp chuẩn cho phòng server vừa và nhỏ.</p>

<h2>Hệ thống HFC-227ea gồm những gì?</h2>
<ul>
<li><strong>Bình chứa khí HFC-227ea</strong> kèm van xả, ống góp, đường ống và đầu phun khí bố trí theo thể tích phòng.</li>
<li><strong>Trung tâm điều khiển xả khí</strong> như <a href="' . $url_hcvr . '">Hochiki HCVR 3 kênh</a>: nhận tín hiệu từ 2 loại đầu báo (khói + nhiệt) theo nguyên tắc kích hoạt chéo, đếm ngược thời gian trễ rồi mới xả.</li>
<li><a href="' . $url_nut_kich . '">Nút kích hoạt xả khí bằng tay</a> và <a href="' . $url_nut_huy . '">nút hủy xả khí</a> đặt tại cửa phòng.</li>
<li>Chuông, còi, đèn báo xả khí trong và ngoài phòng; biển cảnh báo cấm vào khi đang xả.</li>
</ul>

<h2>HFC-227ea dùng cho khu vực nào?</h2>
<p>Phòng máy chủ, phòng UPS, phòng điện, trạm viễn thông, kho tài liệu, phòng thiết bị y tế — nơi tài sản giá trị cao và không dùng được nước. Khu vực rộng, thông thoáng như nhà xưởng thì <a href="' . $url_sprinkler . '">hệ thống sprinkler</a> vẫn là lựa chọn kinh tế hơn.</p>

<h2>Tư vấn thiết kế, thi công hệ thống HFC-227ea</h2>
<p>PCCC Phước Long <a href="' . $svc . '">khảo sát, thiết kế và thi công</a> hệ thống chữa cháy khí HFC-227ea trọn gói: tính toán nồng độ theo thể tích phòng, cung cấp thiết bị chính hãng, lắp đặt và nghiệm thu. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để được tư vấn miễn phí.</p>
';

$body_hfc = '<!-- wp:image --><figure class="wp-block-image size-large"><img src="'
	. esc_url( $img_hcvr ) . '" alt="hệ thống chữa cháy khí HFC-227ea"/></figure><!-- /wp:image -->'
	. "\n\n" . trim( $body_hfc );

$existing = get_page_by_path( 'he-thong-chua-chay-khi-hfc-227ea', OBJECT, 'post' );
$postarr  = array(
	'post_type'    => 'post',
	'post_status'  => 'publish',
	'post_name'    => 'he-thong-chua-chay-khi-hfc-227ea',
	'post_title'   => 'HFC-227ea (FM-200) là gì? Hệ thống chữa cháy khí sạch',
	'post_excerpt' => $desc_hfc,
	'post_content' => $body_hfc,
);
if ( $existing ) {
	$postarr['ID'] = $existing->ID;
	$hfc_id        = wp_update_post( $postarr, true );
} else {
	$hfc_id = wp_insert_post( $postarr, true );
}
if ( is_wp_error( $hfc_id ) ) {
	WP_CLI::warning( 'Lỗi đăng bài HFC: ' . $hfc_id->get_error_message() );
} else {
	if ( $cat_id ) {
		wp_set_post_categories( $hfc_id, array( $cat_id ) );
	}
	pl2_set_thumb( $hfc_id, $img_hcvr, 'hệ thống chữa cháy khí HFC-227ea' );
	update_post_meta( $hfc_id, 'rank_math_focus_keyword', 'hfc-227ea,hfc 227ea,hệ thống chữa cháy khí hfc-227ea' );
	update_post_meta( $hfc_id, 'rank_math_title', 'HFC-227ea (FM-200) là gì? Hệ thống chữa cháy khí sạch | PCCC Phước Long' );
	update_post_meta( $hfc_id, 'rank_math_description', $desc_hfc );
	WP_CLI::log( "✓ Bài HFC-227ea (ID $hfc_id)" );
}

/* ------------------------------------------------------------------ */
/* 2. VIẾT LẠI BÀI BẢO TRÌ TÒA NHÀ VĂN PHÒNG (giữ slug cũ)             */
/* ------------------------------------------------------------------ */

$kw_tn   = 'bảo trì tòa nhà văn phòng';
$desc_tn = 'Bảo trì tòa nhà văn phòng gồm hạng mục nào, tần suất ra sao? Checklist bảo trì PCCC bắt buộc theo quy định và chi phí tham khảo. Tư vấn: 0798 285 114.';

$body_tn = '
<p><strong>Bảo trì tòa nhà văn phòng</strong> đúng cách giúp thiết bị vận hành ổn định, kéo dài tuổi thọ công trình và — quan trọng nhất — bảo đảm an toàn pháp lý về PCCC. Bài viết tổng hợp các hạng mục cần bảo trì, tần suất và checklist riêng cho hệ thống phòng cháy chữa cháy.</p>

<h2>Các hạng mục bảo trì tòa nhà văn phòng</h2>
<ul>
<li><strong>Hệ thống điện:</strong> tủ điện tổng, máy phát dự phòng, UPS, chiếu sáng — kiểm tra siết đầu cốt, đo nhiệt, chạy thử máy phát định kỳ.</li>
<li><strong>Cấp thoát nước:</strong> bơm tăng áp, bể chứa, đường ống, xử lý nước thải.</li>
<li><strong>Điều hòa không khí, thông gió (HVAC):</strong> vệ sinh dàn nóng/lạnh, thay lọc, kiểm tra gas.</li>
<li><strong>Thang máy:</strong> bảo trì hằng tháng theo hợp đồng với hãng, kiểm định an toàn định kỳ.</li>
<li><strong>Hệ thống PCCC:</strong> báo cháy, chữa cháy, đèn thoát nạn — hạng mục <em>bắt buộc theo quy định pháp luật</em>, trình bày chi tiết bên dưới.</li>
<li>Vệ sinh tòa nhà, an ninh, camera, cảnh quan.</li>
</ul>

<h2>Bảo trì PCCC — hạng mục pháp lý bắt buộc</h2>
<p>Khác các hạng mục kỹ thuật thông thường, hệ thống PCCC phải được kiểm tra, bảo dưỡng định kỳ và lưu hồ sơ để xuất trình khi cơ quan Cảnh sát PCCC kiểm tra. Checklist tối thiểu cho tòa nhà văn phòng:</p>
<ul>
<li><strong>Hằng tháng:</strong> thử tủ trung tâm báo cháy, đèn exit/đèn sự cố, kiểm tra áp kế <a href="' . $url_kiem_dinh . '">bình chữa cháy</a>, chạy thử máy bơm chữa cháy.</li>
<li><strong>Hằng quý:</strong> thử đầu báo khói/nhiệt luân phiên theo khu vực, kiểm tra van, họng nước vách tường, cuộn vòi.</li>
<li><strong>Hằng năm:</strong> tổng kiểm tra toàn hệ, thử áp đường ống, nạp lại bình chữa cháy đến hạn, diễn tập phương án chữa cháy — thoát nạn.</li>
</ul>
<p>Chi tiết từng hạng mục xem tại bài <a href="' . $url_bao_tri . '">bảo trì hệ thống PCCC: hạng mục &amp; tần suất</a>. Tòa nhà có phòng server dùng hệ chữa cháy khí thì bổ sung kiểm tra áp suất bình khí và tủ xả khí — xem bài <a href="' . $url_hfc . '">hệ thống chữa cháy khí HFC-227ea</a>.</p>

<h2>Chi phí bảo trì tòa nhà văn phòng</h2>
<p>Chi phí phụ thuộc quy mô (số tầng, diện tích sàn), số lượng hệ thống kỹ thuật và tần suất. Riêng gói bảo trì PCCC thường tính theo số lượng thiết bị (đầu báo, bình, họng nước, máy bơm) và ký hợp đồng năm — rẻ hơn đáng kể so với gọi lẻ từng lần, đồng thời có đầy đủ biên bản phục vụ kiểm tra pháp lý.</p>

<h2>Đơn vị bảo trì PCCC cho tòa nhà văn phòng</h2>
<p>PCCC Phước Long nhận <a href="' . $svc . '">bảo trì hệ thống PCCC trọn gói</a> cho tòa nhà văn phòng: lịch bảo trì rõ ràng, kỹ thuật viên chứng chỉ, biên bản đầy đủ, khắc phục sự cố nhanh. Cung cấp luôn <a href="' . $shop . '">thiết bị thay thế chính hãng</a> khi cần. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để nhận khảo sát, báo giá miễn phí.</p>
';

$body_tn = '<!-- wp:image --><figure class="wp-block-image size-large"><img src="'
	. esc_url( $img_bao_tri ) . '" alt="' . esc_attr( $kw_tn ) . '"/></figure><!-- /wp:image -->'
	. "\n\n" . trim( $body_tn );

$tn = get_page_by_path( 'huong-dan-bao-tri-he-thong-pccc-dinh-ky-cho-toa-nha-van-phong', OBJECT, 'post' );
if ( $tn ) {
	$r = wp_update_post( array(
		'ID'           => $tn->ID,
		'post_title'   => 'Bảo trì tòa nhà văn phòng: hạng mục, checklist PCCC & chi phí',
		'post_name'    => $tn->post_name, // giữ nguyên slug cũ (đã index)
		'post_excerpt' => $desc_tn,
		'post_content' => $body_tn,
	), true );
	if ( is_wp_error( $r ) ) {
		WP_CLI::warning( 'Lỗi cập nhật bài bảo trì tòa nhà: ' . $r->get_error_message() );
	} else {
		if ( $cat_id ) {
			wp_set_post_categories( $tn->ID, array( $cat_id ) );
		}
		pl2_set_thumb( $tn->ID, $img_bao_tri, $kw_tn );
		update_post_meta( $tn->ID, 'rank_math_focus_keyword', $kw_tn . ',bảo trì PCCC tòa nhà văn phòng' );
		update_post_meta( $tn->ID, 'rank_math_title', 'Bảo trì tòa nhà văn phòng: hạng mục, checklist PCCC & chi phí | PCCC Phước Long' );
		update_post_meta( $tn->ID, 'rank_math_description', $desc_tn );
		WP_CLI::log( "✓ Viết lại bài bảo trì tòa nhà văn phòng (ID {$tn->ID})" );
	}
} else {
	WP_CLI::warning( 'Không tìm thấy bài slug huong-dan-bao-tri-he-thong-pccc-dinh-ky-cho-toa-nha-van-phong' );
}

/* ------------------------------------------------------------------ */
/* 3. LINK NỘI BỘ TỪ BÀI "BẢO TRÌ HỆ THỐNG PCCC"                       */
/* ------------------------------------------------------------------ */

$bt = get_page_by_path( 'bao-tri-he-thong-pccc', OBJECT, 'post' );
if ( $bt && false === strpos( $bt->post_content, $url_toa_nha ) ) {
	$needle = '<h2>Dịch vụ bảo trì PCCC của Phước Long</h2>';
	if ( false !== strpos( $bt->post_content, $needle ) ) {
		$new = str_replace(
			$needle,
			'<p>Với tòa nhà văn phòng, PCCC chỉ là một trong nhiều hệ kỹ thuật cần chăm sóc — xem thêm bài <a href="' . $url_toa_nha . '">bảo trì tòa nhà văn phòng: hạng mục &amp; checklist</a>.</p>' . "\n\n" . $needle,
			$bt->post_content
		);
		wp_update_post( array( 'ID' => $bt->ID, 'post_content' => $new ) );
		WP_CLI::log( "✓ Chèn link vào bài Bảo trì PCCC (ID {$bt->ID})" );
	} else {
		WP_CLI::warning( 'Không tìm thấy vị trí chèn link trong bài Bảo trì PCCC — bỏ qua.' );
	}
} elseif ( $bt ) {
	WP_CLI::log( '• Bài Bảo trì PCCC đã có link — bỏ qua.' );
}

/* ------------------------------------------------------------------ */
/* 4. LINK TỪ SẢN PHẨM TRUNG TÂM XẢ KHÍ HCVR SANG BÀI HFC              */
/* ------------------------------------------------------------------ */

$see_more = "\n" . '<p>Tìm hiểu thêm: <a href="' . $url_hfc . '">hệ thống chữa cháy khí HFC-227ea (FM-200) hoàn chỉnh gồm những gì</a>.</p>';
foreach ( array( 'trung-tam-dieu-khien-xa-khi-3-kenh-hcvr', 'nut-kich-hoat-xa-khi-bang-tay-hps-dak-sr', 'nut-huy-xa-khi-bang-tay-hcvr-as-r' ) as $slug ) {
	$p = get_page_by_path( $slug, OBJECT, 'sanpham' );
	if ( ! $p ) {
		WP_CLI::warning( "Không tìm thấy sản phẩm $slug" );
		continue;
	}
	if ( false !== strpos( $p->post_content, $url_hfc ) ) {
		WP_CLI::log( "• $slug đã có link — bỏ qua." );
		continue;
	}
	wp_update_post( array( 'ID' => $p->ID, 'post_content' => $p->post_content . $see_more ) );
	WP_CLI::log( "✓ Thêm link vào $slug (ID {$p->ID})" );
}

WP_CLI::success( 'Xong. Nhớ purge cache (LiteSpeed) và Request Indexing 2 URL trong Google Search Console.' );
