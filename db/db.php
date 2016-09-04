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
function rs_delete($table,$cond)
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
			$first='<div class="port-links"><span>« previous</span></div>';
			// we're on page one, don't enable 'previous' link	
	}
	
	if($pagenum<$maxpage)
	{ // if page no is less then maximum page after the prevoius condition
		$page=$pagenum+1;  // add one in page
		$next ='<div class="port-links"><a href="'.$fnName.'&page='.$page.'">next »</a></div>'; //it should be linked
	}
	else
	{
		$next ='<div class="port-links"><span>next »</span></div>'; //not linked
	}
	
	$pagingstr="";
	//$startPos=1;
	$endPos=$disppage;//limit of page to be display in paging
	//$v3=$endPos; // how much page no u display

	//if($maxpage<$endPos)
		//$endPos=$maxpage;

	//if($page==$maxpage-1 && $page>$v3)
	//{// condition for the checking the page no == max page -1 and  page no greater then  show 										
										//page - 3 
		//$startPos=$maxpage-$v3;
		//$endPos=$maxpage;
	//}
	//else if($page==$maxpage  && $page>$v3)
	//{
		//$startPos=$maxpage-$v3;
		//$endPos=$page;
	//}
	//else if($page>$v3)
	//{
		//$startPos=$page-$v3;
		//$endPos=$page;
	//}
	$startPos=max($pagenum-intval($endPos/2), 1);
    $endPos=$startPos+$endPos-1;
/*for ($i = $start; $i <= $end && $i <= $maxpage; $i++){
            if($i==$current) {
                echo '<span>'.$i.'</span>&nbsp;';
            } else {
                echo '<a href="'.$thepage.'?page='.$i.$query.'" title="go to page '.$i.'">'.$i.'</a>&nbsp;';
            }
        }*/
	for($i=$startPos;$i<$endPos && $i <= $maxpage;$i++)
	{
		if($i==$pagenum)
		{
			$pagingstr .='<div class="port-links"><a href="#" id="port-links-active" >'.$i.'</a></div>';
		} 
		else 
		{
			$pagingstr .='<div class="port-links"><a href="'.$fnName.'&page='.$i.'">'.$i.'</a></div>';
		}
	}

	$pagingstr=$first.$pagingstr.$next;
	return $pagingstr;
}
function random_generator($digits){
srand ((double) microtime() * 10000000);
//Array of alphabets
$input = array ("A", "B", "C", "D", "E","F","G","H","I","J","K","L","M","N","O","P","Q",
"R","S","T","U","V","W","X","Y","Z");

$random_generator="";// Initialize the string to store random numbers
for($i=1;$i<$digits+1;$i++){ // Loop the number of times of required digits

if(rand(1,2) == 1){// to decide the digit should be numeric or alphabet
// Add one random alphabet 
$rand_index = array_rand($input);
$random_generator .=$input[$rand_index]; // One char is added

}else{

// Add one numeric digit between 1 and 10
$random_generator .=rand(1,10); // one number is added
} // end of if else

} // end of for loop 

return $random_generator;
}

function getDateDiff($sdate,$ldate){
	 $sdate_array=explode('/',$sdate);
	 $ldate_array=explode('/',$ldate);
	 $datediff=(gregoriantojd($ldate_array[1], $ldate_array[0], $ldate_array[2]) - gregoriantojd($sdate_array[1], $sdate_array[0], $sdate_array[2]));
	 return $datediff;
	 
	 /*$d1=mktime(0,0,0,$ldate_array[0],$ldate_array[1],$ldate_array[2]);
	 $d2=mktime(0,0,0,$sdate_array[0],$sdate_array[1],$sdate_array[2]);
	 $datediff=floor(($d1-$d2)/86400)
	 return $datediff;*/
}

