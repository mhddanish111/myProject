<?php
session_start();
if(!isset($_SESSION["CustEmail"]))
{
	header("location:index.html");
	exit;
}
//$pagenav=4;

include("../include/connect.php");
include("include/page-add.php"); 
include("../db/db.php");
$url=$_SERVER['REQUEST_URI'];
$abspath = findAbs($url);
$imagepath = "../gallery/list/";
$COUNTRY_ARRAY=array("AFGHANISTAN","ALBANIA","ALGERIA","AMERICAN SAMOA" ,"ANDORRA","ANGOLA" ,"ANGUILLA" ,"ANTIGUA","ARGENTINA","ARMENIA","ARUBA","AUSTRALIA","AUSTRIA","AZERBAIJAN" ,"BAHAMAS","BAHRAIN","BANGLADESH" ,"BARBADOS" ,"BELARUS","BELGIUM","BELIZE" ,"BENIN","BERMUDA","BHUTAN" ,"BOLIVIA","BOSNIA" ,"BOTSWANA" ,"BRAZIL" ,"BRITISH VIRGIN IS." ,"BRUNEI" ,"BULGARIA" ,"BURKINA FASO" ,"BURUNDI","CAMBODIA" ,"CAMEROON" ,"CANADA" ,"CAPE VERDE" ,"CAYMAN ISLANDS" ,"CENT AFR REP" ,"CHAD" ,"CHILE","CHINA","COLOMBIA" ,"CONGO","COOK ISLANDS" ,"COSTA RICA" ,"CROATIA","CYPRUS" ,"CZECH REPUBLIC" ,"DEMOCRATIC REPUBLIC OF C" ,"DENMARK","DJIBOUTI" ,"DOMINICA" ,"EAST TIMOR" ,"ECUADOR","EGYPT","EL SALVADOR","EQUATORIAL GUINEA","ERITREA","ESTONIA","ETHIOPIA" ,"FIJI" ,"FINLAND","FRANCE" ,"FRENCH GUIANA","FRENCH POLYNESIA" ,"GABON","GAMBIA" ,"GEORGIA","GERMANY","GHANA","GIBRALTAR","GREECE" ,"GREENLAND","GRENADA","GUADELOUPE" ,"GUAM" ,"GUATEMALA","GUINEA" ,"GUINEA BISSAU","GUYANA" ,"HAITI","HONDURAS" ,"HONG KONG","HUNGARY","ICELAND","INDIA","IRAQ REPUBLIC","IRELAND","ISRAEL" ,"ITALY","IVORY COAST","JAMAICA","JAPAN","JORDAN" ,"KAZAKHSTAN" ,"KENYA","KUWAIT" ,"KYRGYZSTAN" ,"LAOS" ,"LATVIA" ,"LEBANON","LESOTHO","LIBERIA","LIBYA","LIECHTENSTEIN","LITHUANIA","LUXEMBOURG" ,"MACAU","MACEDONIA","MADAGASCAR" ,"MALAWI" ,"MALAYSIA" ,"MALDIVES" ,"MALI" ,"MALTA","MARSHALL ISLANDS" ,"MARTINIQUE" ,"MAURITANIA" ,"MAURITIUS","MEXICO" ,"MIAMI","MICRONESIA" ,"MOLDOVA","MONACO" ,"MONGOLIA" ,"MONTSERRAT" ,"MOROCCO","MOZAMBIQUE" ,"MYANMAR","NAMIBIA","NEPAL","NETHERLANDS","NEW CALEDONIA","NEW ZEALAND","NICARAGUA","NIGER","NL. ANTILLES" ,"NORWAY" ,"OMAN" ,"PAKISTAN" ,"PALAU","PALESTINE AUTHORITY","PANAMA" ,"PAPUA NEW GUINEA" ,"PARAGUAY" ,"PERU" ,"PHILIPPINES","POLAND" ,"PORTUGAL" ,"PUERTO RICO","QATAR","REUNION ISLAND" ,"ROMANIA","RUSSIA" ,"RWANDA" ,"SAIPAN" ,"SAUDI ARABIA" ,"SENEGAL","SERBIA AND MONTENEGRO","SEYCHELLES" ,"SIERRA LEONE" ,"SINGAPORE","SLOVAK REPUBLIC","SLOVENIA" ,"SOMALIA","SOUTH AFRICA" ,"SOUTH KOREA","SPAIN","SRI LANKA","ST KITTS &amp; NEVIS" ,"ST. LUCIA","ST. VINCENT","SUDAN","SURINAME" ,"SWAZILAND","SWEDEN" ,"SWITZERLAND","SYRIA","TAIWAN" ,"TANZANIA" ,"THAILAND" ,"TOGO" ,"TRINIDAD &amp; TOBAG" ,"TUNISIA","TURKEY" ,"TURKMENISTAN" ,"TURKS &amp; CAICOS I" ,"U.A.E." ,"U.S.A." ,"UGANDA" ,"UKRAINE","UNITED KINGDOM" ,"URUGUAY","UZBEKISTAN" ,"VANUATU","VATICAN CITY" ,"VENEZUELA","VIRGIN ISLANDS" ,"WALLIS &amp; FUTUNA","YEMEN","ZAMBIA" ,"ZIMBABWE");

	$sel = mysql_query("select ShipCustName,ShipCustEmail,ShipCustPhone,ShipCustTelePhone,ShipCustAddress,ShipCustAddress1,ShipCustLastName,ShipCustCity,ShipCustState,ShipCustZIPCode,ShipCustCountry,Shipfax from shipbilldetail where id = '".$_SESSION['registerid']."'");
