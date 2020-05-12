<?php
include 'cURL.php';
include 'simple_html_dom.php';
$pages=new HttpCurl();
if(!empty($_GET['p'])){ 						wr($_GET['p']);
	$url=parse_url($_GET['p']);
	if(!empty($_POST)){
		$pages->setPost($_POST);
	}
	$pages->cURL(urldecode($_GET['p']));
	$body=$pages->getBody();
	if(!empty($body)){
		$html=str_get_html($body);
		foreach ($html->find('a') as $a){
			if(empty($href['host'])){
				$a->href='http://localhost/fb/index.php?p='.urlencode($url['host'].$a->href);
			}else if(!empty($href['host'])){
				$a->href='http://localhost/fb/index.php?p='.urlencode($a->href);
			}
		}
		foreach ($html->find('form') as $f){
			$action=parse_url($f->action);		wr($action);
			if(empty($action['host'])){
				$f->action='http://localhost/fb/index.php?p='.urlencode($url['host'].$action['path']);
			}else if(!empty($action['host'])){
				$f->action='http://localhost/fb/index.php?p='.urlencode($action['host'].$action['path']);
			}
		}
		foreach ($html->find('meta') as $m){
			$content=parse_url($m->content);
			wr($content);
			$m->outertext='';
		}
		foreach ($html->find('script') as $s){
			$a=array('document.location.href','document.location','location');
			$b=array('var error');
			$s->innertext=str_replace($a,$b,$s->innertex);
		}
		echo $html;
	}
}
?>