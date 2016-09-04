<?php
include("include/connect.php");
include("db/db.php");



$pro=mysql_query("delete FROM `cart` ;") or die(mysql_error());

//$pro=mysql_query("ALTER TABLE  `subcategory` CHANGE  `jatitle`  `seojatitle` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '47th DDC; Diamonds, Gemstones, Jewelry, Watches and Art.';") or die(mysql_error());
//$pro1=mysql_query("ALTER TABLE  `category` CHANGE  `jatitle`  `seojatitle` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '47th DDC; Diamonds, Gemstones, Jewelry, Watches and Art.';") or die(mysql_error());


/*$rs=mysql_query("select id,catname from category") or die(mysql_error());
$rf=0;
while($d=mysql_fetch_array($rs)){	
	$id=$d["id"];
	$catname=trim($d["catname"]);
	$eurl=makeUrl($catname);
	$rf+=rs_update("category","eurl='$eurl'","id='$id'");
}
echo "Category updated : $rf<br>";
$rssub=mysql_query("select id,subcat from subcategory") or die(mysql_error());
$rf=0;
while($dsub=mysql_fetch_array($rssub)){	
	$id=$dsub["id"];
	$subcat=trim($dsub["subcat"]);
	$eurl=makeUrl($subcat);
	$rf+=rs_update("subcategory","eurl='$eurl'","id='$id'");
}
echo "Sub Category updated : $rf<br>";
$rsproduct=mysql_query("select id,title from product") or die(mysql_error());
$rf=0;
while($drsproduct=mysql_fetch_array($rsproduct)){	
	$id=$drsproduct["id"];
	$title=trim($drsproduct["title"]);
	$eurl=makeUrl($title);
	$rf+=rs_update("product","eurl='$eurl'","id='$id'");
}
echo "Product updated : $rf<br>";*/
?>