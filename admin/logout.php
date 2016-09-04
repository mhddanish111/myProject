<?php  session_start();
if($_SESSION['AdminId']=="")
{
echo "<script>window.location.href='index.php';</script>";
}
/*include('../connect.php');
      $upqr=mysql_query("update yp_admin set logouttime='".time()."',islogin='0' where admin_id='".$_SESSION['AdminId']."'");*/
       unset($_SESSION);
	   session_destroy();
       echo "<script>window.location.href='index.php';</script>";

?>