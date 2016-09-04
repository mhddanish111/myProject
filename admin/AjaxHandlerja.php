<?php
session_start();
include_once('../db/db.php');
require_once("../include/connect.php");
$imagepath = "../gallery/large/";
$imagenew = "../gallery/small/";
$imagelist = "../gallery/showlist/";
if($_REQUEST["query"]=="checkcat")
{
    //$responseText="failure#@#";
	$cat=isset($_REQUEST["dublicate"])?$_REQUEST["dublicate"]:"";
	// checking Email
	if(isFound("category","ja_catname",$cat))
			$responseText=" Not Available";
		else
			$responseText="Available";	
echo $responseText;
}
else if($_REQUEST["query"]=="checksubcat")
{
    //$responseText="failure#@#";
	$subcat=isset($_REQUEST["dublicate"])?$_REQUEST["dublicate"]:"";
	$catname = $_REQUEST['catname'];
	// checking Email.
	if(isFoundMore("subcategory","catid='$catname' and ja_subcat='$subcat'"))
		$responseText=" Not Available";
	else
		$responseText="Available";	
echo $responseText;
}
else if($_REQUEST["query"]=="checkproduct")
{
    //$responseText="failure#@#";
	$cat=isset($_REQUEST["dublicate"])?$_REQUEST["dublicate"]:"";
	// checking Email
	if(isFound("catproduct","catname",$cat))
			$responseText=" Not Available";
		else
			$responseText="Available";	
echo $responseText;
}
else if($_REQUEST["query"]=="password")
{
    //$responseText="failure#@#";
	$cat=isset($_REQUEST["dublicate"])?$_REQUEST["dublicate"]:"";
	// checking password
	$sql="select * from admin where admin_password='$cat' and admin_id='".$_SESSION['AdminId']."'";
	$rs=mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($rs)>0)
		$flag=true;
	else
		$flag=false;
	if($flag)
			$responseText="Match";
		else
			$responseText="Not Match";	
echo $responseText;
}
else if($_REQUEST["query"]=="selectsub")
{
	$responseText="";
    //$responseText="failure#@#";
	$cat=isset($_REQUEST["dublicate"])?$_REQUEST["dublicate"]:"";
	#select sub catgeory
	$subsel = mysql_query("select * from ja_subcategory where status ='Y' and catid='$cat'");
	$responseText .= '<option value="">Select Category</option>';
	while($result1 = mysql_fetch_assoc($subsel))
	{
		$responseText .= '<option value='.$result1['id'].'>'. stripslashes($result1['subcat']).'</option>';
	}
echo $responseText;
}
else if($_REQUEST["query"]=="checkcolor")
{
    //$responseText="failure#@#";
	$cat=isset($_REQUEST["dublicate"])?$_REQUEST["dublicate"]:"";
	// checking Email
	if(isFound("color","colorname",$cat))
			$responseText=" Not Available";
		else
			$responseText="Available";	
echo $responseText;
}
?>
