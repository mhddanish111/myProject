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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin:: 47th Diamond District Corp.</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery.js"></script>
</head>
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
          <ul>
            <li><a  href="#"><strong>Manage Category</strong></a>
                <ul>
                  <li><a href="add-category.html">Add Category</a></li>
                  <li><a href="list-category.html">List Category</a></li>
                </ul>
            </li>
            <li><a  href="#" class="currentnavi"><strong>Manage Subcategory</strong></a>
                <ul>
                  <li><a href="add-subategory.html">Add Sub Category</a></li>
                  <li><a href="list-subategory.html">List Sub Category</a></li>
                </ul>
            </li>
            <li><a  href="#" ><strong>Manage Products </strong></a>
                <ul>
                  <li><a href="add-product.html">Add Product</a></li>
                  <li><a href="list-subategory.html">List Product</a></li>
                </ul>
            </li>
            <li><strong><a href="">CMS Pages </a></strong>
                <ul>
                  <li><a href="home.html">Home</a></li>
                  <li><a href="about-us.html">About Us</a></li>
                  <li><a href="contact-us.html">contact Us</a></li>
                </ul>
            </li>
          </ul>
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
  <table width="90%" height="33" border="0" cellpadding="6" cellspacing="0">
    <tr>
      <td><h1>&nbsp;</h1></td>
      <td align="right"><a href="#" class="blink2">Home</a>&nbsp;&nbsp; <a href="#" class="blink2">Change Password</a>&nbsp;&nbsp; <a href="#" class="blink2">Logout</a> </td>
    </tr>
  </table>
  <br />
<br />
<br />
<table width="90%" height="33" border="0" cellpadding="6" cellspacing="0" class="text1">
  <tr>
    <td><h1><font color="#6B6B6B">List  Sub Category</font></h1></td>
    <td align="right"><a href="#"></a></td>
  </tr>
</table>
<table width="90%" border="0" cellpadding="3" cellspacing="1" class="text1">
  <tr class="text">
    <td height="33" align="center" valign="top" bgcolor="#FFFFFF"><table width="50%" border="0" cellpadding="3" cellspacing="1" bgcolor="#3A1F08" class="text1">
      <tr class="text">
        <td height="33" align="left"><font color="#6B6B6B" class="text"><strong>Category</strong></font></td>
        <td align="left"><strong>Sub</strong> <font color="#6B6B6B" class="text"><strong>Category</strong></font></td>
        <td width="100" align="center"><strong>View </strong></td>
        <td width="50" align="center"><strong>Status </strong></td>
        <td width="50" align="center"><strong>Edit</strong></td>
        <td width="50" align="center"><input type="checkbox" name="checkbox322" value="checkbox" /></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#FFFFFF">Antique Jewelry</td>
        <td align="left" bgcolor="#FFFFFF"><font color="#6B6B6B">(2)</font></td>
        <td align="center" bgcolor="#FFFFFF"><a href="view-list-subategory.html" class="blink">view</a></td>
        <td align="center" bgcolor="#FFFFFF"><img src="images/publish.jpg" alt="publish" width="15" height="16" /></td>
        <td align="center" bgcolor="#FFFFFF"><a href="edit-subcategory.html"><img src="images/edit.gif" alt="edit" width="16" height="13" border="0" /></a></td>
        <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="checkbox323" value="checkbox" /></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#FFFFFF">New Jewelry</td>
        <td align="left" bgcolor="#FFFFFF"><font color="#6B6B6B">(10)</font></td>
        <td align="center" bgcolor="#FFFFFF"><a href="view-list-subategory.html" class="blink">view</a></td>
        <td align="center" bgcolor="#FFFFFF"><img src="images/delete.jpg" alt="in active" width="15" height="16" /></td>
        <td align="center" bgcolor="#FFFFFF"><a href="edit-subcategory"><img src="images/edit.gif" alt="edit" width="16" height="13" border="0" /></a></td>
        <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="checkbox324" value="checkbox" /></td>
      </tr>
    </table>
      <br />
        <br /></td>
  </tr>
</table>
<br />
<table width="50%" height="33" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td></td>
    <td align="right"><a href="#"><input type="image" src="images/publish.gif" alt="visibility"  name="publishsubsubcat" id="publishsubsubcat" width="65" height="26" border="0" /></a></td>
    <td width="70" align="right"><a href="#"><input type="image" name="deltesubsubcat" id="deltesubsubcat" src="images/delete.gif" alt="delete" width="65" height="26" border="0" /></a></td>
  </tr>
</table>
<br />
<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="text1">
  <tr>
    <td align="center">Copyright &copy; 2011. 47th Diamond District Corp.</td>
  </tr>
</table>
</center>
</body>
</html>
