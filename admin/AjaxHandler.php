<?php
session_start();
include_once('../db/db.php');
require_once("../include/connect.php");
$imagepath = "../gallery/large/";
//$imagenew = "../gallery/small/";
//$imagelist = "../gallery/showlist/";
if($_REQUEST["query"]=="checkcat")
{
    //$responseText="failure#@#";
	$cat=isset($_REQUEST["dublicate"])?$_REQUEST["dublicate"]:"";
	// checking Email
	$eurl=makeUrl(trim($_REQUEST['dublicate']));
	if(isFound("category","eurl",$eurl))
			$responseText=" Not Available";
		else
			$responseText="Available";	
echo $responseText;
}
else if($_REQUEST["query"]=="checkcoupon")
{
    //$responseText="failure#@#";
	$cat=isset($_REQUEST["dublicate"])?$_REQUEST["dublicate"]:"";
	// checking Email
	if(isFound("coupons ","name",$cat))
			$responseText=" Not Available";
		else
			$responseText="Available";	
echo $responseText;
}
else if($_REQUEST["query"]=="checksubcat")
{
    //$responseText="failure#@#";
	$subcat=isset($_REQUEST["dublicate"])?$_REQUEST["dublicate"]:"";
	$eurl=makeUrl(trim($_REQUEST['dublicate']));
	$catname = $_REQUEST['catname'];
	// checking Email.
	if(isFoundMore("subcategory","catid='$catname' and eurl='$eurl'"))
		$responseText=" Not Available";
	else
		$responseText="Available";	
echo $responseText;
}
else if($_REQUEST["query"]=="showsubcat")
{
    //$responseText="failure#@#";
	$id=isset($_REQUEST["dublicate"])?$_REQUEST["dublicate"]:"";
	$catname = $_REQUEST['catname'];
	// checking Email.
	$rs = mysql_query("select ja_catname from category where id='".$id."' and ja_catname !=''");
	$res = mysql_fetch_assoc($rs);
	if(mysql_num_rows($rs)>0)
	{	
		$responseText .='<input type = "text" name="subjapan" class="inp2" value ="'.stripslashes($res['ja_catname']).'" readonly=" " id="subjapan">';
	}
	else
	{
		$responseText="";
	}
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
else if($_REQUEST["query"]=="checkamount")
{
    $responseText="";
	$cat=isset($_REQUEST["dublicate"])?$_REQUEST["dublicate"]:"";
	// checking password
	$sql="select * from coupons where id='$cat'";
	$rs=mysql_query($sql) or die(mysql_error());
	$res = mysql_fetch_assoc($rs);
	$responseText .='<input type = "text" name="amount" value="$'.$res['amount'].'" class="inp2" readonly=""/>';
	$responseText .='<input type="hidden" name="couponcode" id = "couponcode" value="'.$res['couponid'].'"/>';
	echo $responseText;
}
else if($_REQUEST["query"]=="selectsub")
{
	$responseText="";
    //$responseText="failure#@#";
	$cat=isset($_REQUEST["dublicate"])?$_REQUEST["dublicate"]:"";
	#select japanese Category Name
	$selcat = mysql_query("select ja_catname from category where status ='Y' and id='$cat'");
	$subsel = mysql_query("select * from subcategory where status ='Y' and catid='$cat'");
	$catres = mysql_fetch_assoc($selcat);
	$responseText .='<table width="100%" border="0" cellpadding="10" cellspacing="1" class="text1">
	 <tr>
            <td align="left" width="292" >Category In Japanese:</td>
			<td align="left" width="262" id="selectsub1"><input type ="text" name="japancat" size="35" value="'.stripslashes($catres['ja_catname']).'" readonly=" ">';
	#select sub catgeory
	$responseText .='</td></tr><tr><td align="left" width="292" >Choose Sub Category:</td>
              			<td align="center" width="262"><select name="selectsub" class="inp2" id="selectsub" onchange="getServerResponse(\'japansub\',\'AjaxHandler.php?query=selectjapan&dublicate=\'+this.value,\'\',false)">
             			<option value="">Select sub Category</option>';
						while($result1 = mysql_fetch_assoc($subsel))
						{
							$responseText .= '<option value='.$result1['id'].'>'.stripslashes($result1['subcat']).'</option>';
						}
	$responseText .='</select></td></tr></table>';
echo $responseText;
}
else if($_REQUEST["query"]=="selectjapan")
{
	$responseText="";
    //$responseText="failure#@#";
	$cat=isset($_REQUEST["dublicate"])?$_REQUEST["dublicate"]:"";
	#select japanese Category Name
	$selcat = mysql_query("select ja_subcat from subcategory where id='$cat'");
	$catres = mysql_fetch_assoc($selcat);
	$responseText .='<br><input name="subcatjapan" type="text" size="35"  id="subcatjapan" value ="'.stripslashes($catres['ja_subcat']).'" readonly=" " />';
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
else if($_REQUEST["query"]=="mliststatus"){
	$responseText="failure#@#";
	$id=$_REQUEST["id"];
	$status=$_REQUEST["status"];
	
	$sql="update tbl_subscription set sstatus='$status' where id='$id'";
	$query=mysql_query($sql) or die(mysql_error());
	if($query) {
			if($status=="Y")
				$responseText='success#@#<img src="images/publish.jpg" style="cursor:pointer;" title="Deactivate"  width="15" height="16" border="0" onclick="getServerResponse(\'status'.$id.'\',\'AjaxHandler.php?query=mliststatus&id='.$id.'&status=N\',\'../\',false)" />';
			else{
				$responseText='success#@#<img src="images/delete.jpg"  style="cursor:pointer;" title="Activate" width="15" height="16" border="0" onclick="getServerResponse(\'status'.$id.'\',\'AjaxHandler.php?query=mliststatus&id='.$id.'&status=Y\',\'../\',false)" />';
			}	
	}	
	else 
		$responseText='failure#@#Subscriber status could not changed. Try Agin..';

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
else if($_REQUEST["query"]=="couponcode")
{
	include("autogenratedcoupon.php");
	$couponid = couponcode();
	$couponid = "47DDC".$couponid;
    $responseText="";
	$responseText .='<input type="text" name="couponcode" id="couponcode" class="inp2" value="'.$couponid.'" maxlength="19" />';
	echo $responseText;
}

?>
