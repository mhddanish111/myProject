<?php
session_start();
include("page-add.php");
include("../include/connect.php");
include("../db/db.php");
$total=0;
if($_SESSION['AdminId']=="")
{
echo "<script>window.location.href='index.php';</script>";
}
$imagepath = "../gallery/large/";
$ordernum=$_GET['ordernum'];

$selorder  = mysql_query("select itemorder.*,shipbilldetail.* from itemorder join shipbilldetail on itemorder.userid = shipbilldetail.userid where itemorder.order_number= '$ordernum'");


/*$selorder=mysql_query("select * from itemorder where order_number='$ordernum'");*/
$getorder=mysql_fetch_array($selorder);
$total = $total+$getorder['total_price'] + $getorder['tax']+$getorder['shipingcharge']-$getorder['couponamount'];
$userid=$getorder['userid'];
/*$selcust=mysql_query("select * from shipbilldetail where userid='$userid'");
$getcust=mysql_fetch_array($selcust);*/
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
 <!-- <br />
  <table width="320" border="0" cellpadding="6" cellspacing="0" bgcolor="#3A1F08" class="text">
    <tr>
      <td align="right">&nbsp;</td>
      <td width="220" align="left"><label></label></td>
    </tr>
    <tr>
      <td align="right">Keyword</td>
      <td width="200" align="left"><label>
        <input name="textfield" type="text" class="inp" value="Search by order numbers" size="35" />
      </label></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td align="left"><label><a href="#"><img src="images/search.gif" alt="search" width="81" height="26" border="0" /></a></label></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
  </table>
  <br />
<br />-->
<table width="90%" height="33" border="0" cellpadding="6" cellspacing="0" class="text1">
  <tr>
    <td><h1><font color="#6B6B6B">View Order Detail </font></h1></td>
    <td align="right"><a href="list-orders.php" class="blink"><strong>Back</strong></a></td>
  </tr>
</table>
<table width="90%" border="0" cellpadding="3" cellspacing="1" class="text1">
  <tr class="text">
    <td height="33" align="center" valign="top" bgcolor="#FFFFFF"><table width="90%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top"><table width="450" border="0" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF" class="text1">
          <tr>
            <td>Order Number :</td>
            <td width="262" height="48" align="left"><strong><?php echo $getorder['order_number']; ?></strong></td>
          </tr>
          <tr>
            <td>Order Date :</td>
            <td width="262" height="48" align="left"><strong><?php echo $getorder['order_date']; ?> </strong></td>
          </tr>
          <tr>
            <td>Full Name : </td>
            <td height="48" align="left"><strong><?php echo $getorder['BillCustName']; ?></strong></td>
          </tr>
          <tr>
            <td>Email  : </td>
            <td width="262" height="48" align="left"><strong><?php echo $getorder['CustEmail']; ?></strong></td>
          </tr>
          <tr>
            <td>Phone:</td>
            <td height="48" align="left"><strong><?php echo $getorder['BillCustPhone']; ?></strong></td>
          </tr>
		  <tr>
            <td>Sub Total  : </td>
            <td width="262" height="48" align="left"><strong>$<?php echo $getorder['total_price']; ?></strong></td>
          </tr>
		  <tr>
            <td>Shiping Charge  : </td>
            <td width="262" height="48" align="left"><strong>$<?php echo $getorder['shipingcharge']; ?></strong></td>
          </tr>
		  
        </table></td>
        <td valign="top"><table width="450" border="0" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF" class="text1">
		<tr>
            <td>Tax : </td>
            <td width="262" height="48" align="left"><strong>$<?php echo $getorder['tax']; ?></strong></td>
          </tr>
          <tr>
		  <tr>
            <td>Coupon amount : </td>
            <td width="262" height="48" align="left"><strong>$<?php echo $getorder['couponamount']; ?></strong></td>
          </tr>
          <tr>
          <tr>
            <td>Total Price : </td>
            <td width="262" height="48" align="left"><strong>$<?php echo $total; ?></strong></td>
          </tr>
          <tr>
            <td>Shipping status : </td>
            <td height="48" align="left"><strong><?php echo $getorder['shipping_staus']; ?></strong></td>
          </tr>
		  <tr>
            <td>Shipping date:</td>
            <td height="48" align="left"><strong><?php if($getorder['shipdate']=='') echo 'Not Shipped'; else echo $getorder['shipdate']; ?></strong></td>
          </tr>
          <tr>
            <td>Mode of Payment: </td>
            <td height="48" align="left"><strong><?php echo $getorder['payment_mode']; ?></strong></td>
          </tr>
          <tr>
            <td height="70">Shipping Address :</td>
            <td align="left"><strong><?php echo stripslashes($getorder['ShipCustAddress']." ".$getorder['ShipCustAddress1']." ".$getorder['ShipCustCity']." ".$getorder['ShipCustState']." ".$getorder['ShipCustZIPCode']." ".$getorder['ShipCustCountry']); ?></strong></td>
          </tr>
          <tr>
            <td height="70">Billing  Address :</td>
            <td align="left"><strong><?php echo stripslashes($getorder['BillCustAddress']." ".$getorder['BillCustAddress1']. " ".$getorder['BillCustCity']." ".$getorder['BillCustState']." ".$getorder['BillCustZIPCode']." ".$getorder['BillCustCountry']); ?></strong></td>
          </tr>
        </table></td>
      </tr>
    </table>
        <br />
        <br />
        <table width="90%" border="0" cellpadding="3" cellspacing="1" bgcolor="#3A1F08" class="text1">
          <tr class="text">
            <td height="33" align="left"><strong>Item</strong></td>
			<td width="150" align="center"><strong>Shiping Charge</strong></td>
            <td width="150" align="center"><strong>Quantity</strong></td>
            <td width="150" align="center"><strong>Value in US $</strong></td>
          </tr>
          <?php 
		  $selorderdet=mysql_query("select item_order_detail.*,product.imagepath from item_order_detail join product on item_order_detail.itemid =  product.id where item_order_detail.order_number='$ordernum'");
		  while($getorderdet=mysql_fetch_array($selorderdet))
		  {
		 // $selprod=mysql_query("select imagepath from product where id='".$getorderdet['itemid']."'");
		  //$new_result=mysql_fetch_array($selprod);
		  ?>
          <tr>
            <td align="left" valign="top" bordercolor="0" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="80" height="86"><img src="<?php echo $imagepath.$getorderdet['imagepath']; ?>" width="57" height="73" /></td>
                  <td><?php echo $getorderdet['item']; ?></td>
                </tr>
            </table></td>
            <td align="center" bgcolor="#FFFFFF">$<?php echo $getorderdet['productshipingcharge']; ?></td>
			<td align="center" bgcolor="#FFFFFF"><?php echo $getorderdet['item_qty']; ?></td>
            <td align="center" bgcolor="#FFFFFF">$<?php echo $getorderdet['item_value']; ?></td>
          </tr>
		  <?php } ?>
      </table></td>
  </tr>
</table>
<br />
<br />
<br />
<?php echo  admin_footer(); ?>
</center>
</body>
</html>
