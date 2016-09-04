<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");
ob_start();
include_once("../include/connect.php");
include_once("../db/db.php");
if($_REQUEST["query"]=="logout"){
$del = mysql_query("select productid from cart where session_id='".session_id()."'");
while($res = mysql_fetch_assoc($del))
{
	$product_id = $res['productid'];
	unset($_SESSION["incart_".$product_id]);
}
	$sqlclearcart="delete from cart where session_id='".session_id()."'";
	mysql_query($sqlclearcart) or die(mysql_error());
	unset($_SESSION["cart_item"]);
	session_destroy();
	header("Location: index.html");	
	exit;
}
//******************************* Upadating Customer Personal Info **********************************
if(isset($_REQUEST["btnupdatereg"])){

	$rowAffected=rs_update("customer","
	CustName='".mysql_escape_string($_REQUEST["CustName"])."',
	CustPhone='".mysql_escape_string($_REQUEST["CustPhone"])."',
	CustAddress='".mysql_escape_string($_REQUEST["CustAddress"])."',
	CustCity='".mysql_escape_string($_REQUEST["CustCity"])."',
	CustState='".mysql_escape_string($_REQUEST["CustState"])."',
	CustZIPCode='".mysql_escape_string($_REQUEST["CustZIPCode"])."',
	CustCountry='".mysql_escape_string($_REQUEST["CustCountry"])."'","CustEmail='".$_SESSION["CustEmail"]."'");
	
	if($rowAffected>0)
	  $_SESSION["msg"]="Info Updated Successfully";
	else
	  $_SESSION["msg"]="Info Not Updated";
	  header("Location: my_account.html?id=54351354");	
	  exit;
}
//******************************************* password change work ***************************************
else if(isset($_REQUEST["btnchangepass"])){

	$oldpass=$_REQUEST["oldpassword"];
	$newpass=$_REQUEST["newpassword"];
	$userid=$_REQUEST["CustEmail"];
	
	$countSql="select COUNT(CustEmail) from customer where CustEmail='".$userid."' and CustPassword='".$oldpass."'";
	$countRs=mysql_query($countSql) or die("Error :".mysql_error());
	$countData=mysql_fetch_array($countRs);
	
	if($countData[0]<1){
	    $_SESSION["msg"]="Invalid Old Password";
	}
	else{
	    $rowAffected=rs_update("customer","CustPassword='".$newpass."'","CustEmail='".$userid."'");
		if($rowAffected>0)
           $_SESSION["msg"]="Password Changed Successfully";
		else
		   $_SESSION["msg"]="Password Not Changed";
	}
	header("Location: my_account.html?id=25321354");	
	exit;
}
else if(isset($_REQUEST['updatebill_x']))
{
	$username = mysql_real_escape_string($_REQUEST["username"]);
	$userlastname = mysql_real_escape_string($_REQUEST["userlastname"]);
	$useremail = mysql_real_escape_string($_REQUEST["useremail"]);
	$userphone = mysql_real_escape_string($_REQUEST["userphone"]);
	$telephone = mysql_real_escape_string($_REQUEST["telephone"]);
	$useraddress = mysql_real_escape_string($_REQUEST["useraddress"]);
	$useraddress1 = mysql_real_escape_string($_REQUEST["useraddress1"]);
	$usercity = mysql_real_escape_string($_REQUEST["usercity"]);
	$select2 = mysql_real_escape_string($_REQUEST["select2"]);
	$province = mysql_real_escape_string($_REQUEST["province"]);
	$select3 = mysql_real_escape_string($_REQUEST["select3"]);
	$userfax = mysql_real_escape_string($_REQUEST["userfax"]);
	if($_REQUEST['bill'])
	{
		$rowAffected=rs_update("shipbilldetail","BillCustName='$username',BillCustLastName='$userlastname',BillCustEmail='$useremail',BillCustPhone ='$userphone',BillCustTelePhone='$telephone',BillCustAddress='$useraddress',BillCustAddress1='$useraddress1',BillCustCity='$usercity',BillCustState='$select2',BillCustZIPCode='$province',BillCustCountry ='$select3',Billfax='$userfax'","id='".$_SESSION['registerid']."'");
	}	
	else
	{
		$rowAffected=rs_update("shipbilldetail","ShipCustName='$username',ShipCustLastName='$userlastname',ShipCustEmail='$useremail',ShipCustPhone ='$userphone',ShipCustTelePhone='$telephone',ShipCustAddress='$useraddress',ShipCustAddress1='$useraddress1',ShipCustCity='$usercity',ShipCustState='$select2',ShipCustZIPCode='$province',ShipCustCountry ='$select3',Shipfax='$userfax'","id='".$_SESSION['registerid']."'");
		$_SESSION["shipcountry"]=$select3;
		$_SESSION["shipcity"]=$usercity;
	}
	
	header("Location:billing-shiping-info.html");
	exit;
}
else if(isset($_REQUEST['updateuserprofile_x']))
{
	$username = mysql_real_escape_string($_REQUEST["username"]);
	$userlastname = mysql_real_escape_string($_REQUEST["userlastname"]);
	$useremail = mysql_real_escape_string($_REQUEST["useremail"]);
	$userphone = mysql_real_escape_string($_REQUEST["userphone"]);
	$telephone = mysql_real_escape_string($_REQUEST["telephone"]);
	$useraddress = mysql_real_escape_string($_REQUEST["useraddress"]);
	$useraddress1 = mysql_real_escape_string($_REQUEST["useraddress1"]);
	$usercity = mysql_real_escape_string($_REQUEST["usercity"]);
	$select2 = mysql_real_escape_string($_REQUEST["select2"]);
	$province = mysql_real_escape_string($_REQUEST["province"]);
	$select3 = mysql_real_escape_string($_REQUEST["select3"]);
	$userfax = mysql_real_escape_string($_REQUEST["userfax"]);
	$rowAffected=rs_update("customer","CustName='$username',CustLastName='$userlastname',CustEmail='$useremail',CustPhone ='$userphone',CustTelephone='$telephone',CustAddress='$useraddress',CustAddress1='$useraddress1',CustCity='$usercity',CustState='$select2',CustZIPCode='$province',CustCountry ='$select3',fax='$userfax'","id='".$_SESSION['userid']."' and usertype='register'");
	$rowAffected=rs_update("shipbilldetail","BillCustName='$username',BillCustLastName='$userlastname',BillCustEmail='$useremail',BillCustPhone ='$userphone',BillCustTelePhone='$telephone',BillCustAddress='$useraddress',BillCustAddress1='$useraddress1',BillCustCity='$usercity',BillCustState='$select2',BillCustZIPCode='$province',BillCustCountry ='$select3',Billfax='$userfax'","id='".$_SESSION['registerid']."'");
	//$_SESSION["shipcountry"]=$select3;
	//$_SESSION["shipcity"]=$usercity;
	header("Location:myaccount.html");
	exit;
}				
?>

