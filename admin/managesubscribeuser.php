<?php
session_start();
include("page-add.php");
include("../include/connect.php");
include("../db/db.php");
if($_SESSION['AdminId']=="")
{
echo "<script>window.location.href='index.php';</script>";
}


$lquery=$_REQUEST["lquery"]==""?"": " and tl.CustName like '".$_REQUEST["lquery"]."%'";
 $sql="select tl.CustName,ts.* from tbl_subscription as ts,customer as tl where ts.email=tl.CustEmail  $lquery group by ts.email";
$numrows=mysql_num_rows(mysql_query($sql));
$rowsPerPage = 10;
$pageNum = 1;
if($_GET['page']!="")
	$pageNum = $_GET['page'];

$offset = ($pageNum - 1) * $rowsPerPage;
$pageFrom=$offset==0?"1":$offset+1;

$maxPage = ceil($numrows/$rowsPerPage);
$self = $_SERVER['PHP_SELF'].'?opt=pg';

$rs=mysql_query($sql." LIMIT $offset, $rowsPerPage")or die("mysql_error : ".mysql_error());
$rocordperpage=mysql_num_rows($rs);	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin:: 47th Diamond District Corp.</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript" src="../js/AjaxHandler.js"></script>
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
    <td><h1><font color="#6B6B6B">Manage Subscribe Users</font></h1></td>
    <td align="right"><a href="#"></a></td>
  </tr>
</table>
<form action="dbfunction.php" method="post" name="delteform" id="delteform" onsubmit="return checkBox();">
<table width="90%" border="0" cellpadding="3" cellspacing="1" class="text1">
  <tr class="text">
    <td height="33" align="center" valign="top" bgcolor="#FFFFFF">
	<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#3A1F08" class="text1">
	
     <tr class="text"><td colspan="7">
	 <?php
				$Alpha =array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
				for($i=0;$i<26;$i++){
					$sql_count="select count(DISTINCT ts.email ) as cnt from tbl_subscription as ts,customer as tl where ts.email=tl.CustEmail and tl.CustName like '".$Alpha[$i]."%' group by ts.email";
					$rs_count=mysql_query($sql_count) or die(mysql_error());
					$data_count=mysql_fetch_array($rs_count);
					//echo "<td nowrap>";
					if($data_count["cnt"]>0){
						echo '<a href="managesubscribeuser.php?lquery='.$Alpha[$i].'" class="blink2">'.strtoupper($Alpha[$i]).'('.$data_count["cnt"].')</a>,&nbsp;&nbsp;';
					}
					else{
						echo ''.strtoupper($Alpha[$i]).'(0),&nbsp;&nbsp;';
					}
					
				}
		?>	
	 </td></tr>
	 <tr class="text">
	<td height="33" align="left"><strong>S No. </strong></td>
    <td height="33" align="left"><strong>Name </strong></td>
    <td height="33" align="left"><strong>Email </strong></td>
    <td height="33" align="left"><strong>IP Address</strong></td>
	<td height="33" align="center"><strong>Mail Send</strong></td>
    <td width="80" height="33" align="center"><strong>Status</strong></td>
    <td align="center"><strong><input name="master" type="checkbox" value="11"  onClick="javascript: selectall();"></strong></td>
      </tr>
	   <? 
	if($numrows>0){
		$sno=1;
		 while($rsdata=mysql_fetch_array($rs)){
  ?>
      <tr>
    <td align="left" bgcolor="#FFFFFF"><?=$sno++?></td>
	<td align="left" bgcolor="#FFFFFF"><?=$rsdata['CustName']?></td>
    <td align="left" bgcolor="#FFFFFF"><?=$rsdata['email']?></td>
	<td align="left" bgcolor="#FFFFFF"><?=$rsdata['ipaddress']?></td>
    <td align="left" bgcolor="#FFFFFF"><?=$rsdata['send']?></td>
	<td align="center" bgcolor="#FFFFFF" id="status<?=$rsdata["id"]?>">
	<?php if($rsdata['sstatus']=='Y'){
		echo '<img src="images/publish.jpg" style="cursor:pointer;" title="Deactivate" alt="publish" width="15" height="16" border="0" onclick="getServerResponse(\'status'.$rsdata["id"].'\',\'AjaxHandler.php?query=mliststatus&id='.$rsdata["id"].'&status=N\',\'../\',false)" />';
		}
		else{
		echo '<img src="images/delete.jpg" style="cursor:pointer;" title="Activates" alt="in active" width="15" height="16" border="0" onclick="getServerResponse(\'status'.$rsdata["id"].'\',\'AjaxHandler.php?query=mliststatus&id='.$rsdata["id"].'&status=Y\',\'../\',false)" />';	
		}
	?>
</td>
      <td align="center" bgcolor="#FFFFFF">
	<input type="checkbox" name="box[]" id="box[]" value="<?=$rsdata['id'];?>" /></td>
  </tr>
      <?php $sno++;
	  }
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
        <br /></td>
  </tr>
</table>
 <?php if ($maxPage > 0){ ?>
<table width="90%" height="33" border="0" cellpadding="3" cellspacing="1">
  <tr>
    <td></td>
    <td align="right"><input type="image" src="images/publish.gif" alt="visibility" width="65" height="26" border="0" name="publishmlist" /></td>
    <td width="70" align="right"><input type="image" src="images/delete.gif" alt="delete" width="65" height="26" border="0" name="deltemlist" onclick="return confirm('Do you really want to delete this?'); return true" /></td>
  </tr>
</table>
<?php } ?>
</form>
<br />
<br />
<?php admin_footer(); ?>
</center>
</body>
</html>
