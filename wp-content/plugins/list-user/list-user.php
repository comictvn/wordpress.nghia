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
		$user = $wpdb->get_results( $sql );
	
		$data = '<table>';
		$data .= '<tr><td>Username</td><td>Ngày đăng ký</td><td>Sửa</td><td>Xóa</td></tr>';
		foreach( $user as $set ) {
			$data .= '<tr>';
			$data .= '<td>'.$set->user_nicename.'</td>';
			$data .= '<td>'.$set->user_registered.'</td>';
			$data .= '<td><a href="">Sửa</a></td>';
			$data .= '<td><a href="">Xóa</a></td>';
			$data .= '</tr>';
		}
		$data .= '</table>';
		echo $data;
	}
	function create_table()
	{
		global $wpdb;
		$table_name = $wpdb->prefix ."cron_job";
		if($wpdb->get_var("SHOW TABLE LIKE ".$table_name) != $table_name) {
			$sql = "CREATE TABLE ".$table_name." (
				id INTERGER(11) UNSIGNED AUTO_INCREMENT,
				cronjob_time VARCHAR(255) NOT NULL,
				is_startup INTERGER(1) NOT NULL,
				PRIMARY KEY (id))";
			require_once(ABSPATH . 'wp-admin/include/upgrade.php');
			dbDelta($sql);
			add_option('TABLE CRON JOB','1.0');
		}
	}
	function delete_table()
	{
		global $wpdb;
		$table_name = $wpdb->prefix ."cron_job";
		$wpdb->query( "DROP TABLE IF EXISTS" .$table_name);
	}
	function add_ads() {
 
		$ads =
		 
		'<div class="ads">
		 
		<!--Chèn mã vào đây-->
		 aaa
		</div>';
		 
		 
		return $ads;
		 
		}
 
        add_action( 'genesis_entry_header', 'add_ads' );
	add_shortcode('List-User', 'list_user');
?>