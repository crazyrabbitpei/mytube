<?php session_start(); ?>
<?php
ini_set('display_errors','Off');
error_reporting(E_ALL);
include("connectdb.php");
include("str.php");

$uid = $_SESSION['uid'];
$author = $_SESSION['username'];
$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];
$category = $_POST['category'];
$lim = $_POST['lim'];
$list = $_POST['list'];
$time=3;

//htmlentities($title,ENT_QUOTES);
echo "title:".$title."<br>";
//htmlentities($content,ENT_QUOTES);
echo "content:".$content."<br>";
echo "lim:".$lim."<br>";
//$id = html_entity_decode($id);
//$title = html_entity_decode($title);
//$content = html_entity_decode($content);
//$author = html_entity_decode($author);

/*
$fcount = $_POST['fcount'];
$viewc = $_POST['viewc'];
$keyword = $_POST['keyword'];
$published = $_POST['published'];
$duration = $_POST['duratoin'];
*/
$maintable = "Basic";
$table = "myUpload";
$subtable = "mySub";

//$title = replace($title);
//$content = replace($content);
//$author = replace($author);
//$list = replace($list);

$id = mysql_real_escape_string($id);
$title = mysql_real_escape_string($title);
$content = mysql_real_escape_string($content);
$author = mysql_real_escape_string($author);
$list = mysql_real_escape_string($list);

$date = date(DATE_ATOM);
$query = "insert into ".$maintable." (id,title,content,favoriteCount,viewCount,author,category,keyword,published,duration,uid) values ('".$id."','".$title."','".$content."',0,0,'".$author."','".$category."','123','".$date."','0','".$uid."')";
$check = "select id from ".$maintable." where id='".$id."'";

if($result = mysql_query($check)){
		$row = mysql_fetch_array($result);
		if($row['id']!=null){
			echo "You can't upload:".$row['id'];
			header("refresh:$time; url='video_upload.php'");
		}
		else{
			if(mysql_query($query)){
				/*$query1 = "select * from $table where uid='$uid' and list='$list'";
				print $query1;
				if($result = mysql_query($query1)){
					$row = mysql_fetch_array($result);
					if($row['list']!=null){
                 			       echo $row['list']." has exist";
						$query = "update ".$table." set lim='".$lim."' where uid='".$uid."' and list='$list'";
						if(mysql_query($query)){
							print "success:$query<br>";
						}
						else{print "false:$query<br>";}
			                }*/			
						$query = "insert into ".$table."(uid,id,ts,title,list,lim) values ('".$uid."','".$id."','".$date."','".$title."','".$list."','".$lim."')";
						if(mysql_query($query)){
							print "Success!:".$query."<br>";
							if($lim!='public'){
							}
							else{
								$query1 = "update ".$subtable." set newsub=newsub+1 where uid='".$uid."'";
								if($result = mysql_query($query1)){
									print "notice Success!";
								}
								else{
									print "False:".$query1;
								}
							}
							header("refresh:$time; url='video_upload.php'");
						}
						else{
							print "False:".$query;
						}
				//}
			}
			else{
				print "False:".$query;
			}
		}
}
else{

}

?>

