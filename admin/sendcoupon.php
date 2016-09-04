<?php
session_start();
include("page-add.php");
include("../include/connect.php");
include("../db/db.php");
if($_SESSION['AdminId']=="")
{
echo "<script>window.location.href='index.php';</script>";
}

$sqlcoupon = mysql_query("select id, name from coupons where status='Y'");
$lquery=$_REQUEST["lquery"]==""?"": " and tl.CustName like '".$_REQUEST["lquery"]."%'";
/* $sql="SELECT DISTINCT (CustEmail) FROM  `customer`";
$numrows=mysql_num_rows(mysql_query($sql));
$rowsPerPage = 10;
$pageNum = 1;
if($_GET['page']!="")
	$pageNum = $_GET['page'];

$offset = ($pageNum - 1) * $rowsPerPage;
$pageFrom=$offset==0?"1":$offset+1;

$maxPage = ceil($numrows/$rowsPerPage);
$self = $_SERVER['PHP_SELF'].'?opt=pg';

$rs=mysql_query($sql." LIMIT $offset, $rowsPerPage")or die("mysql_error : ".mysql_error());
$rocordperpage=mysql_num_rows($rs);	*/


//$sql_s="select count(*) cnt from tbl_subscription where send='0'";
//$rs_s=mysql_query($sql_s) or die(mysql_error());
//$d_s=mysql_fetch_array($rs_s);
//$mail_not_send=$d_s["cnt"];


//$sql_s="select count(*) cnt from tbl_subscription where send='1'";
//$rs_s=mysql_query($sql_s) or die(mysql_error());
//$d_s=mysql_fetch_array($rs_s);
//$mail_send=$d_s["cnt"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin:: 47th Diamond District Corp.</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="images/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" language="javascript" src="selectbox.js"></script>
<script language="javascript" type="text/javascript" src="images/dhtmlgoodies_calendar.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});
</script>

<script language="javascript" type="text/javascript">
function showsendingoption(val,sendinchoice){
		if(val.value=="all"){
			document.getElementById("textboddiv").style.display="none";
			document.getElementById("limitdiv").style.display="block";
		}
		else{
			document.getElementById("textboddiv").style.display="block";
			document.getElementById("limitdiv").style.display="none";	
		}
		
		document.getElementById('hiddensendingoption').value=sendinchoice;	
}
function showShip(boxid){
   document.getElementById(boxid).style.visibility="block";
   document.getElementById('showalluser').style.visibility="none";
}

function hideShip(boxid){
   document.getElementById(boxid).style.visibility="none";
   document.getElementById('showalluser').style.visibility="block";
}
function hideshow(hideid,showid,sendinchoice){
   if(hideid!='')
   	   document.getElementById(hideid).style.display="none";
	if(showid!='')
   		document.getElementById(showid).style.display="block";

	document.getElementById('hiddensendingchoice').value=sendinchoice;	
}
</script>
</head>

<body bgcolor="#F5F3E3" onload="hideShip('byclient');">
<center>
  <?php echo admin_top(); ?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="text">
    <tr>
      <td bgcolor="#583103"><img src="images/dot.gif" width="1" height="2" /></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#3A1F08"><div id="navi-panel">
          <?php echo admin_nav(); ?>
        <script type="text/javascript">
        jQuery.each(jQuery('#navi-panel>ul>li'), function() {
           if (jQuery(this).position().left > 625) {
                jQuery(this).children().filter('ul').addClass('submenuright')
            }
            jQuery(this).mouseover(function() {
                jQuery(this).addClass("sfhover")
            })
            jQuery(this).mouseout(function() {
                jQuery(this).removeClass("sfhover")
            })
        });
    </script>
      </div></td>
    </tr>
  </table>
  <?php echo admin_right_nav();
  if(isset($_SESSION['msg']))
{
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}?>
<br />
<table width="90%" height="33" border="0" cellpadding="6" cellspacing="0" class="text1">
  <tr>
    <td><h1><font color="#6B6B6B">Send Coupon </font></h1></td>
    <td align="right"><a href="#"></a></td>
  </tr>
</table>
<form name="frm_opts1" method="post" action="sendcouponletter.php" onsubmit="return validateForm(this);">
<table width="90%" border="0" cellpadding="3" cellspacing="1" class="text1">
  <tr class="text">
    <td height="33" align="center" valign="top" bgcolor="#FFFFFF">
	<table width="80%" border="0" cellpadding="3" cellspacing="1" bgcolor="#3A1F08" class="text1">
		  <tr>
		  	<td class="text">Select Coupon </td>
		     <td><select id="couponname" name="couponname" onchange="getServerResponse('amountajax','AjaxHandler.php?query=checkamount&dublicate='+this.value,'',false)">
			 	<option value="">Coupon Name</option>
