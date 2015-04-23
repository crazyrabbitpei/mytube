<?php session_start(); ?>
<?php
ini_set('display_errors','Off');
error_reporting(E_ALL);
include("connectdb.php");
include("str.php");
$name = $_SESSION['username'];
$uid = $_SESSION['uid'];
//$uid=$_POST['uid'];
$list =$_POST['list'];
$lim=$_POST['lim'];
$sort=$_POST['sort'];
$option=$_POST['option'];
$lim = mysql_real_escape_string($lim);
$list = mysql_real_escape_string($list);
$sort = mysql_real_escape_string($sort);


$table = "myList";
$record = "slist";
$maintable = "Basic";
$user = 'myid';
                if($option=='1'){
                        $record = "slist";
                }
                else if($option=='2'){
                        $record = "myHistory";
                        $user = 'uid';
                }
                else if($option=='3'){
                        $record = "myUpload";
                        $user = 'uid';
                }
                else if($option=='4'){
                        $record = "mySub";
                        $user = 'uid';
                }
	

$check = "select * from ".$record." where $user='".$uid."' and list='".$list."'";
if($result1 = mysql_query($check)){
	$row = mysql_fetch_array($result1);
	if($row['list']==$list){
		if($option==3){
			$query = "update ".$record." set lim='".$lim."' where $user='".$uid."' and list='".$list."'";
			if($lim=='public' && $row['lim']!='public'){
				$query1 = "update mySub set newsub=newsub+1 where uid='".$uid."'";
				if($result = mysql_query($query1)){
					print "notice Success!";
				}
				else{
					print "False:".$query1;
				}
			}
		}
		else{
			$query = "update ".$record." set lim='".$lim."' , sort='".$sort."' where $user='".$uid."' and list='".$list."'";
		}
		if(mysql_query($query)){
			print "Success update";
		}
		else{
			print "False:".$query;

		}
	}
}
?>

