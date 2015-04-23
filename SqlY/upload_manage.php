<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>manage Upload</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="video.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
</head>
<body>

<?php
	//update 要再做一套界面

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

<h1><?php echo $name ?>'s Upload manage</h1>
<?php
ini_set('display_errors','Off');
error_reporting(E_ALL);	
include("connectdb.php");
?>
<?php
		/*----------manage detail-------------------------*/
                $maintable = "Basic";
		$tableName = "myUpload";//Bascic:global,HistoryM:history record ,SelfM:self music pack, Default is Basic table
		/*----------Other count----------------------*/
		$cdata = 0;
		/*----------Start count time----------------------*/
		$time_start = microtime(true);
		/*--------------Mysql search start----------------*/

		$query1 = "select * from $tableName where uid='$uid'";
		if($result = mysql_query($query1)){ 
				/*----------End count time----------------------*/
				$time_end = microtime(true);
				$time = $time_end - $time_start;
				/*----------use ajax:return result------------------------*/
				$rows = array();
				print "<a href='2home.php'>home</a><br><table>";
				while($array_result1 = mysql_fetch_array($result)){
					$query2 = "select * from ".$maintable." where id='".$array_result1['id']."'";
					if($result1 = mysql_query($query2)){ 
						$array_result = mysql_fetch_array($result1);
						if($array_result['title']==null){
							$title = "[Video has been removed.]";
							$smallp = "";
                                                        $link = "";
                                                        $input = "";
						}
						else{
							if($array_result['uid']==$uid){
								$input  ="<input type='button' value='Update' onclick=\"editvideo('".$array_result['id']."','".$tableName."',0,'$list')\"/>";
							}
							$title = $array_result['title'];
							/*-----------------------get video icon----------------------------------*/
							$smallp = 'http://i.ytimg.com/vi_webp/'.$array_result1['id'].'/default.webp';
							$link = 'http://www.youtube.com/watch?v='.$array_result1['id'];
							if(file_exists($smallp)){
							}
							else{
								$smallp = 'http://i.ytimg.com/vi/'.$array_result1['id'].'/mqdefault.jpg';
							}

						}
						
						$cdata=$cdata+1;
						//option 0:update, 2:delete
						print "<tr align='left'>
							<td width='180px' height='130px'><img width='180px' height='130px' src='".$smallp."'></img></td>
							<td>".$title."
							<div style='position: relative;top: 30px;'>Upload date:".$array_result1['ts']."</div>
							<div style='position: relative;top: 40px;'>ViewCount:".$array_result['viewCount']."</div>
							<div style='position:relative;
							     		left:0px;
							     		bottom:80px;'>
								<input type='button' value='Delete' onclick=\"editvideo('".$array_result1['id']."','".$tableName."','3','')\"/>
							".$input."
							</div>
							</td>
						</tr>";
						//print "<br><img width='180px' height='130px' src='".$smallp."'</img><br>".$array_result['title'] . "<br>" . $array_result['published'] . "<br>" . $array_result['content'] . "<br>"  . $array_result['category'] . "<br>" .  $array_result['duration'] . "<br>" . $array_result['favoriteCount'] . "<br>" . $array_result['viewCount'] . "<br>" .  $array_result['author'] . "<br>" . $array_result['uid'] ."<br>";
					}		
				}
				print "</table>";

		}	
		else{
				//print "Query error.";
		}
		//echo json_encode($rows);
?>
</body>
</html>
