<?php
session_start();
$pagenav=4;
$pagenavsub=2;
include("../include/connect.php");
include("include/page-add.php"); 
include("db/db.php");
$imagepath = "../gallery/list/";
$abspath = findAbs($url);
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
<script src="js/svb.js" type="text/javascript"></script>
<script src="js/AjaxHandler.js" type="text/javascript"></script>
<script src="js/af_js.js" type="text/javascript"></script>
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
<div id="heading">
  <div id="breadcum"><a href="forgotpassword.html" class="brelink">Forgot Password </a></div>
</div>

</div>
<div id="welcome-ddc-box">
<div id="forgot-main-box">
<div class="billing-box">
<div class="confirm-heading"><strong>
  Lost your password? No worries</strong></div>
</div>
<div id="forgot-text">Just follow these easy steps to recover it<br />
  <br />
    1. Enter the email ID you gave at the time of registration<br />
    <br />
2. A confirmation mail containing your lost password will be sent to your inbox</div>
<div id="forgot-email-box">
<div id="forgot-email">Email Address</div>
<div class="textfelid-box">
    
   <input name="email" class="inp" id="email" type="text"  value="<?php echo $email?>" />
  </div>
</div>
<div class="submit-box"><img src="../images/submit.gif" alt="continue" width="99" height="30" border="0" onclick="return forgotPassword('loginMsg','AjaxHandler.php?query=sendpassword','email','password','fieldid');" style="cursor:pointer;" /> </div>
 <div id="loginMsg"></div>
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
