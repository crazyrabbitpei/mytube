var playCount;
var player;
var obj;
var totalv=0;
var exist = [];
var nowid;
var nowc;

var last_del=10000000;

// 3. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
function onYouTubeIframeAPIReady() {
	player = new YT.Player('player', {
			height: '100%',
			width: '100%',
	videoId: nowid,
	playerVars: {
                            //rel: 1,
                            //autoplay: 1,
                            //disablekb: 0,
                            //showsearch: 0,
                            //showinfo: 0,
                            //controls: 1,
                            autohide: 1
                            //modestbranding: 0,
                            //wmode: 'opaque',
                            //hd: 1,
                            //html5: 1,
                            //iv_load_policy: 3
         },
	events: {
		'onReady': onPlayerReady,
		'onStateChange': onPlayerStateChange
	}
	});
}

// 4. The API will call this function when the video player is ready.
function onPlayerReady(event) {
	event.target.playVideo();
}

// 5. The API calls this function when the player's state changes.
//    The function indicates that when playing a video (state=0),
//    the player should play for the next video.
function onPlayerStateChange(event) {
	console.log("check"+event.data);
	if (event.data == 0) {
		if(playCount!=-1){
			playCount++;
			nowc = playCount;
			if (playCount > (obj.length -1)) {
        	                playCount = 0;
				nowc = 0;
        	        }		
			nextvideo(playCount);
		}
	}
}
function nextvideo(c){
		playCount=c;
		nowc = c;
		nowid = obj[c].id;
		player.loadVideoById(obj[c].id);
                player.playVideo();
		
		cdiv = document.getElementsByClassName('video_info')[0];
		cdiv.setAttribute("id",obj[c].id);
		//favoriteCount = like(obj[c].id);
		obj[c].favoriteCount = like(obj[c].id);
		//obj[c].favoriteCount = '0';
			
		cdiv = document.getElementById('v_content_block');
		cdiv.innerHTML = "<div id='v_content'>ViewCount : "+obj[c].viewCount+"<span id='like'>Favorite : "+obj[c].favoriteCount+"</span>Duration : "+obj[c].duration+"<br>Author : "+obj[c].author+"&nbsp&nbsp;Published : "+obj[c].published+"<br>Category : "+obj[c].category+"<br><br>Content : <br>"+obj[c].content+"</div>";
		
		cdiv = document.getElementsByClassName('video_title')[0];
		cdiv.innerHTML= "<h1>"+obj[c].title+"</h1>";
		
		title=replace(obj[c].title);
                //category=replace(obj[c].category);
                //content=replace(obj[c].content);
                //author=replace(obj[c].author);
                //keyword=replace(obj[c].keyword);
		
		console.log("obj[c].title-->"+obj[c].title);

		cdiv = document.getElementsByClassName('add_list')[0];
		cdiv.setAttribute("onclick","add_list('"+obj[c].myid+"','"+obj[c].id+"','favorite','"+title+"','10')");

		cdiv = document.getElementsByClassName('subscribe')[0];
		cdiv.setAttribute("onclick","subscribe('"+obj[c].myid+"','"+obj[c].uid+"')");

		r_history(obj[c].myid,obj[c].id,obj[c].title,obj[c].category,obj[c].content,obj[c].published,obj[c].author,obj[c].keyword,obj[c].viewCount,obj[c].favoriteCount,obj[c].duration,"r_history.php");
		return;
	
}
function videolist(list,option,s,order){
	console.log("videolist:"+list+" option:"+option+" s:"+s+" order:"+order);
	playCount = s;
	
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
                       // console.log("return:["+xmlhttp.responseText+"]");
			obj = JSON.parse(xmlhttp.responseText);
			totalv = obj.length;
			for(var i=0;i<obj.length;i++){
				exist[i]='1';	
			}

                }
                else {
                        //document.getElementById("status").innerHTML = "Recording...";
                }
        }
        xmlhttp.open("POST","get_list_info.php", true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	//1:mylist,2:myhistory,3:myUpload,4:mysub
	xmlhttp.send("list="+encodeURIComponent(list)+"&option="+option+"&order="+order);
	
	return;
}
//post data to to video_info.php,not yet(just input title and id), hidden now
function r_history (myid,id,title,category,content,published,author,keyword,viewc,fcount,duration,to) {
	console.log("r_history:title "+encodeURIComponent(title));
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
			console.log("r_history------>"+xmlhttp.responseText);
		}
		else {
			//document.getElementById("status").innerHTML = "Recording...";
		}
	}
	xmlhttp.open("POST",to, true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("uid="+myid+"&id="+id+"&title="+encodeURIComponent(title)+"&category="+encodeURIComponent(category)+"&content="+encodeURIComponent(content)+"&published="+published+"&author="+encodeURIComponent(author)+"&keyword="+encodeURIComponent(keyword)+"&viewc="+viewc+"&fcount="+fcount+"&duratoin="+duration);
	//if want to post data to a  new page
	/*var myForm = document.createElement("form");
	  myForm.method="post" ;
	  myForm.action = to ;

	  var temp=document.createElement("input");
	  temp.type="text";
	  temp.name="id";
	  temp.value=id;
	  myForm.appendChild(temp);
	//console.log("name:"+myForm.name+"value:"+myForm.value);
	console.log(myForm);

	document.body.appendChild(myForm) ;
	myForm.submit() ;
	document.body.removeChild(myForm) ;
	 */		
}

