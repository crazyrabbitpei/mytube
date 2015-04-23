<?php session_start(); ?>
<?php
ini_set('display_errors','Off');
error_reporting(E_ALL);	
include("connectdb.php");
?>
<?php
        if($_SESSION['username']==null){
                echo "Deny Permission<br>";
                //header("http/1.1 403 Forbidden");
                $url ='user/login.php';
                echo $url;
                header("Location:$url");
                //exit();
                //echo "<meta http-equiv=REFRESH CONTENT=$denytime;url='$url'>";
        }
        else{
                $name = $_SESSION['username'];
                $uid = $_SESSION['uid'];
                $option = $_POST['option'];
		$user = 'myid';
		$record = "slist";
		if($option=='1'){
			$record = "slist";
		}
		else if($option=='2'){
			$record = "myHistory";
			$user = 'uid';
		}
		else if($option=='3'){
			$record = "myUpload";
			$user = 'uid';
		}
		else if($option=='4'){
			$record = "mySub";
			$user = 'uid';
		}
        }
?>
<?php
		/*----------Search detail-------------------------*/
		//option:2 initial hot search;option:1 relative search;default 0

		if($option==3){
			$query1 = "select DISTINCT list from $record where $user= $uid order by list";
		}
		else{
			$query1 = "select * from $record where $user= $uid order by list";
		}
			if($result = mysql_query($query1)){ 
				/*----------use ajax:return result------------------------*/
				$rows = array();
				while($array_result = mysql_fetch_array($result)){
					if($option==3){
						$json_data = array(
						'list' => $array_result['list']
						//'lim' => $array_result['lim']		
						);
						$rows[]=$json_data;
					}
					else{
						$json_data = array(
						'list' => $array_result['list'],
						'lim' => $array_result['lim']		
						);
						$rows[]=$json_data;
					}
				}
			}
			else{
					print "Query error.";
			}
		echo json_encode($rows);
?>
