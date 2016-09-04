<?php
session_start();
//$pagenav=4;
include("include/connect.php");
include("include/page-add.php"); 
include("db/db.php");
$url=$_SERVER['REQUEST_URI'];
$abspath = findAbs($url);
$imagepath = $abspath."gallery/large/";
$imagelist = $abspath."gallery/list/";
/*if(!isset($_REQUEST['eurl']))
{
	$selcat = mysql_query("select id,catname,eurl,seotitle,keyword,seodescription from category where status = 'Y' order by id limit 0,1");
	$rscat = mysql_fetch_assoc($selcat);
	$_SESSION['catname'] = $rscat['catname'];
	$_SESSION['catid'] = $rscat['id'];
	$_SESSION['eurl'] = $rscat['eurl'];
}*/
if(!isset($_REQUEST['cid']))
{
	$selcat = mysql_query("select id,catname,eurl,seotitle,keyword,seodescription from category where status = 'Y' order by id limit 0,1");
	$rscat = mysql_fetch_assoc($selcat);
	$_SESSION['catname'] = $rscat['catname'];
	$_SESSION['catid'] = $rscat['id'];
	$_SESSION['eurl'] = $rscat['eurl'];
}
else
{
	$selcat = mysql_query("select id,catname,eurl,seotitle,keyword,seodescription from category where status = 'Y' and eurl = '".$_REQUEST['cid']."' order by id limit 0,1");
	if(mysql_num_rows($selcat)>0)
	{
		$rscat = mysql_fetch_assoc($selcat);
		$_SESSION['catname'] = $rscat['catname'];
		$_SESSION['catid'] = $rscat['id'];
		$_SESSION['eurl'] = $rscat['eurl'];
	}
}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="<?php echo $abspath; ?>images/favicon.ico" type="image/x-icon">
<title><?php if(!empty($rscat['seotitle'])) echo stripslashes($rscat['seotitle']);
			else echo "47th DDC; Diamonds, Gemstones, Jewelry, Watches and Art."; ?></title>
<meta name="keywords" content="<?php echo stripslashes($rscat['keyword']); ?>" />
<meta name="description" content="<?php echo stripslashes($rscat['seodescription']); ?>" />
<link href="<?php echo $abspath; ?>style.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?php echo $abspath; ?>css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $abspath; ?>css/style.css" type="text/css" media="screen" />

<script src="<?php echo $abspath; ?>js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/main.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="<?php echo $abspath; ?>javascript2/style.css">
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/jquery_003.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/easySlider1.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/jquery.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/this-theme2.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/svb.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/AjaxHandler.js"></script>

<?php //echo metaDescription($pagenav); ?>
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
  <div id="breadcum"><a href="<?php echo $abspath; ?>index.html" class="brelink">Home</a> >&nbsp;<?php echo stripslashes($rscat['catname']); ?></div>
</div>

</div>
<div id="welcome-ddc-box">
<div id="left-link-box">
<div id="collection-heaading">47DDC COLLECTION </div>
<?php echo leftLink($abspath); ?>
</div>
<div id="products-box">
  <div id="post-72" class="post-72 page type-page status-publish hentry post-style">
    <div class="post-entry"> <span class="banner-inicio"></span>
        <div class="last_projects">
          
		  <?php 
		  	$rsprod = rs_select("subcategory  where status='Y' and catid='".$_SESSION['catid']."'","*");
			
			if(mysql_num_rows($rsprod)>0)
			{
				echo'<ul>';
				while($resprod = mysql_fetch_assoc($rsprod))
				{
            		echo'<li><a href="'.$abspath.''.strtolower($_REQUEST['cid']).'/'.strtolower($resprod['eurl']).'/12/1/1.html" title="'.stripslashes($resprod['subcat']).'"><img src="'.$imagelist.$resprod['imagepath'].'" class="attachment-project-last wp-post-image" alt="'.stripslashes($resprod['subcat']).'" title="'.stripslashes($resprod['subcat']).'" height="179" width="200" />
                  	<div style="top: 150px;" class="last_projects_caption"><p class="last_projects_caption_title">'.stripslashes($resprod['subcat']).'</p></div></a></li>';
				}
				echo'</ul>';
			}
			else
			{
			  echo "<ul><li>Sorry</ul></li>"; 
			}
			?>
         
        </div>
    </div>
    <!-- .entry-content -->
  </div>
</div>

</div>
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
