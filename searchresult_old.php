<?php
session_start();
include("include/connect.php");
include("include/page-add.php"); 
include("db/db.php");
$url=$_SERVER['REQUEST_URI'];
$abspath = findAbs($url);
$imagepath = $abspath."gallery/large/";
$imagelist = $abspath."gallery/list/";
$pagesearch=1;
//print_r($_POST);
/////////////////////////////////////////////////////////// Saech Result Query in ///////////
$serchtext = mysql_real_escape_string($_REQUEST['textfield']);
if(!empty($_POST['selectsortby']))
{
	if($_POST['selectsortby']=="highttolow")
		$orderby = "p.price desc";
	else if($_POST['selectsortby']=="lowtohigh")
		$orderby = "p.price asc";
	else if($_POST['selectsortby']=="oldtonew")
		$orderby = "p.id ";
	else if($_POST['selectsortby']=="newtoold")
		$orderby = "p.id desc";
}
else
	$orderby = "p.id";
$cond='';	
	//echo $orderby;
	if(!empty($_POST['selectcat']))
		$cond.=" and p.catid='".$_POST['selectcat']."' ";
	if(!empty($_POST['selectsub']))
		$cond.=" and p.subcatid ='".$_POST['selectsub']."' ";	
	
$sql="select p.id,p.imagepath,p.title,p.description,p.price,p.adddate,p.eurl as peurl,c.eurl as ceurl, s.eurl as seurl from product as p left join category as c on p.catid=c.id left join subcategory as s on s.catid=c.id where 1 $cond and p.status ='Y' and p.title Like '%$serchtext%' OR p.price Like '%$serchtext%' order by $orderby";	
		
$numrows = mysql_num_rows(mysql_query($sql));
$rowsPerPage = $_POST['searchperpage']!=""?$_POST['searchperpage']:12;
//$rowsPerPage=3;
$pageNum = 1;
if(isset($_POST['page']))
	$pageNum = $_POST['page'];
$offset = ($pageNum - 1) * $rowsPerPage;
$maxPage= ceil($numrows/$rowsPerPage);
$rsprod=mysql_query($sql." LIMIT $offset, $rowsPerPage")or die(mysql_error());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php echo showTitleFab($pagenav); ?>
<?php echo metaDescription($pagenav); ?>
<link href="<?php echo $abspath; ?>style.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?php echo $abspath; ?>css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $abspath; ?>css/style.css" type="text/css" media="screen" />

<script src="<?php echo $abspath; ?>js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/main.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="<?php echo $abspath; ?>javascript2/style.css">
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/jquery_003.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/easySlider1.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/jquery.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/this-theme.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/svb.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/AjaxHandler.js"></script>
<script type="text/javascript" language="javascript">
function pageSubmit()
{
	document.forms["frmsearch"].submit();
}
</script>
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
<form action="searchresult.html" id="frmsearch" name="frmsearch" method="post" enctype="multipart/form-data">
<input type="hidden" name="page" id="page" value="<?php echo $pageNum; ?>" />
<div id="product-heading-box">
<div id="heading">
  <div id="breadcum"><a href="#" class="brelink">Search</a> > <?php echo $_REQUEST['textfield']; ?></div>  
</div>
<div id="items">
<div id="items-text">Items per page:</div>
<div id="items-field">
  <select name="searchperpage" id="searchperpage" class="inp8" onchange="pageSubmit();">
    <option value="12" <?php if($_REQUEST['searchperpage']==12) echo "selected"; ?>>12</option>
    <option value="24" <?php if($_REQUEST['searchperpage']==24) echo "selected"; ?>>24</option>
    <option value="36" <?php if($_REQUEST['searchperpage']==36) echo "selected"; ?>>36</option>
	<option value="48" <?php if($_REQUEST['searchperpage']==48) echo "selected"; ?>>48</option>
	<option value="60" <?php if($_REQUEST['searchperpage']==60) echo "selected"; ?>>60</option>
  </select>
  </div>
</div>

<!--<div id="paging-box">
                  <div class="port-links"><a href="#">Next >></a></div>
                <div class="port-links"><a href="#">5</a></div>
                <div class="port-links"><a href="#">4</a></div>
                <div class="port-links"><a href="#">3</a></div>
                <div class="port-links"><a href="#">2</a></div>
                <div class="port-links"><a href="#" id="port-links-active" >1</a></div>
              </div>-->

<?php
if($maxPage>1)
{
	echo'<div id="paging-box">'.getPaginationForSearch($numrows,$rowsPerPage,$pageNum,"searchresult.html","","4").'</div>';
}
?>
</div>
<div id="search-keyboxout">
<div id="search-keybox">
<div class="textfelid-searchbox">
      <label>
      <input name="textfield" type="text" id="textfield" value="<?php echo $_REQUEST['textfield']; ?>" class="inp5" />
      </label>
  </div>
  <div class="textfelid-searchbox1">
      
    <select name="selectcat" id="selectcat" class="inp6" onchange="getServerResponse1('selectsub','AjaxHandler.php?query=selectsub&dublicate='+this.value,'',false)">
      <option value="">All Categories</option>
	<?php
	  $rscategory = rs_select("category where status ='Y' and catname !='' ","*");
	while($resultcategory = mysql_fetch_assoc($rscategory))
	{
		if($resultcategory['id']==$_POST['selectcat'])
			echo'<option value ="'.$resultcategory['id'].'" selected="selected">'.stripslashes($resultcategory['catname']).'</option>';
		else
			echo'<option value ="'.$resultcategory['id'].'">'.stripslashes($resultcategory['catname']).'</option>';
	}
