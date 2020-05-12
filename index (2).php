<?php
include 'httpcurl.php';
include 'fbform.php';
$fb='http://m.facebook.com';
function replace($html){
	$html=str_replace('>','>|',$html);
	$html=explode('|',$html);
	foreach($html as $line){
		$line=str_replace('[','(',$line);
		$line=str_replace(']',')',$line);
		$line=str_replace('action="/','action="?p='.$_GET['p'].'&f=/',$line);
		$line=str_replace('href="/','href="?p=/',$line);
		$saida[]=$line;
	}
	return implode('',$saida);
}

function page($url){
	$pages = new FBform();
	$pages->get($url);
	return replace($pages->getBody());
}
function form($url,$post){
	$pages = new FBform();
	$pages->get($url);
	if(isset($post['body'])){
		$pages->fbSendMsg($post['body']);
	}
	if(isset($post['status'])){
		$pages->fbstatusupdate($post['status']);
	}
	return replace($pages->getBody());
}
if(!file_exists(getcwd ().'/'.cookie)){
	header ("location: login/");
}else{
	if(!file(getcwd ().'/'.cookie)){
		header ("location: login/");
	}else{
		if(isset($_GET)){
			if(isset($_GET['f'])){
				echo form($fb.$_GET['p'],$_POST);
			}else
			if(isset($_GET['p'])){
				echo page($fb.$_GET['p']);
			}
		}else{
			header ("location: /?p");
		}
	}
}
?>