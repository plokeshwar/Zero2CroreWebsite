<?php
class curl{
	
	public $curl_param;
	public $api;
	
	public function __construct($curl_param,$api){
		$this->curl_param = $curl_param;
		$this->api = $api;
	}
	
	public function exec_curl(){
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->api);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_POST, 1 );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->curl_param); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain')); 

		$result=curl_exec ($ch);
		
		return $result;
	}
}