// function for paging for getting search
function getPaginationForSearch($rowCount,$rowsperpage,$page,$fnName,$abpath,$disppage)
{
	$pagenum=$page;// what page number
	$pagingstr="";
	$maxpage=0;
	$y=0;
	if($rowCount != 0){
		$maxpage= ceil($rowCount/$rowsperpage);// count maximum page 
	}

	if($pagenum>1){
		$page=$pagenum-1;// decrese page no. the page no
		$first='<div class="port-links"><a onclick="setSearchPage(\''.$page.'\');" href="javascript:void(0);">« previous</a></div>';// for the back page
	}	 
	else{
		$first='<div class="port-links"><span>« previous</span></div>';
		// we're on page one, don't enable 'previous' link	
	}
	
	if($pagenum<$maxpage){ // if page no is less then maximum page after the prevoius condition
		$page=$pagenum+1;  // add one in page
		$next ='<div class="port-links"><a onclick="setSearchPage(\''.$page.'\');" href="javascript:void(0);">next »</a></div>'; //it should be linked
	}
	else{
		$next ='<div class="port-links"><span>next »</span></div>'; //not linked
	}
	
	$pagingstr="";
	//$startPos=1;
	$endPos=$disppage;//limit of page to be display in paging
	/*$v3=$endPos; // how much page no u display

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
		$endPos=$page;
	}*/
	
/*for ($i = $start; $i <= $end && $i <= $maxpage; $i++){
            if($i==$current) {
                echo '<span>'.$i.'</span>&nbsp;';
            } else {
                echo '<a href="'.$thepage.'?page='.$i.$query.'" title="go to page '.$i.'">'.$i.'</a>&nbsp;';
            }
        }*/
	/*for($i=$startPos;$i<=$endPos && $i <= $maxpage;$i++)
	{
		if($i==$pagenum)
		{
			$pagingstr .='<div class="port-links" id="port-links-active">'.$i.'</div>';
		} 
		else 
		{
			$pagingstr .='<div class="port-links"><a href="'.$fnName.'&page='.$i.'">'.$i.'</a></div>';
		}
	}*/
//echo "startPos : $startPos- endPos : $endPos";
$startPos=max($pagenum-intval($endPos/2), 1);
    $endPos=$startPos+$endPos-1;
	for($i=$startPos;$i<$endPos && $i <=$maxpage;$i++)
	{
		if($i==$pagenum)
		{
			$pagingstr .='<div class="port-links"><a href="#" id="port-links-active" >'.$i.'</a></div>';
		} 
		else 
		{
			$pagingstr .='<div class="port-links"><a onclick="setSearchPage(\''.$i.'\');" href="javascript:void(0);">'.$i.'</a></div>';
		}
	}

	$pagingstr=$first.$pagingstr.$next;
	return $pagingstr;
}
function makeUrl($urlStr)
{
	$newUrl="";
	$newUrl=trim($urlStr);
	$newUrl=str_replace(" ","-",$newUrl);
	$newUrl=str_replace("_","-",$newUrl);
	$newUrl=trim($newUrl);
	$newUrl= str_replace("__","-",$newUrl);
	$newUrl=trim($newUrl);
	$newUrl=preg_replace('/[^a-zA-Z0-9\-_]/',"",$newUrl);
	$newUrl=trim($newUrl);
	$newUrl= str_replace("--","-",$newUrl);
	return $newUrl;

}
//pagination for url rewriteing
function getPaginationURR($rowCount,$rowsperpage,$page,$fnName,$spliter,$ext,$disppage)
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
//    if($y != 0){
//        $maxpage = $maxpage+1;
//    }

    if($pagenum>1)
    { // if page greater page then one
        $page=$pagenum-1;// decrese page no. the page no
        $first='<div class="port-links"><a href="'.$fnName.''.$spliter.''.$page.'.'.$ext.'">« previous</a></div>';// for the back page
    }     
    else
    {
            $first='<div class="port-links"><a href="#">« previous</a></div>';
            // we're on page one, don't enable 'previous' link    
    }
    
    if($pagenum<$maxpage)
    { // if page no is less then maximum page after the prevoius condition
        $page=$pagenum+1;  // add one in page
        $next ='<div class="port-links"><a href="'.$fnName.''.$spliter.''.$page.'.'.$ext.'">next »</a></div>'; //it should be linked
    }
    else
    {
        $next ='<div class="port-links"><a href="#" >next »</a></div>'; //not linked
    }
    
    $pagingstr="";
    $startPos=1;
    $endPos=$disppage;//limit of page to be display in paging
    /*$v3=$endPos; // how much page no u display

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
*/
    $startPos=max($pagenum-intval($endPos/2), 1);
    $endPos=$startPos+$endPos-1;
	for($i=$startPos;$i<$endPos && $i <=$maxpage;$i++)
	{
        if($i==$pagenum)
        {
            $pagingstr .='<div class="port-links"><a href="#" id="port-links-active">'.$i.'</a></div>';
        } 
        else 
        {
            $pagingstr .='<div class="port-links"><a href="'.$fnName.''.$spliter.''.$page.'.'.$ext.'">'.$i.'</a></div>';
        }
    }

    $pagingstr=$first.$pagingstr.$next;
    return $pagingstr;
}
?>
