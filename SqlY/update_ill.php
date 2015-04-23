<?php session_start(); ?>
<?php
ini_set('display_errors','Off');
error_reporting(E_ALL);
include("connectdb.php");
$name = $_SESSION['username'];
$uid = $_SESSION['uid'];
$list =$_POST['list'];
$ill=$_POST['ill'];
$option=$_POST['option'];
$ill = mysql_real_escape_string($ill);
$list = mysql_real_escape_string($list);


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
		$query = "update ".$record." set ill='".$ill."' where $user='".$uid."' and list='".$list."'";
		if(mysql_query($query)){
			
			//print "Success update to $list:$ill";
		}
		else{
			//print "False:".$query;

		}
	}
}
?>

