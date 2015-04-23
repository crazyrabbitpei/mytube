<?php session_start(); ?>
<?php
ini_set('display_errors','Off');
error_reporting(E_ALL);
include("connectdb.php");
$name = $_SESSION['username'];
$uid = $_SESSION['uid'];
//$uid=$_POST['uid'];
$id = $_POST['id'];
$list =$_POST['list'];
$lim=$_POST['lim'];
$title = $_POST['title'];
$title = mysql_real_escape_string($title);


$table = "myList";
$record = "slist";
$maintable = "Basic";

//mysql_query("SET CHARACTER_SET_CLIENT='utf8'");
//mysql_query("SET NAMES 'UTF8'");

//mysql_query("SET CHARACTER_SET_RESULTS='utf8'");
$query = "select * from ".$maintable." where id='".$id."'";
if($result = mysql_query($query)){
	$row = mysql_fetch_array($result);
	$check = "select * from ".$record." where myid='".$uid."' and list='".$list."'";
	if($result1 = mysql_query($check)){
                $row = mysql_fetch_array($result1);
                if($row['list']==$list){
                        //print "This list name has already exists.";
                }
                else{
			$query = "insert into ".$record." (myid,name,list,lim,sort) values ('".$uid."','".$name."','".$list."','".$lim."','新增日期 (最新 - 最舊)')";
                        if(mysql_query($query)){
                                //print "Success add list : $list";
                        }
                        else{
                                //print "False:".$query;
                        }
                }
        }
	
	$query = "insert into ".$table." (uid,id,list,title) values ('".$uid."','".$id."','".$list."','".$title."')";

	//print $query;
	$check = "select id from ".$table." where id='".$id."' and uid='".$uid."' and list='".$list."'";
	if($result1 = mysql_query($check)){
		$row = mysql_fetch_array($result1);
		if($row['id']==$id){
			print "This video has already exists in $list";
		}
		else{
			if(mysql_query($query)){
				print "Success add to $list";
			}
			else{
				print "False:".$query;
			}
		}
	}
}
else{
	print "False";
}
?>

