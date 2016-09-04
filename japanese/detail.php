<?php
session_start();
$pagenav=4;
$pagenavsub=2;
include("../include/connect.php");
include("include/page-add.php"); 
include("../db/db.php");
$url=$_SERVER['REQUEST_URI'];
$abspath = findAbs($url);
$imagepath = $abspath."../gallery/large/";
$imagelist = $abspath."../gallery/list/";
$cart_div_status="display:none;";
	if(isset($_SESSION["cart_item"]))
	{
		$added_item=$_SESSION["cart_item"];
		
		if($_SESSION["cart_item"]>0)
			$cart_div_status="display:block;";
}

if(!empty($_REQUEST['pid']))
{
$rs = mysql_query("SELECT product.*,category.ja_catname,subcategory.ja_subcat FROM product LEFT JOIN category ON product.catid = category.id LEFT JOIN subcategory ON product.subcatid = subcategory.id WHERE product.eurl ='".$_REQUEST['pid']."' and category.eurl='".$_REQUEST['cid']."' and subcategory.eurl='".$_REQUEST['sid']."'");
}
else
{
	$rs = mysql_query("SELECT product. * , category.ja_catname, subcategory.ja_subcat FROM product LEFT JOIN category ON product.catid = category.id LEFT JOIN subcategory ON product.subcatid = subcategory.id order by product.id desc limit 0,1");
}
$rsprod = mysql_fetch_assoc($rs);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//en" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php //echo showTitleFab($pagenav); ?>
<link rel="shortcut icon" href="<?php echo $abspath; ?>images/favicon.ico" type="image/x-icon">
<title><?php if(!empty($rsprod['seojatitle'])) echo stripslashes($rsprod['seojatitle']);
				else echo "47th DDC; Diamonds, Gemstones, Jewelry, Watches and Art."; ?></title>
<meta name="keywords" content="<?php echo stripslashes($rsprod['jakeyword']); ?>" />
<meta name="description" content="<?php echo stripslashes($rsprod['jaseodescription']); ?>" />
<link href="<?php echo $abspath; ?>../style.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?php echo $abspath; ?>css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $abspath; ?>css/style.css" type="text/css" media="screen" />
<!--<link rel='stylesheet' type='text/css' href='<?php //echo $abspath; ?>css/viewcart.css'/>-->
<script type='text/JavaScript' src='<?php echo $abspath; ?>js/viewcart.js'></script>
<script src="<?php echo $abspath; ?>js/af_js.js" type="text/javascript"></script>
<script src="<?php echo $abspath; ?>js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/main.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/prototype.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/scriptaculous.js?load=effects,builder"></script>

<link rel="stylesheet" type="text/css" media="all" href="<?php echo $abspath; ?>javascript2/style.css">
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/jquery_003.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/easySlider1.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/jquery.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>javascript2/this-theme.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/jawelary.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/AjaxHandler.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>js/svb.js"></script>
<!-- Light Box -->
<link rel="stylesheet" type="text/css" href="<?php echo $abspath; ?>lightbo/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript" src="<?php echo $abspath; ?>lightbo/jquery.js"></script>
<script type="text/javascript" src="<?php echo $abspath; ?>lightbo/jquery.lightbox-0.5.js"></script>
<script type="text/javascript">
    $(function() {
        $('#detail-left-box a').lightBox();
    });
    </script>

