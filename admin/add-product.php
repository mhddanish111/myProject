<?php
session_start();
include("page-add.php");
include("../include/connect.php");
include("../db/db.php");
if($_SESSION['AdminId']=="")
{
echo "<script>window.location.href='index.php';</script>";
}
$catsel = rs_select("category where status ='Y'","catname,ja_catname,id");
//$colsel = rs_select("color where status ='Y'","colorname,id");



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//en" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Admin:: 47th Diamond District Corp.</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="js/validation.js" language="javascript"></script>
</head>

<body bgcolor="#F5F3E3">
<center>
  <?php echo admin_top(); ?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="text">
    <tr>
      <td bgcolor="#583103"><img src="images/dot.gif" width="1" height="2" /></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#3A1F08"><div id="navi-panel">
<?php echo admin_nav();?>
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
      </div></td>
    </tr>
  </table>
  <?php echo admin_right_nav();
  if(isset($_SESSION['msg']))
{
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}?>

<br />
<table width="90%" height="33" border="0" cellpadding="6" cellspacing="0" class="text1">
  <tr>
    <td><h1><font color="#6B6B6B">A</font><font color="#6B6B6B">dd Product </font></h1></td>
    <td align="right"><a href="#"></a></td>
  </tr>
</table>
<form action="dbfunction.php" enctype="multipart/form-data" method="post">
<table width="90%" border="0" cellpadding="3" cellspacing="1" class="text1">
  <tr class="text">
    <td height="33" align="center" valign="top" bgcolor="#FFFFFF"><table width="99%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="60%" valign="top"><table width="470" border="0" cellpadding="0" cellspacing="2" bgcolor="#FFFFFF" class="text1">
          <tr>
            <td height="33" colspan="2" align="left"><strong>General Information 　基本情報</strong></td>
            </tr>
		  <tr>
            <td align="left">Choose <font color="#6B6B6B">Category</font>:</td>
            <td width="262" height="48" align="left" ><label></label>                    <label>
                      &nbsp;
                      <select name="selectcat" class="inp2" id="selectcat" onchange="getServerResponse('selectsub1','AjaxHandler.php?query=selectsub&dublicate='+this.value,'',false)">
                        <option value="">Select Category</option>
						<?php
						while($result = mysql_fetch_assoc($catsel))
						{
							echo'<option value='.$result['id'].'>'. stripslashes($result['catname']).'</option>';
						}
						?>
                      </select>
                    </label>                  </td>
          </tr>
		   <tr>
			<td colspan="2" align="left"><div id="selectsub1"></div></td>
		</tr>
		   <tr>
            <td align="left">サブカテゴリー:</td>
            <td width="262" height="48" align="left" id="japansub"></td>
		    </tr>
		    <tr>
            <td align="left">Title:</td>
            <td width="262" height="48" align="left" ><label></label>
                <input name="title" type="text" class="inp2" value="" id="title" />            </td>
		    </tr>
			<tr>
            <td align="left">タイトル:</td>
            <td width="262" height="48" align="left" ><label></label>
                <input name="jatitle" type="text" class="inp2" value="" id="title" />            </td>
		    </tr>
			<tr>
            <td align="left">Seo Title:</td>
            <td width="262" height="48" align="left" ><label></label>
                <input name="seotitle" type="text" class="inp2" value="" id="seotitle" />            </td>
		    </tr>
			<tr>
            <td align="left">Japense Seo Title:</td>
            <td width="262" height="48" align="left" ><label></label>
                <input name="seojatitle" type="text" class="inp2" value="" id="seojatitle" />            </td>
		    </tr>
			<tr>
            <td width="120"><font color="#6B6B6B">Keywords</font></td>
            <td width="262" height="48" align="left"  ><label></label>
                  <textarea name="keywords" class="inp5" cols="35" rows="4"  id="keywords"></textarea></td>
          </tr>
		  <tr>
            <td width="120"><font color="#6B6B6B">Japense Keywords</font></td>
            <td width="262" height="48" align="left"  ><label></label>
                  <textarea name="jakeywords" class="inp5" cols="35" rows="4"  id="jakeywords"></textarea></td>
          </tr>
		   <tr>
            <td width="120"><font color="#6B6B6B">Seo Description</font></td>
            <td width="262" height="48" align="left" ><label></label>
                    <textarea name="seodescription" class="inp5" cols="35" rows="4"  id="seodescription"></textarea></td>
          </tr>
		  <tr>
            <td width="180"><font color="#6B6B6B">Japense Seo Description</font></td>
            <td width="240" height="48" align="left" ><label></label>
                    <textarea name="jaseodescription" class="inp5" cols="35" rows="4"  id="jaseodescription"></textarea></td>
          </tr>
			
			  <tr>
            <td align="left">Product Description:</td>
            <td width="262" height="90" align="left" ><label></label>                  <label>
                    <textarea name="gendescription" class="inp3" id="gendescription"></textarea>
                    </label>                </td>
		    </tr>
			<tr>
            <td align="left">説明:</td>
            <td width="262" height="90" align="left" ><label></label>                  <label>
                    <textarea name="jagendescription" class="inp3" id="gendescription"></textarea>
                    </label>                </td>
		    </tr>
			  <tr>
            <td align="left">Condition:</td>
            <td width="262" height="48" align="left" ><label></label>
                <input name="gencondiotion" type="text" class="inp2" value="" id="gencondiotion" />            </td>
		    </tr>
			 <tr>
            <td align="left">状態:</td>
            <td width="262" height="48" align="left" ><label></label>
                <input name="jagencondiotion" type="text" class="inp2" value="" id="jagencondiotion" />            </td>
		    </tr>
		     <tr>
            <td>Product <font color="#6B6B6B">Image</font>/写真:</td>
            <td width="262" height="48" ><label></label>
             <input name="subimage" id="sub_image" type="file" class="inp5" />  </td>
		   </tr>
		     <tr>
		       <td align="left">Stock Number:</td>
		       <td width="262" height="48" align="left" ><label></label>
                   <input name="genstock" type="text" class="inp2" value="" id="genstock" />               </td>
		     </tr>
			 <tr>
		       <td align="left">品番:</td>
		       <td width="262" height="48" align="left" ><label></label>
                   <input name="jagenstock" type="text" class="inp2" value="" id="genstock" />               </td>
		     </tr>
			 <tr>
		       <td align="left"><strong>In Stock</strong> :</td>
		       <td width="262" height="33" align="left"><label></label>
                   <input name="instock" id="instock" type="text" class="inp2" maxlength="4"  onkeypress="return checkForInt(event);" />               </td>
		     </tr>
		     <tr>
		       <td align="left">Price:</td>
		       <td width="262" height="48" align="left"><label></label>
                   $&nbsp;<input name="genprice" type="text" class="inp2" value="" id="genprice" onkeypress="return numbersonly(event);" />               </td>
		     </tr>
			  <tr>
		       <td align="left">価格:</td>
		       <td width="262" height="48" align="left"><label></label>
                   <input name="jagenprice" type="text" class="inp2" value="" id="jagenprice" onkeypress="return numbersonly(event);" />               </td>
		     </tr>
		     <tr>
		       <td align="left">Move to Front of section:</td>
		       <td height="48" align="left"><input type="checkbox" name="genfront" value="checkbox" /></td>
		       </tr>
		     <tr>
		       <td align="left">Make Category Picture:</td>
		       <td height="48" align="left"><input type="checkbox" name="gencatpic" value="checkbox" /></td>
		       </tr>
        </table>
          <br />
          <table width="470" border="0" cellpadding="0" cellspacing="3" bgcolor="#FFFFFF" class="text1">
            <tr>
              <td height="33" colspan="2" align="left"><strong>Jewelry Information/ジュエリー</strong></td>
            </tr>
            <tr>
              <td align="left">Brand Name:</td>
              <td width="269" height="48" align="left" ><label></label>
                  <input name="brname" type="text" class="inp2" value="" id="brname" />              </td>
            </tr>
			<tr>
              <td align="left">ブランド名:</td>
              <td width="269" height="48" align="left" ><label></label>
                  <input name="jabrname" type="text" class="inp2" value="" id="brname" />              </td>
            </tr>
            <tr>
              <td align="left">Hallmarks/Origin:</td>
              <td width="269" height="48" align="left" ><label></label>
                  <input name="jehallmarks" type="text" class="inp2" value="" id="jehallmarks" />              </td>
            </tr>
			<tr>
              <td align="left">極印/原産:</td>
              <td width="269" height="48" align="left" ><label></label>
                  <input name="jajehallmarks" type="text" class="inp2" value="" id="jajehallmarks" />              </td>
            </tr>
            <tr>
              <td align="left">Period:</td>
              <td width="269" height="48" align="left" ><label></label>
                  <input name="jeperiod" type="text" class="inp2" value="" id="jeperiod" />              </td>
            </tr>
			<tr>
              <td align="left">時代:</td>
              <td width="269" height="48" align="left" ><label></label>
                  <input name="jajeperiod" type="text" class="inp2" value="" id="jajeperiod" />              </td>
            </tr>
            <tr>
              <td align="left">Total Diamond Weight:</td>
              <td width="269" height="48" align="left" ><label></label>
                  <input name="jediamond" type="text" class="inp2" value="" id="jediamond" />              </td>
            </tr>
			 <tr>
              <td align="left">ダイヤモンドトータルカラット:</td>
              <td width="269" height="48" align="center" ><label></label>
                  <input name="jajediamond" type="text" class="inp2" value="" id="jajediamond" />              </td>
            </tr>
            <tr>
              <td align="left">Diamond Color<strong>:</strong></td>
              <td width="269" height="48" align="center" ><label><input name="jediamondcolor" type="text" class="inp2" value="" id="jediamondcolor" /></label>
                       </td>
            </tr>
			<tr>
              <td align="left">ダイヤモンドカラー<strong>:</strong></td>
              <td width="269" height="48" align="center" ><label><input name="jajediamondcolor" type="text" class="inp2" value="" id="jajediamondcolor" /></label>
                       </td>
            </tr>
            <tr>
              <td align="left">Diamond Clarity<strong>:</strong></td>
              <td width="269" height="48" align="center" ><label></label>
                  <input name="jediamondcl" type="text" class="inp2" value="" id="jediamondcl" />              </td>
            </tr>
			<tr>
              <td align="left">ダイヤモンドクラリティ<strong>:</strong></td>
              <td width="269" height="48" align="center" ><label></label>
                  <input name="jajediamondcl" type="text" class="inp2" value="" id="jajediamondcl" />              </td>
            </tr>
            <tr>
              <td align="left">Total Gemstone Weight<strong>:</strong></td>
              <td width="269" height="48" align="center" ><label></label>
                  <input name="jestoneweight" type="text" class="inp2" value="" id="jestoneweight" />              </td>
            </tr>
			<tr>
              <td align="left">宝石トータルカラット<strong>:</strong></td>
              <td width="269" height="48" align="center" ><label></label>
                  <input name="jajestoneweight" type="text" class="inp2" value="" id="jajestoneweight" />              </td>
            </tr>
            <tr>
              <td align="left">Gemstone Color<strong>:</strong></td>
              <td width="269" height="48" align="center" ><label> <input name="jestonecolor" type="text" class="inp2" value="" id="jestonecolor" /> </label>
                   </td>
            </tr>
			<tr>
              <td align="left">宝石カラー<strong>:</strong></td>
              <td width="269" height="48" align="center" ><label> <input name="jajestonecolor" type="text" class="inp2" value="" id="jajestonecolor" /> </label>
                   </td>
            </tr>
            <tr>
              <td align="left">Gemstone Clarity<strong>:</strong></td>
              <td width="269" height="48" align="center" ><label></label>
                  <input name="jestonecl" id="jestonecl" type="text" class="inp2" value="" />              </td>
            </tr>
			<tr>
              <td align="left">宝石クラリティ<strong>:</strong></td>
              <td width="269" height="48" align="center" ><label></label>
                  <input name="jajestonecl" id="jajestonecl" type="text" class="inp2" value="" />              </td>
            </tr>
            <tr>
              <td align="left">Metal<strong>:</strong></td>
              <td width="269" height="48" align="center" ><label></label>
                  <input name="jemetal" type="text"  id="jemetal"class="inp2" value="" />              </td>
            </tr>
			 <tr>
              <td align="left">地金素材<strong>:</strong></td>
              <td width="269" height="48" align="center" ><label></label>
                  <input name="jajemetal" type="text"  id="jajemetal"class="inp2" value="" />              </td>
            </tr>
            <tr>
              <td align="left">Metal Purity<strong>:</strong></td>
              <td width="269" height="48" align="center" ><label></label>
                  <input name="jemetailpu" type="text" class="inp2" value="" id="jemetailpu" />              </td>
            </tr>
			 <tr>
              <td align="left">純度<strong>:</strong></td>
              <td width="269" height="48" align="center" ><label></label>
                  <input name="jajemetailpu" type="text" class="inp2" value="" id="jajemetailpu" />              </td>
            </tr>
            <tr>
              <td align="left">Total Piece Weight<strong>:</strong></td>
              <td width="269" height="48" align="center" ><label></label>
                  <input name="jempriceweight" id="jempriceweight"type="text" class="inp2" value="" />              </td>
            </tr>
			<tr>
              <td align="left">重さ<strong>:</strong></td>
              <td width="269" height="48" align="center" ><label></label>
                  <input name="jajempriceweight" id="jajempriceweight"type="text" class="inp2" value="" />              </td>
            </tr>
            <tr>
              <td align="left">Dimensions<strong>:</strong></td>
              <td width="269" height="48" align="center" ><label></label>
                  <input name="jedimension" id="jedimension" type="text" class="inp2" value="" />              </td>
            </tr>
			 <tr>
              <td align="left">寸法<strong>:</strong></td>
              <td width="269" height="48" align="center" ><label></label>
                  <input name="jajedimension" id="jajedimension" type="text" class="inp2" value="" />              </td>
            </tr>
            <tr>
              <td align="left">Finger Size:</td>
              <td height="48" align="center" ><input name="jefingersize" id="jefingersize" type="text" class="inp2" value="" /></td>
            </tr>
			<tr>
              <td align="left">リングサイズ:</td>
              <td height="48" align="center" ><input name="jajefingersize" id="jajefingersize" type="text" class="inp2" value="" /></td>
            </tr>
            <tr>
              <td align="left">Sizable/サイズ変更:</td>
              <td height="48" align="left">                  <label>
                    <select name="jeselect" class="inp" id="jeselect">
                      <option  value="">----  Select One ---</option>
                      <option value="1">Yes</option>
                      <option value="2">NO</option>
                    </select>
                    </label>                </td>
            </tr>
          </table>
          <br />
          <table width="450" border="0" cellpadding="0" cellspacing="2" bgcolor="#FFFFFF" class="text1">
            <tr>
              <td height="33" colspan="2" align="left"><strong>Diamond Information / 　ダイヤモンド</strong></td>
            </tr>
            <tr>
              <td align="left">Weight:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="diaweight" type="text" class="inp2" value="" id="diaweight" />
              </td>
            </tr>
			 <tr>
              <td align="left">カラット:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jadiaweight" type="text" class="inp2" value="" id="jadiaweight" />
              </td>
            </tr>
            <tr>
              <td align="left">Shape:</td>
              <td width="262" height="48" align="center" ><label></label>
                <input name="diashap" type="text" class="inp2" value="" id="diashap"/></td>
            </tr>
			<tr>
              <td align="left">シェイプ:</td>
              <td width="262" height="48" align="center" ><label></label>
                <input name="jadiashap" type="text" class="inp2" value="" id="jadiashap"/></td>
            </tr>
            <tr>
              <td align="left">Lab/Certificate:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="dialab" id="dialab" type="text" class="inp2" value="" />
              </td>
            </tr>
			 <tr>
              <td align="left">鑑定機関:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jadialab" id="jadialab" type="text" class="inp2" value="" />
              </td>
            </tr>
            <tr>
              <td align="left">Color:</td>
              <td width="262" height="48" align="center" ><label><input name="diacolor" id="diacolor" type="text" class="inp2" value="" /></label>
                  </td>
            </tr>
			 <tr>
              <td align="left">カラー:</td>
              <td width="262" height="48" align="center" ><label><input name="jadiacolor" id="jadiacolor" type="text" class="inp2" value="" /></label>
                  </td>
            </tr>
            <tr>
              <td align="left">Clarity:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="diaclarity" id="diaclarity" type="text" class="inp2" value="" />
              </td>
            </tr>
			<tr>
              <td align="left">クラリティ:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jadiaclarity" id="jadiaclarity" type="text" class="inp2" value="" />
              </td>
            </tr>
            <tr>
              <td align="left">Cut:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="diacut" type="text" class="inp2" value="" id="diacut" />
              </td>
            </tr>
			<tr>
              <td align="left">カット状態:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jadiacut" type="text" class="inp2" value="" id="jadiacut" />
              </td>
            </tr>
            <tr>
              <td align="left">Polish:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="daipolish" type="text" class="inp2" value="" id="daipolish" />
              </td>
            </tr>
			 <tr>
              <td align="left">研磨状態:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jadaipolish" type="text" class="inp2" value="" id="jadaipolish" />
              </td>
            </tr>
            <tr>
              <td align="left">Symmetry</td>
              <td height="48" align="center" ><input name="diasymmetry" id="diasymmetry" type="text" class="inp2" value="" /></td>
            </tr>
			 <tr>
              <td align="left">対称性</td>
              <td height="48" align="center" ><input name="jadiasymmetry" id="jadiasymmetry" type="text" class="inp2" value="" /></td>
            </tr>
            <tr>
              <td align="left">Fluorescence:</td>
              <td height="48" align="center" ><input name="diafluor" type="text" id="diafluor" class="inp2" value="" /></td>
            </tr>
			<tr>
              <td align="left">蛍光性:</td>
              <td height="48" align="center" ><input name="jadiafluor" type="text" id="jadiafluor" class="inp2" value="" /></td>
            </tr>
            <tr>
              <td align="left">Table %:</td>
              <td height="48" align="center" ><input name="diatable" type="text" class="inp2" value="" id="diatable" /></td>
            </tr>
			<tr>
              <td align="left">テーブル %:</td>
              <td height="48" align="center" ><input name="jadiatable" type="text" class="inp2" value="" id="jadiatable" /></td>
            </tr>
            <tr>
              <td align="left">Depth %</td>
              <td height="48" align="center" ><input name="diadepth" type="text" class="inp2" value="" id="diadepth" /></td>
            </tr>
			  <tr>
              <td align="left">深さ%</td>
              <td height="48" align="center" ><input name="jadiadepth" type="text" class="inp2" value="" id="jadiadepth" /></td>
            </tr>
            <tr>
              <td align="left">Measurements:</td>
              <td height="48" align="center" ><input name="diameasurment" type="text" class="inp2" value="" id="diameasurment" /></td>
            </tr>
			 <tr>
              <td align="left">寸法:</td>
              <td height="48" align="center" ><input name="jadiameasurment" type="text" class="inp2" value="" id="jadiameasurment" /></td>
            </tr>
            <tr>
              <td align="left">Remarks:</td>
              <td height="48" align="center" ><input name="diaremarks" type="text" class="inp2" value="" id="diaremarks" /></td>
            </tr>
			<tr>
              <td align="left">備考:</td>
              <td height="48" align="center" ><input name="jadiaremarks" type="text" class="inp2" value="" id="jadiaremarks" /></td>
            </tr>
			<tr>
              <td align="left">Price Per Carat:</td>
              <td height="48" align="center" ><input name="diapercarat" id="diapercarat" type="text" class="inp2" value="" /></td>
            </tr>
			<tr>
              <td align="left">カラットあたりの価格:</td>
              <td height="48" align="center" ><input name="jadiapercarat" id="jadiapercarat" type="text" class="inp2" value="" /></td>
            </tr>
           
          </table></td>
        <td valign="top"><table width="450" border="0" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF" class="text1">
			 
			 
            <tr>
              <td align="left">Total Price:</td>
              <td height="48" align="center" ><input name="diatotalprice" type="text" class="inp2" value="" id="diatotalprice" /></td>
            </tr>.
			 <tr>
              <td align="left">合計価格:</td>
              <td height="48" align="center" ><input name="jadiatotalprice" type="text" class="inp2" value="" id="jadiatotalprice" /></td>
            </tr>
            <tr>
              <td height="33" colspan="2" align="left"><strong>Gemstone Information / 　宝石</strong></td>
            </tr>
            <tr>
              <td align="left">Carat Weight:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="gemcarat" id="gemcarat" type="text" class="inp2" value="" />              </td>
            </tr>
			<tr>
              <td align="left">カラット:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jagemcarat" id="jagemcarat" type="text" class="inp2" value="" />              </td>
            </tr>
            <tr>
              <td align="left">Gemstone Type:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="gemstonetype" type="text" class="inp2" value="" id="gemstonetype" />              </td>
            </tr>
			<tr>
              <td align="left">宝石種類:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jagemstonetype" type="text" class="inp2" value="" id="jagemstonetype" />              </td>
            </tr>
            <tr>
              <td align="left">Shape:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="gemshape" type="text" class="inp2" value="" id="gemshape" />              </td>
            </tr>
			 <tr>
              <td align="left">シェイプ:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jagemshape" type="text" class="inp2" value="" id="jagemshape" />              </td>
            </tr>
            <tr>
              <td align="left">Color:</td>
              <td width="262" height="48" align="center" ><label><input name="gemcolor" type="text" class="inp2" value="" id="gemcolor" /></label>
                  </td>
            </tr>
			 <tr>
              <td align="left">カラー:</td>
              <td width="262" height="48" align="center" ><label><input name="jagemcolor" type="text" class="inp2" value="" id="jagemcolor" /></label>
                  </td>
            </tr>
            <tr>
              <td align="left">Clarity:</td>
              <td height="48" align="center" ><input name="gemclarity" id="gemclarity" type="text" class="inp2" value="" /></td>
            </tr>
			<tr>
              <td align="left">クラリティ:</td>
              <td height="48" align="center" ><input name="jagemclarity" id="jagemclarity" type="text" class="inp2" value="" /></td>
            </tr>
            <tr>
              <td align="left">Cut:</td>
              <td height="48" align="center" ><input name="gemcut" id="gemcut" type="text" class="inp2" value="" /></td>
            </tr>
			 <tr>
              <td align="left">カット状態:</td>
              <td height="48" align="center" ><input name="jagemcut" id="jagemcut" type="text" class="inp2" value="" /></td>
            </tr>
            <tr>
              <td align="left">Origin:</td>
              <td height="48" align="center" ><input name="gemorigin" id="gemorigin" type="text" class="inp2" value="" /></td>
            </tr>
			<tr>
              <td align="left">原産:</td>
              <td height="48" align="center" ><input name="jagemorigin" id="jagemorigin" type="text" class="inp2" value="" /></td>
            </tr>
            <tr>
              <td align="left">Treatment:</td>
              <td height="48" align="center" ><input name="gemtreatment" id="gemtreatment" type="text" class="inp2" value="" /></td>
            </tr>
			 <tr>
              <td align="left">人口処理:</td>
              <td height="48" align="center" ><input name="jagemtreatment" id="jagemtreatment" type="text" class="inp2" value="" /></td>
            </tr>
            <tr>
              <td align="left">Lab/Certificate:</td>
              <td height="48" align="center" ><input name="gemlab" id="gemlab" type="text" class="inp2" value="" /></td>
            </tr>
			 <tr>
              <td align="left">鑑定機関:</td>
              <td height="48" align="center" ><input name="jagemlab" id="jagemlab" type="text" class="inp2" value="" /></td>
            </tr>
            <tr>
              <td align="left">Remarks:</td>
              <td height="48" align="center" ><input name="gemremarks" id="gemremarks" type="text" class="inp2" value="" /></td>
            </tr>
			 <tr>
              <td align="left">備考:</td>
              <td height="48" align="center" ><input name="jagemremarks" id="jagemremarks" type="text" class="inp2" value="" /></td>
            </tr>
          </table>
          <br />
          <table width="450" border="0" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF" class="text1">
            <tr>
              <td height="33" colspan="2" align="left"><strong>Watch Information/時計</strong></td>
            </tr>
            <tr>
              <td align="left">Brand Name:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="watbrand" id="watbrand" type="text" class="inp2" value="" />              </td>
            </tr>
			 <tr>
              <td align="left">ブランド名:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jawatbrand" id="jawatbrand" type="text" class="inp2" value="" />              </td>
            </tr>
            <tr>
              <td align="left">Model:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="watmodel" id="watmodel" type="text" class="inp2" value="" />              </td>
            </tr>
			<tr>
              <td align="left">モデル:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jawatmodel" id="jawatmodel" type="text" class="inp2" value="" />              </td>
            </tr>
            <tr>
              <td align="left">Gender:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="watgender" id="watgender" type="text" class="inp2" value="" />              </td>
            </tr>
			<tr>
              <td align="left">ジェンダー:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jawatgender" id="jawatgender" type="text" class="inp2" value="" />              </td>
            </tr>
            <tr>
              <td align="left">Age/Condition:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="watage" id="watage" type="text" class="inp2" value="" />              </td>
            </tr>
			<tr>
              <td align="left">年数/コンディション:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jawatage" id="jawatage" type="text" class="inp2" value="" />              </td>
            </tr>
            <tr>
              <td align="left">Features: </td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="watfeatures" id="watfeatures" type="text" class="inp2" value="" />              </td>
            </tr>
			 <tr>
              <td align="left">&nbsp;</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="watfeatures1" type="text" id="watfeatures1" class="inp2" value="" />              </td>
            </tr>
			<tr>
              <td align="left">&nbsp;</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="watfeatures2" id="watfeatures2" type="text" class="inp2" value="" />              </td>
            </tr>
			<tr>
              <td align="left">&nbsp;</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="watfeatures3" id="watfeatures3" type="text" class="inp2" value="" />              </td>
            </tr>
			<tr>
              <td align="left">仕様: </td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jawatfeatures" id="jawatfeatures" type="text" class="inp2" value="" />              </td>
            </tr>
			
			<tr>
              <td align="left">&nbsp;</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jawatfeatures1" type="text" id="jawatfeatures1" class="inp2" value="" />              </td>
            </tr>
			 <tr>
              <td align="left">&nbsp;</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jawatfeatures2" id="jawatfeatures2" type="text" class="inp2" value="" />              </td>
            </tr>
			 
			<tr>
              <td align="left">&nbsp;</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jawatfeatures3" id="jawatfeatures3" type="text" class="inp2" value="" />              </td>
            </tr>
            <tr>
              <td align="left">Movement<strong>:</strong></td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="watmovement" id="watmovement" type="text" class="inp2" value="" />              </td>
            </tr>
			 <tr>
              <td align="left">ムーブメント<strong>:</strong></td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jawatmovement" id="jawatmovement" type="text" class="inp2" value="" />              </td>
            </tr>
            <tr>
              <td align="left">Case Material:</td>
              <td height="48" align="center" ><input name="watcase" id="watcase" type="text" class="inp2" value="" /></td>
            </tr>
			 <tr>
              <td align="left">ケース素材:</td>
              <td height="48" align="center" ><input name="jawatcase" id="jawatcase" type="text" class="inp2" value="" /></td>
            </tr>
			
            <tr>
              <td align="left">Band Material:</td>
              <td height="48" align="center" ><input name="watband" type="text" class="inp2" value="" id="watband" /></td>
            </tr>
			 <tr>
              <td align="left">バンド素材:</td>
              <td height="48" align="center" ><input name="jawatband" type="text" class="inp2" value="" id="jawatband" /></td>
            </tr>
			<tr>
              <td align="left">Dimensions:</td>
              <td height="48" align="center" ><input name="watdim" id="watdim" type="text" class="inp2" value="" /></td>
            </tr>
			<tr>
              <td align="left">寸法:</td>
              <td height="48" align="center" ><input name="jawatdim" id="jawatdim" type="text" class="inp2" value="" /></td>
            </tr>
            <tr>
              <td align="left">Carat Weight:</td>
              <td height="48" align="center" ><input name="watcarat" id="watcarat" type="text" class="inp2" value="" /></td>
            </tr>
			<tr>
              <td align="left">カラット:</td>
              <td height="48" align="center" ><input name="jawatcarat" id="jawatcarat" type="text" class="inp2" value="" /></td>
            </tr>
            <tr>
              <td align="left">Box &amp; Papers:</td>
              <td height="48" align="center" ><input name="watbox" id="watbox" type="text" class="inp2" value="" /></td>
            </tr>
			<tr>
              <td align="left">箱&保障: </td>
              <td height="48" align="center" ><input name="jawatbox" id="jawatbox" type="text" class="inp2" value="" /></td>
            </tr>
            <tr>
              <td align="left">Warranty:</td>
              <td height="48" align="center" ><input name="watwarranty" id="watwarranty" type="text" class="inp2" value="" /></td>
            </tr>
			 <tr>
              <td align="left">保障期間:</td>
              <td height="48" align="center" ><input name="jawatwarranty" id="jawatwarranty" type="text" class="inp2" value="" /></td>
            </tr>
            <tr>
              <td align="left">Remarks:</td>
              <td height="48" align="center" ><input name="watremarks" id="watremarks" type="text" class="inp2" value="" /></td>
            </tr>
			<tr>
              <td align="left">備考:</td>
              <td height="48" align="center" ><input name="jawatremarks" id="jawatremarks" type="text" class="inp2" value="" /></td>
            </tr>
          </table>
          <br />
          <table width="450" border="0" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF" class="text1">
            <tr>
              <td height="33" colspan="2" align="left"><strong>Object Information/ コレクション</strong></td>
            </tr>
            <tr>
              <td align="left">Brand Name:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="objbrandname" id="objbrandname" type="text" class="inp2" value="" />              </td>
            </tr>
			 <tr>
              <td align="left">ブランド名:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jaobjbrandname" id="jaobjbrandname" type="text" class="inp2" value="" />              </td>
            </tr>
            <tr>
              <td align="left">Hallmarks/Origin:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="objhall" id="objhall" type="text" class="inp2" value="" />              </td>
            </tr>
			 <tr>
              <td align="left">刻印/原産:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jaobjhall" id="jaobjhall" type="text" class="inp2" value="" />              </td>
            </tr>
            <tr>
              <td align="left">Period:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="objperiod" id="objperiod" type="text" class="inp2" value="" />              </td>
            </tr>
			<tr>
              <td align="left">時代:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jaobjperiod" id="jaobjperiod" type="text" class="inp2" value="" />              </td>
            </tr>
            <tr>
              <td align="left">Style:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="objstyle" id="objstyle" type="text" class="inp2" value="" />              </td>
            </tr>
			  <tr>
              <td align="left">スタイル:</td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jaobjstyle" id="jaobjstyle" type="text" class="inp2" value="" />              </td>
            </tr>
            <tr>
              <td align="left">Material<strong>:</strong></td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="objmaterial" id="objmaterial" type="text" class="inp2" value="" />              </td>
            </tr>
			<tr>
              <td align="left">素材<strong>:</strong></td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jaobjmaterial" id="jaobjmaterial" type="text" class="inp2" value="" />              </td>
            </tr>
			<tr>
              <td align="left">Dimensions<strong>:</strong></td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="objdimensions" id="objdimensions" type="text" class="inp2" value="" />              </td>
            </tr>
			<tr>
              <td align="left">寸法<strong>:</strong></td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jaobjdimensions" id="jaobjdimensions" type="text" class="inp2" value="" />              </td>
            </tr>
			<tr>
              <td align="left">Weight<strong>:</strong></td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="objweight" id="objweight" type="text" class="inp2" value="" />              </td>
            </tr>
			<tr>
              <td align="left">重さ<strong>:</strong></td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jaobjweight" id="jaobjweight" type="text" class="inp2" value="" />              </td>
            </tr>
			<tr>
              <td align="left">Remarks<strong>:</strong></td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="objremarks" id="objremarks" type="text" class="inp2" value="" />              </td>
            </tr>
			<tr>
              <td align="left">備考<strong>:</strong></td>
              <td width="262" height="48" align="center" ><label></label>
                  <input name="jaobjremarks" id="jaobjremarks" type="text" class="inp2" value="" />              </td>
            </tr>
			<tr>
              <td align="left" colspan="2"><strong>Other Information :</strong></td>
              </tr>
			<tr>
              <td colspan="2" id="moreproducttd">
			  <div style="padding-bottom:5px; overflow:auto;">
				<div style="float:left; width:25%;">Name </div>
				 <div style="float:left; width:25%;">Value</div>
				 <div style="float:left; width:25%;">の名前 </div>
				 <div style="float:left; width:25%;">の値</div>
				 </div>
			  <div style="padding-bottom:10px; overflow:auto;">
				<div style="float:left; width:25%;"><input type="text" class="inp22" name="order_item_0" id="order_item_0" value="" /></div>
				 <div style="float:left; width:25%;"><input type="text" class="inp22" name="order_value_0" id="order_value_0" value="" /></div>
				 <div style="float:left; width:25%;"><input type="text" class="inp22" name="jaorder_item_0" id="jaorder_item_0" value="" /></div>
				 <div style="float:left; width:25%;"><input type="text" class="inp22" name="jaorder_value_0" id="jaorder_value_0" value="" /></div>
				 </div>
			</td></tr>
			<tr><td>
				 <div style="padding-bottom:10px; overflow:auto;">
				<div style="float:left; width:50%;"></div>
				 <div style="float:left; width:50%;"></div>
				 </div>
				 <div><img src="images/add-more.gif" alt="add more products" border="0" onclick="addMoreProduct();" style="cursor:pointer;" id="btnaddmore" /></div>
				 <input type="hidden" id="itemecount" name="itemecount" value="0"/>
			  </td>
			  </tr>
			  <tr>
              <td colspan="2" style="height:33px;" align="left"><strong>Shiping Charge:</strong></td>
			  </tr>
            <tr>
              <td>International:</td>
			  <td height="48" align="left"><label>
                <input type="text" name="shipchargeint" id="shipchargeint" class="inp2" />
                </label>              </td>
			</tr>
			<tr>
              <td>Domestic:</td>
			  <td height="48" align="left"><label>
                <input type="text" name="shipchargedom" id="shipchargedom" class="inp2" />
                </label>              </td>
			</tr>
			<tr>
              <td>Publish:</td>
			  <td height="48" align="left"><label>
                <input type="checkbox" name="objpublish" value="checkbox" />
                </label>              </td>
			  </tr>
            <tr>
              <td height="48" colspan="2" align="center"><table width="240" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center"><input type="image" src="images/save.gif" name="addProduct" onclick="return addProduct();" alt="submit" width="99" height="30" border="0" /></td>
                  <td align="center"><img src="images/cancel.gif" alt="clear" width="99" height="30" border="0" onclick="history.back(-1);" style="cursor:pointer" /></td>
                </tr>
              </table></td>
              </tr>
          </table></td></tr>
    </table>
        <br />
        <br /></td>
  </tr>
</table></form>
<br />

<br />
<?php echo  admin_footer(); ?>
</center>
</body>
</html>
