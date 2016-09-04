<?php 
function logo($abspath,$isHome=false)
{
if(!$isHome)
	echo'<div id="logo"><a href="'.$abspath.'index.html" class="tooltip" title="Back To Home"><img src="'.$abspath.'images/logo.jpg" alt="logo" width="339" height="142" border="0" /></a></div>';
else
	echo'<div id="logo"><img src="'.$abspath.'images/logo.jpg" alt="logo" width="339" height="142" border="0" /></div>';
}
/*function logo()
{
 echo'<div id="logo"><a href="index.php"><img src="images/logo.jpg" alt="logo" width="339" height="142" border="0" /></a></div>';
}
*/function allPage($abspath)
{
	global $pagesearch;
	echo'<div id="welcome-main-box">
		<div id="welcome-box">';

		if(isset($_SESSION['Register']))
			{
				if($_SESSION['Register']=="GUEST")
				{
		echo'<div id="welcome-toptext">Welcome <strong>'.$_SESSION["Register"].'</strong> </div>';
	}
	else
	{
		echo'<div id="welcome-toptext">Welcome <strong>'.$_SESSION["CustName"].'</strong> </div>';
	}
}
else
{
	echo'<div id="welcome-toptext">Welcome</div>';
}

echo'<div id="shopping-bag-text">';
if(isset($_SESSION["cart_item"]) && !empty($_SESSION["cart_item"]))
									echo $_SESSION["cart_item"]."&nbsp;item in your cart";
									else
									echo "0&nbsp;item in your cart";
									
								echo '</div>'; 
								echo language($abspath);
echo '</div>';
if(((isset($_SESSION['Register'])) && ($_SESSION['Register']=="register")))
{
	echo'<div id="account-text"><a href="'.$abspath.'myaccount.html" class="link1">My Account</a> | <a href="'.$abspath.'order-status.html" class="link1">Order Status</a> | <a href="'.$abspath.'dbfunction.php?query=logout" class="link1">Logout </a> | <a href="'.$abspath.'view-cart.html" class="link1">View Cart</a> | <a href="'.$abspath.'customer-service.html" class="link1">Help</a></div>';
}
else if(isset($_SESSION['Register']))
{
echo'<div id="account-text"><a href="'.$abspath.'order-status.html" class="link1">Order Status</a> | <a href="'.$abspath.'dbfunction.php?query=logout" class="link1">Logout </a> | <a href="'.$abspath.'view-cart.html" class="link1">View Cart</a> | <a href="'.$abspath.'customer-service.html" class="link1">Help</a></div>';
}
else
{
echo'<div id="account-text"><a href="'.$abspath.'registration.html" class="link1">Register</a> | <a href="'.$abspath.'order-status.html" class="link1">Order Status</a> | <a href="'.$abspath.'login.html" class="link1">Login</a> | <a href="'.$abspath.'view-cart.html" class="link1">View Cart</a> | <a href="'.$abspath.'customer-service.html" class="link1">Help</a></div>';
}
if(!isset($pagesearch))
echo '<div class="search-but-top"><a href="#"><img src="'.$abspath.'images/search-top.png" alt="search" width="110" height="21" border="0" onclick="ShowPopupSearch()"/></a></div>';
echo '</div>';
}
function language($abspath)
{
	echo '<div id="language-box1">
<div id="eng-box"><a href="'.$abspath.'../index.html" class="tlink" >Eng</a></div>
<div id="jp-box"><a href="index.html" class="tlink" id="tlink-active">&#26085;&#26412;</a></div>
</div>';
}
function nav($abspath)
{
	$selcat = mysql_query("select id,ja_catname,eurl from category where status ='Y' and ja_catname !=''");
	 
	global $pagenav;
	echo'<ul>
            <li><a  href="'.$abspath.'index.html"';
						  if($pagenav==1) 
						  echo 'class="currentnavi"';
						  echo '>HOME</a>            </li>
            <li><a  href="'.$abspath.'about-us.html"';
						  if($pagenav==2) 
						  echo 'class="currentnavi"';
						  echo '>ABOUT US</a>
            </li>
            <li><a  href="'.$abspath.'our-staff.html"';
						  if($pagenav==3) 
						  echo 'class="currentnavi"';
						  echo '>OUR STAFF</a>
            </li>
            <li><a href="#"';
						  if($pagenav==4) 
						  echo 'class="currentnavi"';
						  echo '>PRODUCTS</a>
               <ul>';
			   while($rescat = mysql_fetch_assoc($selcat))
			   {
			   		echo'<li><a href="'.$abspath.strtolower($rescat['eurl']).'.html">'.stripslashes($rescat['ja_catname']).'</a></li>';
				}
                 echo'</ul>
            </li>
			<li><a href="'.$abspath.'contact-us.html"';
						  if($pagenav==5) 
						  echo 'class="currentnavi"';
						  echo '>CONTACT US </a>
            </li>
		  </ul>';
}
function bottom($abspath)
{
	echo'<div id="bottom-box">
<div id="bottom">
<div id="bottom-left">
<div id="bottom-links">
						<a href="'.$abspath.'index.html">Home</a> <a href="'.$abspath.'about-us.html"> About Us</a> 
						<a href="'.$abspath.'our-staff.html">Our Staff</a> <a href="return-privacy-policy.html">Return &amp; Privacy Policy</a>
						<a href="'.$abspath.'contact-us.html">Contact Us </a>
					</div>
<!-- PayPal Logo -->
<!-- PayPal Logo -->
<div id="copyright">Copyright &copy; 2011 47ddc. All rights reserved</div>
  <div id="webtimeinc">Web Design &amp; Developed by:&nbsp; <a href="http://www.webtimeinc.com" target="_blank" class="link">Webtime Inc </a></div>
  <div id="ebay-box">
  <div id="ebay-text"><strong>We are Top Rated on eBay as well:</strong></div>
  <div id="small-icon-box">
<div id="sicon-box2"><a href="http://stores.ebay.com/Shinmei-Gu-A-Gate-to-the-World" target="_blank"><img src="'.$abspath.'images/iconTrsMini.gif" width="56" height="19" border="0" /></a></div>
<div id="sicon-box3"><a href="http://stores.ebay.com/Shinmei-Gu-A-Gate-to-the-World" target="_blank"><img src="'.$abspath.'images/psIcon_50x25.gif" width="50" height="25" border="0" /></a></div>
<div id="sicon-box1"><a href="http://stores.ebay.com/Shinmei-Gu-A-Gate-to-the-World" target="_blank"><img src="'.$abspath.'images/imgAvaBadge1000.gif" border="0" /></a></div>
</div>
  </div>
</div>
<div id="bottom-right">
<div id="follow-heaading">Follow us</div>
<div id="follow-box">
<div class="follow"><a href="http://www.facebook.com/#!/pages/47th-Diamond-District-Corp/116716695076416" target="_blank" class="tooltip" title="47ddc on Facebook"><img src="'.$abspath.'images/facebook.jpg" alt="facebook" border="0" /></a></div>
<div class="follow"><a href="http://twitter.com/#!/47DDC" target="_blank" class="tooltip" title="Follow us on Twitter"><img src="'.$abspath.'images/tiwtter.jpg" alt="facebook" width="28" height="30" border="0" /></a></div>
<div class="follow"><a href="http://www.yelp.com/biz/47th-diamond-district-corp-manhattan" target="_blank" class="tooltip" title="Follow us on Yelp"><img src="'.$abspath.'images/yelp.jpg" alt="facebook" width="28" height="30" border="0" /></a></div>
</div>

</div>
<div id="icon-box">
  <div id="domain-box"><span id="cdSiteSeal3"><script type="text/javascript" src="//tracedseals.starfieldtech.com/siteseal/get?scriptId=cdSiteSeal3&amp;cdSealType=Seal3&amp;sealId=55e4ye7y7mb73c2d3282a9680b80ee8qbry7mb7355e4ye7ddba513a0dc6cb4fb"></script></span></div>
 
  <div id="secure-box"><a href="#" onclick="window.open(\'https://www.sitelock.com/verify.php?site=47ddc.com\',\'SiteLock\',\'width=600,height=600,left=160,top=170\');" ><img alt="website security" title="SiteLock"  src="//shield.sitelock.com/shield/47ddc.com" border="0"/> </a></div>
   <div id="paypal-box"><!-- PayPal Logo --><a href="#" onclick="javascript:window.open(\'https://www.paypal.com/us/cgi-bin/webscr?cmd=xpt/Marketing/popup/OLCWhatIsPayPal-outside','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350\');"><img  src="https://www.paypal.com/en_US/i/bnr/horizontal_solution_PPeCheck.gif" border="0" alt="Solution Graphics"></a><!-- PayPal Logo --></div>
   <div id="agta-box"><a href="http://www.agta.org/info/agta-source-directory-member-1032556.html" target="_blank"><img src="'.$abspath.'images/agta_member_logo.jpg" alt="AGAT Member" border="0" /></a></div>
    <div id="jbt-box"><img src="'.$abspath.'images/Jewelers_Board_Trade.jpg" alt="Jewelers Board Trade" border="0" /></div>
  <div id="gia-box"><img src="'.$abspath.'images/GIA.jpg" alt="GIA" border="0" /></div>
  
  </div>

  
</div>
</div>';
}
function leftLink($abspath)
{
	global $pagenavsub;
	echo'<div id="left-links">';
	$rscat1 = rs_select("category where status ='Y' and ja_catname !='' ","*");
	while($rescat1 = mysql_fetch_assoc($rscat1))
	{
		if(strtolower(stripslashes($rescat1['eurl']))==$_REQUEST['cid'])
		{
			echo'<div class="l1"><a id="l1-active"><strong>'.stripslashes($rescat1['ja_catname']).'</strong></a></div>';
		}
		else
		{
			echo'<div class="l1"><a href="'.$abspath.''.strtolower(stripslashes($rescat1['eurl'])).'.html">'.stripslashes($rescat1['catname']).'</a></div>';
		}
		if(strtolower(stripslashes($rescat1['eurl']))==$_REQUEST['cid'])
		{
			$rssub = rs_select("subcategory where catid='".$rescat1['id']."' and status ='Y'","*");
			while($ressub = mysql_fetch_assoc($rssub))
			{
				if($pagenavsub==2)
				{
					if($_REQUEST['sid']==strtolower(stripslashes($ressub['eurl'])))
					{
						echo'<div class="sublink"><a href="'.$abspath.''.strtolower($_REQUEST['cid']).'/'.strtolower($ressub['eurl']).'/12/1/1.html" id="sublink-active">'.stripslashes($ressub['ja_subcat']).'</a></div>';
					}
					else
					{
						echo'<div class="sublink"><a href="'.$abspath.''.strtolower($_REQUEST['cid']).'/'.strtolower($ressub['eurl']).'/12/1/1.html">'.stripslashes($ressub['ja_subcat']).'</a></div>';
					}
				}
				else
				{
					echo'<div class="sublink"><a href="'.$abspath.''.strtolower($_REQUEST['cid']).'/'.strtolower($ressub['eurl']).'/12/1/1.html">'.stripslashes($ressub['ja_subcat']).'</a></div>';
				}
			}
		}
  	}
echo '
</div>';
}
/////////////////////////////////////////////////////////////// function show card /////////////

