<?php
session_start();
include("page-add.php");
include("../include/connect.php");
if($_SESSION['AdminId']=="")
{
echo "<script>window.location.href='index.php';</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin:: 47th Diamond District Corp.</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery.js"></script></head>
</head>

<body bgcolor="#F5F3E3">
<center>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#331C09" class="text">
    <tr>
      <td width="300" align="center" bgcolor="#331C09"><img src="images/logo.gif" alt="logo" width="286" height="97" /></td>
      <td align="right" bgcolor="#331C09">&nbsp;</td>
      <td width="150" bgcolor="#331C09"><h2><font color="#EEDD8F">Admin Panel</font></h2></td>
    </tr>
  </table>
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
  <?php echo admin_right_nav(); ?>
  <br />
<br />
<br />
<table width="749" height="382" border="0" cellpadding="0" cellspacing="0" class="text">
  <tr>
    <td align="center" background="images/welcome.png">&nbsp;</td>
  </tr>
</table>
<?php  echo admin_footer(); ?>
<br />
<br />
</center>
</body>
</html>
