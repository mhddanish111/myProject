<?php
session_start();
include("include/connect.php");
include("db/db.php");
$imagepath = "gallery/list/";
$responseText="";
$query=$_REQUEST["query"];
//$shipingcharge=10;
//echo $query;
if($query=="addtocart" || $query=="removefromcart" || $query=="updatecart" || $query=="viewcart" )
{
	if(!isset($_SESSION['orderid']))
	{
		$_SESSION['orderid'] = uniqid(DDC);
		//$ordid = mysql_query("select order_number from itemorder where order_number='".$_SESSION['orderid']."'"); 
	}
	$sql="";
	$rowAffected="0";
	$responseText="failure#@#";
	$product_id=$_REQUEST["product_id"];
	$product_qty=$_REQUEST["product_qty"];
	$shipingcharge =0;
	$abs = $_REQUEST['path'];
	if($query=="addtocart")
	{
		$selpro = mysql_query("select id,title,price from product where id ='$product_id'");
		$prores = mysql_fetch_assoc($selpro);
		$sql="insert into cart (productid,productname,price,qty,session_id) values('".$prores['id']."','".mysql_real_escape_string($prores['title'])."','".$prores['price']."','1','".session_id()."')";
		$rowAffected=mysql_query($sql) or die(mysql_error());
		if($rowAffected>0){
			$responseText='success#@#<img src="'.$abs.'images/added.gif" alt="added to cart">';
			$_SESSION["incart_".$product_id]="YES";
			if(isset($_SESSION["cart_item"]))
			{
				$_SESSION["cart_item"]=($_SESSION["cart_item"]+1);
			}
			else
			{
				$_SESSION["cart_item"]=1;
			}
		}
		else{
			$responseText="failure#@#";	
		}
			
	}
	else if($query=="removefromcart"){	
		$sql="delete from cart where productid='$product_id' and session_id='".session_id()."'";
		$rowAffected=mysql_query($sql) or die(mysql_error());
		if($rowAffected>0){
			$responseText='success#@#<img src="'.$abs.'images/add-cart.gif" alt="add to cart" style="cursor:pointer"  onClick="cartSetup(\''.$abs.'UserAjaxHandler.php?query=addtocart&product_id='.$product_id.'\',\'addtocart\',\''.$product_id.'\','.$abs.');">';
			$_SESSION["incart_".$product_id]="";
			unset($_SESSION["incart_".$product_id]);
			$_SESSION["cart_item"]=($_SESSION["cart_item"]-1);
		}
		else{
			$responseText="failure#@#";	
		}
		
	}	
	else if($query=="updatecart"){
		$cnt=$_REQUEST["count"]==""?0:$_REQUEST["count"];
		for($i=1;$i<=$cnt;$i++){
			$sql="update cart set qty='".$_REQUEST["product_qty_".$i]."' where productid='".$_REQUEST["product_id_".$i]."' and session_id='".session_id()."'";	
			$rowAffected=mysql_query($sql) or die(mysql_error());
		}
		if($rowAffected>0){
			$responseText="success#@#";
		}
		else{
			$responseText="failure#@#";	
		}
	}
	else if($query=="viewcart"){
		$responseText="success#@#";
	}
		
	//****************** designing cart formate *************
	$cart_div_content="#@#";
	if(isset($_SESSION["CustEmail"]))
	{
	$sql_cart="SELECT IF( sd.ShipCustCountry =  'U.S.A.', p.shipchargedom, p.shipchargeint ) AS ship, p.imagepath,crt.productname, crt.qty,crt.productid, crt.price FROM product AS p,shipbilldetail AS sd, cart AS crt WHERE p.id = crt.productid AND crt.session_id =  '".session_id()."' AND sd.userid =  '".$_SESSION["userid"]."'";}
	else
	{
		$sql_cart="SELECT  p.imagepath,crt.productname, crt.qty,crt.productid, crt.price FROM product AS p, cart AS crt WHERE p.id = crt.productid AND crt.session_id ='".session_id()."'";
	}
	$rs_cart=mysql_query($sql_cart) or die(mysql_error());
	
	if(mysql_num_rows($rs_cart)>0){
	$cart_div_content.='<form id="frm_cart" name="frm_cart">
<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="28" align="left" valign="top"><div class=myFloatBarhide id=\'hideCart\' name=\'hideCart\'>
        <a onclick="hideFloatCart()" style="cursor:hand;" ><img src="'.$abs.'images/hide-cart.png" /></a>
       </div></td>
    <td width="600" align="left" valign="top"><table width="578" border="0" cellpadding="0" cellspacing="1" bgcolor="#EE9A04" class="text">
      <tr>
        <td height="33"><table width="100%" border="0" cellpadding="5" cellspacing="0" class="text">
            <tr>
              <td><strong>Product</strong></td>
              <td width="80" align="center"><strong>Unit Price</strong></td>
              <td width="70" align="center"><strong>Qty</strong></td>
              <td width="60" align="center"><strong>Remove</strong></td>
              <td width="80" align="center"><strong>Total</strong></td>
            </tr>
        </table></td>
      </tr>';
	  $total=0;
			$cnt=0;
			$subtotal=0;
			$shipcharge =0;
			while($data_cart=mysql_fetch_array($rs_cart))
			{
				++$cnt;
				$quan=(int)$data_cart["qty"];
				$rate=$data_cart["price"];
				$total=$total+($quan*$rate);
				$subtotal = $subtotal+$total;
				$shipcharge = $shipcharge+($data_cart["ship"]*$quan);
				$cart_div_content.='<tr class="text1">
        <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="5" cellspacing="0" class="table">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="70" align="left"><img src="'.$abs.$imagepath.$data_cart["imagepath"].'" height="40" width="50"/></td>
                    <td align="left"><strong>47ddc - 00'. stripslashes($data_cart["productid"]).'</strong></td>
                  </tr>
              </table></td>
			  <td width="70" align="center">$'.$rate.'</td>
              <td width="80" align="center"><input type="text" name="product_qty_'.$cnt.'"  id="product_qty_'.$cnt.'" value="'.$quan.'" size=3 maxlength="3" onkeypress="return checkForInt(event);" ><input type="hidden" name="product_id_'.$cnt.'" id="product_id_'.$cnt.'" value="'.$data_cart["productid"].'"></td>
              <td width="60" align="center"><a onclick="cartSetup(\''.$abs.'UserAjaxHandler.php?query=removefromcart&product_id='.$data_cart["productid"].'\',\'removefromcart\',\''.$data_cart["productid"].'\',\''.$abs.'\');" style="cursor:pointer"><img src="'.$abs.'images/delete.png" alt="Remove" border="0" title="Remove" width="30" height="31" /></a></td>
              <td width="80" align="center">$'.$total.'</td>
            </tr>
        </table></td>
      </tr>';
	  $total=0;
	  }
		$_SESSION['shipcharge'] = $shipcharge;
		$_SESSION['subtotal'] = $subtotal;
	  $cart_div_content.='<input type="hidden" name="count" id="count" value="'.$cnt.'">';
			
			$cart_div_content.='
      <tr>
        <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td align="left">;<a href="'.$abs.'index.html"><img src="'.$abs.'images/continue-shopping1.gif" width="145" height="24" border="0" /></a></td>
              <td align="right"><img src="'.$abs.'images/update-cart.gif" width="98" height="24" border="0" onclick="cartSetup(\''.$abs.'UserAjaxHandler.php?query=updatecart\',\'updatecart\',\'\',\''.$abs.'\');" style="cursor:pointer" border="0" /></td>
            </tr>
          </table>
            <table width="100%" border="0" cellpadding="5" cellspacing="0" class="text2">
              <tr>
                <td align="right" valign="top">';if(!empty($_SESSION['shipcharge']))
				 $cart_div_content.='Shiping : <br />';//Shiping : <br />';
                  if($_SESSION["shipcountry"]=='U.S.A.' && $_SESSION["shipcity"]=="new york")
				{
						 $cart_div_content.='Tax: <br />';
				}//Tax: <br />
				  if($_SESSION['couponamount']!=0)
				$cart_div_content.='Discount : <br>';
                 $cart_div_content.='<strong><font color="#FF0000">Total Cost:</font></strong></td>
                <td width="80" align="center" valign="top">';if(!empty($_SESSION['shipcharge'])) $cart_div_content.='$'.$_SESSION['shipcharge'].'<br />';
				 if($_SESSION["shipcountry"]=='U.S.A.' && $_SESSION["shipcity"]=="new york")
				{
						$tax = number_format((($_SESSION['subtotal']*10)/100),2);
						$cart_div_content.='$'.$tax.'<br />';
						$_SESSION['tax'] = $tax;
				} 
				if($_SESSION['couponamount']!=0)
				$cart_div_content.='$'.$_SESSION['couponamount'].'<br>';
				$gtotal=0;
				$gtotal = $_SESSION['shipcharge']+$_SESSION['tax']+$_SESSION['subtotal']-$_SESSION['couponamount'];
				$cart_div_content.='<strong><font color="#FF0000">$'.$gtotal.'</font></strong></td>
              </tr>
            </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td align="left">&nbsp;</td>
                <td align="right">';
				if(isset($_SESSION["CustEmail"]))
			{
				$cart_div_content.='<a href="'.$abs.'billing-shiping-info.html"><img src="'.$abs.'images/proceed-checkout.gif" width="151" height="24" border="0" /></a>';
			}
				else
				{
					$cart_div_content.='<a href="'.$abs.'checkout.html"><img src="'.$abs.'images/proceed-checkout.gif" width="151" height="24" border="0" /></a>';
				}
				$cart_div_content.='</td>
              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>';
	}
	else{
		$cart_div_content.='empty';
		$_SESSION["cart_item"]=0;
	}
	//****************** end designing cart format ***************	
	echo $responseText.$cart_div_content.'#@#'.$_SESSION["cart_item"];
}
else if($_REQUEST["query"]=="checkloginid"){
	$sql="";
	if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_REQUEST["user_id"])){
		$responseText='success#@#<font color="#ff0000">Invalid Email</font>';
	}else{
		if($_REQUEST["old_user_id"]!="")
			$sql="select * from customer where user_id='".$_REQUEST["user_id"]."' and login_id!='".$_REQUEST["old_user_id"]."'";
		else
			$sql="select * from customer where user_id='".$_REQUEST["user_id"]."'";	
		$rs=mysql_query($sql) or die(mysql_error());
		if(mysql_num_rows($rs)>0){
			$responseText='success#@#<font color="#ff0000">Not Available</font>';
		}
		else{
			$responseText='success#@#<font color="#23b300">Available</font>';
		}
	}
	
	
	echo $responseText;
}
else if($_REQUEST["query"]=="resetlogindetial"){
	$user_id=$_REQUEST["user_id"];
	$oldpassword=$_REQUEST["oldpassword"];
	$password=$_REQUEST["password"];
	$first_name=$_REQUEST["first_name"];
	$last_name=$_REQUEST["last_name"];
	$responseText="success#@#";
	$rs=mysql_query("select * from customer where user_id='$user_id'");
	if($rsdata=mysql_fetch_array($rs)){
		$rs1=mysql_query("select * from customer where password='$oldpassword'");
		if($rsdata=mysql_fetch_array($rs1)){	
			$rowAffected=mysql_query("update customer set password='$password',first_name='$first_name',last_name='$last_name' where user_id='$user_id'");
			if($rowAffected>0){
				$responseText="success#@#Registeration Detail updated successfully";
			}else{$responseText="success#@#Registeration Detail Not Updated !";}	
		}else{ $responseText="success#@#Invalid Old Login Password";}
	}else{$responseText="success#@#Invalid Login Id Please Try Again";}
	
	echo $responseText;
}
else if($query=="removefromcart1"){
	$product_id=$_REQUEST["product_id"];	
		$sql="delete from cart where productid='$product_id' and session_id='".session_id()."'";
		$rowAffected=mysql_query($sql) or die(mysql_error());
		if($rowAffected>0){
			$_SESSION["incart_".$product_id]="";
			unset($_SESSION["incart_".$product_id]);
			$_SESSION["cart_item"]=($_SESSION["cart_item"]-1);
		}
		//header("location:view-cart.php");
		echo "<script>window.location.href='view-cart.html';</script>";
		exit();		
	}
else if(isset($_REQUEST['updateviewcart_x'])){
		$cnt=$_REQUEST["count"]==""?0:$_REQUEST["count"];
		for($i=1;$i<=$cnt;$i++){
			$sql="update cart set qty='".$_REQUEST["product_qty_".$i]."' where productid='".$_REQUEST["product_id_".$i]."' and session_id='".session_id()."'";	
			$rowAffected=mysql_query($sql) or die(mysql_error());
		}
		echo "<script>window.location.href='view-cart.html';</script>";
		exit();
		
	}
		
?>