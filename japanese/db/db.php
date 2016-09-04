<?php

function rs_insert($table,$field,$values)
{
	$query="insert into $table($field) values($values)";
	$query=mysql_query($query) or die(mysql_error());
	return $query;
}
function rs_update($table,$value,$cond)
{
	$query="update $table set $value where $cond";
	$query=mysql_query($query) or die(mysql_error());
	return $query;
}
function rs_del($table,$cond)
{
	$query="delete from $table where $cond";
	$query=mysql_query($query) or die(mysql_error());
	return $query;
}
function rs_select($table,$col)
{
  $sel = "select $col from $table";
  $query=mysql_query($sel) or die(mysql_error());
	return $query;
}
function rs_select_con($table,$con)
{
  	$sel = "select * from $table where $con";
  	$query=mysql_query($sel) or die(mysql_error());
	return $query;
}
function resize_actual($filename, $savepath, $width,$height){
	//echo $filename."<br>".$savepath;
	$is_uploaded=false;

    list($width_orig, $height_orig, $type) = getimagesize($filename);
    $image_p = imagecreatetruecolor($width, $height);
    if($type==2)
    {
        $image = imagecreatefromjpeg($filename);
        $is_uploaded=imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
        imagejpeg($image_p, $savepath , 100);
    }
    elseif($type==3)
    {
        $image = imagecreatefrompng($filename);
        $is_uploaded=imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
       imagepng($image_p, $savepath , 100);
    }
    elseif($type==1)
    {
        $image = imagecreatefromgif($filename);
        $is_uploaded=imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
        imagegif($image_p, $savepath , 100);
    }
    elseif($type)
    {
        $image = imagecreatefromjpeg($filename);
      $is_uploaded= imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
       imagejpeg($image_p, $savepath , 100);
    }

	return $is_uploaded;
}
function isFound($TableName,$ColumnName,$ColumnValue){
	$flag=true;
	$sql="select $ColumnName from $TableName where $ColumnName='$ColumnValue'";
	$rs=mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($rs)>0)
		$flag=true;
	else
		$flag=false;
	
	return $flag;	
}
function isFoundMore($TableName,$condition){
	$flag=true;
	$sql="select * from $TableName where $condition";
	$rs=mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($rs)>0)
		$flag=true;
	else
		$flag=false;
	
	return $flag;	
}
function getPagination($rowCount,$rowsperpage,$page,$fnName,$abpath,$disppage)
{
	$pagenum=$page;// what page number
	$pagingstr="";
	//int offset=(int)((pagenum-1)* rowsperpage);
	$maxpage=0;
	$y=0;
	if($rowCount != 0)
	{
		$maxpage= ceil($rowCount/$rowsperpage);// count maximum page 

		//$y = ceil($rowCount % $rowsperpage);
	}
//	if($y != 0){
//		$maxpage = $maxpage+1;
//	}

	if($pagenum>1)
	{ // if page greater page then one
		$page=$pagenum-1;// decrese page no. the page no
		$first='<div class="port-links"><a href="'.$fnName.'&page='.$page.'">« previous</a></div>';// for the back page
	}	 
	else
	{
			$first='<div class="port-links"><a href="#">« previous</a></div>';
			// we're on page one, don't enable 'previous' link	
	}
	
	if($pagenum<$maxpage)
	{ // if page no is less then maximum page after the prevoius condition
		$page=$pagenum+1;  // add one in page
		$next ='<div class="port-links"><a href="'.$fnName.'&page='.$page.'">next »</a></div>'; //it should be linked
	}
	else
	{
		$next ='<div class="port-links"><a href="#" >next »</a></div>'; //not linked
	}
	
	$pagingstr="";
	$startPos=1;
	$endPos=$disppage;//limit of page to be display in paging
	$v3=$endPos; // how much page no u display

	if($maxpage<$endPos)
		$endPos=$maxpage;

	if($page==$maxpage-1 && $page>$v3)
	{// condition for the checking the page no == max page -1 and  page no greater then  show 										
										//page - 3 
		$startPos=$maxpage-$v3;
		$endPos=$maxpage;
	}
	else if($page==$maxpage  && $page>$v3)
	{
		$startPos=$maxpage-$v3;
		$endPos=$page;
	}
	else if($page>$v3)
	{
		$startPos=$page-$v3;
		$endPos=$page+2;
	}

	for($i=$startPos;$i<=$endPos;$i++)
	{
		if($i==$pagenum)
		{
			$pagingstr .='<div class="port-links" id="port-links-active">'.$i.'</div>';
		} 
		else 
		{
			$pagingstr .='<div class="port-links"><a href="'.$fnName.'&page='.$i.'">'.$i.'</a></div>';
		}
	}

	$pagingstr=$first.$pagingstr.$next;
	return $pagingstr;
}
?>
