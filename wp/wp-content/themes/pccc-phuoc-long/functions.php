<?php
/**
 * PCCC Phước Long — theme functions.
 *
 * @package pccc-phuoc-long
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'pccc_pl_setup' ) ) {
	function pccc_pl_setup() {
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

		register_nav_menus(
			array(
				'primary' => __( 'Menu chính', 'pccc-phuoc-long' ),
				'footer'  => __( 'Menu chân trang', 'pccc-phuoc-long' ),
			)
		);
	}
}
add_action( 'after_setup_theme', 'pccc_pl_setup' );

/**
 * Enqueue styles + brand font.
 */
function pccc_pl_assets() {
	// Be Vietnam Pro — Vietnamese-friendly brand font (graceful fallback to system-ui).
	wp_enqueue_style(
		'pccc-pl-font',
		'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=Lexend:wght@500;600;700;800&display=swap',
		array(),
		null
	);
	wp_enqueue_style(
		'pccc-pl-style',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);
	$extra_path = get_theme_file_path( 'assets/extra.css' );
	wp_enqueue_style(
		'pccc-pl-extra',
		get_theme_file_uri( 'assets/extra.css' ),
		array( 'pccc-pl-style' ),
		file_exists( $extra_path ) ? filemtime( $extra_path ) : wp_get_theme()->get( 'Version' )
	);

	// Mega menu danh mục sản phẩm (hover desktop + drawer mobile).
	$menu_js = get_theme_file_path( 'assets/menu.js' );
	wp_enqueue_script(
		'pccc-pl-menu',
		get_theme_file_uri( 'assets/menu.js' ),
		array(),
		file_exists( $menu_js ) ? filemtime( $menu_js ) : wp_get_theme()->get( 'Version' ),
		true
	);

	// Giỏ hàng / yêu cầu báo giá (client-side, lưu localStorage).
	wp_enqueue_script(
		'pccc-pl-cart',
		get_theme_file_uri( 'assets/cart.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
	$phone = '0798285114';
	wp_localize_script( 'pccc-pl-cart', 'PCCC_CART', array(
		'phone'   => $phone,
		'zalo'    => 'https://zalo.me/' . $phone,
		'cartUrl' => home_url( '/gio-hang/' ),
		'site'    => get_bloginfo( 'name' ),
		'domain'  => wp_parse_url( home_url(), PHP_URL_HOST ),
	) );
}
add_action( 'wp_enqueue_scripts', 'pccc_pl_assets' );

/**
 * Nút "Thêm vào giỏ" — chèn ngay sau tiêu đề mỗi sản phẩm (sanpham),
 * cả trong lưới sản phẩm lẫn trang chi tiết.
 */
function pccc_pl_add_cart_button( $content, $block ) {
	if ( ( $block['blockName'] ?? '' ) !== 'core/post-title' ) {
		return $content;
	}
	if ( get_post_type() !== 'sanpham' ) {
		return $content;
	}
	$id = get_the_ID();
	if ( ! $id ) {
		return $content;
	}
	$is_single = is_singular( 'sanpham' );
	$cls   = $is_single ? 'pccc-add-cart pccc-add-cart--lg' : 'pccc-add-cart';
	$label = $is_single ? 'Thêm vào giỏ yêu cầu báo giá' : '+ Thêm vào giỏ';

	$cart_svg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>';

	$btn = sprintf(
		'<button type="button" class="%s" data-id="%d" data-name="%s" data-url="%s">%s%s</button>',
		esc_attr( $cls ),
		(int) $id,
		esc_attr( get_the_title( $id ) ),
		esc_url( get_permalink( $id ) ),
		$cart_svg,
		esc_html( $label )
	);

	return $content . $btn;
}
add_filter( 'render_block', 'pccc_pl_add_cart_button', 10, 2 );

/**
 * Ảnh đại diện mặc định — sản phẩm/dự án chưa có ảnh sẽ hiện placeholder
 * với biểu tượng web (icon ảnh) thay vì để trống.
 */
function pccc_pl_featured_image_placeholder( $content, $block ) {
	if ( ( $block['blockName'] ?? '' ) !== 'core/post-featured-image' ) {
		return $content;
	}
	// Đã có ảnh thật -> giữ nguyên.
	if ( trim( (string) $content ) !== '' ) {
		return $content;
	}

	$id = get_the_ID();
	if ( ! $id ) {
		return $content;
	}

	$is_link = ! empty( $block['attrs']['isLink'] );
	$height  = $block['attrs']['height'] ?? '';
	$style   = $height ? ' style="height:' . esc_attr( $height ) . '"' : '';

	// Icon ảnh (web icon) dạng SVG nội tuyến.
	$icon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><path d="M21 15l-5-5L5 21"></path></svg>';

	$inner = '<span class="pccc-img-placeholder__icon">' . $icon . '</span>';

	if ( $is_link ) {
		return sprintf(
			'<a href="%s" class="pccc-img-placeholder wp-block-post-featured-image"%s aria-label="%s">%s</a>',
			esc_url( get_permalink( $id ) ),
			$style,
			esc_attr( get_the_title( $id ) ),
			$inner
		);
	}

	return sprintf(
		'<div class="pccc-img-placeholder wp-block-post-featured-image"%s>%s</div>',
		$style,
		$inner
	);
}
add_filter( 'render_block', 'pccc_pl_featured_image_placeholder', 10, 2 );

/**
 * Đánh dấu mục menu của trang hiện tại (current-menu-item).
 * Menu dùng link kiểu "custom" (không có id) nên core không tự gắn class này.
 */
function pccc_pl_nav_current_item( $content, $block ) {
	if ( ( $block['blockName'] ?? '' ) !== 'core/navigation-link' ) {
		return $content;
	}
	$url = $block['attrs']['url'] ?? '';
	if ( '' === $url ) {
		return $content;
	}

	$link_path = rtrim( (string) wp_parse_url( $url, PHP_URL_PATH ), '/' );
	$cur_path  = rtrim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH ), '/' );

	// Trang chủ so khớp tuyệt đối; các mục khác khớp cả trang con (vd /san-pham/binh-abc).
	$active = ( $link_path === $cur_path )
		|| ( '' !== $link_path && str_starts_with( $cur_path . '/', $link_path . '/' ) );

	// Bài viết / chuyên mục tin tức không nằm dưới /tin-tuc/ nhưng vẫn thuộc mục Tin tức.
	if ( ! $active && '/tin-tuc' === $link_path && ( is_home() || is_singular( 'post' ) || is_category() || is_tag() ) ) {
		$active = true;
	}

	if ( ! $active ) {
		return $content;
	}

	$processor = new WP_HTML_Tag_Processor( $content );
	if ( $processor->next_tag( 'li' ) ) {
		$processor->add_class( 'current-menu-item' );
		$content = $processor->get_updated_html();
	}
	return $content;
}
add_filter( 'render_block', 'pccc_pl_nav_current_item', 10, 2 );

