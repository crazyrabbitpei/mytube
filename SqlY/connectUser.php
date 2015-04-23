<?php session_start(); ?>
<?php
$denytime=0;
	if($_SESSION['username']==null){
		echo "Deny Permission<br>";
		//header("http/1.1 403 Forbidden");
		$url ='user/login.php';
		//echo $url;
		header("Location:$url");
		//exit();
		//echo "<meta http-equiv=REFRESH CONTENT=$denytime;url='$url'>";
	}
	else{
		$name = $_SESSION['username'];
	}
$db = "account";
$link = mysql_connect('localhost', 'username', 'password');
$_SESSION['video_link']=$link;
if (!$link) {
        die('Could not connect: ' . mysql_error());
}
if(!mysql_select_db($db,$link)){
	die('Coul not use db:' .$db);	
}
?>
