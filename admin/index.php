<?php
session_start();
//include("page-add.php");
include("../include/connect.php");
if(isset($_POST['adminlogin_x']))
{
	
	 $username=$_POST['textfield22'];
	 $password=$_POST['textfield222'];
	$sql="select * from admin where admin_id='$username' and admin_password='$password'";
	$chk123=mysql_query($sql) or die(mysql_error());
	$numrows=mysql_num_rows($chk123);
	if($numrows>0)
	{
		$data=mysql_fetch_array($chk123);
		$_SESSION['AdminId']=$data['admin_id'];
		$_SESSION['UserName']=$data['username'];
		$upqr=mysql_query("update admin set lastlogin='".date("Y-m-d, H:i:s")."' where admin_id='".$_SESSION['AdminId']."'");
		echo "<script>window.location.href='welcome-admin.php';</script>";
	}
	else
	{
		$_SESSION['msg']="Invalid Login!";
	}
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin:: 47th Diamond District Corp.</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="#F5F3E3">
<center>
  <br />
<br />
<br />
<br />
<br />
<br />
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" name="adminsub" method="post">
<table width="749" height="382" border="0" cellpadding="0" cellspacing="0" class="text">
<?php 
			  if(isset($_SESSION['msg']))
			  {
			  ?>
            <tr>
              <td colspan="4" align="center" class="registration"><strong><font color="#FF0000"><?php echo $_SESSION['msg'];
			  																								unset($_SESSION['msg']);
																								?>
																								</font></strong>
			</td>
            </tr>
			<?php } ?>
  <tr>
    <td align="center" background="images/index-bg.png"><br />
      <br />
        <br />
        <table width="520" border="0" cellpadding="0" cellspacing="0" class="text1">
      <tr>
        <td height="44" colspan="4" align="left"><h1>Admin Login</h1> </td>
          </tr>
      <tr>
        <td width="60" height="30" align="left">User ID </td>
          <td align="left"><label>
            <input name="textfield22" type="text" class="inp" size="30" />
            </label></td>
          <td width="80" align="right">Password</td>
          <td align="right"><input name="textfield222" type="password" class="inp" size="30" /></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right"><input type="image" src="images/submit.gif" alt="submit" width="76" height="27" border="0" name="adminlogin" /></td>
        </tr>
    </table></td>
  </tr>
</table></form>
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
