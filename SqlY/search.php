<?php
ini_set('display_errors','Off');
error_reporting(E_ALL);	
include("connectdb.php");
?>
<?php
if($_POST['searchp']==null){
		echo json_encode(array('state'=>'nostring'));
}
else{
		/*----------Search detail-------------------------*/
		//option:2 initial hot search;option:1 relative search;default 0
		$option = $_POST['option'];

		$iftable="column";
		$tableName = "Basic";//mytube(big),Basci(small):global,myHistory:history record ,myVideo:self music pack, Default is Basic table
		$scolumn = "title";//default is title column, can choose other column at search block
		$compare = "like";//like or = ,reference:http://dev.mysql.com/doc/refman/5.0/en/pattern-matching.html
		$p = "%";//for 'like' selction
		$order = 'order by viewCount DESC';
		$and = "";		
		//$limit = "limit 0,50";
		$limit = "";
		
		$keyword = $_POST['searchp'].$p;
		$keyword = addslashes($keyword);
		//realtive search
		if($option==1){
			$key_array = explode(";",$keyword);
			foreach($key_array as $index => $value){
				if($index==count($key_array)-1){
					$keyword = $p.$value;
				}
				else{$and = "and title like '".$value."%'";}
			}
		}
		//hot saerch
		else if($option==2){
			$limit = "limit 0,100";
			$query2 = "select * from $tableName $order $limit";
		}

		$cat = $_POST['cat'];
		$cat_array = explode(";",$cat);
		
		foreach($cat_array as $index => $value){
			if($index==0){
				if($value=="Table"){
					$iftable="table";	
				}
			}
			else if($index==1){
				if($iftable=="table"){
					$tableName=$value;
					if($value=="myHistory"){
						$order = 'order by count DESC';
					}
					else if($value=="myList"){
						$order = "";
					}
				}
				else{
					$scolumn=$value;
				}
			}
			else if($index==2 && $value!=""){//if category
				$and = "and title like '$keyword'";
				$keyword = "$value%";
			}
		}
			//echo "[".$tableName."][".$scolumn."]<br>";
		/*----------Other count----------------------*/
		$cdata = 0;
		/*--------------Mysql search start----------------*/
		//$query1 = "select id,title,published,content,category,duration,favoriteCount,viewCount,author,uid from $tableName where $scolumn $compare '$keyword' order by $order ;";
		$keyword = addslashes($keyword);
		//TODO keyword要加escape_string
		$query1 = "select * from $tableName where $scolumn $compare '$keyword' $and $order $limit ;";
		if($option==2){
			$query1 = $query2;
			//echo "------>[".$query1."]";
		}
		else if($option==1){
			//echo "------>[".$query1."]";
		}
		else if($optoin==0){
			//echo "~~~~~~~~>optoin:0[".$query1."]";
		}
		else{
			//echo "~~~~~~~~>else[".$query1."]";
		}
		if($tableName=="myHistory" || $tableName=="myList"){
			$time_start = microtime(true);
			if($result1 = mysql_query($query1)){
				while($array_result1 = mysql_fetch_array($result1)){
					//htmlentities($array_result1['title'],ENT_QUOTES,"UTF-8");
					$cdata = $cdata+1;
					$query1 = "select * from Basic where id='".$array_result1['id']."'";
					
					$result = mysql_query($query1);
					
					$time_end = microtime(true);
					$time = $time_end - $time_start;

					$array_result = mysql_fetch_array($result);
				
					$smallp = 'http://i.ytimg.com/vi_webp/'.$array_result['id'].'/default.webp';
							$link = 'http://www.youtube.com/watch?v='.$array_result['id'];
							if(file_exists($smallp)){
							}
							else{
								$smallp = 'http://i.ytimg.com/vi/'.$array_result['id'].'/mqdefault.jpg';
							}
							$json_data = array('id' => $array_result['id'],
							'title' => $array_result['title'],'link' => $link
							,'published' => $array_result['published'],'content' => $array_result['content']
							,'category' => $array_result['category'],'duration' => $array_result['duration']
							,'favoriteCount' => $array_result['favoriteCount']
							,'viewCount'=> $array_result['viewCount']
							,'keyword' => $array_result['keyword']
							,'author' => $array_result['author']
							,'uid' => $array_result['uid']
							,'smallp' => $smallp
							,'cdata' => $cdata
							,'time'=>$time);
							$rows[]=$json_data;
				}
				if($cdata==0){
					$rows=array();
				}
			}
		}
		else{
			$time_start = microtime(true);
			if($result = mysql_query($query1)){ 
				/*----------End count time----------------------*/
				$time_end = microtime(true);
				$time = $time_end - $time_start;
				/*----------use ajax:return result------------------------*/
				$rows = array();
				while($array_result = mysql_fetch_array($result)){
						$cdata=$cdata+1;
						//mb_convert_encoding($array_result['title'], "UTF-8", "auto");
						/*-----------------------get video icon----------------------------------*/
						$smallp = 'http://i.ytimg.com/vi_webp/'.$array_result['id'].'/default.webp';
						$link = 'http://www.youtube.com/watch?v='.$array_result['id'];
						if(file_exists($smallp)){
						}
						else{
							$smallp = 'http://i.ytimg.com/vi/'.$array_result['id'].'/mqdefault.jpg';
						}

						/*--------------check if the image_link(smallp) is correct or not, but it occur result 
						too slow, so move it to 2home.php--------*/
						//$headers = get_headers($smallp, 1);
						//if ($headers[0] != 'HTTP/1.0 200 OK') {
						//		//print "fail:".$headers[0]."<br>";
						//		$smallp = 'http://i.ytimg.com/vi/'.$array_result['id'].'/mqdefault.jpg';
						//}
						/*------------------------json get----------------------------------------*/
						$json_data = array('id' => $array_result['id'],
						'title' => $array_result['title'],'link' => $link
						,'published' => $array_result['published'],'content' => $array_result['content']
						,'category' => $array_result['category'],'duration' => $array_result['duration']
						,'favoriteCount' => $array_result['favoriteCount']
						,'viewCount'=> $array_result['viewCount']
						,'keyword' => $array_result['keyword']
						,'uid' => $array_result['uid']
						,'author' => $array_result['author'],'smallp' => $smallp,'cdata' => $cdata,'time'=>$time);
						$rows[]=$json_data;
						/*-----------------------for post----------------------------------------------------------------*/
						//$vlink = 'video_info.php?id='.$array_result['id'].'&title='.$array_result['title'].'&link='.$link.
						//		'&published='.$array_result['published'].'&content='.$array_result['content'].
						//		'&category='.$array_result['category'].'&duration='.$array_result['duration'].
						//		'&favoriteCount='.$array_result['favoriteCount'].'&viewCount='.$array_result['viewCount'].
						//		'&author='.$array_result['author'];
						/*---------------replace blank to %20------------*/
						//$pattern = '/\s+/';
						//$replacement = '%20';
						//$vlink = preg_replace($pattern, $replacement, $vlink);
						//print "<a href=".$vlink."><img src=".$smallp." width='200' height='150'></a>";
				}

			}
			
			else{
					//print "Query error.";
			}
		}
		echo json_encode($rows);
}
?>
