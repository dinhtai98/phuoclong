<?php
/**
 * Đăng đợt bài blog SEO thứ 2 cho PCCC Phước Long.
 * Chạy: cd httpdocs && wp eval-file publish-blog-2.php
 * Chạy lại an toàn (trùng slug -> cập nhật).
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	fwrite( STDERR, "Chạy bằng WP-CLI: wp eval-file publish-blog-2.php\n" );
	exit( 1 );
}

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

// Ảnh minh hoạ cho từng bài (dùng lại ảnh sản phẩm có sẵn trong Media Library).
$UP     = home_url( '/wp-content/uploads/2026/06/' );
$images = array(
	'bao-gia-lap-dat-he-thong-pccc'       => $UP . 'hcv-2-4-8.webp',
	'he-thong-chua-chay-sprinkler'        => $UP . 'ty325.png',
	'nen-mua-binh-chua-chay-loai-nao'     => $UP . 'mfzl4.png',
	'he-thong-bao-chay-dia-chi-va-thuong' => $UP . 'fsp-951.png',
);

$home    = home_url();
$svc     = $home . '/dich-vu/';
$contact = $home . '/lien-he/';
$shop    = $home . '/san-pham/';
$cat     = 'Kiến thức PCCC';

$articles = array(

	array(
		'slug'     => 'bao-gia-lap-dat-he-thong-pccc',
		'title'    => 'Báo giá lắp đặt hệ thống PCCC 2026: chi phí phụ thuộc gì?',
		'keyword'  => 'báo giá lắp đặt hệ thống PCCC',
		'seo_desc' => 'Báo giá lắp đặt hệ thống PCCC phụ thuộc diện tích, loại hệ thống và thiết bị. Nhận khảo sát và báo giá miễn phí trong 24h: 0798 285 114.',
		'body'     => '
<p>Nhận <strong>báo giá lắp đặt hệ thống PCCC</strong> chính xác đòi hỏi khảo sát thực tế, vì chi phí thay đổi theo nhiều yếu tố. Bài viết giúp bạn hiểu giá được tính thế nào để dự trù ngân sách hợp lý.</p>

<h2>Báo giá lắp đặt hệ thống PCCC phụ thuộc yếu tố nào?</h2>
<ul>
<li><strong>Diện tích & công năng</strong> công trình (nhà xưởng, văn phòng, kho, chung cư).</li>
<li><strong>Loại hệ thống</strong>: báo cháy thường hay địa chỉ; chữa cháy vách tường, sprinkler tự động hay chữa cháy khí.</li>
<li><strong>Thương hiệu thiết bị</strong>: Hochiki, Notifier, Tyco, Yunyang… mỗi hãng một mức giá.</li>
<li><strong>Hiện trạng</strong>: lắp mới hay cải tạo, độ phức tạp thi công, đường ống.</li>
<li><strong>Hồ sơ pháp lý</strong>: thẩm duyệt thiết kế, nghiệm thu PCCC.</li>
</ul>

<h2>Các hạng mục thường có trong báo giá</h2>
<ul>
<li>Tủ trung tâm, <a href="' . $shop . '">đầu báo, nút nhấn, chuông còi đèn</a>.</li>
<li>Máy bơm, đường ống, van, <a href="' . $shop . '">đầu phun sprinkler</a>, họng nước.</li>
<li><a href="' . $shop . '">Bình chữa cháy</a>, đèn exit, đèn sự cố.</li>
<li>Nhân công thi công + hồ sơ thẩm duyệt, nghiệm thu.</li>
</ul>

<h2>Làm sao có báo giá chuẩn?</h2>
<p>Cách nhanh và đúng nhất là để đơn vị chuyên môn <strong>khảo sát thực tế</strong> rồi bóc tách khối lượng. Báo giá qua loa không khảo sát thường sai lệch lớn khi thi công.</p>

<h2>Nhận báo giá miễn phí từ PCCC Phước Long</h2>
<p>PCCC Phước Long <a href="' . $svc . '">khảo sát và báo giá miễn phí</a> hệ thống PCCC cho nhà xưởng, tòa nhà, văn phòng — báo giá trong 24h, minh bạch từng hạng mục. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong>.</p>
',
	),

	array(
		'slug'     => 'he-thong-chua-chay-sprinkler',
		'title'    => 'Hệ thống chữa cháy Sprinkler là gì? Cấu tạo & nguyên lý',
		'keyword'  => 'hệ thống chữa cháy sprinkler',
		'seo_desc' => 'Hệ thống chữa cháy Sprinkler là gì, cấu tạo, nguyên lý hoạt động và khi nào cần lắp. Tư vấn thiết kế thi công: 0798 285 114.',
		'body'     => '
<p><strong>Hệ thống chữa cháy Sprinkler</strong> là hệ thống chữa cháy tự động bằng nước, phun dập lửa ngay tại điểm cháy mà không cần con người vận hành. Đây là giải pháp phổ biến cho nhà xưởng, kho, tòa nhà, trung tâm thương mại.</p>

<h2>Hệ thống chữa cháy Sprinkler hoạt động thế nào?</h2>
<p>Mỗi <a href="' . $shop . '">đầu phun sprinkler</a> có bầu thủy tinh chứa dung dịch. Khi nhiệt độ đạt ngưỡng (thường 68°C, 93°C…), bầu thủy tinh vỡ, đầu phun tự xả nước dập cháy đúng khu vực phát nhiệt — hạn chế cháy lan trong khi chờ lực lượng chữa cháy.</p>

<h2>Cấu tạo cơ bản</h2>
<ul>
<li>Nguồn nước & máy bơm chữa cháy (bơm chính, bù, dự phòng).</li>
<li>Đường ống dẫn nước áp lực.</li>
<li><a href="' . $shop . '">Đầu phun sprinkler</a> hướng lên/xuống/âm trần tùy vị trí.</li>
<li>Van báo động, công tắc dòng chảy giám sát về trung tâm.</li>
</ul>

<h2>Chọn đầu phun theo khu vực</h2>
<ul>
<li><strong>Hướng lên (upright):</strong> khu vực để hở đường ống, nhà xưởng, kho.</li>
<li><strong>Hướng xuống (pendent):</strong> có trần, lắp phổ biến nhất.</li>
<li><strong>Âm trần (concealed):</strong> văn phòng, khách sạn cần thẩm mỹ.</li>
<li>Chỉ số K (5.6, 8.0, 11.2) càng lớn thì lưu lượng nước càng nhiều, dùng cho nơi nguy cơ cháy cao.</li>
</ul>

<h2>Khi nào cần lắp Sprinkler?</h2>
<p>Nhiều loại công trình bắt buộc theo quy chuẩn PCCC (nhà cao tầng, nhà xưởng, kho diện tích lớn…). Đơn vị thiết kế sẽ tính toán mật độ phun và số đầu theo tiêu chuẩn.</p>

<h2>Tư vấn thiết kế & thi công Sprinkler</h2>
<p>PCCC Phước Long <a href="' . $svc . '">thiết kế và thi công hệ thống Sprinkler</a> đạt chuẩn, cung cấp đầu phun Tyco, Protector chính hãng. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để được tư vấn.</p>
',
	),

	array(
		'slug'     => 'nen-mua-binh-chua-chay-loai-nao',
		'title'    => 'Nên mua bình chữa cháy loại nào? CO2 hay bột ABC',
		'keyword'  => 'nên mua bình chữa cháy loại nào',
		'seo_desc' => 'Nên mua bình chữa cháy loại nào cho gia đình, văn phòng, xe hơi? So sánh bình CO2 và bột ABC, cách chọn đúng. Mua chính hãng: 0798 285 114.',
		'body'     => '
<p>Câu hỏi <strong>nên mua bình chữa cháy loại nào</strong> phụ thuộc vào nơi sử dụng và loại đám cháy dễ xảy ra. Chọn sai loại có thể không dập được lửa, thậm chí nguy hiểm hơn.</p>

<h2>Nên mua bình chữa cháy loại nào theo nhu cầu?</h2>
<h3>Bình bột ABC — đa dụng nhất</h3>
<p>Dập được cháy chất rắn (A), chất lỏng (B), chất khí (C). Phù hợp gia đình, cửa hàng, ô tô, nhà xưởng. Nếu chỉ mua một loại, <a href="' . $shop . '">bình bột ABC</a> là lựa chọn an toàn nhất.</p>
<h3>Bình khí CO2 — cho thiết bị điện</h3>
<p>Dập cháy không để lại cặn, an toàn cho thiết bị điện tử. Phù hợp phòng máy, tủ điện, văn phòng nhiều máy móc. Không dùng ở nơi kín có người vì CO2 gây ngạt.</p>
<h3>Bình chữa cháy pin lithium — cho xe điện</h3>
<p>Cháy pin lithium (xe máy/ô tô điện, kho pin) rất khó dập bằng bình thường. Cần <a href="' . $shop . '">bình chuyên dụng pin lithium</a> để làm mát và chống tái cháy.</p>

<h2>Chọn dung tích thế nào?</h2>
<ul>
<li>Gia đình, xe hơi: bình bột 4kg hoặc CO2 3kg.</li>
<li>Văn phòng, cửa hàng: kết hợp bột ABC + CO2.</li>
<li>Nhà xưởng, kho: bình lớn 8kg + bình cầu tự động treo trên tủ điện.</li>
</ul>

<h2>Lưu ý khi mua</h2>
<p>Chọn hàng có <strong>tem kiểm định PCCC</strong>, còn hạn, đồng hồ áp suất ở vạch xanh. Hàng của Bộ Quốc Phòng (83MEC) hoặc thương hiệu uy tín (VINAFOAM) đảm bảo chất lượng.</p>

<h2>Mua bình chữa cháy chính hãng</h2>
<p>PCCC Phước Long cung cấp <a href="' . $shop . '">bình chữa cháy CO2, bột ABC, pin lithium</a> chính hãng, có kiểm định. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để được tư vấn đúng loại.</p>
',
	),

	array(
		'slug'     => 'he-thong-bao-chay-dia-chi-va-thuong',
		'title'    => 'Hệ thống báo cháy địa chỉ và báo cháy thường khác gì nhau?',
		'keyword'  => 'hệ thống báo cháy địa chỉ',
		'seo_desc' => 'Hệ thống báo cháy địa chỉ khác báo cháy thường thế nào, nên chọn loại nào cho công trình? Tư vấn thiết kế thi công: 0798 285 114.',
		'body'     => '
<p><strong>Hệ thống báo cháy địa chỉ</strong> và báo cháy thường là hai lựa chọn phổ biến. Hiểu rõ khác biệt giúp bạn chọn đúng, tránh lãng phí hoặc thiếu tính năng cần thiết.</p>

<h2>Hệ thống báo cháy địa chỉ là gì?</h2>
<p>Mỗi thiết bị (đầu báo, nút nhấn, module) có một <strong>địa chỉ riêng</strong> trên đường loop. Khi có cháy, trung tâm hiển thị chính xác vị trí điểm báo — cực kỳ quan trọng với công trình lớn nhiều tầng, giúp xử lý nhanh.</p>

<h2>Hệ thống báo cháy thường</h2>
<p>Báo theo <strong>vùng (zone)</strong>, chỉ biết cháy ở khu vực nào chứ không định vị từng điểm. Chi phí thấp, lắp đơn giản — phù hợp nhà ở, cửa hàng, văn phòng và nhà xưởng nhỏ.</p>

<h2>So sánh nhanh</h2>
<ul>
<li><strong>Định vị:</strong> địa chỉ = từng điểm; thường = theo vùng.</li>
<li><strong>Chi phí:</strong> địa chỉ cao hơn; thường tiết kiệm.</li>
<li><strong>Quy mô phù hợp:</strong> địa chỉ cho cao ốc, khách sạn, nhà máy; thường cho công trình vừa và nhỏ.</li>
<li><strong>Mở rộng:</strong> địa chỉ dễ quản lý số lượng lớn thiết bị.</li>
</ul>

<h2>Nên chọn loại nào?</h2>
<p>Công trình lớn, nhiều tầng, cần định vị nhanh → chọn <a href="' . $shop . '">hệ địa chỉ (Notifier, Hochiki)</a>. Công trình nhỏ, ngân sách hạn chế → hệ thường (Yunyang, Hochiki HCV) là đủ và tiết kiệm.</p>

<h2>Tư vấn giải pháp phù hợp</h2>
<p>PCCC Phước Long <a href="' . $svc . '">thiết kế và thi công cả hai loại hệ thống báo cháy</a>, tư vấn theo đúng quy mô và ngân sách. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong>.</p>
',
	),
);

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
WP_CLI::success( "Đăng/cập nhật $n bài blog (đợt 2)." );
