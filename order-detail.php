<?php
session_start();
include("include/connect.php");
include("include/page-add.php"); 
$url=$_SERVER['REQUEST_URI'];
$abspath = findAbs($url);
$imagepath = $abspath."gallery/large/";
$imagelist = $abspath."gallery/list/";
$odrid = $_REQUEST['ordid'];
//echo "SELECT item_order_detail.*,itemorder.order_date,product.imagepath FROM `item_order_detail` left join itemorder on item_order_detail.order_number=itemorder.order_number left join product on  item_order_detail.itemid = product.id WHERE item_order_detail.order_number = '$odrid'";
$sel = mysql_query("SELECT item_order_detail.*,itemorder.order_date,product.imagepath FROM `item_order_detail` left join itemorder on item_order_detail.order_number=itemorder.order_number left join product on  item_order_detail.itemid = product.id WHERE item_order_detail.order_number = '$odrid'");

//print_r($_REQUEST);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php echo showTitleFab($pagenav); ?>
<link href="<?php echo $abspath; ?>style.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?php echo $abspath; ?>css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $abspath; ?>css/style.css" type="text/css" media="screen" />

<script src="<?php echo $abspath; ?>js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/main.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="<?php echo $abspath; ?>javascript2/style.css">
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/jquery_003.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/easySlider1.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/jquery.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/this-theme.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/svb.js"></script>
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
  <div id="breadcum"><a href="#" class="brelink">Order Detail</a></div>
</div>

</div>
<div id="welcome-ddc-box">
<div id="search-out-box">
  <div id="order-main-box">
<div id="order-orange-box">
<div id="orderno-heading">Product Name</div>
<div id="order-price">Image</div>
<div id="order-date">Product Id </div>
<div id="order-status1">Product Price</div>
<div id="shipment-date">Quantity</div>
<div id="order-view1">Order Date</div>
</div>

<?php
if(mysql_num_rows($sel)>0)
{
	echo'<div id="order-grey-box">';
	while($res=mysql_fetch_assoc($sel))
	{
		echo'<div class="order-grey-box2">
		<div class="orderno-num1"><strong>'.stripslashes($res['item']).'</strong></div>
		<div class="order-image"><img src="'.$imagelist.$res['imagepath'].'" width="40" height="45" /></div>
		<div class="order-date1">47ddc - 00'.$res['itemid'].'</div>
		<div class="order-status1">$'.$res['item_value'].'</div>
		<div class="order-date1">'.$res['item_qty'].'</div>
		<div class="order-view2">'.$res['order_date'].'</div>
		</div>';
	}
	echo'</div>';
}
else
{
	echo'<div id="order-grey-box">No Order Found</div>';
}
?>
<div id="back-box"><a style="cursor:pointer;" onclick="history.back(-1);" class="link1">« Back</a></div>
</div>
  </div>
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
