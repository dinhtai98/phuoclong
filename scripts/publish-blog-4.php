<?php
/**
 * Đăng đợt bài blog SEO thứ 4 cho PCCC Phước Long.
 * Chạy: cd httpdocs && wp eval-file publish-blog-4.php
 * Chạy lại an toàn (trùng slug -> cập nhật, không tạo bản sao).
 *
 * Mỗi bài đã tối ưu: từ khoá ở đầu tiêu đề + trong đoạn mở + trong H2, meta description
 * chứa từ khoá, có link nội bộ tới dịch vụ/liên hệ/sản phẩm.
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	fwrite( STDERR, "Chạy bằng WP-CLI: wp eval-file publish-blog-4.php\n" );
	exit( 1 );
}

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

// Ảnh minh hoạ cho từng bài (dùng lại ảnh sản phẩm có sẵn trong Media Library).
$UP     = home_url( '/wp-content/uploads/2026/06/' );
$images = array(
	'nap-sac-binh-chua-chay'          => $UP . '83mec-abc-4kg.jpeg',
	'quy-dinh-lap-dat-den-exit'       => $UP . 'kt610.jpeg',
	'pccc-nha-o-ket-hop-kinh-doanh'   => $UP . 'binh-cau-chua-chay-tu-dong-6kg-xzftb61.jpg',
	'hong-nuoc-chua-chay-vach-tuong'  => $UP . 'voi-chua-chay-dn50x20mx16-bar-kem-khop.png',
);

$home    = home_url();
$svc     = $home . '/dich-vu/';
$contact = $home . '/lien-he/';
$shop    = $home . '/san-pham/';
$cat     = 'Kiến thức PCCC';

$articles = array(

	array(
		'slug'     => 'nap-sac-binh-chua-chay',
		'title'    => 'Nạp sạc bình chữa cháy: khi nào cần, quy trình & báo giá',
		'keyword'  => 'nạp sạc bình chữa cháy',
		'seo_desc' => 'Nạp sạc bình chữa cháy bột ABC, CO2 khi nào cần, quy trình ra sao, giá bao nhiêu? Nhận nạp sạc tận nơi, có tem kiểm định: 0798 285 114.',
		'body'     => '
<p><strong>Nạp sạc bình chữa cháy</strong> định kỳ là cách duy nhất bảo đảm bình còn đủ chất chữa cháy và áp suất để hoạt động đúng lúc cần. Bài viết giúp bạn nhận biết khi nào phải nạp, quy trình chuẩn và chi phí tham khảo.</p>

<h2>Khi nào cần nạp sạc bình chữa cháy?</h2>
<ul>
<li><strong>Sau mỗi lần sử dụng</strong>, dù chỉ phun vài giây — áp suất trong bình đã tụt, không thể dùng tiếp.</li>
<li><strong>Kim áp kế về vạch đỏ</strong> (bình bột): bình mất áp, phun ra yếu hoặc không phun được.</li>
<li><strong>Bình CO2 hao hụt khối lượng</strong> trên 10% so với ghi trên vỏ (kiểm tra bằng cân, vì bình CO2 không có áp kế).</li>
<li><strong>Đến hạn nạp định kỳ</strong> theo khuyến cáo nhà sản xuất, thường 6–12 tháng kiểm tra một lần và nạp lại sau vài năm tùy loại.</li>
<li>Vỏ bình gỉ sét, niêm chì mất, vòi loa nứt — cần kiểm tra tổng thể kèm nạp sạc.</li>
</ul>

<h2>Quy trình nạp sạc bình chữa cháy chuẩn</h2>
<ol>
<li>Kiểm tra ngoại quan vỏ bình, van, vòi phun; loại bỏ bình quá cũ, vỏ móp gỉ nặng.</li>
<li>Xả hết chất chữa cháy cũ, vệ sinh bên trong bình.</li>
<li>Thử áp suất thủy lực vỏ bình theo quy chuẩn (với bình đến hạn thử áp).</li>
<li>Nạp bột ABC/BC hoặc khí CO2 đúng chủng loại, đúng khối lượng ghi trên nhãn.</li>
<li>Nén áp suất đẩy (bình bột), kiểm tra rò rỉ, niêm phong chì và dán <strong>tem nạp sạc</strong> ghi ngày nạp, hạn nạp kế tiếp.</li>
</ol>
<p>Bình nạp xong phải có tem, biên bản bàn giao — đây là căn cứ khi cơ quan chức năng kiểm tra an toàn PCCC. Xem thêm về <a href="' . $home . '/kiem-dinh-binh-chua-chay/">kiểm định bình chữa cháy</a> để nắm quy định đầy đủ.</p>

<h2>Giá nạp sạc bình chữa cháy bao nhiêu?</h2>
<p>Chi phí phụ thuộc loại bình (bột ABC hay CO2), khối lượng (1kg – 35kg/xe đẩy) và tình trạng vỏ bình. Thông thường nạp bình bột nhỏ chỉ vài chục nghìn đồng/kg, bình CO2 tính theo kg khí. Nếu vỏ bình quá cũ, mua <a href="' . $shop . '">bình chữa cháy mới</a> đôi khi kinh tế hơn — đơn vị nạp uy tín sẽ tư vấn thẳng thay vì cố nạp.</p>

<h2>Dịch vụ nạp sạc bình chữa cháy của Phước Long</h2>
<p>PCCC Phước Long nhận <a href="' . $svc . '">nạp sạc bình chữa cháy</a> bột ABC, CO2 cho cửa hàng, tòa nhà, nhà xưởng: thu gom tận nơi, có bình cho mượn dùng tạm trong thời gian nạp, trả bình kèm tem và biên bản đầy đủ. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để nhận báo giá nhanh.</p>
',
	),

	array(
		'slug'     => 'quy-dinh-lap-dat-den-exit',
		'title'    => 'Quy định lắp đặt đèn exit, đèn chiếu sáng sự cố mới nhất',
		'keyword'  => 'quy định lắp đặt đèn exit',
		'seo_desc' => 'Quy định lắp đặt đèn exit và đèn chiếu sáng sự cố: vị trí, độ cao, thời gian chiếu sáng theo TCVN. Cung cấp và thi công trọn gói: 0798 285 114.',
		'body'     => '
<p>Nắm rõ <strong>quy định lắp đặt đèn exit</strong> và đèn chiếu sáng sự cố giúp công trình qua nghiệm thu PCCC và quan trọng hơn là dẫn người thoát nạn an toàn khi mất điện, có khói. Bài viết tổng hợp các yêu cầu cần nhớ khi thi công.</p>

<h2>Quy định lắp đặt đèn exit (đèn chỉ dẫn thoát nạn)</h2>
<ul>
<li><strong>Vị trí:</strong> phía trên cửa ra vào của lối thoát nạn, cửa buồng thang bộ, các điểm rẽ hành lang — người ở bất kỳ vị trí nào cũng nhìn thấy đèn dẫn hướng gần nhất.</li>
<li><strong>Độ cao treo:</strong> mép dưới đèn thường cách sàn 2–2,7 m; hành lang dài phải bổ sung đèn chỉ hướng (mũi tên) để khoảng cách nhìn thấy không bị đứt quãng.</li>
<li><strong>Loại đèn:</strong> hành lang hai hướng dùng <a href="' . $shop . '">đèn exit hai mặt</a>; trên cửa dùng đèn một mặt. Ký hiệu hình người chạy và mũi tên theo tiêu chuẩn.</li>
<li><strong>Nguồn dự phòng:</strong> đèn phải có ắc quy tự sạc, duy trì sáng tối thiểu theo tiêu chuẩn (thường ≥ 2 giờ) khi mất điện lưới.</li>
</ul>

<h2>Quy định đèn chiếu sáng sự cố (emergency)</h2>
<ul>
<li>Lắp tại hành lang, buồng thang bộ, sảnh, phòng máy, khu vực đông người — bảo đảm độ rọi tối thiểu trên đường thoát nạn khi mất điện.</li>
<li>Đèn tự bật khi mất nguồn, thời gian chiếu sáng dự phòng tối thiểu theo TCVN (thường ≥ 2 giờ).</li>
<li>Bố trí sao cho không có đoạn đường thoát nạn nào tối hoàn toàn, đặc biệt tại các bậc thang, điểm đổi hướng.</li>
</ul>

<h2>Kiểm tra, bảo dưỡng định kỳ</h2>
<p>Đèn exit, đèn sự cố phải được kiểm tra định kỳ: thử cắt điện xem đèn có tự sáng không, thời gian sáng còn đạt không, thay ắc quy chai phồng. Hạng mục này nằm trong gói <a href="' . $home . '/bao-tri-he-thong-pccc/">bảo trì hệ thống PCCC</a> hằng quý/năm của tòa nhà.</p>

<h2>Cung cấp và lắp đặt đèn exit, đèn sự cố</h2>
<p>PCCC Phước Long cung cấp <a href="' . $shop . '">đèn exit, đèn chiếu sáng sự cố Kentom</a> chính hãng và <a href="' . $svc . '">thi công lắp đặt</a> đúng tiêu chuẩn nghiệm thu cho văn phòng, nhà xưởng, chung cư. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để được khảo sát, báo giá miễn phí.</p>
',
	),

	array(
		'slug'     => 'pccc-nha-o-ket-hop-kinh-doanh',
		'title'    => 'PCCC cho nhà ở kết hợp kinh doanh: quy định & giải pháp',
		'keyword'  => 'PCCC cho nhà ở kết hợp kinh doanh',
		'seo_desc' => 'PCCC cho nhà ở kết hợp kinh doanh: quy định bắt buộc, lối thoát nạn thứ 2, thiết bị cần trang bị. Tư vấn giải pháp trọn gói: 0798 285 114.',
		'body'     => '
<p><strong>PCCC cho nhà ở kết hợp kinh doanh</strong> đang được siết chặt sau nhiều vụ cháy gây hậu quả nghiêm trọng. Nhà vừa ở vừa buôn bán tiềm ẩn nguy cơ kép: hàng hóa dễ cháy ở tầng dưới, người ngủ ở tầng trên, thường chỉ có một lối ra.</p>

<h2>Quy định PCCC cho nhà ở kết hợp kinh doanh</h2>
<ul>
<li>Khu vực kinh doanh phải <strong>ngăn cách với khu vực ở</strong> bằng tường, vách ngăn cháy; không để hàng hóa chặn cầu thang, lối đi.</li>
<li>Phải có <strong>lối thoát nạn thứ 2</strong>: qua ban công, lô gia, cầu thang ngoài nhà hoặc lên mái sang nhà bên. "Chuồng cọp" phải mở ô cửa thoát hiểm có khóa trong.</li>
<li>Không câu mắc điện tùy tiện; thiết bị điện khu bán hàng phải có aptomat riêng, tắt nguồn khi đóng cửa.</li>
<li>Trang bị phương tiện chữa cháy tại chỗ và cam kết bảo đảm an toàn PCCC theo yêu cầu của công an khu vực.</li>
</ul>

<h2>Thiết bị PCCC tối thiểu nên trang bị</h2>
<ul>
<li><a href="' . $shop . '">Bình chữa cháy</a> bột ABC đặt ở mỗi tầng và gần khu vực hàng hóa; biết <a href="' . $home . '/cach-su-dung-binh-chua-chay/">cách sử dụng bình chữa cháy</a> đúng kỹ thuật.</li>
<li><a href="' . $shop . '">Đầu báo khói độc lập</a> tại khu hàng hóa, cầu thang và phòng ngủ — phát hiện cháy ngay khi cả nhà đang ngủ.</li>
<li><strong>Bình cầu chữa cháy tự động</strong> treo tại kho hàng, khu vực ít người qua lại — tự phun bột khi nhiệt độ tăng cao.</li>
<li>Đèn sự cố, dụng cụ phá dỡ (búa, kìm cộng lực) và thang dây nếu nhà nhiều tầng.</li>
</ul>

<h2>Xây dựng phương án thoát nạn cho gia đình</h2>
<p>Thống nhất trước với cả nhà: cháy ở tầng trệt thì thoát lối nào, cháy chặn cầu thang thì lên đâu, ai bế trẻ nhỏ, điểm tập kết ở đâu. Tham khảo bài <a href="' . $home . '/ky-nang-thoat-hiem-khi-chay/">kỹ năng thoát hiểm khi cháy</a> để luyện tập định kỳ.</p>

<h2>Tư vấn giải pháp PCCC trọn gói cho nhà ở kết hợp kinh doanh</h2>
<p>PCCC Phước Long khảo sát tận nơi, <a href="' . $svc . '">tư vấn giải pháp và lắp đặt thiết bị</a> phù hợp diện tích, ngành hàng và ngân sách — từ bình chữa cháy, đầu báo khói đến hệ báo cháy hoàn chỉnh. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để được tư vấn miễn phí.</p>
',
	),

	array(
		'slug'     => 'hong-nuoc-chua-chay-vach-tuong',
		'title'    => 'Họng nước chữa cháy vách tường: cấu tạo, quy định & cách dùng',
		'keyword'  => 'họng nước chữa cháy vách tường',
		'seo_desc' => 'Họng nước chữa cháy vách tường gồm những gì, quy định lắp đặt và cách sử dụng đúng? Cung cấp vòi, lăng phun, tủ chữa cháy chính hãng: 0798 285 114.',
		'body'     => '
<p><strong>Họng nước chữa cháy vách tường</strong> là phương tiện chữa cháy cơ bản của mọi nhà xưởng, tòa nhà — cho phép người tại chỗ dập đám cháy lớn hơn khả năng của bình xách tay trong lúc chờ lực lượng chuyên nghiệp.</p>

<h2>Họng nước chữa cháy vách tường gồm những gì?</h2>
<ul>
<li><strong>Van góc chữa cháy</strong> DN50/DN65 đấu vào trục cấp nước chữa cháy của tòa nhà.</li>
<li><a href="' . $shop . '">Cuộn vòi chữa cháy</a> DN50 hoặc DN65, dài 20–30 m, kèm khớp nối.</li>
<li><strong>Lăng phun</strong> (đầu phun cầm tay) tạo tia nước đặc hoặc phun sương.</li>
<li><strong>Tủ chữa cháy</strong> âm tường hoặc nổi chứa toàn bộ thiết bị, sơn đỏ, có ký hiệu rõ ràng.</li>
</ul>

<h2>Quy định lắp đặt họng nước chữa cháy vách tường</h2>
<ul>
<li>Bố trí tại lối đi, sảnh, hành lang, gần cửa ra vào từng tầng — tâm họng cao khoảng 1,25 m so với sàn.</li>
<li>Số lượng và vị trí tính theo nguyên tắc <strong>mọi điểm trong nhà đều được ít nhất một tia nước vươn tới</strong> (công trình quan trọng yêu cầu hai tia).</li>
<li>Lưu lượng, áp suất tại lăng phun phải đạt theo QCVN/TCVN; hệ thống đấu với máy bơm chữa cháy và bể nước dự trữ của công trình.</li>
<li>Vòi không được gấp gãy, mục; van không rò rỉ — phải kiểm tra, tráo cuộn vòi định kỳ trong các kỳ <a href="' . $home . '/bao-tri-he-thong-pccc/">bảo trì hệ thống PCCC</a>.</li>
</ul>

<h2>Cách sử dụng họng nước vách tường khi có cháy</h2>
<ol>
<li>Mở tủ, rải cuộn vòi về phía đám cháy, tránh để vòi xoắn gập.</li>
<li>Lắp khớp nối vòi vào van góc và lắp lăng phun vào đầu còn lại.</li>
<li>Một người giữ chắc lăng phun hướng về gốc lửa, người kia mở van từ từ.</li>
<li>Phun vào gốc đám cháy; <strong>tuyệt đối không phun nước vào thiết bị điện chưa cắt nguồn</strong>.</li>
</ol>

<h2>Cung cấp vòi, lăng phun, tủ chữa cháy chính hãng</h2>
<p>PCCC Phước Long cung cấp <a href="' . $shop . '">vòi chữa cháy, lăng phun, tủ chữa cháy</a> đạt kiểm định và nhận <a href="' . $svc . '">thi công, thay thế, bảo trì</a> hệ họng nước vách tường cho nhà xưởng, tòa nhà. <a href="' . $contact . '">Liên hệ</a> hoặc gọi <strong>0798 285 114</strong> để được báo giá nhanh.</p>
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
