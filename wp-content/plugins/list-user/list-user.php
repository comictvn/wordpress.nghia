<?php 
	/**
	 * Plugin Name: list-user
	 * Description: Plugin liệt kê danh sách thành viên
	 * Version: 1.0
	 * Author: Duy Nghĩa
	**/
	
	function list_user(){
		global $wpdb;
		$sql = "SELECT * FROM wp_users";
		echo $user = $wpdb->get_results( $sql );
		var_dump($user );
		$data = '<ul>';
		foreach( $user as $set ) {
			$data .= '<li>'.$set->user_nicename. ' | ' .$set->user_registered.'</li>';
		}
		$data .= '</ul>';
		echo $data;
	}
	add_shortcode('List-User', 'list_user');
?>