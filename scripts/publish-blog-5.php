<?php
/**
 * Đăng đợt bài blog SEO thứ 5 cho PCCC Phước Long.
 * Chạy: cd httpdocs && wp eval-file publish-blog-5.php
 * Chạy lại an toàn (trùng slug -> cập nhật, không tạo bản sao).
 *
 * Mỗi bài đã tối ưu: từ khoá ở đầu tiêu đề + trong đoạn mở + trong H2, meta description
 * chứa từ khoá, có link nội bộ tới dịch vụ/liên hệ/sản phẩm và các bài blog liên quan.
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	fwrite( STDERR, "Chạy bằng WP-CLI: wp eval-file publish-blog-5.php\n" );
	exit( 1 );
}

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

// Ảnh minh hoạ cho từng bài (dùng lại ảnh sản phẩm có sẵn trong Media Library).
$UP     = home_url( '/wp-content/uploads/2026/06/' );
$images = array(
	'quy-dinh-pccc-nha-hang-quan-karaoke' => $UP . 'kt2200el.jpeg',
	'cac-loai-dau-phun-sprinkler'         => $UP . 'ty3551.png',
	'ho-so-tham-duyet-pccc'               => $UP . 'work-1.jpg',
	'kiem-tra-pccc-dinh-ky'               => $UP . 'work-33.jpg',
);

$home    = home_url();
$svc     = $home . '/dich-vu/';
$contact = $home . '/lien-he/';
$shop    = $home . '/san-pham/';
$cat     = 'Kiến thức PCCC';

$articles = array(

	array(
		'slug'     => 'quy-dinh-pccc-nha-hang-quan-karaoke',
		'title'    => 'Quy định PCCC cho nhà hàng, quán karaoke, quán cà phê',
		'keyword'  => 'quy định PCCC cho nhà hàng',
		'seo_desc' => 'Quy định PCCC cho nhà hàng, quán karaoke, quán cà phê: thiết bị bắt buộc, lối thoát nạn, hồ sơ cần có. Tư vấn lắp đặt trọn gói: 0798 285 114.',
		'body'     => '
<p><strong>Quy định PCCC cho nhà hàng</strong>, quán karaoke, quán cà phê ngày càng chặt sau các vụ cháy cơ sở kinh doanh dịch vụ gây hậu quả lớn. Chủ cơ sở cần nắm rõ yêu cầu để vừa được cấp phép hoạt động, vừa bảo vệ khách và nhân viên.</p>

<h2>Quy định PCCC cho nhà hàng, quán karaoke gồm những gì?</h2>
<ul>
<li><strong>Lối thoát nạn:</strong> tối thiểu theo số người, cửa mở theo chiều thoát nạn, không khóa trái khi đang kinh doanh; hành lang, cầu thang không bị bàn ghế, kho hàng chiếm dụng.</li>
<li><strong>Đèn exit, đèn sự cố:</strong> lắp đủ trên đường thoát nạn — xem chi tiết <a href="' . $home . '/quy-dinh-lap-dat-den-exit/">quy định lắp đặt đèn exit</a>.</li>
<li><strong>Báo cháy:</strong> cơ sở karaoke, nhà hàng quy mô từ mức quy định phải có hệ thống báo cháy tự động; phòng hát cách âm kín càng bắt buộc đầu báo trong từng phòng.</li>
<li><strong>Chữa cháy:</strong> bình chữa cháy xách tay bố trí theo diện tích, khu bếp có phương án riêng cho cháy dầu mỡ; quy mô lớn cần họng nước vách tường, sprinkler.</li>
<li><strong>Vật liệu:</strong> hạn chế vật liệu cách âm, trang trí dễ cháy (mút, xốp) — đây là nguyên nhân cháy lan cực nhanh ở quán karaoke.</li>
<li><strong>Điện:</strong> aptomat riêng từng khu vực, không câu mắc tùy tiện, kiểm tra định kỳ hệ thống điện, biển quảng cáo.</li>
</ul>

<h2>Hồ sơ, thủ tục PCCC cho cơ sở kinh doanh dịch vụ</h2>
<p>Tùy quy mô, cơ sở phải được <a href="' . $home . '/ho-so-tham-duyet-pccc/">thẩm duyệt thiết kế và nghiệm thu về PCCC</a> trước khi hoạt động, có hồ sơ quản lý PCCC, phương án chữa cháy được phê duyệt và nhân viên được huấn luyện nghiệp vụ PCCC định kỳ.</p>

<h2>Khu bếp nhà hàng: điểm nóng dễ cháy nhất</h2>
<ul>
<li>Vệ sinh dầu mỡ bám ở hút mùi, ống khói định kỳ — dầu mỡ tích tụ là mồi cháy lan lên mái.</li>
<li>Khóa van gas, kiểm tra dây và van gas thường xuyên; lắp đầu báo và bình chữa cháy ngay khu bếp.</li>
<li>Không dùng nước dập cháy chảo dầu — dùng nắp đậy hoặc bình chữa cháy phù hợp.</li>
</ul>

<h2>Trang bị PCCC trọn gói cho nhà hàng, quán karaoke</h2>
<p>PCCC Phước Long <a href="' . $svc . '">khảo sát, tư vấn và thi công</a> hệ báo cháy, đèn exit, bình chữa cháy đạt chuẩn nghiệm thu cho nhà hàng, quán karaoke, quán cà phê. Thiết bị <a href="' . $shop . '">chính hãng, có kiểm định</a>. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để được tư vấn miễn phí.</p>
',
	),

	array(
		'slug'     => 'cac-loai-dau-phun-sprinkler',
		'title'    => 'Đầu phun sprinkler: các loại, thông số & cách chọn đúng',
		'keyword'  => 'đầu phun sprinkler',
		'seo_desc' => 'Đầu phun sprinkler có mấy loại: hướng lên, hướng xuống, gắn tường, phản ứng nhanh? Nhiệt độ kích hoạt 68/93°C chọn sao? Tư vấn: 0798 285 114.',
		'body'     => '
<p><strong>Đầu phun sprinkler</strong> là bộ phận quyết định của hệ chữa cháy tự động bằng nước: chọn sai kiểu lắp hay ngưỡng nhiệt, hệ thống có thể phun chậm hoặc không phủ hết đám cháy. Bài viết phân loại các dòng thông dụng và cách chọn đúng.</p>

<h2>Các loại đầu phun sprinkler theo kiểu lắp</h2>
<ul>
<li><strong>Hướng xuống (pendent):</strong> lắp dưới trần, tia nước tỏa hình nón xuống sàn — phổ biến nhất trong văn phòng, thương mại (dòng TY315, TY325).</li>
<li><strong>Hướng lên (upright):</strong> lắp trên đường ống nổi, hắt nước lên rồi tỏa xuống — hợp nhà xưởng, tầng kỹ thuật không trần giả.</li>
<li><strong>Gắn tường (sidewall):</strong> lắp ngang trên tường, phun quạt về một phía — dùng cho hành lang, phòng nhỏ khó đi ống trần.</li>
<li><strong>Âm trần/concealed:</strong> giấu sau nắp thẩm mỹ, hợp khách sạn, văn phòng cao cấp.</li>
</ul>

<h2>Nhiệt độ kích hoạt và màu ống thủy tinh</h2>
<p>Bầu thủy tinh chứa dung dịch giãn nở, vỡ ở ngưỡng nhiệt định sẵn để xả nước:</p>
<ul>
<li><strong>68°C (bầu đỏ):</strong> khu vực thông thường — văn phòng, cửa hàng, khách sạn.</li>
<li><strong>93°C (bầu xanh lá):</strong> khu vực nhiệt cao — bếp, phòng máy, gần mái tôn hấp nhiệt.</li>
<li>Ngoài ra còn 57°C, 141°C… cho môi trường đặc thù; hệ số phản ứng nhanh (quick response) cho nơi tập trung đông người.</li>
</ul>
<p>Lưu ý: hai mức nhiệt là hai mã sản phẩm khác nhau (ví dụ TY315 68°C và TY315 93°C) — khi thay thế phải đúng thông số cũ.</p>

<h2>Chọn đầu phun sprinkler theo công trình</h2>
<ul>
<li>Diện tích bảo vệ và hệ số K (K5.6, K8.0…) phải theo thiết kế được thẩm duyệt, không tự ý đổi.</li>
<li>Khu vực dễ va đập (kho, bãi xe) nên lắp thêm <a href="' . $home . '/nap-chup-dau-phun-sprinkler/">nắp chụp bảo vệ đầu phun</a> để tránh vỡ bầu gây phun nhầm.</li>
<li>Đầu phun đã kích hoạt hoặc bầu nứt phải thay mới, không tái sử dụng; nên dự trữ hộp đầu phun thay thế cùng chủng loại tại công trình.</li>
</ul>
<p>Xem thêm tổng quan <a href="' . $home . '/he-thong-chua-chay-sprinkler/">hệ thống chữa cháy sprinkler</a> để hiểu vai trò của đầu phun trong toàn hệ.</p>

<h2>Mua đầu phun sprinkler Tyco chính hãng</h2>
<p>PCCC Phước Long cung cấp <a href="' . $shop . '">đầu phun sprinkler Tyco</a> (TY315, TY325, TY3551, TY4251…) đủ kiểu lắp, đủ ngưỡng nhiệt, kèm nắp chụp bảo vệ và <a href="' . $svc . '">dịch vụ lắp đặt, thay thế</a>. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để được báo giá theo số lượng.</p>
',
	),

	array(
		'slug'     => 'ho-so-tham-duyet-pccc',
		'title'    => 'Hồ sơ thẩm duyệt PCCC gồm những gì? Quy trình mới nhất',
		'keyword'  => 'hồ sơ thẩm duyệt PCCC',
		'seo_desc' => 'Hồ sơ thẩm duyệt PCCC gồm những giấy tờ gì, nộp ở đâu, bao lâu có kết quả? Dịch vụ tư vấn thẩm duyệt, nghiệm thu trọn gói: 0798 285 114.',
		'body'     => '
<p>Chuẩn bị đúng <strong>hồ sơ thẩm duyệt PCCC</strong> ngay từ đầu giúp dự án không bị trả hồ sơ, chậm tiến độ. Bài viết liệt kê thành phần hồ sơ, nơi nộp và quy trình từ thẩm duyệt thiết kế đến nghiệm thu đưa công trình vào sử dụng.</p>

<h2>Công trình nào phải thẩm duyệt PCCC?</h2>
<p>Danh mục do Chính phủ quy định theo quy mô, công năng: nhà cao tầng, chung cư, nhà xưởng sản xuất, kho hàng, trung tâm thương mại, karaoke, trường học, bệnh viện… từ ngưỡng diện tích/chiều cao nhất định. Công trình cải tạo làm thay đổi công năng, giải pháp PCCC cũng phải thẩm duyệt lại.</p>

<h2>Hồ sơ thẩm duyệt PCCC gồm những gì?</h2>
<ul>
<li>Văn bản đề nghị thẩm duyệt thiết kế về PCCC (theo mẫu).</li>
<li>Giấy tờ pháp lý dự án: chứng nhận đăng ký doanh nghiệp, quyền sử dụng đất, chủ trương đầu tư…</li>
<li><strong>Hồ sơ thiết kế:</strong> bản vẽ và thuyết minh thể hiện giải pháp ngăn cháy, thoát nạn, hệ báo cháy, chữa cháy, chống tụ khói, cấp nước chữa cháy, nguồn điện ưu tiên.</li>
<li>Giấy xác nhận đủ điều kiện của đơn vị tư vấn thiết kế về PCCC.</li>
</ul>
<p>Hồ sơ nộp tại cơ quan Cảnh sát PCCC có thẩm quyền (theo phân cấp công trình), trực tiếp hoặc qua cổng dịch vụ công; thời hạn giải quyết tính theo ngày làm việc tùy nhóm công trình.</p>

<h2>Quy trình từ thẩm duyệt đến nghiệm thu</h2>
<ol>
<li><strong>Thẩm duyệt thiết kế:</strong> được cấp Giấy chứng nhận thẩm duyệt kèm bản vẽ đóng dấu.</li>
<li><strong>Thi công đúng hồ sơ:</strong> mọi thay đổi giải pháp PCCC phải trình thẩm duyệt điều chỉnh — xem <a href="' . $home . '/bao-gia-lap-dat-he-thong-pccc/">chi phí lắp đặt hệ thống PCCC</a> để dự trù ngân sách.</li>
<li><strong>Nghiệm thu:</strong> chủ đầu tư tự nghiệm thu rồi đề nghị cơ quan PCCC kiểm tra kết quả nghiệm thu; đạt yêu cầu mới được đưa công trình vào sử dụng.</li>
</ol>
<p>Với nhà cao tầng, yêu cầu kỹ thuật chi tiết đã được tổng hợp trong bài <a href="' . $home . '/tieu-chuan-pccc-nha-cao-tang/">tiêu chuẩn PCCC cho nhà cao tầng</a>.</p>

<h2>Lỗi thường gặp khiến hồ sơ bị trả</h2>
<ul>
<li>Bản vẽ thiếu giải pháp chống tụ khói, tăng áp buồng thang; bố trí họng nước, đầu phun không đủ bán kính phủ.</li>
<li>Chọn thiết bị không có kiểm định hoặc thông số không khớp thuyết minh.</li>
<li>Thi công khác bản vẽ được duyệt → nghiệm thu không đạt, phải khắc phục tốn kém.</li>
</ul>

<h2>Dịch vụ tư vấn thẩm duyệt, nghiệm thu PCCC</h2>
<p>PCCC Phước Long <a href="' . $svc . '">tư vấn thiết kế, lập hồ sơ thẩm duyệt, thi công và hỗ trợ nghiệm thu</a> trọn gói — kỹ sư kinh nghiệm làm việc trực tiếp với cơ quan PCCC, thiết bị <a href="' . $shop . '">chính hãng có kiểm định</a>. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để được tư vấn hồ sơ miễn phí.</p>
',
	),

	array(
		'slug'     => 'kiem-tra-pccc-dinh-ky',
		'title'    => 'Kiểm tra PCCC định kỳ: doanh nghiệp cần chuẩn bị gì?',
		'keyword'  => 'kiểm tra PCCC định kỳ',
		'seo_desc' => 'Kiểm tra PCCC định kỳ của cơ quan chức năng gồm những gì, chuẩn bị hồ sơ và thiết bị ra sao để không bị phạt? Hỗ trợ rà soát: 0798 285 114.',
		'body'     => '
<p>Đợt <strong>kiểm tra PCCC định kỳ</strong> của cơ quan chức năng là nỗi lo của nhiều doanh nghiệp — nhưng nếu duy trì hồ sơ và thiết bị đúng chuẩn quanh năm thì không có gì phải đối phó. Bài viết liệt kê những gì đoàn kiểm tra thường xem và cách chuẩn bị.</p>

<h2>Kiểm tra PCCC định kỳ diễn ra thế nào?</h2>
<p>Cơ sở thuộc diện quản lý về PCCC được kiểm tra định kỳ theo phân loại nguy hiểm cháy nổ (và kiểm tra đột xuất khi có dấu hiệu vi phạm). Đoàn kiểm tra đối chiếu hồ sơ, đi thực tế hiện trạng và lập biên bản; lỗi vi phạm có thể bị xử phạt hành chính, nặng thì đình chỉ hoạt động.</p>

<h2>Hồ sơ PCCC doanh nghiệp phải có sẵn</h2>
<ul>
<li>Hồ sơ quản lý, theo dõi hoạt động PCCC của cơ sở; nội quy, tiêu lệnh chữa cháy niêm yết.</li>
<li>Giấy chứng nhận <a href="' . $home . '/ho-so-tham-duyet-pccc/">thẩm duyệt, nghiệm thu về PCCC</a> (nếu thuộc diện).</li>
<li><strong>Phương án chữa cháy</strong> được phê duyệt, có tổ chức thực tập định kỳ kèm biên bản.</li>
<li>Chứng nhận huấn luyện nghiệp vụ PCCC của đội PCCC cơ sở và người lao động.</li>
<li>Sổ theo dõi, biên bản tự kiểm tra và <a href="' . $home . '/bao-tri-he-thong-pccc/">bảo trì hệ thống PCCC</a>, tem kiểm định phương tiện.</li>
</ul>

<h2>Hiện trạng thiết bị: những điểm đoàn kiểm tra hay soi</h2>
<ul>
<li><strong>Bình chữa cháy:</strong> đủ số lượng, kim áp kế vạch xanh, còn hạn — bình tụt áp phải <a href="' . $home . '/nap-sac-binh-chua-chay/">nạp sạc</a> và <a href="' . $home . '/kiem-dinh-binh-chua-chay/">kiểm định</a> lại ngay.</li>
<li><strong>Hệ báo cháy:</strong> trung tâm không báo lỗi, đầu báo không bị che chắn, thử chuông còi hoạt động.</li>
<li><strong>Họng nước, máy bơm:</strong> vòi không mục, van không rò, bơm chạy được cả nguồn điện và dự phòng.</li>
<li><strong>Lối thoát nạn:</strong> không bị hàng hóa chắn, cửa không khóa trái, đèn exit và đèn sự cố sáng khi cắt điện.</li>
<li>Khoảng cách an toàn, sắp xếp hàng hóa dễ cháy, hệ thống điện không câu mắc tùy tiện.</li>
</ul>

<h2>Checklist tự kiểm tra hằng quý</h2>
<p>Chủ động tự kiểm tra theo chu kỳ tháng/quý: đi một vòng theo danh mục trên, chụp ảnh lưu hồ sơ, ghi sổ theo dõi và xử lý ngay hạng mục hỏng. Duy trì đều đặn thì đợt kiểm tra chính thức chỉ là thủ tục.</p>

<h2>Dịch vụ rà soát, khắc phục trước kiểm tra</h2>
<p>PCCC Phước Long nhận <a href="' . $svc . '">rà soát hiện trạng, bảo trì hệ thống, nạp sạc bình</a> và bổ sung <a href="' . $shop . '">thiết bị đạt kiểm định</a> giúp doanh nghiệp sẵn sàng trước đợt kiểm tra PCCC định kỳ. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để đặt lịch khảo sát.</p>
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
