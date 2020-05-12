<?php
include 'httpcurl.php';
include 'fbform.php';

$fbhomepage = 'http://m.facebook.com';
$username = "smwtf";   // Insert your login email
$password = "samuel20";   // Insert your password
$status = "";

$pages = new FBform();
//$pages->get($fbhomepage);  
//$pages->fblogin($username, $password);
/*$pages->get($fbhomepage);
$pages->fbstatusupdate($status);*/

$pages->get($fbhomepage.'/messages/read/?tid=mid.1382055842134%3A9b210386272de8b066&amp;refid=11#fua');
print_r($pages->fblogout());
//$pages->fbSendMsg(':)');
?>