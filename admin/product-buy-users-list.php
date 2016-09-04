<?php
session_start();
include("page-add.php");
include("../include/connect.php");
include("../db/db.php");
if($_SESSION['AdminId']=="")
{
echo "<script>window.location.href='index.php';</script>";
}
$productid=$_REQUEST['productid'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin:: 47th Diamond District Corp.</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/validation.js"></script>
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
    <?php echo admin_right_nav(); ?>

<br />
<table width="90%" height="33" border="0" cellpadding="6" cellspacing="0" class="text1">
  <tr>
    <td><h1><font color="#6B6B6B">Product Buy User List</font></h1></td>
    <td align="right"><a href="#"></a></td>
  </tr>
</table>
<table width="90%" border="0" cellpadding="3" cellspacing="1" bgcolor="#3A1F08" class="text1">
 <tr class="text">
    <td height="33" align="center"><span class="contact-name"><strong> Full Name</strong></span></td>
    <td align="center"><span class="contact-name"><strong>Email</strong></span></td>
    <td align="center"><span class="contact-name"><strong>Phone No </strong></span></td>
    <td width="80" align="center"><span class="contact-name1"><strong>Country</strong></span></td>
    <td align="center"><strong>User Type</strong></td>
    </tr>
  <?php

 	$sql="select order_number from item_order_detail where itemid='".$productid."'";
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
	$sno=1;
	while($new_result = mysql_fetch_assoc($rs))
  	{
	$selorder=mysql_query("select userid from itemorder where order_number='".$new_result['order_number']."'");
	$getorder=mysql_fetch_array($selorder);
	$seluser=mysql_query("select * from customer where id='".$getorder['userid']."'");
	$getuser=mysql_fetch_array($seluser);
?>
  <tr>
    <td align="center" bgcolor="#FFFFFF"><?php echo $getuser['CustName']; ?></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo $getuser['CustEmail']; ?></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo $getuser['CustPhone']; ?></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo $getuser['CustCountry']; ?></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo $getuser['usertype']; ?></td>
    </tr>
   <?php } 
	if($maxPage> 1)
	{
		echo '<tr><td align="center"  colspan="8" bgcolor="#FFFFFF">';
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
	echo '<tr><td align="center"  colspan="8" bgcolor="#FFFFFF" >No Record Found</td></tr>';						
}
?>
</table>

<br />

<br />
<br />
<?php echo  admin_footer(); ?>
</center>
</body>
</html>
