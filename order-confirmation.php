<?php
session_start();
//echo $_SESSION["CustEmail"];
if(!isset($_SESSION["CustEmail"]))
{
	//header("location:detail.php");
	header("location:index.html");
	exit();
}
//$pagenav=4;
$pagenavsub=2;
include("include/connect.php");
include("include/page-add.php"); 
include("db/db.php");
$url=$_SERVER['REQUEST_URI'];
$abspath = findAbs($url);
$imagepath = $abspath."gallery/list/";
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
<script type="text/javascript" src="js/af_js.js"></script>
<script type="text/javascript" src="js/AjaxHandler.js"></script>
<script type="text/javascript" src="js/svb.js"></script>
<?php echo metaDescription($pagenav); ?>
</head>

<body>

<!-- Web Design & Developed by: http://www.webtimeinc.com -->

<!-- Top Start//-->
<div id="top-main">
<div id="top">
<?php echo logo($abspath) ?>
<div id="top-right">
<?php echo allPage($abspath); ?>
  
<div id="top-links1">
<div id="navi-panel">
          <?php echo nav($abspath); ?>
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
<div id="product-heading-box">
<div class="checkout-method-box">
<div class="checkout2">1</div>
<div class="checkout-method-text">Checkout Method</div>
</div>
<div class="checkout-method-box">
<div class="checkout2">2</div>
<div class="checkout-method-text">Billing &amp; Shipping Info </div>
</div>
<div class="checkout-method-box">
<div class="checkout2">3</div>
<div class="checkout-method-text">Shipping &amp; Payment  </div>
</div>
<div class="checkout-method-box">
<div class="checkout1">4</div>
<div class="checkout-method-text">Order Confirmation </div>
</div>
</div>
<div id="welcome-ddc-box">
<div id="checkout-left-box1">
<div class="billing-box">
<div class="confirm-heading"><strong>
  Order Confirmation  </strong></div>
</div>
<div class="oredr-text">You are now ready to complete your order. <br />
  <br />
        Please review your order below, and then click the 
'Place Order' button to process your order...</div>

	<div id="back-box"><a style="cursor:pointer;" onclick="history.back(-1);" class="link1">« Back</a></div>
  
</div>
<form action="goforpayment.php" method="post" enctype="multipart/form-data">
<div id="checkout-right-box1">
<div id="coupon-mainbox">
<div id="coupon-heading"><strong>
 Discount Codes</strong></div>
 <div id="coupon-text">Enter your coupon code if you have one.</div>
 <div id="coupon-feild-box">
 <div id="couponfelid-box1">
     <input name="couponid" type="text" class="inp2" id="couponid" />
   </div>
   <div id="apply-box"><img src="images/apply.gif" alt="apply" width="110" height="26" border="0" onclick="return getServerResponseCoupon('coupon-msg','AjaxHandler.php?query=checkcoupon&dublicate='+document.getElementById('couponid').value,'',false)" style="cursor:pointer;" /></div>
 </div>
 <div id="coupon-msg"></div>
</div>
<div class="billing-box">
<div class="confirm-heading"><span class="checkout-radio-box">
  <label><strong>Payment Informaion </strong></label>
</span></div>
</div>
<div class="checkout-radio-box">
    <label>
      <input name="radiobutton" id="radiobutton" type="radio" value="radiobutton" checked="checked" />
    </label>
    Paypal</div>
	<!--<div class="continue-box">
  	Special Voucher No.<input type="text" name="couponno" id="couponn" /><br />
	Amount<input type="text" name="amount" id="amount" onblur="getamount('',);" />
	</div>-->
  <div class="continue-box">
  	<input type="image" src="images/order.gif" alt="continue" width="127" height="30" border="0" style="cursor:pointer;"/>
	</div>
</div>
</form>
<!--show cart-->
<?php if(isset($_SESSION["CustEmail"]))
  {
  $sql_cart="SELECT IF( sd.ShipCustCountry =  'U.S.A.', p.shipchargedom, p.shipchargeint ) AS ship, p.imagepath,crt.productname, crt.qty,crt.productid, crt.price FROM product AS p,shipbilldetail AS sd, cart AS crt WHERE p.id = crt.productid AND crt.session_id =  '".session_id()."' AND sd.userid =  '".$_SESSION["userid"]."'";
  }
  else
  {
  	$sql_cart="select cart.*,product.imagepath from cart left join product on cart.productid = product.id where session_id='".session_id()."'";
  }
$rs_cart=mysql_query($sql_cart) or die(mysql_error());
	echo '<div id="product-view-box">
<div id="cart-box">
<div id="cart-image">In Your Bag</div>
<div id="price-item">Price Per Item </div>
<div id="total-price">Total</div>
</div>
<div id="cart-box1">';
if(mysql_num_rows($rs_cart)>0){
	$total=0;
	$cnt=0;
	$shipcharge = 0;
	$tax = 0;
	$gtotal=0;
	$subtotal=0;
	while($data_cart=mysql_fetch_array($rs_cart))
	{
		++$cnt;
		$amount =0;
		$quan=(int)$data_cart["qty"];
		$rate=$data_cart["price"];
		$amount = $rate * $quan;
		$subtotal=$subtotal+($quan*$rate);
		$shipcharge = $shipcharge + ($data_cart["ship"]*$quan);
		echo'<div class="cart-box2">
		<div id="product-image"><img src="'.$imagepath.$data_cart["imagepath"].'" width="80" height="80" align="middle" /></div>
		<div id="price-item1">$'.$data_cart['price'].'</div>
		<div id="total-price1">$'.$amount.'</div>
		</div>';
	}
	$_SESSION['shipcharge'] = $shipcharge;
	$_SESSION['subtotal'] = $subtotal;
}
echo'</div>
<div id="cart-box2">
<div id="modify"><a href="view-cart.php" class="link1">Modify your order</a></div>
<div id="total-price3">Sub Total :$'.$_SESSION['subtotal'].'<br />
Shipping : $ '.$_SESSION['shipcharge'].'<br />';
if($_SESSION["shipcountry"]=='U.S.A.' && $_SESSION["shipcity"]=="new york")
		{
			$tax = number_format((($_SESSION['subtotal']*10)/100),2);
			echo "Tax : $".$tax."<br>";
			$_SESSION['tax'] = $tax;
		}
		else
		$_SESSION['tax'] =00;
		if($_SESSION['couponamount']!=0)
				echo'Discount : $'.$_SESSION['couponamount'].'<br>';
		$gtotal = $_SESSION['shipcharge']+$_SESSION['tax']+$_SESSION['subtotal']-$_SESSION['couponamount'];
	 echo'<strong>Total Cost: $ '.$gtotal.'</strong>';
  echo'</div>';
  echo'<div id="showcoudetact"></div>';
echo'</div>
</div>';
?>
<!--end cart-->
</div>
</div>
</div>

<!-- welcome end//-->

<!-- bottom start//-->
<?php echo bottom($abspath); ?>
<!-- bottom end//-->
<?php echo showSearch($abspath); ?>
</body>
</html>
