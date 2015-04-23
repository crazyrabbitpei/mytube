<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="video.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<title>manage history</title>
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
		exit();
		//echo "<meta http-equiv=REFRESH CONTENT=$denytime;url='$url'>";
	}
	else{
		$name = $_SESSION['username'];
	}
?>

<h1><?php echo $name ?>'s History manage</h1>

<?php
ini_set('display_errors','Off');
error_reporting(E_ALL);	
include("connectdb.php");
$uid=$_SESSION['uid'];
$list='';
?>
<?php

		/*----------manage detail-------------------------*/
		$maintable = "Basic";
		$tableName = "myHistory";//Bascic:global,HistoryM:history record ,SelfM:self music pack, Default is Basic table
		/*--------------Mysql search start----------------*/
		//$query2 = "select id,title,published,content,category,duration,favoriteCount,viewCount,author,uid from $tableName where $scolumn $compare '$keyword' order by $order;";
		$query1 = "select * from $tableName where uid='$uid'";
		if($result = mysql_query($query1)){ 
				/*----------use ajax:return result------------------------*/
				$rows = array();
				print "<a href='2home.php'>home</a><br><table>";
				while($array_result = mysql_fetch_array($result)){
					$query2 = "select * from ".$maintable." where id='".$array_result['id']."'";
					if($result1 = mysql_query($query2)){ 
						$array_result1 = mysql_fetch_array($result1);
						if($array_result1['title']==null){
							$title = "[Video has been removed.]";
							$smallp = "";
							$link = "";
						}
						else{
							$title = $array_result1['title'];
							/*-----------------------get video icon----------------------------------*/
							$smallp = 'http://i.ytimg.com/vi_webp/'.$array_result1['id'].'/default.webp';
							$link = 'http://www.youtube.com/watch?v='.$array_result1['id'];
							if(file_exists($smallp)){
							}
							else{
								$smallp = 'http://i.ytimg.com/vi/'.$array_result1['id'].'/mqdefault.jpg';
							}
						}

												
						//option 0:update, 1:delete, 3:delete from history
						print "<tr align='left'>
							<td width='180px' height='130px'><img width='180px' height='130px' src='".$smallp."'></img></td>
							<td>".$title."
							<div style='position: relative;top: 30px;'>last view date:".$array_result['ts']."</div>
							<div style='position: relative;top: 30px;'>view:".$array_result['count']."</div>
							<div style='position:relative; left:0px; bottom:80px;'>
								<input type='button' value='Delete' onclick=\"editvideo('".$array_result['id']."','".$tableName."',3,'$list')\"/>
							</div>
							</td>
						</tr>";
					}
					else{

					}
				}
				print "</table>";

		}	
?>
</body>
</html>
