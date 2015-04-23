<?php
ini_set('display_errors','On');
error_reporting(E_ALL);
include("connectdb.php");
?>
<?php
$time = 0;
$list = $_POST['list'];
$table = $_POST['table'];
//delete option:1 from video_manage; option:2 from upload_manage; option:3 from history_manage
$option= $_POST['option'];
$uid = $_SESSION['uid'];	
$user = "uid";
	if($option=='1'){
                $tableName = "myList";
                $column = 'list';
                $order = '';
        }
        else if($option=='2'){
                $tableName = "myHistory";
                $column = 'ts';
                $order = '';
        }
        else if($option=='3'){
                $tableName = "myUpload";
                $column = 'list';
                $order = '';
        }
        else if($option=='4'){
                $tableName = "mySub";
                $column = 'uid';
                $order = '';
                $user = 'myid';
        }



$table = mysql_real_escape_string($tableName);
$list = mysql_real_escape_string($list);
//$list = addslashes($list);
//$table = addslashes($table);

$record = "slist";
$maintable = "Basic";

//if($option==1 && $table=="myList"){//delete list
	//echo "option:".$option." table:".$table."<br>";
	if($option==3){	
		$query1 = "select * from $table where $user='$uid' and $column='$list'";
		if($result = mysql_query($query1)){
			while($array_result = mysql_fetch_array($result)){
				$query2 = "delete from ".$maintable." where $user='".$uid."' and id='".$array_result['id']."'";
				if($result = mysql_query($query2)){
                        	}
			}
		}
	}
	$query2 = "delete from ".$table." where $user='".$uid."' and $column='$list'";
	if($result = mysql_query($query2)){
		print "Delete list : ".$list;
		if($option==1){
			$query2 = "delete from ".$record." where myid='".$uid."' and list='$list'";
			if($result = mysql_query($query2)){
			}
			else{
				echo "false:".$query2;
			}
		}
	}
	else{
		echo "false:".$query2;
	}
//}

//else{
//	echo "not find ".$list." in".$table; 
//}

//check url and whether video is exist in $table(myList,myUpload,myHistory) or not;
/*if($option!=0 && $option!=1 && $option!=2 && $option!=3){
	header("Location:2home.php");
	//echo "option:".$option." table:".$table;
	return;
}
else if(($option==1 && $table!=$myList) || ($option==2 && $table!=$myUpload)|| ($option==3 && $table!=$myHistory)){
	header("Location:2home.php");
	//echo "option:".$option." table:".$table;
	return;
}
else if($result = mysql_query($query1)){
	$row = mysql_fetch_array($result);
	if($row==null){
		header("Location:2home.php");
		return;
	}
}

//check permission
if($result = mysql_query($query)){
	$row = mysql_fetch_array($result);
	if($row['uid']!=$uid){
		if($option==0||$option==2){
			print "You have no permission.";
			header("refresh:$time; url='2home.php'");
			return;
		}
	}
}
else{
	print "error";
	return;
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
else if($option==1||$option==2||$option==3){//delete option:1 from video_manage; option:2 from upload_manage; option:3 from history_manage
	$query1 = "delete from ".$table." where id='".$id."'";
	if($result = mysql_query($query1)){
		print "Delete : ".$id." from ".$table."<br>";
		if($option==3){
			header("refresh:$time; url='history_manage.php'");
		}
		else if($option==2){
			$query1 = "delete from ".$maintable." where id='".$id."'";
			if($result = mysql_query($query1)){
				print "Delete : ".$id." from ".$maintable."<br>";
				header("refresh:$time; url='upload_manage.php'");
			}
			else{
				print "error.";
			}
		}
		else if($option==1){
			header("refresh:$time; url='video_manage.php'");
		}
	}
	else{
		print "error.";
	}
}
*/
?>
