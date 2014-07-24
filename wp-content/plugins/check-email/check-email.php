
<?php 
ob_start();
	/**
	 * Plugin Name: Check email
	 * Description: Check email
	 * Version: 1.0
	 * Author: Duy Nghĩa
	**/
add_action('admin_menu', 'check_mail_manager'); //đăng ký 1 page để quản lý trong admin dashboard

function check_mail_manager() {
 
add_menu_page('Check mail', 'Check mail', 'manage_options', 'check-mail-menu-admin', 'menu_admin');

//add_menu_page(tiêu đề trang, tiêu đề menu, quyền nào được vào trang này, "slug", hàm hiển thị nội dung của trang)
}
	function menu_admin(){?>
	<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){

			$('#check').click(function(){
				$('#message').empty();
				$('#message').append("<p><img src='http://www.mytreedb.com/uploads/mytreedb/loader/ajax_loader_blue_32.gif' width='32' height='32'>Đang kiểm tra xin mời đợi vài phút.</p>");
				check();
				function check()
				{
				    $.ajax( {
				        "dataType": 'json',
				        "type": "POST",
				        "url": 'admin.php?page=check-mail-menu-admin',
				        "data": {suggest:'txt'},
				        "timeout": 15000,   // optional if you want to handle timeouts (which you should)
				        "error": handleAjaxError // this sets up jQuery to give me errors
				    } );
				}
				
				function handleAjaxError( xhr, textStatus, error ) {
					
				    if ( textStatus === 'timeout' ) {
				        check();
				    }
				    else {
				        $('#message').empty();
						$('#message').append("<p>Đã kiểm tra xong.</p>");
				    }
				}
				
			})

		})
	</script>
	<div id="message" class="updated below-h2"></div>
	<?php

		echo "<h2>Cấu hình</h2>";
		echo "<form action='#' method='Post'><input type='button' value=' Kiểm tra ' id='check'/></form>";
		if(isset($_POST['suggest'])) {
			$count = plugin_activated();
			$data = array('data'=>$count);
			echo $result = json_encode($data);
		}
	}

	

	function plugin_activated(){
	         // This will run when the plugin is activated, setup the database
	    	global $wpdb;
			$sql = "SELECT * FROM wp_users u left join wp_user_email e on u.user_email = e.email where e.email is Null";

			$user = $wpdb->get_results( $sql );
			
			foreach ($user as $value) {
				
					wp_delete_user( $value->ID );
					
			}
			return count($user);
			
	    }

?>