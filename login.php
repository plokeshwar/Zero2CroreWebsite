<?php
include('common/include.php');

$header = file_get_contents('templates/register/common/header.html');
$login = file_get_contents('templates/register/login.html');
$footer = file_get_contents('templates/register/common/footer.html');

$content = $header.$login.$footer;

/*Common html replacements*/
$content = str_replace('*{ASSET_LINK}*',ASSET_LINK,$content);
$content = str_replace('*{login_active}*','active',$content);
$content = str_replace('*{register_active}*','',$content);
$content = str_replace('*{otp_active}*','',$content);
$content = str_replace('*{login_link}*','login.php',$content);
$content = str_replace('*{register_link}*','register.php',$content);
$content = str_replace('*{otp_link}*','otp.php',$content);

if(isset($_POST['general_login'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	if($email==''){
		$message = '<div style="color:red;">Enter your email address.</div>';
	}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$message = '<div style="color:red;">Enter your valid email address.</div>';
	}else if($password==''){
		$message = '<div style="color:red;">Enter password.</div>';
	}else{
		$request['request'] = array ( 
		'userId' => $email,
		'password' => $password
		);
		
		$request_json = json_encode($request);
		
		$api = API_URL.'login';

		$curl_obj = new curl($request_json,$api);

		$result = $curl_obj->exec_curl();
		
		$result_array = json_decode($result);
		
		if($result_array->message=='Login successful.'){
			$_SESSION['customer']['id'] = $result_array->data->userId;
			$_SESSION['customer']['email'] = $result_array->data->email;
			$_SESSION['customer']['firstName'] = $result_array->data->firstName;
			$_SESSION['customer']['lastName'] = $result_array->data->lastName;
			print_r($_SESSION); die();
		}else{
			$message = '<div style="color:red;">'.$result_array->message.'</div>';
		}
	}
}else{
	$message = '';
}

$content = str_replace('*{alert-msg}*',$message,$content);

echo $content;

