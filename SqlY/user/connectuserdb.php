<?php
$denytime=0;
if($_SESSION['username']==null){
        //echo "<meta http-equiv=REFRESH CONTENT=$denytime;url=login.php>";
	header("Location:login.php");
}
$db = "account";
$link = mysql_connect('localhost', 'username', 'password');
$_SESSION['link']=$link;
if (!$link) {
        die('Could not connect: ' . mysql_error());
}
if(!mysql_select_db($db,$link)){
	die('Coul not use "$db" ');	
}
?>
