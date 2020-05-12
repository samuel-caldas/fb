<?php
session_start();
include 'simple_html_dom.php';
//$_SESSION["cookie"]=NULL;

if(!isset($_SESSION["cookie"])){
	$_SESSION["cookie"]=array();
}

/*
 * Required parameters
 */
$debug = false;

/*
 * @return curl_post
 */
function cURL($url,$p){
//	$agent = 'Mozilla/5.0 (Windows; U; MSIE 7.0; Windows NT 6.0; en-US)';	//mozilla de pc
	$agent = 'Mozilla/4.0 (compatible; MSIE 5.0; S60/3.0 NokiaN73-1/2.0(2.0617.0.0.7) Profile/MIDP-2.0 Configuration/CLDC-1.1)';	//mozilla movel
//	$agent = 'Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1667.0 Safari/537.36';	//chrome
	if(count($_SESSION["cookie"])>0){
		$cookie=implode(';',$_SESSION["cookie"]).';';
	}else{
		$cookie=false;
	}
	$c=curl_init();
	curl_setopt($c,CURLOPT_HEADER,true);
	curl_setopt($c,CURLOPT_NOBODY,false);
	curl_setopt($c,CURLOPT_URL,$url);
	curl_setopt($c,CURLOPT_SSL_VERIFYHOST,0);
	curl_setopt($c,CURLOPT_COOKIE,$cookie);
	curl_setopt($c,CURLOPT_USERAGENT,$agent);
	curl_setopt($c,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($c,CURLOPT_SSL_VERIFYPEER,0);
	curl_setopt($c,CURLOPT_FOLLOWLOCATION,1);
	if ($p){
		curl_setopt($c,CURLOPT_CUSTOMREQUEST,"POST");
		curl_setopt($c,CURLOPT_POST,1);
		curl_setopt($c,CURLOPT_POSTFIELDS,$p);
	}
	$result=curl_exec($c);
	if ($result){
		preg_match_all('%Set-Cookie: ([^;]+);%',$result,$cs);
		foreach ($cs[1] as $ck) {
			if(!in_array($ck,$_SESSION["cookie"])){
				$_SESSION["cookie"][]=$ck;
			}
		}
		if ($GLOBALS['debug']) {
			print_r($cookie);
		}
		$saida=explode('<html',$result);
		return '<html'.$saida[1];
		//return $result;
	} else {
		return curl_error($c);
	}
	curl_close($c);
}

function login($EMAIL,$PASSWORD) {
    $usr="email=".$EMAIL."&pass=".$PASSWORD;
	$link="https://m.facebook.com/login.php";
	return cURL($link,$usr);
}
//login('smwtf','samuel20');
print_r(cURL('https://m.facebook.com/',NULL));
?>
