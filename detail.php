<?php
session_start();
$pagenav=4;
$pagenavsub=2;
include("include/connect.php");
include("include/page-add.php"); 
include("db/db.php");
$url=$_SERVER['REQUEST_URI'];
$abspath = findAbs($url);
$imagepath = $abspath."gallery/large/";
$imagelist = $abspath."gallery/list/";
$cart_div_status="display:none;";
	if(isset($_SESSION["cart_item"]))
	{
		$added_item=$_SESSION["cart_item"];
		
		if($_SESSION["cart_item"]>0)
			$cart_div_status="display:block;";
}
if(!empty($_REQUEST['pid']))
{
$rs = mysql_query("SELECT product.*,category.catname,subcategory.subcat FROM product LEFT JOIN category ON product.catid = category.id LEFT JOIN subcategory ON product.subcatid = subcategory.id WHERE product.eurl ='".$_REQUEST['pid']."' and category.eurl='".$_REQUEST['cid']."' and subcategory.eurl='".$_REQUEST['sid']."'");
//echo "SELECT product.*,category.catname,subcategory.subcat FROM product LEFT JOIN category ON product.catid = category.id LEFT JOIN subcategory ON product.subcatid = subcategory.id WHERE product.eurl ='".$_REQUEST['pid']."' and category.eurl='".$_REQUEST['cid']."' and subcategory.eurl='".$_REQUEST['sid']."'";
}
else
{
	$rs = mysql_query("SELECT product. * , category.catname, subcategory.subcat FROM product LEFT JOIN category ON product.catid = category.id LEFT JOIN subcategory ON product.subcatid = subcategory.id order by product.id desc limit 0,1");
}
$rsprod = mysql_fetch_assoc($rs);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php //echo showTitleFab($pagenav); ?>
<?php //echo metaDescription($pagenav); ?>
<link rel="shortcut icon" href="<?php echo $abspath; ?>images/favicon.ico" type="image/x-icon">
<title><?php if(!empty($rsprod['seotitle'])) echo stripslashes($rsprod['seotitle']);
				else echo "47th DDC; Diamonds, Gemstones, Jewelry, Watches and Art."; ?></title>
<meta name="keywords" content="<?php echo stripslashes($rsprod['keyword']); ?>" />
<meta name="description" content="<?php echo stripslashes($rsprod['seodescription']); ?>" />
<link href="<?php echo $abspath; ?>style.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?php echo $abspath; ?>css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $abspath; ?>css/style.css" type="text/css" media="screen" />
<!--<link rel="stylesheet" href="<?php //echo $abspath; ?>lightbox.css" type="text/css" media="screen" />-->
<style>
.myFloatBarview{
   bottom:25%;
   right:0px;
   height:5%;
   position:fixed;
	 font-size:17px;
	  color:#E51B26; 
	 padding-left:1%;
	  text-align:left; 
	 font-weight:bold; 
	 text-decoration:none;
	 cursor:hand;
}
.myFloatCart{
   bottom:0px;
   right:0px;
   width:600px;
   position:fixed;
   border:solid 1px #333333;
    background-color:#ffffff;  
   	 font-size: 14px;
	line-height: 19px;
	padding: 5px 10px 5px 0px;
	align:left;
	 display:none;
	 overflow: scroll;   
}
.myFloatBarhide{
   
   height:5%;
	 font-size:17px;
	  color:#E51B26;
	  text-align:left; 
	 font-weight:bold; 
	 text-decoration:none;
	 cursor:hand;
	 }
</style>
<script type='text/JavaScript' src='<?php echo $abspath; ?>js/viewcart.js'></script>
<script src="<?php echo $abspath; ?>js/af_js.js" type="text/javascript"></script>
<script src="<?php echo $abspath; ?>js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/main.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/prototype.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/scriptaculous.js?load=effects,builder"></script>
<!--<script type="text/javascript" src="<?php //echo $abspath; ?>js/lightbox.js"></script>-->

