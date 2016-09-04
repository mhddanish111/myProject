<?php
session_start();
include("include/connect.php");
include("include/page-add.php"); 
$imagepath = "gallery/large/";
$imagelist = "gallery/list/";
$url=$_SERVER['REQUEST_URI'];
$abspath = findAbs($url);
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
<script src="js/jquery.nivo.slider.js" type="text/javascript"></script>
<script src="js/slider.js" type="text/javascript"></script>
<script type="text/javascript" src="js/main.js"></script>
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

<!-- image sliding start//-->
<!-- image sliding end//-->
<!-- center start//-->
<!-- center end//-->
<!-- welcome start//-->
<div id="welcome-ddc-box">
<!-- about start//-->
<div id="staff-box">
<div id="staff-heaading-inn">Return & Privacy Policy  </div>
<!-- about text start//-->
<div id="staff-text">
  <div align="justify">
<?php $selcon = mysql_query("select content from cmscontent where id='6'");
						   $rescol = mysql_fetch_assoc($selcon);
						   echo stripslashes($rescol['content']);
						 
						?>
    <br />
  </div>
</div>
<!-- about text end//-->
</div>
<!-- about end//-->
<!-- getin touch start//-->
</div>
<!-- getin touch end//-->

<!-- welcome end//-->

<!-- bottom start//-->
<?php echo bottom($abspath); ?>
<!-- bottom end//-->
<?php echo showSearch($abspath); ?>
</body>
</html>
