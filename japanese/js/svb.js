// JavaScript Document

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
////******************************
function loginValidation()
{
 	if(rm_trim(document.getElementById('txt_login_id').value==""))
	{
		alert("Please Enter UserName");
		document.getElementById('txt_login_id').focus();
		return false;
	}
	else if(document.getElementById('txt_login_pass').value=="")
	{
		alert("Please Enter Password");
		document.getElementById('txt_login_pass').focus();
		return false;
	}
	return true;
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

 function cmd_delete(){
	var x=confirm("do you want to delete this record");
	if(x)
		return true
	else 
		return false
 }
function ajaxUpdater(id,url,absolutepath) {
	//document.getElementById(id).style.display='';
	//document.getElementById(id).innerHTML="<img src='"+absolutepath+"images/loading.gif' border='0'>";
//	alert("id : "+id+" url : "+url);
    new Ajax.Updater(id,url,{asynchronous:true});  
} 
function ajaxUpdaterProgress(id,url,absolutepath) {
	//document.getElementById(id).style.display='';
	document.getElementById(id).innerHTML="<img src='"+absolutepath+"images/loading.gif' border='0'>";
	//alert("id : "+id+" url : "+url);
    new Ajax.Updater(id,url,{asynchronous:true});  
} 
//************* show driver for input************



function checkUserDetail()
{
var goodname;
var theFields=new Array("admin_id","oldpassword","password","repassword");
var theCaption=new Array("user name","old password","password","re password");
for(var i=0;i<4;i++){
	var thevalue=document.getElementById(theFields[i]).value;
	//alert(thevalue);
	thevalue=rm_trim(thevalue);
	if(thevalue==''){
		
		alert("Please enter "+theCaption[i]);
		document.getElementById(theFields[i]).focus();
		return false;
	}
}

	var p1=document.getElementById("password").value;
	var p2=document.getElementById("repassword").value;
	if(document.getElementById(theFields[2]).value != document.getElementById(theFields[3]).value){
		alert("Password not matched");
		document.getElementById(theFields[2]).focus();
		return false;
	}

	if((document.getElementById(theFields[2]).value).length < 6 || (document.getElementById(theFields[3]).value).length < 6){
		alert("password should be 6 charactor long")
		document.getElementById(theFields[2]).focus();
		return false;
	}
						
return true;		
}

function changesUserDetail(){
	if(checkUserDetail()){
document.getElementById("waitdiv").innerHTML+="<span class='style4'>Processing ... Please wait.</span>";
var url="AjaxHandler.php?query=changesuserdetail&admin_id="+document.getElementById("admin_id").value+"&oldpassword="+document.getElementById("oldpassword").value+"&password="+document.getElementById("password").value;
//alert(url);
ajaxUpdater("changeuserdetaildiv",url);
return true;
}
else{
return false;
}
}

function showShip(boxid){
   document.getElementById(boxid).style.visibility="visible";
   document.getElementById('backid').style.visibility="hidden";
   document.getElementById('continuuehideid').style.visibility="hidden";
}

function hideShip(boxid){
   document.getElementById(boxid).style.visibility="hidden";
   document.getElementById('backid').style.visibility="visible";
   document.getElementById('continuuehideid').style.visibility="visible";
}

//************************************* validating Reg form ************************
function validateRegForm(theForm,abspath){
	var different=document.getElementById('radiobutton3').checked;
	var FiledCount=11;
	if(different)
	{
		FiledCount=20;
	}
		
	var theFields=new Array("username","userlastname","useraddress","usercity","select2","province","select3","userphone","useremail","userpassword","reuserpassword","shipusername","shipuserlastname","shipuseraddress","shipusercity","shipselect2","shipprovince","shipselect3","shipuserphone","shipuseremail");
    var theCaption=new Array("First Name","Last Name","Address","City","State","Province/Zip Code","Country","Cellular Phone","Email","Password","Confirm Password","First Name","Last Name","Address","City","State","Province/Zip Code","Country","Phone","Email Address");
	var mobile = "^[0-9]{7,15}$";
	for(var i=0;i<FiledCount;i++){
		var thevalue=document.getElementById(theFields[i]).value;
		//alert(thevalue);
		thevalue=rm_trim(thevalue);
		if(thevalue==''){
			alert("Please enter "+theCaption[i]);
			document.getElementById(theFields[i]).focus();
			return false;
	  	}
		/*else if ((i==6) ||(i==16)){
			if(!thevalue.match(mobile))
			{
				alert("InValid Cellular Phone No.");
				document.getElementById(theFields[i]).focus();
				return false;
			}
		}*/
	  	else if((i==8) || (i==19)) {
			if(!emailValidator(thevalue)){
				 alert("Pleae Enter Valid Email");
				 document.getElementById(theFields[i]).value="";
				 document.getElementById(theFields[i]).focus();
				  return false;
			}
		}	
	 	
		else if(i==10){
			if(document.getElementById(theFields[9]).value != document.getElementById(theFields[10]).value){
			alert("Passwords Not Matched");
		    document.getElementById(theFields[10]).value="";
			document.getElementById(theFields[10]).focus();
			return false;
		}
		if((document.getElementById(theFields[9]).value).length < 6 || (document.getElementById(theFields[10]).value).length < 6){
			alert("Password Must Be 6 Characters Long");
			document.getElementById(theFields[9]).value="";
			document.getElementById(theFields[10]).value="";
			document.getElementById(theFields[9]).focus();
			return false;
		 }
	  }
	}// loop
	/*var thevalue=document.getElementById('telephone').value;
	var thevalue1=document.getElementById('shipusertelephone').value;
	thevalue1=rm_trim(thevalue1);
	thevalue=rm_trim(thevalue);
	if(thevalue!=''){
		if(isNaN(thevalue)){
		alert("Please enter Number only in TelePhone no. ");
			document.getElementById('telephone').focus();
			return false;
		}
	}
	if(thevalue1!=''){
		if(isNaN(thevalue1)){
		alert("Please enter Number only in TelePhone no. ");
			document.getElementById('shipusertelephone').focus();
			return false;
		}
	}*/
	//************ ajax
	var url=abspath+"AjaxHandler.php?query=custregistration";
	url+=getFormData('frmreg');
	getServerRes("probar",url,abspath);
	//alert(url);
}
//************************************* validating Reg form new user without radio button ************************
function validateRegForm2(theForm,abspath){
	var FiledCount=11;
			
	var theFields=new Array("username","userlastname","useraddress","usercity","select2","province","select3","userphone","useremail","userpassword","reuserpassword");
    var theCaption=new Array("First Name","Last Name","Address","City","State","Province/Zip Code","Country","Cellular Phone No.","Email","Password","Confirm Password");
	var mobile = "^[0-9]{7,15}$";
	for(var i=0;i<FiledCount;i++){
		var thevalue=document.getElementById(theFields[i]).value;
		//alert(thevalue);
		thevalue=rm_trim(thevalue);
		if(thevalue==''){
			alert("Please enter "+theCaption[i]);
			document.getElementById(theFields[i]).focus();
			return false;
	  	}
	  	else if(i==8) {
			if(!emailValidator(thevalue)){
				 alert("Pleae Enter Valid Email");
				 document.getElementById(theFields[i]).value="";
				 document.getElementById(theFields[i]).focus();
				  return false;
			}
		}	
	 	/*else if (i==6){
			if(!thevalue.match(mobile))
			{
				alert("Invalid  Cellular Phone No.");
				document.getElementById(theFields[i]).focus();
				return false;
			}
		}*/
		else if(i==10){
			if(document.getElementById(theFields[9]).value != document.getElementById(theFields[10]).value){
			alert("Passwords Not Matched");
		    document.getElementById(theFields[10]).value="";
			document.getElementById(theFields[10]).focus();
			return false;
		}
		if((document.getElementById(theFields[9]).value).length < 6 || (document.getElementById(theFields[10]).value).length < 6){
			alert("Password Must Be 6 Characters Long");
			document.getElementById(theFields[9]).value="";
			document.getElementById(theFields[10]).value="";
			document.getElementById(theFields[9]).focus();
			return false;
		 }
	  }
	}// loop
	/*var thevalue=document.getElementById('telephone').value;
	thevalue=rm_trim(thevalue);
	if(thevalue!=''){
		if(isNaN(thevalue)){
		alert("Please enter Number only in TelePhone no. ");
			document.getElementById('telephone').focus();
			return false;
		}
	}*/
	//************ ajax
	var url=abspath+"AjaxHandler.php?query=custregistration&radiobutton1=shipingsame";
	url+=getFormData('frmreg');
	getServerRes("probar",url,abspath);
	//alert(url);
}
//************************************* validating Reg form ************************
function validateRegForm1(theForm,abspath){
	var different=document.getElementById('radiobutton3').checked;
	//alert(document.getElementById('radiobutton3').checked);
	var FiledCount=9;
	if(different)
	{
		FiledCount=18;
	}
	var theFields=new Array("username","userlastname","useraddress","usercity","select2","province","select3","userphone","useremail","shipusername","shipuserlastanme","shipuseraddress","shipusercity","shipselect2","shipuserprovince","shipselect3","shipuserphone","shipuseremail");
    var theCaption=new Array("First Name","Last Name","Address","City","State","Province/Zip Code","Country","Cellular Phone","Email","Ship First Name","Ship Last Name"," Ship Address"," Ship City","Ship State","Ship Province/ Zip Codde","Ship Country","Ship Phone","Ship Email");
	var mobile = "^[0-9]{7,15}$";
	for(var i=0;i<FiledCount;i++){
		var thevalue=document.getElementById(theFields[i]).value;
		//alert(thevalue);
		thevalue=rm_trim(thevalue);
		if(thevalue==''){
			alert("Please enter "+theCaption[i]);
			document.getElementById(theFields[i]).focus();
			return false;
	  	}
		/*else if (i==6 || i==14){
			if(!thevalue.match(mobile))
			{
				alert("Invalid Cellular Phone No.");
				document.getElementById(theFields[i]).focus();
				return false;
			}
		}*/
	  	else if (i==8 || i==17){
			if(!emailValidator(thevalue)){
				 alert("Pleae Enter Valid Email");
				 document.getElementById(theFields[i]).value="";
				 document.getElementById(theFields[i]).focus();
				  return false;
			}
		}	
	 	
	}// loop
	/*var thevalue=document.getElementById('telephone').value;
	var thevalue1=document.getElementById('shipusertelephone').value;
	thevalue1=rm_trim(thevalue1);
	thevalue=rm_trim(thevalue);
	if(thevalue!=''){
		if(isNaN(thevalue)){
		alert("Please enter Number only in TelePhone no. ");
			document.getElementById('telephone').focus();
			return false;
		}
	}
	if(thevalue1!=''){
		if(isNaN(thevalue1)){
		alert("Please enter Number only in TelePhone no. ");
			document.getElementById('shipusertelephone').focus();
			return false;
		}
	}*/
	//************ ajax
	if(( document.getElementById("radiobutton2").checked == false )
    && ( document.getElementById("radiobutton3").checked == false ))
	{
		alert("Please Choose Shiping Address Same ya Different");
		return false;
	}
	
	//var url=abspath+"AjaxHandler.php?query=custregistration";
	//url+=getFormData('frmreg');
	//getServerRes("probar",url,abspath)
	return true;
}
function getServerRes(divid,url,abspath){
	document.getElementById(divid).innerHTML = "<img src='"+abspath+"images/loader.gif' border='0'>";
	
	var ajaxRequest=getAjaxRequestObject();  // The variable that makes Ajax possible!
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var message=ajaxRequest.responseText.split("#@#");
		//alert(message);
			if(message[0]=="failure"){
				alert(message[1]);
				document.getElementById(divid).innerHTML="";
			}
			else if(message[0]=="success"){
				window.location.href=message[1];		
			}
			else{
				alert("Error in server response : "+message);
				document.getElementById(divid).innerHTML="";
			}
		}
	}
	var queryString =url+"&dt="+new Date().getTime();
	//alert(queryString);
	ajaxRequest.open("POST", queryString, true);
	ajaxRequest.send(null); 
	return true;
}
function getServerResponse1(divid,url,abspath,pbar){
	if(pbar) { document.getElementById(divid).innerHTML = "<img src='"+abspath+"images/loader.gif' border='0'>"; }
	
	var ajaxRequest=getAjaxRequestObject();  // The variable that makes Ajax possible!
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var message=ajaxRequest.responseText.split("#@#");
		//alert(message[1]);
			if(message[0]=="failure"){
				//alert(message[1]);
				document.getElementById(divid).innerHTML="";
			}
			else if(message[0]=="success"){
				document.getElementById(divid).innerHTML=message[1];	
			}
			else{
				alert("Error in server response : "+message);
				document.getElementById(divid).innerHTML="";
			}
		}
	}
	var queryString =abspath+""+url+"&dt="+new Date().getTime();
	//alert(queryString);
	ajaxRequest.open("POST", queryString, true);
	ajaxRequest.send(null); 
	return true;
}
//******************************************* password change *********************************
function changePassword(theForm){
		
	var theFields=new Array("oldpassword","newpassword","repassword");
	var theCaption=new Array("Old Password","New Password","Re-Password");

for(var i=0;i<3;i++){
	var thevalue=document.getElementById(theFields[i]).value;
	thevalue=rm_trim(thevalue);
	if(thevalue==''){
		alert("Please Enter "+theCaption[i]);
		document.getElementById(theFields[i]).focus();
		return false;
	}
 }
	if(document.getElementById(theFields[1]).value != document.getElementById(theFields[2]).value){
		alert("Passwords Not Matched");
		document.getElementById(theFields[2]).value="";
		document.getElementById(theFields[2]).focus();
		return false;
	}

	if((document.getElementById(theFields[1]).value).length < 6 || (document.getElementById(theFields[2]).value).length < 6){
		alert("Password Must Be 6 Characters Long");
		document.getElementById(theFields[1]).value="";
		document.getElementById(theFields[2]).value="";
		document.getElementById(theFields[1]).focus();
		return false;
	}
return true;	
}
//******************************************************
function refreshCaptcha(abspath){ 
document.getElementById('refcaptimg').src=abspath+"CaptchaSecurityImages.php?t=" + new Date().getTime(); 
}

