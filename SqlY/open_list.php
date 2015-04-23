<?php session_start(); ?>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $_GET['list'] ?></title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="video.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<link rel="stylesheet" type="text/css" href="sequences.css?<?php echo date('l jS \of F Y h:i:s A'); ?>"/>
<link rel="stylesheet" type="text/css" href="../../assets/css/famous_styles.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
</head>
<body style='background:black;color:white'>

<?php
$denytime=0;
if($_SESSION['username']==null){
	echo "Deny Permission<br>";
	$url ='user/login.php';
	header("Location:$url");
}
else{
	$name = $_SESSION['username'];
	$uid = $_SESSION['uid'];
	$list = $_GET['list'];
	$start = $_GET['start'];
	$option = $_GET['option'];
	$option2 = $option*10;
	$user='uid';
	$column = '';
	$record = 'slist';
	if($option=='1'){
                $tableName = "myList";
		$column = 'list';
        }
        else if($option=='2'){
                $tableName = "myHistory";
		$column = 'ts';
		$order  = 'order by ts DESC';
        }
        else if($option=='3'){
                $tableName = "myUpload";
		$column = 'list';
		$order  = 'order by ts DESC';
        }
        else if($option=='4'){
                $tableName = "mySub";
		$column = 'uid';
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
$setime = 0;


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
//select myList.id,myList.uid from Basic,myList where Basic.id=myList.id and myList.uid='10' order by viewCount;
//select Basic.id,Basic.duration,Basic.published,Basic.favoriteCount,Basic.viewCount,myList.id,myList.uid from Basic,myList where Basic.id=myList.id and myList.uid='10' order by viewCount;
$display_list = "select * from $maintable,$tableName where $maintable.id=$tableName.id and $tableName.$column='".$list."' and $tableName.$user='$uid' $order";
//print "l:$display_list";
$clist = $clist+1;
$videoList = '';
if($result_display_list = mysql_query($display_list)){
	print "<div id='main'></div>";
	print "<div id='searchc'></div>";
	print "<ul class='playlist' style='margin-bottom: 2px;'>";

	while($array_display_list = mysql_fetch_array($result_display_list)){

		$id = $array_display_list['id'];
		$query2 = "select * from ".$maintable." where id='".$array_display_list['id']."'";
		if($result2 = mysql_query($query2)){ 
			$array_result2 = mysql_fetch_array($result2);
			if($array_result2['title']==null){
				$title =  $array_display_list['title']."[Video has been removed.]";
				$delete = "delete from ".$tableName." where id='".$array_display_list['id']."'";
				if($result = mysql_query($delete)){
                                	//print "Delete : ".$id." from ".$maintable;
                        	}
				
				$smallp = "https://s.ytimg.com/yts/img/no_thumbnail-vfl4t3-4R.jpg";			
				$link = "";
				print "<li><div name=$id class='mCSB_container_open'\"> <span class='item' onmouseover=\"title_move(this)\" onmouseout=\"title_init(this,10)\">";
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

				$json_data = array('id' => $array_result2['id'],
                                                        'title' => $array_result2['title'],'link' => $link
                                                        ,'published' => $array_result2['published'],'content' => $array_result2['content']
                                                        ,'category' => $array_result2['category'],'duration' => $array_result2['duration']
                                                        ,'favoriteCount' => $array_result2['favoriteCount']
                                                        ,'viewCount'=> $array_result2['viewCount']
                                                        ,'keyword' => $array_result2['keyword']
                                                        ,'author' => $array_result2['author']
                                                        ,'uid' => $array_result2['uid']
                                                        ,'smallp' => $smallp
                                                        ,'cdata' => $cdata
                                                        ,'myid' => $uid
                                                        ,'time'=>$time);
                                $rows[]=$json_data;
							
				$array_result2['title'] = replace($array_result2['title']);
				$array_result2['content'] = replace($array_result2['content']);
				$array_result2['author'] = replace($array_result2['author']);
				$array_result2['keyword'] = replace($array_result2['keyword']);
				$array_result2['category'] = replace($array_result2['category']);
				

				$id = $array_result2['id'];

				print "<li><div name=$id class='mCSB_container_open' onclick=\"nextvideo($cdata)\"> <span class='item' onmouseover=\"title_move(this)\" onmouseout=\"title_init(this,10)\">";
			}
			//option 10:delete, no update for myList's item
			print"	<img class='preview' src='".$smallp."'></img>
				<div class='cover'></div>
				<div class='title bold'>".$title."</div>
				</span>
				</div>
				<div class='action'>
					<span class='add' onclick=\"editvideo('".$array_display_list['id']."','".$tableName."','$option2','$list')\">-</span>
				</div>
				</li>
				";
		}
		$cdata=$cdata+1;
	}
	print "</ul>";
	print "<div class='item_title list_bold'><span>$list</span></div>";
	//print "<div class='item_title list_bold'><span>$list</span></div>";
	if($cdata==0){
		$query2 = "delete from ".$tableName." where $user='".$uid."'and $column='$list'";
	        if($result = mysql_query($query2)){
			//print "Delete list : ".$list;
                	if($option==1){
                	        $query2 = "delete from ".$record." where myid='".$uid."' and list='$list'";
                	        if($result = mysql_query($query2)){
                	        }
                	        else{
                	                //echo "false:".$query2;
                	        }
                	}

		}
		header("Location:video_manage.php?option=$option");
	}
	
	$title = mysql_real_escape_string($rows[$start]['title']);
	$content = mysql_real_escape_string($rows[$start]['content']);
	//$title = html_entity_decode($title, ENT_NOQUOTES, 'UTF-8');
	//$title = replace($rows[$start]['title']);
	//$content = replace($rows[$start]['content']);
	//待改

	print "<script>
		openvideo(
				'".$uid."',
				'".$rows[$start]['id']."',
				'".$rows[$start]['id']."',
				'".$title."',
				'".$rows[$start]['category']."',
				'".$content."',
				'".$rows[$start]['published']."',
				'".$rows[$start]['author']."',
				'".$rows[$start]['keyword']."',
				'".$rows[$start]['viewCount']."',
				'".$rows[$start]['favoriteCount']."',
				'".$rows[$start]['duration']."',
				'".$rows[$start]['uid']."',
				'".$option2."'
			 )</script>";
	
	print "<script>videolist('$list','$option','$start','$order')</script>";//1:mylist,2:myhistory,3:myUpload,4:mysub
	
}
/*-----------------the way to pass listvideo------------------*/
//print "<li><div class='mCSB_container_open' onclick=\"videolist('0','$cdata'),openvideo( '".$uid."', '".$array_result2['id']."', '".$array_result2['id']."', '".$array_result2['title']."', '".$array_result2['category']."', '".$array_result2['content']."', '".$array_result2['published']."', '".$array_result2['author']."', '".$array_result2['keyword']."', '".$array_result2['viewCount']."', '".$array_result2['favoriteCount']."', '".$array_result2['duration']."', '".$array_result2['uid']."', '100')\"> <span class='item' onmouseover=\"title_move(this)\" onmouseout=\"title_init(this,10)\">";

//print "<li><div name=$id class='mCSB_container_open' onclick=\"location.href='open_list.php?list=$list&start=$cdata'\"> <span class='item' onmouseover=\"title_move(this)\" onmouseout=\"title_init(this,10)\">";
/*------------------------------------------------------------*/
?>
</body>
</html>
