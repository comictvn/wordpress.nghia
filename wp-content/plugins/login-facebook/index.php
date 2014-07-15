<?php 
	/**
	 * Plugin Name: login-facebook
	 * Description: Đăng ký đăng nhập bằng facebook
	 * Version: 1.0
	 * Author: Duy Nghĩa
	**/
add_action('admin_menu', 'register_login_facebook_manage_page'); //đăng ký 1 page để quản lý trong admin dashboard
 
function register_login_facebook_manage_page() {
 
add_menu_page('Login by Facebook', 'Login by Facebook', 'manage_options', 'dvd-login-facebook', 'dvd_login_facebook');
 
//add_menu_page(tiêu đề trang, tiêu đề menu, quyền nào được vào trang này, "slug", hàm hiển thị nội dung của trang)
 
}
 
function dvd_login_facebook(){
 
?>
 
<?php $dvd_key_facebook = get_option("dvd_key_facebook"); //lấy option chứa appId, secret và pageid ?>
 
<div class="wrap">
 
<h2>Cấu hình</h2>
 
<?php
 
if(!$dvd_key_facebook){ //trường hợp chưa cấu hình: xuất thông báo yêu cầu cấu hình
 
echo "<p style='color:blue;'>Nhập đầy đủ thông tin cấu hình để có thể sử dụng</p>";
 
}else{
 
//trường hợp đã cấu hình: xuất ra đoạn code để sử dụng, ở đây là 1 link đến trang xử lý đăng nhập với facebook
 
echo htmlentities('<a href="'.get_permalink($dvd_key_facebook['pageid']).'">Đăng Nhập Với Facebook</a>', ENT_QUOTES, "UTF-8");
 
}
 
if (isset($_POST['save_config'])) { //xử lý khi bấm lưu cấu hình
 
$appid = sanitize_text_field($_POST['appid']); //lấy appid
 
$secret = sanitize_text_field($_POST['secret']); //lấy sercret
 
if ($appid == "" || $secret == "")
 
echo "<p style='color:red'>Các trường không được để trống.</p>"; //xuất thông báo nếu các trường để trống
 
else {
 
//nếu điền đầy đủ thông tin rồi, phải kiểm tra app có tồn tại hay không bằng cách sử dụng graph API của facebook
 
$resp = json_decode(file_get_contents("https://graph.facebook.com/".$appid."?fields=roles&access_token=".$appid."|".$secret.""));
 
if(!$resp->id){ //đối tượng trả về nếu không có id đồng nghĩa với việc app không tồn tại
 
echo "<p style='color:red'>Lỗi: thông tin cấu hình không chính xác!</p>";
 
}else{ //nếu app tồn tại
 
$lfb_page = get_page_by_title("Login By Facebook");
 
if(!$lfb_page){ //nếu page với tiêu đề này chưa có thì tạo mới và chèn short code vào
 
$page_id = wp_insert_post(
 
array(
 
"post_title" => "Login By Facebook",
 
"post_content" => "[dvd_login_by_facebook]",
 
"post_status" => "publish",
 
"post_author" => 1,
 
"post_type" => "page")
 
);
 
}else{ //trường hợp có rồi thì cập nhật lại nội dung
 
wp_update_post(array(
 
"ID" => $lfb_page->ID, "post_content" => "[dvd_login_by_facebook]"
 
));
 
$page_id = $lfb_page->ID;
 
}
 
update_option("dvd_key_facebook", array("appid" => $appid, "secret" => $secret, "pageid" => $page_id)); //tạo mới, cập nhật option lưu các giá trị cấu hình
 
wp_redirect(admin_url("admin.php?page=dvd-login-facebook")); exit();//tải lại trang
 
}
 
}
 
}
 
?>
 
<form action="" method="post" style="margin-top:2%" >
 
<table>
 
<tr>
 
<td>AppID</td><td><input type="text" name="appid" size="40" value="<?php
 
if (isset($dvd_key_facebook["appid"]))
 
echo $dvd_key_facebook["appid"];
 
?>"/></td>
 
</tr>
 
<tr>
 
<td>Secret</td><td><input type="text" name="secret" size="40" value="<?php
 
if (isset($dvd_key_facebook["secret"]))
 
echo $dvd_key_facebook["secret"];
 
?>"/></td>
 
</tr>
 
<tr>
 
<td>&nbsp;</td><td><input type="submit" name="save_config" value="Lưu" class="button-primary"/></td>
 
</tr>
 
</table>
 
</form>
 
</div>
 
<?php
 
}

