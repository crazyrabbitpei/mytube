<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
<?php
$_SESSION['username'] = $_POST[name];
include("connectuserdb.php");
$denytime=0;
$time=2;

if($_SESSION['username']==null){
	unset($_SESSION['username']);
	header("Location:create.php");
	//echo "<meta http-equiv=REFRESH CONTENT=$denytime;url=create.php>";
}

else{
	echo $_SESSION['username'];
	$link=$_SESSION['link'];
	if(!(ereg("^[A-Za-z0-9_]+$",$_POST[name])) ||!(ereg("^[A-Za-z0-9_]+$",$_POST[psw])) ||!(ereg("^[A-Za-z0-9_]*@+[A-Za-z0-9]*",$_POST[mailaddr]))){
		echo "Please input A-Z a-z 0-9 or _ words for correct form.";	
		echo "<meta http-equiv=REFRESH CONTENT=$time;url=create.php>";
	}
	else{
		$verify = "select * from User where Name='$_POST[name]' or Mail='$_POST[mailaddr]'";
		$v_array = mysql_query($verify);
		$v_result = mysql_fetch_array($v_array);
		if($v_result['Name']==$_POST['name']&&$v_result['Name']!=NULL){
			echo "<h1>Error</h1><p>The User [$v_result[Name]] has been apply, please change another.<p>";
			?>
				<input type='button' value='Back to create User' onclick="self.location.href='create.php'"></input>
				<?php
		}
		else if($v_result['Mail']==$_POST['mailaddr']&&$v_result['Mail']!=NULL){
			echo "<h1>Error</h1><p>The e-mail [$v_result[Mail]] has been use, please change another.</p>";
			?>
				<input type='button' value='Back to create User' onclick="self.location.href='create.php'"></input>
				<?php
		}
		else{
			$sql = "INSERT INTO User (Name,Passw,Mail) values('$_POST[name]','$_POST[psw]','$_POST[mailaddr]')";
			if (mysql_query($sql)&& $_POST[name]!=null&& $_POST[psw]!=null && $_POST[mailaddr]!=null){

				setcookie("user","",time()-3600);
				setcookie("psw","",time()-3600);
				echo "Success apply.";
				$sql_uid = "SELECT uid FROM User WHERE Name='$_POST[name]'";
				$result_uid=mysql_query($sql_uid);
				$uid = mysql_fetch_array($result_uid);
				$_SESSION['uid']=$uid[0];
				echo "<meta http-equiv=REFRESH CONTENT=$time;url='../2home.php'>";
			}
			else{
				if($_POST[name]==null  || $_POST[psw]==null || $_POST[mailaddr]==null){
					echo "Please key all data completely.";
					echo "<meta http-equiv=REFRESH CONTENT=$time;url=create.php>";
				}
				else{
					echo  mysql_error();#1062 for Duplicate entry 'rabbit' for key 'Name'
						//echo "<meta http-equiv=REFRESH CONTENT=$time;url=create.php>";
				}
			}
		}
	}
}
?>
</body>
</html>