function openvideo (myid,cname,id,title,category,content,published,author,keyword,viewc,fcount,duration,uid,option) {//study how to do without jump to another video page
	//record hostory
	r_history(myid,id,title,category,content,published,author,keyword,viewc,fcount,duration,"r_history.php");
	/*clean the content before*/
	//console.log("["+myid,cname,id,title,category,content,published,author,keyword,viewc,fcount,duration,uid,option+"]");
	nowid = id;
	if(option!=10){
		playCount=-1;
	}
	
	var s = document.getElementsByClassName("video_info");
	document.getElementById("searchc").innerHTML="";
	for(i = s.length - 1;i>=0; i--){
		s[i].remove(s[i]);
	}

	if(option==2){
		if(s = document.getElementById("tab_0")){
			s.remove();
		}
		if(s = document.getElementById("result_0")){
			s.remove();
		}
	}
	/*append a new page that i click*/
	cdiv = document.createElement("div");
	cdiv.setAttribute("id",cname);
	cdiv.setAttribute("class","video_info");
	document.getElementById("searchc").appendChild(cdiv);


		content = (content).replace(/\r\n/g,"<br/>");
		//content = (content).replace(/\n/g,"<br>");
	console.log("1openvideo------>fcontent:"+fcount);
	//fcount = like(id,2);	
	//console.log("2openvideo------>fcontent:"+fcount);
	//append video info
	cdiv = document.createElement("div");
	cdiv.setAttribute("id","v_content_block");
	cdiv.innerHTML = "<div id='v_content'>ViewCount : "+viewc+"<span id='like'>Favorite : "+fcount+"</span>Duration : "+duration+"<br>Author : "+author+"&nbsp&nbsp;Published : "+published+"<br>Category : "+category+"<br><br>Content : <br>"+content+"</div>";  
	document.getElementById(cname).appendChild(cdiv);
	
	//append video and title
	cdiv = document.createElement("div");
	cdiv.setAttribute("class","video_title");
	cdiv.innerHTML= "<h1>"+title+"</h1>";
	document.getElementById(cname).appendChild(cdiv);
	/*---------------------------------youtube api----------------------------------------*/
	cdiv = document.createElement("div");
	cdiv.setAttribute("class","video_frame");
	cdiv.setAttribute("id","player");
	//youtube api:https://developers.google.com/youtube/player_parameters#Parameters
	if(option<10){
		cdiv.innerHTML= "<iframe class='video' src='//www.youtube.com/embed/"+id+"?autoplay=1&autohide=1' frameborder='0' allowfullscreen=1 autoplay='1'></iframe><br>";
	}
	else{
	// 2. This code loads the IFrame Player API code asynchronously.
		var tag = document.createElement('script');
		tag.src = "https://www.youtube.com/iframe_api";
		var firstScriptTag = document.getElementsByTagName('script')[0];
		firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	}

	document.getElementById(cname).appendChild(cdiv);
	/*--------------------------------------------*/
	//append close and add_list buttom and subscribe
	cdiv = document.createElement("div");
	cdiv.setAttribute("id","video_option");
	document.getElementById("searchc").appendChild(cdiv);

	title = (title).replace(/\"/g,"\\u0022");
	title = (title).replace(/\'/g,"\\u0027");
	content = (content).replace(/\"/g,"\\u0022");
	content = (content).replace(/\'/g,"\\u0027");
	//content = (content).replace(/\r\n/g,"<br/>");
	published = (published).replace(/\"/g,"\\u0022");
	published = (published).replace(/\'/g,"\\u0027");
	author = (author).replace(/\"/g,"\\u0022");
	author = (author).replace(/\'/g,"\\u0027");


	//of myList mod, then do another close
	cdiv = document.createElement("div");
	cdiv.setAttribute("class","close");
	cdiv.setAttribute("onclick","video_close("+option+")");
	cdiv.innerHTML="<img src='image/close.png' style='width: 50px;'></img>";
	document.getElementById("video_option").appendChild(cdiv);
	//input_list
	cdiv = document.createElement("div");
	cdiv.setAttribute("id","list_block");
	cdiv.innerHTML = "<div id='input_block'><input id='input_list' class='input_list' value='favorite' style='text'></input><select id='limit'><option value='public'>公開</option><option value='hide'>不公開</option><option value='private'>私人</option></select></div>";
	document.getElementById("searchc").appendChild(cdiv);
	//add_list
	cdiv = document.createElement("div");
	cdiv.setAttribute("class","add_list");
	cdiv.setAttribute("onclick","add_list('"+myid+"','"+id+"','favorite','"+title+"','"+option+"')");
	cdiv.innerHTML="<img src='image/edit_property.png' style='width: 50px;'></img>";
	document.getElementById("video_option").appendChild(cdiv);

	cdiv = document.createElement("div");
	cdiv.setAttribute("class","subscribe");
	cdiv.setAttribute("onclick","subscribe('"+myid+"','"+uid+"')");
	cdiv.setAttribute("style","margin: 0px 0px 20px 0px;");
	cdiv.innerHTML="<img src='image/sub.png' style='width: 50px;'></img>";
	document.getElementById("video_option").appendChild(cdiv);


	cdiv = document.createElement("div");
	cdiv.setAttribute("class","like");
	cdiv.setAttribute("onclick","like('"+id+"','1')");
	cdiv.setAttribute("style","margin: 0px 0px 20px 0px;");
	cdiv.innerHTML="<img src='image/like.png' style='width: 50px;'></img>";
	document.getElementById("video_option").appendChild(cdiv);

	/*show the page and hide the main div*/
	document.getElementById("searchc").style.visibility="visible";
	if(option<10){
		document.getElementById("main").style.visibility="hidden";
	}
	document.getElementById(cname).style.visibility="visible";



	//relative search
	if(option!='1'){
		var reg=/[-\'()]/g;
		var rela_title = title.replace(reg," ");
		rela_title = rela_title.replace(/  /g," ");
		var grabkey = 10;
		var searchk1 = 1,searchk2=0;
		var length=0,count=0;
		var keys = rela_title.split(" ",grabkey);
		for(i=0;i<keys.length;i++){
			if(keys[i].length>length){
				//console.log("bigger["+i+":"+keys[i]+"]small["+searchk2+"]<-"+searchk1);
				length = keys[i].length;
				if(i!=0){searchk2 = searchk1;}
				searchk1=i;
			}
			else if(keys[i].length>keys[searchk2].length && i<=searchk1+1){
				searchk2 = i;
			}
		}
		//console.log("["+keys[searchk1]+";"+keys[searchk2]+"]");
		//close relative search
		//search(keys[searchk1]+";"+keys[searchk2],'nocat','1');
	}

}
function like(id,option){
	console.log("like-> id:"+id);
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
                        document.getElementById("like").innerHTML = "Favorite : "+xmlhttp.responseText;
                }
                else {
                        //document.getElementById("status").innerHTML = "Recording...";
                }
        }
        xmlhttp.open("POST","like.php", true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send("id="+escape(id)+"&option="+option);
	//return xmlhttp.responseText;//to do
}
function video_close(option,sort){
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

	if(option>=10){
		console.log(option);
		option = option/10;
		location.href="video_manage.php?option="+option;
	}
	//if(option==2){
	//	document.getElementById("hot_tab").setAttribute("class","active");
	//	document.getElementById("hot").style.display="block";
	//document.getElementById("tab_0").setAttribute("class","");
	//document.getElementById("result_0").style.display="none";

	//}
	else{
		if(document.getElementById("tab_0")){
			document.getElementById("tab_0").setAttribute("class","active");
			document.getElementById("result_0").style.display="block";
			document.getElementById("hot_tab").setAttribute("class","");
			document.getElementById("hot").style.display="none";
		}
		else{
			document.getElementById("hot_tab").setAttribute("class","active");
			document.getElementById("hot").style.display="block";
		}


		document.getElementById("searchc").style.visibility="hidden";
		document.getElementById("searchc").innerHTML="";
		document.getElementById("main").style.visibility="visible";
	}
}
function add_list(myid,id,list,title,option){
	//title = (title).replace(/\"/g,"\\u0022");
	//title = (title).replace(/\'/g,"\\u0027");
	var s = document.getElementById("list_block");
	if(s.style.visibility=="visible"){
		list = document.getElementById('input_list').value;
		lim = document.getElementById('limit');
		var text = lim.options[lim.selectedIndex].value;
		console.log("list---->"+list+"title---->"+title+"lim--->"+text);
		document.getElementById('list_name_block').remove();
		s.style.visibility="hidden";
		console.log("uid:"+myid+"id"+id);
		console.log("list:"+list);
		r_list(myid,id,list,title,option,text,"r_list.php");
	}

	else{
		s.style.visibility="visible";

		//document.getElementById("status").innerHTML = "";
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
				//console.log("------>["+xmlhttp.responseText+"]");
				obj1 = JSON.parse(xmlhttp.responseText);//if json is not correct, this line will occur falsea
				cdiv = document.createElement("div");
				cdiv.setAttribute("id","list_name_block");
				document.getElementById("list_block").appendChild(cdiv);
				ul_block = document.createElement("ul");
				ul_block.setAttribute("id","list_name");
				document.getElementById("list_name_block").appendChild(ul_block);
				if(obj1.length==0){
					li = document.createElement("li");
					li.innerHTML = "No list.<br>";
					document.getElementById("list_name").appendChild(li);
				}
				else{
					title = (title).replace(/\"/g,"\\u0022");
					title = (title).replace(/\'/g,"\\u0027");
					console.log("change-->"+title);
					for(i=0;i<obj1.length;i++){
						li = document.createElement("li");
						li.setAttribute("class","one_list_name");
						li.setAttribute("onclick","document.getElementById('input_list').value='"+obj1[i].list+"',add_list('"+myid+"','"+id+"','"+obj1[i].list+"','"+title+"')");
						if(obj1[i].lim=='公開'||obj1[i].lim=='public'){
                                        		icon = 'image/un_lock.png';
						}
						if(obj1[i].lim=='不公開'||obj1[i].lim=='hide'){
                                        		icon = 'image/lock.png';
						}
						if(obj1[i].lim=='私人'||obj1[i].lim=='private'){
                                       			icon = 'image/self3.png';
                                                }
						li.innerHTML = "<span>"+obj1[i].list+"</span><img src='"+icon+"' style='width: 20px; height: 20px;'></img>";
						document.getElementById("list_name").appendChild(li);
						console.log(obj1[i].list);
					}
				}
			}
			else {
				//document.getElementById("status").innerHTML = "Recording...";
			}
		}
		xmlhttp.open("POST","get_list.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp.send("myid="+escape(myid));
	}

}

function get_list(option){
		console.log("option:"+option);
		//document.getElementById("status").innerHTML = "";
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
				//console.log("------>["+xmlhttp.responseText+"]");
				obj1 = JSON.parse(xmlhttp.responseText);//if json is not correct, this line will occur falsea
				cdiv = document.createElement("div");
				//cdiv.setAttribute("id","list_name_block");
				//document.getElementById("list_block").appendChild(cdiv);
				ul_block = document.createElement("ul");
				ul_block.setAttribute("id","list_name");
				document.getElementById("list_name_block1").appendChild(ul_block);
				if(obj1.length==0){
					li = document.createElement("li");
					li.innerHTML = "No list.<br>";
					document.getElementById("list_name").appendChild(li);
				}
				else{
					for(i=0;i<obj1.length;i++){
						li = document.createElement("li");
						li.setAttribute("class","one_list_name");
						li.setAttribute("onclick","document.getElementById('input_list').value='"+obj1[i].list+"'");
						/*
						if(obj1[i].lim=='public'){
							obj1[i].lim = '公開';
						}
						if(obj1[i].lim=='hide'){
							obj1[i].lim = '不公開';
						}
						if(obj1[i].lim=='private'){
							obj1[i].lim = '私人';
                                                }
						*/
						//li.innerHTML = "<span>"+obj1[i].list+"</span><span style='color:pink'>("+obj1[i].lim+")<span>";
						li.innerHTML = "<span>"+obj1[i].list+"</span>";
						
						document.getElementById("list_name").appendChild(li);
						console.log(obj1[i].list);
					}
				}
			}
			else {
				//document.getElementById("status").innerHTML = "Recording...";
			}
		}
		xmlhttp.open("POST","get_list.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp.send("option="+option);

}
function subscribe(myid,uid){
	console.log("myid:"+myid+"sub-> uid:"+uid);
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
			//console.log("subscribe------>["+xmlhttp.responseText+"]");
			message(xmlhttp.responseText,'searchc');
			//document.getElementById("status").innerHTML = xmlhttp.responseText;
		}
		else {
			//document.getElementById("status").innerHTML = "Recording...";
		}
	}
	xmlhttp.open("POST","subscribe.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("myid="+escape(myid)+"&uid="+escape(uid));

}

function r_list (myid,id,list,title,option,lim,to) {
	console.log("r_list:title=>"+title+" lim:"+lim);
	if(s = document.getElementById("add_massage_block")){
		s.remove();
	}

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
			console.log("------>"+xmlhttp.responseText);
			//test(xmlhttp.responseText,'searchc');
			message(xmlhttp.responseText,'searchc');
		}
		else {
			//document.getElementById("status").innerHTML = "Recording...";
		}
	}
	xmlhttp.open("POST",to, true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("uid="+escape(myid)+"&id="+escape(id)+"&list="+encodeURIComponent(list)+"&title="+encodeURIComponent(title)+"&lim="+lim);
}
function message(msg,position){
	cdiv = document.createElement("div");
	cdiv.setAttribute("class","message_block");
	cdiv.setAttribute("id","add_massage_block");
	cdiv.style.display="none";
	cdiv.innerHTML=msg;
	document.getElementById(position).appendChild(cdiv);
	$("#add_massage_block").fadeIn(500,function(){
			setTimeout(function(){
				$("#add_massage_block").fadeOut(3000);
				},2000);
			});
}
function editvideo(id,table,option,list,listNo,videoNo,total){
	option2 = option;
	if(option>=10){//10 is from 
		option2 = option/10;
		for(i=0;i<obj.length;i++){
			if(id==obj[i].id){
				exist[i]='0';
				totalv--;
				console.log("id:"+id+" is in ["+i+"] delete it->totalv:"+totalv);	
				break;
			}
		}
		for(j=0;j<obj.length;j++){
				if(nowid==obj[j].id){
					console.log("now is in num:"+j);
					break;
				}
		}
		
		if(i>j){
			console.log("[delete after]playing:"+playCount);
			//openlist(list,option2,playCount);
		}
		else if(i==j){
			if(i==obj.length-1){
				playCount--;
			}
			else if(totalv!=1){
			}
			else{
				playCount=0;
			}
			console.log("[delete nowid]playing:"+playCount);
			//openlist(list,option2,playCount);
		}
		else{
			playCount--;
			console.log("[delete before]playing:"+playCount);
			//openlist(list,option2,playCount);
		}
	}
	else if(videoNo!=undefined){
		videoNo = parseInt(videoNo);
		if(totalv==0){
			totalv = parseInt(total);
			total = parseInt(total);
		}
		containNo = listNo.split("_")[2];
		containNo = parseInt(containNo)-1;
		console.log("editvideo:"+id,table,option,list,listNo,videoNo,containNo);
		temp = videoNo-(total-totalv);
		console.log("videoNo["+videoNo+"]-(total["+total+"]-totalv["+totalv+"])="+temp);
		if(totalv==1){
			videoNo=0;
		}
		else if(videoNo<last_del){

		}
		else if(videoNo>last_del){
			videoNo = videoNo-(total-totalv);
			if(videoNo<0){
				videoNo=0;
			}
		}
		else if(videoNo == last_del){
			videoNo--;
		}

		if(s = document.getElementById(listNo).getElementsByTagName('li')[videoNo]){
			var h = document.getElementsByClassName("mCSB_container")[containNo].style.height;
			h = parseInt(h);
			h = h-216;
			h = h+"px";
			document.getElementsByClassName("mCSB_container")[containNo].style.height = h;
			temp = totalv-1;
			console.log("h:"+h+" containNo:"+containNo+" last_del:"+last_del+" now del:"+videoNo+"no totalv:"+temp);
			s.remove();
			last_del = videoNo;
			totalv--;
			document.getElementsByClassName("mCSB_container")[containNo].getElementsByClassName('item_title')[0].getElementsByTagName('span')[1].innerHTML = "共"+totalv+"部影片";
		}
	}
	if(s = document.getElementById("add_massage_block")){
		s.remove();
	}
	
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
			console.log("editvideo------>"+xmlhttp.responseText);
			//window.location.reload:自動更新頁面，目前先關起來，以方便觀察log，所以每次有操作都要更新畫面	
			//message(xmlhttp.responseText,'listc');
			if(option>=10){
				openlist(list,option2,playCount);
			}
			else if(videoNo!=undefined){
				if(totalv==0){
					delete_list(list,table,option);
					window.location.reload();
				}
			}
			else{
				window.location.reload();
			}
			/*setTimeout(function(){
			//window.location.replace(window.location.href);

			},2000);*/
		}
		else {
			//document.getElementById("status").innerHTML = "Recording...";
		}
	}
	xmlhttp.open("POST",'video_edit.php', true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("list="+encodeURIComponent(list)+"&table="+table+"&option="+option+"&id="+id);
}

function editownvideo(id,option){
	console.log(id,option);//option 1:video,list setting
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
			//console.log("------>"+xmlhttp.responseText);
			cdiv = document.createElement("div");
			cdiv.setAttribute("class","yt-dialog-base");
			cdiv.innerHTML=xmlhttp.responseText;
			document.getElementById("listc").appendChild(cdiv);
			get_list(option);
			//document.body.appendChild(cdiv);
			/*setTimeout(function(){
			//window.location.replace(window.location.href);
			message(xmlhttp.responseText,'listc');
			},2000);*/
		}
		else {
			//document.getElementById("status").innerHTML = "Recording...";
		}
	}
	xmlhttp.open("POST",'editownvideo.php', true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id="+id+"&option="+option);

}

function updateownvideo(list,option){
	p = document.getElementsByClassName("yt-uix-form-input-select-value")[0].innerHTML;
	sort = document.getElementsByClassName("yt-uix-form-input-select-value")[1].innerHTML;
	console.log("change p :"+list+"->["+p+"]->"+"sort:"+sort+" option="+option);
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
			removeset();
			window.location.reload();
			//message(xmlhttp.responseText,'listc');
			//document.body.appendChild(cdiv);
			/*setTimeout(function(){
			//window.location.replace(window.location.href);

			},2000);*/
		}
		else {
			//document.getElementById("status").innerHTML = "Recording...";
		}
	}
	xmlhttp.open("POST",'update_privacy.php', true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("list="+encodeURIComponent(list)+"&lim="+p+"&sort="+sort+"&option="+option);
	
}
function title_move(x){
	var speed=10;//900->30,300->10....
	speed = x.getElementsByClassName('title')[0].offsetWidth/30;
	x.getElementsByClassName('title')[0].style.transition="left "+speed+"s linear";
	//console.log("width:"+x.getElementsByClassName('title')[0].offsetWidth);
	//console.log("left:"+x.getElementsByClassName('title')[0].offsetLeft);

	x.getElementsByClassName('title')[0].style.left = 0 - x.getElementsByClassName('title')[0].offsetWidth;
	//console.log("->change:"+x.getElementsByClassName('title')[0].style.left);
	x.getElementsByClassName('title')[0].addEventListener("transitionend", function () {
			x.getElementsByClassName('title')[0].style.transition="right";
			x.getElementsByClassName('title')[0].style.left = 40+"px";
			setTimeout(function() {
				x.getElementsByClassName('title')[0].style.transition="left "+speed+"s linear";
				x.getElementsByClassName('title')[0].style.left = 0 - x.getElementsByClassName('title')[0].offsetWidth;
				}, 100);
			}, false);
}
function title_init(x,value){
	x.getElementsByClassName('title')[0].style.transition="right";
	x.getElementsByClassName('title')[0].style.left = value+"px";
}
function openlist(list,option,num){
	console.log("openlist:"+list,option,num);
	location.href="open_list.php?list="+list+"&option="+option+"&start="+num;
}
function delete_list(list,table,option){
	console.log("delete_list:"+list,table,option);
	if(s = document.getElementById("add_massage_block")){
		s.remove();
	}

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
			console.log("------>"+xmlhttp.responseText);
			window.location.reload();
			/*setTimeout(function(){
			//window.location.replace(window.location.href);
			message(xmlhttp.responseText,'listc');
			},2000);*/
		}
		else {
			//document.getElementById("status").innerHTML = "Recording...";
		}
	}
	xmlhttp.open("POST",'delete_list.php', true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("list="+encodeURIComponent(list)+"&table="+table+"&option="+option);

}
function pull_down(list,i,option,count){
	var num = parseInt(i);//list No
	var count = parseInt(count);//list videonum
	count1 = 170+(count*216)-18;
	idname = "mCSB_container_"+i;
	idname2 = "video_m_pull_down_"+i;
	idname3 = "open_list_"+i;
	console.log("o->height:"+document.getElementsByClassName("mCSB_container")[num-1].style.height);
	h = document.getElementsByClassName("mCSB_container")[num-1].style.height;
	if(h!=''&& h!='170px'){
		console.log("change->height:"+parseInt(h));
		normal(list,i);
		document.getElementById(idname2).innerHTML = "<span>pull down</span>";
		return;
	}
	document.getElementById(idname2).innerHTML = "<span>pull up</span>";

	newdiv = document.createElement('div');
	newdiv.setAttribute("id",idname3);
	newdiv.setAttribute("class","open_list");
	document.getElementById(idname).appendChild(newdiv);

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
			newdiv.innerHTML=xmlhttp.responseText;

			//videolist(list,option,'0');
		}
		else {
			//document.getElementById("status").innerHTML = "Recording...";
		}
	}
	xmlhttp.open("POST","get_video.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("list="+encodeURIComponent(list)+"&option="+option+"&listNo="+idname3+"&totalv="+count);
	document.getElementsByClassName("mCSB_container")[num-1].style.height=count1+"px";

}
function normal(list,i){
	var num = parseInt(i);
	idname3 = "open_list_"+i;
	console.log("out:"+num+",list:"+list);
	document.getElementsByClassName("mCSB_container")[num-1].style.height="170px";
	document.getElementById(idname3).style.visibility="hidden";
	//document.getElementById(list).style.background="pink";
	document.getElementById(idname3).remove();
}
function test(msg,num){
	console.log("this is:"+msg+"->num:"+num);
	return;
}
function replace(str){
	if(str==null){return;}
	str = (str).replace(/\"/g,"\\u0022");
	str = (str).replace(/\'/g,"\\u0027");
	console.log("str->"+str);
	return str;
}
function setting(list,option,lim,sort){
	console.log(list,option,lim,sort);//option 1:video,list setting
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
			//console.log("------>"+xmlhttp.responseText);
			cdiv = document.createElement("div");
			cdiv.setAttribute("class","yt-dialog-base");
			cdiv.innerHTML=xmlhttp.responseText;
			document.getElementById("listc").appendChild(cdiv);

			//document.body.appendChild(cdiv);
			/*setTimeout(function(){
			//window.location.replace(window.location.href);
			message(xmlhttp.responseText,'listc');
			},2000);*/
		}
		else {
			//document.getElementById("status").innerHTML = "Recording...";
		}
	}
	xmlhttp.open("POST",'setting.php', true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("list="+encodeURIComponent(list)+"&option="+option+"&lim="+lim+"&sort="+sort);

}
function changep(p,value){
		//var x =document.getElementsByClassName("yt-uix-form-input-select-element")[0];
		//var i = x.selectedIndex;
		console.log(p);
		document.getElementsByClassName("yt-uix-form-input-select-value")[value].innerHTML=p;
}
function updateset(list,option){
	p = document.getElementsByClassName("yt-uix-form-input-select-value")[0].innerHTML;
	sort = document.getElementsByClassName("yt-uix-form-input-select-value")[1].innerHTML;
	console.log("change p :"+list+"->["+p+"]->"+"sort:"+sort+" option="+option);
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
			removeset();
			window.location.reload();
			//message(xmlhttp.responseText,'listc');
			//document.body.appendChild(cdiv);
			/*setTimeout(function(){
			//window.location.replace(window.location.href);

			},2000);*/
		}
		else {
			//document.getElementById("status").innerHTML = "Recording...";
		}
	}
	xmlhttp.open("POST",'update_privacy.php', true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("list="+encodeURIComponent(list)+"&lim="+p+"&sort="+sort+"&option="+option);
	
}
function removeset(){
	if(document.getElementsByClassName("yt-dialog-base")[0]){
		document.getElementsByClassName("yt-dialog-base")[0].remove(document.getElementsByClassName("yt-dialog-base")[0]);
	}
}

function add_ill(list,option,ill){
	console.log(list,option,ill);
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
			cdiv = document.createElement("div");
			cdiv.setAttribute("class","yt-dialog-base");
			cdiv.innerHTML=xmlhttp.responseText;
			document.getElementById("listc").appendChild(cdiv);

			//document.body.appendChild(cdiv);
			/*setTimeout(function(){
			//window.location.replace(window.location.href);
			message(xmlhttp.responseText,'listc');
			},2000);*/
		}
		else {
			//document.getElementById("status").innerHTML = "Recording...";
		}
	}
	xmlhttp.open("POST",'add_ill.php', true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("list="+encodeURIComponent(list)+"&option="+option+"&ill="+encodeURIComponent(ill));

}

function updateill(list,value,option){
	p = value;
	console.log("change p :"+list+"->["+p+"]");
	
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
			//removeset();
			window.location.reload();
			//message(xmlhttp.responseText,'listc');
			//document.body.appendChild(cdiv);
			/*setTimeout(function(){
			//window.location.replace(window.location.href);

			},2000);*/
		}
		else {
			//document.getElementById("status").innerHTML = "Recording...";
		}
	}
	xmlhttp.open("POST",'update_ill.php', true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("list="+encodeURIComponent(list)+"&ill="+encodeURIComponent(p)+"&option="+option);
	
	
}
function list_all(option,num,list,count){
	var array = new Array();
	array = list.split(",");
	array1 = count.split(",");
	num = parseInt(num)+1;
	
	h = document.getElementsByClassName("mCSB_container")[0].style.height;
	if(h=='170px'||h==''){
		message("載入中...",'listc');
	}
	var i=1;
	var myVar = setInterval(function(){
			pull_down(array[i],i,option,array1[i]);
			console.log(i,array[i]+"->");
			i++;
			if(i==num){
			console.log("stop");
			if(s = document.getElementById("add_massage_block")){
				s.remove();
			}
			clearInterval(myVar);
			}
			},500);
}
