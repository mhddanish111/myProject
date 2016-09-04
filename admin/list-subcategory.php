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
<script type="text/javascript" src="js/validation.js"> </script>
</head>
<body bgcolor="#F5F3E3">
<center>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#331C09" class="text">
    <tr>
      <td width="300" align="center" bgcolor="#331C09"><img src="images/logo.gif" alt="logo" width="286" height="97" /></td>
      <td align="right" bgcolor="#331C09">&nbsp;</td>
      <td width="150" bgcolor="#331C09"><h2><font color="#EEDD8F">Admin Panel</font></h2></td>
    </tr>
  </table>
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
<table width="90%" height="33" border="0" cellpadding="6" cellspacing="0" class="text1">
  <tr>
    <td><h1><font color="#6B6B6B">List  Sub Category</font></h1></td>
    <td align="right"><a href="#"></a></td>
  </tr>
</table>
<form action="dbfunction.php" method="post" name="delteform" id="delteform" onsubmit="return checkBox();">
<table width="90%" border="0" cellpadding="3" cellspacing="1" class="text1">
  <tr class="text">
    <td height="33" align="center" valign="top" bgcolor="#FFFFFF"><table width="50%" border="0" cellpadding="3" cellspacing="1" bgcolor="#3A1F08" class="text1">
      <tr class="text">
        <td height="33" align="left"><font color="#6B6B6B" class="text"><strong>Category</strong></font></td>
		<td height="33" align="left"><font color="#6B6B6B" class="text"><strong>カテゴリ</strong></font></td>
        <td align="left"><strong>Sub</strong> <font color="#6B6B6B" class="text"><strong>Category</strong></font></td>
        <td width="100" align="center"><strong>View </strong></td>
        <td width="50" align="center"><strong>Status </strong></td>
        <!--<td width="50" align="center"><strong>Edit</strong></td>-->
        <td width="50" align="center"><input type="checkbox" name="master"  onClick="seleciona();" /></td>
      </tr>
<?php $sql="select * from category order by id desc";
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
	//echo "select count(*) as numrows,id as subcatid from subcategory where catid = '".$new_result['id']."'";
	$res = mysql_query("select count(*) as numrows from subcategory where catid = '".$new_result['id']."'");
	$result = mysql_fetch_assoc($res);
	?>
	<tr>
        <td align="left" bgcolor="#FFFFFF"><?php echo stripslashes($new_result['catname']); ?></td>
		<td align="left" bgcolor="#FFFFFF"><?php echo stripslashes($new_result['ja_catname']); ?></td>
        <td align="left" bgcolor="#FFFFFF"><font color="#6B6B6B"><?php echo "(".$result['numrows'].")";?></font>
		</td>
        <td align="center" bgcolor="#FFFFFF"><a href="view-list-subategory.php?catname=<?php echo  $new_result['id']; ?>" class="blink">view</a></td>
        <td align="center" bgcolor="#FFFFFF"><?php if($new_result['status']=="Y") 
									echo '<img src="images/publish.jpg"  alt="visibility" width="15" height="16" />';
									else
									echo'<img src="images/delete.jpg" alt="in active" width="15" height="16" />'; ?></td>
        
        <td align="center" bgcolor="#FFFFFF"><?php $selpro = mysql_query("select catid from subcategory where catid ='".$new_result['id']."'");
										  $prores = mysql_fetch_assoc($selpro);
										if($prores)
										{
										   		echo '<img src="images/blocked.gif">';
										}
										else
										{ 
												echo'<input type="checkbox" name="box[]" id="checkbox" value="'.$new_result['id'].'" />';
										}
										?></td>
      </tr>
	<?php $sr++;}
							if ($maxPage > 1){
							echo '<tr><td align="center"  colspan="5" bgcolor="#FFFFFF">';
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
			            	echo '<tr><td align="center"  colspan="5" bgcolor="#FFFFFF">No Record Found</td></tr>';						
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
    <td align="right"><input type="image" src="images/publish.gif" alt="visibility" width="65" height="26" border="0" name="publishcat" /></td>
    <td width="70" align="right"><input type="image" src="images/delete.gif" alt="delete" width="65" height="26" border="0" name="deltecat" onclick="return confirm('Do you really want to delete this?'); return true" /></td>
  </tr>
</table>
</form>
<br />
<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="text1">
  <tr>
    <td align="center">Copyright &copy; 2011. 47th Diamond District Corp.</td>
  </tr>
</table>
</center>
</body>
</html>
