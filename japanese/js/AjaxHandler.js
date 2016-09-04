function getAjaxRequestObject(){
	var ajaxRequest;
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
		return ajaxRequest;
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
			return ajaxRequest;
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
				return ajaxRequest;
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
}

function getServerResponse(divid,url,abspath,prog){
	//alert(url);
	document.getElementById(divid).style.display="block";
	if(prog)
		document.getElementById(divid).innerHTML = "<img src='"+abspath+"images/loader.gif' border='0'>";
	
	var ajaxRequest=getAjaxRequestObject();  // The variable that makes Ajax possible!
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var message=ajaxRequest.responseText.split("#@#");
			//alert(message);
			//prompt('ajax response ',message);
			if(message[0]=="failure"){
				alert("Error in server response");
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
	
	var queryString =url+"&dt="+new Date().getTime();
	//alert(queryString);
	ajaxRequest.open("POST", queryString, true);
	ajaxRequest.send(null); 
	//********
	
	return true;
}

function showsendingoption(val){
		if(val.value=="all"){
			document.getElementById("textboddiv").style.display="none";
			document.getElementById("limitdiv").style.display="block";
		}
		else{
			document.getElementById("textboddiv").style.display="block";
			document.getElementById("limitdiv").style.display="none";	
		}
			
}

function resetSubscriber(){
	var x=confirm("Do you want to reset all subscriber");
	if(x)
		getServerResponse("mailresetdiv","AjaxHandler.php?query=resetallsubscriber","../",true);
	else 
		return false;
}