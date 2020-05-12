<?php
session_start();
include 'Chrome.php';
class HttpCurl {
	private $_ch,$_agent, $_post, $_header,$_code,$_body,$_error;
	public function __construct() {
        if (!function_exists('curl_init')) {
            throw new Exception('cURL not enabled!');
        } 
    }
	
	public function cURL($url) {
// User Agents
//		$this->_agent='Mozilla/5.0 (Windows; U; MSIE 7.0; Windows NT 6.0; en-US)';	//mozilla de pc
		$this->_agent='Mozilla/4.0 (compatible; MSIE 5.0; S60/3.0 NokiaN73-1/2.0(2.0617.0.0.7) Profile/MIDP-2.0 Configuration/CLDC-1.1)';	//mozilla movel
//		$this->_agent='Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML,like Gecko) Chrome/32.0.1667.0 Safari/537.36';	//chrome
//	
		$this->_ch=curl_init();
		curl_setopt($this->_ch,CURLOPT_HEADER,TRUE);
        curl_setopt($this->_ch,CURLINFO_HEADER_OUT,TRUE);
		curl_setopt($this->_ch,CURLOPT_NOBODY,false);
		curl_setopt($this->_ch,CURLOPT_URL,$url);
		curl_setopt($this->_ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($this->_ch,CURLOPT_USERAGENT,$this->_agent);
		curl_setopt($this->_ch,CURLOPT_RETURNTRANSFER,TRUE);
		curl_setopt($this->_ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($this->_ch,CURLOPT_FOLLOWLOCATION,FALSE);
		if(!empty($_SESSION["cookie"])){
			$cookieBuffer=array();
			foreach($_SESSION["cookie"] as $k=>$c){
				$cookieBuffer[]="$k=$c";
			}
			curl_setopt($this->_ch,CURLOPT_COOKIE,implode("; ",$cookieBuffer) );
		}
		if(!empty($this->_post)){
			curl_setopt($this->_ch,CURLOPT_CUSTOMREQUEST,"POST");
			curl_setopt($this->_ch,CURLOPT_POST,TRUE);
			curl_setopt($this->_ch,CURLOPT_POSTFIELDS,$this->_post);
			$this->_post=NULL;
		}
		$this->_code=curl_exec($this->_ch);
        wr($this->_error=curl_error($this->_ch));
		$this->_header=substr($this->_code,0,curl_getinfo($this->_ch,CURLINFO_HEADER_SIZE));
		$this->_body=substr($this->_code,curl_getinfo($this->_ch,CURLINFO_HEADER_SIZE));
		preg_match_all("/^Set-cookie: (.*?);/ism",$this->_header,$cookies);
		foreach($cookies[1] as $cookie){
			$buffer_explode=strpos($cookie,"=");
			$_SESSION["cookie"][substr($cookie,0,$buffer_explode)]=substr($cookie,$buffer_explode+1);
		}
		curl_close($this->_ch);
		return $this->_body;
	}
	
	public function setPost($post) {
        lg($this->_post=http_build_query($post));
    }
	
	// Get http_code
    public function getStatus() {
        return $this->_info[http_code];
    }
      
	// Get web page header information
    public function getHeader() {
        return $this->_header;
    }
	
	// Get web page complete information
	public function getCode() {
        return $this->_code;
    }
	
	// Get web page Cookie
	public function getCookie() {
        return $_SESSION["cookie"];
    }
	// Delete web page Cookie
	public function delCookie() {
        $_SESSION["cookie"]=NULL;
    }
     public function getHandle() {
        return $this->_ch;
    } 
	// Get web page content
    public function getBody() {
        return $this->_body;
    }
      
    public function __destruct() {
    }
}
?>