<?php session_start(); ?>
<?php
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
	$lim = $_POST['lim'];
	$sort = $_POST['sort'];
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

	if($lim=='public'){
		$lim = '公開';
	}

	else if($lim=='hide'){
		$lim = '不公開';
	}
	else if($lim=='private'){
		$lim = '私人';
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
<span class='hlight'><?php echo $list?><?php echo $sort ;?></span>清單設定
</h2>
</div>
<div class="yt-dialog-content">      
	<div class="messages">
	<div class="yt-alert yt-alert-default yt-alert-error  error-message hid">  <div class="yt-alert-icon">
		<span class="icon master-sprite yt-sprite"></span>
	</div>

	<ul class="yt-uix-tabs" data-uix-tabs-selected-extra-class="selected">
	
	</ul>

	<form class="settings-form" action="/playlist_ajax?action_edit_settings=1" method="post">
		<input type="hidden" name="session_token" value="QUFFLUhqa3lJR3dNUWxocm9CZUZUaXF4QnJ0NjZIcERvQXxBQ3Jtc0ttckl6a1EyVmFPRlI2WVJLd3FZR3FtZmNmbE5HSEg1Y0JUejJ5MUs4clhXT0VLTXZvbnNsMnlPMWltMlp1WUNjWklvTE96cVVEWXNZWVRkc2N1NXl3THFlT2FnYU1rbERPZGtqeTJQYTJxcDR2cmVmeGhIRkhaRlpfaGJLRGx1VEJ6aTRIZmVibDB6TERISkRSZ3VJSU9HdEd0MUljd2t2Yk12UXRnUEpJMzhxZUJERlk=">
		<input type="hidden" name="full_list_id" value="PLEMFqx1DuWwX_VH0So9MqzofKd0sxZFe8">
		<div id="basic-settings" class="playlist-settings-tab"><div class="basic-settings-column"><label class="yt-uix-form-label section-title">隱私設定</label>  <div class="yt-uix-form-select-fluid ">
		<span class="yt-uix-form-input-select playlist-privacy-setting"><span class="yt-uix-form-input-select-content"><span class="yt-uix-form-input-select-arrow yt-sprite"></span><span class="yt-uix-form-input-select-value"><?php echo $lim ?></span></span><select onchange="changep(this.options[this.selectedIndex].innerHTML,0)" class="yt-uix-form-input-select-element " name="privacy">  <option value="public" <?php if($lim=='公開'){echo "selected";} ?>>公開</option>
	
		<option value="hide" <?php if($lim=='不公開'){echo "selected";} ?>>不公開</option>

		<option value="private" <?php if($lim=='私人'){echo "selected";} ?>>私人</option>
		</select></span>
		</div>
		<label class="yt-uix-form-label section-title">排序</label>  
		<div class="yt-uix-form-select-fluid ">
			<span class="yt-uix-form-input-select playlist-video-order">
				<span class="yt-uix-form-input-select-content">
					<span class="yt-uix-form-input-select-arrow yt-sprite"> </span>
					<span class="yt-uix-form-input-select-value"><?php echo $sort ?></span>
				</span>
				<select onchange="changep(this.options[this.selectedIndex].innerHTML,1)" class="yt-uix-form-input-select-element playlist-video-order-input" name="video_order">  
					<option value="0" <?php if($sort=='標題'){echo "selected";} ?>>標題</option>
					<option value="3" <?php if($sort=='最熱門'){echo "selected";} ?>>最熱門</option>
					<option value="1" <?php if($sort=='新增日期 (最新 - 最舊)'){echo "selected";} ?>>新增日期 (最新 - 最舊)</option>
					<option value="2" <?php if($sort=='新增日期 (最舊 - 最新)'){echo "selected";} ?>>新增日期 (最舊 - 最新)</option>
					<option value="4" <?php if($sort=='發佈日期 (最新 - 最舊)'){echo "selected";} ?>>發佈日期 (最新 - 最舊)</option>
					<option value="5" <?php if($sort=='發佈日期 (最舊 - 最新)'){echo "selected";} ?>>發佈日期 (最舊 - 最新)</option>
				</select>
			</span>
		</div>
		</div>
		</div>
	</form>
</div>
<div class="yt-dialog-footer">
	<button class="yt-uix-button yt-uix-button-size-default yt-uix-button-default   yt-dialog-dismiss yt-dialog-cancel" type="button" onclick="removeset()" data-action="cancel"><span class="yt-uix-button-content">取消 </span></button>
	<button class="yt-uix-button yt-uix-button-size-default yt-uix-button-primary save-button" type="button" onclick="updateset('<?php echo $list?>','<?php echo $option?>')"><span class="yt-uix-button-content">儲存 </span></button>
</div>
