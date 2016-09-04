<?php
session_start();
include("page-add.php");
include("../include/connect.php");
include("../db/db.php");
if($_SESSION['AdminId']=="")
{
echo "<script>window.location.href='index.php';</script>";
}

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
    <td><h1><font color="#6B6B6B">A</font><font color="#6B6B6B">dd Category</font></h1></td>
    <td align="right"><a href="#"></a></td>
  </tr>
</table>
<table width="90%" border="0" cellpadding="3" cellspacing="1" class="text1">
  <tr class="text">
    <td height="33" align="center" valign="top" bgcolor="#FFFFFF"><table width="50%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top"><form action="dbfunction.php" enctype="multipart/form-data" method="post">
		<table width="520" border="0" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF" class="text1">
          <tr>
            <td width="100">Add <font color="#6B6B6B">Category</font>:</td>
            <td width="262" height="48" align="left" ><label></label>
                    <input name="textfield22" type="text" class="inp2"  id="textfield22" onblur="getServerResponse('catdiv','AjaxHandler.php?query=checkcat&dublicate='+this.value,'',false)" /></td><td width="156"><div id="catdiv" style="color:#FF0000"></div></td>
          </tr>
		  <tr>
            <td width="120"><font color="#6B6B6B">追加 カテゴリ:</font></td>
            <td width="262" height="48" align="left" ><label></label>
                    <input name="jatextfield22" type="text" class="inp2"  id="jatextfield22" /></td><td width="156"><div id="catdiv1" style="color:#FF0000"></div></td>
          </tr>
		  <tr>
            <td width="120"><font color="#6B6B6B">Title</font></td>
            <td width="262" height="48" align="left" colspan="2" ><label></label>
                    <input name="title" type="text" class="inp2"  id="title"/></td>
          </tr>
		  <tr>
            <td width="120"><font color="#6B6B6B">Japense Title</font></td>
            <td width="262" height="48" align="left" colspan="2" ><label></label>
                    <input name="jatitle" type="text" class="inp2"  id="jatitle"/></td>
          </tr>
		  <tr>
            <td width="120"><font color="#6B6B6B">Keywords</font></td>
            <td width="262" height="48" align="left" colspan="2" ><label></label>
                  <textarea name="keywords" class="inp5" cols="45" rows="4"  id="keywords"></textarea></td>
          </tr>
		  <tr>
            <td width="120"><font color="#6B6B6B">Japense Keywords</font></td>
            <td width="262" height="48" align="left" colspan="2" ><label></label>
                  <textarea name="jakeywords" class="inp5" cols="45" rows="4"  id="jakeywords"></textarea></td>
          </tr>
		   <tr>
            <td width="120"><font color="#6B6B6B">Seo Description</font></td>
            <td width="262" height="48" align="left" colspan="2" ><label></label>
                    <textarea name="seodescription" class="inp5" cols="45" rows="4"  id="seodescription"></textarea></td>
          </tr>
		   <tr>
            <td width="120"><font color="#6B6B6B">Japense Seo Description</font></td>
            <td width="262" height="48" align="left" colspan="2" ><label></label>
                    <textarea name="jaseodescription" class="inp5" cols="45" rows="4"  id="jaseodescription"></textarea></td>
          </tr>
          <tr>
            <td>Publish:</td>
            <td width="262" height="48" align="left">              <label>
                <input type="checkbox" name="checkbox" value="checkbox" checked="checked" />
                </label>            </td>
          </tr>
          <tr>
            <td height="48" colspan="2" align="center"><br />
              <table width="240" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center"><input type="image" src="images/save.gif" alt="submit" name="catadd" width="99" height="30" border="0" onclick="return addcat();" /></td>
                <td align="center"><a style="cursor:pointer"><img src="images/cancel.gif" alt="clear" width="99" height="30" border="0" onclick="history.back(-1);" /></a></td>
              </tr>
            </table>              <label></label></td>
            </tr>
        </table></form></td>
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
