<?php
include '../httpcurl.php';
include '../fbform.php';
if(isset($_POST['usr']) && isset($_POST['pw'])){
	$pages = new FBform();
	$pages->get('http://m.facebook.com');
	$pages->fblogin($_POST['usr'], $_POST['pw']);
	header ("location: ../");
}
if(file_exists('../'.cookie)){
	header ("location: ../");
}else{
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<style type="text/css">
body {
	background-color: rgba(255,255,255,1);
	margin: 0px;
}
body,td,th {
	color: rgba(59,89,152,1.00);
	font-family: Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;
}
a:link {
	color: rgba(88,88,88,1);
	text-decoration: none;
}
a:visited {
	color: rgba(88,88,88,1);
	text-decoration: none;
}
a:hover {
	color: rgba(88,88,88,1);
	text-decoration: underline;
}
a:active {
	color: rgba(88,88,88,1);
	text-decoration: none;
}
.top{
	height: 38px;
	display: block;
	margin: 0px;
	padding: 0px;
	position: absolute;
	top: 0px;
	left: 0px;
	right: 0px;
	background-color: rgba(59,89,152,1.00);
	-webkit-box-shadow: 0px 3px 3px rgba(0,0,0,0.21);
	box-shadow: 0px 2px 2px rgba(0,0,0,0.21);
	border-bottom: 2px solid rgba(50,78,134,1.00);
	z-index: 500;
}
.logo{
	margin-left: -75px;
	left: 50%;
	position: relative;
	height: 38px;
	width: 150px;
	background-size: cover;
	background-repeat: no-repeat;
	background-position: center;
	background-image: url(img/ico.png);
}
.login{
	background-color: rgba(224,230,243,1.00);
	width: 450px;
	margin-left: -225px;
	left: 50%;
	position: relative;
	z-index: 0;
	padding-bottom: 20px;
	border-bottom-left-radius: 3px;
	border-bottom-right-radius: 3px;
	padding-top: 45px;
}
.form{
	background-color: rgba(255,255,255,1.00);
	display: block;
	border: 1px solid rgba(178,199,233,1.00);
	margin-top: 20px;
	margin-right: 25px;
	margin-left: 25px;
	margin-bottom: 10px;
	border-radius: 8px;
}
.ip1, .ip2{
	margin: 0px;
	padding-top: 2px;
	padding-right: 5px;
	padding-left: 5px;
	padding-bottom: 2px;
	color: rgba(88,88,88,1.00);
	font-size: 16px;
	line-height: 30px;
	font-family: Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;
	-webkit-box-shadow: inset 0px 0px 0px rgba(0,0,0,0.00);
	box-shadow: inset 0px 0px 0px rgba(0,0,0,0.00);
	width:386px;
	border: none;
	outline:none;
}
.ip1{
	border-top-right-radius: 8px;
	border-top-left-radius: 8px;
}
.ip2{
	border-bottom-left-radius: 8px;
	border-bottom-right-radius: 8px;
}
.btns{
	color: rgba(255,255,255,1.00);
	text-shadow: -1px -1px 0px rgba(59,89,152,1.00);
	border: 1px solid rgba(59,89,152,1.00);
	border-radius: 3px;
	-webkit-box-shadow: 1px 1px rgba(88,88,88,0.36);
	box-shadow: 1px 1px rgba(88,88,88,0.36);
	line-height: 25px;
	margin-left: 26px;
	padding-top: 0px;
	padding: 0px;
	line-height: 35px;
	width: 398px;
	font-size: 17px;
	background-image: -webkit-linear-gradient(270deg,rgba(59,89,152,0.82) 0%,rgba(59,89,152,1.00) 100%);
	background-image: linear-gradient(180deg,rgba(59,89,152,0.82) 0%,rgba(59,89,152,1.00) 100%);
}
.hr{
	background-color: rgba(190,208,237,1.00);
	height: 1px;
	border: none;
	padding: 0px;
	margin: 0px;
}
.log{}
.log .title{}
.log .content{}
.smwtf{
	color: rgba(59,89,152,1.00);
	text-shadow: 1px 1px rgba(59,89,152,0.29);
	position: absolute;
	bottom: 25px;
	right: 25px;
}
</style>
</head>

<body>
<div class="top"><div class="logo"></div></div>
<div class="login">
	<form action="./" method="post">
        <div class="form">
            <input name="usr" type="email" autofocus required="required" class="ip1" id="ip1" placeholder="Email" autocomplete="off">
            <hr class="hr">
            <input name="pw" type="password" required="required" class="ip2" id="ip2" placeholder="Senha" autocomplete="off">
      </div>
      <input class="btns" type="submit">
  </form>
</div>
<div class="log">
	<div class="title"></div>
    <div class="content"></div>
</div>
<a class="smwtf" href="http://fb.com/smwtf" title="Samuel Caldas" target="_blank">@samuelcaldas</a>
</body>
</html>
<?php
}
?>