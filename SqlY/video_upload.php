<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Upload</title>
<script src="video.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<link rel="stylesheet" type="text/css" href="sequences.css?<?php echo date('l jS \of F Y h:i:s A'); ?>"/>
<link rel="stylesheet" type="text/css" href="../../assets/css/famous_styles.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
</head>
<body>
<script>
get_list('3');
</script>
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
	}
?>

<?php
ini_set('display_errors','Off');
error_reporting(E_ALL);
include("connectdb.php");
?>
<?php
	/*print "<div align='center'><h1>".$name."'s Upload</h1><br>
			<form action='upload.php' method='post'>
			Video Id : <input type='text' name='id' value=''></input><br>
			Title : <input type='text' name='title' value=''></input><br>
			Content : <br><textarea name='content' style='width:300px;height:200px;'></textarea><br>
			Author : <input type='text' name='author' value=''></input><br>
			Category : <input type='text' name='category' value=''></input><br>
			<br><input value='Insert' type='submit'></input>
			</form><br><a href='2home.php'>home</a></div>";*/
	//header("refresh:1; url='2home.php'");

?>

<h1><?php echo $name?>'s Upload</h1>
<form id="contactform" action='upload.php' method='post'>
<div class="formcolumn">
  <div class="dynamiclabel">
    <input id="id" name='id' placeholder="Video Id" type="text">
    <label for="id">Video Id</label>
  </div>

  <div class="dynamiclabel">
    <input id="title" name='title' placeholder="Title" type="text">
    <label for="title">Title</label>
  </div>

  <div class="dynamiclabel">
    <textarea id="content" name='content' placeholder="Content"></textarea>
    <label for="content">Content</label>
  </div>
</div>
<div class="formcolumn">
	<div class="staticlabel">	
	<label for="category">Category:</label>
	<select id="category" name='category'>
		<option value="1">--請選擇類別--</option>
		<option value="animation">animation</option>
		<option value="movie">movie</option>
		<option value="music">music</option>
		<option value="game">game</option>
		<option value="other">other</option>
	</select>
	</div>

	<div class="staticlabel">
	<label for="limit">Video privacy:</label>
	<select id="limit" name="lim">
		<option value="public">公開</option>
		<option value="hide">不公開</option>
		<option value="private">私人</option>
	</select>
	</div>
  	<div class="dynamiclabel" style="margin: 10px 10px 40px 10px;top: 30px;">
    		<input id="input_list" name='list' placeholder="List" value="myVideo" style=" width: 100%; text"></input>
   		<label for="input_list">List</label>


	</div>
	<div id="list_name_block1">
	
	</div>

<input class="button" type="submit" value="Insert" style=" width: 100px; margin: 20px 0px; position: absolute; "></input>
</div>


</form>
<div class='home'><a href='2home.php'>home</a></div>
</body>
</html>
