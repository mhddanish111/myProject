<?php
session_start();
$pagenav=4;
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
<?php echo language(); ?> 
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
  Acknowledgement of Payemt
</strong></div>
</div>
<div class="thanks-text">
<?php if($_SESSION["opt"]=="success"){ ?>
  Thank you for your purchase. Your order has been received
  <br />
  <br />
      Your order # is: <?php echo $_SESSION['orderid'];?><br />
      You will receive an order confirmation email with details of your order and a link to track its progress.</div>
<?php
	}
	else if($_SESSION["opt"]=="cancel"){ ?>
	Dear Customer, you have canceled your order.


 <?php } 
	 else { ?>
 	INVALID REQEST.....
 <?php } ?> 
 	<div id="back-box"><a href="index.html" class="link1">« Continue Shopping </a></div>
</div>
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
<?php
unset($_SESSION['orderid']);
if($_SESSION["Register"]=="GUEST")
{
	session_destroy();
}
?>