/**
 * Mega menu danh mục sản phẩm — dựng cây danh mục (danh_muc_sp) thành panel:
 * desktop hover hiện panel nhiều cột; mobile là drawer cấp 2 (menu.js điều khiển).
 */
function pccc_pl_mega_menu_html() {
	$terms = get_terms(
		array(
			'taxonomy'   => 'danh_muc_sp',
			'hide_empty' => true,
		)
	);
	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return '';
	}

	$by_parent = array();
	foreach ( $terms as $t ) {
		$by_parent[ $t->parent ][] = $t;
	}
	if ( empty( $by_parent[0] ) ) {
		return '';
	}

	$item = static function ( $term ) {
		return sprintf(
			'<a href="%s">%s</a>',
			esc_url( get_term_link( $term ) ),
			esc_html( wp_specialchars_decode( $term->name ) )
		);
	};

	$render_children = static function ( $parent_id ) use ( &$render_children, $by_parent, $item ) {
		if ( empty( $by_parent[ $parent_id ] ) ) {
			return '';
		}
		$out = '<ul class="pccc-mega__list">';
		foreach ( $by_parent[ $parent_id ] as $t ) {
			$out .= '<li>' . $item( $t ) . $render_children( $t->term_id ) . '</li>';
		}
		return $out . '</ul>';
	};

	$cols = '';
	foreach ( $by_parent[0] as $t ) {
		$cols .= '<div class="pccc-mega__col">'
			. '<a class="pccc-mega__head" href="' . esc_url( get_term_link( $t ) ) . '">'
			. esc_html( wp_specialchars_decode( $t->name ) ) . '</a>'
			. $render_children( $t->term_id )
			. '</div>';
	}

	return '<div class="pccc-mega" aria-label="Danh mục sản phẩm">'
		. '<div class="pccc-mega__bar">'
		. '<button type="button" class="pccc-mega__back">‹ Quay lại</button>'
		. '<a class="pccc-mega__all" href="' . esc_url( home_url( '/san-pham/' ) ) . '">Tất cả sản phẩm <span aria-hidden="true">→</span></a>'
		. '</div>'
		. '<div class="pccc-mega__grid">' . $cols . '</div>'
		. '</div>';
}