<link rel="stylesheet" type="text/css" media="all" href="<?php echo $abspath; ?>javascript2/style.css">
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/jquery_003.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/easySlider1.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/jquery.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/this-theme.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/jawelary.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/svb.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/AjaxHandler.js"></script>
<!-- Light Box -->
<link rel="stylesheet" type="text/css" href="<?php echo $abspath; ?>lightbo/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript" src="<?php echo $abspath; ?>lightbo/jquery.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>lightbo/jquery.lightbox-0.5.js"></script>
<script type="text/javascript">
    $(function() {
        $('#detail-left-box a').lightBox();
    });
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
<div id="product-heading-box">
<div id="heading">
  <div id="breadcum"><a href="<?php echo $abspath; ?>index.html" class="brelink">Home</a> > <a href="<?php echo $abspath; ?><?php echo strtolower($_REQUEST['cid']).".html"; ?>" class="brelink"><?php echo stripslashes($rsprod['catname']); ?></a> > <a href="<?php echo $abspath; ?><?php echo strtolower($_REQUEST['cid'])."/".strtolower($_REQUEST['sid'])."/12/1/1.html"; ?>" class="brelink"><?php echo stripslashes($rsprod['subcat']); ?></a> &gt;&nbsp;<?php echo stripcslashes($rsprod['title'])  ?></div>
</div>

