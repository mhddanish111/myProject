<?php
session_start();
include_once("../include/connect.php");
include_once("../db/db.php");

$Session_Id=session_id();

if(!isset($_SESSION["CustEmail"])){
	$_SESSION["errormsg"]="Please Login First";
	//header("location: index.php");
	echo "<script>window.location.href='index.html'</script>";
	exit;
}

//$invoice_id=$_GET['invoiceId'];
$message;
$invoice_id=$_REQUEST["invoiceId"];
$user_email;





$opt=$_GET['opt'];
$_SESSION["opt"]=$opt;
$_SESSION["orderid"]=$invoice_id;
$date = date("m/d/Y");
$date1 = date("m/d/Y");
if($opt=="success"){
	$sql="update `itemorder` set payment_staus='Success',paymentdate='".$date."' where order_number=".$invoice_id;
	//echo "<br>sql ".$sql;
	$rowAffected=mysql_query($sql) or die(mysql_query());
	$selcard = mysql_query("select * from cart where session_id ='".session_id()."'");
	$items='';
	$cnt=1;
	
	while($cardresult = mysql_fetch_assoc($selcard))
	{
	//$updateprodqty=mysql_query("update product set productstock=productstock-'".$cardresult['qty']."' where productid='".$cardresult['productid']."'");
	$updateprodqty=mysql_query("update product set soldproduct=soldproduct +'".$cardresult['qty']."' where productid='".$cardresult['productid']."'");
	$sqlupdatecoupon=mysql_query("update `sendcoupon` set flag='Y',usedate='".$date1."' where userid='".$_SESSION["CustEmail"]."'and couponid='".$_SESSION['couponid']."'");
}
		//mail format
			$sendto = $_SESSION["CustEmail"];

					$headers= "From:mkhisal@gmail.com\r\n";
					$headers.= 'Content-type: text/html; charset=UTF-8' . "\r\n";
					
					$from = "mkhisal@gmail.com";
					$mailsubject= "Order Confirmation - 47ddc.com";
					$message = 'Your order has been processed with Invoice No .'.$invoice_id.'<br>
								Please Login for view your order
								Admin
								47ddc.com';

			if(mail($sendto, $mailsubject, $message, $headers)){
				//echo "Mail send Successfully <br>Thanks For Your Interest";
				

		}
}
else if($opt=="cancel"){
	//$rowAffected=rs_delete("item_order_detail","order_number='".$invoice_id."'");
	//$rowAffected=rs_delete("itemorder","order_number='".$invoice_id."'");
	$sql=mysql_query("update `sendcoupon` set flag='N',usedate='' where couponid ='".$_SESSION['couponid']."' and userid='".$_SESSION["CustEmail"]."'");// update if coupon not use
}
$sel = mysql_query("delete from cart where session_id='".session_id()."'");

	header("Location: thanks.html?axid=47ddc");
	exit;

	//echo $message;

?>