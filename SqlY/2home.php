<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>SqlY</title>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="video.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<link rel="stylesheet" type="text/css" href="sequences.css?<?php echo date('l jS \of F Y h:i:s A'); ?>"/>
<link rel="stylesheet" type="text/css" href="../../assets/css/famous_styles.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<?php
	$denytime=0;
	if($_SESSION['username']==null){
		//echo "Deny Permission<br>";
		//header("http/1.1 403 Forbidden");
		$url ='user/login.php';
		//echo $url;
		header("Location:$url");
		//echo "<meta http-equiv=REFRESH CONTENT=$denytime;url='$url'>";
}
	else{
		$name = $_SESSION['username'];
		$uid = $_SESSION['uid'];
		//echo "Welcome ".$name." uid:".$uid;
	}
?>

<script>
var resultnum=0;
function search(value,cat,option){
		var xmlhttp;
		var obj, table, data = "";
		var i;
		console.log("value:"+value+" cat:"+cat+"  option:"+option);
		//document.getElementById("result").innerHTML = "";
		document.getElementById("status").innerHTML = "";
		
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
						console.log(xmlhttp.responseText);
						obj = JSON.parse(xmlhttp.responseText);//if json is not correct, this line will occur falsea

						console.log("------->length:"+obj.length);
						if(obj.state=="nostring"){
							document.getElementById("status").innerHTML = "No Search Word";
							return;
						}
						if(xmlhttp.responseText=="[]"){
							if(option==1){
								document.getElementById("status").innerHTML = "No relative.";
							}
							else{document.getElementById("status").innerHTML = "Search nothing."};
							return ;
						}

						document.getElementById("status").innerHTML =  "time:"+obj[0].time;
						document.getElementById("status").setAttribute("class","status_time");
						/*------create div to input result,li to create a new result tab,a is used for li------------*/
						list = document.createElement("li");
						atag = document.createElement('a');
						/*count the search nums and id name for each  div and li*/
						var divname = "result_"+resultnum;
						var tabname = "tab_"+resultnum;
				//relative search		
				if(option=='1'){
						var divname = "relative_"+resultnum;
						var tabname = "rtab_"+resultnum;
						/*-------------------------------------*/
						if(document.getElementById("rtab_0")==null){		
							newdiv = document.createElement('div');
							newdiv.setAttribute("id",divname);
							newdiv.setAttribute("class","result");
							document.getElementById("all_contain").appendChild(newdiv);
							/*-------------------------------------*/
							atag.setAttribute('href','#'+divname);
							atag.innerHTML = divname;
							list.setAttribute("class","");
							list.setAttribute("id",tabname);
							list.appendChild(atag);
							document.getElementById("tab").appendChild(list);
						}
						else{
							document.getElementById(divname).innerHTML="";
							document.getElementById(divname).setAttribute("style","display:block");
							//var s = document.getElementsByClassName("video_info");
							//for(i = s.length - 1;i>=0; i--){
							//		s[i].remove(s[i]);
							//}
						}
				}
				//hot search
				else if(option==2){
					var divname = "hot";
					document.getElementById("hot").innerHTML = "";
				}
				//if hadn't searched before, then create a new result lab, div	
				else if( document.getElementById(tabname)==null){
						//resultnum = resultnum+1;
						/*-------------------------------------*/
						newdiv = document.createElement('div');
						newdiv.setAttribute("id",divname);
						newdiv.setAttribute("class","result");
						document.getElementById("all_contain").appendChild(newdiv);
						/*-------------------------------------*/
						atag.setAttribute('href','#'+divname);
						atag.innerHTML = divname;
						list.setAttribute("class","");
						list.setAttribute("id",tabname);
						list.appendChild(atag);
						document.getElementById("tab").appendChild(list);
				}
				else{
						document.getElementById(divname).innerHTML="";
						document.getElementById(divname).setAttribute("style","display:block");
						var s = document.getElementsByClassName("video_info");
						for(i = s.length - 1;i>=0; i--){
								s[i].remove(s[i]);
						}
				}
						/*--------refresh the html because li has be added-------------*/
						$(function(){
						var _showTab = -1;
						var $nowLi = $('ul.tabs li').eq(_showTab).addClass('active').siblings('.active').removeClass('active');
						$nowTab = $($('ul.tabs li').eq(_showTab).find('a').attr('href')).siblings('.result').hide();
						$('ul.tabs li').mouseover(function() {
							var $this = $(this),
							_clickTab = $this.find('a').attr('href');
							//document.getElementById("info_1").innerHTML = $this.find('a').attr('href');
							$this.addClass('active').siblings('.active').removeClass('active');
							$(_clickTab).stop(false, true).fadeIn().siblings().hide();
							return false;
							}).find('a').focus(function(){
								this.blur();
							});
						});
						/*---------create a table to input the result of table----------------------------*/
						table = document.createElement("table");
						table.style.width = '100%';
						table.innerHTML = "<tr align='center'><th width='155px'>Total:"+obj.length+"</th></tr>";

						for (i = 0; i < obj.length; i++){
								temp = "{'title':'"+obj[i].title+"','id':'"+obj[i].id+"','content':'"+obj[i].content+"','author':'"+obj[i].author+"','viewCount':'"+obj[i].viewCount+"'}";
								var cname = "c_"+i; 
								console.log("!!!!!:"+temp);
								title = (obj[i].title).replace(/\"/g,"\\u0022");
								title = (title).replace(/\'/g,"\\u0027");
								content = (obj[i].content).replace(/\"/g,"\\u0022");
								content = (content).replace(/\'/g,"\\u0027");
								content = (content).replace(/\r\n/g,"<br />");
								published = (obj[i].published).replace(/\"/g,"\\u0022");
								published = (published).replace(/\'/g,"\\u0027");
								author = (obj[i].author).replace(/\"/g,"\\u0022");
								author = (author).replace(/\'/g,"\\u0027");
								
								if(obj[i].keyword!=null){
									keyword = (obj[i].keyword).replace(/\"/g,"\\u0022");
									keyword = (keyword).replace(/\'/g,"\\u0027");
								}
								else{keyword="no";}


								
								//video_info(temp,cname);//append all result page, and hide them first
								myid = <?php echo $uid ; ?>;
								data = "<tr VALIGN=top onmouseover=\"this.style.backgroundColor='pink';\"onMouseOut=\"this.style.backgroundColor=''\" onclick=\"openvideo('"+myid+"','"+cname+"','"+obj[i].id+"','"+title+"','"+obj[i].category+"','"+content+"','"+published+"','"+author+"','"+keyword+"','"+obj[i].viewCount+"','"+obj[i].favoriteCount+"','"+obj[i].duration+"','"+obj[i].uid+"','"+option+"')\" align='left'><th  width='180px' height='130px'><img width='180px' height='130px' src='"+obj[i].smallp+"'></img></td></th><td><div class='result_title'>"+obj[i].title+"</div><div class='result_viewcount'>viewCount:"+obj[i].viewCount+"</div></td></tr>";
								
								//console.log(data);
								//no link with picture
								table.innerHTML = table.innerHTML + data;
						}
						document.getElementById(divname).appendChild(table);
						/*---------------------------------------------------------------------------------*/

				}
				else if(xmlhttp.readyState == 3 && xmlhttp.status == 200){
						//document.getElementById("status").innerHTML = "Search Error";
				}
				else {
						//document.getElementById("content1").innerHTML = "now status="+xmlhttp.status;
						//document.getElementById("content2").innerHTML = "now readyState="+xmlhttp.readyState;
						console.log('ready state:'+xmlhttp.readyState+'status:'+xmlhttp.status);
						document.getElementById("status").innerHTML = "Searching...";
						if(option==2){
							document.getElementById("hot").innerHTML = "Loading...";
						}	
				}
		}
		xmlhttp.open("POST", "search.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		//value = encodeURI(value);
		//console.log("value->"+value);
		xmlhttp.send("searchp="+value+"&cat="+escape(cat)+"&option="+escape(option));//cat is category that mysql will use
		/*-----if use d3 to search then when mouseleave to the circle then the chart will fade out*/
		var div=$("#chart");
		div.css("opacity") == 1 ? div.fadeTo("slow", 0.0) : div.fadeTo("slow", 1.0);
		div.css("visibility", "hidden");

}


//jquery:d3 & movie show/hide control 
$(document).ready(function (){
				$("#sp").click(function(){
						console.log("go");
					var temp = document.getElementById("sp").innerHTML;
					document.getElementById("sp").innerHTML = "<input type='text' value='"+temp+"'/>";
				});
				
				
				$(".close").click(function(){
					//delete all video page, relative result, but keep result
					var s = document.getElementsByClassName("video_info");
					for(i = s.length - 1;i>=0; i--){
						s[i].remove(s[i]);
					}
					if(s = document.getElementById("relative_0")){
							s.remove();
					}
					if(s = document.getElementById("rtab_0")){
							s.remove();
					}

					/*just hidden
					for(i=0;i<s.length;i++){
						(document.getElementsByClassName("video_info"))[i].style.visibility="hidden";
					}
					*/
						document.getElementById("searchc").style.visibility="hidden";
						document.getElementById("main").style.visibility="visible";
		    	 });
				
				$("#fad").click(function(){
								var div=$("#chart");
								if(d3.select("#chart").style("visibility")=="hidden"){
								d3.select("#chart").style("visibility", "visible");
								d3.select("#chart").style("opacity",0);
								div.css("opacity") == 0 ? div.fadeTo("slow", 1.0) : div.fadeTo("slow", 0.0);
								}
								else{
								div.css("opacity") == 1 ? div.fadeTo("slow", 0.0) : div.fadeTo("slow", 1.0);
								}
								});

				/*info_1 is for log in/out and user manager*/
				/*$("#info_1").mouseenter(function(){
								var div=$("#info_1");
								div.css("background","red");
								div.css("width","20%");
								div.css("height","30%");
								document.getElementById("info_1").innerHTML = "yo~~~";
								});
				$("#info_1").mouseout(function(){
								var div=$("#info_1");
								div.css("background","gray");
								div.css("width","5%");
								div.css("height","5%");
								document.getElementById("info_1").innerHTML = "log in/out and user manage";
								});
				*/
				/*info_2 is for history, mylist and myup*/
				/*
				$(".info_2").click(function(){
								var div=$(".info_2");
								div.innerHTML="";
								div.css("background","red");
								div.css("width","20%");
								div.css("height","30%");
								
								newlink = document.createElement('a');
								//newlink.setAttribute("id",divname);
								//newlink.setAttribute("class","info_2");
								newlink.setAttribute("href","video_manage.php");
								newlink.innerHTML="myUpload";
								document.getElementsByClassName("info_2")[0].appendChild(newlink);
			
								//document.getElementsClassName("info_2").innerHTML = "<a href='video_manage.php'>myUpload</a><br>";
								});
				*/
				/*
				$(".info_2").click(function(){
								var div=$(".info_2");
								div.css("background","gray");
								div.css("width","5%");
								div.css("height","5%");
								document.getElementsClassName("info_2")[0].innerHTML = "for history, mylist and myup";
								});
				*/
				/*info_3 is for manager subscribe*/
				/*info_4 is for upload*/
				/*info_5 is other*/
});
//load this function when the web is load first, to get the init web notice
$(function(){
		var _showTab = 0;
		var $defaultLi = $('ul.tabs li').eq(_showTab).addClass('active');
		$($defaultLi.find('a').attr('href')).siblings().hide();
		$('ul.tabs li').mouseover(function() {
				var $this = $(this),
				_clickTab = $this.find('a').attr('href');
				//document.getElementById("info_1").innerHTML = $this.find('a').attr('href');
				$this.addClass('active').siblings('.active').removeClass('active');
				$(_clickTab).stop(false, true).fadeIn().siblings().hide();
				return false;
			}).find('a').focus(function(){
				this.blur();
			});
});

</script>
</head>
<body onload="search('hot','nocat','2')" background='image/home.jpg' style=" background-size：auto; background-size: 1000px 900px; ">

<div id="main">
		<div id="sequence"></div>
	<div id="chart">
		<div id="explanation">
			<div>Do you want to Search</div>
			<div id="key"></div></br>
			<span id="percentage"></span><br/>
		</div>
	</div>
	<div id="searchblock">
		<INPUT TYPE="text" NAME="searchp" ID="searchp"></INPUT>
		<!--option:0 is main search,option:1 is relative search need to create a new tab,option:2 is mean hot search when web load-->
		<INPUT value="Search" type="button" onclick="search(document.getElementById('searchp').value,'nocat','0')"/>
		<div id="fad"><button onclick="get(document.getElementById('searchp').value)">Category</button></div>
	</div>


	<div id="info_1">
		<a href="user/logout.php">log out</a><br>
		<a href="user/profile.php">user manage</a><br>

	</div>
	<div class="info_2">
		<a href="video_manage.php?option=1">收藏清單</a><br>
		<a href="upload_manage.php?">我的影片</a><br>
		<a href="video_manage.php?option=2">瀏覽紀錄</a>
	</div>
	<div id="info_3">
		<a href="sub_manage.php">Subscribe notice</a>
	</div>
	<div id="info_4">
		<a href="video_upload.php">上傳</a>
	</div>
</div>
<!--<div id="sidebar">
<input type="checkbox" id="togglelegend">block<br/>
<div id="legend" style="visibility: hidden;"></div>
</div>-->
<script type="text/javascript" src="sequences.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<div id="message">
	<div id="status" class="status_time" align="center"></div>
</div>

<div id=notice>
	<div class="abgne_tab">
	<ul id="tab" class="tabs">
		<li id="hot_tab"><a href="#hot">Hot!</a></li>
	</ul>
	</div>

	<div id="all_contain" class="tab_container">
		<div id="hot" class="result"></div>
	</div>

</div>

<!--<div id="searchc" onclick="hidevideo()"></div>-->
<div id="searchc"></div>
</body>
</html>
