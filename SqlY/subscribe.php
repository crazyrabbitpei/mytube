<?php
ini_set('display_errors','Off');
error_reporting(E_ALL);
//include("connectUser.php");
include("connectdb.php");
$myid = $_POST['myid'];
$uid = $_POST['uid'];
$maintable = "Basic";
$table = "mySub";
$date = date(DATE_ATOM);
$check = "select * from ".$maintable." where uid='".$uid."'";
if($result = mysql_query($check)){
	$row = mysql_fetch_array($result);
	//mysql_close($link);
	if($row['uid']!=null){
		$check = "select * from ".$table." where uid='".$uid."' and myid='".$myid."'";
		if($result1 = mysql_query($check)){
			$row1 = mysql_fetch_array($result1);
			if($row1['uid']==null){
				$query = "insert into ".$table."(myid,uid,author,ts,newsub) values ('".$myid."','".$uid."','".$row['author']."','".$date."','0')";
				if(mysql_query($query)){
					echo "Success subscribe:".$uid."Name:".$row['author'];
					//echo "query:".$query;
				}
				else{
					//echo "False:".$query;
				}
			}
			else{
				echo "has subscribed.";
			}
		}
		else{
			//echo "False:".$check." result1:".$result1;
		}
	}
	else{
		echo "You can't subscribe this user.";
	}
}
else{
	echo "False:".$check;
}
?>