function showCard()
{
	global $imagepath;
	if(isset($_SESSION["CustEmail"]))
  {
  $sql_cart="SELECT IF( sd.ShipCustCountry =  'U.S.A.', p.shipchargedom, p.shipchargeint ) AS ship, p.imagepath,crt.productname, crt.qty,crt.productid, crt.price FROM product AS p,shipbilldetail AS sd, cart AS crt WHERE p.id = crt.productid AND crt.session_id =  '".session_id()."' AND sd.userid =  '".$_SESSION["userid"]."'";
  }
  else
  {
  	$sql_cart="select cart.*,product.imagepath from cart left join product on cart.productid = product.id where session_id='".session_id()."'";
  }
$rs_cart=mysql_query($sql_cart) or die(mysql_error());
	echo '<div id="product-view-box">
<div id="cart-box">
<div id="cart-image">In Your Bag</div>
<div id="price-item">Price Per Item </div>
<div id="total-price">Total</div>
</div>
<div id="cart-box1">';
if(mysql_num_rows($rs_cart)>0){
	$total=0;
	$cnt=0;
	$shipcharge = 0;
	$tax = 0;
	$gtotal=0;
	$subtotal=0;
	while($data_cart=mysql_fetch_array($rs_cart))
	{
		++$cnt;
		$amount =0;
		$quan=(int)$data_cart["qty"];
		$rate=$data_cart["price"];
		$amount = $rate * $quan;
		$subtotal=$subtotal+($quan*$rate);
		$shipcharge = $shipcharge + ($data_cart["ship"]*$quan);
		echo'<div class="cart-box2">
		<div id="product-image"><img src="'.$imagepath.$data_cart["imagepath"].'" width="80" height="80" align="middle" /></div>
		<div id="price-item1">$'.$data_cart['price'].'</div>
		<div id="total-price1">$'.$amount.'</div>
		</div>';
	}
	$_SESSION['shipcharge'] = $shipcharge;
	$_SESSION['subtotal'] = $subtotal;
}
echo'</div>
<div id="cart-box2">
<div id="modify"><a href="view-cart.html" class="link1">Modify your order</a></div>
<div id="total-price3">Sub Total :$'.$_SESSION['subtotal'].'<br />';
if(!empty($_SESSION['shipcharge']))
echo'Shipping : $ '.$shipcharge.'<br />';
if($_SESSION["shipcountry"]=='U.S.A.' && $_SESSION["shipcity"]=="new york")
		{
			$tax = number_format((($_SESSION['subtotal']*10)/100),2);
			echo "Tax : $".$tax."<br>";
			$_SESSION['tax'] = $tax;
		}
		else
		$_SESSION['tax'] = 00;
		if($_SESSION['couponamount']!=0)
				echo'Discount : $'.$_SESSION['couponamount'].'<br>';
		$gtotal = $_SESSION['shipcharge']+$_SESSION['tax']+$_SESSION['subtotal']-$_SESSION['couponamount'];
		//$_SESSION['granttotal'] = $gtotal;
		
  echo'<strong>Total Cost: $ '.$gtotal.'</strong></div>
</div>
</div>';
}
function showTitleFab($page)
{
  echo '<title>47th DDC; Diamonds, Gemstones, Jewelry, Watches and Art.</title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">';
}
function metaDescription($pageno)
{
	$responce ="";
	$responce .= stripcslashes('<meta name="keywords" content="Diamond, Sapphire, Ruby, Emerald, Jewelry, Necklace, Vintage, Estate, Art Deco, Art Nouveau, 19th Century, Platinum, 18K, 14K, 22K, Edwardian, Victorian, Jacob & co, Rolex, Patek Philippe, Vacheron, David Webb, Cartier, Tiffany, Bracelet, Bangle, Ring, Earrings, Watches, Art, Antique Jewelry, Natural Pearls, Conch Pearls, Clam, Quahog, Scallop, Melo, Salt Water, Abalone, Blue Diamonds, Red Diamond, Pink Diamonds, Sotheby\’s, Christies, Auctions, Japanese, eBay"/>');
	echo $responce;
}
function showSearch($abspath)
{
	$selcat = mysql_query("SELECT * FROM `category` WHERE ja_catname !='' and status ='Y' ");
 $responce ="";
 $responce .='
 <div id="Layer1" style="display:none;">
 <div id="search-popbox">
<div id="search-up">
<div id="search-close"><a href="#"><img src="'.$abspath.'images/close.gif" width="15" height="14" border="0" onclick="JavaScript:HidePopupSearch()" /></a></div>
</div>
<div id="search-mid">
<div id="search-pop-innbox">
<div class="search-pop-heading">Search By Keyword</div>
<div class="search-key">
  <input name="textfield" id="textfield" type="text" class="inp4" onkeyup="return isEnterSearch(event,\''.$abspath.'\')" />
</div>

<div class="search-felid-box">
  <select name="selectcat" id ="selectcat" class="inp3">
    <option value="All-Category">All Categories</option>
	';
	if(mysql_num_rows($selcat)>0)
	{
		while($res= mysql_fetch_assoc($selcat))
		{
			$responce .='<option value="'.$res['eurl'].'">'.stripslashes($res['ja_catname']).'</option>';
		}
	}
	
   $responce .='</select>
  </div>
<div class="search-but">
	<img style="cursor:pointer;" src="'.$abspath.'images/search-but.gif" width="74" height="21" border="0" onClick="return searchValidation(\''.$abspath.'\');"  /></div>
</div>
</div>
<div id="search-bottom"></div>
</div>

</div>';
echo $responce;
}
//////////////////////////Find abs path ///////////
function findAbs($url)
{
	$Start_Leve=1;
	$fd = parse_url($url);
	$path_parts = pathinfo($fd['path']);
	$dirs = explode("/", $path_parts['dirname']);
	$extension=$path_parts['extension'];
	array_shift($dirs);
	$abspath='';
	for($i=$Start_Leve;$i<count($dirs);$i++)
	{
	$abspath.='../';
	}
	return $abspath;
}
?>