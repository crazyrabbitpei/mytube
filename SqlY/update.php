<?php
ini_set('display_errors','On');
error_reporting(E_ALL);
include("connectdb.php");
$uid = $_SESSION['uid'];
$title = $_POST['title'];
$content = $_POST['content'];
$category = $_POST['category'];
$list = $_POST['list'];
$lim = $_POST['lim'];
$table = "myUpload";
$id = $_POST['id'];
$maintable = "Basic";
if($lim==''){
	$lim='私人';
}
$title = mysql_escape_string($title);
$content = mysql_escape_string($content);
$id = mysql_escape_string($id);
$check = "select * from ".$table." where $user='".$uid."' and list='".$list."'";
if($result1 = mysql_query($check)){
        $row = mysql_fetch_array($result1);
}
$query = "update ".$maintable." set title='".$title."',content='".$content."',category='$category' where id='".$id."'";

if(mysql_query($query)){ 
	print "<br>Update ".$maintable." Success!<br>";	
	print "<br>Result : <br>".$title."<br>".$content."<br>".$category."------------------<br>";
	
	$query = "update ".$table." set title='".$title."',list='$list',lim='$lim' where id='".$id."' and uid='$uid'";
	if(mysql_query($query)){ 
		if($lim=='public' && $row['lim']!='public'){
                                $query1 = "update mySub set newsub=newsub+1 where uid='".$uid."'";
                                if($result = mysql_query($query1)){
                                        print "notice Success!";
                                }
                                else{
                                        print "False:".$query1;
                                }
                 }
		//print "<br>Update ".$table." Success!<br>";	
		//print "<br>Result : <br>".$title."<br>list:$list<br>lim:$lim";
	}
	header("refresh:1; url='video_manage.php?option=3'");
}
else{
	print "false";
}
?>
