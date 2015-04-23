<?php session_start(); ?>
<?php
$denytime=0;
if($_SESSION['username']==null){
	$url ='user/login.php';
        header("Location:$url");
}
else{
	$name = $_SESSION['username'];
	$uid = $_SESSION['uid'];
	$list = $_POST['list'];
	$option = $_POST['option'];
	$order = $_POST['order'];

}
?>
<?php
//ini_set('display_errors','On');
//error_reporting(E_ALL);
include("connectdb.php");
include("str.php");
?>
<?php
/*----------manage detail-------------------------*/
$maintable = "Basic";
$user='uid';
$column = '';	
if($option=='1'){
	$tableName = "myList";
	$column = 'list';
}
else if($option=='2'){
	$tableName = "myHistory";
	$column = 'ts';
}
else if($option=='3'){
	$tableName = "myUpload";
	$column = 'list';
}
else if($option=='4'){
	$tableName = "mySub";
	$column = 'uid';
	$user = 'myid';
}

/*----------Other count----------------------*/
$cdata = 0;
$start = 0;
$rows = array();
$display_list = "select * from $maintable,$tableName where $maintable.id=$tableName.id and $tableName.$column='".$list."' and $tableName.$user='$uid' $order";
//print $display_list;
if($result_display_list = mysql_query($display_list)){
	while($array_display_list = mysql_fetch_array($result_display_list)){
		$id = $array_display_list['id'];
		$query2 = "select * from ".$maintable." where id='".$array_display_list['id']."'";
		if($result2 = mysql_query($query2)){ 
			$array_result2 = mysql_fetch_array($result2);
			if($array_result2['title']==null){
				$title = "[video has been removed.]";
				$smallp = "";
				$link = "";
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
				$array_result2['title'] = html_entity_decode($array_result2['title'], ENT_NOQUOTES, 'UTF-8');
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
							,'other' => '1000'
                                                        ,'myid' => $uid);
                                $rows[]=$json_data;
							
				/*$array_result2['title'] = replace($array_result2['title']);
				$array_result2['content'] = replace($array_result2['content']);
				$array_result2['author'] = replace($array_result2['author']);
				$array_result2['keyword'] = replace($array_result2['keyword']);
				$array_result2['category'] = replace($array_result2['category']);*/
				//$id = $array_result2['id'];
			}
		}

		$cdata=$cdata+1;
	}
	echo json_encode($rows);
}
?>
