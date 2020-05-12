<?php
session_start();
ini_set('max_execution_time', 500); //300 seconds = 5 minutes
////////////Includes////////////
	include 'sdk\src\facebook.php';
	include 'httpcurl.php';
	include 'fbform.php';
	include 'simple_html_dom.php';
	//include 'DBFramework.php';

////////////login fb curl////////////
	$pages = new FBform();
	/*$pages->get('http://m.facebook.com');
	$pages->fblogin('smwtf','samuel20');*/

/*////////////facebook application configuration////////////
	$fbconfig['appid'] = "459033397520460";
	$fbconfig['secret'] = "80353b4a6b41f356397710215a9d77d4";
	$facebook = new Facebook(array('appId' => $fbconfig['appid'], 'secret' => $fbconfig['secret'], 'cookie' => true,));
	$user       = $facebook->getUser();
	$loginUrl   = $facebook->getLoginUrl(array('scope' => 'email'));
////////////FB FRIENDS////////////
	if($user){
		try{
			$user_profile = $facebook->api('/me');
			$user_friends = $facebook->api('/me/friends');
			$access_token = $facebook->getAccessToken();
		}catch(FacebookApiException $e){
			d($e);
			$user = null;
		}
	}
	if(!$user){
		header('Location:'.$loginUrl);;
		exit;
	}
    foreach($user_friends['data'] as $usr){
        echo $usr['id'];
        echo '<br />';
    }
*/
	
////////////FB CHAT////////////
for($i=0;$i<=85;$i++){
	$pages->get('https://m.facebook.com/messages/?page='.$i);
	$html = str_get_html($pages->getBody());
	$a=$html->find('._52je a');
	foreach($a as $element){
		if(!$_SESSION['friends']){
			$_SESSION['friends'][]=$element->href;
		}else{
			if(!in_array($element->href, $_SESSION['friends'])){
				$_SESSION['friends'][]=$element->href;
			}
		}
	}
}

print_r($_SESSION['friends']);
/*function friends($page){
	$html = str_get_html($page);
	$a=$html->find('.c a');
	$friends=array();
	foreach($a as $element){		
		$friends[]=$element->href;
	}
	return $friends;
}
if($_GET['p']<=85){
	$pages->get('https://m.facebook.com/smwtf?v=friends&startindex='.(30*$_GET['p']));//cada pagina uns 30 amigos, ao todo sao  2.544
	foreach(friends($pages->getBody()) as $friend){
		if(!in_array($friend, $_SESSION['friends'])){
			$_SESSION['friends'][]=$friend;
		}
	}
	header('Location:index.php?p='.($_GET['p']++));
}*/
?>