<?php
session_start();
include("include/connect.php");
include("include/page-add.php");
$url=$_SERVER['REQUEST_URI'];
$abspath = findAbs($url);

$imagepath = "gallery/large/";
$imagelist = "gallery/list/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php echo showTitleFab($pagenav); ?>
<?php echo metaDescription($pagenav); ?>
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
<script type="text/javascript" src="js/jawelary.js"></script>
<script type="text/javascript" src="js/svb.js"></script>
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
  <div id="breadcum"><a href="#" class="brelink">Track Order</a>&nbsp;&nbsp;
  <?php
  	if(isset($_SESSION["msg"])){
		echo $_SESSION["msg"];
		unset($_SESSION["msg"]);
	}
  ?>
  </div>
</div>

</div>
<div id="welcome-ddc-box">
<div id="search-out-box">
<div class="billing-box">
<div class="confirm-heading"><strong>
  Search Order</strong></div>
</div>
<form action="order-status.html" method="post">
<div id="search-box-main">
<div id="search-box">
<div id="search-text"><strong>Keyword</strong></div>
<div class="searchfelid-box">
    
    <input name="keywordsearch" id="keywordsearch" type="text" class="inp1" value="<?php echo stripslashes($_REQUEST['keywordsearch']);?>"/>
  </div>
</div>
<div id="search-but"><input type="image" src="<?php echo $abspath; ?>images/search.gif" alt="continue" name="ordersearch" width="99" height="30" border="0" style="cursor:pointer;" onclick="return keywordSearch();"  /></div>
</div>
</form>
<?php
	if(isset($_REQUEST['keywordsearch']))
	{
		$orderno = mysql_real_escape_string($_REQUEST['keywordsearch']);
		$sql = mysql_query("select * from itemorder where order_number='$orderno'");
		$res = mysql_fetch_assoc($sql);
		echo'<div id="order-main-box">
		<div id="order-orange-box">
		<div id="orderno-heading">Order Number </div>
		<div id="order-price">Order Amount </div>
		<div id="order-date">Order Date </div>
		<div id="order-status">Order Status</div>
		<div id="shipment-date">Shipment Date </div>
		<div id="order-view">View</div>
		</div>';
		if(mysql_num_rows($sql)>0)
		{
		echo'<div id="order-grey-box">
		<div class="order-grey-box1">
		<div class="orderno-num"><strong>'.$res['order_number'].'</strong></div>
		<div class="order-price">$'.$res['total_price'].'</div>
		<div class="order-date">'.$res['order_date'].'</div>
		<div class="order-status">'.$res['payment_staus'].'</div>
		<div class="order-date">'; if($res['shipdate']=="")
									echo "Pending";
									else
									echo $res['shipdate'];
									echo'</div>
		<div class="order-view"><a href="'.$abspath.'order-detail/'.$res['order_number'].'.html"><img src="'.$abspath.'images/view.gif" alt="view" width="16" height="16" border="0" /></a></div>
		</div>		
		</div>';
		}
		else
		{
			echo'<div id="order-grey-box">No Order Found</div>';
		}
		echo'</div>';
	}
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
</body>
</html>