///***************************************** Function for foegot Password ***********************
function forgotPassword(divid,url,mailid,type,fid){
	  var emailvalue=document.getElementById(mailid).value;
	  
			  emailvalue=rm_trim(emailvalue);
			  if(emailvalue==''){
			  alert("Please Enter Email");
			  document.getElementById(mailid).focus();
			  return false;
			  }
			 else if(!emailValidator(emailvalue)){
					alert("Invalid Email ");
					document.getElementById(divid).innerHTML="";
					document.getElementById(mailid).value="";
					ocument.getElementById(mailid).focus();
						return false;
					   }
					  // alert(url);
			url=url+"&email="+emailvalue;
			getServerResponse(divid,url,"",true)
}

//*************************************** Validatiog ship bill form **************************
function validateshipbillForm(theForm){
	//var notrequired=document.getElementById("notrequired").checked;

	var FiledCount=16;
	//if(notrequired)
		//FiledCount=8;
	var theFields=new Array("BillCustName","BillCustEmail","BillCustPhone","BillCustAddress","BillCustCity","BillCustState","BillCustZIPCode","BillCustCountry","ShipCustName","ShipCustEmail","ShipCustPhone","ShipCustAddress","ShipCustCity","ShipCustState","ShipCustZIPCode","ShipCustCountry");
    var theCaption=new Array("Bill Name","Bill Email","Bill Phone","Bill Address","Bill City","Bill State","Bill ZIPCode","Bill Country","Ship Name","Ship Email","Ship Phone","Ship Address","Ship City","Ship State","Ship ZIPCode","Ship Country");
	
	for(var i=0;i<FiledCount;i++){
	var thevalue=document.getElementById(theFields[i]).value;
	//alert(thevalue);
	thevalue=rm_trim(thevalue);
	if(thevalue==''){
		alert("Please enter "+theCaption[i]);
		document.getElementById(theFields[i]).focus();
		return false;
	  }
	 else if(i==1 || i==9){
			if(!emailValidator(thevalue)){
				 alert("Pleae Enter Valid Email");
				 document.getElementById(theFields[i]).value="";
				 document.getElementById(theFields[i]).focus();
				  return false;
			}
		} 
	}// loop
}
//*********************************************************************************************
function emailValidator(elem){
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if(elem.match(emailExp)){
		return true;
	}else{
		return false;
	}
}

