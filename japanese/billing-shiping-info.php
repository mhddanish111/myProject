<?php
session_start();
if((!isset($_SESSION["CustEmail"])) || (!isset($_SESSION['cart_item']))){
	header("Location:index.html");
	exit;
}
//$pagenav=4;
include("../include/connect.php");
include("include/page-add.php"); 
include("../db/db.php");
$url=$_SERVER['REQUEST_URI'];
$abspath = findAbs($url);
$imagepath = "../gallery/list/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//JA" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php echo showTitleFab($pagenav); ?>
<link href="../style.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />

<script src="js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/main.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="javascript2/style.css">
<script type="text/javascript" src="javascript2/jquery_003.js"></script>
<script type="text/javascript" src="javascript2/easySlider1.js"></script>
<script type="text/javascript" src="javascript2/jquery.js"></script>
<script type="text/javascript" src="javascript2/this-theme.js"></script>
<script type="text/javascript" src="js/AjaxHandler.js"></script>
<script type="text/javascript" src="js/svb.js"></script>
<?php echo metaDescription($pagenav); ?>
<meta name="description" content="第四十七ダイヤモンド地区コーポレーションへ！
私たちは、ジュエリーとアート� ®、上質、希少でユニークな作品のコレクターと売り手です。我々は、ニューヨークダイヤモンド地区内の2つの場所を持っている。我々は素晴らしいアンティークジュエリーとレアなアイテムだけでなく、微細なダイヤモンドおよび宝石用原石を専門としています。あなたが私達を扱うときには、ニューヨーク州や、世界中の不動産宝石の様々なアクセスを得る。私たちのコレクションは、美しいもののための重労働と愛の年から構成されています。我々は全てがこのビジネスへの愛が不足している、我々はまた、AGTA（米国宝石貿易協会）の誇りのメンバーであり、私たちはNYのダイヤモンドディーラークラブと密接に連携。 ">
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
<div class="checkout1">3</div>
<div class="checkout-method-text">Shipping &amp; Payment  </div>
</div>
<div class="checkout-method-box">
<div class="checkout2">4</div>
<div class="checkout-method-text">Order Confirmation </div>
</div>
</div>
<div id="welcome-ddc-box">
<div id="checkout-left-box1">
<div class="billing-box">
<div class="billing-heading"><strong>Billing Address </strong>|</div>
<div class="billing-edit"><a href="change-detail.html?PHPSESSIID=<?php echo session_id(); ?>&query=bill&update=billinfo" class="link1">Change</a> </div>
</div>
<?php
$sel = mysql_query("select * from shipbilldetail where CustEmail = '".$_SESSION['CustEmail']."' and id='".$_SESSION["registerid"]."'"); 
$res = mysql_fetch_assoc($sel);
?>
<div class="billing-text"><?php echo stripslashes($res['BillCustName'])." ".stripslashes($res['BillCustLastName']);
  	echo'<br />';
  	echo stripslashes($res['BillCustAddress'])." ".stripslashes($res['BillCustAddress1']);
  	echo '<br />';
  	echo $res['BillCustCity'];
  	echo'<br>'; 
	echo $res['BillCustState'].", ". $res['BillCustZIPCode'];
	echo'<br />';
	echo $res['BillCustCountry'] ;
	echo'<br />';

	echo "T:".$res['BillCustPhone'];?></div>
<div id="back-box"><a style="cursor:pointer;" onclick="history.back(-1);" class="link1"> Back</a></div>
  
</div>
<div id="checkout-right-box1">
<div class="billing-box">
<div class="ship-heading"><strong>Shipping Address </strong>|</div>
<div class="billing-edit"><a href="ship-change-detail.html?PHPSESSIID=<?php echo session_id();?>&query=ship&update=shipinfo" class="link1">Change</a>  </div>
</div>
<div class="billing-text"><?php echo  stripslashes($res['ShipCustName'])." ".stripslashes($res['ShipCustLastName']);
  	echo'<br />';
  	echo stripslashes($res['ShipCustAddress'])." ".stripslashes($res['ShipCustAddress1']);
  	echo '<br />';
  	echo stripslashes($res['ShipCustCity']);
  	echo'<br>'; 
	echo $res['ShipCustState'] .",".$res['ShipCustZIPCode'];
	echo'<br />';
	echo $res['ShipCustCountry'];
	echo'<br />';

	echo "T:".$res['ShipCustPhone'];?></div>
   <div class="continue-box"><a href="order-confirmation.html"><img src="../images/continue.jpg" alt="continue" width="99" height="30" border="0" /></a><a href="#"></a></div>
</div>
<!--show cart-->
<?php echo showCard();?>
<!--end cart-->
</div>
</div>

</div>

<!-- welcome end//-->

<!-- bottom start//-->
<?php echo bottom($abspath); ?>
<!-- bottom end//-->
<!-- Seardh Div -->
<?php echo showSearch($abspath); ?>
<!-- SEarch Deiv -->
</body>
</html>
