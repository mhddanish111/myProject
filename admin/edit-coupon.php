<?php
session_start();
include("page-add.php");
include("../include/connect.php");
include("../db/db.php");
if($_SESSION['AdminId']=="")
{
echo "<script>window.location.href='index.php';</script>";
}
$editid = $_REQUEST['editid'];
$sql = rs_select("coupons where id ='$editid'","*");
$res = mysql_fetch_assoc($sql);
$status = $res['status']=="Y"?"checked":"";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin:: 47th Diamond District Corp.</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
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
    <td><h1><font color="#6B6B6B">E</font><font color="#6B6B6B">dit Offer Coupons</font></h1></td>
    <td align="right"><a href="#"></a></td>
  </tr>
</table>
<table width="90%" border="0" cellpadding="3" cellspacing="1" class="text1">
  <tr class="text">
    <td height="33" align="center" valign="top" bgcolor="#FFFFFF"><table width="50%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top"><form action="dbfunction.php" enctype="multipart/form-data" method="post">
		<table width="551" border="0" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF" class="text1">
		<tr>
		  	<td>Coupon Code</td>
		     <td><input type="text" name="couponcode" id="couponcode" class="inp2" value="<?php echo $res['couponid']; ?>" maxlength="19" /></td>
		  </tr>
          <tr>
            <td width="163">Coupons <font color="#6B6B6B">Name</font>:</td>
            <td width="260" height="48" align="left" ><label></label>
                    <input name="textfield22" type="text" class="inp2"  id="textfield22" onchange="getServerResponse('catdiv','AjaxHandler.php?query=checkcoupon&dublicate='+this.value,'',false)" value="<?php echo stripslashes($res['name']); ?>" /></td><td width="108"><div id="catdiv" style="color:#FF0000"></div></td>
          </tr>
		  <tr>
            <td width="163" >Coupons <font color="#6B6B6B">Message</font>:</td>
            <td height="48" align="left" colspan="2" ><textarea name="message" id="message" rows="4" cols="28"><?php echo stripslashes($res['message']); ?></textarea></td>
          </tr>
		  <tr>
            <td width="163" >Coupons <font color="#6B6B6B">Amount</font>:</td>
            <td height="48" align="left" colspan="2" ><label></label>
                    $&nbsp;<input name="amount" type="text" class="inp2"  id="amount" value="<?php echo stripslashes($res['amount']); ?>"  /></td>
          </tr>
		  <tr>
            <td>Publish:</td>
            <td width="262" height="48" align="left">              <label>
                <input type="checkbox" name="checkbox" value="checkbox" <?php echo $status; ?>/>
                </label>            </td>
          </tr>
		  <tr>
            <td height="48" colspan="2" align="center"><br />
              <table width="240" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center"><input type="image" src="images/save.gif" alt="submit" name="editcoupon" width="99" height="30" border="0" onclick="return addcoupon();" /></td>
                <td align="center"><a style="cursor:pointer"><img src="images/cancel.gif" alt="clear" width="99" height="30" border="0" onclick="history.back(-1);" /></a></td>
              </tr>
            </table>              <label></label></td>
            </tr>
        </table>
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page']?>"  />
		<input type="hidden" name="id" value="<?php echo $_REQUEST['editid']; ?>" /></form></td>
        </tr>
    </table>
        <br />
        <br /></td>
  </tr>
</table>
<br />
<br />
<br />
<?php echo  admin_footer(); ?>
</center>
</body>
</html>
