<?php
function dvd_login($user_data, $fb_id, $avartar, $redirect_url){//hàm tạo mới user và login
 
	$uid = wp_insert_user($user_data); //tạo user
	 
	if(!is_wp_error($uid)){
	 
	update_usermeta($uid, "fb_id", $fb_id); //cập nhật user meta
	
	update_usermeta($uid, "wp_user_avatar", $avartar); //cập nhật user meta
	
	wp_set_auth_cookie($uid); //chứng thực
	 
	do_action('wp_login', $user_login, get_userdata($uid, $user_data['user_pass'])); // đăng nhập với tài khoản vừa tạo
	 
	wp_new_user_notification($uid, $user_data['user_pass']);//gửi email thông báo đến user
	 
	wp_redirect($redirect_url); //chuyển hướng
	 
	}else{
	 
	echo "Lỗi: tạo thành viên mới thất bại!. <a href='".get_permalink($dvd_key_facebook['pageid'])."'>Bấm vào đây</a> để về trang chủ."; return;
	 
	}
 
}

function add_post($post, $attachment, $filename)
{
	
	//$postid = wp_insert_post($post);
	$attach_id = wp_insert_attachment( $attachment, $user_data['wp_user_avatar'], 0 );
	$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
	wp_update_attachment_metadata( $attach_id, $attach_data );
}

function dvd_create_userlogin($fbusername, $fbid){ //hàm tạo tên đăng nhập cho user không trùng lặp dựa vào tên đăng nhập facebook
 
	if(!$fbusername || $fbusername == "")
	 
	$userlogin = "fb_".$fbid; //nếu tên đăng nhập facebook rỗng thì lấy tên đăng nhập theo dạng "fb_id của user"
	 
	else
	 
	$userlogin = trim($fbusername);
	 
	$count = 0;
	 
	$orginal_userlogin = $userlogin;
	 
	do{
	 
	$usertmp = get_user_by("login", $userlogin);
	 
	if (isset($usertmp) && $usertmp != "" && $usertmp->ID != 0){
	 
	$count++;
	 
	$userlogin = $orginal_userlogin.$count;
	 
	}else{
	 
	break;
	 
	}
	 
	}while(true); //kiểm tra tên đăng nhập và thiết lập thêm số sau tên đăng nhập để tránh trùng lặp
	 
	return $userlogin;
 
}
?>