//--------------------------------- gallery 1.3
var galleryReq;
var slideshow_loaded=false;
var currentCarImages=new Array();
var current_img_id=0;
var maxpicfitted=21;
var curpicoffset=new Array(0,maxpicfitted);
var currentCID=0;
var currentCIDloaded=false;
var PICNUMBER=0;
var pagerw=25;//multiplier for offset based on current style
function onGReqError(){
	alert("ERROR");
}
function loadSlideShow(){
	//try{
	galleryReq=new mAJAXRequest();
	//}catch(err){
		//document.getElementById("jsclassess").src="scripts/classes.js";
	//}
	//---------------------------------------------------------[create gallery container
	var mainBody=document.getElementsByTagName("body").item(0);
	var gContainerDIV=document.createElement("div");
	gContainerDIV.setAttribute("id","slideshow");
	gContainerDIV.style.display="none";
	gContainerDIV.innerHTML='<div id="slideback"><iframe id="ifrgx"></iframe></div><div id="slideholder"><div class="content"><div class="topinfo"><p id="carname_container" class="car-name"></p><p class="car-name-lnks"><a href="javascript:;" onclick="closeSlideshow()">Close Gallery</a></p></div><!-- .topinfo --><br class="clean" /><div class="image_slide"><div class="loader"><img id="image_slide" width="640" class="largethumbsimg" /></div></div><div id="showlargeimages"><div class="sll"><a href="javascript:prevPic()">&lt;&lt;PREV</a></div><div id="imgbtns_holder"><div id="imgbtns_container" align="center"></div></div><div class="slr"><a href="javascript:nextPic()">NEXT&gt;&gt;</a></div></div><!-- #showlargeimages --></div></div>';
	//<div id="slideback"><iframe id="ifrgx" style="position:absolute;left:0;top:0;z-index:100;width:100%;height:100%;border:none;filter:progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)"></iframe></div><div id="slideholder"><div class="content"><div class="padding"><div class="topinfo"><p id="carname_container" class="car-name"></p><p class="car-name-lnks"><a href="javascript:;" onclick="closeSlideshow()">Close Gallery</a></p></div><img id="image_slide" width="640" class="largethumbsimg" /><div id="showlargeimages"><div class="sll"><a href="javascript:prevPic()">&lt;&lt;PREV</a></div><div id="imgbtns_holder"><div id="imgbtns_container" align="center"></div></div><div class="slr"><a href="javascript:nextPic()">NEXT&gt;&gt;</a></div></div></div></div></div>//
	mainBody.appendChild(gContainerDIV);
	//-----------------------------------------
	galleryReq.setRequestLocation("isapi_xml.php");
	galleryReq.setResponseType('xml');
	galleryReq.assignParser(galleryParser);
	galleryReq.assignErrorHandler(onGReqError);
	//-----------------------------------------
	slideshow_loaded=true;
}
function galleryParser(){
	var resp=galleryReq.getResponse();
	var gimages=resp.getElementsByTagName("IMG");
	if(gimages.length>0){
		currentCarImages=new Array();//<-clear old images
		if(resp.getElementsByTagName("CARNAME")[0].childNodes[0])
			document.getElementById("carname_container").innerHTML=resp.getElementsByTagName("CARNAME")[0].childNodes[0].nodeValue;
		var slideback=document.getElementById("slideback");
		slideback.style.width=document.documentElement.scrollWidth+"px";
		slideback.style.height=document.documentElement.scrollHeight+"px";
			
		document.getElementById("slideholder").style.top=document.documentElement.scrollTop+"px";
		document.getElementById("slideshow").style.display="block";
		//----------------------------------------------------------------------------------------
		var page_links='';
		for(var i=0;i<gimages.length;i++){
			if(i==0) page_links+='<a id="page'+i+'" class="selected" href="javascript:displayPic('+i+')">1</a>';
			else page_links+='<a id="page'+i+'" href="javascript:displayPic('+i+')">'+(i+1)+'</a>';
			//---------------
			currentCarImages[i]=new Image();
			currentCarImages[i].src=gimages[i].childNodes[0].nodeValue;
		}
		var imgbtns_container=document.getElementById("imgbtns_container");
		imgbtns_container.innerHTML=page_links;
		imgbtns_container.style.width=(pagerw+5)*currentCarImages.length+"px";
		document.getElementById("image_slide").src=currentCarImages[0].src;
		current_img_id=0;
		currentCIDloaded=true;
		if(PICNUMBER>0) movetoPic(PICNUMBER);
	}
}
function nextPic(){
	var nextimgid=current_img_id;
	if(++nextimgid>=currentCarImages.length)
		nextimgid=0;
	if(nextimgid==curpicoffset[1]||nextimgid==0){
		curpicoffset[0]=nextimgid;//+=maxpicfitted;<-left offfset
		if(nextimgid==0) curpicoffset[1]=maxpicfitted;//<-right offset
		else curpicoffset[1]+=maxpicfitted;
		document.getElementById("imgbtns_container").style.left="-"+(curpicoffset[0]*pagerw)+"px";
	}
	displayPic(nextimgid);
}
function prevPic(){
	var overlap=false;
	var nextimgid=current_img_id;
	if(--nextimgid<0){
		nextimgid=currentCarImages.length-1;
		if(nextimgid>curpicoffset[1])
			overlap=true;
	}
	if(nextimgid<curpicoffset[0]||overlap){
		if(overlap){
			curpicoffset[0]=parseInt(currentCarImages.length/maxpicfitted)*maxpicfitted-1;
			curpicoffset[1]=curpicoffset[0]+maxpicfitted;
		}else{
			curpicoffset[0]-=maxpicfitted;
			curpicoffset[1]-=maxpicfitted;
			if(curpicoffset[0]<0){//correct left shift if less then 0
				curpicoffset[0]=0;
				curpicoffset[1]=maxpicfitted;//also correct next right shift pic num
			}
		}
		document.getElementById("imgbtns_container").style.left="-"+(curpicoffset[0]*pagerw)+"px";
	}
	displayPic(nextimgid);
}
function displayPic(imgid){
	if(imgid!=current_img_id){
		document.getElementById("page"+current_img_id).className="";
		document.getElementById("page"+imgid).className="selected";
		current_img_id=imgid;
		document.getElementById("image_slide").src=currentCarImages[current_img_id].src;
	}
}
function movetoPic(pn){
	var s=Math.floor(pn/(maxpicfitted+1));//-get offset section number. (mpf+1) is to get s=0 if on the border
	curpicoffset[0]=s*maxpicfitted;
	curpicoffset[1]=maxpicfitted*(s+1);
	document.getElementById("imgbtns_container").style.left="-"+(curpicoffset[0]*pagerw)+"px";
	displayPic(pn);
}
function showSlideshow(cid){
	if(!slideshow_loaded){
		loadSlideShow();
	}
	if(cid==currentCID){
		if(currentCIDloaded){//display same screen if already loaded, so if no images then we won't request it again
			document.getElementById("slideholder").style.top=document.documentElement.scrollTop+"px";
			document.getElementById("slideshow").style.display="block";
			if(PICNUMBER>0) movetoPic(PICNUMBER);
		}
	}else{
		curpicoffset=new Array(0,maxpicfitted);
		current_img_id=0;
		currentCIDloaded=false;
		currentCID=cid;
		document.getElementById("imgbtns_container").style.left="0px";
		document.getElementById("image_slide").src="";
		galleryReq.setData("module=vigallery&cid="+cid);
		galleryReq.send();
	}
}
function closeSlideshow(){
	document.getElementById("slideshow").style.display="none";
}