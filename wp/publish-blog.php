<?php
/**
 * Đăng bài blog chuẩn SEO cho PCCC Phước Long (post thường) + set Rank Math.
 * Chạy:  wp eval-file publish-blog.php --path=... (trên hosting: cd httpdocs rồi chạy)
 * Chạy lại an toàn: trùng slug -> cập nhật, không tạo bản sao.
 *
 * Mỗi bài đã tối ưu: từ khoá ở đầu tiêu đề + trong đoạn mở + trong H2, meta description
 * chứa từ khoá, có link nội bộ tới dịch vụ/liên hệ/sản phẩm.
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	fwrite( STDERR, "Chạy bằng WP-CLI: wp eval-file publish-blog.php\n" );
	exit( 1 );
}

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

// Ảnh minh hoạ cho từng bài (dùng lại ảnh sản phẩm có sẵn trong Media Library).
$UP     = home_url( '/wp-content/uploads/2026/06/' );
$images = array(
	'quy-dinh-pccc-cho-nha-xuong' => $UP . 'hcv-2-4-8.webp',
	'cach-chon-dau-bao-khoi'      => $UP . 'soe-24v.webp',
	'bao-tri-he-thong-pccc'       => $UP . 'mfzl4.png',
);

$home    = home_url();
$svc     = $home . '/dich-vu/';
$contact = $home . '/lien-he/';
$shop    = $home . '/san-pham/';
$cat     = 'Kiến thức PCCC';

$articles = array(

	array(
		'slug'     => 'quy-dinh-pccc-cho-nha-xuong',
		'title'    => 'Quy định PCCC cho nhà xưởng 2026: hồ sơ, thiết bị & nghiệm thu',
		'keyword'  => 'quy định PCCC cho nhà xưởng',
		'seo_desc' => 'Quy định PCCC cho nhà xưởng 2026: hồ sơ thẩm duyệt, thiết bị bắt buộc, quy trình nghiệm thu và mức phạt. Tư vấn miễn phí: 0798 285 114.',
		'body'     => '
<p><strong>Quy định PCCC cho nhà xưởng</strong> là nội dung mọi chủ đầu tư, doanh nghiệp sản xuất phải nắm rõ trước khi xây dựng và đưa công trình vào hoạt động. Làm đúng ngay từ đầu giúp tránh bị đình chỉ, xử phạt và bảo đảm an toàn cho người lao động.</p>

<h2>Quy định PCCC cho nhà xưởng gồm những gì?</h2>
<p>Theo Nghị định 136/2020/NĐ-CP và các quy chuẩn hiện hành (QCVN 06 về an toàn cháy cho nhà và công trình), nhà xưởng thuộc diện phải bảo đảm các yêu cầu về đường thoát nạn, khoảng cách an toàn, hệ thống báo cháy, chữa cháy và điều kiện nghiệm thu trước khi hoạt động.</p>

<h3>Hồ sơ thẩm duyệt thiết kế</h3>
<ul>
<li>Bản vẽ thiết kế hệ thống PCCC được cơ quan Cảnh sát PCCC thẩm duyệt.</li>
<li>Hồ sơ nghiệm thu về PCCC trước khi đưa công trình vào sử dụng.</li>
<li>Phương án chữa cháy, nội quy và trang bị phương tiện tại chỗ.</li>
</ul>

<h3>Thiết bị PCCC bắt buộc cho nhà xưởng</h3>
<ul>
<li>Hệ thống <a href="' . $shop . '">báo cháy tự động</a> (trung tâm, đầu báo khói/nhiệt, nút nhấn, chuông còi đèn).</li>
<li>Hệ thống chữa cháy: họng nước vách tường, <a href="' . $shop . '">đầu phun sprinkler</a>, máy bơm chữa cháy.</li>
<li>Bình chữa cháy xách tay (bột ABC, CO2) bố trí theo diện tích.</li>
<li>Đèn chiếu sáng sự cố, đèn exit chỉ dẫn thoát nạn.</li>
</ul>

<h2>Quy trình nghiệm thu PCCC cho nhà xưởng</h2>
<p>Trình tự cơ bản: thẩm duyệt thiết kế → thi công lắp đặt đúng hồ sơ → nghiệm thu nội bộ → mời cơ quan PCCC nghiệm thu và cấp văn bản chấp thuận. Chỉ khi có kết quả nghiệm thu đạt, nhà xưởng mới được phép hoạt động.</p>

<h2>Mức phạt khi vi phạm</h2>
<p>Đưa công trình vào sử dụng khi chưa nghiệm thu PCCC, thiếu thiết bị hoặc hệ thống không hoạt động có thể bị xử phạt hành chính nặng và đình chỉ hoạt động. Đầu tư đúng ngay từ đầu luôn rẻ hơn khắc phục sau.</p>

<h2>Giải pháp trọn gói từ PCCC Phước Long</h2>
<p>PCCC Phước Long cung cấp <a href="' . $svc . '">dịch vụ PCCC trọn gói</a>: tư vấn thiết kế, thẩm duyệt, thi công lắp đặt và nghiệm thu cho nhà xưởng, kho bãi, nhà máy. Đội ngũ kỹ sư nhiều năm kinh nghiệm, hồ sơ pháp lý đầy đủ.</p>
<p>Cần tư vấn quy định PCCC cho nhà xưởng của bạn? <a href="' . $contact . '">Liên hệ ngay</a> hoặc gọi <strong>0798 285 114</strong> để được khảo sát và báo giá miễn phí.</p>
',
	),

	array(
		'slug'     => 'cach-chon-dau-bao-khoi',
		'title'    => 'Cách chọn đầu báo khói phù hợp cho văn phòng, nhà xưởng',
		'keyword'  => 'cách chọn đầu báo khói',
		'seo_desc' => 'Cách chọn đầu báo khói đúng loại cho văn phòng, nhà xưởng: báo khói quang, báo nhiệt, thường và địa chỉ. Tư vấn: 0798 285 114.',
		'body'     => '
<p>Biết <strong>cách chọn đầu báo khói</strong> đúng loại giúp hệ thống báo cháy phát hiện sớm, ít báo giả và tiết kiệm chi phí. Bài viết này hướng dẫn chọn đầu báo theo từng khu vực sử dụng.</p>

<h2>Cách chọn đầu báo khói theo nguyên lý hoạt động</h2>
<h3>Đầu báo khói quang (photoelectric)</h3>
<p>Phát hiện khói âm ỉ, cháy chậm — phù hợp văn phòng, phòng ngủ, hành lang, khu vực sinh hoạt. Đây là loại phổ biến nhất nhờ ổn định và ít báo giả.</p>
<h3>Đầu báo nhiệt</h3>
<p>Kích hoạt theo nhiệt độ, dùng cho nơi nhiều khói bụi/hơi nước dễ làm đầu báo khói báo giả như bếp, nhà xe, phòng kỹ thuật.</p>

<h2>Chọn đầu báo thường hay địa chỉ?</h2>
<ul>
<li><strong>Hệ thường (conventional):</strong> chi phí thấp, báo theo vùng (zone) — phù hợp nhà ở, cửa hàng, nhà xưởng nhỏ.</li>
<li><strong>Hệ địa chỉ (addressable):</strong> mỗi đầu báo có địa chỉ riêng, định vị chính xác điểm cháy — phù hợp cao ốc, khách sạn, nhà máy lớn.</li>
</ul>

<h2>Chọn theo khu vực lắp đặt</h2>
<ul>
<li>Văn phòng, hành lang, phòng ngủ → <a href="' . $shop . '">đầu báo khói quang</a>.</li>
<li>Bếp, gara, phòng máy nóng → đầu báo nhiệt.</li>
<li>Công trình lớn cần định vị → đầu báo địa chỉ (Notifier, Hochiki).</li>
</ul>

<h2>Lưu ý khi lắp đặt</h2>
<p>Bố trí đúng khoảng cách và số lượng theo diện tích, đúng điện áp (thường 24V DC), tránh lắp gần cửa gió/điều hòa gây nhiễu. Nên để đơn vị chuyên môn tính toán để bảo đảm vùng phủ và qua nghiệm thu.</p>

<h2>Cần tư vấn chọn đầu báo phù hợp?</h2>
<p>PCCC Phước Long cung cấp đầy đủ <a href="' . $shop . '">đầu báo khói, đầu báo nhiệt</a> chính hãng Hochiki, Notifier, Yunyang và <a href="' . $svc . '">thi công hệ thống báo cháy</a> trọn gói. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để được tư vấn đúng nhu cầu.</p>
',
	),

	array(
		'slug'     => 'bao-tri-he-thong-pccc',
		'title'    => 'Bảo trì hệ thống PCCC: hạng mục & tần suất cần biết',
		'keyword'  => 'bảo trì hệ thống PCCC',
		'seo_desc' => 'Bảo trì hệ thống PCCC gồm hạng mục nào, bao lâu làm một lần? Checklist bảo trì báo cháy, chữa cháy, máy bơm. Gọi 0798 285 114.',
		'body'     => '
<p><strong>Bảo trì hệ thống PCCC</strong> định kỳ giúp thiết bị luôn sẵn sàng hoạt động khi có sự cố, đồng thời là yêu cầu bắt buộc để duy trì điều kiện an toàn phòng cháy chữa cháy của công trình.</p>

<h2>Vì sao phải bảo trì hệ thống PCCC?</h2>
<p>Thiết bị để lâu không kiểm tra dễ hỏng ngầm: ắc-quy trung tâm chai, đầu báo bám bụi, van khóa kẹt, bơm không lên áp. Khi cháy xảy ra mà hệ thống không hoạt động thì hậu quả rất nặng, chưa kể bị xử phạt khi kiểm tra.</p>

<h2>Các hạng mục bảo trì hệ thống PCCC</h2>
<h3>Hệ thống báo cháy</h3>
<ul>
<li>Kiểm tra tủ trung tâm, nguồn và ắc-quy dự phòng.</li>
<li>Thử từng đầu báo khói/nhiệt, nút nhấn, chuông còi đèn.</li>
<li>Vệ sinh đầu báo, kiểm tra tín hiệu về trung tâm.</li>
</ul>
<h3>Hệ thống chữa cháy</h3>
<ul>
<li>Kiểm tra máy bơm chữa cháy (bơm chính, bơm bù, bơm dự phòng), áp lực đường ống.</li>
<li>Kiểm tra van, họng nước vách tường, <a href="' . $shop . '">đầu phun sprinkler</a>, lăng vòi.</li>
<li>Kiểm tra, nạp sạc <a href="' . $shop . '">bình chữa cháy</a> hết hạn.</li>
</ul>
<h3>Thoát nạn</h3>
<ul>
<li>Đèn exit, đèn chiếu sáng sự cố còn sáng khi mất điện.</li>
<li>Đường và cửa thoát nạn thông thoáng.</li>
</ul>

<h2>Bảo trì hệ thống PCCC bao lâu một lần?</h2>
<p>Thông thường nên kiểm tra định kỳ hằng tháng cho các hạng mục cơ bản và bảo trì tổng thể định kỳ (quý/năm) tùy quy mô công trình. Bình chữa cháy kiểm tra định kỳ và nạp lại theo hạn sử dụng.</p>

<h2>Dịch vụ bảo trì PCCC của Phước Long</h2>
<p>PCCC Phước Long nhận <a href="' . $svc . '">bảo trì hệ thống PCCC</a> định kỳ cho tòa nhà, nhà xưởng, văn phòng — có biên bản, lịch bảo trì rõ ràng, khắc phục nhanh. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để nhận báo giá bảo trì.</p>
',
	),
);

// Bảo đảm có category.
$term = term_exists( $cat, 'category' );
if ( ! $term ) {
	$term = wp_insert_term( $cat, 'category' );
}
$cat_id = ( ! is_wp_error( $term ) ) ? ( is_array( $term ) ? (int) $term['term_id'] : (int) $term ) : 0;

$n = 0;
foreach ( $articles as $a ) {
	$img_url = $images[ $a['slug'] ] ?? '';
	$content = trim( $a['body'] );
	if ( '' !== $img_url ) {
		$content = '<!-- wp:image --><figure class="wp-block-image size-large"><img src="'
			. esc_url( $img_url ) . '" alt="' . esc_attr( $a['keyword'] ) . '"/></figure><!-- /wp:image -->'
			. "\n\n" . $content;
	}
	$existing = get_page_by_path( $a['slug'], OBJECT, 'post' );
	$postarr  = array(
		'post_type'    => 'post',
		'post_status'  => 'publish',
		'post_name'    => $a['slug'],
		'post_title'   => $a['title'],
		'post_excerpt' => $a['seo_desc'],
		'post_content' => $content,
	);
	if ( $existing ) {
		$postarr['ID'] = $existing->ID;
		$id            = wp_update_post( $postarr, true );
	} else {
		$id = wp_insert_post( $postarr, true );
	}
	if ( is_wp_error( $id ) ) {
		WP_CLI::warning( "Lỗi: {$a['title']} — " . $id->get_error_message() );
		continue;
	}
	if ( $cat_id ) {
		wp_set_post_categories( $id, array( $cat_id ) );
	}
	// Ảnh đại diện: ưu tiên ảnh có sẵn trong Media Library, không tải trùng.
	if ( '' !== $img_url && ! has_post_thumbnail( $id ) ) {
		$aid = attachment_url_to_postid( $img_url );
		if ( ! $aid ) {
			$aid = media_sideload_image( $img_url, $id, $a['keyword'], 'id' );
		}
		if ( ! is_wp_error( $aid ) && $aid ) {
			set_post_thumbnail( $id, $aid );
			update_post_meta( $aid, '_wp_attachment_image_alt', $a['keyword'] );
		}
	}
	update_post_meta( $id, 'rank_math_focus_keyword', $a['keyword'] );
	update_post_meta( $id, 'rank_math_title', $a['title'] . ' | PCCC Phước Long' );
	update_post_meta( $id, 'rank_math_description', $a['seo_desc'] );
	WP_CLI::log( "✓ {$a['title']} (ID $id)" );
	$n++;
}
WP_CLI::success( "Đăng/cập nhật $n bài blog." );