function getFormData(theForm){
	//alert(theForm.name);
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
     // alert("hidden : "+elements.item(i).name+" "+elements.item(i).value);
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
  
  function ShipBillSame(chkbox){
		var ShipArray=new Array("ShipCustName","ShipCustEmail","ShipCustPhone","ShipCustAddress","ShipCustCity","ShipCustState","ShipCustZIPCode","ShipCustCountry");
		var BillArray=new Array("BillCustName","BillCustEmail","BillCustPhone","BillCustAddress","BillCustCity","BillCustState","BillCustZIPCode","BillCustCountry");
		
		copyText(BillArray,ShipArray,chkbox.checked);
	  	
  }
  
  function copyText(Array1,Array2,copyFlag) {
		if(copyFlag) {
			for(var i=0;i<Array1.length;i++){

				if(document.getElementById(Array1[i]))
					document.getElementById(Array2[i]).value=document.getElementById(Array1[i]).value;
			}
  		}
		else{
			for(var i=0;i<Array2.length;i++){
				if(document.getElementById(Array1[i]))
					document.getElementById(Array2[i]).value="";
			}	
		}
	}
	
function getServerResponseCoupon(divid,url,abspath,prog){
	var thevalue=document.getElementById('couponid').value;
	thevalue=rm_trim(thevalue);
	if(thevalue=="")
	{
		alert("Please Enter the Coupon Code");
		document.getElementById('couponid').focus();
		return false;
	}
	var ajaxRequest=getAjaxRequestObject();  // The variable that makes Ajax possible!
	ajaxRequest.onreadystatechange = function()
	{
		if(ajaxRequest.readyState == 4)
		{
			var message=ajaxRequest.responseText.split("#@#");
			//alert(message);
			if(message[0]=="success")
			{
				document.getElementById('total-price3').style.display="none";
			document.getElementById(divid).innerHTML=message[1];
			document.getElementById('showcoudetact').innerHTML=message[2];
			}
			else if(message[0]=="failure")
			{
				document.getElementById('total-price3').style.display="none";
			document.getElementById(divid).innerHTML=message[1];
			document.getElementById('showcoudetact').innerHTML=message[2];
			}
			
		}
	}
	var queryString =abspath+""+url+"&dt="+new Date().getTime();
	//alert(queryString);
	ajaxRequest.open("POST", queryString, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Connection", "close");
	
	ajaxRequest.send(null); 
	//********
	
	return true;
}
function searchValidation(path)
{
	if(document.getElementById('textfield').value=="")
	{
		alert("Please Enter Search Text in Search Box");
		document.getElementById('textfield').focus();
		return false;
		
	}
	var textfield=document.getElementById('textfield').value;
	var selectcat=document.getElementById('selectcat').value;
	var selectsub='All-Subcategory';
	var selectsortby='BestMatch';
	var searchperpage='12';
	var page='1';
	var redircturl=''+path+''+textfield+'/'+selectcat+'/'+selectsub+'/'+selectsortby+'/'+searchperpage+'/'+page+'.html';
	window.location.href=redircturl;
	
}
function ShowPopupSearch() {
        document.getElementById('Layer1').style.display = 'block';
        //document.getElementById('TopSearchIframe').src = "TopSearchFrame.aspx"
    }
function HidePopupSearch() {
        document.getElementById('Layer1').style.display = 'none';
    }
function setSearchPage(page){
	document.getElementById('page').value=page;	
	document.forms["frmsearch"].submit();
}
function pageSubmit()
{
	document.forms["frmsearch"].submit();
}
function isEnterSearch(e,path){
	
var unicode=e.charCode? e.charCode : e.keyCode
if(unicode==13){ searchValidation(path);}

}
