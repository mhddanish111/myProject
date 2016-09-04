<?php
session_start();
include("../include/connect.php");
include("include/page-add.php"); 
include("../db/db.php");
$url=$_SERVER['REQUEST_URI'];
$abspath = findAbs($url);
$imagepath = $abspath ."../gallery/large/";
$imagelist = $abspath ."../gallery/list/";
$pagesearch=1;
//print_r($_POST);
$orderby='order by p.id desc';
/////////////////////////////////////////////////////////// Saech Result Query in ///////////
$serchtext = mysql_real_escape_string(urldecode($_REQUEST['textfield']));
if(!empty($_REQUEST['selectsortby']))
{
	if($_REQUEST['selectsortby']=="HighToLow")
		$orderby = "order by p.japrice desc";
	else if($_REQUEST['selectsortby']=="LowToHigh")
		$orderby = "order by p.japrice asc";
	else if($_REQUEST['selectsortby']=="OldToNew")
		$orderby = "order by p.id ";
	else if($_REQUEST['selectsortby']=="NewToOld")
		$orderby = "order by p.id desc";
}
$cond='';	
	//echo $orderby;
	if($_REQUEST['selectcat']!='' && $_REQUEST['selectcat']!='All-Category') {
		$cond.=" and c.eurl='".$_REQUEST['selectcat']."' ";
	}	
	if($_REQUEST['selectsub']!='' && $_REQUEST['selectsub']!='All-Subcategory'){
		$cond.=" and s.eurl ='".$_REQUEST['selectsub']."' ";	
	}	
	
$sql="select p.id,p.imagepath,p.jatitle,p.jadescription,p.japrice,p.adddate,p.eurl as peurl,c.eurl as ceurl, s.eurl as seurl from product as p left join category as c on p.catid=c.id left join subcategory as s on s.catid=c.id where 1 $cond and p.status ='Y' and p.jatitle Like '%$serchtext%' OR p.japrice Like '%$serchtext%' $orderby";	
		
$numrows = mysql_num_rows(mysql_query($sql));
$rowsPerPage = $_REQUEST['searchperpage']!=""?$_REQUEST['searchperpage']:12;
//$rowsPerPage=3;
$pageNum = 1;
if(isset($_REQUEST['page']))
	$pageNum = $_REQUEST['page'];
