<?php
session_start();
include("include/connect.php");
include("include/page-add.php"); 
$url=$_SERVER['REQUEST_URI'];
$abspath = findAbs($url);
if(isset($_SESSION["CustEmail"]))
{
	header("location:".$abspath."billing-shiping-info.html");
	exit;
}


$imagepath = $abspath."gallery/large/";
$imagelist = $abspath."gallery/list/";
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
<script type="text/javascript" src="js/af_js.js"></script>
<script type="text/javascript" src="js/AjaxHandler.js"></script>
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
  <div id="breadcum"><a href="#" class="brelink">Login</a></div>
</div>

</div>
<div id="welcome-ddc-box">
<div id="checkout-left-box1">
  <div id="login-box">
    <h3>Login</h3>
    <br />
    <strong>Already registered?</strong> <br />
    Please log in below: </div>
  <div class="email-text-box">Email Address</div>
  <div class="textfelid-box">
    <input name="loginusername" id="loginusername" type="text" class="inp" />
  </div>
  <div class="email-text-box">Password</div>
  <div class="textfelid-box">
    <input name="loginpassword" id="loginpassword" type="password" class="inp" />
  </div>
  <div class="email-text-box"><a href="<?php echo $abspath; ?>forgotpassword.html" class="link">Forgot your password?</a></div>
  <div class="continue-box"><input type="image" src="<?php echo $abspath; ?>images/login.gif" alt="login"  name="userlogin" width="99" height="30" border="0"  style="cursor:pointer;" onclick="return checkLogin('loginack','loginusername','loginpassword');" /></div><span id="loginack" style="font-size:12px;color:#FF0000;font-family:'Courier New', Courier, monospace;"></span>
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
