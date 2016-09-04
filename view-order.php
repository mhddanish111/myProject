<?php
session_start();

include("include/connect.php");
include("include/page-add.php");
$url=$_SERVER['REQUEST_URI'];
$abspath = findAbs($url);
$imagepath = $abspath."gallery/large/";
$imagelist = $abspath."gallery/list/";
$odrid = $_REQUEST['ordid'];
$sel = mysql_query("SELECT item_order_detail.*,itemorder.order_date FROM `item_order_detail` left join itemorder on item_order_detail.order_number=itemorder.order_number  WHERE item_order_detail.order_number = '$odrid'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php echo showTitleFab($pagenav); ?>
<link href="style.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />

<script src="<js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $abspath ; ?>js/main.js"></script>

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
<!--<div class="billing-box">
<div class="confirm-heading"><strong>
  Search Order</strong></div>
</div>-->
<!--<div id="search-box-main">
<div id="search-box">
<div id="search-text"><strong>Keyword</strong></div>
<div class="searchfelid-box">
    
    <input name="textfield" type="text" class="inp1" />

  </div>
</div>
<div id="search-but"><a href="#"><img src="images/search.gif" alt="continue" width="99" height="30" border="0" /></a></div>
</div>-->
<div id="order-main-box">
<div id="order-orange-box">
<div id="orderno-heading">Product Name </div>
<div id="order-price">Product Id </div>
<div id="order-date">Product Price </div>
<div id="order-status">Product Quantity</div>
<div class="order-date">Order Date</div>
		</div>
</div>
<?php
if(mysql_num_rows($sel)>0)
{
	echo'<div id="order-grey-box">';
	while($res=mysql_fetch_assoc($sel))
	{
		
		echo'<div class="order-grey-box1">
		<div class="orderno-num"><strong>'.stripslashes($res['item']).'</strong></div>
		<div class="order-price">47ddc - 00'.$res['itemid'].'</div>
		<div class="order-date">$'.$res['item_value'].'</div>
		<div class="order-status">'.$res['item_qty'].'</div>
		<div class="order-date">'.$res['order_date'].'</div>
		</div>';
	}
	echo'</div>';
	
}
else
	{
	echo'<div id="order-grey-box">No Record Found</div>';
	}
?>
<!--<div id="order-grey-box">

<div class="order-grey-box1">
<div class="orderno-num"><strong>DDC123456789</strong></div>
<div class="order-price">$999</div>
<div class="order-date">06 Aug 2011</div>
<div class="order-status">Pending</div>
<div class="order-date">Pending</div>
<div class="order-view"><a href="#"><img src="images/view.gif" alt="view" width="16" height="16" border="0" /></a></div>
</div>
</div>-->
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
