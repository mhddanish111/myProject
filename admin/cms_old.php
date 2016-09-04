<?php
session_start();
include("page-add.php");
include("../include/connect.php");
include("../db/db.php");
if($_SESSION['AdminId']=="")
{
	echo "<script>window.location.href='index.php';</script>";
}
$id=$_GET['id'];
$rs = rs_select("cmscontent where id='$id'","*");
$result = mysql_fetch_assoc($rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin:: 47th Diamond District Corp.</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="js/validation.js" language="javascript"></script>
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
<?php echo admin_nav();?>
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
    <td><h1><font color="#6B6B6B"><?php echo $result['title']; ?></font></h1></td>
    <td align="right"><a href="#"></a></td>
  </tr>
</table>
<table width="90%" border="0" cellpadding="3" cellspacing="1" class="text1">
  <tr class="text">
    <td height="33" align="center" valign="top" bgcolor="#FFFFFF"><table width="50%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top"><form action="dbfunction.php" enctype="multipart/form-data" method="post">
		<table width="750" border="0" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF" class="text1">
          <tr>
            <td width="145">English Content :</td>
            <td width="590" align="center"><!--<textarea name="contact_us" id="contact_us"><?php //echo stripslashes($result['content']); ?> </textarea><script language="JavaScript" type="text/javascript">generate_wysiwyg("contact_us");</script> -->
			
			<?php
					include("../FCK/fckeditor.php");
		
					$sBasePath = "../FCK/";
					$oFCKeditor = new FCKeditor('contact_us');
					$oFCKeditor->BasePath = $sBasePath;
				
					$oFCKeditor->Value = stripslashes($result["content"]);
					$oFCKeditor->Height = "400";
					$oFCKeditor->Width= "800";
					echo $fck=$oFCKeditor->Create();
					?>
			</td>
          </tr>
		  <tr>
            <td width="145">Japanese Content :</td>
            <td width="490" align="center"><!--<textarea name="contact_usr" id="contact_usr"><?php // echo stripslashes($result['jacontent']); ?> </textarea><script language="JavaScript" type="text/javascript">generate_wysiwyg("contact_usr");</script> -->
			<?php
					include("../FCK/fckeditor.php");
		
					$sBasePath = "../FCK/";
					$oFCKeditor = new FCKeditor('contact_usr');
					$oFCKeditor->BasePath = $sBasePath;
				
					$oFCKeditor->Value = stripslashes($result["jacontent"]);
					$oFCKeditor->Height = "400";
					$oFCKeditor->Width= "800";
					echo $fck=$oFCKeditor->Create();
					?>
			</td>
          </tr>
          <tr>
            <td height="48" colspan="2" align="center"><br />
              <table width="240" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center"><input type="image" src="images/save.gif" alt="submit" name="homesubmit" width="99" height="30" border="0" /></td>
                <td align="center"><a href="welcome-admin.php"><img src="images/cancel.gif" alt="clear" width="99" height="30" border="0" /></a></td>
              </tr>
            </table>              <label></label></td>
            </tr>
        </table>
		<input type="hidden" name="id" value="<?php echo $id; ?>"  /> </form></td>
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
