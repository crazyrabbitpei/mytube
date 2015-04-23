<?php session_start(); ?>
<?php
//ini_set('display_errors','On');
//error_reporting(E_ALL);
include("connectdb.php");
?>
<?php
$time = 1;
$id = $_POST['id'];
$table = $_POST['table'];
//delete option:1 from video_manage; option:2 from upload_manage; option:3 from history_manage
$option= $_POST['option'];
$list= $_POST['list'];
$uid = $_SESSION['uid'];	

$table = mysql_real_escape_string($table);
if($optoin==4){
	
}

$id = mysql_real_escape_string($id);
//$id = addslashes($id);
//$table = addslashes($table);

$maintable = "Basic";
$myList = "myList";
$myUpload = "myUpload";
$myHistory = "myHistory";
$mySub = "mySub";

$query = "select id,title,published,content,category,duration,favoriteCount,viewCount,author,uid,keyword from ".$maintable." where id='".$id."'";  
$query1 = "select * from $table where id='$id'";

if($option==4 && $table==$mySub){
	echo "option:".$option." table:".$table;
	$query2 = "select * from $table where uid='$id' and myid='$uid'";
	if($result = mysql_query($query2)){
		$row = mysql_fetch_array($result);
		if($row['uid']==$id){
			echo "find ".$row['uid']." in".$table; 
			$query2 = "delete from ".$table." where uid='".$id."'and myid='$uid'";
			if($result = mysql_query($query2)){
				print "Delete : ".$id." from ".$table;
			}
			else{
				echo "false:".$query2;
			}
		}
		else{
			echo "not find ".$id." in".$table; 
		}
	}
	else{
		echo "false:".$query2;
	}
	return;
}

//check url and whether video is exist in $table(myList,myUpload,myHistory) or not;
if($option!=0 && $option!=1 && $option!=2 && $option!=3 && $option!=10 && $option!=20 && $option!=30){
	echo "option:".$option." table:".$table." list:".$list;
	return;
}
else if((($option==1 || $option==10) && $table!=$myList) || (($option==3 || $option==30) && $table!=$myUpload) || (($option==2 || $option==20) && $table!=$myHistory)){
	//echo "option:".$option." table:".$table;
	return;
}
else if($result = mysql_query($query1)){
	$row = mysql_fetch_array($result);
	if($row==null){
		return;
	}
}

//check permission

if($option==0||$option==3||$optoin==30){
	if($result = mysql_query($query)){
		$row = mysql_fetch_array($result);
		if($row['uid']!=$uid){
			print "You have no permission.";
	echo "option:".$option." table:".$table;
			return;
		}
	}
}
if($option==0){
	if($result = mysql_query($query)){
		$row = mysql_fetch_array($result);
		print $row['id']."<br>
			<form action='update.php' method='post'>
			Title : <input type='text' name='title' value='".$row['title']."'></input><br>
			Content : <br><textarea name='content' style='width:300px;height:200px;'>".$row['content']."</textarea><br>
			<input type='hidden' name='id' value=".$id.">
			<input type='hidden' name='table' value=".$table.">
			<input value='Update' type='submit'></input>
			</form>";
	}
	else{
		print "error.";
	}
}
else if($option==1||$option==2||$option==3||$option==10||$option==20||$option==30){//delete option:1 from video_manage; option:2 from upload_manage; option:3 from history_manage
	print "[list=$list]";
	//$list = urlencode($list);
	if($list==''){
		$query1 = "delete from ".$table." where id='".$id."'";
	}
	else{
		$column='list';
		if($table=='myHistory'){
			$column = 'ts';
		}
		
		$query1 = "delete from ".$table." where id='".$id."' and $column='".$list."'";
	}
	
	if($result = mysql_query($query1)){
		print "Delete : ".$id." from ".$table." list : ".$list;
		if($option==2){
		}
		else if($option==3){
			$query1 = "delete from ".$maintable." where id='".$id."'";
			if($result = mysql_query($query1)){
				print "Delete : ".$id." from ".$maintable;
			}
			else{
				print "option=2:error.";
			}
		}
		else if($option==1){
		}
		else if($option==20){
                }
                else if($option==30){
                        $query1 = "delete from ".$maintable." where id='".$id."'";
                        if($result = mysql_query($query1)){
                                print "Delete : ".$id." from ".$maintable;
                        }
                        else{
                                print "optoin=30:error.";
                        }
                }
                else if($option==10){
			$list = urlencode($list);
                }
	}
	else{
		print $query1."error";
	}
	
}
?>
