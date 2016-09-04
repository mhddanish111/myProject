<?php
session_start();
include("page-add.php");
include("../include/connect.php");
include("../db/db.php");
if($_SESSION['AdminId']=="")
{
echo "<script>window.location.href='index.php';</script>";
}

$morepro = rs_select("moreproduct where id ='".$_REQUEST['fieldid']."'","*");
$moreres = mysql_fetch_assoc($morepro);
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
    <td><h1><font color="#6B6B6B">E</font><font color="#6B6B6B">dit More Field</font></h1></td>
    <td align="right"><a href="manage-morefield.php?productname=<?php echo $_REQUEST['productname']; ?>" class="blink"><strong>Manage More field</strong></a></td>
  </tr>
</table>
<table width="90%" border="0" cellpadding="3" cellspacing="1" class="text1">
  <tr class="text">
    <td height="33" align="center" valign="top" bgcolor="#FFFFFF"><table width="50%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top"><form action="dbfunction.php" enctype="multipart/form-data" method="post">
		<table width="550" border="0" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF" class="text1">
		
          <tr>
              <td colspan="2" id="moreproducttd">
			  <div style="padding-bottom:5px; overflow:auto;">
				<div style="float:left; width:25%;">Name </div>
				 <div style="float:left; width:25%;">Value</div>
				 <div style="float:left; width:25%;">の名前 </div>
				 <div style="float:left; width:25%;">の値</div>
				 </div>
			  <div style="padding-bottom:10px; overflow:auto;">
				<div style="float:left; width:25%;"><input type="text" class="inp22" name="order_item_0" id="order_item_0" value="<?php echo stripslashes($moreres['fieldname']); ?>" /></div>
				 <div style="float:left; width:25%;"><input type="text" class="inp22" name="order_value_0" id="order_value_0" value="<?php echo stripslashes($moreres['fieldvalue']); ?>"  /></div>
				 <div style="float:left; width:25%;"><input type="text" class="inp22" name="jaorder_item_0" id="jaorder_item_0" value="<?php echo stripslashes($moreres['jafieldname']); ?>" /></div>
				 <div style="float:left; width:25%;"><input type="text" class="inp22" name="jaorder_value_0" id="jaorder_value_0" value="<?php echo stripslashes($moreres['jafieldvalue']); ?>"  /></div>
				 </div>
			</td></tr>
			<tr>
            <td height="48" colspan="2" align="center"><br />
              <table width="240" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center"><input type="image" src="images/save.gif" alt="submit" name="editMoreField" width="99" height="30" border="0" onclick="return editMore();" /></td>
                <td align="center"><img src="images/cancel.gif" alt="clear" width="99" height="30" border="0" onclick="history.back(-1);" style="cursor:pointer" /></td>
              </tr>
            </table>              <label></label></td>
            </tr>
        </table>
        <input type="hidden" name="productname" value="<?php echo $_REQUEST['productname'] ?>"  />
		<input type="hidden" name="fieldid" value="<?php echo $_REQUEST['fieldid'] ?>"  /></form></td>
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