/**
 * Gắn mega menu vào mục "Sản phẩm" của navigation.
 */
function pccc_pl_nav_product_mega( $content, $block ) {
	if ( ( $block['blockName'] ?? '' ) !== 'core/navigation-link' ) {
		return $content;
	}
	$path = rtrim( (string) wp_parse_url( $block['attrs']['url'] ?? '', PHP_URL_PATH ), '/' );
	if ( '/san-pham' !== $path ) {
		return $content;
	}

	$panel = pccc_pl_mega_menu_html();
	if ( '' === $panel ) {
		return $content;
	}

	$processor = new WP_HTML_Tag_Processor( $content );
	if ( ! $processor->next_tag( 'li' ) ) {
		return $content;
	}
	$processor->add_class( 'pccc-has-mega' );
	$content = $processor->get_updated_html();

	$pos = strrpos( $content, '</li>' );
	if ( false === $pos ) {
		return $content;
	}
	return substr( $content, 0, $pos ) . $panel . substr( $content, $pos );
}
add_filter( 'render_block', 'pccc_pl_nav_product_mega', 10, 2 );

/**
 * Shortcode [pccc_cart] — khung trang giỏ hàng (JS sẽ dựng nội dung).
 */
function pccc_pl_cart_shortcode() {
	return '<div id="pccc-cart-root"><p style="text-align:center;color:#5B6B86">Đang tải giỏ hàng…</p></div>';
}
add_shortcode( 'pccc_cart', 'pccc_pl_cart_shortcode' );

/**
 * Register block pattern category.
 */
function pccc_pl_pattern_categories() {
	register_block_pattern_category(
		'pccc',
		array( 'label' => __( 'PCCC Phước Long', 'pccc-phuoc-long' ) )
	);
}
add_action( 'init', 'pccc_pl_pattern_categories' );

/**
 * Floating call / Zalo buttons (site-wide).
 */
function pccc_pl_float_buttons() {
	$cart_svg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>';
	echo '<div class="pccc-float">'
		. '<a class="pccc-cart-fab" href="' . esc_url( home_url( '/gio-hang/' ) ) . '" title="Giỏ hàng / Yêu cầu báo giá" aria-label="Giỏ hàng">' . $cart_svg . '<span class="pccc-cart-badge">0</span></a>'
		. '<a class="pccc-phone" href="tel:0798285114" title="Gọi ngay 079 8285 114" aria-label="Gọi điện">GỌI<br>NGAY</a>'
		. '<a class="pccc-zalo" href="https://zalo.me/0798285114" target="_blank" rel="noopener" title="Chat Zalo" aria-label="Chat Zalo">Zalo</a>'
		. '</div>';
}
add_action( 'wp_footer', 'pccc_pl_float_buttons' );