$offset = ($pageNum - 1) * $rowsPerPage;
$maxPage= ceil($numrows/$rowsPerPage);
$rsprod=mysql_query($sql." LIMIT $offset, $rowsPerPage")or die(mysql_error());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="shortcut icon" href="<?php echo $abspath; ?>images/favicon.ico" type="image/x-icon">
<?php echo metaDescription($pagenav); ?>
<link href="<?php echo $abspath; ?>../style.css" rel="stylesheet" type="text/css" />

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
function pageSubmit(path){
	if(document.getElementById('textfield').value==""){
		alert("Please Enter Search Text in Search Box");
		document.getElementById('textfield').focus();
		return false;
	}
	else{
		var textfield=document.getElementById('textfield').value;
		var selectcat=document.getElementById('selectcat').value;
		var selectsub=document.getElementById('selectsub').value;
		var selectsortby=document.getElementById('selectsortby').value;
		var searchperpage=document.getElementById('searchperpage').value;
		var page=document.getElementById('page').value;
		var redircturl=escape(''+path+''+textfield+'/'+selectcat+'/'+selectsub+'/'+selectsortby+'/'+searchperpage+'/'+page+'.html');
		//alert(redircturl);
		window.location.href=redircturl;
	}
}
function isEnter(e,path){
var unicode=e.charCode? e.charCode : e.keyCode
if(unicode==13){ pageSubmit(path);}

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
<input type="hidden" name="page" id="page" value="<?php echo $pageNum; ?>" />
<div id="product-heading-box">
<div id="heading">
  <div id="breadcum"><a href="#" class="brelink">Search</a> > <?php echo $serchtext; ?></div>  
</div>
<?php
if($maxPage>1)
{
	echo'<div id="paging-box">'.getPaginationURR($numrows,$rowsPerPage,$pageNum,$abspath."".$_REQUEST['textfield']."/".$_REQUEST['selectcat']."/".$_REQUEST['selectsub']."/".$_REQUEST['selectsortby']."/".$_REQUEST['searchperpage'],"/","html","4").'</div>';

}
?>
<div id="items">
<div id="items-text">Items per page:</div>
<div id="items-field">
  <select name="searchperpage" id="searchperpage" class="inp8" onchange="pageSubmit('<?php echo $abspath; ?>');">
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
<div class="textfelid-searchbox">
      <label>
      <input name="textfield" type="text" id="textfield" value="<?php echo $_REQUEST['textfield']; ?>" onkeyup="return isEnter(event,'<?php echo $abspath; ?>')" class="inp5" />
      </label>
  </div>
  <div class="textfelid-searchbox1">
      
    <select name="selectcat" id="selectcat" class="inp6" onchange="getServerResponse1('selectsubdiv','AjaxHandler.php?query=selectsubsearch&dublicate='+this.value,'<?php echo $abspath; ?>',false)">
      <option value="All-Category">All Categories</option>
	<?php
	  $rscategory = rs_select("category where status ='Y' and ja_catname !='' ","*");
	while($resultcategory = mysql_fetch_assoc($rscategory))
	{
		if($resultcategory['eurl']==$_REQUEST['selectcat'])
			echo'<option value ="'.$resultcategory['eurl'].'" selected="selected">'.stripslashes($resultcategory['ja_catname']).'</option>';
		else
			echo'<option value ="'.$resultcategory['eurl'].'">'.stripslashes($resultcategory['ja_catname']).'</option>';
	}
?>
	  
                </select>
  </div>
  <div class="textfelid-searchbox1" id="selectsubdiv">
  <select name="selectsub" id="selectsub" class="inp6">
  <option value="All-Subcategory">Subcategories</option>
     <?php
	 $sqlsub="select scat.id,scat.ja_subcat,scat.eurl from subcategory as scat, category as cat where scat.catid=cat.id and scat.status='Y' and cat.eurl='".$_REQUEST['selectcat']."'";
	$subsel=mysql_query($sqlsub) or die(mysql_error());
	if(mysql_num_rows($subsel))
	{
		while($resultsub = mysql_fetch_assoc($subsel))
		{
			if($resultsub['eurl']==$_REQUEST['selectsub'])
			echo '<option value='.$resultsub['eurl'].' selected="selected">'.stripslashes($resultsub['ja_subcat']).'</option>';
			else
			echo '<option value='.$resultsub['eurl'].'>'.stripslashes($resultsub['ja_subcat']).'</option>';
		}
	} 
	?>
    </select>
  </div>
  <div class="search-but1"><img src="<?php echo $abspath; ?>images/search1.png" width="71" height="19" border="0" style="cursor:pointer;" onClick="pageSubmit('<?php echo $abspath; ?>');" /></div>
  <div class="sort-box">
<div class="sort-by"><strong>Sort by:</strong></div>
<div class="sort-searchbox">
      
     <select name="selectsortby" id="selectsortby" class="inp7" onchange="pageSubmit('<?php echo $abspath; ?>');">
      <option value="BestMatch">Best Match</option>
	  <option value="HighToLow" <?php if($_REQUEST['selectsortby']=="HighToLow") echo  "selected=\"selected\""; ?>>Price: High to Low</option>
      <option value="LowToHigh" <?php if($_REQUEST['selectsortby']=="LowToHigh") echo  "selected=\"selected\""; ?>>Price: Low to High</option>
      <option value="OldToNew" <?php if($_REQUEST['selectsortby']=="OldToNew") echo  "selected=\"selected\""; ?>>Date: Old to New</option>
      <option value="NewToOld" <?php if($_REQUEST['selectsortby']=="NewToOld") echo  "selected=\"selected\""; ?> >Date: New to Old</option>
      </select>
  </div>
</div>
</div></div>

<div id="welcome-ddc-box">
<div id="left-link-box">
<div id="collection-heaading">47DDC COLLECTION </div>

<div id="left-links">
<?php 
$rscat1 = rs_select("category where status ='Y' and ja_catname !='' ","*");
	while($rescat1 = mysql_fetch_assoc($rscat1))
	{
		if($rescat1['eurl']==$_REQUEST['selectcat'])
			echo'<div class="l1"><a id="l1-active"><strong>'.stripslashes($rescat1['ja_catname']).'</strong></a></div>';
		else
			echo'<div class="l1"><a href="'.$abspath.''.strtolower($rescat1['eurl']).'.html">'.stripslashes($rescat1['ja_catname']).'</a></div>';
		if($rescat1['eurl']==$_REQUEST['selectcat'])
		{
			$rssub1 = rs_select("subcategory where catid='".$rescat1['id']."' and status ='Y' and ja_subcat !='' ","*");
			while($ressub1 = mysql_fetch_assoc($rssub1))
			{
				if($_REQUEST['selectsub']==$ressub1['eurl'])
					echo'<div class="sublink"><a href="'.$abspath.''.strtolower($rescat1['eurl']).'/'.strtolower($ressub1['eurl']).'/12/1/1.html" id="sublink-active">'.stripslashes($ressub1['ja_subcat']).'</a></div>';
				else
					echo'<div class="sublink"><a href="'.$abspath.''.strtolower($rescat1['eurl']).'/'.strtolower($ressub1['eurl']).'/12/1/1.html">'.stripslashes($ressub1['ja_subcat']).'</a></div>';
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
					echo'<li><a href="'.$abspath.''.strtolower($prodres['ceurl']).'/'.strtolower($prodres['seurl']).'/'.strtolower(stripslashes($prodres['peurl'])).'.html" title="'.stripslashes($prodres['jatitle']).'"><img src="'.$imagelist.$prodres['imagepath'].'" class="attachment-project-last wp-post-image" alt="pedropuig01" title="'.stripslashes($prodres['jatitle']).'" height="179" width="200" /><div style="top: 150px;" class="last_projects_caption"><p class="last_projects_caption_title">'.stripslashes($prodres['jatitle']).'</p><p class="last_projects_caption_desc">'.stripslashes(substr($prodres['jadescription'],0,59)).'</p><p class="last_projects_caption_desc">Price: $'.$prodres['japrice'].'</p><p class="last_projects_caption_desc">Add date: '.$prodres['adddate'].'</p></div></a></li>';
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