$res = mysql_fetch_assoc($sel)


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ja" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php echo showTitleFab($pagenav); ?>
<link href="../style.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />

<script src="js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/main.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="javascript2/style.css">
<script type="text/javascript" src="javascript2/jquery_003.js"></script>
<script type="text/javascript" src="javascript2/easySlider1.js"></script>
<script type="text/javascript" src="javascript2/jquery.js"></script>
<script type="text/javascript" src="javascript2/this-theme.js"></script>
<script type="text/javascript" src="js/jawelary.js"></script>
<script type="text/javascript" src="js/AjaxHandler.js"></script>
<script type="text/javascript" src="js/svb.js"></script>
<script type="text/javascript" src="js/af_js.js"></script>
<?php echo metaDescription($pagenav); ?>
<meta name="description" content="第四十七ダイヤモンド地区コーポレーションへ！
私たちは、ジュエリーとアート� ®、上質、希少でユニークな作品のコレクターと売り手です。我々は、ニューヨークダイヤモンド地区内の2つの場所を持っている。我々は素晴らしいアンティークジュエリーとレアなアイテムだけでなく、微細なダイヤモンドおよび宝石用原石を専門としています。あなたが私達を扱うときには、ニューヨーク州や、世界中の不動産宝石の様々なアクセスを得る。私たちのコレクションは、美しいもののための重労働と愛の年から構成されています。我々は全てがこのビジネスへの愛が不足している、我々はまた、AGTA（米国宝石貿易協会）の誇りのメンバーであり、私たちはNYのダイヤモンドディーラークラブと密接に連携。 "></head>

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
<div class="checkout-method-box">
<div class="checkout2">1</div>
<div class="checkout-method-text"><strong>Checkout Method</strong></div>
</div>
<div class="checkout-method-box">
<div class="checkout1">2</div>
<div class="checkout-method-text">Billing &amp; Shipping Info </div>
</div>
<div class="checkout-method-box">
<div class="checkout2">3</div>
<div class="checkout-method-text">Shipping &amp; Payment  </div>
</div>
<div class="checkout-method-box">
<div class="checkout2">4</div>
<div class="checkout-method-text">Order Confirmation </div>
</div>
</div>

<form id="frmreg" name="frmreg" method="post" action="dbfunction.php">
<div id="welcome-ddc-box">
<div id="checkout-left-box1">
<div class="email-text-box">First name </div>
<div class="textfelid-box">
    
     <input name="username" id="username" type="text" class="inp"  value="<?php echo stripslashes($res['ShipCustName']); ?>"/>
  </div>
  <div class="email-text-box">
     <label for="billing:city">Last Name</label>
     
  </div>
<div class="textfelid-box">
      <label>
      <input name="userlastname" id="userlastname" type="text" class="inp" value="<?php echo stripslashes($res['ShipCustLastName']); ?>" />
      </label>
  </div>
  <div class="email-text-box"> Address</div>
