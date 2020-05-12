<?php
define('FB','https://m.facebook.com');
class faceboog extends HttpCurl {
	private $_url;
	
	public function __construct(){}	 	
	public function __destruct(){}
	
	public function page(){
		$pages=new HttpCurl();
		if(isset($_GET['p'])){
			if(isset($post)){
				foreach($post as $key => $value) { 
					if(!is_array($value)){
						$fields.=$key.'='.$value.'&'; 
					}else{
						foreach($value as $k=>$v){
							$fields.=$key.'['.$k.']'.'='.$v.'&'; 
						}
					}
				}
				rtrim($fields, '&');
				$pages->setPost($fields);
			}
			$pages->cURL($_GET['p']);
		}else{
			$pages->cURL(FB);
		}
	}
}
?>