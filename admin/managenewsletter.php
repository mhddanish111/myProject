<?php
session_start();
include("page-add.php");
include("../include/connect.php");
include("../db/db.php");
if($_SESSION['AdminId']=="")
{
echo "<script>window.location.href='index.php';</script>";
}


$lquery=$_REQUEST["lquery"]==""?"": " and tl.CustName like '".$_REQUEST["lquery"]."%'";
 $sql="select tl.CustName,ts.* from tbl_subscription as ts,customer as tl where ts.email=tl.CustEmail  $lquery group by ts.email";
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
$rocordperpage=mysql_num_rows($rs);	


$sql_s="select count(*) cnt from tbl_subscription where send='0'";
$rs_s=mysql_query($sql_s) or die(mysql_error());
$d_s=mysql_fetch_array($rs_s);
$mail_not_send=$d_s["cnt"];


$sql_s="select count(*) cnt from tbl_subscription where send='1'";
$rs_s=mysql_query($sql_s) or die(mysql_error());
$d_s=mysql_fetch_array($rs_s);
$mail_send=$d_s["cnt"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin:: 47th Diamond District Corp.</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript" src="../js/AjaxHandler.js"></script>
<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" language="javascript" src="selectbox.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});
</script>

<script language="javascript" type="text/javascript">
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
function validateForm(frm){
	if(frm.subject.value.search(/\S/)==-1){
		alert("Please enter mail subject.");
		frm.subject.focus();
		return false;
	}

	if(document.getElementById('sendingoption2').checked){
		if(frm.subscriberemail.value.search(/\S/)==-1){
			alert("Please select at leaset on receiver.");
			frm.subscriberemail.focus();
			return false;
		}
	}

	
}
</script>
</head>

<body bgcolor="#F5F3E3">
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
    <td><h1><font color="#6B6B6B">Send News Letter </font></h1></td>
    <td align="right"><a href="#"></a></td>
  </tr>
</table>
<form name="frm_opts1" method="post" action="sendnewsletter.php" onsubmit="return validateForm(this)">
<table width="90%" border="0" cellpadding="3" cellspacing="1" class="text1">
  <tr class="text">
    <td height="33" align="center" valign="top" bgcolor="#FFFFFF">
	<table width="80%" border="0" cellpadding="3" cellspacing="1" bgcolor="#3A1F08" class="text1">

	      <tr>
		  	<td class="text">Subject </td>
		     <td><input  type="text" name="subject" id="subject" size="50" /></td>
		  </tr>
		  
		  <tr>
		     <td class="text">Message </td>
			 <td><textarea name="message" id="message" rows="10" cols="60" ></textarea>
			 
			 </td>
		  </tr>
		   <tr>
		  	<td class="text">Sending Option</td>
			<td class="text">
				<input type="radio" name="sendingoption" id="sendingoption1" value="all" checked onclick="showsendingoption(this);" />&nbsp;<strong>ALL</strong>
				<input type="radio" name="sendingoption" id="sendingoption2" value="userwise" onclick="showsendingoption(this);"  />&nbsp;<strong>User Wise</strong>
			</td>
		  </tr>
		  <tr>
			<td class="text">News Letter </td>
			<td lign="center">
			<div id="limitdiv">
			<select name=maillimit id=maillimit>
				<option value="">-- Mail Limit --</option>
				<option value="20">20</option>
				<option value="40">40</option>
				<option value="80">80</option>
				<option value="100">100</option>
				<option value="200">200</option>
				<option value="300">300</option>
				<option value="400">400</option>
				<option value="500">500</option>
			</select>
			</div>
			<div id="textboddiv" style="display:none;">
				<table width="80%" border="0" cellspacing="0" cellpadding="0">
		           <tr>
				   	<td width="45%" align="center">
						<select size="10" name="masteremail[]" id="masteremail" multiple="multiple">
							<?php
								$sql_email="select email from tbl_subscription where sstatus='Y'";
								$rs_email=mysql_query($sql_email) or die(mysql_error());
								while($data_email=mysql_fetch_array($rs_email))
									echo '<option value="'.$data_email["email"].'">'.$data_email["email"].'</option>';
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
		  <td>&nbsp;</td>
		  <td align="center" id="mailresetdiv" class="text">
			&nbsp;&nbsp;<strong>Mail Send</strong>&nbsp; : &nbsp;<?php echo $mail_send; ?>
			&nbsp;&nbsp;<strong>Remail Mail</strong>&nbsp; : &nbsp;<?php echo $mail_not_send; ?>
		  </td></tr>
		  <tr>
		     <td align="center" colspan="2">
			   <input type="image"  src="images/send.gif" alt="submit"  border="0" name="btnsendnewsletter" value="S E N D"  style="cursor:pointer;" onclick="allSelected()" />
            <input type="hidden" name="btnsendnewsletter" value="add" />
            &nbsp;&nbsp;
            <input  type="image"  src="images/reset.gif" alt="clear" border="0" onclick="return resetSubscriber();"  value="Reset Subscriber" style="cursor:pointer;" />

			 </td>
		  </tr>



     
    </table>
        <br />
	</td>
  </tr>
</table>

</form>
<br />
<br />
<?php admin_footer(); ?>
</center>
</body>
</html>
