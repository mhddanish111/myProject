<?php
session_start();

include("include/connect.php");
include("include/page-add.php"); 
$imagepath = "gallery/large/";
$imagelist = "gallery/list/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>47th Diamond District Corp! Specialize in fine antique jewelry and rare items as well as fine diamonds and gemstones</title>
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
</head>

<body>

<!-- Web Design & Developed by: http://www.webtimeinc.com -->

<!-- Top Start//-->
<div id="top-main">
<div id="top">
<?php echo logo() ?>
<div id="top-right">
<?php echo allPage(); ?>
  
<div id="top-links1">
<div id="navi-panel">
          <?php echo nav(); ?>
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
  <div id="breadcum"><a href="#" class="brelink">Track Order</a></div>
</div>

</div>
<div id="welcome-ddc-box">
<div id="search-out-box">
<div class="billing-box">
<div class="confirm-heading"><strong>
  Search Order</strong></div>
</div>
<div id="search-box-main">
<div id="search-box">
<div id="search-text"><strong>Keyword</strong></div>
<div class="searchfelid-box">
    
    <input name="textfield" type="text" class="inp1" />
  </div>
</div>
<div id="search-but"><a href="#"><img src="images/search.gif" alt="continue" width="99" height="30" border="0" /></a></div>
</div>
<div id="order-main-box">
<div id="order-orange-box">
<div id="orderno-heading">Order Number </div>
<div id="order-price">Order Amount </div>
<div id="order-date">Order Date </div>
<div id="order-status">Order Status</div>
<div id="order-view">View</div>
</div>
<div id="order-grey-box">
<div class="order-grey-box1">
<div class="orderno-num"><strong>DDC123456789</strong></div>
<div class="order-price">$999</div>
<div class="order-date">06 Aug 2011</div>
<div class="order-status">Pending</div>
<div class="order-view"><a href="#"><img src="images/view.gif" alt="view" width="16" height="16" border="0" /></a></div>
</div>
<div class="order-grey-box1">
<div class="orderno-num"><strong>DDC123456789</strong></div>
<div class="order-price">$999</div>
<div class="order-date">06 Aug 2011</div>
<div class="order-status">Pending</div>
<div class="order-view"><a href="#"><img src="images/view.gif" alt="view" width="16" height="16" border="0" /></a></div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- welcome end//-->
<!-- bottom start//-->
<?php echo bottom(); ?>
<!-- bottom end//-->
</body>
</html>
