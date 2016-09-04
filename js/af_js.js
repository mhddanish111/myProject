function rm_trim(inputString){
	if (typeof inputString != "string") { return inputString;}

	var temp_str = '';
	temp_str = inputString.replace(/[\s]+/g,"");
	if(temp_str == '')
		return "";
	
	var retValue = inputString;
	var ch = retValue.substring(0, 1);
	while (ch == " "){
		retValue = retValue.substring(1, retValue.length);
		ch = retValue.substring(0, 1);
	}
	ch = retValue.substring(retValue.length-1, retValue.length);
	while (ch == " "){
		retValue = retValue.substring(0, retValue.length-1);
		ch = retValue.substring(retValue.length-1, retValue.length);
	}
	while (retValue.indexOf("  ") != -1){
	  retValue = retValue.substring(0, retValue.indexOf("  ")) + retValue.substring(retValue.indexOf("  ")+1, retValue.length);
	}
	return retValue;
}

function isEmail(str){
	var at="@";
	var dot=".";
	var lat=str.indexOf(at);
	var ldot=str.indexOf(dot);
	var lstr=str.length;
	var extBody = str.split('.')

	if(str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		return false;
	}
	if(str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		return false;
	}
	if(str.indexOf(" ")!=-1){
		return false;
	}
	if(str.indexOf(at,(lat+1))!=-1){
		return false;
	}
	if(str.indexOf(dot,(lat+2))==-1){
		return false;
	}
	if(str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		return false;
	}
	if(extBody[1] == ''){
		return false;
	}
	return true;
}
function getAjaxRequestObject()
{
	var ajaxRequest;
	try
	{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
		
		return ajaxRequest;
		
	}
	catch (e)
	{
		// Internet Explorer Browsers
		try
		{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
			return ajaxRequest;
		}
		catch (e) 
		{
			try
			{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
				return ajaxRequest;
			}
			catch (e)
			{
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
}
function cartSetup(url,query,product_id,path){
	var extra_url="";
	if(query=="updatecart"){
		extra_url=getFormData("frm_cart");
	}
	//alert(extra_url);
	//alert(url);
	var ajaxRequest=getAjaxRequestObject();  
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var message=ajaxRequest.responseText.split("#@#");
			//alert(message[2]);
			if(message[0]=="failure"){
				alert("Error in server response");
			}
			else if(message[0]=="success"){
				if(query=="addtocart"){
					document.getElementById("addtocart_span"+product_id).innerHTML=message[1];
					document.getElementById("mycartdisplay").innerHTML=message[2];
					document.getElementById("cart").style.display="block";
					if(document.getElementById("showcartitem_left"))
						document.getElementById("showcartitem_left").innerHTML=message[3];
				}
				else if(query=="removefromcart"){
					if(document.getElementById("addtocart_span"+product_id))
						document.getElementById("addtocart_span"+product_id).innerHTML=message[1];

					if(message[2]=="empty"){
						document.getElementById("mycartdisplay").innerHTML="Cart is Empty";	
						document.getElementById('cart').style.display='none';
						document.getElementById('myFloatCart').style.display='none';
						
					}
					else{
						document.getElementById("mycartdisplay").innerHTML=message[2];
						document.getElementById("cart").style.display="block";
					}
					if(document.getElementById("showcartitem_left"))
						document.getElementById("showcartitem_left").innerHTML=message[3];
				}
				else if(query=="updatecart"){
					document.getElementById("mycartdisplay").innerHTML=message[2];
					document.getElementById("cart").style.display="block";
					if(document.getElementById("showcartitem_left"))
						document.getElementById("showcartitem_left").innerHTML=message[3];
				}
				else if(query=="viewcart"){
					//alert("hi");
					//alert(message[2]);
					//alert(message[3]);
					document.getElementById("mycartdisplay").innerHTML=message[2];
					document.getElementById("cart").style.display="block";
					if(document.getElementById("showcartitem_left"))
						document.getElementById("showcartitem_left").innerHTML=message[3];
				}
			}
			else{
				alert("Error in server response");
			}
			
			
		}
	}
	var queryString =url+""+extra_url+"&path="+path+"&dt="+new Date().getTime();
//alert(queryString);
	ajaxRequest.open("POST",queryString, true);
	ajaxRequest.send(null); 
}





function SHSDivWithPos(did,act,evt){
	var divObject=document.getElementById(did);
	var xyPOS=getXY(evt);
	divObject.style.display=act;
	divObject.style.left=xyPOS[0]+"px";
	divObject.style.top=xyPOS[1]+"px";
	alert(did+'left: '+xyPOS[0]+'\ntop : '+xyPOS[1]);
}
function SHSDiv(did,act){
	if(document.getElementById(did)){
		var sdivObject=document.getElementById(did);
		sdivObject.style.display=act;
	}
}

// get xy mouse pointer
function getXY(e) {
	var posx = 0;
	var posy = 0;
	if (!e) var e = window.event;
	if (e.pageX || e.pageY) 	{
		posx = e.pageX;
		posy = e.pageY;
	}
	else if (e.clientX || e.clientY) 	{
		posx = e.clientX + document.body.scrollLeft
			+ document.documentElement.scrollLeft;
		posy = e.clientY + document.body.scrollTop
			+ document.documentElement.scrollTop;
	}
	return new Array(posx,posy);
//	alert(posx+"\n"+posy);
	// posx and posy contain the mouse position relative to the document
	// Do something with this information
}
//*************** getting all input type from form and make query string *************
function getFormData(theForm){
   var inputtype=new Array("text","hidden","radio","checkbox","file","password");
   var urlData="";
   //checking select type
   if(document.getElementById(theForm).getElementsByTagName("select")){
    elements = document.getElementById(theForm).getElementsByTagName("select");
    for(i=0;i<elements.length;i++){
     urlData+="&"+elements.item(i).name+"="+elements.item(i).value;
    }
   }
   
   if(document.getElementById(theForm).getElementsByTagName("textarea")){
    elements = document.getElementById(theForm).getElementsByTagName("textarea");
    for(i=0;i<elements.length;i++){
     urlData+="&"+elements.item(i).name+"="+escape(elements.item(i).value);
    }
   }
   
   for(var ti=0;ti<inputtype.length;ti++){
    elements = document.getElementById(theForm).getElementsByTagName("input");
    
    for(var i=0;i<elements.length;i++){
     if(elements.item(i).type == inputtype[ti]){
      if (elements.item(i).type == "radio" || elements.item(i).type == "checkbox"){
       if (elements.item(i).checked==true){ 
       urlData+="&"+elements.item(i).name+"="+elements.item(i).value;
       }
      }
      else if (elements.item(i).type == "hidden"){
       if (elements.item(i).name!="basePathtxt" && elements.item(i).name!="claimbillpath" && elements.item(i).name!="finalUploadPath"){
       urlData+="&"+elements.item(i).name+"="+elements.item(i).value;
       }
      }
      else{
       urlData+="&"+elements.item(i).name+"="+elements.item(i).value;
      }
     }
    }
    
   }
   return(urlData);
 }
  
  ///////////////////////////*************** BLANK FORM DATA **********************
  function clearFormData(theForm){
   var inputtype=new Array("text","hidden","radio","checkbox","file","password");
   var urlData="";
   //checking select type
   if(document.getElementById(theForm).getElementsByTagName("select")){
    elements = document.getElementById(theForm).getElementsByTagName("select");
    for(i=0;i<elements.length;i++){
     elements.item(i).value="";
    }
   }
   
   if(document.getElementById(theForm).getElementsByTagName("textarea")){
    elements = document.getElementById(theForm).getElementsByTagName("textarea");
    for(i=0;i<elements.length;i++){
     	elements.item(i).value="";
    }
   }
   
   for(var ti=0;ti<inputtype.length;ti++){
    elements = document.getElementById(theForm).getElementsByTagName("input");
    
    for(var i=0;i<elements.length;i++){
     if(elements.item(i).type == inputtype[ti]){
      if (elements.item(i).type == "radio" || elements.item(i).type == "checkbox"){
       if (elements.item(i).checked==true){ 
       }
      }
      else if (elements.item(i).type == "hidden"){
     
       }
      
      }
      else{
		  if(elements.item(i).type !="button")
		       elements.item(i).value="";
      }
     }
    }
    
   }
  
  //***************************************** END BLANKING FORM DATA
 
function submitRequestWithForm(frm_action,frm_method,input_fields_value,input_fields_name){
	
}

function checkRegister(){
	var str="<img src='images/error_image.gif' border='0'>&nbsp;";
	var theFields=new Array("user_id","password","repassword","first_name","last_name");
	var theCaption=new Array("Email","Password","Confirm Password","First name","Last name");
	var return_flag=true;
	for(var i=0;i<5;i++){
		var thevalue=document.getElementById(theFields[i]).value;
		thevalue=rm_trim(thevalue);
		
		if(thevalue==''){
			str+="Please Enter "+theCaption[i];
			document.getElementById(theFields[i]+"td").innerHTML=str;
			for(var ii=0;ii<5;ii++){
				if(i!=ii)
					document.getElementById(theFields[ii]+"td").innerHTML="";					
			}
			document.getElementById(theFields[i]).focus();
			return false;
		}
		else if(i==0){
			if(!isEmail(thevalue)){
				str+="Please Enter Valid "+theCaption[i];
				document.getElementById(theFields[i]+"td").innerHTML=str;
				for(var ii=0;ii<5;ii++){
					if(i!=ii)
						document.getElementById(theFields[ii]+"td").innerHTML="";					
				}
				document.getElementById(theFields[i]).focus();
				return false;				
			}
		}
	}
	if(document.getElementById("password").value!=document.getElementById("repassword").value){
		str+=" Password is not same";
		document.getElementById("passwordtd").innerHTML=str;
		document.getElementById("password").focus();
		for(var ii=0;ii<5;ii++){
			if(theFields[ii]!="password")
				document.getElementById(theFields[ii]+"td").innerHTML="";					
		}
		return false;				
	}
	for(var ii=0;ii<5;ii++)
		document.getElementById(theFields[ii]+"td").innerHTML="";					

	return true;
}
	
function resetLoginDet(frm_id,url,divid,abspath,prog){
		if(checkRegister()){
			url+=getFormData(frm_id);
			getServerResponse(divid,url,abspath,prog)
		}
		else{
				return false;
		}
}

function qtyValidtion(qtyvalue)
{
	if(qtyvalue<0)
	{
		alert("Please enter Only Positve Value");
		return false;
	}
	return true;
}
function checkLogin(divid,loginid,loginpwd){
	//document.getElementById(pro_id).innerHTML = "<img src='images/loader.gif' border='0'>";
	var loginusername=escape(document.getElementById(loginid).value);
	var loginpassword=escape(document.getElementById(loginpwd).value);
	var url="AjaxHandler.php?query=userlogin&loginusername="+loginusername+"&loginpassword="+loginpassword;
	var ajaxRequest=getAjaxRequestObject();  
	ajaxRequest.onreadystatechange = function(){

		if(ajaxRequest.readyState == 4){
			var message=ajaxRequest.responseText.split("#@#");
			//alert(message);
			if(message[0]=="failure"){
				alert(message[1]);
				//document.getElementById(divid).innerHTML=message[1];
			}
			else if(message[0]=="success"){
				window.location.href="billing-shiping-info.html";
				
			}
			else{
				document.getElementById(divid).innerHTML="Error in server response";
			}
		}
	}
	var queryString =url+"&dt="+new Date().getTime();
	//alert(queryString);
	ajaxRequest.open("POST", queryString, true);
	ajaxRequest.send(null); 
}