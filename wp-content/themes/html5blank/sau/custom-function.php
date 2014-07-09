<?php
// Them css va javascript vao giua the head
function sw_styles_and_scripts() {
	wp_register_style('html5blank-custom-style', get_template_directory_uri().'/sau/custom-style.css');
	wp_enqueue_style('html5blank-custom-style');
}
add_action('wp_enqueue_scripts', 'sw_styles_and_scripts');

// Them vao cac chuc nang ho tro cua giao dien
if (function_exists('add_theme_support'))
{
	// Khai bao kich thuoc cho hinh anh thumbnail khi xem bai viet
	add_image_size('custom-single-size', 300, 175, true);
	
	// Khai bao kich thuoc cho hinh anh thumbnail khi duyet danh sach bai viet
	add_image_size('custom-home-size', 1004, 477, true);
}
?>