</div>
<div id="welcome-ddc-box">
<div id="left-link-box">
<div id="collection-heaading">47DDC COLLECTION </div>
<?php echo leftLink($abspath); ?>
</div>
<?php
if(mysql_num_rows($rs)>0)
{
?>
	<div id="products-detail-box">
	<!-- detail left start//-->
		<div id="detail-left-box">
			<div id="big-image-box">
  				<div align="center"><a href="<?php echo $imagepath.$rsprod['imagepath']; ?>" >
					<img src="<?php echo $imagelist.$rsprod['imagepath']; ?>" alt="detail" width="328" height="288" vspace="1" border="0" /></a></div>
			</div>
			<div id="buy-now-box">
			<div id="buy-now"><?php if($rsprod['soldproduct']<$rsprod['productstock'])
				{
							 echo'<span id="addtocart_span'.$rsprod["id"].'">';
							if($_SESSION["incart_".$rsprod["id"]]=="YES")
							{
								echo '<img src="'.$abspath.'images/added.gif" alt="added to cart" />';
							}
							else
							{	
								echo '<img src="'.$abspath.'images/add-cart.gif" alt="add to cart" style="cursor:pointer" onClick="cartSetup(\''.$abspath.'UserAjaxHandler.php?query=addtocart&product_id='.$rsprod["id"].'\',\'addtocart\',\''.$rsprod["id"].'\',\''.$abspath.'\');">';
							}	
							echo '</span>';
				}
				else
				{
					echo'<img src="'.$abspath.'images/outof-stock.gif" border="0" />';
				}
							  ?> 
					</div>
</div>
<?php 
			$selimg = rs_select("db_image where productid='".$rsprod['id']."'","*");
			if(mysql_num_rows($selimg)>0)
			{
				echo'<div id="more-heading"><strong>More Images</strong></div>
				<div id="more-images-box">';
				while($imgres = mysql_fetch_assoc($selimg))
				{
					echo'<div class="small-image-box">
					<div align="center"><a href="'.$imagepath.$imgres['imagepath'].'"><img src="'.$imagelist.$imgres['imagepath'].'" alt="47ddc" width="71" height="71" vspace="1" border="0" /></a></div></div>';
				}
	    		echo'</div>';
			}
 ?>			
			<div id="detail-heading"><strong>Product Detail</strong></div>
			<div id="detail-text"><?php echo stripslashes($rsprod['description']); ?> </div>
			
		</div>
<!-- detail left end//-->

		<div id="detail-right-box">
			<div id="product-name-box"><?php echo stripslashes($rsprod['title']); ?></div>
			<div class="product-heading">General Information</div>
			<div class="info-out-box">
			<?php
				  echo'<div class="info-box"><div class="info-left-box">Category:</div><div class="info-right-box">'.stripslashes($rsprod['catname']).'</div></div>';
				  echo'<div class="info-box"><div class="info-left-box">Sub Category:</div><div class="info-right-box">'.stripslashes($rsprod['subcat']).'</div></div>';
				if(!empty($rsprod['title']))
				{
					echo '<div class="info-box"><div class="info-left-box">Title:</div><div class="info-right-box">'.stripslashes($rsprod['title']).'</div></div>';
				}
				if(!empty($rsprod['condition']))
				{
					echo'<div class="info-box"><div class="info-left-box">Condition:</div><div class="info-right-box">'.stripslashes($rsprod['condition']).'</div></div>';
				}
				if(!empty($rsprod['stock']))
				{
					echo'<div class="info-box"><div class="info-left-box">Stock Number:</div><div class="info-right-box">'.stripslashes($rsprod['stock']).'</div></div>';
				}
				if(!empty($rsprod['price']))
				{
					echo'<div class="info-box"><div class="info-left-box">Price:</div><div class="info-right-box">$'.stripslashes($rsprod['price']).'</div></div>';
				}
?>
			</div>
<?php
			if(!empty($rsprod['brname']) || (!empty($rsprod['jehallmarks'])) || (!empty($rsprod['jeperiod'])) || (!empty($rsprod['jediamond'])) || (!empty($rsprod['jediamondcolor'])) || (!empty($rsprod['jediamondcl'])) ||  (!empty($rsprod['jemetal'])) || (!empty($rsprod['jemetailpu'])) || (!empty($rsprod['jempriceweight'])) || (!empty($rsprod['jedimension'])) || (!empty($rsprod['jefingersize'])) || ($rsprod['jeselect']=="1"))
			{
				echo'<div class="product-heading">Jewelry Information</div>
				<div class="info-out-box">';
				if(!empty($rsprod['brname']))
				{
					echo'<div class="info-box"><div class="info-left-box">Brand Name:</div><div class="info-right-box">'.stripslashes($rsprod['brname']).'</div></div>';
				}
				if(!empty($rsprod['jehallmarks']))
				{
					echo'<div class="info-box"><div class="info-left-box">Hallmarks/Origin:</div><div class="info-right-box">'.stripslashes($rsprod['jehallmarks']).'</div></div>';
				}
				if(!empty($rsprod['jeperiod']))
				{
					echo'<div class="info-box">
					<div class="info-left-box">Period:</div>
					<div class="info-right-box">'.stripslashes($rsprod['jeperiod']).'</div>
					</div>';
				}
				if(!empty($rsprod['jediamond']))
				{
					echo'<div class="info-box">
					<div class="info-left-box">Total Diamond Weight:</div>
					<div class="info-right-box">'.stripslashes($rsprod['jediamond']).'</div>
					</div>';
				}
	if(!empty($rsprod['jediamondcolor']))
 	{	
		echo'<div class="info-box">
		<div class="info-left-box">Diamond Color:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jediamondcolor']).'</div>
		</div>';
	}
	if(!empty($rsprod['jediamondcl']))
 	{	
		echo'<div class="info-box">
		<div class="info-left-box">Diamond Clarity:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jediamondcl']).'</div>
		</div>';
	}
	if(!empty($rsprod['jestoneweight']))
 	{	
		echo'<div class="info-box">
		<div class="info-left-box">Total Gemstone Weight:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jestoneweight']).'</div>
		</div>';
	}
	if(!empty($rsprod['jestonecolor']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Gemstone Color:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jestonecolor']).'</div>
		</div>';
	}
	if(!empty($rsprod['jediamondcl']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Gemstone Clarity:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jediamondcl']).'</div>
		</div>';
	}
	if(!empty($rsprod['jemetal']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Metal:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jemetal']).'</div>
		</div>';
	}
	if(!empty($rsprod['jemetailpu']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Metal Purity:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jemetailpu']).'</div>
		</div>';
	}
	if(!empty($rsprod['jempriceweight']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Total Piece Weight:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jempriceweight']).'</div>
		</div>';
	}
	if(!empty($rsprod['jedimension']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Dimensions:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jedimension']).'</div>
		</div>';
	}
	if(!empty($rsprod['jefingersize']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Finger Size:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jefingersize']).'</div>
		</div>';
	}
	if($rsprod['jeselect']=="1")
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Sizable:</div>
		<div class="info-right-box">'; 
										if($rsprod['jeselect']=="1")
										{
											echo "YES";
										}
										else
										{
										   echo "NO";
										}
										
		echo '</div>
		</div>';
	}
	?>	
	</div>
<?php } ?>
<?php
	if(!empty($rsprod['diaweight']) || (!empty($rsprod['diashap'])) || (!empty($rsprod['dialab'])) || (!empty($rsprod['diacolor'])) || (!empty($rsprod['diaclarity'])) || (!empty($rsprod['diacut'])) ||  (!empty($rsprod['daipolish'])) || (!empty($rsprod['diasymmetry'])) || (!empty($rsprod['diafluor'])) || (!empty($rsprod['diatable'])) || (!empty($rsprod['diadepth'])) || (!empty($rsprod['diameasurment'])) || (!empty($rsprod['diaremarks'])) || (!empty($rsprod['diapercarat'])) || (!empty($rsprod['diatotalprice'])))
	{
	?>
		<div class="product-heading">Diamond Information</div>
		<div class="info-out-box">
	<?php
	if(!empty($rsprod['diaweight']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Weight:</div>
		<div class="info-right-box">'.stripslashes($rsprod['diaweight']).'</div>
		</div>';
	}
	if(!empty($rsprod['diashap']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Shape:</div>
		<div class="info-right-box">'.stripslashes($rsprod['diashap']).'</div>
		</div>';
	}
	if(!empty($rsprod['dialab']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Lab/Certificate:</div>
		<div class="info-right-box">'.stripslashes($rsprod['dialab']).'</div>
		</div>';
	}
	if(!empty($rsprod['diacolor']))
 	{	
		echo'<div class="info-box">
		<div class="info-left-box">Color:</div>
		<div class="info-right-box">'.stripslashes($rsprod['diacolor']).'</div>
		</div>';
	}
	if(!empty($rsprod['diaclarity']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Clarity:</div>
		<div class="info-right-box">'.stripslashes($rsprod['diaclarity']).'</div>
		</div>';
	}
	if(!empty($rsprod['diacut']))
 	{	
		echo'<div class="info-box">
		<div class="info-left-box">Cut:</div>
		<div class="info-right-box">'.stripslashes($rsprod['diacut']).'</div>
		</div>';
	}
	if(!empty($rsprod['daipolish']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Polish:</div>
		<div class="info-right-box">'.stripslashes($rsprod['daipolish']).'</div>
		</div>';
	}
	if(!empty($rsprod['diasymmetry']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Symmetry:</div>
		<div class="info-right-box">'.stripslashes($rsprod['diasymmetry']).'</div>
		</div>';
	}
	if(!empty($rsprod['diafluor']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Fluorescence:</div>
		<div class="info-right-box">'.stripslashes($rsprod['diafluor']).'</div>
		</div>';
	}
	if(!empty($rsprod['diatable']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Table %:</div>
		<div class="info-right-box">'.stripslashes($rsprod['diatable']).'</div>
		</div>';
	}
	if(!empty($rsprod['diadepth']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Depth %:</div>
		<div class="info-right-box">'.stripslashes($rsprod['diadepth']).'</div>
		</div>';
	}
	if(!empty($rsprod['diameasurment']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Measurements:</div>
		<div class="info-right-box">'.stripslashes($rsprod['diameasurment']).'</div>
		</div>';
	}
	if(!empty($rsprod['diaremarks']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Remarks:</div>
		<div class="info-right-box">'.stripslashes($rsprod['diaremarks']).'</div>
		</div>';
	}
	if(!empty($rsprod['diapercarat']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Price Per Carat:</div>
		<div class="info-right-box">'.stripslashes($rsprod['diapercarat']).'</div>
		</div>';
	}
	if(!empty($rsprod['diatotalprice']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Total Price:</div>
		<div class="info-right-box">'.stripslashes($rsprod['diatotalprice']).'</div>
		</div>';
	}
	?>
		</div>
	<?php } ?>
	<?php
	if(!empty($rsprod['gemcarat']) || (!empty($rsprod['gemstonetype'])) || (!empty($rsprod['gemshape'])) || (!empty($rsprod['gemcolor'])) || (!empty($rsprod['gemclarity'])) || (!empty($rsprod['gemcut'])) ||  (!empty($rsprod['gemorigin'])) || (!empty($rsprod['gemtreatment'])) || (!empty($rsprod['gemlab'])) || (!empty($rsprod['gemremarks'])))
	{
	?>
		<div class="product-heading">Gemstone Information</div>
		<div class="info-out-box">
	<?php
	if(!empty($rsprod['gemcarat']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Carat Weight:</div>
		<div class="info-right-box">'.stripslashes($rsprod['gemcarat']).'</div>
		</div>';
	}
	if(!empty($rsprod['gemstonetype']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Gemstone Type:</div>
		<div class="info-right-box">'.stripslashes($rsprod['gemstonetype']).'</div>
		</div>';
	}
	if(!empty($rsprod['gemshape']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Shape:</div>
		<div class="info-right-box">'.stripslashes($rsprod['gemshape']).'</div>
		</div>';
	}
	if(!empty($rsprod['gemcolor']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Color:</div>
		<div class="info-right-box">'.stripslashes($rsprod['gemcolor']).'</div>
		</div>';
	}
	if(!empty($rsprod['gemclarity']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Clarity:</div>
		<div class="info-right-box">'.stripslashes($rsprod['gemclarity']).'</div>
		</div>';
	}
	if(!empty($rsprod['gemcut']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Cut:</div>
		<div class="info-right-box">'.stripslashes($rsprod['gemcut']).'</div>
		</div>';
	}
	if(!empty($rsprod['gemorigin']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Origin:</div>
		<div class="info-right-box">'.stripslashes($rsprod['gemorigin']).'</div>
		</div>';
	}
	if(!empty($rsprod['gemtreatment']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Treatment:</div>
		<div class="info-right-box">'.stripslashes($rsprod['gemtreatment']).'</div>
		</div>';
	}
	if(!empty($rsprod['gemlab']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Lab/Certificate:</div>
		<div class="info-right-box">'.stripslashes($rsprod['gemlab']).'</div>
		</div>';
	}
	if(!empty($rsprod['gemremarks']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Remarks:</div>
		<div class="info-right-box">'.stripslashes($rsprod['gemremarks']).'</div>
		</div>';
	}
	echo'</div>';
}
if(!empty($rsprod['watbrand']) || (!empty($rsprod['watmodel'])) || (!empty($rsprod['watgender'])) || (!empty($rsprod['watage'])) || (!empty($rsprod['watfeatures'])) || (!empty($rsprod['watfeatures1'])) ||  (!empty($rsprod['watfeatures2'])) || (!empty($rsprod['watfeatures3'])) || (!empty($rsprod['watmovement'])) || (!empty($rsprod['watcase'])) || (!empty($rsprod['watband'])) || (!empty($rsprod['watcarat'])) || (!empty($rsprod['watbox'])) || (!empty($rsprod['watwarranty'])) || (!empty($rsprod['watremarks'])))
{
	echo'<div class="product-heading">Watch Information</div>
	<div class="info-out-box">';
	if(!empty($rsprod['watbrand']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Brand Name:</div>
		<div class="info-right-box">'.stripslashes($rsprod['watbrand']).'</div>
		</div>';
	}
	if(!empty($rsprod['watmodel']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Model:</div>
		<div class="info-right-box">'.stripslashes($rsprod['watmodel']).'</div>
		</div>';
	}
	if(!empty($rsprod['watgender']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Gender:</div>
		<div class="info-right-box">'.stripslashes($rsprod['watgender']).'</div>
		</div>';
	}
	if(!empty($rsprod['watage']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Age/Condition:</div>
		<div class="info-right-box">'.stripslashes($rsprod['watage']).'</div>
		</div>';
	}
	if(!empty($rsprod['watfeatures']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Features:</div>
		<div class="info-right-box">'.stripslashes($rsprod['watfeatures']).'</div>
		</div>';
	}
	if(!empty($rsprod['watfeatures1']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box"></div>
		<div class="info-right-box">'.stripslashes($rsprod['watfeatures1']).'</div>
		</div>';
	}
	if(!empty($rsprod['watfeatures2']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box"></div>
		<div class="info-right-box">'.stripslashes($rsprod['watfeatures2']).'</div>
		</div>';
	}
	if(!empty($rsprod['watfeatures3']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box"></div>
		<div class="info-right-box">'.stripslashes($rsprod['watfeatures3']).'</div>
		</div>';
	}
	if(!empty($rsprod['watmovement']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Movement:</div>
		<div class="info-right-box">'.stripslashes($rsprod['watmovement']).'</div>
		</div>';
	}
	if(!empty($rsprod['watcase']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Case Material:</div>
		<div class="info-right-box">'.stripslashes($rsprod['watcase']).'</div>
		</div>';
	}
	if(!empty($rsprod['watband']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Band Material:</div>
		<div class="info-right-box">'.stripslashes($rsprod['watband']).'</div>
		</div>';
	}
	if(!empty($rsprod['watcarat']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Carat Weight:</div>
		<div class="info-right-box">'.stripslashes($rsprod['watcarat']).'</div>
		</div>';
	}
	if(!empty($rsprod['watbox']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Box & Papers:</div>
		<div class="info-right-box">'.stripslashes($rsprod['watbox']).'</div>
		</div>';
	}
	if(!empty($rsprod['watwarranty']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Warranty:</div>
		<div class="info-right-box">'.stripslashes($rsprod['watwarranty']).'</div>
		</div>';
	}
	if(!empty($rsprod['watremarks']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Remarks:</div>
		<div class="info-right-box">'.stripslashes($rsprod['watremarks']).'</div>
		</div>';
	}
	echo'</div>';
}
if(!empty($rsprod['objbrandname']) || (!empty($rsprod['objhall'])) || (!empty($rsprod['objperiod'])) || (!empty($rsprod['objstyle'])) || (!empty($rsprod['objmaterial'])) || (!empty($rsprod['objdimensions'])) || (!empty($rsprod['objweight'])) || (!empty($rsprod['objremarks'])))
{
	echo'<div class="product-heading">Object Information</div>
		<div class="info-out-box">';
	if(!empty($rsprod['objbrandname']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Brand Name:</div>
		<div class="info-right-box">'.stripslashes($rsprod['objbrandname']).'</div>
		</div>';
	}
	if(!empty($rsprod['objhall']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Hallmarks/Origin:</div>
		<div class="info-right-box">'.stripslashes($rsprod['objhall']).'</div>
		</div>';
	}
	if(!empty($rsprod['objperiod']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Period:</div>
		<div class="info-right-box">'.stripslashes($rsprod['objperiod']).'</div>
		</div>';
	}
	if(!empty($rsprod['objstyle']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Style:</div>
		<div class="info-right-box">'.stripslashes($rsprod['objstyle']).'</div>
		</div>';
	}
	if(!empty($rsprod['objmaterial']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Material:</div>
		<div class="info-right-box">'.stripslashes($rsprod['objmaterial']).'</div>
		</div>';
	}
	if(!empty($rsprod['objdimensions']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Dimensions:</div>
		<div class="info-right-box">'.stripslashes($rsprod['objdimensions']).'</div>
		</div>';
	}
	if(!empty($rsprod['objweight']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Weight:</div>
		<div class="info-right-box">'.stripslashes($rsprod['objweight']).'</div>
		</div>';
	}
	if(!empty($rsprod['objremarks']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">Remarks:</div>
		<div class="info-right-box">'.stripslashes($rsprod['objremarks']).'</div>
		</div>';
	}
	echo'</div>';
}
$rsmore = rs_select("moreproduct where productid='".$rsprod['id']."'","*"); 
if(mysql_num_rows($rsmore)>0)
{
	echo'<div class="product-heading">Other Information</div>
		 <div class="info-out-box">';
		while($moreres = mysql_fetch_assoc($rsmore))
		{
			echo'<div class="info-box">
			<div class="info-left-box">'.stripslashes($moreres['fieldname']).':</div>
			<div class="info-right-box">'.stripslashes($moreres['fieldvalue']).'</div></div>';
		}
		echo'</div>';
}
?>
</div>
</div>
</div>
		<?php
		}
		else
		{
			echo'<div id="products-detail-box">No Product Found</div>';
		}
		?>
</div>

<!-- welcome end//-->

<!-- bottom start -->
<?php echo bottom($abspath); ?>
<!-- bottom end//-->
<?php echo showSearch($abspath); ?>
<!-- view cart div -->
<?php 
if($added_item>0){
	echo '<script language="javascript" type="text/javascript">
			cartSetup("'.$abspath.'UserAjaxHandler.php?query=viewcart","viewcart","","'.$abspath.'");
		</script>';
}

?>
<!-- end view cart div -->
<!-- view cart div -->
<div class=myFloatBarview id=cart name=cart   style="<?php echo $cart_div_status; ?>">
	<a onclick=showFloatCart()><img src="<?php echo $abspath; ?>images/view-cart.png" /></a>
</div>
	<div class=myFloatCart id=myFloatCart name=myFloatCart style="width:620px;">
    <table width="590">
     <tr>
      <td>
	  	<div  id="mycartdisplay"></div>
       
      </td>
     </tr>
    </table>
</div>

<!-- end view cart div -->


</body>
</html>
