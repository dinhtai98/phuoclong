<?php
/**
 * Import sản phẩm (CPT `sanpham`) từ CSV — KHÔNG cần WP All Import Pro.
 * Chạy bằng WP-CLI (bạn đã có sẵn ~/bin/wp):
 *
 *   ~/bin/wp eval-file scripts/import-products.php sanpham-import.csv --path=wp
 *
 * CSV phải đúng định dạng từ convert-products-csv.py:
 *   post_title, danh_muc, sku, xuat_xu, don_vi_tinh, post_content, image_url, link_tham_khao
 *
 * - Chạy lại nhiều lần an toàn: trùng SKU (hoặc trùng tên nếu không có SKU) -> cập nhật, không tạo bản sao.
 * - Ảnh: tải về từ image_url (nhiều ảnh ngăn bởi `|`, ảnh đầu làm featured image). Chỉ tải nếu sản phẩm chưa có ảnh.
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	fwrite( STDERR, "Script này phải chạy bằng WP-CLI: wp eval-file scripts/import-products.php <file.csv>\n" );
	exit( 1 );
}

$csv = $args[0] ?? ( getenv( 'PRODUCTS_CSV' ) ?: 'sanpham-import.csv' );
if ( ! file_exists( $csv ) ) {
	WP_CLI::error( "Không tìm thấy file CSV: $csv" );
}

// Cần cho việc tải ảnh về media library.
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$fh = fopen( $csv, 'r' );
if ( ! $fh ) {
	WP_CLI::error( "Không mở được file: $csv" );
}

$header = fgetcsv( $fh );
if ( ! $header ) {
	WP_CLI::error( 'CSV rỗng.' );
}
$header[0] = preg_replace( '/^\xEF\xBB\xBF/', '', $header[0] ); // bỏ BOM nếu còn
$col       = array_flip( $header );

$created  = 0;
$updated  = 0;
$img_ok   = 0;
$img_err  = 0;
$sitename = get_bloginfo( 'name' );

// ---- Cấu hình tối ưu SEO (đổi true/false tuỳ ý) ----
$SEO_KW_HEADING   = true; // chèn <h2> chứa từ khoá lên đầu nội dung (qua check "từ khoá trong H2 / đầu nội dung")
$SEO_INLINE_IMAGE = true; // nhúng 1 ảnh vào nội dung kèm alt = từ khoá (qua check "ảnh có alt là từ khoá")
$SEO_INTERNAL     = true; // thêm liên kết nội bộ (danh mục + trang liên hệ)
$SEO_OVERWRITE    = true; // ghi đè SEO mỗi lần chạy; đặt false nếu bạn đã chỉnh SEO bằng tay trong Rank Math
$contact_url      = home_url( '/lien-he/' );

while ( ( $row = fgetcsv( $fh ) ) !== false ) {
	$get = function ( $key ) use ( $row, $col ) {
		return isset( $col[ $key ], $row[ $col[ $key ] ] ) ? trim( $row[ $col[ $key ] ] ) : '';
	};

	$title = $get( 'post_title' );
	if ( '' === $title ) {
		continue; // bỏ dòng trống
	}
	$sku = $get( 'sku' );

	// Tìm sản phẩm đã tồn tại để tránh tạo trùng.
	$existing = 0;
	if ( '' !== $sku ) {
		$q = new WP_Query( array(
			'post_type'      => 'sanpham',
			'post_status'    => 'any',
			'meta_key'       => 'sku',
			'meta_value'     => $sku,
			'fields'         => 'ids',
			'posts_per_page' => 1,
			'no_found_rows'  => true,
		) );
		$existing = $q->posts[0] ?? 0;
	}
	if ( ! $existing ) {
		$q = new WP_Query( array(
			'post_type'      => 'sanpham',
			'post_status'    => 'any',
			'title'          => $title,
			'fields'         => 'ids',
			'posts_per_page' => 1,
			'no_found_rows'  => true,
		) );
		$existing = $q->posts[0] ?? 0;
	}

	// ---- Dữ liệu cho SEO ----
	$dm = $get( 'danh_muc' );
	$kw = $get( 'focus_keyword' );
	if ( '' === $kw ) {
		$kw = $title; // chưa có cột focus_keyword -> dùng tên sản phẩm
	}

	// Bảo đảm có term danh mục (để lấy link nội bộ tới trang danh mục).
	$cat_url = '';
	if ( '' !== $dm ) {
		$term = term_exists( $dm, 'danh_muc_sp' );
		if ( ! $term ) {
			$term = wp_insert_term( $dm, 'danh_muc_sp' );
		}
		if ( ! is_wp_error( $term ) ) {
			$tid  = is_array( $term ) ? (int) $term['term_id'] : (int) $term;
			$link = get_term_link( $tid, 'danh_muc_sp' );
			if ( ! is_wp_error( $link ) ) {
				$cat_url = $link;
			}
		}
	}

	$first_img = '';
	if ( '' !== $get( 'image_url' ) ) {
		$first_img = trim( explode( '|', $get( 'image_url' ) )[0] );
	}

	// ---- Dựng nội dung tối ưu SEO ----
	$blocks = array();
	if ( $SEO_KW_HEADING ) {
		$blocks[] = '<!-- wp:heading --><h2>' . esc_html( $kw ) . '</h2><!-- /wp:heading -->';
	}
	if ( $SEO_INLINE_IMAGE && '' !== $first_img ) {
		$blocks[] = '<!-- wp:image --><figure class="wp-block-image size-large"><img src="'
			. esc_url( $first_img ) . '" alt="' . esc_attr( $kw ) . '"/></figure><!-- /wp:image -->';
	}
	$blocks[] = $get( 'post_content' );
	if ( $SEO_INTERNAL ) {
		$links = array();
		if ( '' !== $cat_url ) {
			$links[] = 'Xem thêm sản phẩm cùng nhóm: <a href="' . esc_url( $cat_url ) . '">' . esc_html( $dm ) . '</a>';
		}
		$links[] = '<a href="' . esc_url( $contact_url ) . '">Liên hệ tư vấn &amp; báo giá</a>';
		$ext     = $get( 'external_link' ); // liên kết ngoài (tuỳ chọn, chỉ khi CSV có cột này)
		if ( '' !== $ext ) {
			$links[] = 'Tài liệu kỹ thuật: <a href="' . esc_url( $ext ) . '" target="_blank" rel="noopener">tham khảo</a>';
		}
		$blocks[] = '<!-- wp:paragraph --><p>' . implode( ' · ', $links ) . '</p><!-- /wp:paragraph -->';
	}
	$content_final = implode( "\n\n", $blocks );

	$postarr = array(
		'post_type'    => 'sanpham',
		'post_status'  => 'publish',
		'post_title'   => $title,
		'post_content' => $content_final,
	);

	if ( $existing ) {
		$postarr['ID'] = $existing;
		$id            = wp_update_post( $postarr, true );
		$updated++;
	} else {
		$id = wp_insert_post( $postarr, true );
		$created++;
	}

	if ( is_wp_error( $id ) ) {
		WP_CLI::warning( "Lỗi lưu \"$title\": " . $id->get_error_message() );
		continue;
	}

	// Danh mục -> taxonomy danh_muc_sp.
	if ( '' !== $dm ) {
		wp_set_object_terms( $id, $dm, 'danh_muc_sp', false );
	}

	// Custom fields.
	foreach ( array( 'sku', 'xuat_xu', 'don_vi_tinh', 'link_tham_khao' ) as $f ) {
		$v = $get( $f );
		if ( '' !== $v ) {
			update_post_meta( $id, $f, $v );
		}
	}

	// ---- SEO (Rank Math) ----
	// $set_seo: ghi nếu được phép đè ($SEO_OVERWRITE) hoặc field còn trống.
	$set_seo = function ( $key, $value ) use ( $id, $SEO_OVERWRITE ) {
		if ( '' === $value ) {
			return;
		}
		if ( $SEO_OVERWRITE || ! get_post_meta( $id, $key, true ) ) {
			update_post_meta( $id, $key, $value );
		}
	};

	// Focus keyword.
	$set_seo( 'rank_math_focus_keyword', $kw );

	// SEO title.
	$seo_title = $get( 'seo_title' );
	if ( '' === $seo_title ) {
		$seo_title = $title . ' | ' . $sitename;
	}
	$set_seo( 'rank_math_title', $seo_title );

	// Meta description — luôn bắt đầu bằng từ khoá (qua check "từ khoá trong meta description").
	$seo_desc = $get( 'seo_description' );
	if ( '' === $seo_desc ) {
		$plain = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( $get( 'post_content' ) ) ) );
		// Bỏ phần đầu trùng nếu mô tả đã mở đầu gần giống từ khoá, rồi ghép "từ khoá – mô tả".
		$seo_desc = $kw . ' – ' . $plain;
		$seo_desc = mb_substr( $seo_desc, 0, 158 );
	}
	$set_seo( 'rank_math_description', $seo_desc );

	// Ảnh đại diện — chỉ xử lý nếu sản phẩm chưa có ảnh.
	if ( '' !== $first_img && ! has_post_thumbnail( $id ) ) {
		// Ưu tiên dùng lại ảnh đã có trong Media Library (tránh tải trùng trên production).
		$aid = attachment_url_to_postid( $first_img );
		if ( ! $aid ) {
			$aid = media_sideload_image( $first_img, $id, $title, 'id' ); // chưa có -> tải về
		}
		if ( is_wp_error( $aid ) || ! $aid ) {
			$img_err++;
			$msg = is_wp_error( $aid ) ? $aid->get_error_message() : 'không tải/không tìm thấy';
			WP_CLI::warning( "Ảnh lỗi ($first_img): $msg" );
		} else {
			set_post_thumbnail( $id, $aid );
			update_post_meta( $aid, '_wp_attachment_image_alt', $kw ); // alt = từ khoá
			$img_ok++;
		}
	}

	WP_CLI::log( "✓ $title (ID $id)" );
}

fclose( $fh );
WP_CLI::success( "Tạo mới $created, cập nhật $updated sản phẩm. Ảnh: $img_ok ok, $img_err lỗi." );
