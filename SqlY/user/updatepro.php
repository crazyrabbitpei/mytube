<?php session_start(); ?>
<?php
include("connectuserdb.php");
$link=$_SESSION['link'];
$time=2;
$denytime=0;
if($_SESSION[username]==null){
	echo "Deny Permission";
	echo "<meta http-equiv=REFRESH CONTENT=$denytime;url=login.php>";
}
$verify = "select * from User where Mail='$_POST[mailaddr]'";
$v_array = mysql_query($verify);
$v_result = mysql_fetch_array($v_array);
if((!(ereg("^[A-Za-z0-9]+$",$_POST[psw])) && $_POST[psw]!=NULL) || (!(ereg("^[A-Za-z0-9_]*@+[A-Za-z0-9]*",$_POST[mailaddr])) && $_POST[mailaddr]!=NULL)){
	header("Location:profile.php");
}
else if ($_POST[psw]!=null && $_POST[mailaddr]!=null){
	if($v_result['Mail']==$_POST['mailaddr']){
		echo "<h1>Error</h1><p>The e-mail [$v_result[Mail]] has been used, please change another.<p>";
		?>
			<input type='button' value='Back to create User' onclick="self.location.href='profile.php'"></input>
			<?php
	}
	else{
		$sql = "UPDATE User SET Passw='$_POST[psw]', Mail='$_POST[mailaddr]' WHERE Name='$_SESSION[username]'";
		if(mysql_query($sql)){
			echo "Success Update Password and Email address.";
			echo "<meta http-equiv=REFRESH CONTENT=$time;url='../2home.php'>";
		}
		else{
			echo mysql_error();
			echo "<meta http-equiv=REFRESH CONTENT=$time;url=profile.php>";
		}
	}
}
else if($_POST[psw]==null && $_POST[mailaddr]==null){
	//echo "Noting change.";
	mysql_close($link);
	header("Location:profile.php");
}
else if($_POST[mailaddr]==null){
	$sql = "UPDATE User SET Passw='$_POST[psw]' WHERE Name='$_SESSION[username]'";
	if(mysql_query($sql)){
		echo "Success Update Password.";
		echo "<meta http-equiv=REFRESH CONTENT=$time;url='../2home.php'>";
	}
	else{
		echo mysql_error();
		echo "<meta http-equiv=REFRESH CONTENT=$time;url=profile.php>";
	}
}
else if($_POST[psw]==null){
	if($v_result['Mail']==$_POST['mailaddr']){
		echo "<h1>Error</h1><p>The e-mail [$v_result[Mail]] has been used, please change another.<p>";
		?>
			<input type='button' value='Back to create User' onclick="self.location.href='profile.php'"></input>
			<?php
	}
	else{
		$sql = "UPDATE User SET Mail='$_POST[mailaddr]' WHERE Name='$_SESSION[username]'";
		if(mysql_query($sql)){
			echo "Success Update Email address.";
			echo "<meta http-equiv=REFRESH CONTENT=$time;url='../2home.php'>";
		}	
		else{
			echo mysql_error();
			echo "<meta http-equiv=REFRESH CONTENT=$time;url=profile.php>";
		}
	}
}

?>