function dvd_login_by_facebook() {
 
if(!get_option('users_can_register')){ //nếu chức năng đăng ký đã đóng thì xuất thông báo và đưa link chuyển hướng
 
echo "<h1>Chức năng đăng ký đã đóng. <a href='".home_url()."'>Bấm vào đây</a> để về trang chủ</h1>";
 
return;
 
}
 
include_once(plugin_dir_path(__FILE__)."src/facebook.php"); //include php sdk của facebook
 
include_once(plugin_dir_path(__FILE__)."functions.php"); //include các hàm cần thiết
 
$dvd_key_facebook = get_option("dvd_key_facebook"); //lấy thông tin cấu hình
 
if(!$dvd_key_facebook){
 
echo "Lỗi chưa cấu hình. <a href='".get_bloginfo('url')."'>Bấm vào đây</a> để về trang chủ."; return; //trường hợp chưa cấu hình
 
}
 
$config = array( //tạo mảng lưu các giá trị cần để khởi tạo đối tượng
 
'appId' => $dvd_key_facebook["appid"],
 
'secret' => $dvd_key_facebook["secret"]
 
);
 
$facebook = new Facebook($config);  //khởi tạo đối tượng dựa vào appID và secret
 
$fb_user_id = $facebook->getUser(); //sử dụng hàm getUser() để lấy đối tượng user đang login trên facebook, hàm trả về id của user đang login
 
if ($fb_user_id) {//nếu có id có nghĩa đang login facebook
 
try {
 
$user_profile = $facebook->api("/$fb_user_id", "GET"); //sử dụng gragh api để lấy thông tin, hàm trả về 1 mảng các thông tin của user
 
$user_data = array(); //mảng lưu dữ liệu của user mới cần tạo
 
$user_login = dvd_create_userlogin($user_profile['username'], $user_profile['id']); //tạo username duy nhất
 
$random_password = wp_generate_password($length = 12, $include_standard_special_chars = false); //tạo mật khẩu ngẫu nhiên
 
$user_data['user_login'] = $user_login;
 
$user_data['user_pass'] = $random_password;
 
$user_data['user_email'] = $user_profile['email'];
 
$user_data['user_nicename'] = $user_login;
 
$user_data['first_name'] = $user_profile['first_name'];
 
$user_data['last_name'] = $user_profile['last_name'];
 
$user_data['user_url'] = $user_profile['link'];

$user_data['wp_user_avatar'] = "/path/to/uploads/2014/07/Tulips.jpg";


 
$user_data['display_name'] = $user_profile['first_name']." ".$user_profile['last_name'];
$image_url= "https://graph.facebook.com/$fb_user_id/picture?type=large";
$image_url = getFacebookImageFromURL($image_url);

$upload_dir = wp_upload_dir();
$image_data = file_get_contents($image_url);
$filename = basename($image_url);
if(wp_mkdir_p($upload_dir['path']))
    $file = $upload_dir['path'] . '/' . $filename;
else
    $file = $upload_dir['basedir'] . '/' . $filename;
file_put_contents($file, $image_data);

$wp_filetype = wp_check_filetype($filename, null );
$attachment = array(
    'post_mime_type' => $wp_filetype['type'],
    'post_title' => sanitize_file_name($filename),
    'post_content' => '',
    'post_status' => 'inherit'
);



//lấy các thông tin cần thiết từ user facebook

$user = get_users(array(
 
"meta_key" => "fb_id",
 
"meta_value" => $user_profile['id']
 
));
 
if($user && count($user) > 0){ //kiểm tra user có tồn tại trong DB chưa
 
//user đã tồn tại, login và chuyển hướng
 
wp_set_auth_cookie($user[0]->ID);
 
do_action('wp_login', $user->user_login, get_userdata($user[0]->ID));
 
wp_redirect(home_url());
 
}else{ //chưa có user, kiểm tra email, nếu tồn tại hoặc không lây được, yêu cầu nhập email mới tạo mới và login
 
if(email_exists($user_data['user_email']) || $user_data['user_email'] == ""){
 
?>
 
<p>Email của bạn đã được sử dụng. Bạn vui lòng nhập địa chỉ email mới để tiếp tục.</p>
 
<?php
 
if(isset($_POST['confirm'])){
 
if(!is_email($_POST['uemail']) || email_exists($_POST['uemail'])){
 
?>
 
<p style="color:red;">Lỗi: email không hợp lệ hoặc đã được sử dụng.</p>
 
<?php
 
}else{
 
$user_data['user_email'] = $_POST['uemail'];
 
dvd_login($user_data, $fb_user_id, $user_data['wp_user_avatar'], home_url(), $attachment, $file );
 
}
 
}
 
?>
 
<form action="" method="post">
 
<input type="text" name="uemail" autocomplete="off" />
 
<input type="submit" name="confirm" value="Tiếp Tục" />
 
</form>
 
<?php
 
}else{ //đã có user => login
 
dvd_login($user_data, $fb_user_id, $user_data['wp_user_avatar'], home_url(), $attachment, $file);
 
}
 
}
 
} catch (FacebookApiException $e) { //bắt lỗi
 
echo "<p style='color:red;'>Lỗi!.</p>";
 
error_log($e->getType());
 
error_log($e->getMessage());
 
return;
 
}
 
} else { //trường hợp chưa login thì chuyển hướng đến trang đăng nhập
 
$login_url = $facebook->getLoginUrl(array("scope" => "read_stream, email")); //muốn lấy nhiều thông tin thì thêm scope
 
wp_redirect($login_url); //chuyển hướng đến trang login
 
}
 
}
add_shortcode("dvd_login_by_facebook", "dvd_login_by_facebook");
