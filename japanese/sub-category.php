<?php
session_start();
$pagenav=4;
$pagenavsub=2;
include("../include/connect.php");
include("../db/db.php");
include("include/page-add.php"); 

$url=$_SERVER['REQUEST_URI'];
$abspath = findAbs($url);
$imagepath = $abspath."../gallery/large/";
$imagelist = $abspath."../gallery/list/";
if(!isset($_REQUEST['sid']))
{
	$selsub = mysql_query("SELECT category.ja_catname,category.id as categoryid, category.eurl AS cateurl, subcategory.id, subcategory.ja_subcat, subcategory.eurl, subcategory.seojatitle, subcategory.jakeyword, subcategory.jaseodescription FROM category LEFT JOIN subcategory ON category.id = subcategory.catid WHERE subcategory.status = 'Y' ORDER BY subcategory.id limit 0,1");
	$rssubcat = mysql_fetch_assoc($selsub);
	$_SESSION['subcatname'] = $rssubcat['subcat'];
	$_SESSION['subcatid'] = $rssubcat['id'];
	$_SESSION['subeurl'] = $rssubcat['eurl'];
}
else
{
	$selsub = mysql_query("SELECT category.ja_catname,category.id as categoryid, category.eurl AS cateurl, subcategory.id, subcategory.ja_subcat, subcategory.eurl, subcategory.seojatitle, subcategory.jakeyword, subcategory.jaseodescription FROM category LEFT JOIN subcategory ON category.id = subcategory.catid WHERE subcategory.status = 'Y' AND subcategory.eurl = '".$_REQUEST['sid']."' ORDER BY subcategory.id");
	if(mysql_num_rows($selsub)>0)
	{
		$rssubcat = mysql_fetch_assoc($selsub);
		$_SESSION['subcatname'] = $rssubcat['subcat'];
		$_SESSION['subcatid'] = $rssubcat['id'];
		$_SESSION['subeurl'] = $rssubcat['eurl'];
	}
}
$R_sortby=1;
$orderby = "id";
if(!empty($_REQUEST['sortby'])){
	if($_REQUEST['sortby']=="1"){ $orderby = "price desc ";$R_sortby=1;}
	else if($_REQUEST['sortby']=="2"){ $orderby = "price ";$R_sortby=2;}
	else if($_REQUEST['sortby']=="3") {$orderby = "id desc ";$R_sortby=3;}
	else if($_REQUEST['sortby']=="4"){$orderby = "id "; $R_sortby=4;}
}
 $sql="select id,imagepath,jatitle,jadescription,japrice,adddate,catid,subcatid,eurl from product where catid='".$rssubcat['categoryid']."' and status ='Y' and subcatid='".$rssubcat['id']."' order by $orderby" ;
			$numrows = mysql_num_rows(mysql_query($sql));
			//$rowsPerPage = $_REQUEST['searchperpage']!=""?$_REQUEST['searchperpage']:3;
			$rowsPerPage = $_REQUEST['searchperpage']!=""?$_REQUEST['searchperpage']:12;
			$pageNum = 1;
			if(isset($_GET['page']))
			$pageNum = $_GET['page'];
			$offset = ($pageNum - 1) * $rowsPerPage;
			$maxPage = ceil($numrows/$rowsPerPage);
		    $rsprod=mysql_query($sql." LIMIT $offset, $rowsPerPage")or die(mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ja" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="<?php echo $abspath; ?>images/favicon.ico" type="image/x-icon">
<title><?php if(!empty($rssubcat['seojatitle'])) echo stripslashes($rssubcat['seojatitle']);
			else echo "47th DDC; Diamonds, Gemstones, Jewelry, Watches and Art."; ?></title>
<meta name="keywords" content="<?php echo stripslashes($rssubcat['jakeyword']); ?>" />
<meta name="description" content="<?php echo stripslashes($rssubcat['jaseodescription']); ?>" />

<link href="<?php echo $abspath; ?>../style.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?php echo $abspath; ?>css/nivo-slider.css" type="text/css" media="screen" />

<script src="j<?php echo $abspath; ?>s/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/main.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="<?php echo $abspath; ?>javascript2/style.css">
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/jquery_003.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/easySlider1.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/jquery.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/this-theme.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/AjaxHandler.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/svb.js"></script>
<script type="text/javascript" language="javascript">
function pageSubmit()
{
	document.forms["frmsearch"].submit();
}
</script>
<?php //echo metaDescription($pagenav); ?>
<!--<meta name="description" content="第四十七ダイヤモンド地区コーポレーションへ！
私たちは、ジュエリーとアート� ®、上質、希少でユニークな作品のコレクターと売り手です。我々は、ニューヨークダイヤモンド地区内の2つの場所を持っている。我々は素晴らしいアンティークジュエリーとレアなアイテムだけでなく、微細なダイヤモンドおよび宝石用原石を専門としています。あなたが私達を扱うときには、ニューヨーク州や、世界中の不動産宝石の様々なアクセスを得る。私たちのコレクションは、美しいもののための重労働と愛の年から構成されています。我々は全てがこのビジネスへの愛が不足している、我々はまた、AGTA（米国宝石貿易協会）の誇りのメンバーであり、私たちはNYのダイヤモンドディーラークラブと密接に連携。 ">-->
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
<form action="" method="post" name="frmsearch" id="frmsearch">
<input type="hidden" name="page" id="page" value="<?php echo $pageNum; ?>" />
<div id="product-heading-box">
<div id="heading">
  <div id="breadcum"><a href="<?php echo $abspath; ?>index.html" class="brelink">トップ</a> > <a href="<?php echo $abspath.strtolower($_REQUEST['cid']).".html"; ?>" class="brelink"><?php echo  stripslashes($rssubcat['ja_catname']) ; ?></a> > <?php echo stripslashes($rssubcat['ja_subcat']); ?></div>
</div>
<?php
		  if($maxPage>1)
		 	{	
		echo'<div id="paging-box">'.
getPaginationURR($numrows,$rowsPerPage,$pageNum,$abspath."".$_REQUEST['cid']."/".$_REQUEST['sid']."/".$_REQUEST['searchperpage']."/".$_REQUEST['sortby'],"/","html","4").'</div>';
			}
?>
<div id="items">
<div id="items-text">Items per page:</div>
<div id="items-field">
  <select name="searchperpage" id="searchperpage" class="inp8" onchange="javascript:window.location.href='<?php echo $abspath.''.$_REQUEST["cid"].'/'.$_REQUEST["sid"].'/'; ?>'+this.value+'/<?php echo $_REQUEST["sortby"].'/'.$_REQUEST["page"].'.html'; ?>'">
   <option value="12" <?php if($_REQUEST['searchperpage']==12) echo "selected"; ?>>12</option>
	<option value="24" <?php if($_REQUEST['searchperpage']==24) echo "selected"; ?>>24</option>
    <option value="36" <?php if($_REQUEST['searchperpage']==36) echo "selected"; ?>>36</option>
    <option value="48" <?php if($_REQUEST['searchperpage']==48) echo "selected"; ?>>48</option>
	<option value="60" <?php if($_REQUEST['searchperpage']==60) echo "selected"; ?>>60</option>
  </select>
  </div>
</div>
 
</div>
<div id="search-keyboxout">
<div id="search-keybox">
 
  <div class="sort-box">
<div class="sort-by"><strong>Sort by:</strong></div>
<div class="sort-searchbox">
      
    <select name="sortby" id="sortby" class="inp7" onchange="javascript:window.location.href='<?php echo $abspath.''.$_REQUEST["cid"].'/'.$_REQUEST["sid"].'/'.$_REQUEST["searchperpage"].'/'; ?>'+this.value+'/<?php echo $_REQUEST["page"].'.html'; ?>'">
      <option value="0">Best Match</option>
	  <option value="1" <?php if($_REQUEST['sortby']=="1") echo  "selected=\"selected\""; ?>>Price: High to Low</option>
      <option value="2" <?php if($_REQUEST['sortby']=="2") echo  "selected=\"selected\""; ?>>Price: Low to High</option>
      <option value="3" <?php if($_REQUEST['sortby']=="3") echo  "selected=\"selected\""; ?>>Date: Old to New</option>
      <option value="4" <?php if($_REQUEST['sortby']=="4") echo  "selected=\"selected\""; ?> >Date: New to Old</option>
      </select>
  </div>
</div>
</div></div>
</form>
<div id="welcome-ddc-box">
<div id="left-link-box">
<div id="collection-heaading">47DDC コレクション </div>
<?php echo leftLink($abspath); ?>
</div>
<div id="products-box">
  <div id="post-72" class="post-72 page type-page status-publish hentry post-style">
    <div class="post-entry"> <span class="banner-inicio"></span>
        <div class="last_projects">
		  <?php 
		  	if(mysql_num_rows($rsprod)>0)
			{
				
				echo'<ul>';
				while($prodres = mysql_fetch_assoc($rsprod))
				{
					echo'<li><a href="'.$abspath.''.strtolower($_REQUEST['cid']).'/'.strtolower($_REQUEST['sid']).'/'.strtolower(stripslashes($prodres['eurl'])).'.html" title="'.stripslashes($prodres['jatitle']).'"><img src="'.$imagelist.$prodres['imagepath'].'" class="attachment-project-last wp-post-image" alt="pedropuig01" title="'.stripslashes($prodres['jatitle']).'" height="179" width="200" /><div style="top: 150px;" class="last_projects_caption"><p class="last_projects_caption_title">'.stripslashes($prodres['jatitle']).'</p><p class="last_projects_caption_desc">'.stripslashes(substr($prodres['jadescription'],0,59)).'</p><p class="last_projects_caption_desc">価格:'.$prodres['japrice'].'</p></div></a></li>';
				}
				echo '</ul>';
			}
			else
			{
					echo "なし 製品 発見"; 
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
