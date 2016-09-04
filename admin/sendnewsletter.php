<?php
session_start();
include("page-add.php");
include("../include/connect.php");
include("../db/db.php");
if($_SESSION['AdminId']=="")
{
echo "<script>window.location.href='index.php';</script>";
}
$scount=0;
$fcount=0;

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
<style>
.progress_wrapper {width:300px;border:1px solid #ccc;position:absolute;top:150px;left:50%;margin-left:-150px}
.progress {height:20px;background-color:#0000ff}
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
<table width="90%" height="33" border="0" cellpadding="6" cellspacing="0" class="text1">
  <tr>
    <td><h1><font color="#6B6B6B">News Letter Sending...  </font></h1></td>
    <td align="right"><a href="#"></a></td>
  </tr>
</table>
<form name="frm_opts1" method="post" action="sendnewsletter.php" onsubmit="return validateForm(this)">
<table width="90%" border="0" cellpadding="3" cellspacing="1" class="text1">
  <tr class="text">
    <td height="33" align="center" valign="top" bgcolor="#3A1F08">
	<?php
	$subject=$_REQUEST["subject"];
	$message=$_REQUEST["message"];
	$maillimit=$_REQUEST["maillimit"]==""?"":"limit 0,".$_REQUEST["maillimit"];
	$sendingoption=$_REQUEST["sendingoption"];
	$subscriberemail=$_REQUEST["subscriberemail"];
	
	if($sendingoption=="userwise"){
		$total_iterations=count($_POST['subscriberemail']);
		$mailsendcount=0;
		$percentage = 0;	//	the starting percentage
		$total_iterations = $total_iterations;	//	the number of iterations to perform
		$width_per_iteration = 300 / $total_iterations; // how many pixels should the progress div be increased per each iteration
		$width = $width_per_iteration;
		
		foreach($_POST['subscriberemail'] as $key=>$vals){	
			$sql="select tl.CustName,ts.* from tbl_subscription as ts,customer as tl where ts.email=tl.CustEmail and tl.CustEmail='".$vals."' group by ts.email";
			$rs=mysql_query($sql) or die(mysql_error());
			$d=mysql_fetch_array($rs);

			$width += $width_per_iteration;
			ob_flush();
			flush();
			
			$sendto =$vals;
			$from = "info@47ddc.com";
			$headers = "From: " .$from;
			$headers.= PHP_EOL;
			$headers.= "Reply-To: $from\n";
			$headers.= 'Content-type: text/html; charset=utf-8' . "\r\n";
			
			$subject = "Newsletter from 47th Diamond District Corp  ";
			
			$message = "Dear ".$d["CustName"]."<br>".$_REQUEST["message"]."	<br><br>";
						
						
			$message .= "This mail was sent because you have subscribed for 47th Diamond District Corp newsletter<br>
						<br>
						Thanks<br>
						Admin<br>
						47th Diamond District Corp <br><br>";
				
				$scolor="";
				echo '<div class="progress_wrapper" id="prodiv"><div class="progress" style="width:' . $width . 'px;"></div></div><br />';
	
				if(@mail($sendto, $subject, $message, $headers)){
					$mailsendcount++;
					$rowAffected=rs_update("tbl_subscription","send='1'","id='".$d["id"]."'");
					$scolor="#228b22";
					++$scount;
					$SS="success";
				}
				else{$scolor="#ff0000";	++$fcount;$SS="failed";}
				echo '<div style="background-color: #3A1F08;text-align:center;">'.$d["fname"].'&nbsp;'.$d["lname"].'&nbsp;('.$d["email"].')&nbsp;:&nbsp;
				<font color="'.$scolor.'">'.$SS.'</font>
			</div>';
			
			echo '<script language="javascript">document.getElementById("prodiv").style.display="none";</script>';
		}
		echo '<div style="background-color: #3A1F08;text-align:center;"><strong>Send Mail : '.$scount.'&nbsp;&nbsp;&nbsp; | Failed Mail : '.$fcount.'</strong></div>';
	}
	else{
		$sql="select tl.CustName,ts.* from tbl_subscription as ts,customer as tl where ts.email=tl.CustEmail and ts.send='0'  group by ts.email $maillimit";
		$rs=mysql_query($sql) or die(mysql_error());
		if(mysql_num_rows($rs)>0){
			$total_iterations=mysql_num_rows($rs);
			$mailsendcount=0;
			$percentage = 0;	//	the starting percentage
			$total_iterations = $total_iterations;	//	the number of iterations to perform
			$width_per_iteration = 300 / $total_iterations; // how many pixels should the progress div be increased per each iteration
			$width = $width_per_iteration;
			
			while($d=mysql_fetch_array($rs)){
			
			$width += $width_per_iteration;
			ob_flush();
			flush();
			
			$sendto =$d["email"];
			$from =  "info@47ddc.com";
			$headers = "From: " .$from;
			$headers.= PHP_EOL;
			$headers.= "Reply-To: $from\n";
			$headers.= 'Content-type: text/html; charset=utf-8' . "\r\n";
			
			$subject = "Newsletter from 47th Diamond District Corp  ";
			
			$message = "Dear ".$d["CustName"]."<br>".$_REQUEST["message"]."	<br><br>";
						
						
			$message .= "This mail was sent because you have subscribed for 47th Diamond District Corp newsletter<br>
						<br>
						Thanks<br>
						Admin<br>
						47th Diamond District Corp <br><br>";
				
				$scolor="";
				echo '<div class="progress_wrapper" id="prodiv"><div class="progress" style="width:' . $width . 'px;"></div></div><br />';
	
				if(@mail($sendto, $subject, $message, $headers)){
					$mailsendcount++;
					$rowAffected=rs_update("tbl_subscription","send='1'","id='".$d["id"]."'");
					$scolor="#228b22";
					++$scount;
					$SS="success";
				}
				else{$scolor="#ff0000";	++$fcount;$SS="failed";}
				echo '<div style="background-color: #3A1F08;text-align:center;">'.$d["fname"].'&nbsp;'.$d["lname"].'&nbsp;('.$d["email"].')&nbsp;:&nbsp;
				<font color="'.$scolor.'">'.$SS.'</font>
			</div>';
			}
			echo '<script language="javascript">document.getElementById("prodiv").style.display="none";</script>';
		}
		
		echo '<div style="background-color: #3A1F08;text-align:center;"><strong>Send Mail : '.$scount.'&nbsp;&nbsp;&nbsp; | Failed Mail : '.$fcount.'</strong></div>';
	}
	?>
	</td>
  </tr>
</table>

</form>
<br />
<br />
<?php admin_footer(); ?>
</center>
</body>
</html>
