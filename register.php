<?php
include('common/include.php');

$header = file_get_contents('templates/register/common/header.html');
$register_form = file_get_contents('templates/register/register_form.html');
$footer = file_get_contents('templates/register/common/footer.html');

$content = $header.$register_form.$footer;

/*Common html replacements*/
$content = str_replace('*{ASSET_LINK}*',ASSET_LINK,$content);
$content = str_replace('*{login_active}*','',$content);
$content = str_replace('*{register_active}*','active',$content);
$content = str_replace('*{otp_active}*','',$content);
$content = str_replace('*{login_link}*','login.php',$content);
$content = str_replace('*{register_link}*','register.php',$content);
$content = str_replace('*{otp_link}*','otp.php',$content);

if(isset($_POST['register'])){
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$mobile = $_POST['mobile'];
	$email = $_POST['email'];
	$pan = $_POST['pan'];
	$aadhar = $_POST['aadhar'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];
	
	if($firstName==''){
		$message = '<div style="color:red;">Enter your first name.</div>';
	}else if($lastName==''){
		$message = '<div style="color:red;">Enter your last name.</div>';
	}else if($mobile==''){
		$message = '<div style="color:red;">Enter your mobile number.</div>';
	}else if($email==''){
		$message = '<div style="color:red;">Enter your email address.</div>';
	}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$message = '<div style="color:red;">Enter your valid email address.</div>';
	}else if($pan==''){
		$message = '<div style="color:red;">Enter your pan number.</div>';
	}else if($aadhar==''){
		$message = '<div style="color:red;">Enter your aadhar number.</div>';
	}else if($password==''){
		$message = '<div style="color:red;">Enter password.</div>';
	}else if($confirm_password==''){
		$message = '<div style="color:red;">Enter confirm password.</div>';
	}else if($confirm_password!=$password){
		$message = '<div style="color:red;">Password and confirm password should match.</div>';
	}else{
		$request['request'] = array ( 
		'firstName' => $firstName, 
		'lastName' => $lastName, 
		'mobile' => $mobile,
		'email' => $email,
		'pan' => $pan,
		'aadhar' => $aadhar,
		'password' => $password
		);
		
		$request_json = json_encode($request);
		
		$api = API_URL.'register';

		$curl_obj = new curl($request_json,$api);

		$result = $curl_obj->exec_curl();
		
		$result_array = json_decode($result);
		
		if($result_array->message=='User is successfully registered.'){
			$message = '<div style="color:green;">You are successfully registered.</div>';
			
			$firstName = '';
			$lastName = '';
			$mobile = '';
			$email = '';
			$pan = '';
			$aadhar = '';
			$password = '';
			$confirm_password = '';
		}else{
			$message = '<div style="color:blue;">You are already registered with us.</div>';
		}
		
	}
}else{
	$message = '';
	$firstName = '';
	$lastName = '';
	$mobile = '';
	$email = '';
	$pan = '';
	$aadhar = '';
	$password = '';
	$confirm_password = '';
}

$content = str_replace('*{alert-msg}*',$message,$content);

/*Form Fields Value*/
$content = str_replace('*{firstName}*',$firstName,$content);
$content = str_replace('*{lastName}*',$lastName,$content);
$content = str_replace('*{mobile}*',$mobile,$content);
$content = str_replace('*{email}*',$email,$content);
$content = str_replace('*{pan}*',$pan,$content);
$content = str_replace('*{aadhar}*',$aadhar,$content);
$content = str_replace('*{password}*',$password,$content);
$content = str_replace('*{confirm_password}*',$confirm_password,$content);

echo $content;