<?php //echo metaDescription($pagenav); ?>
<!--<meta name="description" content="第四十七ダイヤモンド地区コーポレーションへ！
私たちは、ジュエリーとアート� ®、上質、希少でユニークな作品のコレクターと売り手です。我々は、ニューヨークダイヤモンド地区内の2つの場所を持っている。我々は素晴らしいアンティークジュエリーとレアなアイテムだけでなく、微細なダイヤモンドおよび宝石用原石を専門としています。あなたが私達を扱うときには、ニューヨーク州や、世界中の不動産宝石の様々なアクセスを得る。私たちのコレクションは、美しいもののための重労働と愛の年から構成されています。我々は全てがこのビジネスへの愛が不足している、我々はまた、AGTA（米国宝石貿易協会）の誇りのメンバーであり、私たちはNYのダイヤモンドディーラークラブと密接に連携。 ">-->
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
  <div id="breadcum"><a href="<?php echo $abspath; ?>index.html" class="brelink">トップ</a> > <a href="<?php echo $abspath; ?><?php echo strtolower($_REQUEST['cid']).".html"; ?>" class="brelink"><?php echo stripslashes($rsprod['ja_catname']); ?></a> > <a href="<?php echo $abspath; ?><?php echo strtolower($_REQUEST['cid'])."/".strtolower($_REQUEST['sid'])."/12/1/1.html"; ?>" class="brelink"><?php echo stripslashes($rsprod['ja_subcat']); ?></a> &gt;&nbsp;<?php echo stripcslashes($rsprod['jatitle'])  ?></div>
</div>

</div>
<div id="welcome-ddc-box">
<div id="left-link-box">
<div id="collection-heaading">47DDC コレクション </div>
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
  				<div align="center"><a href="<?php echo $imagepath.$rsprod['imagepath']; ?>" rel="lightbox[roadtrip]">
					<img src="<?php echo $imagelist.$rsprod['imagepath']; ?>" alt="detail" width="328" height="288" vspace="1" border="0" /></a></div>
			</div>
			<div id="buy-now-box">
			<div id="buy-now"><?php if($rsprod['soldproduct']<$rsprod['productstock'])
				{
							 echo'<span id="addtocart_span'.$rsprod["id"].'">';
							if($_SESSION["incart_".$rsprod["id"]]=="YES")
							{
								echo '<img src="'.$abspath.'../images/added.gif" alt="added to cart" />';
							}
							else
							{	
								echo '<img src="'.$abspath.'../images/add-cart.gif" alt="add to cart" style="cursor:pointer" onClick="cartSetup(\''.$abspath.'UserAjaxHandler.php?query=addtocart&product_id='.$rsprod["id"].'\',\'addtocart\',\''.$rsprod["id"].'\',\''.$abspath.'\');">';
							}	
							echo '</span>';
				}
				else
				{
					echo'<img src="'.$abspath.'../images/outof-stock.gif" border="0" />';
				}
							  ?> 
					</div>
</div>
<?php 
			$selimg = rs_select("db_image where productid='".$rsprod['id']."'","*");
			if(mysql_num_rows($selimg)>0)
			{
				echo'<div id="more-heading"><strong>より 画像</strong></div>
				<div id="more-images-box">';
				while($imgres = mysql_fetch_assoc($selimg))
				{
					echo'<div class="small-image-box">
					<div align="center"><a href="'.$imagepath.$imgres['imagepath'].'" rel="lightbox[roadtrip]"><img src="'.$imagelist.$imgres['imagepath'].'" alt="47ddc" width="71" height="71" vspace="1" border="0" /></a></div></div>';
				}
	    		echo'</div>';
			}
 ?>


			<div id="detail-heading"><strong>製品 詳細</strong></div>
			<div id="detail-text"><?php echo stripslashes($rsprod['jadescription']); ?> </div>
		</div>
<!-- detail left end//-->

		<div id="detail-right-box">
			<div id="product-name-box"><?php echo stripslashes($rsprod['jatitle']); ?></div>
			<div class="product-heading">一般 情報</div>
			<div class="info-out-box">
			<?php
				  echo'<div class="info-box"><div class="info-left-box">カテゴリ:</div><div class="info-right-box">'.stripslashes($rsprod['ja_catname']).'</div></div>';
				  echo'<div class="info-box"><div class="info-left-box">サブ カテゴリ:</div><div class="info-right-box">'.stripslashes($rsprod['ja_subcat']).'</div></div>';
				if(!empty($rsprod['jatitle']))
				{
					echo '<div class="info-box"><div class="info-left-box">タイトル:</div><div class="info-right-box">'.stripslashes($rsprod['jatitle']).'</div></div>';
				}
				if(!empty($rsprod['jacondition']))
				{
					echo'<div class="info-box"><div class="info-left-box">条件:</div><div class="info-right-box">'.stripslashes($rsprod['jacondition']).'</div></div>';
				}
				if(!empty($rsprod['jastock']))
				{
					echo'<div class="info-box"><div class="info-left-box">在庫切れ 数:</div><div class="info-right-box">'.stripslashes($rsprod['jastock']).'</div></div>';
				}
				if(!empty($rsprod['japrice']))
				{
					echo'<div class="info-box"><div class="info-left-box">価格:</div><div class="info-right-box">'.stripslashes($rsprod['japrice']).'</div></div>';
				}
