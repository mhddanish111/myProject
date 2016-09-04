<?php
session_start();
include("page-add.php");
include("../include/connect.php");
include("../db/db.php");
$imagepath = "../gallery/large/";
//$imagenew = "../gallery/small/";
$imagelist = "../gallery/list/";
if($_SESSION['AdminId']=="")
{
echo "<script>window.location.href='index.php';</script>";
}
$catid = $_REQUEST['catname'];
$sql = rs_select_con("category","id='$catid'");
$res = mysql_fetch_assoc($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//en" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
}
?>
  <br />
  <table width="90%" height="33" border="0" cellpadding="6" cellspacing="0" class="text1">
    <tr>
      <td><h1><font color="#6B6B6B">List  Sub Category</font></h1></td>
      <td align="right"><a href="#"></a></td>
    </tr>
  </table>
  <form action="dbfunction.php" method="post" name="delteform" id="delteform" onsubmit="return checkBox();">
  <table width="90%" border="0" cellpadding="3" cellspacing="1" class="text1">
    <tr class="text">
      <td height="33" align="center" valign="top" bgcolor="#FFFFFF"><table width="80%" border="0" cellpadding="3" cellspacing="1" bgcolor="#3A1F08" class="text1">
          <tr class="text">
            <td width="101" height="33" align="left"><font color="#6B6B6B" class="text"><strong>Category</strong></font></td>
			<td width="101" height="33" align="left"><font color="#6B6B6B" class="text"><strong>カテゴリ</strong></font></td>
            <td width="147" align="left"><strong>Sub</strong> <font color="#6B6B6B" class="text"><strong>Category</strong></font></td>
			<td width="147" align="left"><strong>サブ</strong> <font color="#6B6B6B" class="text"><strong>カテゴリ</strong></font></td>
            <td width="100" align="center"><strong>Sub Cat Image</strong></td>
            <td width="103" align="center"><strong>Products</strong></td>
            <td width="128" align="center"><strong> View Products</strong></td>
            <td width="90" align="center"><strong>Status </strong></td>
            <td width="50" align="center"><strong>Edit</strong></td>
            <td width="50" align="center"><input type="checkbox" name="master"  onClick="seleciona();" /></td>
          </tr>
<?php $sql="SELECT subcategory.*,category.catname, category.ja_catname FROM subcategory INNER JOIN category ON subcategory.catid = category.id WHERE subcategory.catid = '$catid'
ORDER BY subcategory.id DESC";
$numrows = mysql_num_rows(mysql_query($sql));
$rowsPerPage = 15;
$pageNum = 1;
if(isset($_GET['page']))
$pageNum = $_GET['page'];
$offset = ($pageNum - 1) * $rowsPerPage;
$maxPage = ceil($numrows/$rowsPerPage);
$self = $_SERVER['PHP_SELF'];
$rs=mysql_query($sql." LIMIT $offset, $rowsPerPage")or die(mysql_error());
if(mysql_num_rows($rs)>0)
{
	while($new_result = mysql_fetch_assoc($rs))
  	{
		$res1 = mysql_query("select count(*) as numrows from product where subcatid = '".$new_result['id']."' and catid='".$res['id']."'");
		$result = mysql_fetch_assoc($res1);
?> 
   <tr>
            <td align="left" bgcolor="#FFFFFF"><?php echo stripslashes($new_result['catname']); ?></td>
			<td align="left" bgcolor="#FFFFFF"><?php echo stripslashes($new_result['ja_catname']); ?></td>
            <td align="left" bgcolor="#FFFFFF"><font color="#6B6B6B"><?php echo stripslashes($new_result['subcat']); ?></font></td>
			 <td align="left" bgcolor="#FFFFFF"><font color="#6B6B6B"><?php echo stripslashes($new_result['ja_subcat']); ?></font></td>
            <td align="center" bgcolor="#FFFFFF"><img src="<?php echo $imagelist.$new_result['imagepath']; ?>" height="20" width="20"></td>
            <td align="center" bgcolor="#FFFFFF"><?php echo "(".$result['numrows'].")";?></td>
            <td align="center" bgcolor="#FFFFFF"><a href="view-products.php?catname=<?php echo $res['id'];?>&subcatname=<?php echo $new_result['id']; ?>" class="blink">view</a></td>
            <td align="center" bgcolor="#FFFFFF"><?php if($new_result['status']=="Y") 
									echo '<img src="images/publish.jpg"  alt="visibility" width="15" height="16" />';
									else
									echo'<img src="images/delete.jpg" alt="in active" width="15" height="16" />'; ?></td>
            <td align="center" bgcolor="#FFFFFF"><a href="edit-subcategory.php?editid=<?php echo $new_result['id']; ?>&page=<?php echo $pageNum ?>&catname=<?php echo $catid; ?>"><img src="images/edit.gif" alt="edit" width="16" height="13" border="0" /></a></td>
            <td align="center" bgcolor="#FFFFFF"><?php $selpro = mysql_query("select catid,subcatid from product where subcatid = '".$new_result['id']."' and catid='".$res['id']."'");
										  $prores = mysql_fetch_assoc($selpro);
										if($prores)
										{
										   		echo '<img src="images/blocked.gif">';
										}
										else
										{ 
												echo'<input type="checkbox" name="box[]" id="checkbox" value="'.$new_result['id'].'" />';
										}
										?>
			
          </tr>
          <?php $sr++;}
							if ($maxPage > 1){
							echo '<tr><td align="center"  colspan="10" bgcolor="#FFFFFF">';
							if ($pageNum > 1){
								$page = $pageNum - 1;
								$prev = " <a href=\"$self?page=$page&catname=$catid\" class = 'details'>[Prev]</a> ";
								$first = " <a href=\"$self?page=1&catname=$catid\" class = 'details'>[First Page]</a> ";
							} 
							else{
								$prev  = ' [Prev] ';       // we're on page one, don't enable 'previous' link
								$first = ' [First Page] '; // nor 'first page' link
							}
						
						// print 'next' link only if we're not
						// on the last page
							if ($pageNum < $maxPage){	
								$page = $pageNum + 1;
								$next = " <a href=\"$self?page=$page&catname=$catid\" class = 'details'>[Next]</a> ";
								$last = " <a href=\"$self?page=$maxPage&catname=$catid\" class = 'details'>[Last Page]</a> ";
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
									$total_page.=" <a href=\"$self?page=$i&catname=$catid\" class = 'details'>$i</a>&nbsp;";
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
			            	echo '<tr><td align="center"  colspan="10" bgcolor="#FFFFFF">No Record Found</td></tr>';						
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
      <td align="right"><input type="image" src="images/publish.gif" alt="visibility" width="65" height="26" border="0" name="publishsubsubcat" /></td>
    <td width="70" align="right"><input type="image" src="images/delete.gif" alt="delete" width="65" height="26" border="0" name="deltesubsubcat" onclick="return confirm('Do you really want to delete this?'); return true" /></td>
    </tr>
  </table>
  <input type="hidden" name="catname" value="<?php echo $_REQUEST["catname"]; ?>" /></form>
  <br />
<br />
<br />
<?php echo admin_footer(); ?>
</center>
</body>
</html>
