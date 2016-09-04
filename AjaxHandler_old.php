<?php
session_start();
include_once("include/connect.php");
include_once("db/db.php");
$date = date("Y/m/d");
$date1 = date("d/m/Y");
$ip = $_SERVER['REMOTE_ADDR'];
if($_REQUEST["query"]=="checkusername"){
	$responseText="";
	$CustEmail=$_REQUEST["CustEmail"];
	$sql="select CustEmail from customer where CustEmail='".$CustEmail."' and usertype='register'";
	$rs=mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($rs)>0){
		$responseText="success#@#Not Available";
	}
	else{
		$responseText="success#@#Available";
	}
	
	echo $responseText;
}
else if($_REQUEST["query"]=="redirectpage")
{
	$chk = $_POST['radiobutton'];
	if($chk=="Register")
	{
		header("Location:billing.html");
		exit();
	}
	else
	{
		header("Location:billing1.html");
		exit();
	}
}
//************************************** natching verification code ************************
else if($_REQUEST["query"]=="matchkey"){
    $responseText="";
	
	$keycode=$_REQUEST["keycode"];
	$CustEmail=$_REQUEST["CustEmail"];
	$sql="select CustEmail from customer where CustEmail='".$CustEmail."'";
	$rs=mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($rs)>0){
			$responseText="failure#@#Email Not Available";
	}
	else{
	        if($keycode!=$_SESSION["keycode"])
				$responseText="failure#@#KeyCode Not Match ";
			else
				$responseText="success#@#";
		
	}
	echo $responseText;
}
else if($_REQUEST["query"]=="checkcoupon"){
    $responseText="failure#@#";
	$gtotal=0;
	$today = date("d/m/Y");
	$couponid=$_REQUEST["dublicate"];
	$CustEmail=$_SESSION["CustEmail"];
	$sql="select sc.validUpto,sc.flag,c.amount from sendcoupon as sc,coupons as c where c.id=sc.cid and sc.userid='".$CustEmail."' and sc.couponid='".$couponid."'";
	$rs=mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($rs)>0)
	{
		$res = mysql_fetch_assoc($rs);
		if($res['flag']=="N")
		{
			$validate = $res['validUpto'];
			//$validate = strtotime($validate);
			
			if(getDateDiff($today,$validate) >0)
			{
				$responseText="success#@#Coupon Available amount $".$res['amount'];
				$_SESSION['couponamount'] = $res['amount'];
				$_SESSION['couponid'] = $couponid;
				//$_SESSION['granttotal'] = $_SESSION['granttotal']-$res['amount'];
				
				$gtotal = $_SESSION['shipcharge']+$_SESSION['tax']+$_SESSION['subtotal']-$_SESSION['couponamount'];
				
				$responseText .='#@#Sub Total : $'. $_SESSION['subtotal'].'<br />Shipping : $'.$_SESSION['shipcharge'];
				if($_SESSION['tax']!=00)
				$responseText .='<br />Tax : $'.$_SESSION['tax'];
				if($_SESSION['couponamount']!=0)
				$responseText .='<br />Discount : $'.$_SESSION['couponamount'];
				$responseText .='<br /> <strong>Total Cost: $'.$gtotal.'</strong>';
				//$sqlupdatecoupon=mysql_query("update `sendcoupon` set flag='Y',usedate='".$date1."' where userid='".$_SESSION["CustEmail"]."'and couponid='".$_SESSION['couponid']."'");
				//$responseText .="update `sendcoupon` set flag='Y',usedate='".$date1."' where userid='".$_SESSION["CustEmail"]."'";
			}
			else
			{
				$responseText="failure#@#Coupon Date Expire";
				$_SESSION['couponamount']=0;
				$_SESSION['couponid'] = "";
				$gtotal = $_SESSION['shipcharge']+$_SESSION['tax']+$_SESSION['subtotal']-$_SESSION['couponamount'];
				
				$responseText .='#@#Sub Total : $'. $_SESSION['subtotal'].'<br />Shipping : $'.$_SESSION['shipcharge'];
				if($_SESSION['tax']!=00)
				$responseText .='<br />Tax : $'.$_SESSION['tax'];
				if($_SESSION['couponamount']!=0)
				$responseText .='<br />Discount : $'.$_SESSION['couponamount'];
				$responseText .='<br /> <strong>Total Cost: $'.$gtotal.'</strong>';
			}
		}
		else
		{
			$responseText="failure#@#You Already Use It";
			$_SESSION['couponamount']=0;
			$_SESSION['couponid'] = "";
			$gtotal = $_SESSION['shipcharge']+$_SESSION['tax']+$_SESSION['subtotal']-$_SESSION['couponamount'];
				$responseText .='#@#Sub Total : $'. $_SESSION['subtotal'].'<br />Shipping : $'.$_SESSION['shipcharge'];
				if($_SESSION['tax']!=00)
				$responseText .='<br />Tax : $'.$_SESSION['tax'];
				if($_SESSION['couponamount']!=0)
				$responseText .='<br />Discount : $'.$_SESSION['couponamount'];
				$responseText .='<br /> <strong>Total Cost: $'.$gtotal.'</strong>';
		}
	}
	else
	{
		$responseText="failure#@#Invalid Coupon Code";
		$_SESSION['couponamount']=0;
		$_SESSION['couponid'] = "";
		$gtotal = $_SESSION['shipcharge']+$_SESSION['tax']+$_SESSION['subtotal']-$_SESSION['couponamount'];
		$responseText .='#@#Sub Total : $'. $_SESSION['subtotal'].'<br />Shipping : $'.$_SESSION['shipcharge'];
				if($_SESSION['tax']!=00)
				$responseText .='<br />Tax : $'.$_SESSION['tax'];
				if($_SESSION['couponamount']!=0)
				$responseText .='<br />Discount : $'.$_SESSION['couponamount'];
				$responseText .='<br /> <strong>Total Cost: $'.$gtotal.'</strong>';
	}
	echo $responseText;
}

