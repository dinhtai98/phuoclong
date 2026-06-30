<?php
/**
 * Plugin Name: PCCC Phước Long — SVG support
 * Description: Cho phép tải ảnh SVG làm ảnh bìa/biểu tượng.
 * Version: 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_filter( 'upload_mimes', function ( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	return $mimes;
} );

add_filter( 'wp_check_filetype_and_ext', function ( $data, $file, $filename, $mimes ) {
	if ( substr( strtolower( $filename ), -4 ) === '.svg' ) {
		$data['ext']  = 'svg';
		$data['type'] = 'image/svg+xml';
	}
	return $data;
}, 10, 4 );

// Hiển thị SVG trong lưới media + cho phép kích thước hiển thị.
add_filter( 'wp_prepare_attachment_for_js', function ( $response, $attachment ) {
	if ( 'image/svg+xml' === $response['mime'] ) {
		$response['sizes'] = array(
			'full' => array(
				'url'         => $response['url'],
				'width'       => 1200,
				'height'      => 750,
				'orientation' => 'landscape',
			),
		);
	}
	return $response;
}, 10, 2 );
