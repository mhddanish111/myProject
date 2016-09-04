<?php
function admin_footer()
{
	echo'<table width="100%" border="0" cellpadding="0" cellspacing="0" class="text1">
  <tr>
    <td align="center">Copyright &copy; 2011. 47th Diamond District Corp.</td>
  </tr>
</table>';
}
function admin_right_nav()
{
	echo'<table width="90%" height="33" border="0" cellpadding="6" cellspacing="0">
    <tr>
      <td><h1>&nbsp;</h1></td>
      <td align="right"><a href="welcome-admin.php" class="blink2">Home</a>&nbsp;&nbsp; <a href="change-password.php" class="blink2">Change Password</a>&nbsp;&nbsp; <a href="logout.php" class="blink2">Logout</a> </td>
    </tr>
  </table>';
}
function admin_top()
{
	echo'<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#331C09" class="text">
    <tr>
      <td width="300" align="center" bgcolor="#331C09"><img src="images/logo.gif" alt="logo" width="286" height="97" /></td>
      <td align="right" bgcolor="#331C09">&nbsp;</td>
      <td width="150" bgcolor="#331C09"><h2><font color="#EEDD8F">Admin Panel</font></h2></td>
    </tr>
  </table>';
}
function admin_nav()
{
	echo'<ul>
			<li><a  href="#"><strong>Manage Users </strong></a>
                <ul>
                  <li><a href="list-users.php">List User</a></li>
                </ul>
            </li>
            <li><a  href="#"><strong>Manage Category</strong></a>
                <ul>
                  <li><a href="add-category.php">Add Category</a></li>
                  <li><a href="list-category.php">List Category</a></li>
				</ul>
            </li>
            <li><a  href="#"><strong>Manage Subcategory</strong></a>
                <ul>
                  <li><a href="add-subcategory.php">Add Sub Category</a></li>
                  <li><a href="list-subcategory.php">List Sub Category</a></li>
				  </ul>
            </li>
			<li><a  href="#" ><strong>Manage Products </strong></a>
                <ul>
                  <li><a href="add-product.php">Add Product</a></li>
                  <li><a href="list-subcategory.php">List Product</a></li></ul>
            </li>
			
            <li><strong><a href="#">CMS Pages </a></strong>
                <ul>';
				$selcms=mysql_query("select * from cmscontent");
				while($getcms=mysql_fetch_array($selcms))
				{
                 echo  '<li><a href="cms.php?id='.$getcms['id'].'">'.$getcms['title'].'</a></li>';
                }
               echo  '</ul>
            </li>
			<li><a  href="#"><strong>Manage Orders </strong></a>
                <ul>
                  <li><a href="list-orders.php">List Orders</a></li>
                </ul>
            </li>
			<li><strong><a href="#" >Mailing List</a></strong>
                <ul>
                  <li><a href="managesubscribeuser.php">Subscribe User</a></li>
                  <li><a href="managenewsletter.php">Send News Letter</a></li>
                 </ul>
            </li>
			<li><strong><a href="#" >Coupons</a></strong>
                <ul>
                  <li><a href="add-coupon.php">Add Coupans</a></li>
				  <li><a href="list-coupon.php">list Coupans</a></li>
                  <li><a href="sendcoupon.php">Send Coupans</a></li>
				  <li><a href="sendcouponlist.php">Send Coupans list</a></li>
                 </ul>
            </li>
          </ul>';
}
?>

      
    