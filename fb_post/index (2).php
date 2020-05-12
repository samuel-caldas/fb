<?php
session_start();
if(!isset($_SESSION["cookie"])){
	$_SESSION["cookie"]=NULL;
}
/*
 * Required parameters
 */
$device_name = 'Home'; #in case you have location checking turned on
$debug = true;

/*
 * @return curl_post
 */
function cURL($url,$header,$cookie,$p){
	$c=curl_init();
	
	curl_setopt($c,CURLOPT_HEADER,$header);
	curl_setopt($c,CURLOPT_NOBODY,$header);
	curl_setopt($c,CURLOPT_URL,$url);
	curl_setopt($c,CURLOPT_SSL_VERIFYHOST,0);
	curl_setopt($c,CURLOPT_COOKIE,$cookie);
	curl_setopt($c,CURLOPT_USERAGENT,'Mozilla/4.0 (compatible; MSIE 5.0; S60/3.0 NokiaN73-1/2.0(2.0617.0.0.7) Profile/MIDP-2.0 Configuration/CLDC-1.1)');
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
		return $result;
	} else {
		return curl_error($c);
	}
	curl_close($c);
}
/*
 * @return form input field names & values
 */

function parse_inputs($html) {
    $dom = new DOMDocument;
    @$dom->loadxml($html);
    $inputs = $dom->getElementsByTagName('input');
    return($inputs);
}

/*
 * @return form action url
 */

function parse_action($html) {
    $dom = new DOMDocument;
    @$dom->loadxml($html);
    $form_action = $dom->getElementsByTagName('form')->item(0)->getAttribute('action');
    if (!strpos($form_action, "//")) {
        $form_action = "https://m.facebook.com$form_action";
    }
    return($form_action);
}
function cookies($txt){
	$pg='%Set-Cookie: ([^;]+);%';
	$cookie=NULL;
	preg_match_all($pg,$txt,$result);
	for($i=0;$i<count($result[0]);$i++){
		$cookie.=$result[1][$i].";";
	}
	return $cookie;
}
function login($EMAIL,$PASSWORD) {
    $usr="email=".$EMAIL."&pass=".$PASSWORD;
	$_SESSION["cookie"]=NULL;
	$link="https://m.facebook.com/login.php";
	$ck='reg_fb_gate=https%3A%2F%2Fm.facebook.com%2Flogin.php';
	///////////////////////////////////////////
	$_SESSION["cookie"]=cookies(cURL($link,true,$ck,$usr));
	///////////////////////////////////////////
	if ($GLOBALS['debug']) {
		echo "<strong>Cookies de login:</strong><br><br>";
		echo $_SESSION["cookie"];
		echo '<br>----------------------------------------------------------------------------------------------------------------------------------<br><br>';
		echo "<strong>Home:</strong><br><br>";
		echo htmlspecialchars(cURL('m.facebook.com/',true,$_SESSION["cookie"],NULL));
		
		echo '<br>----------------------------------------------------------------------------------------------------------------------------------<br><br>';
		echo "<strong>messages:</strong><br><br>";
		echo htmlspecialchars(cURL('m.facebook.com/messages',false,$_SESSION["cookie"],NULL));
    }
}

/*
 * grab and return the homepage
 */

function grab_home() {
	$url='https://m.facebook.com/';
    $html = cURL($url,NULL);
    return($html);
}

/*
 * logout
 */
 
function logout() {
    $dom = new DOMDocument;
    @$dom->loadxml(grab_home());
    $links = $dom->getElementsByTagName('a');
    foreach ($links as $link) {
        if (strpos($link->getAttribute('href'), 'logout.php')) {
            $logout = $link->getAttribute('href');
            break;
        }
    }

    $url = 'https://m.facebook.com' . $logout;
    /*
     * just logout lol
     */
    $loggedout = cURL($url,NULL);
    if ($GLOBALS['debug']) {
        echo "\nLogout url = $url\n";
        echo $loggedout;
    }
    echo "\n[i] Logged out.\n";
}

login('smwtf','samuel20');
?>
