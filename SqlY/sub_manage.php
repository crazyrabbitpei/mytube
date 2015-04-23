<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>manage subscribe</title>
<script src="video.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="sequences.css?<?php echo date('l jS \of F Y h:i:s A'); ?>"/>
<!--<link rel="stylesheet" type="text/css" href="../../assets/css/famous_styles.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="../../../src/core/famous.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />-->
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
	$list = '';
}
?>

<h1><?php echo $name ?>'s Subscribe manage</h1>
<?php
ini_set('display_errors','Off');
error_reporting(E_ALL);	
include("connectdb.php");
?>
<?php
/*----------manage detail-------------------------*/
$maintable = "Basic";//myUpload
$maintable2 = "myUpload";//myUpload
$tableName = "mySub";//Bascic:global,HistoryM:history record ,SelfM:self music pack, Default is Basic table
/*----------Other count----------------------*/
$cdata = 0;
$clist = 0;
/*----------Start count time----------------------*/
$time_start = microtime(true);
/*--------------Mysql search start----------------*/

$query1 = "select * from $tableName where myid='$uid' order by ts DESC";
if($result = mysql_query($query1)){ 
	$rows = array();
	print "<a href='2home.php'>home</a><br>";
	while($array_result1 = mysql_fetch_array($result)){
		$clist++;
		$cdata=0;
		print "<h3>".$clist.":".$array_result1['author']."</h3><br>
			last upload:".$array_result1['ts']."<br>
			有<span class='hlight'>".$array_result1['newsub']."</span>則更新<br>

			<div style='position:relative; left:100px; bottom:70px;'>
			<input type='button' value='Delete' onclick=\"editvideo('".$array_result1['uid']."','".$tableName."','4','$list')\"/>
			</div>";

		$query2 = "select * from ".$maintable." where uid='".$array_result1['uid']."' order by published DESC";
		if($result1 = mysql_query($query2)){ 
			print "<table>";
			while($array_result = mysql_fetch_array($result1)){
				$query3="select lim from myUpload where id='".$array_result['id']."' and uid='".$array_result1['uid']."'";
				if($result3 = mysql_query($query3)){
                        		$num = mysql_num_rows($result3);
					$array_result3 = mysql_fetch_array($result3);
					if($num!= 0){
						//echo "(!0)lim:".$array_result3['lim'];
						if($array_result3['lim']!='public'){
							continue;
						}
					}
					else{
						//echo "(0)lim:".$array_result3['lim'];
					}	
					$cdata++;				
		
				}

				$title = $array_result['title'];
				/*-----------------------get video icon----------------------------------*/
				$smallp = 'http://i.ytimg.com/vi_webp/'.$array_result['id'].'/default.webp';
				$link = 'http://www.youtube.com/watch?v='.$array_result['id'];
				if(file_exists($smallp)){
				}
				else{
					$smallp = 'http://i.ytimg.com/vi/'.$array_result['id'].'/mqdefault.jpg';
				}

				//option 0:update, 1:delete
				if($cdata>=$array_result1['newsub']+1){
					if($cdata==$array_result1['newsub']+1){
						print "<tr align='left'>";
					}
					else{
						print "<tr align='left'>";
					}
				print "
					<td width='180px' height='130px'><img width='180px' height='130px' src='".$smallp."'></img></td>
					<td>".$cdata."
					</td>
					<td>".$title."<span class='hlight'>(old)</span>
					</td>
					</tr>";
				}
				else{
				print "<tr align='left'>
					<td width='180px' height='130px'><img width='180px' height='130px' src='".$smallp."'></img></td>
					<td>".$cdata."
					</td>
					<td>".$title."<span class='hlight'>(new)</span>
					</td>
					</tr>";
				}

			}
			print "</table>";
		}		
	}


}	
else{
	//print "Query error.";
}

   $query = "update ".$tableName." set newsub=0 where myid='".$uid."'";	
   if($result = mysql_query($query)){
   }
?>
</body>
</html>
