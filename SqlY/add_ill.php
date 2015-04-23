<?php session_start(); ?>
<?php
//新增說明還未做 action=".php" name="playlist_description"
$denytime=0;
if($_SESSION['username']==null){
	echo "Deny Permission<br>";
	$url ='user/login.php';
	//echo $url;
}
else{
	$name = $_SESSION['username'];
	$uid = $_SESSION['uid'];
	$list = $_POST['list'];
	$ill = $_POST['ill'];
	$option = $_POST['option'];
	
	if($option=='1'){
		$tableName = "myList";
	}
	else if($option=='2'){
		$tableName = "myHistory";
	}
	else if($option=='3'){
		$tableName = "myUpload";
	}
	else if($option=='4'){
		$tableName = "mySub";
	}

}
?>
<?php
ini_set('display_errors','Off');
error_reporting(E_ALL);	
include("connectdb.php");
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
?>
<script src="video.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<div class="yt-dialog-fg" style="
">
<div class="yt-dialog-fg-content yt-dialog-show-content">
<div class="yt-dialog-header">
<h2 class="yt-dialog-title">
<span class='hlight'><?php echo $list?></span>新增說明
</h2>
</div>
<div class="yt-dialog-content">      
	<div class="messages">
	<div class="yt-alert yt-alert-default yt-alert-error  error-message hid">  <div class="yt-alert-icon">
		<span class="icon master-sprite yt-sprite"></span>
	</div>

	<ul class="yt-uix-tabs" data-uix-tabs-selected-extra-class="selected">
	</ul>
		<span class="yt-uix-form-input-container yt-uix-form-input-textarea-container clearfix yt-uix-form-input-fluid-container"><span class=" yt-uix-form-input-fluid"><textarea onchange="updateill('<?php echo$list?>',this.value,'<?php echo$option?>')" class="yt-uix-form-input-textarea " name="playlist_description" maxlength="5000" rows="6" placeholder="說明"><?php if($ill!='新增說明'){echo $ill;} ?></textarea></span></span>
	<div class="yt-dialog-footer">
		<button class="yt-uix-button yt-uix-button-size-default yt-uix-button-default   yt-dialog-dismiss yt-dialog-cancel" type="button" onclick="removeset()" data-action="cancel"><span class="yt-uix-button-content">取消 </span></button>
	<!--	<button class="yt-uix-button yt-uix-button-size-default yt-uix-button-primary save-button" type="button"><span class="yt-uix-button-content">儲存 </span></button>
	</div>-->
</div>

