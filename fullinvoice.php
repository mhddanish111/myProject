<?php
session_start();
//echo $_SESSION['granttotal'];
//echo $_SESSION['couponamount'];
//echo $_SESSION['shipcharge'];
//echo $_SESSION['couponamount'];

include("include/connect.php");
include("include/page-add.php"); 
include("db/db.php");
$url=$_SERVER['REQUEST_URI'];
$abspath = findAbs($url);
$imagepath = $abspath."gallery/list/";
//$shipingcharge=10;
if(!isset($_SESSION["CustEmail"]))
{
	header("location:index.html");
	exit;
}

if(!isset($_SESSION['cart_item'])){
	header("location:index.html");
	exit;
}
//echo $_REQUEST['couponid'];
$couponamount =0;
$_SESSION['tax'] = 0;
if($_REQUEST['couponid']!="")
{
	$today = date("d/m/Y");
	//$today = strtotime($toady);
	$couponid=$_REQUEST["couponid"];
	$CustEmail=$_SESSION["CustEmail"];
	//$sqlcou="select sendcoupon.*,coupons.amount from sendcoupon join coupons on sendcoupon.cid=coupons.id where sendcoupon.userid='".$CustEmail."' and sendcoupon.couponid='".$couponid."'";
	$sqlcou="select sc.validUpto,sc.flag,c.amount from sendcoupon as sc,coupons as c where c.id=sc.cid and sc.userid='".$CustEmail."' and sc.couponid='".$couponid."'";
	
	$rs=mysql_query($sqlcou) or die(mysql_error());
	if(mysql_num_rows($rs)>0)
	{
		$res = mysql_fetch_assoc($rs);
		if($res['flag']=="N")
		{
			$validate = $res['validUpto'];
			//$validate = strtotime($validate);
			if(getDateDiff($today,$validate) >0)
			{
				$_SESSION['responseText']="Coupon Available @ $". $res['amount'];
				$_SESSION['couponamount'] = $res['amount'];
				$_SESSION['couponid'] = $couponid;
			}
			else
			{
				$_SESSION['responseText']="Coupon Date Expire";
				header("Location:$abspath order-confirmation.html");
				exit;
			}
		}
		else
		{
			$_SESSION['responseText']="You Already Use It";
			header("Location:$abspath order-confirmation.html");
			exit;
		}
	}
	else
	{
		$_SESSION['responseText']="Invalid Coupon Code";
		header("Location:$abspath order-confirmation.html");
		exit;
	}
}

$shipcharge =0;

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
<div id="heading">
  <div id="breadcum"><a href="#" class="brelink">View Cart </a></div>
</div>