//************************************************** Customer Registration **********************************
else if($_REQUEST["query"]=="custregistration")
{
	$responseText="failure#@#";
	$chk = $_REQUEST['radiobutton1'];
	$CustEmail= mysql_real_escape_string($_REQUEST["useremail"]);
	$status	= $_REQUEST['specialcheckbox']!=""?"Y":"N";
	$username = mysql_real_escape_string($_REQUEST["username"]);
	$userlastname = mysql_real_escape_string($_REQUEST["userlastname"]);
	$userpassword = mysql_real_escape_string($_REQUEST["userpassword"]);
	$userphone = mysql_real_escape_string($_REQUEST["userphone"]);
	$telephone = mysql_real_escape_string($_REQUEST["telephone"]);
	$useraddress = mysql_real_escape_string($_REQUEST["useraddress"]);
	$useraddress1 = mysql_real_escape_string($_REQUEST["useraddress1"]);
	$usercity = mysql_real_escape_string($_REQUEST["usercity"]);
	$select2 = mysql_real_escape_string($_REQUEST["select2"]);
	$province = mysql_real_escape_string($_REQUEST["province"]);
	$select3 = mysql_real_escape_string($_REQUEST["select3"]);
	$userfax = mysql_real_escape_string($_REQUEST["userfax"]);
	$shipCustEmail=$_REQUEST["shipuseremail"];
	$shipusername = mysql_real_escape_string($_REQUEST["shipusername"]);
	$shipuserlastname = mysql_real_escape_string($_REQUEST["shipuserlastname"]);
	$shipuserphone = mysql_real_escape_string($_REQUEST["shipuserphone"]);
	$shipusertelephone = mysql_real_escape_string($_REQUEST["shipusertelephone"]);
	$shipuseraddress = mysql_real_escape_string($_REQUEST["shipuseraddress"]);
	$shipuseraddress1 = mysql_real_escape_string($_REQUEST["shipuseraddress1"]);
	$shipusercity = mysql_real_escape_string($_REQUEST["shipusercity"]);
	$shipselect2 = mysql_real_escape_string($_REQUEST["shipselect2"]);
	$shipprovince = mysql_real_escape_string($_REQUEST["shipprovince"]);
	$shipselect3 = mysql_real_escape_string($_REQUEST["shipselect3"]);
	$shipuserfax = mysql_real_escape_string($_REQUEST["shipuserfax"]);
	#$useraddress2 = $useraddress." ".$useraddress1;
	$sql="select CustEmail from customer where CustEmail='".$CustEmail."' and usertype='register'";
	$rs=mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($rs)>0){
	    $responseText="failure#@#Email Id Not Available";
	}
	else
	{
			 //****************** INSERTING INTO DATABASE AND SEDING MAIL*********
		$rowAffected=rs_insert("customer","CustName,CustLastName,CustEmail,CustPassword,CustPhone,CustTelephone,CustAddress,CustAddress1,CustCity,CustState,CustZIPCode,CustCountry,fax,regdate,ipaddress,usertype,sendMonth","'$username','$userlastname','$CustEmail','$userpassword','$userphone','$telephone','$useraddress','$useraddress1','$usercity','$select2','$province','$select3','$userfax','$date','$ip','register','$status'");
		$userid = mysql_insert_id();
		if($rowAffected>0)
		{   
			//****************** @jawed inserting value for mailing list in tbl_subscriber table 
		
		if($_REQUEST['specialcheckbox']!=""){
			$rw=rs_del("tbl_subscription","email='$CustEmail'");
			$rw=rs_insert("tbl_subscription","email,sessionid,ipaddress,sstatus","'".$CustEmail."','".session_id()."','".$_SERVER['REMOTE_ADDR']."','Y'");
		}
			// inserting mail id into shipbill table
			if($chk=="shipingsame")
			{
				$rowShipBill=rs_insert("shipbilldetail","userid,CustEmail,ShipCustName,ShipCustLastName,ShipCustEmail,ShipCustPhone,ShipCustTelePhone,ShipCustAddress,ShipCustAddress1,ShipCustCity,ShipCustState,ShipCustZIPCode, ShipCustCountry,Shipfax,BillCustName,BillCustLastName,BillCustEmail,BillCustPhone,BillCustTelePhone,BillCustAddress,BillCustAddress1,BillCustCity,BillCustState,BillCustZIPCode,BillCustCountry,Billfax","'$userid','$CustEmail','$username','$userlastname','$CustEmail','$userphone','$telephone','$useraddress','$useraddress1','$usercity','$select2','$province','$select3','$userfax','$username','$userlastname','$CustEmail','$userphone','$telephone','$useraddress','$useraddress1','$usercity','$select2','$province','$select3','$userfax'");
				$_SESSION["shipcountry"]=$select3;
				$_SESSION["shipcity"]=$usercity;
			}
			else
			{
				$rowShipBill=rs_insert("shipbilldetail","userid,CustEmail,ShipCustName,ShipCustLastName,ShipCustEmail,ShipCustPhone,ShipCustTelePhone,ShipCustAddress,ShipCustAddress1,ShipCustCity,ShipCustState,ShipCustZIPCode, ShipCustCountry,Shipfax,BillCustName,BillCustLastName,BillCustEmail,BillCustPhone,BillCustTelePhone,BillCustAddress,BillCustAddress1,BillCustCity,BillCustState,BillCustZIPCode,BillCustCountry,Billfax","'$userid','$CustEmail','$shipusername','$shipuserlastname','$shipCustEmail','$shipuserphone','$shipusertelephone','$shipuseraddress','$shipuseraddress1','$shipusercity','$shipselect2','$shipprovince','$shipselect3','$shipuserfax','$username','$userlastname','$CustEmail','$userphone','$telephone','$useraddress','$useraddress1','$usercity','$select2','$province','$select3','$userfax'");
				$_SESSION["shipcountry"]=$shipselect3;
				$_SESSION["shipcity"]=$shipusercity;
			}
			$_SESSION["CustEmail"]=$_REQUEST["useremail"];
			$_SESSION["userid"]=$userid;
			
			$_SESSION["LoginStatus"]="Customer";
			$_SESSION["CustName"]=$_REQUEST["username"];
			$_SESSION["Register"]="register";
			$_SESSION["registerid"]=mysql_insert_id();
			$responseText="success#@#billing-shiping-info.html";
			}
		
		else{
				$responseText="failure#@#Failed Try Again";
		}
	}	
	echo $responseText;
}
//************************************************** Customer Registration **********************************
else if($_REQUEST["query"]=="guestregistration")
{
	$chk = $_POST['radiobutton1'];
	$CustEmail= mysql_real_escape_string($_REQUEST["useremail"]);
	$status	= $_REQUEST['specialcheckbox']!=""?"Y":"N";
	$username = mysql_real_escape_string($_REQUEST["username"]);
	$userlastname = mysql_real_escape_string($_REQUEST["userlastname"]);
	$userphone = mysql_real_escape_string($_REQUEST["userphone"]);
	$telephone = mysql_real_escape_string($_REQUEST["telephone"]);
	$useraddress = mysql_real_escape_string($_REQUEST["useraddress"]);
	$useraddress1 = mysql_real_escape_string($_REQUEST["useraddress1"]);
	$usercity = mysql_real_escape_string($_REQUEST["usercity"]);
	$select2 = mysql_real_escape_string($_REQUEST["select2"]);
	$province = mysql_real_escape_string($_REQUEST["province"]);
	$select3 = mysql_real_escape_string($_REQUEST["select3"]);
	$userfax = mysql_real_escape_string($_REQUEST["userfax"]);
	$shipCustEmail=$_REQUEST["shipuseremail"];
	$shipusername = mysql_real_escape_string($_REQUEST["shipusername"]);
	$shipuserlastanme = mysql_real_escape_string($_REQUEST["shipuserlastanme"]);
	$shipuserphone = mysql_real_escape_string($_REQUEST["shipuserphone"]);
	$shipusertelephone = mysql_real_escape_string($_REQUEST["shipusertelephone"]);
	$shipuseraddress = mysql_real_escape_string($_REQUEST["shipuseraddress"]);
	$shipuseraddress1 = mysql_real_escape_string($_REQUEST["shipuseraddress1"]);
	$shipusercity = mysql_real_escape_string($_REQUEST["shipusercity"]);
	$shipselect2 = mysql_real_escape_string($_REQUEST["shipselect2"]);
	$shipuserprovince = mysql_real_escape_string($_REQUEST["shipuserprovince"]);
	$shipselect3 = mysql_real_escape_string($_REQUEST["shipselect3"]);
	$shipuserfax = mysql_real_escape_string($_REQUEST["shipuserfax"]);
	$useraddress2 = $useraddress." ".$useraddress1;
	
			 //****************** INSERTING INTO DATABASE AND SEDING MAIL*********
	
	
	$rowAffected=rs_insert("customer","CustName,CustLastName,CustEmail,CustPassword,CustPhone,CustTelephone,CustAddress,CustAddress1,CustCity,CustState,CustZIPCode,CustCountry,fax,regdate,ipaddress,usertype,sendMonth","'$username','$userlastname','$CustEmail','$userpassword','$userphone','$telephone','$useraddress','$useraddress1','$usercity','$select2','$userzip','$select3','$userfax','$date','$ip','GUEST','$status'");
	$userid = mysql_insert_id();
	if($rowAffected>0)
	{   // inserting mail id into shipbill table
		
		
		//****************** @jawed inserting value for mailing list in tbl_subscriber table 
		
		if($_REQUEST['specialcheckbox']!=""){
			$rw=rs_del("tbl_subscription","email='$CustEmail'");
			$rw=rs_insert("tbl_subscription","email,sessionid,ipaddress,sstatus","'".$CustEmail."','".session_id()."','".$_SERVER['REMOTE_ADDR']."','Y'");
		}
		
		if($chk=="shipingsame")
		{
			$rowShipBill=rs_insert("shipbilldetail","userid,CustEmail,ShipCustName,ShipCustLastName,ShipCustEmail,ShipCustPhone,ShipCustTelePhone,ShipCustAddress,ShipCustAddress1,ShipCustCity,ShipCustState,ShipCustZIPCode, ShipCustCountry,Shipfax,BillCustName,BillCustLastName,BillCustEmail,BillCustPhone,BillCustTelePhone,BillCustAddress,BillCustAddress1,BillCustCity,BillCustState,BillCustZIPCode,BillCustCountry,Billfax","'$userid','$CustEmail','$username','$userlastname','$CustEmail','$userphone','$telephone','$useraddress','$useraddress1','$usercity','$select2','$province','$select3','$userfax','$username','$userlastname','$CustEmail','$userphone','$telephone','$useraddress','$useraddress1','$usercity','$select2','$province','$select3','$userfax'");
			$_SESSION["shipcountry"]=$select3;
			$_SESSION["shipcity"]=$usercity;
		}
		else
		{
			$rowShipBill=rs_insert("shipbilldetail","userid,CustEmail,ShipCustName,ShipCustLastName,ShipCustEmail,ShipCustPhone,ShipCustTelePhone,ShipCustAddress,ShipCustAddress1,ShipCustCity,ShipCustState,ShipCustZIPCode, ShipCustCountry,Shipfax,BillCustName,BillCustLastName,BillCustEmail,BillCustPhone,BillCustTelePhone,BillCustAddress,BillCustAddress1,BillCustCity,BillCustState,BillCustZIPCode,BillCustCountry,Billfax","'$userid','$CustEmail','$shipusername','$shipuserlastanme','$shipCustEmail','$shipuserphone','$shipusertelephone','$shipuseraddress','$shipuseraddress1','$shipusercity','$shipselect2','$shipuserprovince','$shipselect3','$shipuserfax','$username','$userlastname','$CustEmail','$userphone','$telephone','$useraddress','$useraddress1','$usercity','$select2','$province','$select3','$userfax'");
			$_SESSION["shipcountry"]=$shipselect3;
			$_SESSION["shipcity"]=$shipusercity;
		}
		$_SESSION["CustEmail"]=$_REQUEST["useremail"];
		$_SESSION["userid"]=$userid;
		//$_SESSION["CustName"]=$_REQUEST["username"];
		$_SESSION["Register"]="GUEST";
		$_SESSION["registerid"]=mysql_insert_id();
		if($_REQUEST["sendto"]=="userprofile")
		{
			header("Location:billing-shiping-info.html");
			exit;
		}
	}	
	else
	{
		$_SESSION['msg']="Please Try Again";
	}	 
	header("Location:billing1.html");
	exit();
}
//**************************************** Send Password************************
else if($_REQUEST["query"]=="sendpassword"){
    $responseText="failure#@#";
	
	// checking Email
	$RowCount="select id,CustName  from customer where CustEmail='".$_REQUEST["email"]."' and usertype='register'";
	$RowRs=mysql_query($RowCount) or die(mysql_error());
	$RowData=mysql_fetch_array($RowRs);
	
	if(mysql_num_rows($RowRs)<1){
	$responseText="failure#@#Email Not Found.";
	}
	else{
	$newpassword=random_generator(8);
	
	// updaring student's password
	$updatepass=rs_update("customer","CustPassword ='".$newpassword."'","CustEmail='".$_REQUEST["email"]."' and id ='".$RowData["id"]."' ");
	
	// sending mail
	$SendToUser=$_REQUEST["email"];
	$UserHeader="From:admin@47ddc.com\r\n";
	$UserHeader.="Reply-To: admin@47ddc.com \n";
	$UserHeader.='Content-type: text/html; charset=UTF-8' . "\r\n";			
	$UserSubject = "Password Help";
	$UserMessage = '<table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#0033FF">
					<tr><td> Dear '.$RowData["CustName"].',</td></tr>	
					<tr><td>&nbsp;</td></tr>
					<tr>
					<td align="">Your login details are given below:</td>
					</tr>
					<tr>
					   <td align="left"> UserName :'.$_REQUEST["email"].'.
					   </td>
					</tr>  
					<tr>
					   <td align="left"> Password :'.$newpassword.'.
					   </td>
					</tr> 
					<tr>
					   <td align="left">Click <a href="http://47ddc.axisolutions.com/">Here</a> To Login,
					   </td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>
					Thanks<br />
					 Admin<br />
					http://47ddc.axisolutions.com/
					</td></tr>
					</table>';
					if(@mail($SendToUser, $UserSubject, $UserMessage, $UserHeader)){
					$responseText="success#@#Your password has been sent to your email address.Please check your mails.";
								}
								else{
									$responseText="failure#@#Mail Sending Error.";
								}
}//else								
echo $responseText;								
}

