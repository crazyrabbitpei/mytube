<?php session_start(); ?>
<?php 
$_SESSION['username'] = $_POST[name];
include("connectuserdb.php");
$time=0;
$denytime=0;
if($_SESSION['username']==null){
	unset($_SESSION['username']);
	header("Location:login.php");
	//echo "<meta http-equiv=REFRESH CONTENT=$denytime;url=login.php>";
}
if(!(ereg("^[A-Za-z0-9_]+$",$_POST[name])) ||!(ereg("^[A-Za-z0-9]+$",$_POST[psw]))){
	echo "<h1>Error</h1><p>Name or Password can't be blank.Or please input correct form</p>";
	unset($_SESSION['username']);
        ?>
	<input type='button' value='Back to sign in' onclick="self.location.href='login.php'"></input>
	<?php
	//echo "<meta http-equiv=REFRESH CONTENT=$time;url=login.php>";
}
else{
	$_POST[name] = mysql_real_escape_string($_POST[name]);
	$_POST[psw] = mysql_real_escape_string($_POST[psw]);
	$link=$_SESSION['link'];
	$sql_name = "SELECT * FROM User WHERE Name='$_POST[name]'";
	$sql_uid = "SELECT uid FROM User WHERE Name='$_POST[name]'";
	$sql_psw = "SELECT Passw FROM User WHERE Passw='$_POST[psw]' and Name='$_POST[name]'";
	$result_name=mysql_query($sql_name);
	$result_uid=mysql_query($sql_uid);
	$result_psw=mysql_query($sql_psw);

	if (mysql_fetch_array($result_name)&& $_POST[name]!=null && $_POST[psw]!=null){
#echo "search name:$_POST[name]";
		$result = mysql_fetch_array($result_psw);
		$uid = mysql_fetch_array($result_uid);
		if ($_POST['psw']==$result[0]){
		//if ($_POST['psw']=mysql_fetch_array($result_psw)){
			if($_POST['memory']!=NULL){
				setcookie("user","$_POST[name]",time()+3600);
				setcookie("psw","$_POST[psw]",time()+3600);
			}
			else{
				setcookie("user","",time()-3600);
				setcookie("psw","",time()-3600);
			}
			$_SESSION['uid']=$uid[0];
			
			echo "uid".$_SESSION['uid']."Success log-in,wait 3 seconds.";
			echo "<meta http-equiv=REFRESH CONTENT=$time;url='../2home.php'>";
		}
		else{
			echo "<h1>Error</h1>";
			echo "<p>Password is not correct</p>";
			?>
			<input type='button' value='Back to sign in' onclick="self.location.href='login.php'"></input>
			<?php
			//echo "<meta http-equiv=REFRESH CONTENT=$time;url=login.php>";
		}
	}
	else{
		if($_POST[name]==null){
			echo "<h1>Error</h1>";
			echo "<p>Please input your name.</p>";
			?>
                        <input type='button' value='Back to sign in' onclick="self.location.href='login.php'"></input>
                        <?php
			//echo "<meta http-equiv=REFRESH CONTENT=$time;url=login.php>";
		}
		else if($_POST[psw]==null){
			echo "<h1>Error</h1>";
			echo "<p>Please input your password.</p>";
			?>
                        <input type='button' value='Back to sign in' onclick="self.location.href='login.php'"></input>
                        <?php
			//echo "<meta http-equiv=REFRESH CONTENT=$time;url=login.php>";
		}
		else{
			echo "<h1>Error</h1>";
			echo "<p>Name doesn't exist.</p>";
			?>
                        <input type='button' value='Back to sign in' onclick="self.location.href='login.php'"></input>
                        <?php
			//echo "<meta http-equiv=REFRESH CONTENT=$time;url=login.php>";
		}
	}
}
?>

