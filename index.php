<?php
session_start();
$pagenav=1;
include("include/connect.php");
include("include/page-add.php"); 


$url=$_SERVER['REQUEST_URI'];
$abspath = findAbs($url);
//echo 'abspath : '.$abspath;
$imagepath = $abspath."gallery/large/";
$imagelist =$abspath."gallery/list/";
$rs = mysql_query("SELECT p.id,p.title,p.imagepath,p.eurl as peurl,s.eurl as seurl, c.eurl as ceurl  FROM `product` as p left join subcategory as s on p.subcatid= s.id left join category as c on s.catid = c.id where p.status ='Y' order by RAND() limit 0,5");
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
<script src="js/jquery.nivo.slider.js" type="text/javascript"></script>
<script src="js/slider.js" type="text/javascript"></script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/svb.js"></script>
<script type="text/javascript" src="js/AjaxHandler.js"></script>

</head>

<body>

<!-- Web Design & Developed by: http://www.webtimeinc.com -->

<!-- Top Start//-->
<div id="top-main">
<div id="top">
<?php echo logo($abspath,true); ?>
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
<div id="fash-mainbox">
<div id="fash-box">
<div id="fash">
<div id="content">
<div id="slider2" class="nivoSlider"> <img src="images/003.jpg" alt="" title="International jewelry direct from the manufacturers & designers!" /> <img src="images/002.jpg" alt="" title="Awe inspiring large & rare diamonds!" /> <img src="images/004.jpg" alt="" title="The finest gemstone & diamond collections in the world!" /> <img src="images/005.jpg" alt="" title="We carry New & Vintage high luxury watches!" /> <img src="images/006.jpg" alt="" title="This is the place to design your special piece!" /> <img src="images/001.jpg" alt="" title="We are located in the heart of the New York International Diamond District." /> </div>
</div>

</div>
</div>
</div>
<!-- image sliding end//-->

<!-- center start//-->
<div id="mid-box">
<div id="latest-box">LATEST COLLECTION </div>
<div id="home-images-box">
<?php 
	$i=0;
	while($resrs = mysql_fetch_assoc($rs))
	{ //<a href="'.$abspath.'product/'.$prodres['eurl'].'.htm'" title="'.stripslashes($prodres['title']).'"
  		echo'<div class="image-box'.$i.'">
		<div class="image"><a href="'.$abspath.''.strtolower($resrs['ceurl']).'/'.strtolower($resrs['seurl']).'/'.strtolower($resrs['peurl']).'.html" title="'.stripslashes($resrs['title']).'"><img src="'.$imagelist.$resrs['imagepath'].'" alt="47ddc" width="160" height="160" border="0" /></a></div>
		</div>';
		$i++;
	}
?>
  <!--<div class="image-box1">
<div class="image"><a href="#"><img src="images/homep.jpg" alt="47ddc" width="210" height="130" border="0" /></a></div>
</div>-->

  <!--<div class="image-box2">
<div class="image"><a href="#"><img src="images/homep.jpg" alt="47ddc" width="210" height="130" border="0" /></a></div>
</div>-->
  <!--<div class="image-box3">
<div class="image"><a href="#"><img src="images/homep.jpg" alt="47ddc" width="210" height="130" border="0" /></a></div>
</div>-->
</div>
</div>
<!-- center end//-->
<!-- welcome start//-->
<div id="welcome-ddc-box">
<!-- about start//-->
<div id="about-box">
<div id="welcome-heaading">WELCOME</div>
<!-- about text start//-->
<div id="welcome-text">
  <div align="justify"><?php $selcon = mysql_query("select content from cmscontent where id='1'");
						   $rescol = mysql_fetch_assoc($selcon);
						   echo stripslashes($rescol['content']);
						 
						?>
  </div>
</div>
<!-- about text end//-->
</div>
<!-- about end//-->
<!-- getin touch start//-->
<div id="get-touch">
<div id="touch-heaading">STAY IN TOUCH </div>
<div id="touch-text"><?php $selcon = mysql_query("select content from cmscontent where id='4'");
						   $rescol = mysql_fetch_assoc($selcon);
						   echo stripslashes($rescol['content']);
						 
						?></div>
  
  </div></div>
<!-- getin touch end//-->

<!-- welcome end//-->

<!-- bottom start//-->
<?php echo bottom($abspath); ?>
<!-- bottom end//-->
<!-- Seardh Div -->
<?php echo showSearch($abspath); ?>
<!-- SEarch Deiv -->
</body>
</html>
