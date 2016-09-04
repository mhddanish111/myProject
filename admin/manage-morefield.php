<?php
session_start();
include("page-add.php");
include("../include/connect.php");
include("../db/db.php");
if($_SESSION['AdminId']=="")
{
echo "<script>window.location.href='index.php';</script>";
}
//$morepro = rs_select("moreproduct where productid ='".$_REQUEST['productname']."'","id,	fieldname,fieldvalue");
$productname = $_REQUEST['productname'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//en" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<table width="90%" height="33" border="0" cellpadding="6" cellspacing="0" class="text1">
  <tr>
    <td><h1><font color="#6B6B6B">M</font><font color="#6B6B6B">anage More Field</font></h1></td>
    <td align="right"><a href="add-morefield.php?productname=<?php echo $_REQUEST['productname']; ?>" class="blink"><strong>Add More Field</strong></a></td>
  </tr>
</table>
<form action="dbfunction.php" method="post" name="delteform" id="delteform" onsubmit="return checkBox();">
<table width="90%" border="0" cellpadding="3" cellspacing="1" class="text1">
	<tr class="text">
    	<td height="33" align="center" valign="top" bgcolor="#FFFFFF">
			<table width="52%" border="0" cellpadding="3" cellspacing="1" bgcolor="#3A1F08" class="text1">
  				<tr class="text">
  				  	<td height="33" align="left"><font color="#6B6B6B" class="text"><strong>Name</strong></font></td>
					<td height="33" align="left"><font color="#6B6B6B" class="text"><strong>Value</strong></font></td>
					<td height="33" align="left"><font color="#6B6B6B" class="text"><strong>の名前</strong></font></td>
					<td height="33" align="left"><font color="#6B6B6B" class="text"><strong>の値</strong></font></td>
					<td width="75" align="center"><font color="#6B6B6B" class="text"><strong>Edit</strong></font></td>
					<td width="75" align="center"><input type="checkbox" name="master"  onClick="seleciona();" /></td>
				</tr>
			
			  	<?php
				 $sql="select * from moreproduct where productid ='".$_REQUEST['productname']."' order by id desc";
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
				$i=0; 	
				while($moreres = mysql_fetch_assoc($rs))
				{
				echo'<tr>
					<td align="left"  bgcolor="#FFFFFF">'.$moreres['fieldname'].'</td>
					<td align="left"  bgcolor="#FFFFFF">'.$moreres['fieldvalue'].'</td>
					<td align="left"  bgcolor="#FFFFFF">'.$moreres['jafieldname'].'</td>
					<td align="left"  bgcolor="#FFFFFF">'.$moreres['jafieldvalue'].'</td>
					<td align="center"  bgcolor="#FFFFFF"><a href="edit-morefield.php?fieldid='.$moreres['id'].'&page='.$pageNum.'&productname='.$_REQUEST['productname'].'"><img src="images/edit.gif" alt="edit" width="16" height="13" border="0" /></a></td>
					<td align="center"  bgcolor="#FFFFFF"><input type="checkbox" name="box[]" id="checkbox" value="'.$moreres['id'].'" /><td>
					</tr>';
				 $i++;
				 } ?>
				 
			<?php if ($maxPage > 1){
							echo '<tr><td align="center"  colspan="6" bgcolor="#FFFFFF">';
							if ($pageNum > 1){
								$page = $pageNum - 1;
								$prev = " <a href=\"$self?page=$page&productname=$productname\" class = 'details'>[Prev]</a> ";
								$first = " <a href=\"$self?page=1&productname=$productname\" class = 'details'>[First Page]</a> ";
							} 
							else{
								$prev  = ' [Prev] ';       // we're on page one, don't enable 'previous' link
								$first = ' [First Page] '; // nor 'first page' link
							}
						
						// print 'next' link only if we're not
						// on the last page
							if ($pageNum < $maxPage){	
								$page = $pageNum + 1;
								$next = " <a href=\"$self?page=$page&productname=$productname\" class = 'details'>[Next]</a> ";
								$last = " <a href=\"$self?page=$maxPage&productname=$productname\" class = 'details'>[Last Page]</a> ";
							} 
							else{
								$next = ' [Next] ';      // we're on the last page, don't enable 'next' link
								$last = ' [Last Page] '; // nor 'last page' link
							}
							$total_page="";
							for($j=1;$j<=$maxPage;$j++){
								if($j==$pageNum){
									$total_page.=$j."&nbsp;";
								}
								else {
									$total_page.=" <a href=\"$self?page=$j&productname=$productname\" class = 'details'>$j</a>&nbsp;";
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
			            	echo '<tr><td align="center" colspan="6" bgcolor="#FFFFFF">No Record Found</td></tr>';						
						}

					?>
				</table>
      </td>
  </tr>
</table>
<br />
<table width="50%" height="33" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td></td>
    <td width="70" align="right"><input type="image" src="images/delete.gif" alt="delete" width="65" height="26" border="0" name="deltemorefield" onclick="return confirm('Do you really want to delete this?'); return true" /></td>
  </tr>
</table>
        <input type="hidden" name="productname" value="<?php echo $_REQUEST['productname'] ?>"  /> </form></td>
        
<br />
<br />
<br />
<?php echo  admin_footer(); ?>
</center>
</body>
</html>