?>
			</div>
<?php
			if(!empty($rsprod['jabrname']) || (!empty($rsprod['jajehallmarks'])) || (!empty($rsprod['jajeperiod'])) || (!empty($rsprod['jajediamond'])) || (!empty($rsprod['jajediamondcolor'])) || (!empty($rsprod['jajediamondcl'])) ||  (!empty($rsprod['jajemetal'])) || (!empty($rsprod['jajemetailpu'])) || (!empty($rsprod['jajempriceweight'])) || (!empty($rsprod['jajedimension'])) || (!empty($rsprod['jajefingersize'])) || ($rsprod['jeselect']=="1"))
			{
				echo'<div class="product-heading">ジュエリー 情報</div>
				<div class="info-out-box">';
				if(!empty($rsprod['jabrname']))
				{
					echo'<div class="info-box"><div class="info-left-box">のブランド の名前:</div><div class="info-right-box">'.stripslashes($rsprod['jabrname']).'</div></div>';
				}
				if(!empty($rsprod['jajehallmarks']))
				{
					echo'<div class="info-box"><div class="info-left-box">特徴/起源:</div><div class="info-right-box">'.stripslashes($rsprod['jajehallmarks']).'</div></div>';
				}
				if(!empty($rsprod['jajeperiod']))
				{
					echo'<div class="info-box">
					<div class="info-left-box">期間:</div>
					<div class="info-right-box">'.stripslashes($rsprod['jajeperiod']).'</div>
					</div>';
				}
				if(!empty($rsprod['jajediamond']))
				{
					echo'<div class="info-box">
					<div class="info-left-box">合計 ダイヤモンド 重さ:</div>
					<div class="info-right-box">'.stripslashes($rsprod['jajediamond']).'</div>
					</div>';
				}
	if(!empty($rsprod['jajediamondcolor']))
 	{	
		echo'<div class="info-box">
		<div class="info-left-box">ダイヤモンド カラー:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jajediamondcolor']).'</div>
		</div>';
	}
	if(!empty($rsprod['jajediamondcl']))
 	{	
		echo'<div class="info-box">
		<div class="info-left-box">ダイヤモンド 明瞭:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jajediamondcl']).'</div>
		</div>';
	}
	if(!empty($rsprod['jajestoneweight']))
 	{	
		echo'<div class="info-box">
		<div class="info-left-box">合計 ジェムストーン 重さ:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jajestoneweight']).'</div>
		</div>';
	}
	if(!empty($rsprod['jajestonecolor']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">ジェムストーン カラー:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jajestonecolor']).'</div>
		</div>';
	}
	if(!empty($rsprod['jajediamondcl']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">ジェムストーン 明瞭:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jajediamondcl']).'</div>
		</div>';
	}
	if(!empty($rsprod['jajemetal']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">メタル:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jajemetal']).'</div>
		</div>';
	}
	if(!empty($rsprod['jajemetailpu']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">メタル 純度:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jajemetailpu']).'</div>
		</div>';
	}
	if(!empty($rsprod['jajempriceweight']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">合計 ピース 重さ:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jajempriceweight']).'</div>
		</div>';
	}
	if(!empty($rsprod['jajedimension']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">寸法:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jajedimension']).'</div>
		</div>';
	}
	if(!empty($rsprod['jajefingersize']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">指のサイズ:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jajefingersize']).'</div>
		</div>';
	}
	if($rsprod['jeselect']=="1")
 	{
		echo'<div class="info-box">
		<div class="info-left-box">かなり大きな:</div>
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
	if(!empty($rsprod['jadiaweight']) || (!empty($rsprod['jadiashap'])) || (!empty($rsprod['jadialab'])) || (!empty($rsprod['jadiacolor'])) || (!empty($rsprod['jadiaclarity'])) || (!empty($rsprod['jadiacut'])) ||  (!empty($rsprod['jadaipolish'])) || (!empty($rsprod['jadiasymmetry'])) || (!empty($rsprod['jadiafluor'])) || (!empty($rsprod['jadiatable'])) || (!empty($rsprod['jadiadepth'])) || (!empty($rsprod['jadiameasurment'])) || (!empty($rsprod['jadiaremarks'])) || (!empty($rsprod['jadiapercarat'])) || (!empty($rsprod['jadiatotalprice'])))
	{
	?>
		<div class="product-heading">ダイヤモンド情報</div>
		<div class="info-out-box">
	<?php
	if(!empty($rsprod['jadiaweight']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">重さ:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jadiaweight']).'</div>
		</div>';
	}
	if(!empty($rsprod['jadiashap']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">形状:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jadiashap']).'</div>
		</div>';
	}
	if(!empty($rsprod['jadialab']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">ラボ/証明書:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jadialab']).'</div>
		</div>';
	}
	if(!empty($rsprod['jadiacolor']))
 	{	
		echo'<div class="info-box">
		<div class="info-left-box">カラー:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jadiacolor']).'</div>
		</div>';
	}
	if(!empty($rsprod['jadiaclarity']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">明瞭:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jadiaclarity']).'</div>
		</div>';
	}
	if(!empty($rsprod['jadiacut']))
 	{	
		echo'<div class="info-box">
		<div class="info-left-box">カット:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jadiacut']).'</div>
		</div>';
	}
	if(!empty($rsprod['jadaipolish']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">ポーランド:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jadaipolish']).'</div>
		</div>';
	}
	if(!empty($rsprod['jadiasymmetry']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">対称性:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jadiasymmetry']).'</div>
		</div>';
	}
	if(!empty($rsprod['jadiafluor']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">蛍光:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jadiafluor']).'</div>
		</div>';
	}
	if(!empty($rsprod['jadiatable']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">表 %:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jadiatable']).'</div>
		</div>';
	}
	if(!empty($rsprod['jadiadepth']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">深さ:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jadiadepth']).'</div>
		</div>';
	}
	if(!empty($rsprod['jadiameasurment']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">測定:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jadiameasurment']).'</div>
		</div>';
	}
	if(!empty($rsprod['jadiaremarks']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">解説:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jadiaremarks']).'</div>
		</div>';
	}
	if(!empty($rsprod['jadiapercarat']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">カラットあたりの価格:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jadiapercarat']).'</div>
		</div>';
	}
	if(!empty($rsprod['jadiatotalprice']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">合計価格:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jadiatotalprice']).'</div>
		</div>';
	}
	?>
		</div>
	<?php } ?>
	<?php
	if(!empty($rsprod['jagemcarat']) || (!empty($rsprod['jagemstonetype'])) || (!empty($rsprod['jagemshape'])) || (!empty($rsprod['jagemcolor'])) || (!empty($rsprod['jagemclarity'])) || (!empty($rsprod['jagemcut'])) ||  (!empty($rsprod['jagemorigin'])) || (!empty($rsprod['jagemtreatment'])) || (!empty($rsprod['jagemlab'])) || (!empty($rsprod['jagemremarks'])))
	{
	?>
		<div class="product-heading">ジェムストーン 情報</div>
		<div class="info-out-box">
	<?php
	if(!empty($rsprod['jagemcarat']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">カラット 重さ:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jagemcarat']).'</div>
		</div>';
	}
	if(!empty($rsprod['jagemstonetype']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">ジェムストーン タイプ:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jagemstonetype']).'</div>
		</div>';
	}
	if(!empty($rsprod['jagemshape']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">形状:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jagemshape']).'</div>
		</div>';
	}
	if(!empty($rsprod['jagemcolor']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">カラー:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jagemcolor']).'</div>
		</div>';
	}
	if(!empty($rsprod['jagemclarity']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">明瞭:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jagemclarity']).'</div>
		</div>';
	}
	if(!empty($rsprod['jagemcut']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">カット:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jagemcut']).'</div>
		</div>';
	}
	if(!empty($rsprod['jagemorigin']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">起源:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jagemorigin']).'</div>
		</div>';
	}
	if(!empty($rsprod['jagemtreatment']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">治療:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jagemtreatment']).'</div>
		</div>';
	}
	if(!empty($rsprod['jagemlab']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">ラボ/証明書:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jagemlab']).'</div>
		</div>';
	}
	if(!empty($rsprod['jagemremarks']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">解説:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jagemremarks']).'</div>
		</div>';
	}
	echo'</div>';
}
if(!empty($rsprod['jawatbrand']) || (!empty($rsprod['jawatmodel'])) || (!empty($rsprod['jawatgender'])) || (!empty($rsprod['jawatage'])) || (!empty($rsprod['jawatfeatures'])) || (!empty($rsprod['jawatfeatures1'])) ||  (!empty($rsprod['jawatfeatures2'])) || (!empty($rsprod['jawatfeatures3'])) || (!empty($rsprod['jawatmovement'])) || (!empty($rsprod['jawatcase'])) || (!empty($rsprod['jawatband'])) || (!empty($rsprod['jawatdim'])) || (!empty($rsprod['jawatcarat'])) || (!empty($rsprod['jawatbox'])) || (!empty($rsprod['jawatwarranty'])) || (!empty($rsprod['jawatremarks'])))
{
	echo'<div class="product-heading">見る 情報</div>
	<div class="info-out-box">';
	if(!empty($rsprod['jawatbrand']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">のブランド の名前:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jawatbrand']).'</div>
		</div>';
	}
	if(!empty($rsprod['jawatmodel']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">モデル:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jawatmodel']).'</div>
		</div>';
	}
	if(!empty($rsprod['jawatgender']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">性別:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jawatgender']).'</div>
		</div>';
	}
	if(!empty($rsprod['jawatage']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">年齢/条件:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jawatage']).'</div>
		</div>';
	}
	if(!empty($rsprod['jawatfeatures']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">機能:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jawatfeatures']).'</div>
		</div>';
	}
	if(!empty($rsprod['jawatfeatures1']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box"></div>
		<div class="info-right-box">'.stripslashes($rsprod['jawatfeatures1']).'</div>
		</div>';
	}
	if(!empty($rsprod['jawatfeatures2']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box"></div>
		<div class="info-right-box">'.stripslashes($rsprod['jawatfeatures2']).'</div>
		</div>';
	}
	if(!empty($rsprod['jawatfeatures3']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box"></div>
		<div class="info-right-box">'.stripslashes($rsprod['jawatfeatures3']).'</div>
		</div>';
	}
	if(!empty($rsprod['jawatmovement']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">運動:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jawatmovement']).'</div>
		</div>';
	}
	if(!empty($rsprod['jawatcase']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">事例 材料:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jawatcase']).'</div>
		</div>';
	}
	if(!empty($rsprod['jawatband']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">バンド 材料:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jawatband']).'</div>
		</div>';
	}
	if(!empty($rsprod['jawatdim']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">寸法:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jawatdim']).'</div>
		</div>';
	}
	if(!empty($rsprod['jawatcarat']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">カラット 重さ:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jawatcarat']).'</div>
		</div>';
	}
	if(!empty($rsprod['jawatbox']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">ボックス & ペーパー:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jawatbox']).'</div>
		</div>';
	}
	if(!empty($rsprod['jawatwarranty']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">保証:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jawatwarranty']).'</div>
		</div>';
	}
	if(!empty($rsprod['jawatremarks']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">解説:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jawatremarks']).'</div>
		</div>';
	}
	echo'</div>';
}
if(!empty($rsprod['jaobjbrandname']) || (!empty($rsprod['jaobjhall'])) || (!empty($rsprod['jaobjperiod'])) || (!empty($rsprod['jaobjstyle'])) || (!empty($rsprod['jaobjmaterial'])) || (!empty($rsprod['jaobjdimensions'])) || (!empty($rsprod['jaobjweight'])) || (!empty($rsprod['jaobjremarks'])))
{
	echo'<div class="product-heading">オブジェクト 情報</div>
		<div class="info-out-box">';
	if(!empty($rsprod['jaobjbrandname']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">のブランド の名前:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jaobjbrandname']).'</div>
		</div>';
	}
	if(!empty($rsprod['jaobjhall']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">特徴/起源:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jaobjhall']).'</div>
		</div>';
	}
	if(!empty($rsprod['jaobjperiod']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">期間:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jaobjperiod']).'</div>
		</div>';
	}
	if(!empty($rsprod['jaobjstyle']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">スタイルの:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jaobjstyle']).'</div>
		</div>';
	}
	if(!empty($rsprod['jaobjmaterial']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">材料:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jaobjmaterial']).'</div>
		</div>';
	}
	if(!empty($rsprod['jaobjdimensions']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">寸法:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jaobjdimensions']).'</div>
		</div>';
	}
	if(!empty($rsprod['jaobjweight']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">重さ:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jaobjweight']).'</div>
		</div>';
	}
	if(!empty($rsprod['jaobjremarks']))
 	{
		echo'<div class="info-box">
		<div class="info-left-box">解説:</div>
		<div class="info-right-box">'.stripslashes($rsprod['jaobjremarks']).'</div>
		</div>';
	}
	echo'</div>';
}
$rsmore = rs_select("moreproduct where productid='".$rsprod['id']."'","*"); 
if(mysql_num_rows($rsmore)>0)
{
	echo'<div class="product-heading">他 情報</div>
		 <div class="info-out-box">';
		while($moreres = mysql_fetch_assoc($rsmore))
		{
			echo'<div class="info-box">
			<div class="info-left-box">'.stripslashes($moreres['jafieldname']).':</div>
			<div class="info-right-box">'.stripslashes($moreres['jafieldvalue']).'</div></div>';
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
			echo'<div id="products-detail-box">なし 製品 発見</div>';
		}
		?>
</div>

<!-- welcome end//-->

<!-- bottom start//-->
<?php echo bottom($abspath);?>
<!-- bottom end//-->
<!-- Seardh Div -->
<?php echo showSearch($abspath); ?>
<!-- SEarch Deiv -->
<!-- view cart div -->
<?php 
if($added_item>0){
	echo '<script language="javascript" type="text/javascript">
			cartSetup("'.$abspath.'UserAjaxHandler.php?query=viewcart","viewcart","","'.$abspath.'");
		</script>';
}

?>
<div class=myFloatBarview id=cart name=cart   style="<?php echo $cart_div_status; ?>">
	<a onclick=showFloatCart()><img src="<?php echo $abspath; ?>../images/view-cart.png" /></a>
</div>
<div class=myFloatCart id=myFloatCart name=myFloatCart style="width:620px;">
    <table width="590">
     <tr>
      <td>
       <div id="cartdisplay" name="cartdisplay">
	   
				 
	   </div>
      </td>
     </tr>
     <tr valign=bottom>
      <td valign=bottom align= left colspan=4>
       <!--<div class=myFloatBarhide id='hideCart' name='hideCart'>
        <a onclick="hideFloatCart()" style="cursor:hand;" ><img src="images/hide-cart.gif"></a>
       </div>-->
      </td>
     </tr>
    </table>
</div>
<!-- end view cart div -->
</body>
</html>
