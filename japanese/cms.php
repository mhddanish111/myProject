<?php
$pagenav=1;
include("../include/connect.php");
include("include/page-add.php"); 
$imagepath = "../gallery/large/";
$imagelist = "../gallery/list/";
$rs = mysql_query("SELECT id,title,imagepath FROM `product` order by rand() LIMIT 0 , 4");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ja" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>第四十七 ダイヤモンド 地区 コープ! 専門にする の 微 アンティーク ジュエリー や まれ アイテム としての としての としての 微 ダイヤモンド や 宝石</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />

<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery.nivo.slider.js" type="text/javascript"></script>
<script src="js/slider.js" type="text/javascript"></script>
<script type="text/javascript" src="js/main.js"></script>

</head>

<body>

<!-- Web Design & Developed by: http://www.webtimeinc.com -->

<!-- Top Start//-->
<div id="top-main">
<div id="top">
<?php echo logo(); ?>
<div id="top-right">
  <?php echo language() ?>
<div id="top-links">
<div id="navi-panel">
<?php $selcat = mysql_query("select id,ja_catname from category where status ='Y' and ja_catname !=''");
	 
	global $pagenav;
	echo'<ul>
            <li><a  href="index.php"';
						  if($pagenav==1) 
						  echo 'class="currentnavi"';
						  echo '>&#12488;&#12483;&#12503;</a>            </li>
            <li><a  href="cms.php"';
						  if($pagenav==2) 
						  echo 'class="currentnavi"';
						  echo '>&#31169;&#36948;&#12395;&#12388;&#12356;&#12390;</a>
            </li>
            <li><a  href="cms.php"';
						  if($pagenav==3) 
						  echo 'class="currentnavi"';
						  echo ' >&#31169;&#12383;&#12385;&#12398;&#12473;&#12479;&#12483;&#12501;</a>
            </li>
            <li><a href=""';
						  if($pagenav==4) 
						  echo 'class="currentnavi"';
						  echo '>&#35069;&#21697;</a>
               <ul>';
			   while($rescat = mysql_fetch_assoc($selcat))
			   {
			   		echo'<li><a href="category.php?cid='.$rescat['id'].'">'.stripslashes($rescat['ja_catname']).'</a></li>';
				}
                 echo'<li><a href="cms.php">サービス</a></li>
               </ul>
            </li>
			<li><a href="cms.php"';
						  if($pagenav==5) 
						  echo 'class="currentnavi"';
						  echo '>&#12362;&#21839;&#12356;&#21512;&#12431;&#12379;</a>
            </li>
		  </ul>'; ?>
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
<div id="about-box">
<div id="welcome-heaading-inn">について アメリカ </div>
<!-- about text start//-->
<div id="welcome-text">
  <div align="justify"><?php $selcon = mysql_query("select ja_aboutdesp from aboutus");
						   $rescol = mysql_fetch_assoc($selcon);
						   echo stripslashes($rescol['ja_aboutdesp']);
						?>
  </div>
</div>
<!-- about text end//-->
</div>
<!-- about end//-->
<!-- getin touch start//-->
<div id="get-touch">
<div id="touch-heaading"><strong>&#12356;&#12388;&#12391;&#12418;&#26368;&#26032;&#24773;&#22577;</strong></div>
<div id="touch-text"><?php $selcon = mysql_query("select ja_contactdesp from contactus");
						   $rescol = mysql_fetch_assoc($selcon);
						   echo stripslashes($rescol['ja_contactdesp']);
						?></div>
  
  </div>
  <!-- getin touch end//-->

<!-- welcome end//-->

<!-- bottom start//-->
<div id="bottom-box">
<div id="bottom">
<div id="bottom-left">
<div id="bottom-links"><a href="index.php">&#12488;&#12483;&#12503;</a> <a href="cms.php">&#31169;&#36948;&#12395;&#12388;&#12356;&#12390;</a> <a href="cms.php">私&#31169;&#12383;&#12385;&#12398;&#12473;&#12479;&#12483;&#12501;</a><a href="#">&#35069;&#21697;</a><a href="cms.php">&#12362;&#21839;&#12356;&#21512;&#12431;&#12379;</a></div>
  <div id="copyright">&#33879;&#20316;&#27177; &copy;201047ddc&#12290;&#12377;&#12409;&#12390;&#12398;&#27177;&#21033;&#12434;&#20445;&#26377;&#12290;</div>
  <div id="webtimeinc">ウェブ デザイン &amp; 開発 で:&nbsp; <a href="http://www.webtimeinc.com" target="_blank" class="link">Webtime Inc</a></div>
</div>
<div id="bottom-right">
<div id="follow-heaading">従ってください 私たち</div>
<div id="follow-box">
<div class="follow"><a href="#" target="_blank" class="tooltip" title="47ddc on Facebook"><img src="images/facebook.jpg" alt="facebook" border="0" /></a></div>
<div class="follow"><a href="#" target="_blank" class="tooltip" title="Follow us on Twitter"><img src="images/tiwtter.jpg" alt="facebook" width="28" height="30" border="0" /></a></div>
<div class="follow"><a href="#" target="_blank" class="tooltip" title="Follow us on Linkedin"><img src="images/in.jpg" alt="facebook" width="28" height="30" border="0" /></a></div>
</div>
</div>
  
</div>
</div>
<!-- bottom end//-->
</body>
</html>
