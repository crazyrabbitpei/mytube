<?php session_start(); ?>
<?php
$denytime=0;
if($_SESSION['username']==null){
	echo "Deny Permission<br>";
	//header("http/1.1 403 Forbidden");
	$url ='user/login.php';
	//echo $url;
	header("Location:$url");
	//exit();
	//echo "<meta http-equiv=REFRESH CONTENT=$denytime;url='$url'>";
}
else{
	$name = $_SESSION['username'];
	$uid = $_SESSION['uid'];
	$list = $_POST['list'];
	$option = $_POST['option'];
	$listNo = $_POST['listNo'];
	$totalv = $_POST['totalv'];
	$order = "";
	$user = 'uid';
	$record = 'slist';
	if($option=='1'){
                $tableName = "myList";
                $column = 'list';
                $order = '';
        }
        else if($option=='2'){
                $tableName = "myHistory";
                $column = 'ts';
                $order = 'order by ts DESC';
        }
        else if($option=='3'){
                $tableName = "myUpload";
                $column = 'list';
                $order = 'order by ts DESC';
        }
        else if($option=='4'){
                $tableName = "mySub";
                $column = 'uid';
                $order = '';
                $user = 'myid';
        }
}
?>
<?php
ini_set('display_errors','Off');
error_reporting(E_ALL);	
include("connectdb.php");
include("str.php");
?>
<?php
/*----------manage detail-------------------------*/
$maintable = "Basic";
//$tableName = "myList";//Bascic:global,HistoryM:history record ,SelfM:self music pack, Default is Basic table
/*----------Other count----------------------*/
$cdata = 0;
$clist = 0;
/*----------Start count time----------------------*/
$time_start = microtime(true);
/*----------End count time----------------------*/
$time_end = microtime(true);
$time = $time_end - $time_start;
/*----------use ajax:return result------------------------*/
$rows = array();
if($option==1){
	$check = "select * from ".$record." where myid='".$uid."' and list='".$list."'";
	if($result1 = mysql_query($check)){
		$row = mysql_fetch_array($result1);
		if($row['sort']=='標題'){
                        $order = "order by $maintable.title";
                }
                else if($row['sort']=='最熱門'){
                        $order = "order by $maintable.viewCount DESC";
                }
                else if($row['sort']=='新增日期 (最新 - 最舊)'){
                        $order = "order by $tableName.ts DESC";
                }
                else if($row['sort']=='新增日期 (最舊 - 最新)'){
                        $order = "order by $tableName.ts ASC";
                }
                else if($row['sort']=='發佈日期 (最新 - 最舊)'){
                        $order = "order by $maintable.published DESC";
                }
                else if($row['sort']=='發佈日期 (最舊 - 最新)'){
                        $order = "order by $maintable.published ASC";
                }
	}
}
$display_list = "select * from $maintable,$tableName where $maintable.id=$tableName.id and $tableName.$column='".$list."' and $tableName.$user='$uid' $order";
$clist = $clist+1;
$cdata = 0;

if($result_display_list = mysql_query($display_list)){
	print "<ul style='margin-bottom: 2px;'>";
	while($array_display_list = mysql_fetch_array($result_display_list)){
		print "<li><div class='mCSB_container_open' onclick=\"openlist('$list','$option','$cdata')\"><span class='item'>";
		$query2 = "select * from ".$maintable." where id='".$array_display_list['id']."'";
		if($result2 = mysql_query($query2)){ 
			$array_result2 = mysql_fetch_array($result2);

			if($option=='1'){
				$other = "<div class='hviewc'><span style='font-size:25px'>".$array_result2['duration']."</span>分鐘</div>";
			}
			else if($option=='2'){
				$other = "<div class='hviewc'>已看過<span style='font-size:25px'>".$array_display_list['count']."</span>次</div>";
			}
			else if($option=='3'){
				if($array_display_list['lim']=='public'){
					$array_display_list['lim'] = '公開';
					$icon = 'image/un_lock.png';
				}

				else if($array_display_list['lim']=='hide'){
					$array_display_list['lim'] = '不公開';
					$icon = 'image/lock.png';
				}
				else if($array_display_list['lim']=='private'){
					$array_display_list['lim'] = '私人';
					$icon = 'image/self3.png';
				}
				//$other = "<div class='hviewc'><span style='font-size:25px'>".$array_display_list['lim']."</span></div>";
				$other = "<div class='hviewc'><img src='$icon'></img></div>";
			}
			else if($option=='4'){
				$other = '';
			}
			
			if($array_result2['title']==null){
				$title =  $array_display_list['title']."[Video has been removed.]";
				$delete = "delete from ".$tableName." where id='".$array_display_list['id']."'";
                                if($result = mysql_query($delete)){
                                        //print "Delete : ".$id." from ".$maintable;
                                }
				$smallp = "https://s.ytimg.com/yts/img/no_thumbnail-vfl4t3-4R.jpg";
				$link = "";
				print"		<img style='width: 100%;height: 100%;'class='preview' src='".$smallp."'></img>
						<div class='cover'></div>

						<div class='title bold'>[Video has been removed]</div>
						</span>

						<div class='list_title'>$title</div>
						<div class='list_content'>Author : ".$array_result2['author']."<br>Published : ".$array_result2['published']."<span style='position:relative;left:30px'>ViewCount : ".$array_result2['viewCount']."</span><span style='position:relative;left:60px'>Category : ".$array_result2['category']."</span></div>
						</div>
						<div class='action' onclick=\"editvideo('".$array_display_list['id']."','".$tableName."','1','$list','$listNo','$cdata','$totalv')\">
							<span class='add'>-</span>
						</div>
					</li>
				";

			}
			else{
				//$title = $array_result2['title'];
				$title = $array_display_list['title'];
				/*-----------------------get video icon----------------------------------*/
				$smallp = 'http://i.ytimg.com/vi_webp/'.$array_result2['id'].'/default.webp';
				$link = 'http://www.youtube.com/watch?v='.$array_result2['id'];
				if(file_exists($smallp)){
				}
				else{
					$smallp = 'http://i.ytimg.com/vi/'.$array_result2['id'].'/mqdefault.jpg';
				}
			
				//option 3:delete, no update
				print"	<img class='preview' src='".$smallp."'></img>
						<div class='cover'></div>

						</span>

						".$other."
						<div class='list_title'>$title</div>
						<div class='list_content'>Author : ".$array_result2['author']."<br>Published : ".$array_result2['published']."<span style='position:relative;left:30px'>ViewCount : ".$array_result2['viewCount']."</span><span style='position:relative;left:60px'>Category : ".$array_result2['category']."</span></div>


						</div>	

						<div class='action'>
							<span class='add' onclick=\"editvideo('".$array_result2['id']."','".$tableName."','$option','$list','$listNo','$cdata','$totalv')\">-</span>";
				if($option==3){			
					print	"<button class='set_list' onclick=\"editownvideo('".$array_result2['id']."','".$option."')\">編輯影片</button>";		
				}
				print	"</div> </li>";
			}
		}
		$cdata=$cdata+1;
	}		
}
?>
