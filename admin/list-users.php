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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin:: 47th Diamond District Corp.</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/validation.js"></script>
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
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
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <table width="320" border="0" cellpadding="6" cellspacing="0" bgcolor="#3A1F08" class="text">
    <tr>
      <td align="right">&nbsp;</td>
      <td width="220" align="left"><label></label></td>
    </tr>
    <tr>
      <td align="right">Keyword</td>
      <td width="200" align="left"><label>
        <input name="keywordsearch" id="keywordsearch" type="text" class="inp" value="<?php echo $_POST["keywordsearch"] ?>" size="35" />
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
  <br />
<br />
<table width="90%" height="33" border="0" cellpadding="6" cellspacing="0" class="text1">
  <tr>
    <td><h1><font color="#6B6B6B">List Users </font></h1></td>
    <td align="right"><a href="#"></a></td>
  </tr>
</table>
<form action="dbfunction.php" method="post" name="delteform" id="delteform" onsubmit="return checkBox();">
<table width="90%" border="0" cellpadding="3" cellspacing="1" bgcolor="#3A1F08" class="text1">
  <tr class="text">
    <td height="33" align="center"><span class="contact-name"><strong> Full Name</strong></span></td>
    <td align="center"><span class="contact-name"><strong>Email</strong></span></td>
    <td align="center"><span class="contact-name"><strong>Phone No </strong></span></td>
    <td width="80" align="center"><span class="contact-name1"><strong>Country</strong></span></td>
    <td align="center"><strong>IP Address </strong></td>
    <td align="center"><strong>User Type</strong></td>
    <td align="center"><input type="checkbox" name="master" onClick="seleciona()" /></td>
  </tr>
  <?php
if(isset($_REQUEST['keywordsearch']))
{
	$keywordsearch = $_REQUEST['keywordsearch'];
	$sql="select id,CustName,CustEmail,CustPhone,CustCountry,usertype,ipaddress from customer  where CustName like '%$keywordsearch%' order by id desc ";
	$numrows = mysql_num_rows(mysql_query($sql));
}
else
{
 	$sql="select id,CustName,CustEmail,CustPhone,CustCountry,usertype,ipaddress from customer order by id desc";
	$numrows = mysql_num_rows(mysql_query($sql));
}
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
	$sno=1;
	while($new_result = mysql_fetch_assoc($rs))
  	{
?>
  	<tr>
    <td align="center" bgcolor="#FFFFFF"><?php echo stripslashes($new_result['CustName']); ?></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo stripslashes($new_result['CustEmail']); ?></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo stripslashes($new_result['CustPhone']); ?></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo stripslashes($new_result['CustCountry']); ?></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo stripslashes($new_result['ipaddress']); ?></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo stripslashes($new_result['usertype']); ?></td>
    <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="box[]" id="checkbox" value="<?php echo $new_result['id']; ?>" /></td>
  </tr>
   <?php } 
	if($maxPage> 1)
	{
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
	echo '<tr><td align="center"  colspan="7" bgcolor="#FFFFFF" >No Record Found</td></tr>';						
}
?>
</table>
<br />
<table width="90%" height="33" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td></td>
    <td align="right">&nbsp;</td>
    <td width="68" align="right"><input type="image" src="images/delete.gif" alt="del" width="65" height="26" border="0" name="delteuserord" onclick="return confirm('Do you really want to delete this?'); return true"/></td>
  </tr>
</table>
<input type="hidden" name="page" value="<?php echo $pageNum; ?>"  />
</form>
<br />

<?php echo  admin_footer(); ?>
</center>
</body>
</html>
