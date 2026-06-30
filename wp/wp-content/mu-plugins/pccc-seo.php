<?php
/**
 * Plugin Name: PCCC Phước Long — SEO Seeder (Rank Math)
 * Description: Ghi sẵn tiêu đề / mô tả / từ khoá SEO (Rank Math) cho các trang cố định.
 * Version: 1.1.0
 *
 * Rank Math lưu dữ liệu SEO dưới dạng post meta:
 *   rank_math_title           — Tiêu đề SEO (<title>)
 *   rank_math_description     — Meta description
 *   rank_math_focus_keyword   — Từ khoá chính
 *   rank_math_robots          — Mảng robots, ví dụ ['noindex'] cho trang không nên index
 *
 * Quy ước nội dung để qua phần lớn cảnh báo Rank Math:
 *   - Tiêu đề SEO BẮT ĐẦU bằng từ khoá chính (đạt "từ khoá ở đầu tiêu đề").
 *   - Tiêu đề SEO chứa SỐ (năm / số điện thoại / số dự án).
 *   - Mô tả Meta CHỨA từ khoá chính.
 * (Các tiêu chí còn lại — số từ ≥600, hình ảnh + alt, H2/H3, link ngoài,
 *  mật độ từ khoá — phụ thuộc NỘI DUNG trang, phải sửa trong trình soạn thảo.)
 *
 * Cơ chế chạy:
 *   - Tự chạy 1 lần theo version: chỉ ghi vào ô CÒN TRỐNG (không đụng chỉnh tay).
 *   - ?pccc_seo_reseed=1 (cần quyền quản trị): GHI ĐÈ để áp bản copy mới nhất.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const PCCC_SEO_VERSION = '1.1.0';

/**
 * Nội dung SEO cho từng trang — chỉ cần sửa mảng này.
 * Khoá theo slug (post_name) để không phụ thuộc ID.
 */
function pccc_seo_page_map() {
	return array(
		// Trang chủ — kw ở đầu tiêu đề, số = 2026, kw trong mô tả.
		'trang-chu' => array(
			'title'   => 'PCCC Phước Long — Thiết kế, Thi công, Bảo trì hệ thống PCCC 2026',
			'desc'    => 'PCCC Phước Long chuyên thiết kế, thi công, thẩm duyệt và bảo trì hệ thống phòng cháy chữa cháy. Tư vấn miễn phí, báo giá trong 24h: 0798 285 114.',
			'keyword' => 'PCCC Phước Long',
		),
		// Giới thiệu
		'gioi-thieu' => array(
			'title'   => 'Giới thiệu PCCC Phước Long — Hơn 10 năm kinh nghiệm thi công',
			'desc'    => 'Giới thiệu PCCC Phước Long: đội ngũ kỹ sư hơn 10 năm kinh nghiệm, năng lực thi công hệ thống phòng cháy chữa cháy đạt tiêu chuẩn.',
			'keyword' => 'giới thiệu PCCC Phước Long',
		),
		// Dịch vụ
		'dich-vu' => array(
			'title'   => 'Dịch vụ PCCC trọn gói 2026 — Thiết kế, Thi công, Bảo trì',
			'desc'    => 'Dịch vụ PCCC trọn gói: tư vấn thiết kế, thi công lắp đặt, thẩm duyệt và bảo trì hệ thống phòng cháy chữa cháy cho hơn 100 công trình.',
			'keyword' => 'dịch vụ PCCC',
		),
		// Năng lực
		'nang-luc' => array(
			'title'   => 'Năng lực PCCC Phước Long — Hơn 100 dự án đã thi công',
			'desc'    => 'Năng lực PCCC: hồ sơ pháp lý đầy đủ, đội ngũ kỹ sư và hơn 100 dự án phòng cháy chữa cháy đã hoàn thành cùng PCCC Phước Long.',
			'keyword' => 'năng lực PCCC',
		),
		// Liên hệ — số = hotline.
		'lien-he' => array(
			'title'   => 'Liên hệ PCCC Phước Long — Hotline 0798 285 114',
			'desc'    => 'Liên hệ PCCC Phước Long để được tư vấn và báo giá hệ thống phòng cháy chữa cháy trong 24h. Hotline / Zalo: 0798 285 114.',
			'keyword' => 'liên hệ PCCC Phước Long',
		),
		// Tin tức
		'tin-tuc' => array(
			'title'   => 'Tin tức PCCC 2026 — Kiến thức & Quy định phòng cháy chữa cháy',
			'desc'    => 'Tin tức PCCC mới nhất 2026: cập nhật kiến thức, quy định và hướng dẫn phòng cháy chữa cháy từ Công ty PCCC Phước Long.',
			'keyword' => 'tin tức PCCC',
		),
		// Giỏ hàng / yêu cầu báo giá — không cho Google index (không cần phân tích từ khoá).
		'gio-hang' => array(
			'title'   => 'Giỏ hàng / Yêu cầu báo giá | PCCC Phước Long',
			'desc'    => 'Danh sách sản phẩm bạn quan tâm — gửi yêu cầu báo giá tới PCCC Phước Long.',
			'keyword' => '',
			'robots'  => array( 'noindex', 'nofollow' ),
		),
	);
}

/**
 * Ghi meta cho 1 trang.
 *
 * @param int  $post_id ID trang.
 * @param array $data    Dữ liệu SEO.
 * @param bool $force    true = ghi đè; false = chỉ ghi khi ô còn trống.
 */
function pccc_seo_seed_post( $post_id, $data, $force = false ) {
	$fields = array(
		'rank_math_title'         => $data['title'] ?? '',
		'rank_math_description'   => $data['desc'] ?? '',
		'rank_math_focus_keyword' => $data['keyword'] ?? '',
	);

	foreach ( $fields as $key => $value ) {
		if ( '' === $value ) {
			continue;
		}
		$existing = get_post_meta( $post_id, $key, true );
		if ( $force || '' === $existing || null === $existing || false === $existing ) {
			update_post_meta( $post_id, $key, $value );
		}
	}

	if ( ! empty( $data['robots'] ) ) {
		$existing = get_post_meta( $post_id, 'rank_math_robots', true );
		if ( $force || empty( $existing ) ) {
			update_post_meta( $post_id, 'rank_math_robots', $data['robots'] );
		}
	}
}

/**
 * Chạy seeder. Tự chạy 1 lần theo version (chỉ ô trống),
 * hoặc ?pccc_seo_reseed=1 để GHI ĐÈ áp bản mới.
 */
function pccc_seo_maybe_seed() {
	if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$reseed = isset( $_GET['pccc_seo_reseed'] );
	$seeded = get_option( 'pccc_seo_seeded' );

	if ( ! $reseed && $seeded === PCCC_SEO_VERSION ) {
		return;
	}

	// Chạy thủ công qua query = ghi đè; chạy tự động theo version = chỉ ô trống.
	$force = $reseed;

	foreach ( pccc_seo_page_map() as $slug => $data ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $page instanceof WP_Post ) {
			pccc_seo_seed_post( $page->ID, $data, $force );
		}
	}

	update_option( 'pccc_seo_seeded', PCCC_SEO_VERSION );
}
add_action( 'admin_init', 'pccc_seo_maybe_seed' );