?>
	  
                </select>
  </div>
  <div class="textfelid-searchbox1">
  <select name="selectsub" id="selectsub" class="inp6">
  <option value="">Subcategories</option>
     <?php
	 $subsel = mysql_query("select subcat,catid,id from subcategory where status ='Y' and catid='".$_REQUEST['selectcat']."' and subcat !=''");
	//$catres = mysql_fetch_assoc($subsel);
	if(mysql_num_rows($subsel))
	{
		while($resultsub = mysql_fetch_assoc($subsel))
		{
			if($resultsub['id']==$_REQUEST['selectsub'])
			echo '<option value='.$resultsub['id'].' selected="selected">'.stripslashes($resultsub['subcat']).'</option>';
			else
			echo '<option value='.$resultsub['id'].'>'.stripslashes($resultsub['subcat']).'</option>';
		}
	} 
	?>
    </select>
  </div>
  <div class="search-but1"><input type="image" src="<?php echo $abspath; ?>images/search1.png" width="71" height="19" border="0" style="cursor:pointer;" onClick="return searchValidation();" /></div>
  <div class="sort-box">
<div class="sort-by"><strong>Sort by:</strong></div>
<div class="sort-searchbox">
      
    <select name="selectsortby" id="selectsortby" class="inp7" onchange="pageSubmit();">
      <option value="">Best Match</option>
	  <option value="highttolow" <?php if($_REQUEST['selectsortby']=="highttolow") echo  "selected=\"selected\""; ?>>Price: High to Low</option>
      <option value="lowtohigh" <?php if($_REQUEST['selectsortby']=="lowtohigh") echo  "selected=\"selected\""; ?>>Price: Low to High</option>
      <option value="oldtonew" <?php if($_REQUEST['selectsortby']=="oldtonew") echo  "selected=\"selected\""; ?>>Date: Old to New</option>
      <option value="newtoold" <?php if($_REQUEST['selectsortby']=="newtoold") echo  "selected=\"selected\""; ?> >Date: New to Old</option>
      </select>
  </div>
</div>
</div></div>
</form>
<div id="welcome-ddc-box">
<div id="left-link-box">
<div id="collection-heaading">47DDC COLLECTION </div>

<div id="left-links">
<?php 
$rscat1 = rs_select("category where status ='Y' and catname !='' ","*");
	while($rescat1 = mysql_fetch_assoc($rscat1))
	{
		if($rescat1['id']==$_REQUEST['selectcat'])
			echo'<div class="l1"><a id="l1-active"><strong>'.stripslashes($rescat1['catname']).'</strong></a></div>';
		else
			echo'<div class="l1"><a href="'.$abspath.''.strtolower($rescat1['eurl']).'.html">'.stripslashes($rescat1['catname']).'</a></div>';
		if($rescat1['id']==$_REQUEST['selectcat'])
		{
			$rssub1 = rs_select("subcategory where catid='".$_REQUEST['selectcat']."' and status ='Y' and subcat !='' ","*");
			while($ressub1 = mysql_fetch_assoc($rssub1))
			{
				if($_REQUEST['selectsub']==$ressub1['id'])
					echo'<div class="sublink"><a href="'.$abspath.''.strtolower($rescat1['eurl']).'/'.strtolower($ressub1['eurl']).'.html" id="sublink-active">'.stripslashes($ressub1['subcat']).'</a></div>';
				else
					echo'<div class="sublink"><a href="'.$abspath.''.strtolower($rescat1['eurl']).'/'.strtolower($ressub1['eurl']).'.html">'.stripslashes($ressub1['subcat']).'</a></div>';
			}
		}
  	}
?>
</div>
</div>

<div id="products-box">
  <div id="post-72" class="post-72 page type-page status-publish hentry post-style">
    <div class="post-entry"> <span class="banner-inicio"></span>
        <div class="last_projects">
          <?php  
		  if($numrows>0)
			{
				
				echo'<ul>';
				while($prodres = mysql_fetch_assoc($rsprod))
				{
					echo'<li><a href="'.$abspath.''.strtolower($prodres['ceurl']).'/'.strtolower($prodres['seurl']).'/'.strtolower(stripslashes($prodres['peurl'])).'.html"><img src="'.$imagelist.$prodres['imagepath'].'" class="attachment-project-last wp-post-image" alt="pedropuig01" title="'.stripslashes($prodres['title']).'" height="179" width="200" /><div style="top: 150px;" class="last_projects_caption"><p class="last_projects_caption_title">'.stripslashes($prodres['title']).'</p><p class="last_projects_caption_desc">'.stripslashes(substr($prodres['description'],0,59)).'</p><p class="last_projects_caption_desc">Price: $'.$prodres['price'].'</p><p class="last_projects_caption_desc">Add date: '.$prodres['adddate'].'</p></div></a></li>';
				}
				echo '</ul>';
			}
			else
			{
					echo "No Product Found"; 
			}
		  ?>
            
          </ul>
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

</body>
</html>