<div class="textfelid-box">
    
   <input name="useraddress" id="useraddress" type="text" class="inp" value="<?php echo stripslashes($res['ShipCustAddress']); ?>" />
  </div>
  <div class="email-text-box"> Address</div>
<div class="textfelid-box">
    
   <input name="useraddress1" id="useraddress1" type="text" class="inp" value="<?php echo stripslashes($res['ShipCustAddress1']); ?>" />
  </div>
  <div class="email-text-box">City</div>
  <div class="textfelid-box">
    <label>
    <input name="usercity" id="usercity" type="text" class="inp"  value="<?php echo stripslashes($res['ShipCustCity']); ?>"/>
    </label>
  </div>
  <div class="email-text-box">State</div>
<div class="textfelid-box">
    
    <input type="text" name="select2" id="select2" class="inp" value="<?php echo stripslashes($res['ShipCustState']); ?>"/>
  </div>
  
  
  <div id="back-box"><a style="cursor:pointer;" onclick="history.back(-1);" class="link1"> Back</a></div>   
</div>
<div id="checkout-right-box1">
<div class="email-text-box">
    <label id="" for="billing:postcode">Province/Zip Code</label>
    <div> </div>
  </div>
<div class="textfelid-box">
  <input name="province" id="province" maxlength="15" type="text" class="inp" value="<?php echo stripslashes($res['ShipCustZIPCode']); ?>" />
</div>
   <div class="email-text-box">Country</div>
<div class="textfelid-box">
    
    <select name="select3" id="select3" class="inp">
		<option value="">-- select country --</option>
         <?php
			for($i=0;$i<count($COUNTRY_ARRAY);$i++)
			{
			if($res['ShipCustCountry']==$COUNTRY_ARRAY[$i])
						echo '<option value="'.$COUNTRY_ARRAY[$i].'" selected>'.$COUNTRY_ARRAY[$i].'</option>';	
			else
						echo '<option value="'.$COUNTRY_ARRAY[$i].'" >'.$COUNTRY_ARRAY[$i].'</option>';
			}
		?>     
        </select>
  </div>
  <div class="email-text-box">Telephone</div>
  <div class="textfelid-box">
    <label>
    <input name="telephone" id="telephone" type="text" class="inp"  value="<?php echo stripslashes($res['ShipCustTelePhone']); ?>"/>
    </label>
  </div>
  
   <div class="email-text-box">
    <label id="" for="billing:postcode">Cellular Phone</label>
    <div> </div>
  </div>
<div class="textfelid-box">
  <input name="userphone" id="userphone" type="text" class="inp" value="<?php echo stripslashes($res['ShipCustPhone']); ?>" />
</div>
<div class="email-text-box">
     <label for="billing:city">Fax</label>
     <div> </div>
   </div>
<div class="textfelid-box">
    
    <input name="userfax" id="userfax" type="text" class="inp"  value="<?php echo stripslashes($res['Shipfax']); ?>"/>
  </div>
  <div class="email-text-box">
    <label id="" for="billing:postcode">Email Address</label>
    <div> </div>
  </div>
<div class="textfelid-box">
    
    <input name="useremail" id="useremail" type="text" class="inp" value="<?php echo $res['ShipCustEmail']; ?>"  />
  </div>
  

  <div class="continue-box"><input type="image" src="../images/continue.jpg" name="updatebill" alt="continue" border="0" onclick="return validateUpdate()"; style="cursor:pointer;" /><span id="probar"><?php if(isset($_SESSION['msg']))
  									{
										echo $_SESSION['msg'];
										unset($_SESSION['msg']);
										
									}?></span></div>
</div><input type="hidden" id="sendto" name="sendto" value="userprofile" />

<!--show cart-->
<?php echo showCard();?>
<!--end cart-->

</div>
<input type="hidden" name="ship" value="ship" />
</form>

</div>

</div>

<!-- welcome end//-->

<!-- bottom start//-->
<?php echo bottom($abspath); ?>
<!-- bottom end//-->
<!-- Seardh Div -->
<?php echo showSearch($abspath); ?>
<!-- SEarch Deiv -->
</body>
</html>
