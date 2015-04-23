<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>manage video</title>
<script src="video.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="sequences.css?<?php echo date('l jS \of F Y h:i:s A'); ?>"/>
<link rel="stylesheet" type="text/css" href="../../assets/css/famous_styles.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="../../../src/core/famous.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />

<!--<link rel="stylesheet" href="//s.ytimg.com/yts/cssbin/www-core-webp-vflgOrshZ.css" name="www-core" class="css-httpssytimgcomytscssbinwwwcorewebpvflgOrshZcss">-->
<!--<link rel="stylesheet" href="//s.ytimg.com/yts/cssbin/www-pageframe-webp-vflfg8eHa.css" name="www-pageframe" class="css-httpssytimgcomytscssbinwwwpageframewebpvflfg8eHacss">-->
<!--<link rel="stylesheet" href="//s.ytimg.com/yts/cssbin/www-guide-webp-vflhTssWz.css" name="www-guide" class="css-httpssytimgcomytscssbinwwwguidewebpvflhTssWzcss">-->
<!--<link rel="stylesheet" href="//s.ytimg.com/yts/cssbin/www-results-webp-vflIliRQd.css" name="www-results" class="css-httpssytimgcomytscssbinwwwresultswebpvflIliRQdcss">-->
</head>
<body>

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
	$option= $_GET['option'];
	$sort= $_GET['sort'];
	$order ='';
	$user = 'uid';
	if($option=='1'){
                $tableName = "myList";
		$column = 'list';
		$color = 'lightpink';
		if($sort=='title'){
			$order = 'order by list';
		}
		else if($sort=='new'){
			$order = 'order by ts DESC';
		}
		else if($sort=='old'){
			$order = 'order by ts ASC';
		}
		else{
			$order = 'order by ts DESC';
		}
		$manage = 's List';
        }
        else if($option=='2'){
                $tableName = "myHistory";
		$column = 'ts';
		$color = 'lightblue';
                if($sort=='new'){
                        $order = 'order by ts DESC';
                }
                else if($sort=='old'){
                        $order = 'order by ts ASC';
                }
		else{
			$order = 'order by ts DESC';
		}
		$manage = 's History';
        }
        else if($option=='3'){
                $tableName = "myUpload";
		$column = 'list';
		$order = '';
		$manage = 's Upload';
		$color = 'aquamarine';
		if($sort=='title'){
			$order = 'order by list';
		}
		else if($sort=='new'){
                        $order = 'order by ts DESC';
                }
                else if($sort=='old'){
                        $order = 'order by ts ASC';
                }
		else{
			$order = 'order by ts DESC';
		}

        }
        else if($option=='4'){
                $tableName = "mySub";
		$column = 'uid';
		$order = '';
		$user = 'myid';
		$manage = 's Subscribe';
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
$record = 'slist';
$maintable = "Basic";
/*----------Other count----------------------*/
$cdata = 0;
$clist = 0;
/*----------Start count time----------------------*/
$time_start = microtime(true);
/*--------------Mysql search start----------------*/
$temp='';
$query1 = "select DISTINCT $column from ( select * from $tableName  $order) as Tmp where $user='$uid'";
//$query1 = "select DISTINCT $column from $tableName where $user='$uid' $order";
//$query1 = "select $column from $tableName where $user='$uid' $order";
//echo $query1."<br>";
if($result1 = mysql_query($query1)){ 
	/*----------End count time----------------------*/
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	/*----------use ajax:return result------------------------*/
	print "<div id='listc'>";
	while($array_result1 = mysql_fetch_array($result1)){
		//if($temp==$array_result1[$column]){continue;}
		//$temp = $array_result1[$column];
		$display_list = "select * from $tableName where $column='".$array_result1[$column]."' and $user='$uid'";
		$clist = $clist+1;
		$cdata = 0;
		
		
		if($result_display_list = mysql_query($display_list)){
			$videonum = mysql_num_rows($result_display_list);
			if($videonum == 0){
				continue;
			}
			//print "<ul style='margin-bottom: 2px;'><li><div class='mCSB_container' onmouseout=\"normal('".$array_result1['list']."','".$clist."')\"><span class='item'>";
			print "<ul style='margin-bottom: 2px;'><li><div class='mCSB_container' id='mCSB_container_".$clist."' name='mCSB_container_".$clist."' style='background:$color'><span class='item' onclick=\"openlist('".$array_result1[$column]."','$option','0')\">";
			$rows=$rows.','.$array_result1[$column];
			$rows1 = $rows1.','.$videonum;
			while($array_display_list = mysql_fetch_array($result_display_list)){
				$cdata=$cdata+1;
				//if($cdata==4){
					//print "<div class='pull_down' id='video_m_pull_down_".$clist."' onclick=\"pull_down('".$array_result1['list']."','".$clist."','".$option."')\"><span>pull down</span></div>";
					//break;
				//}

				$query2 = "select * from ".$maintable." where id='".$array_display_list['id']."'";
				//echo $query2."<br>";
				if($result2 = mysql_query($query2)){ 
					$array_result2 = mysql_fetch_array($result2);
					if($array_result2['title']==null){
						$title =  $array_display_list['title']."[Video has been removed]";
						$delete = "delete from ".$tableName." where id='".$array_display_list['id']."'";
						if($result = mysql_query($delete)){
							//print "Delete : ".$id." from ".$maintable;
							$videonum--;
						}
 		                               	//$smallp = "https://s.ytimg.com/yts/img/no_thumbnail-vfl4t3-4R.jpg";
						if($cdata==1){
							$smallp = 'http://i.ytimg.com/vi_webp/'.$array_display_list['id'].'/default.webp';
						}
						$link = "";
					}
					else{
						//$title = $array_result2['title'];
						$title = $array_display_list['title'];
						/*-----------------------get video icon----------------------------------*/
						if($cdata==1){
							$smallp = 'http://i.ytimg.com/vi_webp/'.$array_result2['id'].'/default.webp';
							$link = 'http://www.youtube.com/watch?v='.$array_result2['id'];
							if(file_exists($smallp)){
							}
							else{
								$smallp = 'http://i.ytimg.com/vi/'.$array_result2['id'].'/mqdefault.jpg';
							}
						}

					}


					//option 0:update, 1:delete
					//<div class='action' onclick=\"delete_list('".$array_result1['list']."','".$tableName."','0')\">

					//if($cdata<=3){
						//print"	<div class='one_list_container' id='".$array_result2['id']."'>".$cdata.":".$title."</div>";
					//}
					//if(mysql_num_rows($result_display_list)<=3 && $cdata==mysql_num_rows($result_display_list)){
						
					//	if(mysql_num_rows($result_display_list)==2){
							//print "<div class='one_list_container'><br></div>";
					//	}
					//	else if(mysql_num_rows($result_display_list)==1){
							//print "<div class='one_list_container'><br></div>";
							//print "<div class='one_list_container'><br></div>";
					//	}

						//print "<div class='pull_down' id='video_m_pull_down_".$clist."' onclick=\"pull_down('".$array_result1['list']."','".$clist."','$option')\"><span>pull down</span></div>";

					//}
				}
			}
			//播放清單設定尚未完成:隱私權，排序
			//新增說明尚未完成
			//清單改名
			//歌曲註解
			//設定清單縮圖
			if($cdata!=0 && $videonum!=0){
				if($option==1){
					$query1 = "select * from $record where myid= $uid and list='".$array_result1['list']."'";
					if($result = mysql_query($query1)){
						$lim = mysql_fetch_array($result);
						if($lim['lim']=='public'){
							$lim['lim'] = '公開';
						}

						else if($lim['lim']=='hide'){
							$lim['lim'] = '不公開';
						}
						else if($lim['lim']=='private'){
							$lim['lim'] = '私人';
						}

						if($lim['ill']==''){
							$lim['ill']='新增說明';
						}

					}
			

					print "<img class='preview' src='".$smallp."'></img>
						<div class='cover'></div>

						<div class='title bold'>".$array_result1[$column]."</div>
						</span>
						<div class='action' onclick=\"delete_list('".$array_result1[$column]."','".$tableName."','".$option."')\">
						<span class='add'>-</span>
						</div>

						<div class='list_container'>
						<div class='item_title'>
						<span>".$array_result1[$column]."</span>

						<button class='set_list' onclick=\"setting('".$array_result1[$column]."','".$option."','".$lim['lim']."','".$lim['sort']."')\">播放清單設定</button>
						<br>
						<span>共".$videonum."部影片</span>
						<span class='list_set'>
						<span class='limit'>(".$lim['lim'].")</span>
						由<span style='font-weight: bold;'>".$lim['name']."</span>所創立
						<span style='font-weight: bold;'>".$lim['sort']."</span>排序
						</span>
						<span class='illustrate'onclick=\"add_ill('".$array_result1['list']."','".$option."','".replace($lim['ill'])."')\">".$lim['ill']."</span>
						</div>

						<div class='pull_down' id='video_m_pull_down_".$clist."' onclick=\"pull_down('".$array_result1['list']."','".$clist."','$option','".$videonum."')\"><span>pull down</span>
						</div>
						</div>";
				}
				else if($option=='2'){
					$lim['lim']='';
					$lim['ill']='';
					$lim['sort']='';
					print "<img class='preview' src='".$smallp."'></img>
						<div class='cover'></div>

						<div class='title bold'>".$array_result1[$column]."</div>
						</span>
						<div class='action' onclick=\"delete_list('".$array_result1[$column]."','".$tableName."','".$option."')\">
						<span class='add'>-</span>
						</div>

						<div class='list_container'>
						<div class='item_title'>
						<span>".$array_result1[$column]."</span>
						<br>
						<!--<button class='set_list' onclick=\"setting('".$array_result1[$column]."','".$option."','".$lim['lim']."','".$lim['sort']."')\">播放清單設定</button>-->
						<span>共".$videonum."部影片</span>
						<!--<span class='list_set'>
							<span style='font-weight: bold;'>".$lim['sort']."</span>排序
						</span>-->
						</div>

						<div class='pull_down' id='video_m_pull_down_".$clist."' onclick=\"pull_down('".$array_result1[$column]."','".$clist."','$option','$videonum')\"><span>pull down</span>
						</div>
						</div>";
				
				}
				else if($option=='3'){
					$query1 = "select * from $tableName where uid= $uid and list='".$array_result1['list']."' order by ts DESC";
					if($result = mysql_query($query1)){
						$lim = mysql_fetch_array($result);
						if($lim['lim']=='public'){
							$lim['lim'] = '公開';
						}

						else if($lim['lim']=='hide'){
							$lim['lim'] = '不公開';
						}
						else if($lim['lim']=='private'){
							$lim['lim'] = '私人';
						}

						if($lim['ill']==''){
							$lim['ill']='新增說明';
						}
					}
					print "<img class='preview' src='".$smallp."'></img>
						<div class='cover'></div>

						<div class='title bold'>".$array_result1[$column]."</div>
						</span>
						<div class='action' onclick=\"delete_list('".$array_result1[$column]."','".$tableName."','".$option."')\">
						<span class='add'>-</span>
						</div>

						<div class='list_container'>
						<div class='item_title'>
						<span>".$array_result1[$column]."</span>

						<!--<button class='set_list' onclick=\"setting('".$array_result1[$column]."','".$option."','".$lim['lim']."','".$lim['sort']."')\">播放清單設定</button>-->
						<br>
						<span>共".$videonum."部影片</span>
						<span class='list_set'>
						<!--<span class='limit'>(".$lim['lim'].")</span>-->
						由<span style='font-weight: bold;'>".$name."</span>所創立
						<span style='font-weight: bold;'>最近更新".$lim['ts']."</span>
						<!--<span style='font-weight: bold;'>".$lim['sort']."</span>排序-->
						</span>
						<span class='illustrate'onclick=\"add_ill('".$array_result1['list']."','".$option."','".replace($lim['ill'])."')\">".$lim['ill']."</span>
						</div>

						<div class='pull_down' id='video_m_pull_down_".$clist."' onclick=\"pull_down('".$array_result1['list']."','".$clist."','$option','".$videonum."')\"><span>pull down</span>
						</div>
						</div>";
				}
			}
		}
	print "</div></li></ul>";
	}
	print "</div>";
}	
else{
	//print "Query error.";
}
$row_array = split (',', $rows);
$row_array1 = split (',', $rows1);
?>

<div id='list_bar_block'>
	<div class="famous-surface bar-style bar1" style='background:<?php echo $color;?>'><?php echo $name ;?>'<?php echo $manage ;?></div>
	<div class="famous-surface bar-style bar2"><a href='2home.php'>home</a></div>
	<?php
		if($option==1){
			echo "
			<div class='famous-surface bar-style bar2-1'><a href='video_manage.php?option=3'>myUpload</a></div>
			<div class='famous-surface bar-style bar2-2'><a href='video_manage.php?option=2'>myHistory</a></div>";
		}
		if($option==2){
			echo "
			<div class='famous-surface bar-style bar2-1'><a href='video_manage.php?option=3'>myUpload</a></div>
			<div class='famous-surface bar-style bar2-3' style='top:300px'><a href='video_manage.php?option=1'>myList</a></div>";
		}
		if($option==3){
			echo "
			<div class='famous-surface bar-style bar2-2'><a href='video_manage.php?option=2'>myHistory</a></div>
			<div class='famous-surface bar-style bar2-3'><a href='video_manage.php?option=1'>myList</a></div>";
		}
	?>
	<div class="famous-surface bar-style bar3" onclick="list_all('<?php echo $option?>','<?php echo $clist?>','<?php echo $rows?>','<?php echo $rows1?>')">
		Spread
	</div>
	<div class='famous-surface bar-style bar4'><a href='video_manage.php?option=<?php echo $option?>&sort=new'>新的在前</a></div>
	<div class='famous-surface bar-style bar4' style='top:280px;right:20px;background: palegreen;'><a href='video_manage.php?option=<?php echo $option?>&sort=old'>舊的在前</a></div>
	<?php
		if($option==1||$option==3){	
			print "<div class='famous-surface bar-style bar4' style='top:330px;right: 20px;background: currentcolor'><a href='video_manage.php?option=$option&sort=title'>標題</a></div>";
		}
	?>
	<?php $top = 370;
		for($i=1;$i<count($row_array);$i++){
		echo "<div class='famous-surface bar-style bar2' style='
		    top: ".$top."px;
		    background: black;
		    opacity: 0.8;
		    width: 250px;
		    height: 22px;
		    line-height: 22px;
		    -webkit-transform: none;
		    -moz-transform: none;
		    font-size: 20px;
			border-radius: 0px 10px 10px 0px;'>
			<a href='#mCSB_container_".$i."' onclick=\"pull_down('".$row_array[$i]."','".$i."','".$option."','".$videonum."')\">".$row_array[$i]."</a>
		    </div>";
			$top = $top+30;
		}

	?>
</div>
</body>
</html>
