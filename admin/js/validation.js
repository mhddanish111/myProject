// JavaScript Document
//************ Remove the unwanted space **************//
function rm_trim(inputString)
{
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
//****************** validation for the when user Login**************//
function validate()
{
	if(rm_trim(document.getElementById('username').value)=='')
	{
		alert('Please enter Username');
		document.getElementById('username').focus();
		return false;
	}
	if(document.getElementById('password').value=='')
	{
		alert('Please enter Password');
		document.getElementById('password').focus();
		return false;
	}
	return true;
}

// /**************** Validation for the Change Password *********
function passValidate()
{
	if(document.getElementById('oldpass').value=="")
	{
		alert('Please enter Old Password');
		document.getElementById('oldpass').focus();
		return false;
	}
	if(document.getElementById('newpass').value=="")
	{
		alert('Please enter New Password');
		document.getElementById('newpass').focus();
		return false;
	}
	if(document.getElementById('conpass').value=="")
	{
		alert('Please enter Confirm Password');
		document.getElementById('conpass').focus();
		return false;
	}
	if(document.getElementById('conpass').value!=document.getElementById('newpass').value)
	{
		alert('Please correct Confirm Password');
		document.getElementById('conpass').focus();
		return false;
	}
return true;
}

//*************************************************************************************************

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
function checkForInt(evt) {
var charCode = ( evt.which ) ? evt.which : event.keyCode;
//alert(charCode);
return( charCode >= 48 && charCode <= 57 );
}

function checkForNum(evt) {
var charCode = ( evt.which ) ? evt.which : event.keyCode;
//alert(charCode);
return( ( charCode >= 48 && charCode <= 57 ) || (charCode >= 65 && charCode <= 90) || ( charCode >=97 && charCode <=122) || charCode == 32 || charCode == 45);
}
function selectFile(str)
{	
	if (str=="")
  	{		
 		document.getElementById("upload_all_file").innerHTML="";
		return ;
  	}
	var ajaxRequest=getAjaxRequestObject(); 
	ajaxRequest.onreadystatechange = function()
	{
		if(ajaxRequest.readyState == 4 && ajaxRequest.status==200)
		{	
			<!--alert(ajaxRequest.responseText);-->
			document.getElementById('upload_all_file').innerHTML=ajaxRequest.responseText;
		}
		
	}
	ajaxRequest.open("get", "ajax-ov.php?query=addgallery&id="+str, true);
	ajaxRequest.send(null);
}

function validateImage(Img)
{
	if((Img.value.toLowerCase().lastIndexOf(".jpg")==-1)
	&& (Img.value.toLowerCase().lastIndexOf(".gif")==-1)
	&& (Img.value.toLowerCase().lastIndexOf(".png")==-1)
	&& (Img.value.toLowerCase().lastIndexOf(".pjpeg")==-1))
	{
		return false;
	}
	else
	  return true;
}
function emailValidator(elem){
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if(elem.match(emailExp)){
		return true;
	}else{
		return false;
	}
}
function checkBox()
{
	var chks = document.getElementsByName('box[]');
	var hasChecked = false;
	for (var i = 0; i < chks.length; i++)
	{
		if (chks[i].checked)
		{
			hasChecked = true;
			break;
		}
	}
	if (hasChecked == false)
	{
		alert("Please tick any checkbox Value");
		return false;
	}
	return true;
}
function seleciona()
{
	if (document.delteform.master.checked==true)
	for (i=0; i<document.delteform.elements.length;i++)
	{
		document.delteform.elements[i].checked=true
	}
	if (document.delteform.master.checked==false)
	for (i=0; i<document.delteform.elements.length;i++)
	{
		document.delteform.elements[i].checked=false
	}
}
///////////////////////////////////// Function for Add Category Type ///////////////////////////

function addcat()
{
	var thevalue=document.getElementById("textfield22").value;
	thevalue=rm_trim(thevalue);
	if(thevalue=='')
	{
		alert("Please Enter Category Name");
		document.getElementById("textfield22").focus();
		return false;
	}
	else if(rm_trim(document.getElementById("jatextfield22").value)=='')
	{
		alert("Please Enter Japanese Category Name");
		document.getElementById("jatextfield22").focus();
		return false;
	}
	return true;
}
function addcoupon()
{
	var theFields=new Array("couponcode","textfield22","message","amount");
	var theCaption=new Array("Coupon Code","Name","Message","Amount");
	for(var i=0;i<4;i++)
	{
		var thevalue=document.getElementById(theFields[i]).value;
		thevalue=rm_trim(thevalue);
		if(thevalue=='')
		{
			alert("Please Enter Coupan "+theCaption[i]);
			document.getElementById(theFields[i]).focus();
			return false;
		}
		if(i==3)
		{
			if(isNaN(thevalue))
			{	
				alert("Please Enter Amount only in Number");
				document.getElementById(theFields[i]).focus();
				return false;
			}
		}
	}
	return true;
}
function validateForm(frm){
	var theFields=new Array("couponname","news_date");
	var theCaption=new Array("Name","Valid Date");
	for(var i=0;i<2;i++)
	{
		var thevalue=document.getElementById(theFields[i]).value;
		thevalue=rm_trim(thevalue);
		if(thevalue=='')
		{
			alert("Please Enter Coupan "+theCaption[i]);
			document.getElementById(theFields[i]).focus();
			return false;
		}
	}
	if(document.getElementById('hiddensendingchoice').value=="fromdatabase"){
		if(document.getElementById('hiddensendingoption').value=="userwise"){
			if(frm.subscriberemail.value.search(/\S/)==-1){
				alert("Please select at leaset on receiver.");
				frm.subscriberemail.focus();
				return false;
			}
		}
	}
	else{
		if(frm.useremaiid.value==''){
				alert("Please enter leaset on receiver.");
				frm.useremaiid.focus();
				return false;
		}
	}
	return true;
}
function validateFormByUser(frm)
{
	var theFields=new Array("couponname","news_date");
	var theCaption=new Array("Coupon Name","Coupon Valid Date");
	for(var i=0;i<2;i++)
	{
		var thevalue=document.getElementById(theFields[i]).value;
		thevalue=rm_trim(thevalue);
		if(thevalue=='')
		{
			alert("Please Enter  "+theCaption[i]);
			document.getElementById(theFields[i]).focus();
			return false;
		}
	}
	var femail=document.getElementById("useremaiid").value;
	//alert(femail);
	var femail_array=femail.split(",") ;
	//alert(femail_array.length);
	for(var ii=0;ii<femail_array.length;ii++){
		var thevalue=femail_array[ii];
     	//alert(thevalue);
       thevalue=rm_trim(thevalue);
       if(thevalue==''){
       	alert("Empty Not Allowed")
        document.getElementById("useremaiid").focus();
        return false;
       }
       goodemail=emailValidator(thevalue);
       //alert(goodemail);
       if(!goodemail){
       	alert("Friend "+(ii+1)+" email is  invalid");
        document.getElementById("useremaiid").focus();
        return false;
       }
       //}
	}
	return true;
}
function addmedical()
{
	var thevalue=document.getElementById("des_medi").value;
	thevalue=rm_trim(thevalue);
	if(thevalue=='')
	{
		alert("Please Enter Title");
		document.getElementById("des_medi").focus();
		return false;
	}
	else if(rm_trim(document.getElementById("link_detail").value)=="")
	{
		alert("Please Enter Medical Show Link");
		document.getElementById("link_detail").focus();
		return false;
	}
	return true;
}
function getServerResponse(divid,url,abspath,prog){
	//alert(url);
	document.getElementById(divid).style.display="block";
	if(prog)
		document.getElementById(divid).innerHTML = "<img src='images/loading.gif' border='0'>";
	
	var ajaxRequest=getAjaxRequestObject();  // The variable that makes Ajax possible!
	ajaxRequest.onreadystatechange = function()
	{
		if(ajaxRequest.readyState == 4)
		{
			var message=ajaxRequest.responseText;
			//alert(message);
			//prompt('ajax response ',message);
			document.getElementById(divid).innerHTML=message;
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
function getServerResponsePro(divid,url,abspath,prog){
	//alert(url);
	var ajaxRequest=getAjaxRequestObject();  // The variable that makes Ajax possible!
	ajaxRequest.onreadystatechange = function()
	{
		if(ajaxRequest.readyState == 4)
		{
			var message=ajaxRequest.responseText;
			//alert(message);
			//document.getElementById(divid).style.display = "none";
			document.getElementById(divid).innerHTML=message;
		}
	}
	var queryString =abspath+""+url+"&dt="+new Date().getTime();
	//alert(queryString);
	ajaxRequest.open("POST", queryString, true);
	
	ajaxRequest.send(null); 
	//********
	
	return true;
}
function addSub()
{
	var theFields=new Array("selectcat","textfield22","jatextfield22","sub_image");
	var theCaption=new Array("Category","Sub Category","Sub Category in Japanese","Subcategory Image");
	for(var i=0;i<4;i++)
	{
		var thevalue=document.getElementById(theFields[i]).value;
		thevalue=rm_trim(thevalue);
		if(thevalue=='')
		{
			alert("Please Enter Product "+theCaption[i]);
			document.getElementById(theFields[i]).focus();
			return false;
		}
		if(i==3)
		{
			if(thevalue!="")
			{
				var Img=document.getElementById(theFields[i]);
				if(!validateImage(Img))
				{
					alert("Please Select Valid File Format (*.jpg,*.gif,*.png,*.pjpeg)");
					document.getElementById(theFields[i]).focus();
					return false;
				}
			}
		}
	}
	return true;
}
function editSubCat()
{
	var theFields=new Array("selectcat","textfield22","jatextfield22");
	var theCaption=new Array("Category","Sub Category","Sub Category in Japanese");
	for(var i=0;i<2;i++)
	{
		var thevalue=document.getElementById(theFields[i]).value;
		thevalue=rm_trim(thevalue);
		if(thevalue=='')
		{
			alert("Please Enter Product "+theCaption[i]);
			document.getElementById(theFields[i]).focus();
			return false;
		}
	}
	if(document.getElementById('sub_image').value!="")
	{
		var Img=document.getElementById('sub_image');
		if(!validateImage(Img))
		{
			alert("Please Select Valid File Format (*.jpg,*.gif,*.png,*.pjpeg)");
			document.getElementById(theFields[i]).focus();
			return false;
		}
	}
	return true;
}
function delProductImage(divid,url,abspath,prog){
	// alert(url);
	 var x=confirm("Are you sure you want to delete this image ?");
        if(x){
            getServerResponsePro(divid,url,abspath,prog)
		}
        else {
            return false
		}
}

function homeProductImage(divid,url,abspath,prog){
	// alert(url);
	 var x=confirm("Are you sure you want to show first this image ?");
        if(x){
            getServerResponsePro(divid,url,abspath,prog)
		}
        else {
            return false
		}
}
//************ upload image **********
function uploadImage(theField,id,callfrom)
{
	//alert(callfrom);
	var ajaxRequest=getAjaxRequestObject();  // The variable that makes Ajax possible!
	ajaxRequest.onreadystatechange = function()
	{
		if(ajaxRequest.readyState == 4)
		{
			alert("resposne : "+ajaxRequest.responseText);
			document.getElementById(id).innerHTML = ajaxRequest.responseText;
		}
	}
	
	var queryString =callfrom;
    alert(queryString);
	ajaxRequest.open("POST", queryString, true);
	var params=getFormData(theField);//"&FilePath="+theField.value+"&dt="+new Date().getTime()
	alert(params);
	//alert(params.length);
	 ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	 ajaxRequest.setRequestHeader("Content-length", params.length);
	 ajaxRequest.setRequestHeader("Connection", "close");
	 ajaxRequest.send(params);
	
	//ajaxRequest.send(null); 
	//**********
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
  
   
  // var u=urlData.split("&");
 	
  // prompt("url : ",urlData); 
   //return urlData+"&professionFeesReq="+professionFeesReq;
   return(urlData);

  }
/////////////////////// Add Product  Validation //

function addProduct()
{
	
	var theFields=new Array("selectcat","selectsub","title","gendescription","gencondiotion","sub_image","shipchargeint","shipchargedom");
	var theCaption=new Array("Product Category"," Product Sub Category"," Product Title","Product Description","Product Conditon","Product Image","International Shiping Charge ","Domestic Shiping Charge ");
	for(var i=0;i<8;i++)
	{
		var thevalue=document.getElementById(theFields[i]).value;
		thevalue=rm_trim(thevalue);
		if(thevalue=='')
		{
			alert("Please Enter  "+theCaption[i]);
			document.getElementById(theFields[i]).focus();
			return false;
		}
		if(i==5)
		{
			if(thevalue!="")
			{
				var Img=document.getElementById(theFields[i]);
				if(!validateImage(Img))
				{
					alert("Please Select Valid File Format (*.jpg,*.gif,*.png,*.pjpeg)");
					document.getElementById(theFields[i]).focus();
					return false;
				}
			}
		}
		if(i==6)
		{
			if(thevalue!="")
			{
				if(isNaN(thevalue))
				{
					alert("Please Enter International Shiping charge in Numeric value only");
					document.getElementById(theFields[i]).focus();
					return false;
				}
			}
		}
		if(i==7)
		{
			if(thevalue!="")
			{
				if(isNaN(thevalue))
				{
					alert("Please Enter Domestic Shiping charge in Numeric value only");
					document.getElementById(theFields[i]).focus();
					return false;
				}
			}
		}
	}
	var conprice = document.getElementById('genprice').value;
	var conprice = rm_trim(conprice);
	if(conprice!=" ")
	{
		if(isNaN(conprice))
		{
			alert("Please Enter Product price in Numeric value only");
			document.getElementById('genprice').focus();
			return false;
		}
	}
	return true;
}
function editProduct()
{
	var theFields=new Array("selectcat","selectsub","title","gendescription","shipchargeint","shipchargedom");
	var theCaption=new Array("Product Category"," Product Sub Category"," Product Title","Product Description","International Shiping Charge ","Domestic Shiping Charge ");
	for(var i=0;i<6;i++)
	{
		var thevalue=document.getElementById(theFields[i]).value;
		thevalue=rm_trim(thevalue);
		if(thevalue=='')
		{
			alert("Please Enter  "+theCaption[i]);
			document.getElementById(theFields[i]).focus();
			return false;
		}
		if(i==4)
		{
			if(thevalue!="")
			{
				if(isNaN(thevalue))
				{
					alert("Please Enter International Shiping charge in Numeric value only");
					document.getElementById(theFields[i]).focus();
					return false;
				}
			}
		}
		if(i==5)
		{
			if(thevalue!="")
			{
				if(isNaN(thevalue))
				{
					alert("Please Enter Domestic Shiping charge in Numeric value only");
					document.getElementById(theFields[i]).focus();
					return false;
				}
			}
		}
	}
	if(document.getElementById('sub_image').value!="")
	{
		var Img=document.getElementById('sub_image');
		if(!validateImage(Img))
		{
			alert("Please Select Valid File Format (*.jpg,*.gif,*.png,*.pjpeg)");
			document.getElementById('sub_image').focus();
			return false;
		}
	}
	
	var conprice = document.getElementById('genprice').value;
	var conprice = rm_trim(conprice);
	if(conprice!=" ")
	{
		if(isNaN(conprice))
		{
			alert("Please Enter Product price in Numeric value only");
			document.getElementById('genprice').focus();
			return false;
		}
	}
	return true;
}
function addGallery()
{
	var thevalue=document.getElementById("glimage").value;
	thevalue=rm_trim(thevalue);
	if(thevalue=='')
	{
		alert("Please Choose Image");
		document.getElementById("glimage").focus();
		return false;
	}
	else if(thevalue!="")
	{
		var Img=document.getElementById('glimage');
		if(!validateImage(Img))
		{
			alert("Please Select Valid File Format (*.jpg,*.gif,*.png,*.pjpeg)");
			document.getElementById('glimage').focus();
			return false;
		}
	}
	return true;
}
function addMoreProduct(){
	var divobj = document.getElementById('moreproducttd');
	var iteration=document.getElementById('itemecount').value;

	var order_item=new Array();
	var order_value=new Array();
	var jaorder_item=new Array();
	var jaorder_value=new Array();
	//var order_qty=new Array();
	//var order_total_value=new Array();
		for(var ii=0;ii<=Math.round(iteration);ii++){
			order_item[ii]=document.getElementById('order_item_'+ii).value;
			order_value[ii]=document.getElementById('order_value_'+ii).value;
			jaorder_item[ii]=document.getElementById('jaorder_item_'+ii).value;
			jaorder_value[ii]=document.getElementById('jaorder_value_'+ii).value;
			//order_qty[ii]=document.getElementById('order_qty_'+ii).value;
			//order_total_value[ii]=document.getElementById('order_total_value_'+ii).value;
		}
		iteration=(Math.round(iteration)+1)	
		var newRow='<div style="padding-bottom:10px; overflow:auto;"><div style="float:left; width:25%;"><input name="order_item_'+iteration+'" id="order_item_'+iteration+'" type="text" class="inp22" value="" /></div><div style="float:left; width:25%;"><input name="order_value_'+iteration+'" id="order_value_'+iteration+'" type="text" class="inp22" /></div><div style="float:left; width:25%;"><input name="jaorder_item_'+iteration+'" id="jaorder_item_'+iteration+'" type="text" class="inp22" value="" /></div><div style="float:left; width:25%;"><input name="jaorder_value_'+iteration+'" id="jaorder_value_'+iteration+'" type="text" class="inp22" /></div></div></div>';
	divobj.innerHTML+=newRow;
	document.getElementById('itemecount').value=iteration;
	
	for(var i=0;i<=(Math.round(iteration)-1);i++){
		document.getElementById('order_item_'+i).value=order_item[i];
		document.getElementById('order_value_'+i).value=order_value[i];
		document.getElementById('jaorder_item_'+i).value=jaorder_item[i];
		document.getElementById('jaorder_value_'+i).value=jaorder_value[i];
		//document.getElementById('order_qty_'+i).value=order_qty[i];
		//document.getElementById('order_total_value_'+i).value=order_total_value[i];
	}
	
}

function getTotal(){
	var iteration=document.getElementById('itemecount').value;
//	var order_item=0;
	var order_value=0;
	var order_qty=0;
	var order_total_value=0;
	var total_value=0;
	
	for(var i=0;i<=Math.round(iteration);i++){
	//	order_item=Math.round(document.getElementById('order_item_'+i).value);
		if(IsNumeric(document.getElementById('order_value_'+i).value)){
			order_value=Math.round(document.getElementById('order_value_'+i).value);	
		}
		else{
			order_value=0;
			document.getElementById('order_value_'+i).value=0;	
		}
		
		if(IsNumeric(document.getElementById('order_qty_'+i).value)){
			order_qty=Math.round(document.getElementById('order_qty_'+i).value);	
		}
		else{
			order_qty=0;
			document.getElementById('order_qty_'+i).value=0;	
		}
		
		order_total_value=(order_qty * order_value);
		document.getElementById('order_total_value_'+i).value=order_total_value;
		
		total_value+=order_total_value;
	}
	document.getElementById('total_value').value=total_value;
}
function keywordSearch()
{
	if(rm_trim(document.getElementById('keywordsearch').value==""))
	{
		alert("PLease enter Search text in Search Box");
		document.getElementById('keywordsearch').focus();
		return false;
	}
}
function numbersonly(e){
var unicode=e.charCode? e.charCode : e.keyCode
//alert(unicode);
if (unicode!=8 && unicode!=37 && unicode!=39 && unicode!=46 && unicode!=9){ //if the key isn't the backspace key (which we should allow)
if (unicode<48||unicode>57) //if not a number
return false //disable key press
}
}
/*function showShip(boxid){
   document.getElementById(boxid).style.visibility="visible";
   document.getElementById('showalluser').style.visibility="hidden";
}

function hideShip(boxid){
   document.getElementById(boxid).style.visibility="hidden";
   document.getElementById('showalluser').style.visibility="visible";
}*/
	
