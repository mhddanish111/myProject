// JavaScript Document
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


//*************************************************************************************************

function emailValidator(elem){
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if(elem.match(emailExp)){
		return true;
	}else{
		return false;
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
function checkForm(form)
{
	if(( document.getElementById("radiobuttong").checked == false )
    && ( document.getElementById("radiobuttonr").checked == false ))
	{
		alert("Please Choose Shiping Address Same ya Different");
		return false;
	}
	return true;
} 
function loginvalid()
{
	var thevalue=document.getElementById("login_id").value;
	var thevalue1=document.getElementById("login_password").value;
	if(thevalue=="")
	{
		alert("Please Enter Your login id(Email Id)");
		document.getElementById("login_id").focus("login_id");
		return false;
	}
    if(thevalue!="")
	{
		if(!emailValidator(thevalue))
		{
			alert("Invalid login id Format");
			document.getElementById("login_id").focus();
			return false;
		}
	}
	if(document.getElementById("login_password").value=="")
	{
		alert("Please Enter Your Password");
		document.getElementById("login_password").focus();
		return false;
	}
	return true;
}
function validateUpdate()
{
	var theFields=new Array("username","userlastname","useraddress","usercity","select2","province","select3","userphone","useremail");
    var theCaption=new Array("First Name","Last Name","Address","City","State","Province/ Zip Code","Country","Cellular Phone No.","Email");
	var mobile = "^[0-9]{7,15}$";
	for(var i=0;i<9;i++){
		var thevalue=document.getElementById(theFields[i]).value;
		//alert(thevalue);
		thevalue=rm_trim(thevalue);
		if(thevalue==''){
			alert("Please enter "+theCaption[i]);
			document.getElementById(theFields[i]).focus();
			return false;
	  	}
	  	else if(i==8)  {
			if(!emailValidator(thevalue)){
				 alert("Pleae Enter Valid Email");
				 document.getElementById(theFields[i]).value="";
				 document.getElementById(theFields[i]).focus();
				  return false;
			}
		}	
	 	/*else if (i==6) {
			if(!thevalue.match(mobile))
			{
				alert("Invalid Cellular Phone No.");
				document.getElementById(theFields[i]).focus();
				return false;
			}
		}*/
	}
	/*var thevalue=document.getElementById('telephone').value;
	thevalue=rm_trim(thevalue);
	if(thevalue!=''){
		if(isNaN(thevalue)){
		alert("Please enter Number only in TelePhone no. ");
			document.getElementById('telephone').focus();
			return false;
		}
	}*/
	return true;
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