else if($_REQUEST["query"]=="userlogin")
{
	 $responseText="failure#@#";
	$username=$_REQUEST["loginusername"];
	$password=$_REQUEST["loginpassword"];
	//$sql="select * from tb_login where username='$username' and userpassword='$password'";
	$sel = mysql_query("select id,CustName,CustEmail from customer where CustEmail='".$username."' and CustPassword ='".$password."' and usertype='register'");
	if(mysql_num_rows($sel)==1)
	{
		$log=mysql_fetch_assoc($sel);
		$selship = mysql_query("select id,ShipCustCity,ShipCustCountry from shipbilldetail  where userid='".$log["id"]."'");
		$logship=mysql_fetch_assoc($selship);
		//echo "select id from shipbilldetail  where userid='".$log["id"]."'";
		$_SESSION["LoginStatus"]="Customer";
		$_SESSION["CustEmail"]=$log["CustEmail"];
		$_SESSION["CustName"]=$log["CustName"];
		$_SESSION["Register"]="register";
		$_SESSION["registerid"]=$logship["id"];
		$_SESSION["userid"]=$log["id"];
		$_SESSION["shipcountry"]=$logship['ShipCustCountry'];
		$_SESSION["shipcity"]=$logship['ShipCustCity'];
			$responseText="success#@#".$log["CustName"];
	}
	else{
		 $responseText="failure#@#invalid login deatail";
	}
	echo $responseText;
}
else if($_REQUEST["query"]=="resetallsubscriber"){
	$responseText="success#@#";
	$sql="update tbl_subscription set send='0'";
	mysql_query($sql) or die(msql_error());
	
	
	$sql_s="select count(*) cnt from tbl_subscription where send='0'";
	$rs_s=mysql_query($sql_s) or die(mysql_error());
	$d_s=mysql_fetch_array($rs_s);
	$mail_not_send=$d_s["cnt"];
	
	
	$sql_s="select count(*) cnt from tbl_subscription where send='1'";
	$rs_s=mysql_query($sql_s) or die(mysql_error());
	$d_s=mysql_fetch_array($rs_s);
	$mail_send=$d_s["cnt"];
	
		$responseText.='&nbsp;&nbsp;<strong>Mail Send</strong>&nbsp; : &nbsp;'.$mail_send.'&nbsp;&nbsp;<strong>Remail Mail</strong>&nbsp; : &nbsp;'.$mail_not_send;
	echo 	$responseText;	
	
}
else if($_REQUEST["query"]=="selectsub")
{
	//$responseText="";
    $responseText="failure#@#";
	$cat=isset($_REQUEST["dublicate"])?$_REQUEST["dublicate"]:"";
	#select japanese Category Name
	$subsel = mysql_query("select * from subcategory where status ='Y' and catid='$cat'");
	//$catres = mysql_fetch_assoc($subsel);
	if(mysql_num_rows($subsel))
	{
		$responseText ='success#@#<option value="">Select Sub Category</option>';
		while($result1 = mysql_fetch_assoc($subsel))
		{
			$responseText .= '<option value='.$result1['id'].'>'.stripslashes($result1['subcat']).'</option>';
		}
	}
	else
		$responseText ='success#@#<option value="">Select Sub Category</option>';
	echo $responseText.$cat;
}

?>