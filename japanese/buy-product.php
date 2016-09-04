<?php
session_start();
$pagenav=1;
include("../include/connect.php");
include("include/page-add.php"); 
$url=$_SERVER['REQUEST_URI'];
$abspath = findAbs($url);
$imagelist = "../gallery/list/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//JA" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php echo showTitleFab($pagenav); ?>
<meta name="description" content="第四十七ダイヤモンド地区コーポレーションへ！
私たちは、ジュエリーとアート� ®、上質、希少でユニークな作品のコレクターと売り手です。我々は、ニューヨークダイヤモンド地区内の2つの場所を持っている。我々は素晴らしいアンティークジュエリーとレアなアイテムだけでなく、微細なダイヤモンドおよび宝石用原石を専門としています。あなたが私達を扱うときには、ニューヨーク州や、世界中の不動産宝石の様々なアクセスを得る。私たちのコレクションは、美しいもののための重労働と愛の年から構成されています。我々は全てがこのビジネスへの愛が不足している、我々はまた、AGTA（米国宝石貿易協会）の誇りのメンバーであり、私たちはNYのダイヤモンドディーラークラブと密接に連携。 ">
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />

<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery.nivo.slider.js" type="text/javascript"></script>
<script src="js/slider.js" type="text/javascript"></script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/AjaxHandler.js"></script>
<script type="text/javascript" src="js/svb.js"></script> 
<?php echo metaDescription($pagenav); ?>
</head>

<body>

<!-- Web Design & Developed by: http://www.webtimeinc.com -->

<!-- Top Start//-->
<div id="top-main">
<div id="top">
<?php echo logo($abspath); ?>
<div id="top-right">
  <?php echo language($abspath) ?>
<div id="top-links">
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
  <div id="slider2" class="nivoSlider"> <img src="images/003.jpg" alt="" title="デザイナーズ＆NYのショップより、インターナショナルなジュエリーをダイレクトへお届け！" /> <img src="images/002.jpg" alt="" title="大粒で極上のダイヤモンド！" /> <img src="images/004.jpg" alt="" title="世界で最も上質な宝石&ダイヤモンドコレクション！" /> <img src="images/005.jpg" alt="" title="新品&ヴィンテージ、ハイラグジュアリーウォッチ！" /> <img src="images/006.jpg" alt="" title="スペシャルな人の為の、スペシャルなジュエリー！" /> <img src="images/001.jpg" alt="" title="世界のトップクラスの宝飾品が揃う、NYのダイヤモンドストリートより、最高級の宝石&ダイヤモンドをお届け致します" /> </div>
</div>

</div>
</div>
</div>

<div><?php if(isset($_SESSION['productmsg']))
				{
					echo '<font color="red"><h4>'.$_SESSION['productmsg'].'</h4></font>';
					unset($_SESSION['productmsg']);
				}?></div>
<div id="welcome-ddc-box">
<?php
				$sql_cart="select cart.*,product.imagepath from cart left join product on cart.productid = product.id where session_id='".session_id()."'";
				$rs_cart=mysql_query($sql_cart) or die(mysql_error());
				if(mysql_num_rows($rs_cart)>0){
		  			echo'<form id="frm_cart" name="frm_cart" action="dbfunction.php" method="post">
		  					<table align="center" width="948" border="0" cellspacing="0" cellpadding="0">
  								<tr>
    								<td colspan="7" align="left" valign="middle" bgcolor="#ffb200"><div class="title-br"><h1 class="cl_both ">View Cart</h1>
    </div></td>
    							</tr>
								<tr>
									<td align="left" valign="middle" class="bor_heading">Product Image</td>
									<td align="left" valign="middle" class="bor_heading">Product Code</td>
									<td align="left" valign="middle" class="bor_heading">Quantity</td>
									<td align="left" valign="middle" class="bor_heading">Product Color</td>
									<td align="left" valign="middle" class="bor_heading">Price </td>
									<td align="left" valign="middle" class="bor_heading">Total</td>
									<td align="left" valign="middle" class="bor_heading">Remove</td>
								</tr>';
  								$total=0;
								$cnt=0;
								while($data_cart=mysql_fetch_array($rs_cart))
								{
									++$cnt;
									$quan=(int)$data_cart["qty"];
									$rate=$data_cart["price"];
				 					$total=$total+($quan*$rate);
				 					echo'<tr>
									<td align="left" valign="middle" class="text_heading"><img src="'.$imagelist.$data_cart["imagepath"].' " height="40" width="40"/></td>
									<td align="left" valign="middle" class="text_heading">447ddc - 00'.stripslashes($data_cart["productid"]).'</td>
									<td align="left" valign="middle" class="text_heading"><input type="text" name="product_qty_'.$cnt.'"  id="product_qty_'.$cnt.'" value="'.$quan.'" size=3 maxlength="3" onkeypress="return checkForInt(event);" ><input type="hidden" name="product_id_'.$cnt.'" id="product_id_'.$cnt.'" value="'.$data_cart["productid"].'"></td>
									<td align="left" valign="middle" class="text_heading">$'.$rate.'</td>
									<td align="left" valign="middle" class="text_heading">$'.($rate*$quan).'</td>
									<td align="left" valign="middle" class="text_heading"><a href="dbfunction.php?query=removefromcart&product_id='.session_id().'&pid='.$data_cart["productid"].'" style="cursor:pointer"><img src="images/delete.png" alt="Remove" border="0" title="Remove" width="30" height="31" /></a></td>
								  </tr>';
							}
							echo'<input type="hidden" name="count" id="count" value="'.$cnt.'">
								  <tr>
									<td colspan="4" align="left" valign="middle">&nbsp;</td>
									<td align="left" valign="middle" class="text_headings">Grand Total </td>
									<td align="left" valign="middle" class="text_headings">$'.$total.'</td>
									<td align="left" valign="middle">&nbsp;</td>
								  </tr>
  <tr>
    <td colspan="3" align="left" valign="middle"><table width="330" border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td><input type="submit" name="updatecard" value="Update" class="update_button"/></td>
    <td class="update_butto1"><a href="index.html">Continue Shoping</a></td><td class="update_butto">';
	if(isset($_SESSION["LoginStatus"]))
	{
    echo'<a href="shoping_billing_info.html">Check Out</a>';
	 }
	 else
	 {
	 	echo'<a href="login.html">Check Out</a>';
	 }
	
	echo'</td>
  </tr>
</table>

	
	 </td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
	<td align="left" valign="middle">&nbsp;</td>
  </tr>
</table></form>';
}
?>
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