</div>
<div id="welcome-ddc-box">
<div id="search-out-box">
  <div id="order-main-box">
  <!--show if product add-->
  <?php  
  $sql_cart="SELECT IF( sd.ShipCustCountry =  'U.S.A.', p.shipchargedom, p.shipchargeint ) AS ship, p.imagepath,crt.productname, crt.qty,crt.productid, crt.price FROM product AS p,shipbilldetail AS sd, cart AS crt WHERE p.id = crt.productid AND crt.session_id =  '".session_id()."' AND sd.userid =  '".$_SESSION["userid"]."'";
	$rs_cart=mysql_query($sql_cart) or die(mysql_error());
	
	if(mysql_num_rows($rs_cart)>0){
	$total=0;
			$cnt=0;
			$gtotal=0;
			

  echo'<form action="goforpayment.php" method="post" enctype="multipart/form-data">
    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#54320C" class="text">
      <tr>
        <td height="33"><table width="100%" border="0" cellpadding="5" cellspacing="0" class="text">
            <tr bgcolor="#D8A437">
              <td><strong>Product</strong></td>
			    <td width="80" align="center"><strong>shiping Charge</strong></td>
              <td width="80" align="center"><strong>Unit Price</strong></td>
              <td width="80" align="center"><strong>Total</strong></td>
            </tr>
        </table></td>
      </tr>';

	  while($data_cart=mysql_fetch_array($rs_cart))
		{
				++$cnt;
				$quan=(int)$data_cart["qty"];
				$rate=$data_cart["price"];
				$total=$total+($quan*$rate);
				$gtotal = $gtotal+$total;
				$shipcharge = $shipcharge + $data_cart['ship'];
      echo'<tr class="text1">
        <td background="images/bg.jpg"><table width="100%" border="0" cellpadding="5" cellspacing="0" class="table1">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="70" align="left"><img src="'.$imagepath.$data_cart["imagepath"].'" height="54" width="65"/></td>
                  <td align="left" class="text"><strong>47ddc - 00'. stripslashes($data_cart["productid"]).'</strong></td>
                </tr>
            </table></td>
			<td width="80" align="center"  class="text">$'.$data_cart['ship'].'</td>
            <td width="80" align="center"  class="text">$'.$rate.'</td>
            <td width="80" align="center" class="text">$'.$total.'</td>
          </tr>
		  
        </table></td>
      </tr>';
	  $total=0;
	  }
	  //////////////
	  // $gtotal = $gtotal + $shipingcharge;
	  $_SESSION['shipcharge'] = $shipcharge;//add shipcharge in session
      echo'<input type="hidden" name="count" id="count" value="'.$cnt.'">
	  <tr>
        <td valign="top" background="'.$abspath.'images/bg.jpg">';
            echo'<table width="100%" border="0" cellpadding="5" cellspacing="0" class="text">
              <tr>
                <td align="right" valign="top"> Shiping : <br />';
				if($_SESSION['couponamount']>0)
				echo'Coupon Amount : <br />';
                  if($_SESSION["shipcountry"]=='U.S.A.' && $_SESSION["shipcity"]=="new york")
				{
						echo 'Tax: <br />';
				}
                  echo'<strong><font color="#FF0000">Total Cost:</font></strong></td>
                <td width="80" align="center" valign="top">$'.$_SESSION['shipcharge'].'<br />';
				if($_SESSION['couponamount']>0)
				echo'$'.$_SESSION['couponamount'].'<br />';
                  if($_SESSION["shipcountry"]=='U.S.A.' && $_SESSION["shipcity"]=="new york")
				{
						$tax = number_format((($gtotal*10)/100),2);
						echo'$'.$tax.'<br />';
						$gtotal = $gtotal + $tax; 
						$_SESSION['tax'] = $tax;
				}
				$gtotal = $gtotal + $shipcharge; // add shiping charge total;
				$_SESSION['granttotal'] = $gtotal;// add grant total in session
				if(isset($_SESSION['couponamount']))
				$_SESSION['granttotal'] = $_SESSION['granttotal']- $_SESSION['couponamount'];
							
                 echo'<strong><font color="#FF0000">$'.$_SESSION['granttotal'].'</font></strong></td>
              </tr>
            </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td align="left">&nbsp;</td>
                <td align="right"><input type="image" src="'.$abspath.'images/proceed-checkout.gif" width="151" height="24" border="0" style="cursor:pointer;" />
				</td>
              </tr>
          </table></td>
      </tr>
    </table><form>';
}
else
{
	echo'<table width="100%" border="0" cellpadding="0" cellspacing="1" class="text">
      <tr>
        <td height="33">Oh no! Your shopping bag is empty, but we\'ve got some great ways for you to fill it up. </td>
      </tr>
      <tr class="text1">
        <td background="'.$abspath.'images/bg.jpg">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top" background="'.$abspath.'images/bg.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td align="left"><a href="'.$abspath.'index.html"><img src="'.$abspath.'images/continue-shopping1.gif" width="145" height="24" border="0" /></a></td>
              <td align="right"><a href="#"></a></td>
            </tr>
          </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td align="left">&nbsp;</td>
                <td align="right"><a href="#"></a></td>
              </tr>
          </table></td>
      </tr>
    </table>';
}
?>
	<!--end if no product-->
  </div>
</div>
</div>

<!--<div id="back-box"><a style="cursor:pointer;" onclick="history.back(-1);" class="link1">« Back</a></div>-->
<!-- welcome end//-->
<!-- bottom start//-->
<?php echo bottom($abspath); ?>
<!-- bottom end//-->
<?php echo showSearch($abspath); ?>
</body>
</html>
