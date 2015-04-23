<?php session_start(); ?>
<?php
	$time=0;
	$denytime=0;
        if($_SESSION[username]==null){
        	echo "Deny Permission";
        	header("Location:login.php");
        	//echo "<meta http-equiv=REFRESH CONTENT=$denytime;url=login.php>";
        }
	else{
		unset($_SESSION['username']);
		unset($_SESSION['uid']);
		mysql_close($_SESSION['link']);
		unset($_SESSION['link']);
		mysql_close($_SESSION['video_link']);
		unset($_SESSION['video_link']);

		echo "Log Out Success.";
		echo "<meta http-equiv=REFRESH CONTENT=$time;url=login.php>";
	}
?>
