<?php
/**
 * Đăng đợt bài blog SEO thứ 3 cho PCCC Phước Long.
 * Chạy: cd httpdocs && wp eval-file publish-blog-3.php
 * Chạy lại an toàn (trùng slug -> cập nhật, không tạo bản sao).
 *
 * Mỗi bài đã tối ưu: từ khoá ở đầu tiêu đề + trong đoạn mở + trong H2, meta description
 * chứa từ khoá, có link nội bộ tới dịch vụ/liên hệ/sản phẩm.
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	fwrite( STDERR, "Chạy bằng WP-CLI: wp eval-file publish-blog-3.php\n" );
	exit( 1 );
}

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

// Ảnh minh hoạ cho từng bài (dùng lại ảnh sản phẩm có sẵn trong Media Library).
$UP     = home_url( '/wp-content/uploads/2026/06/' );
$images = array(
	'cach-su-dung-binh-chua-chay'      => $UP . 'binh-chua-chay-bot-abc-4kg-vinafoam.jpg',
	'kiem-dinh-binh-chua-chay'         => $UP . '83mec-co2-mt3.jpeg',
	'tieu-chuan-pccc-nha-cao-tang'     => $UP . 'trung-tam-bao-chay-yunyang.jpg',
	'ky-nang-thoat-hiem-khi-chay'      => $UP . 'kt620.jpg',
);

$home    = home_url();
$svc     = $home . '/dich-vu/';
$contact = $home . '/lien-he/';
$shop    = $home . '/san-pham/';
$cat     = 'Kiến thức PCCC';

$articles = array(

	array(
		'slug'     => 'cach-su-dung-binh-chua-chay',
		'title'    => 'Cách sử dụng bình chữa cháy đúng: bột ABC & CO2',
		'keyword'  => 'cách sử dụng bình chữa cháy',
		'seo_desc' => 'Cách sử dụng bình chữa cháy bột ABC và CO2 đúng kỹ thuật theo quy tắc PASS, kèm lưu ý an toàn. Tư vấn, nạp sạc bình: 0798 285 114.',
		'body'     => '
<p>Nắm được <strong>cách sử dụng bình chữa cháy</strong> đúng trong vài giây đầu có thể dập tắt đám cháy ngay khi mới phát sinh, tránh thiệt hại về người và tài sản. Bài viết hướng dẫn thao tác cho cả bình bột ABC và bình khí CO2.</p>

<h2>Cách sử dụng bình chữa cháy theo quy tắc PASS</h2>
<p>Dù là bình bột hay bình khí, thao tác cơ bản đều theo 4 bước dễ nhớ (PASS):</p>
<ul>
<li><strong>P – Rút chốt:</strong> rút chốt an toàn (chốt kẹp chì) ở tay cầm.</li>
<li><strong>A – Hướng loa/vòi phun</strong> vào gốc ngọn lửa, không phun vào ngọn lửa phía trên.</li>
<li><strong>S – Bóp cò</strong> để chất chữa cháy phun ra.</li>
<li><strong>S – Quét</strong> vòi qua lại theo bề rộng đám cháy cho tới khi tắt hẳn.</li>
</ul>

<h3>Với bình bột ABC (MFZL)</h3>
<p>Trước khi dùng nên dốc ngược bình vài lần cho bột tơi. Đứng đầu hướng gió, cách đám cháy khoảng 1,5 m, phun vào gốc lửa và tiến dần lên. Bột ABC dập được cháy chất rắn, lỏng và thiết bị điện hạ thế.</p>

<h3>Với bình khí CO2 (MT)</h3>
<p>Cầm vào phần tay nhựa của loa phun, <strong>tuyệt đối không cầm trực tiếp vào loa kim loại</strong> vì khí CO2 lạnh sâu (âm hàng chục độ) gây bỏng lạnh. CO2 phù hợp cháy thiết bị điện, phòng máy, nhưng không dùng nơi kín có người vì gây ngạt.</p>

<h2>Những lưu ý an toàn khi chữa cháy</h2>
<ul>
<li>Ưu tiên báo động, gọi 114 và thoát nạn nếu đám cháy đã lớn.</li>
<li>Luôn đứng đầu hướng gió, giữ lối thoát phía sau lưng.</li>
<li>Kiểm tra áp kế: kim ở vạch xanh là bình còn dùng được.</li>
<li>Sau khi dùng phải mang <a href="' . $svc . '">nạp sạc lại</a>, không cất bình đã xả.</li>
</ul>

<h2>Chọn và bảo quản bình chữa cháy</h2>
<p>Mỗi khu vực nên trang bị bình phù hợp: bột ABC cho khu vực chung, CO2 cho phòng điện, phòng server. Đặt bình nơi dễ thấy, dễ lấy, tránh nắng nóng và kiểm tra áp suất định kỳ. Xem thêm <a href="' . $shop . '">các loại bình chữa cháy</a> chính hãng.</p>

<h2>Cần tư vấn hoặc nạp sạc bình chữa cháy?</h2>
<p>PCCC Phước Long cung cấp <a href="' . $shop . '">bình chữa cháy</a> bột ABC, CO2 chính hãng và nhận nạp sạc, kiểm tra định kỳ. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để được tư vấn đúng nhu cầu.</p>
',
	),

	array(
		'slug'     => 'kiem-dinh-binh-chua-chay',
		'title'    => 'Kiểm định bình chữa cháy: quy định, chi phí & thời hạn',
		'keyword'  => 'kiểm định bình chữa cháy',
		'seo_desc' => 'Kiểm định bình chữa cháy là gì, bao lâu một lần, thủ tục và tem kiểm định ra sao? Dịch vụ kiểm định, nạp sạc uy tín: 0798 285 114.',
		'body'     => '
<p><strong>Kiểm định bình chữa cháy</strong> là yêu cầu bắt buộc để bảo đảm bình đủ chất lượng, áp suất và sẵn sàng hoạt động khi có sự cố. Bài viết giải thích quy định, thời hạn và thủ tục kiểm định để doanh nghiệp làm đúng.</p>

<h2>Kiểm định bình chữa cháy là gì?</h2>
<p>Đây là hoạt động kiểm tra, thử nghiệm phương tiện chữa cháy theo quy chuẩn để đánh giá chất lượng vỏ bình, van, áp suất và chất chữa cháy. Bình đạt yêu cầu được dán <strong>tem kiểm định</strong> của cơ quan có thẩm quyền, là căn cứ pháp lý khi cơ quan chức năng kiểm tra.</p>

<h2>Bao lâu phải kiểm định bình chữa cháy một lần?</h2>
<ul>
<li>Kiểm tra định kỳ thường xuyên (hằng tháng/quý) về áp suất, niêm phong, ngoại quan.</li>
<li>Bình bột và bình CO2 cần nạp lại, thử áp định kỳ theo khuyến cáo nhà sản xuất và quy chuẩn (thường vài năm/lần tùy loại).</li>
<li>Bình đã qua sử dụng, kim áp kế tụt về vạch đỏ phải nạp sạc và kiểm định lại ngay.</li>
</ul>

<h2>Thủ tục và hồ sơ kiểm định</h2>
<p>Thông thường gồm: kiểm tra ngoại quan và thông số kỹ thuật, thử nghiệm áp suất vỏ bình, nạp lại chất chữa cháy nếu cần, sau đó cấp tem và biên bản kiểm định. Đơn vị chuyên môn sẽ thay bạn hoàn thiện thủ tục này.</p>

<h2>Vì sao không nên bỏ qua kiểm định?</h2>
<p>Bình quá hạn hoặc mất áp có thể không hoạt động đúng lúc cần, đồng thời doanh nghiệp dễ bị xử phạt khi kiểm tra an toàn PCCC. Chi phí kiểm định, nạp sạc nhỏ hơn rất nhiều so với rủi ro cháy nổ và mức phạt.</p>

<h2>Dịch vụ kiểm định, nạp sạc bình của Phước Long</h2>
<p>PCCC Phước Long nhận <a href="' . $svc . '">kiểm định, nạp sạc bình chữa cháy</a> cho nhà xưởng, tòa nhà, cửa hàng — có biên bản, tem đầy đủ, thu gom và giao tận nơi. Cần thay mới có sẵn <a href="' . $shop . '">bình chữa cháy chính hãng</a>. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để nhận báo giá.</p>
',
	),

	array(
		'slug'     => 'tieu-chuan-pccc-nha-cao-tang',
		'title'    => 'Tiêu chuẩn PCCC cho nhà cao tầng, chung cư mới nhất',
		'keyword'  => 'tiêu chuẩn PCCC cho nhà cao tầng',
		'seo_desc' => 'Tiêu chuẩn PCCC cho nhà cao tầng, chung cư: hệ thống báo cháy, chữa cháy, thoát nạn theo QCVN 06. Tư vấn thiết kế, thi công: 0798 285 114.',
		'body'     => '
<p><strong>Tiêu chuẩn PCCC cho nhà cao tầng</strong> khắt khe hơn nhà thấp tầng vì số người đông, đường thoát nạn dài và nguy cơ cháy lan theo chiều cao. Chủ đầu tư, ban quản lý cần nắm rõ để bảo đảm an toàn và qua nghiệm thu.</p>

<h2>Tiêu chuẩn PCCC cho nhà cao tầng gồm những gì?</h2>
<p>Theo QCVN 06 về an toàn cháy cho nhà và công trình cùng các quy chuẩn liên quan, nhà cao tầng và chung cư phải bảo đảm đồng bộ các nhóm yêu cầu về ngăn cháy, báo cháy, chữa cháy và thoát nạn.</p>

<h3>Hệ thống báo cháy tự động</h3>
<ul>
<li><a href="' . $shop . '">Trung tâm báo cháy</a>, đầu báo khói/nhiệt phủ khắp hành lang, căn hộ, tầng hầm, phòng kỹ thuật.</li>
<li>Nút nhấn khẩn, chuông còi đèn báo cháy tại mỗi tầng.</li>
<li>Với nhà cao tầng lớn nên dùng hệ báo cháy địa chỉ để định vị chính xác điểm cháy.</li>
</ul>

<h3>Hệ thống chữa cháy</h3>
<ul>
<li>Họng nước vách tường trên từng tầng, <a href="' . $shop . '">hệ sprinkler tự động</a> cho khu vực yêu cầu.</li>
<li>Máy bơm chữa cháy, bể nước dự trữ và trụ/họng tiếp nước cho xe chữa cháy.</li>
<li>Bình chữa cháy xách tay bố trí theo diện tích từng tầng.</li>
</ul>

<h3>Thoát nạn và ngăn cháy</h3>
<ul>
<li>Buồng thang bộ thoát nạn có tăng áp, cửa ngăn cháy, đèn exit và đèn chiếu sáng sự cố.</li>
<li>Giải pháp hút khói, ngăn khói cho hành lang và buồng thang.</li>
<li>Khoảng cách và số lối thoát nạn đủ theo số người của từng tầng.</li>
</ul>

<h2>Quy trình bảo đảm đạt tiêu chuẩn</h2>
<p>Trình tự: thẩm duyệt thiết kế về PCCC → thi công đúng hồ sơ → nghiệm thu và được cơ quan PCCC chấp thuận trước khi đưa vào sử dụng. Sau đó phải duy trì <a href="' . $svc . '">bảo trì định kỳ</a> để hệ thống luôn sẵn sàng.</p>

<h2>Tư vấn PCCC cho nhà cao tầng, chung cư</h2>
<p>PCCC Phước Long <a href="' . $svc . '">tư vấn thiết kế, thẩm duyệt, thi công và nghiệm thu</a> hệ thống PCCC cho chung cư, tòa nhà văn phòng, khách sạn. Đội ngũ kỹ sư kinh nghiệm, hồ sơ pháp lý đầy đủ. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để được khảo sát miễn phí.</p>
',
	),

	array(
		'slug'     => 'ky-nang-thoat-hiem-khi-chay',
		'title'    => 'Kỹ năng thoát hiểm khi cháy: 7 nguyên tắc sống còn',
		'keyword'  => 'kỹ năng thoát hiểm khi cháy',
		'seo_desc' => 'Kỹ năng thoát hiểm khi cháy: cách thoát nạn an toàn qua khói, khi kẹt trong phòng và ở nhà cao tầng. Trang bị đèn exit, thiết bị PCCC: 0798 285 114.',
		'body'     => '
<p>Trang bị <strong>kỹ năng thoát hiểm khi cháy</strong> giúp bạn và gia đình bình tĩnh xử lý đúng trong vài phút vàng đầu tiên — khoảng thời gian quyết định sự sống còn khi hỏa hoạn xảy ra.</p>

<h2>Kỹ năng thoát hiểm khi cháy cơ bản cần nhớ</h2>
<ol>
<li><strong>Giữ bình tĩnh, báo động ngay:</strong> hô hoán, nhấn nút báo cháy và gọi 114.</li>
<li><strong>Xác định lối thoát gần nhất:</strong> đi theo đèn exit, ưu tiên cầu thang bộ, <strong>không dùng thang máy</strong>.</li>
<li><strong>Cúi thấp người, men theo tường:</strong> khói độc và nóng bốc lên cao, không khí sạch hơn ở gần sàn.</li>
<li><strong>Che mũi miệng bằng khăn ẩm</strong> để lọc bớt khói khi di chuyển.</li>
<li><strong>Kiểm tra cửa trước khi mở:</strong> nếu tay nắm cửa nóng, tuyệt đối không mở vì lửa đang ở phía bên kia.</li>
<li><strong>Không quay lại lấy tài sản</strong> khi đã thoát ra ngoài.</li>
<li><strong>Nếu bén lửa vào người:</strong> dừng lại, nằm xuống và lăn để dập lửa.</li>
</ol>

<h2>Khi bị kẹt không thể thoát ra</h2>
<p>Đóng cửa ngăn khói, dùng khăn ướt chèn khe cửa, di chuyển ra ban công hoặc cửa sổ thoáng khí, dùng đèn pin hoặc vẫy vải sáng màu để phát tín hiệu cho lực lượng cứu hộ. Tránh nhảy từ trên cao khi chưa có phương tiện đỡ.</p>

<h2>Thoát hiểm ở nhà cao tầng, chung cư</h2>
<p>Ghi nhớ vị trí <strong>hai lối thoát nạn</strong> gần căn hộ, không để đồ đạc chắn hành lang, buồng thang. Đường thoát nạn phải luôn có <a href="' . $shop . '">đèn exit và đèn chiếu sáng sự cố</a> hoạt động tốt để dẫn hướng khi mất điện.</p>

<h2>Phòng hơn chống: chuẩn bị từ trước</h2>
<ul>
<li>Lắp <a href="' . $shop . '">đầu báo khói</a> để phát hiện cháy sớm ngay khi đang ngủ.</li>
<li>Trang bị bình chữa cháy tại chỗ và biết cách dùng.</li>
<li>Tập thoát nạn định kỳ, thống nhất điểm tập kết cho cả nhà/công ty.</li>
</ul>

<h2>Trang bị thiết bị thoát nạn, báo cháy</h2>
<p>PCCC Phước Long cung cấp <a href="' . $shop . '">đèn exit, đèn sự cố, đầu báo khói</a> và <a href="' . $svc . '">thi công hệ thống báo cháy, thoát nạn</a> cho nhà ở, chung cư, nhà xưởng. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để được tư vấn giải pháp an toàn.</p>
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
