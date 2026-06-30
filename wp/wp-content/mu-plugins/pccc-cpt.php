<?php
/**
 * Plugin Name: PCCC Phước Long — Custom Post Types
 * Description: Đăng ký CPT Dự án & Sản phẩm + taxonomy cho website PCCC Phước Long.
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {

	// ---------- CPT: Dự án ----------
	register_post_type( 'duan', array(
		'labels' => array(
			'name'          => 'Dự án',
			'singular_name' => 'Dự án',
			'add_new_item'  => 'Thêm dự án',
			'edit_item'     => 'Sửa dự án',
			'menu_name'     => 'Dự án',
		),
		'public'        => true,
		'has_archive'   => 'du-an',
		'menu_icon'     => 'dashicons-building',
		'rewrite'       => array( 'slug' => 'du-an', 'with_front' => false ),
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		'show_in_rest'  => true,
	) );

	register_taxonomy( 'loai_cong_trinh', 'duan', array(
		'labels'       => array( 'name' => 'Loại công trình', 'singular_name' => 'Loại công trình' ),
		'public'       => true,
		'hierarchical' => true,
		'rewrite'      => array( 'slug' => 'loai-cong-trinh' ),
		'show_in_rest' => true,
	) );

	// ---------- CPT: Sản phẩm ----------
	register_post_type( 'sanpham', array(
		'labels' => array(
			'name'          => 'Sản phẩm',
			'singular_name' => 'Sản phẩm',
			'add_new_item'  => 'Thêm sản phẩm',
			'edit_item'     => 'Sửa sản phẩm',
			'menu_name'     => 'Sản phẩm',
		),
		'public'        => true,
		'has_archive'   => 'san-pham',
		'menu_icon'     => 'dashicons-products',
		'rewrite'       => array( 'slug' => 'san-pham', 'with_front' => false ),
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		'show_in_rest'  => true,
	) );

	register_taxonomy( 'danh_muc_sp', 'sanpham', array(
		'labels'       => array( 'name' => 'Danh mục sản phẩm', 'singular_name' => 'Danh mục sản phẩm' ),
		'public'       => true,
		'hierarchical' => true,
		'rewrite'      => array( 'slug' => 'danh-muc-san-pham' ),
		'show_in_rest' => true,
	) );
} );
