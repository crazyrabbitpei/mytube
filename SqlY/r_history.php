<?php session_start(); ?>
<?php
ini_set('display_errors','On');
error_reporting(E_ALL);
include("connectdb.php");
$uid=$_POST['uid'];
$id = $_POST['id'];
$title = $_POST['title'];

$title = mysql_real_escape_string($title);

/*
$content = $_POST['content'];
$category = $_POST['category'];
$fcount = $_POST['fcount'];
$viewc = $_POST['viewc'];
$author = $_POST['author'];
$keyword = $_POST['keyword'];
$published = $_POST['published'];
$duration = $_POST['duratoin'];
*/

$maintable = 'Basic';
$query1 = "update ".$maintable." set viewCount=viewCount+1 where id='".$id."'";
if($result = mysql_query($query1)){
	print "suc:$query1";
}
else{
	print "fail:$query1";
}	
$table = "myHistory";

$d = date("Y-m-d");
$query = "insert into ".$table." (uid,id,title,count,ts) values ('".$uid."','".$id."','".$title."',1,'".$d."')";
$check = "select id from ".$table." where id='".$id."' and uid='".$uid."'";
if($result = mysql_query($check)){
		$row = mysql_fetch_array($result);
		
		if($row['id']!=null){
			$query1 = "update ".$table." set count=count+1,ts='".$d." 'where id='".$id."' and uid='".$uid."'";	
			if($result = mysql_query($query1)){
				
				print "Success!";
			}
			else{
				print "False:".$query1;
			}
		}
		else{
			if(mysql_query($query)){
				print "Success!";
			}
			else{
				print "False:".$query;
			}
		}
}
else{
	print "False:[".$check."]";
}
?>

