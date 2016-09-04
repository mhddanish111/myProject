<?php
session_start();
include("page-add.php");
include("../include/connect.php");
include("../db/db.php");
if($_SESSION['AdminId']=="")
{
echo "<script>window.location.href='index.php';</script>";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin:: 47th Diamond District Corp.</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
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
          <?php echo admin_nav(); ?>
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
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="frm" id="frm">
  <table width="320" border="0" cellpadding="6" cellspacing="0" bgcolor="#3A1F08" class="text">
    <tr>
      <td align="right">&nbsp;</td>
      <td width="220" align="left"><label></label></td>
    </tr>
    <tr>
      <td align="right">Coupon Id</td>
      <td width="200" align="left"><label>
        <input name="keywordsearch" id="keywordsearch" type="text" class="inp" value="<?php echo stripslashes($_POST["keywordsearch"]) ?>" size="35" />
      </label></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td align="left"><label><input type="image" src="images/search.gif" alt="search" width="81" height="26" border="0" onclick="return keywordSearch();"  name="searchtext" style="cursor:pointer;" /></label></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
  </table>
  </form>
  <br /><br />
<table width="90%" height="33" border="0" cellpadding="6" cellspacing="0" class="text1">
  <tr>
    <td><h1><font color="#6B6B6B">Send Coupon List</font></h1></td>
    <td align="right"><a href="#"></a></td>
  </tr>
</table>
<form action="dbfunction.php" method="post" name="delteform" id="delteform" onsubmit="return checkBox();">
<table width="90%" border="0" cellpadding="3" cellspacing="1" class="text1">
  <tr class="text">
    <td height="33" align="center" valign="top" bgcolor="#FFFFFF">
	<table width="60%" border="0" cellpadding="3" cellspacing="1" bgcolor="#3A1F08" class="text1">
	<?php 
	if(isset($_REQUEST['keywordsearch']))
{
	$keywordsearch = mysql_real_escape_string($_REQUEST['keywordsearch']);
	$sql="select sendcoupon.*, coupons.name,coupons.amount from sendcoupon left join coupons on sendcoupon.cid= coupons.id where sendcoupon.couponid like '%$keywordsearch%' order by sendcoupon.id desc";
}
else
{
	$sql="select sendcoupon.*, coupons.name,coupons.amount from sendcoupon left join coupons on sendcoupon.cid= coupons.id order by sendcoupon.id desc";
}
$numrows = mysql_num_rows(mysql_query($sql));
$rowsPerPage = 15;
$pageNum = 1;
if(isset($_GET['page']))
$pageNum = $_GET['page'];
$offset = ($pageNum - 1) * $rowsPerPage;
$maxPage = ceil($numrows/$rowsPerPage);
$self = $_SERVER['PHP_SELF'];
$rs=mysql_query($sql." LIMIT $offset, $rowsPerPage")or die(mysql_error());
?>
      <tr class="text">
        <td width="169" height="33" align="left"><font color="#6B6B6B" class="text"><strong>Userid</strong></font></td>
		<td width="104" height="33" align="left"><font color="#6B6B6B" class="text"><strong>Valid Date</strong></font></td>
		<td width="104" height="33" align="left"><font color="#6B6B6B" class="text"><strong>Coupon Id</strong></font></td>
        <td width="109" align="center"><strong>Usedate </strong></td>
        <td width="144" align="center"><strong>Coupon name</strong></td>
		<td width="93" align="center"><strong>Coupon Amount</strong></td>
        <td width="46" align="center"><input type="checkbox" name="master"  onClick="seleciona()" /></td>
      </tr>
	  <?php
  if(mysql_num_rows($rs)>0)
  {
  	while($new_result = mysql_fetch_assoc($rs))
  	{
  ?>
      <tr>
        <td align="left" bgcolor="#FFFFFF"><?php echo stripslashes($new_result['userid']); ?></td>
		 <td align="left" bgcolor="#FFFFFF"><?php echo stripslashes($new_result['validUpto']); ?></td>
		  <td align="left" bgcolor="#FFFFFF"><?php echo stripslashes($new_result['couponid']); ?></td>
        <td align="center" bgcolor="#FFFFFF"><?php if($new_result['usedate']=='')
													echo "Not Used";
													else
													echo stripslashes($new_result['usedate']); ?></td>
        <td align="center" bgcolor="#FFFFFF"><?php echo stripslashes($new_result['name']); ?></td>
		<td align="center" bgcolor="#FFFFFF">$<?php echo stripslashes($new_result['amount']); ?></td>
        <td align="center" bgcolor="#FFFFFF"><?php 	if($new_result['flag']=="Y")
													{
													echo'<img src="images/blocked.gif">';
													}
													else
													{
		echo'<input type="checkbox" name="box[]" id="checkbox" value="'.$new_result['id'].'" />';
		}
		?>
		</td>
      </tr>
      <?php $sr++;}
							if ($maxPage > 1){
							echo '<tr><td align="center"  colspan="7" bgcolor="#FFFFFF">';
							if ($pageNum > 1){
								$page = $pageNum - 1;
								$prev = " <a href=\"$self?page=$page\" class = 'details'>[Prev]</a> ";
								$first = " <a href=\"$self?page=1\" class = 'details'>[First Page]</a> ";
							} 
							else{
								$prev  = ' [Prev] ';       // we're on page one, don't enable 'previous' link
								$first = ' [First Page] '; // nor 'first page' link
							}
						
						// print 'next' link only if we're not
						// on the last page
							if ($pageNum < $maxPage){	
								$page = $pageNum + 1;
								$next = " <a href=\"$self?page=$page\" class = 'details'>[Next]</a> ";
								$last = " <a href=\"$self?page=$maxPage\" class = 'details'>[Last Page]</a> ";
							} 
							else{
								$next = ' [Next] ';      // we're on the last page, don't enable 'next' link
								$last = ' [Last Page] '; // nor 'last page' link
							}
							$total_page="";
							for($i=1;$i<=$maxPage;$i++){
								if($i==$pageNum){
									$total_page.=$i."&nbsp;";
								}
								else {
									$total_page.=" <a href=\"$self?page=$i\" class = 'details'>$i</a>&nbsp;";
								}
							}
						// print the page navigation link
						//echo "<br><br><span align='center'  class = 'litleblacktext'>   ". $first . $prev . "  ".$total_page." " . $next . $last . "</span><br>";
							if($maxPage>1)
								echo $total_page;
						//end paging part2
						
							echo '</td></tr>';
						}
					}
						else{
			            	echo '<tr><td align="center"  colspan="7" bgcolor="#FFFFFF">No Record Found</td></tr>';						
						}

					?>
    </table>
      <br />
        <br /></td>
  </tr>
</table>
<br />
<table width="50%" height="33" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td></td>
    <td align="right">&nbsp;</td>
    <td width="70" align="right"><input type="image" src="images/delete.gif" alt="delete" width="65" height="26" border="0" name="deltesendingCoupon" onclick="return confirm('Do you really want to delete this?'); return true" /></td>
  </tr>
</table></form>
<br />
<br />
<?php admin_footer(); ?>
</center>
</body>
</html>