<?php
while($couponres = mysql_fetch_assoc($sqlcoupon))
{
echo'<option value='.$couponres['id'].'>'.stripslashes($couponres['name']).'</option>';
}
 ?>
			 </select></td>
		  </tr>
		  
		  <tr>
		     <td class="text">Amount </td>
			 <td> <div id="amountajax"></div>
			 </td>
		  </tr>
		  <tr>
		     <td class="text">Valid Upto </td>
			 <td><input type="text" class="inp2" name="news_date" id="news_date" size="10" Readonly="">&nbsp;<img src="images/cal.gif" border="0"  onclick=displayCalendar(document.getElementById("news_date"),"dd/mm/yyyy",this)>
			 
			 </td>
		  </tr>
		  <tr>
		  	<td class="text">Sending Choice</td>
			<td class="text">
				<input type="radio" name="dblist" id="dblist" value="dblist" checked="checked" onclick="hideshow('byclient','showalluser','fromdatabase');" />&nbsp;<strong>From Database</strong>
				<input type="radio" name="dblist" id="byadmin" value="byadmin" onclick="hideshow('showalluser','byclient','fromoutside');"  />&nbsp;<strong>User id by You</strong>
			</td>
		  </tr>
		  <tr>
		  <td colspan="2">
		  <div id="showalluser">
		  <table width="100%" border="0" cellpadding="3" cellspacing="1">
		  <tr>
		  	<td class="text">Sending Option</td>
			<td class="text">
				<input type="radio" name="sendingoption" id="sendingoption1" value="all" checked onclick="showsendingoption(this,'all');" />&nbsp;<strong>ALL</strong>
				<input type="radio" name="sendingoption" id="sendingoption2" value="userwise" onclick="showsendingoption(this,'userwise');"  />&nbsp;<strong>User Wise</strong>
			</td>
		  </tr>
		  <tr>
			<td class="text">&nbsp;</td>
			<td>
			<div id="limitdiv">&nbsp;
			</div>
			<div id="textboddiv" style="display:none;">
				<table width="80%" border="0" cellspacing="0" cellpadding="0">
		           <tr>
				   	<td width="45%" align="center">
						<select size="10" name="masteremail[]" id="masteremail" multiple="multiple">
							<?php
								$sql_email="SELECT DISTINCT (CustEmail) FROM  `customer`";
								$rs_email=mysql_query($sql_email) or die(mysql_error());
								while($data_email=mysql_fetch_array($rs_email))
									echo '<option value="'.$data_email["CustEmail"].'">'.$data_email["CustEmail"].'</option>';
							?>
						</select>
					</td>

					<td>
<INPUT class="ssubmenubut" id="bt_LR" onclick="addOnCon(document.frm_opts1.masteremail,document.frm_opts1.subscriberemail);" type="button" value=">>" name="bt_LR">
				<br />
<input class="ssubmenubut" id="bt_RL" onclick="removeOnCon(document.frm_opts1.subscriberemail);" type="button" value="&lt;&lt;" name="bt_RL" />
					
					</td>
					<td>	
						<select size="10" name="subscriberemail[]" id="subscriberemail" multiple="multiple">
						</select>
					</td>
				</tr>
			</table>			
			</div>
			</td>
		  </tr>
		  <tr>
		     <td align="center" colspan="2">
			   <input type="image"  src="images/send.gif" alt="submit"  border="0" name="btnsendnewsletter" value="S E N D"  style="cursor:pointer;" onclick="allSelected();" />
            <input type="hidden" name="btnsendnewsletter" value="add" />
			

			 </td>
		  </tr>
		  </table>
		  </div>
		  </td>
		  </tr>
		 <!-- <tr>
		  <td>&nbsp;</td>
		  <td align="center" id="mailresetdiv" class="text">
			&nbsp;&nbsp;<strong>Mail Send</strong>&nbsp; : &nbsp;<?php// echo $mail_send; ?>
			&nbsp;&nbsp;<strong>Remail Mail</strong>&nbsp; : &nbsp;<?php// echo $mail_not_send; ?>
		  </td></tr>-->
		  <tr>
			  <td colspan="2">
			  <div  id="byclient" style="display:none;">
				  <table width="100%" border="0" cellpadding="3" cellspacing="1">
					<tr>
					 <td class="text">User Id </td>
					 <td><input type="text" class="inp2" name="useremaiid" id="useremaiid" size="10">
					 
					 </td>
				  </tr>
				  <tr>
		     <td align="center" colspan="2">
			   <input type="image"  src="images/send.gif" alt="submit"  border="0" name="btnbyclient" value="S E N D"  style="cursor:pointer;" onclick="return validateFormByUser(this);" />
            
            &nbsp;&nbsp;
           

			 </td>
		  </tr>
				 </table>
				 </div>
			 </td>
		 </tr>
		  <!--<tr>
		     <td align="center" colspan="2">
			   <input type="image"  src="images/send.gif" alt="submit"  border="0" name="btnsendnewsletter" value="S E N D"  style="cursor:pointer;" onclick="return validateForm(this);" />
            <input type="hidden" name="btnsendnewsletter" value="add" />
			

			 </td>
		  </tr>-->
		 
		  <!--
		  <tr>
		     <td align="center" colspan="2">
			   <input type="image"  src="images/send.gif" alt="submit"  border="0" name="btnbyclient" value="S E N D"  style="cursor:pointer;" onclick="return validateFormByUser(this);" />
            
            &nbsp;&nbsp;
           

			 </td>
		  </tr>
		  -->



     
    </table>
        <br />
	</td>
  </tr>
</table>
<input type="hidden" name="hiddensendingchoice" value="fromdatabase" id="hiddensendingchoice" />
<input type="hidden" name="hiddensendingoption" value="all" id="hiddensendingoption" />

</form>
<br />
<br />
<?php admin_footer(); ?>
</center>
</body>
</html>
