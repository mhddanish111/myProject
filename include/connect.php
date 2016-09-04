<?php 
//$con = mysql_connect("localhost","root","");
//$db=mysql_select_db("diamond",$con);
//$con = mysql_connect("ddcorp.db.5334548.hostedresource.com","ddcorp","Corp_0047");
//$db=mysql_select_db("ddcorp",$con);
//$con = mysql_connect("localhost","fousevdd_KHisal","Kedddc@08_KD");
//$db=mysql_select_db("fousevdd_47ddc",$con);

$host="localhost";
$user="root";
$password="";
$dbName="fousevdd_47ddc";

$dbh=mysql_connect($host,$user,$password)
       or die ("I cannot connect to the database.");
	   
	 if(!$dbh)
{
	echo "OOPs! Error Occured".mysql_errno();
	die();
}
mysql_select_db($dbName,$dbh);
?>