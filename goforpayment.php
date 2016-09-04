<?php
session_start();
//$pagenav=4;
$pagenavsub=2;
include("include/connect.php");
include("include/page-add.php"); 
include("db/db.php");
$url=$_SERVER['REQUEST_URI'];
$abspath = findAbs($url);
if(!isset($_SESSION["CustEmail"]))
{
	header("location:index.html");
	exit;
}

if(!isset($_SESSION['cart_item'])){
	header("location:index.html");
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php echo showTitleFab($pagenav); ?>
<link href="style.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />

<script src="js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/main.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="javascript2/style.css">
<script type="text/javascript" src="javascript2/jquery_003.js"></script>
<script type="text/javascript" src="javascript2/easySlider1.js"></script>
<script type="text/javascript" src="javascript2/jquery.js"></script>
<script type="text/javascript" src="javascript2/this-theme.js"></script>
<script type="text/javascript" src="js/svb.js"></script>
<?php echo metaDescription($pagenav); ?>
</head>

<body>

<!-- Web Design & Developed by: http://www.webtimeinc.com -->

<!-- Top Start//-->
<div id="top-main">
<div id="top">
<?php echo logo($abspath); ?>
<div id="top-right">
<?php echo language($abspath); ?> 
<div id="top-links">
<div id="navi-panel">
          <?php echo nav($abspath) ;?> 
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
      </div>
</div>
</div>
</div>
</div>
<!-- Top End//-->

<!-- welcome start//-->
<div id="welcome-ddc-box">
<div id="thanks-box">
<div class="billing-box">
<div class="confirm-heading"><strong>
  Please Wait Connecting For Payment...
</strong></div>
</div>
<div class="thanks-text">
  <br />
  <br />
    
  <img src="images/progress_dots.gif" border="0" />
  
  <?php
  $date = date("m/d/Y");
  $date1 = date("m/d/Y");
// sending mail ti new user
$count = mysql_query("select price,qty,productname from cart where session_id = '".session_id()."'");
$product = 0;
$amount =0;
//$paymode = $_REQUEST['offlinetype'];
$i=0;
while($countres = mysql_fetch_assoc($count))
{
	$amount = $amount + ($countres['qty'] * $countres['price']);
	$product = $product + $countres['qty'];	
		
}
//$sql="update `sendcoupon` set flag='Y',usedate='".$date1."' where userid=".$_SESSION["CustEmail"];//update send coupon status used by client;
$ins = rs_insert("itemorder","order_number,userid,order_date,payment_mode,total_price,payment_staus,shipping_staus,	shipingcharge,couponamount,tax","'".$_SESSION['orderid']."','".$_SESSION["userid"]."','".$date."','Paypal','".$amount."','Pending','Pending','".$_SESSION['shipcharge']."','".$_SESSION['couponamount']."','".$_SESSION['tax']."'");
						#/////////// Insert value in item_order_detail ######################
$selcard = mysql_query("SELECT IF( sd.ShipCustCountry =  'U.S.A.', p.shipchargedom, p.shipchargeint ) AS ship, crt.productname, crt.qty,crt.productid, crt.price FROM product AS p,shipbilldetail AS sd, cart AS crt WHERE p.id = crt.productid AND crt.session_id =  '".session_id()."' AND sd.userid =  '".$_SESSION["userid"]."'");
$items='';
$cnt=1;
while($cardresult = mysql_fetch_assoc($selcard))
{
	$insetorder = mysql_query("insert into item_order_detail(order_number,itemid,item,item_value,item_qty,productshipingcharge) values('".$_SESSION['orderid']."','".$cardresult['productid']."','".$cardresult['productname']."','".$cardresult['price']."','".$cardresult['qty']."','".$cardresult['ship']."')");
	//$updateprodqty=mysql_query("update product set productstock=productstock-'".$cardresult['qty']."' where productid='".$cardresult['productid']."'");
	//$updateprodqty=mysql_query("update product set soldproduct=soldproduct +'".$cardresult['qty']."' where productid='".$cardresult['productid']."'");
	
	$items.="<input type='hidden' name='item_name_".$cnt."' value='".$cardresult['productname']."' id='item_name_".$cnt."'>";
	$items.="<input type='hidden' name='amount_".$cnt."' value='".$cardresult['price']."' id='amount_".$cnt."'>";
	$items.="<input type='hidden' name='quantity_".$cnt."' value='".$cardresult['qty']."' id='quantity_".$cnt."'>";
$cnt++;
}
unset($_SESSION['cart_item']);
$del = mysql_query("select productid from cart where session_id='".session_id()."'");
while($res = mysql_fetch_assoc($del))
{
	$product_id = $res['productid'];
	unset($_SESSION["incart_".$product_id]);
}
//$sel = mysql_query("delete from cart where session_id='".session_id()."'");

//***************** MAKING HTML FORM FOR PAYMNET ***************

$sql="select BillCustName,BillCustLastName,BillCustEmail,BillCustPhone,BillCustAddress,BillCustCity, ".
		" BillCustState,BillCustZIPCode,BillCustCountry from shipbilldetail where CustEmail='".$_SESSION["CustEmail"]."'";
	$rs=mysql_query($sql) or die(mysql_error());
	$BillData=mysql_fetch_array($rs);	
	
 $returnUrl="http://47ddc.com/ConfirmPayment.php?opt=success&invoiceId=".$_SESSION['orderid'];
 $cancelUrl="http://47ddc.com/ConfirmPayment.php?opt=cancel&invoiceId=".$_SESSION['orderid'];
 $invoiceId=$_SESSION['orderid'];

	$form='<input type="hidden" name="cmd" value="_cart">
	<input type="hidden" name="upload" value="1">

	<input type="hidden" name="business" value="shinmeigu@aol.com">
	<input type="hidden" name="no_shipping" value="0">
	<input type="hidden" name="no_note" value="1">
	<input type="hidden" name="currency_code" value="USD">
	<input type="hidden" name="tax" value="0">
	<input type="hidden" name="lc" value="US">
	
	<input type="hidden" name="first_name" value="'.$BillData["BillCustName"].'" id="first_name">
	<input type="hidden" name="last_name" value="'.$BillData["BillCustLastName"].'" id="last_name">
	<input type="hidden" name="address1" value="'.$BillData["BillCustAddress"].'" id="address1">
	<input type="hidden" name="city" value="'.$BillData["BillCustCity"].'" id="city">
	<input type="hidden" name="state" value="'.$BillData["BillCustState"].'" id="state">
	<input type="hidden" name="zip" value="'.$BillData["BillCustZIPCode"].'" id="zip">
	<input type="hidden" name="country" value="'.$BillData["BillCustCountry"].'" id="country">
	<input type="hidden" name="email" value="'.$_SESSION['CustEmail'].'" id="email">
	<input type="hidden" name="cancel_return" value="'.$cancelUrl.'" id="cancel_return">
	<input type="hidden" name="return" value="'.$returnUrl.'" id="return">
	<input type="hidden" name="invoice" value="'.$_SESSION['orderid'].'" id="invoice">
	';
	
	$form.=$items;
	$grandtotal=($_SESSION['shipcharge']+$_SESSION['tax']+$_SESSION['subtotal']);
	if(isset($_SESSION['couponamount']) && $_SESSION['couponamount']>0)
	$form.='<input type="hidden" name="discount_amount_cart" value="'.$_SESSION['couponamount'].'" id="discount_amount_cart">';
	
	
	
	$form.='<input type="hidden" name="tax_cart" value="'.$_SESSION["tax"].'">
	<input type="hidden" name="OrdTotal" value="'.$grandtotal.'" id="OrdTotal">';
	$form.="<input type='hidden' name='shipping_1' value='".$_SESSION["shipcharge"]."' id='shipping_1'>";
	//$url = "https://www.sandbox.paypal.com/cgi-bin/webscr"; //Test
	$url = "https://www.paypal.com/cgi-bin/webscr"; //Live
	$form='<form action="'.$url.'" method="post" id="frmPayPal">'.$form.'</form>';
	echo $form;
  ?>
   
	
  
</div>
</div>
</div>
</div>
<!-- welcome end//-->
<!-- bottom start//-->
<?php echo bottom($abspath); ?>
<!-- bottom end//-->
<?php echo showSearch($abspath); ?>
<?php
unset($_SESSION['orderid']);
if($_SESSION["Register"]=="GUEST")
{
	session_destroy();
}


?>
<script  type="text/javascript" language="javascript">  
function checkout(){
	//alert(document.getElementById("frmPayPal").innerHTML);
	document.getElementById("frmPayPal").submit()
}
checkout();
</script>


</body>
</html>

