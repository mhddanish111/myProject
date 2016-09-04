<?php
session_start();
if($_SESSION['AdminId']=="")
{
	echo "<script>window.location.href='index.php';</script>";
}
@ini_set("max_execution_time", "500");
@ini_set("post_max_size"," 100M");
@ini_set("upload_max_filesize","100M");
include("../db/db.php");
include("../db/constants-defined.php");
include("../include/connect.php");
$user_id = $_SESSION['AdminId'];
$MAX_IMAGE_FILE=5;

$imagepath = "../gallery/large/";
$imagelist = "../gallery/list/";
$date = date("m-d-Y");
#************** Add new Category ****************#
/////////////////////////////////////// Add New Category ///////////////////////
if(isset($_REQUEST['catadd_x']))
{
	$eurl=makeUrl(trim($_REQUEST['textfield22']));
	
	$catname = mysql_real_escape_string(trim($_REQUEST['textfield22']));
	$ja_catname = mysql_real_escape_string(trim($_REQUEST['jatextfield22']));
	$title = mysql_real_escape_string(trim($_REQUEST['title']));
	$keywords = mysql_real_escape_string(trim($_REQUEST['keywords']));
	$seodescription = mysql_real_escape_string(trim($_REQUEST['seodescription']));
	$jatitle = mysql_real_escape_string(trim($_REQUEST['jatitle']));
	$jakeywords = mysql_real_escape_string(trim($_REQUEST['jakeywords']));
	$jaseodescription = mysql_real_escape_string(trim($_REQUEST['jaseodescription']));
	$status	= $_REQUEST['checkbox']!=""?"Y":"N";
	
	$flag = isFound("category","eurl",$eurl);
	//$flag1 = isFound("category","ja_catname",$ja_catname);
	if($flag)
	{
		$_SESSION["msg"]="Product Category Already Exits";	
	}
	else
	{
		$rowAffected=rs_insert("category","catname,status,ja_catname,seotitle,keyword,seodescription,seojatitle,jakeyword,jaseodescription,eurl","'$catname','$status','$ja_catname','$title','$keywords','$seodescription','$jatitle','$jakeywords','$jaseodescription','$eurl'");
		if(mysql_affected_rows()>0)
			$_SESSION["msg"]="Product Category Added Successfully";
		else
			$_SESSION["msg"]="Product Category not Added Successfully";
	}
	//header("Location:add-category.php");
	echo"<script>window.location.href='add-category.php';</script>";	
	exit();
}

else if($_REQUEST['catedit_x'])
{
	$page = $_REQUEST['page'];
	$eurl=makeUrl(trim($_REQUEST['textfield22']));
	$catname = mysql_real_escape_string(trim($_REQUEST['textfield22']));
	$ja_catname = mysql_real_escape_string(trim($_REQUEST['jatextfield22']));
	$status	= $_REQUEST['checkbox']!=""?"Y":"N";
	$title = mysql_real_escape_string(trim($_REQUEST['title']));
	$keywords = mysql_real_escape_string(trim($_REQUEST['keywords']));
	$seodescription = mysql_real_escape_string(trim($_REQUEST['seodescription']));
	$jatitle = mysql_real_escape_string(trim($_REQUEST['jatitle']));
	$jakeywords = mysql_real_escape_string(trim($_REQUEST['jakeywords']));
	$jaseodescription = mysql_real_escape_string(trim($_REQUEST['jaseodescription']));
	$status	= $_REQUEST['checkbox']!=""?"Y":"N";
	$id = $_REQUEST['id'];
	$flag = isFound("category","eurl",$eurl);
	//$flag1 = isFound("category","ja_catname",$ja_catname);
	if($flag)
	{
		$rowAffected=rs_update("category","status='$status',seotitle='$title',keyword='$keywords',seodescription='$seodescription',seojatitle='$jatitle',jakeyword='$jakeywords',jaseodescription='$jaseodescription'","id = '$id'");
		if(mysql_affected_rows()>0)
			$_SESSION["msg"]="Product Category Content Updated Successfully";
		else
			$_SESSION["msg"]="Product Category Content not Updated Successfully";	
	}
	else
	{
		$rowAffected=rs_update("category","catname='$catname',ja_catname='$ja_catname',eurl='$eurl',status='$status',seotitle='$title',keyword='$keywords',seodescription='$seodescription',seojatitle='$jatitle',jakeyword='$jakeywords',jaseodescription='$jaseodescription'","id = '$id'");
		if(mysql_affected_rows()>0)
			$_SESSION["msg"]="Product Category Content with name Updated Successfully";
		else
			$_SESSION["msg"]="Product Category Content with name not Updated Successfully";	
	}
		//header("Location:list-category.php?page=".$page);	
	echo"<script>window.location.href='list-category.php?page=".$page."';</script>";
	//exit;
	exit();
}
	
#**************************************************#
#******************* Update catProduct Status(Active) **********
else if(isset($_REQUEST['publishcat_x']))
{
	$chk = $_POST['box'];
	if(!empty($chk))
	{
		for($i=0;$i<sizeof($chk); $i++)
		{
			$del_id = $chk[$i];
			$result = rs_select("category where id = '$del_id'", "status");
			while($updateresult= mysql_fetch_assoc($result))
			{
				if($updateresult['status']=="N")
					$rowAffected=mysql_query("update category SET status = 'Y' where id = '$del_id'") or die(mysql_error());
				else
					$rowAffected=mysql_query("update category SET status = 'N' where id = '$del_id'") or die(mysql_error());
			}
			if(mysql_affected_rows()>0)
				$_SESSION["msg"]="Product Category Status Update Successfully";
			else
				$_SESSION["msg"]="Product Category Status not Update  Successfully";		
		}
	}
	else
	{
		$_SESSION['msg'] = "Tick any Checkbox";
		
	}
	//header("Location:list-category.php");	
	echo"<script>window.location.href='list-category.php';</script>";
	exit();	
}
#------------------------------------------------------------------------------------------------------------------------------#
#******************** Delete the Category *******************************
else if(isset($_REQUEST['deltecat_x']))
{
	$chk = $_POST['box'];
	if(!empty($chk))
	{
		for($i=0;$i<sizeof($chk); $i++)
		{
			$del_id = $chk[$i];
			$delqr=rs_del("category","id='".$del_id."'");
			if($delqr)
				$_SESSION['msg'] = "Category Deleted Successfully";
			else
				$_SESSION['msg'] = "Category not Deleted  Sucessfully";
		}
	}
	else
		$_SESSION['msg'] = "Tick any Checkbox";
	//header("Location:list-category.php");	
	echo"<script>window.location.href='list-category.php';</script>";
	exit();
}
#************** Add new Coupans ****************#
/////////////////////////////////////// Add New Coupans ///////////////////////
if(isset($_REQUEST['addcoupon_x']))
{
	$name = mysql_real_escape_string(trim($_REQUEST['textfield22']));
	$couponid = mysql_real_escape_string(trim($_REQUEST['couponcode']));
	$message = mysql_real_escape_string(trim($_REQUEST['message']));
	$amount = mysql_real_escape_string(trim($_REQUEST['amount']));
	$status	= $_REQUEST['checkbox']!=""?"Y":"N";
	
	$flag = isFound("coupons","name",$name);
	if($flag)
	{
		$_SESSION["msg"]="Coupan name Already Exits";	
	}
	else
	{
		$rowAffected=rs_insert("coupons","name,couponid,status,amount,message","'$name','$couponid','$status','$amount','$message'");
		if(mysql_affected_rows()>0)
		{
			$_SESSION["msg"]="Coupan Added Successfully";
		}
		else
		{
			$_SESSION["msg"]="Coupan not Added Successfully";
		}
	}
	echo"<script>window.location.href='add-coupon.php';</script>";
	//header("Location:add-coupon.php");	
	exit();
}

else if($_REQUEST['editcoupon_x'])
{
	$page = $_REQUEST['page'];
	$couponid = mysql_real_escape_string(trim($_REQUEST['couponcode']));
	$name = mysql_real_escape_string(trim($_REQUEST['textfield22']));
	$message = mysql_real_escape_string(trim($_REQUEST['message']));
	$amount = mysql_real_escape_string(trim($_REQUEST['amount']));
	$status	= $_REQUEST['checkbox']!=""?"Y":"N";
	$id = $_REQUEST['id'];
	$flag = isFound("coupons","name",$catname);
	if($flag)
	{
		$rowAffected=rs_update("coupons","couponid='$couponid',status='$status',message='$message',amount='$amount'","id = '$id'");
		if(mysql_affected_rows()>0)
		{
			$_SESSION["msg"]="Coupan Updated Successfully";
		}
		else
		{
			$_SESSION["msg"]="Coupon not Updated Successfully";
		}	
	}
	else 
	{
		$rowAffected=rs_update("coupons","couponid='$couponid',status='$status',name='$name',message='$message',amount='$amount'","id = '$id'");
		if(mysql_affected_rows()>0)
		{
			$_SESSION["msg"]="Coupon Updated Successfully";
		}
		else
		{
			$_SESSION["msg"]="Coupon not Updated Successfully";
		}		
	}
	//header("Location:list-coupon.php?page=".$page);	
	echo"<script>window.location.href='list-coupon.php?page=".$page."';</script>";
	exit();
}
	
#**************************************************#
#******************* Update catProduct Status(Active) **********
else if(isset($_REQUEST['publishcoupon_x']))
{
	$chk = $_POST['box'];
	if(!empty($chk))
	{
		for($i=0;$i<sizeof($chk); $i++)
		{
			$del_id = $chk[$i];
			$result = rs_select("coupons where id = '$del_id'", "status");
			while($updateresult= mysql_fetch_assoc($result))
			{
				if($updateresult['status']=="N")
					$rowAffected=mysql_query("update coupons SET status = 'Y' where id = '$del_id'") or die(mysql_error());
				else
					$rowAffected=mysql_query("update coupons SET status = 'N' where id = '$del_id'") or die(mysql_error());
			}
			if(mysql_affected_rows()>0)
				$_SESSION["msg"]="Coupons Status Update Successfully";
			else
				$_SESSION["msg"]="Coupons Status not Update  Successfully";		
		}
	}
	else
	{
		$_SESSION['msg'] = "Tick any Checkbox";
		
	}
	//header("Location:list-coupon.php");	
	//exit;
	echo"<script>window.location.href='list-coupon.php';</script>";
	exit();	
}
#------------------------------------------------------------------------------------------------------------------------------#
#******************** Delete the Category *******************************
else if(isset($_REQUEST['deltecoupon_x']))
{
	$chk = $_POST['box'];
	if(!empty($chk))
	{
		for($i=0;$i<sizeof($chk); $i++)
		{
			$del_id = $chk[$i];
			$delqr=rs_del("coupons","id='".$del_id."'");
			if($delqr)
				$_SESSION['msg'] = "Coupons Deleted Successfully";
			else
				$_SESSION['msg'] = "Coupons not Deleted  Sucessfully";
		}
	}
	else
	{
		$_SESSION['msg'] = "Tick any Checkbox";
		
	}
	//header("Location:list-coupon.php");	
	//exit;
	echo"<script>window.location.href='list-coupon.php';</script>";
	exit();
}
else if(isset($_REQUEST['deltesendingCoupon_x']))
{
 	$chk = $_POST['box'];
	if(!empty($chk))
	{
		for($i=0;$i<sizeof($chk); $i++)
		{
			$del_id = $chk[$i];
			$delqr=rs_del("sendcoupon","id='".$del_id."'");
			if($delqr)
				$_SESSION['msg'] = "Send Coupon  Deleted Successfully";
			else
				$_SESSION['msg'] = "Send Coupon not Deleted  Sucessfully";
		}
	}
	else
	{
		$_SESSION['msg'] = "Tick any Checkbox";
		
	}
	//header("Location:sendcouponlist.php");
	//exit;
	echo"<script>window.location.href='sendcouponlist.php';</script>";
	exit();
}
#////////////////// Add SubCategory in the database ///////////////////

else if (isset($_REQUEST['addsubcat_x']))
{
	$catid = $_REQUEST['selectcat'];
	$eurl=makeUrl(trim($_REQUEST['textfield22']));
	
	$subcat = mysql_real_escape_string(trim($_REQUEST['textfield22']));
	$jasubcat = mysql_real_escape_string(trim($_REQUEST['jatextfield22']));
	$status	= $_REQUEST['checkbox']!=""?"Y":"N";
	$title = mysql_real_escape_string(trim($_REQUEST['title']));
	$keywords = mysql_real_escape_string(trim($_REQUEST['keywords']));
	$seodescription = mysql_real_escape_string(trim($_REQUEST['seodescription']));
	$jatitle = mysql_real_escape_string(trim($_REQUEST['jatitle']));
	$jakeywords = mysql_real_escape_string(trim($_REQUEST['jakeywords']));
	$jaseodescription = mysql_real_escape_string(trim($_REQUEST['jaseodescription']));
	$flag = isFoundMore("subcategory","catid='$catid' and eurl='$eurl'");
	//$flag1 = isFoundMore("subcategory","catid='$catid' and ja_subcat='$jasubcat'");
	if($flag)
	{
		$_SESSION["msg"]="Product Sub Category Already Exits";
		//header("Location:add-subcategory.php");
		//exit;	
	}
	else 
	{
		$img = $_FILES['subimage']['name'];
		if (($_FILES['subimage']['type'] == 'image/gif')
		|| ($_FILES['subimage']['type'] == 'image/jpeg')
		|| ($_FILES['subimage']['type'] == 'image/png')
		|| ($_FILES['subimage']['type'] == 'image/pjpeg')
		&& ($_FILES['subimage']['size'] / 1024 < 2000))
		{
			$img_name=time(). $_FILES['subimage']['name'];
			if(move_uploaded_file($_FILES['subimage']['tmp_name'],$imagepath.$img_name))
			{
				$flag = resize_actual($imagepath.$img_name, $imagelist.$img_name, 200,179);
				$rowAffected=rs_insert("subcategory","catid,subcat,ja_subcat,status,imagepath,keyword,seodescription,seotitle,jakeyword,jaseodescription,seojatitle,eurl","'$catid','$subcat','$jasubcat','$status','$img_name','$keywords','$seodescription','$title','$jakeywords','$jaseodescription','$jatitle','$eurl'");
				if(mysql_affected_rows()>0)
					$_SESSION["msg"]="Product Sub Category Added Successfully";
					//header("Location:add-subcategory.php");	
					//exit;
				else
					$_SESSION["msg"]="Product Sub Category not Added Successfully";
					//header("Location:add-subcategory.php");		
					//exit;
			}
			else
				$_SESSION["msg"]="Product Sub Category Image not uploaded Successfully";
				//header("Location:add-subcategory.php");		
				//exit;
		}
		else
			$_SESSION["msg"]="Image Size/Format Excecption";
			//header("Location:add-subcategory.php");
			//exit;
	}
	echo"<script>window.location.href='add-subcategory.php';</script>";
	exit();
}
#**************************************************#
#******************* Update Sub Category Status(Active) **********
else if(isset($_REQUEST['publishsubsubcat_x']))
{
	$chk = $_POST['box'];
	if(!empty($chk))
	{
		for($i=0;$i<sizeof($chk); $i++)
		{
			$del_id = $chk[$i];
			$result = rs_select("subcategory where id = '$del_id'", "status");
			while($updateresult= mysql_fetch_assoc($result))
			{
				if($updateresult['status']=="N")
					$rowAffected=mysql_query("update subcategory SET status = 'Y' where id = '$del_id'") or die(mysql_error());
				else
					$rowAffected=mysql_query("update subcategory SET status = 'N' where id = '$del_id'") or die(mysql_error());
			}
			if(mysql_affected_rows()>0)
				$_SESSION["msg"]="Product Sub Category Status Update Successfully";
			else
				$_SESSION["msg"]="Product Sub Category Status not Update  Successfully";		
		}
	}
	else
	{
		$_SESSION['msg'] = "Tick any Checkbox";
		
	}
	//header("Location:list-subcategory.php");	
	//exit;	
	echo"<script>window.location.href='view-list-subategory.php?catname=".$_REQUEST['catname']."';</script>";
	exit();
}
#------------------------------------------------------------------------------------------------------------------------------#
#******************** Delete the Category *******************************
else if(isset($_REQUEST['deltesubsubcat_x']))
{
	$chk = $_POST['box'];
	if(!empty($chk))
	{
		for($i=0;$i<sizeof($chk); $i++)
		{
			$del_id = $chk[$i];
			$res = rs_select_con("subcategory","id='".$del_id."'");
			$imgdata = mysql_fetch_assoc($res);
			if(unlink($imagepath.$imgdata['imagepath']))
			{
				@unlink($imagelist.$imgdata['imagepath']);
				$delqr=rs_del("subcategory","id='".$del_id."'");
				if($delqr)
				{
					$_SESSION['msg'] = "Product Category Deleted Successfully";
				}
				else
				{
					$_SESSION['msg'] = "Product Category not Deleted  Sucessfully";
				}
			}
		}
	}
	else
	{
		$_SESSION['msg'] = "Tick any Checkbox";
		
	}
	//header("Location:list-subcategory.php");	
	//exit;
	echo"<script>window.location.href='view-list-subategory.php?catname=".$_REQUEST['catname']."';</script>";
	exit();
}

#////////////////// Edit SubCategory ///////////////////
else if(isset($_REQUEST['editsubcat_x']))
{
 	$editid = $_REQUEST['editid'];
	$page = $_REQUEST['page'];
	$catid = $_REQUEST['selectcat'];
	//$catname = $_REQUEST['catname'];
	$catname = $catid;
	$eurl=makeUrl(trim($_REQUEST['textfield22']));
	
	$subcat = mysql_real_escape_string(trim($_REQUEST['textfield22']));
	$jasubcat = mysql_real_escape_string(trim($_REQUEST['jatextfield22']));
	$title = mysql_real_escape_string(trim($_REQUEST['title']));
	$keywords = mysql_real_escape_string(trim($_REQUEST['keywords']));
	$seodescription = mysql_real_escape_string(trim($_REQUEST['seodescription']));
	$jatitle = mysql_real_escape_string(trim($_REQUEST['jatitle']));
	$jakeywords = mysql_real_escape_string(trim($_REQUEST['jakeywords']));
	$jaseodescription = mysql_real_escape_string(trim($_REQUEST['jaseodescription']));
	$status	= $_REQUEST['checkbox']!=""?"Y":"N";
	$flag = isFoundMore("subcategory","catid='$catid' and eurl='$eurl'");
	//$flag1 = isFoundMore("subcategory","catid='$catid' and ja_subcat='$jasubcat'");
	$oldimagepath = $_REQUEST['oldimagepath'];
	if($_FILES['subimage']['name'])
	{
		if (($_FILES['subimage']['type'] == 'image/gif')
		|| ($_FILES['subimage']['type'] == 'image/jpeg')
		|| ($_FILES['subimage']['type'] == 'image/png')
		|| ($_FILES['subimage']['type'] == 'image/pjpeg')
		&& ($_FILES['subimage']['size'] / 1024 < 2000))
		{
			@unlink($imagepath.$oldimagepath);
			@unlink($imagelist.$oldimagepath);
			$oldimagepath=time(). $_FILES['subimage']['name'];
			if(move_uploaded_file($_FILES['subimage']['tmp_name'],$imagepath.$oldimagepath))
			{
				$flag = resize_actual($imagepath.$oldimagepath, $imagelist.$oldimagepath, 200,179);
				$_SESSION["msg"]="Product Sub Category Image uploaded Successfully";
			}
			else
			{
					$_SESSION["msg"]="Product Sub Category Image not uploaded Successfully";
					echo"<script>window.location.href='edit-subcategory.php?editid=".$editid."&page=".$page."';</script>";
					exit();
			}
		}
		else
		{
			$_SESSION["msg"]="Image Size/Format Excecption";
			echo"<script>window.location.href='edit-subcategory.php?editid=".$editid."&page=".$page."';</script>";
				exit();			
		}
	}
	if($flag)
	{
		$rowAffected=rs_update("subcategory","seotitle='$title',ja_subcat='$jasubcat',keyword='$keywords',seodescription='$seodescription',seojatitle='$jatitle',jakeyword='$jakeywords',jaseodescription='$jaseodescription',status='$status',imagepath='$oldimagepath'","id='$editid'");
	if(mysql_affected_rows()>0)
		$_SESSION["msg"]="Product Sub Category Content Update Successfully";
	else
		$_SESSION["msg"]="Product Sub Category  Content  not Update Successfully";
	}
	else 
	{
		$rowAffected=rs_update("subcategory","catid='$catid',subcat='$subcat',ja_subcat='$jasubcat',eurl='$eurl',seotitle='$title', keyword='$keywords', seodescription='$seodescription', seojatitle='$jatitle',jakeyword='$jakeywords',jaseodescription='$jaseodescription',status='$status',imagepath='$oldimagepath'","id='$editid'");
		if(mysql_affected_rows()>0)
			$_SESSION["msg"]="Product Sub Category Content Update with name Successfully";
		else
			$_SESSION["msg"]="Product Sub Category  Content  not Update with name Successfully";
	}
	header("Location:view-list-subategory.php?catname=".$catname);	
	exit;
}

###########################################################################################################################



#*********************** ADD Home Description ************
else if(isset($_REQUEST['homesubmit_x']))
{
	$contact_us = mysql_real_escape_string(trim($_REQUEST['contact_us']));
	$contact_usr = mysql_real_escape_string(trim($_REQUEST['contact_usr']));
	$id=$_REQUEST['id'];
	$contactid = $_REQUEST['contactid'];
	$rowAffected = mysql_query("update cmscontent set content = '$contact_us',jacontent = '$contact_usr' where id = '".$id."'");// update
	if(mysql_affected_rows()>0)
	 	$_SESSION["msg"] ="Content Updated Successfully";
	else
		$_SESSION["msg"] ="Content Not Updated Successfully";
	
	//header("Location: cms.php?id=$id");	
	//exit;
	echo"<script>window.location.href='cms.php?id=".$id."';</script>";
	exit();
}
#*********************** ADD About us Description ************
else if(isset($_REQUEST['aboutsubmit_x']))
{
	$contact_us = mysql_real_escape_string(trim($_REQUEST['contact_us']));
	$contact_usr = mysql_real_escape_string(trim($_REQUEST['contact_usr']));
	$contactid = $_REQUEST['contactid'];
	$rowAffected = mysql_query("update aboutus set aboutdesp = '$contact_us',ja_aboutdesp = '$contact_usr' where id = '".$contactid."'");// update
	if(mysql_affected_rows()>0)
	 	$_SESSION["msg"] ="About us  Description Updated Successfully";
	else
		$_SESSION["msg"] ="About us  Description Not Updated Successfully";
	//header("Location: about-us.php");
	echo"<script>window.location.href='about-us.php';</script>";
	exit();	
	//exit;
}


#*********************** ADD Contact us Description ************
else if(isset($_REQUEST['contactsubmit_x']))
{
	$contact_us = mysql_real_escape_string(trim($_REQUEST['contact_us']));
	$contact_usr = mysql_real_escape_string(trim($_REQUEST['contact_usr']));
	$contactid = $_REQUEST['contactid'];
	$rowAffected = mysql_query("update contactus set contactdesp = '$contact_us',ja_contactdesp = '$contact_usr' where id = '".$contactid."'");// update
	if(mysql_affected_rows()>0)
	{
	 	$_SESSION["msg"] ="Contact us  Description Updated Successfully";
	}
	else
	{
		$_SESSION["msg"] ="Contact us  Description Not Updated Successfully";
	}
	
	//header("Location: contact-us.php");		
	//exit;
	echo"<script>window.location.href='contact-us.php';</script>";
	exit();	
}
######################## ADD Product in table product ################################
else if(isset($_REQUEST['addProduct_x']))
{
	///////// Seo field ////////////////
	$eurl=makeUrl(trim($_REQUEST['title']));
	
	$seotitle = mysql_real_escape_string(trim($_REQUEST['seotitle']));
	$keywords = mysql_real_escape_string(trim($_REQUEST['keywords']));
	$seodescription = mysql_real_escape_string(trim($_REQUEST['seodescription']));
	$seojatitle = mysql_real_escape_string(trim($_REQUEST['seojatitle']));
	$jakeywords = mysql_real_escape_string(trim($_REQUEST['jakeywords']));
	$jaseodescription = mysql_real_escape_string(trim($_REQUEST['jaseodescription']));
	/////////end  Seo field ////////////////
	$catid = mysql_real_escape_string(trim($_REQUEST['selectcat']));
	$subcatid = mysql_real_escape_string(trim($_REQUEST['selectsub']));
	$title = mysql_real_escape_string(trim($_REQUEST['title']));
	$gendescription = mysql_real_escape_string(trim($_REQUEST['gendescription']));
	$gencondiotion = mysql_real_escape_string(trim($_REQUEST['gencondiotion']));
	$genstock = mysql_real_escape_string(trim($_REQUEST['genstock']));
	$instock = mysql_real_escape_string(trim($_REQUEST['instock']));
	$genprice = mysql_real_escape_string(trim($_REQUEST['genprice']));
	$brname = mysql_real_escape_string(trim($_REQUEST['brname']));
	$jehallmarks = mysql_real_escape_string(trim($_REQUEST['jehallmarks']));
	$jeperiod = mysql_real_escape_string(trim($_REQUEST['jeperiod']));
	$jediamond = mysql_real_escape_string(trim($_REQUEST['jediamond']));
	$jediamondcolor = mysql_real_escape_string(trim($_REQUEST['jediamondcolor']));
	$jediamondcl = mysql_real_escape_string(trim($_REQUEST['jediamondcl']));
	$jestoneweight = mysql_real_escape_string(trim($_REQUEST['jestoneweight']));
	$jestonecolor = mysql_real_escape_string(trim($_REQUEST['jestonecolor']));
	$jestonecl = mysql_real_escape_string(trim($_REQUEST['jestonecl']));
	$jemetal = mysql_real_escape_string(trim($_REQUEST['jemetal']));
	$jemetailpu = mysql_real_escape_string(trim($_REQUEST['jemetailpu']));
	$jempriceweight = mysql_real_escape_string(trim($_REQUEST['jempriceweight']));
	$jedimension = mysql_real_escape_string(trim($_REQUEST['jedimension']));
	$jefingersize = mysql_real_escape_string(trim($_REQUEST['jefingersize']));
	$jeselect = mysql_real_escape_string(trim($_REQUEST['jeselect']));
	$diaweight = mysql_real_escape_string(trim($_REQUEST['diaweight']));
	$diashap = mysql_real_escape_string(trim($_REQUEST['diashap']));
	$dialab = mysql_real_escape_string(trim($_REQUEST['dialab']));
	$diacolor = mysql_real_escape_string(trim($_REQUEST['diacolor']));
	$diaclarity = mysql_real_escape_string(trim($_REQUEST['diaclarity']));
	$diacut = mysql_real_escape_string(trim($_REQUEST['diacut']));
	$daipolish = mysql_real_escape_string(trim($_REQUEST['daipolish']));
	$diasymmetry = mysql_real_escape_string(trim($_REQUEST['diasymmetry']));
	$diafluor = mysql_real_escape_string(trim($_REQUEST['diafluor']));
	$diatable = mysql_real_escape_string(trim($_REQUEST['diatable']));
	$diadepth = mysql_real_escape_string(trim($_REQUEST['diadepth']));
	$diameasurment = mysql_real_escape_string(trim($_REQUEST['diameasurment']));
	$diaremarks = mysql_real_escape_string(trim($_REQUEST['diaremarks']));
	$diapercarat = mysql_real_escape_string(trim($_REQUEST['diapercarat']));
	$diatotalprice = mysql_real_escape_string(trim($_REQUEST['diatotalprice']));
	$gemcarat = mysql_real_escape_string(trim($_REQUEST['gemcarat']));
	$gemstonetype = mysql_real_escape_string(trim($_REQUEST['gemstonetype']));
	$gemshape = mysql_real_escape_string(trim($_REQUEST['gemshape']));
	$gemcolor = mysql_real_escape_string(trim($_REQUEST['gemcolor']));
	$gemclarity = mysql_real_escape_string(trim($_REQUEST['gemclarity']));
	$gemcut = mysql_real_escape_string(trim($_REQUEST['gemcut']));
	$gemorigin = mysql_real_escape_string(trim($_REQUEST['gemorigin']));
	$gemtreatment = mysql_real_escape_string(trim($_REQUEST['gemtreatment']));
	$gemlab = mysql_real_escape_string(trim($_REQUEST['gemlab']));
	$gemremarks = mysql_real_escape_string(trim($_REQUEST['gemremarks']));
	$watbrand = mysql_real_escape_string(trim($_REQUEST['watbrand']));
	$watmodel = mysql_real_escape_string(trim($_REQUEST['watmodel']));
	$watgender = mysql_real_escape_string(trim($_REQUEST['watgender']));
	$watage = mysql_real_escape_string(trim($_REQUEST['watage']));
	$watfeatures = mysql_real_escape_string(trim($_REQUEST['watfeatures']));
	$watfeatures1 = mysql_real_escape_string(trim($_REQUEST['watfeatures1']));
	$watfeatures2 = mysql_real_escape_string(trim($_REQUEST['watfeatures2']));
	$watfeatures3 = mysql_real_escape_string(trim($_REQUEST['watfeatures3']));
	$watmovement = mysql_real_escape_string(trim($_REQUEST['watmovement']));
	$watcase = mysql_real_escape_string(trim($_REQUEST['watcase']));
	$watband = mysql_real_escape_string(trim($_REQUEST['watband']));
	$watdim = mysql_real_escape_string(trim($_REQUEST['watdim']));
	$watcarat = mysql_real_escape_string(trim($_REQUEST['watcarat']));
	$watbox = mysql_real_escape_string(trim($_REQUEST['watbox']));
	$watwarranty = mysql_real_escape_string(trim($_REQUEST['watwarranty']));
	$watremarks = mysql_real_escape_string(trim($_REQUEST['watremarks']));
	$objbrandname = mysql_real_escape_string(trim($_REQUEST['objbrandname']));
	$objhall = mysql_real_escape_string(trim($_REQUEST['objhall']));
	$objperiod = mysql_real_escape_string(trim($_REQUEST['objperiod']));
	$objstyle = mysql_real_escape_string(trim($_REQUEST['objstyle']));
	$objmaterial = mysql_real_escape_string(trim($_REQUEST['objmaterial']));
	$objdimensions = mysql_real_escape_string(trim($_REQUEST['objdimensions']));
	$objweight = mysql_real_escape_string(trim($_REQUEST['objweight']));
	$objremarks = mysql_real_escape_string(trim($_REQUEST['objremarks']));
	######################## For Japanese####################
	$jatitle = mysql_real_escape_string(trim($_REQUEST['jatitle']));
	$jagendescription = mysql_real_escape_string(trim($_REQUEST['jagendescription']));
	$jagencondiotion = mysql_real_escape_string(trim($_REQUEST['jagencondiotion']));
	$jagenstock = mysql_real_escape_string(trim($_REQUEST['jagenstock']));
	$jagenprice = mysql_real_escape_string(trim($_REQUEST['jagenprice']));
	$jabrname = mysql_real_escape_string(trim($_REQUEST['jabrname']));
	$jajehallmarks = mysql_real_escape_string(trim($_REQUEST['jajehallmarks']));
	$jajeperiod = mysql_real_escape_string(trim($_REQUEST['jajeperiod']));
	$jajediamond = mysql_real_escape_string(trim($_REQUEST['jajediamond']));
	$jajediamondcolor = mysql_real_escape_string(trim($_REQUEST['jajediamondcolor']));
	$jajediamondcl = mysql_real_escape_string(trim($_REQUEST['jajediamondcl']));
	$jajestoneweight = mysql_real_escape_string(trim($_REQUEST['jajestoneweight']));
	$jajestonecolor = mysql_real_escape_string(trim($_REQUEST['jajestonecolor']));
	$jajestonecl = mysql_real_escape_string(trim($_REQUEST['jajestonecl']));
	$jajemetal = mysql_real_escape_string(trim($_REQUEST['jajemetal']));
	$jajemetailpu = mysql_real_escape_string(trim($_REQUEST['jajemetailpu']));
	$jajempriceweight = mysql_real_escape_string(trim($_REQUEST['jajempriceweight']));
	$jajedimension = mysql_real_escape_string(trim($_REQUEST['jajedimension']));
	$jajefingersize = mysql_real_escape_string(trim($_REQUEST['jajefingersize']));
	$jajeselect = mysql_real_escape_string(trim($_REQUEST['jajeselect']));
	$jadiaweight = mysql_real_escape_string(trim($_REQUEST['jadiaweight']));
	$jadiashap = mysql_real_escape_string(trim($_REQUEST['jadiashap']));
	$jadialab = mysql_real_escape_string(trim($_REQUEST['jadialab']));
	$jadiacolor = mysql_real_escape_string(trim($_REQUEST['jadiacolor']));
	$jadiaclarity = mysql_real_escape_string(trim($_REQUEST['jadiaclarity']));
	$jadiacut = mysql_real_escape_string(trim($_REQUEST['jadiacut']));
	$jadaipolish = mysql_real_escape_string(trim($_REQUEST['jadaipolish']));
	$jadiasymmetry = mysql_real_escape_string(trim($_REQUEST['jadiasymmetry']));
	$jadiafluor = mysql_real_escape_string(trim($_REQUEST['jadiafluor']));
	$jadiatable = mysql_real_escape_string(trim($_REQUEST['jadiatable']));
	$jadiadepth = mysql_real_escape_string(trim($_REQUEST['jadiadepth']));
	$jadiameasurment = mysql_real_escape_string(trim($_REQUEST['jadiameasurment']));
	$jadiaremarks = mysql_real_escape_string(trim($_REQUEST['jadiaremarks']));
	$jadiapercarat = mysql_real_escape_string(trim($_REQUEST['jadiapercarat']));
	$jadiatotalprice = mysql_real_escape_string(trim($_REQUEST['jadiatotalprice']));
	$jagemcarat = mysql_real_escape_string(trim($_REQUEST['jagemcarat']));
	$jagemstonetype = mysql_real_escape_string(trim($_REQUEST['jagemstonetype']));
	$jagemshape = mysql_real_escape_string(trim($_REQUEST['jagemshape']));
	$jagemcolor = mysql_real_escape_string(trim($_REQUEST['jagemcolor']));
	$jagemclarity = mysql_real_escape_string(trim($_REQUEST['jagemclarity']));
	$jagemcut = mysql_real_escape_string(trim($_REQUEST['jagemcut']));
	$jagemorigin = mysql_real_escape_string(trim($_REQUEST['jagemorigin']));
	$jagemtreatment = mysql_real_escape_string(trim($_REQUEST['jagemtreatment']));
	$jagemlab = mysql_real_escape_string(trim($_REQUEST['jagemlab']));
	$jagemremarks = mysql_real_escape_string(trim($_REQUEST['jagemremarks']));
	$jawatbrand = mysql_real_escape_string(trim($_REQUEST['jawatbrand']));
	$jawatmodel = mysql_real_escape_string(trim($_REQUEST['jawatmodel']));
	$jawatgender = mysql_real_escape_string(trim($_REQUEST['jawatgender']));
	$jawatage = mysql_real_escape_string(trim($_REQUEST['jawatage']));
	$jawatfeatures = mysql_real_escape_string(trim($_REQUEST['jawatfeatures']));
	$jawatfeatures1 = mysql_real_escape_string(trim($_REQUEST['jawatfeatures1']));
	$jawatfeatures2 = mysql_real_escape_string(trim($_REQUEST['jawatfeatures2']));
	$jawatfeatures3 = mysql_real_escape_string(trim($_REQUEST['jawatfeatures3']));
	$jawatmovement = mysql_real_escape_string(trim($_REQUEST['jawatmovement']));
	$jawatcase = mysql_real_escape_string(trim($_REQUEST['jawatcase']));
	$jawatband = mysql_real_escape_string(trim($_REQUEST['jawatband']));
	$jawatdim = mysql_real_escape_string(trim($_REQUEST['jawatdim']));
	$jawatcarat = mysql_real_escape_string(trim($_REQUEST['jawatcarat']));
	$jawatbox = mysql_real_escape_string(trim($_REQUEST['jawatbox']));
	$jawatwarranty = mysql_real_escape_string(trim($_REQUEST['jawatwarranty']));
	$jawatremarks = mysql_real_escape_string(trim($_REQUEST['jawatremarks']));
	$jaobjbrandname = mysql_real_escape_string(trim($_REQUEST['jaobjbrandname']));
	$jaobjhall = mysql_real_escape_string(trim($_REQUEST['jaobjhall']));
	$jaobjperiod = mysql_real_escape_string(trim($_REQUEST['jaobjperiod']));
	$jaobjstyle = mysql_real_escape_string(trim($_REQUEST['jaobjstyle']));
	$jaobjmaterial = mysql_real_escape_string(trim($_REQUEST['jaobjmaterial']));
	$jaobjdimensions = mysql_real_escape_string(trim($_REQUEST['jaobjdimensions']));
	$jaobjweight = mysql_real_escape_string(trim($_REQUEST['jaobjweight']));
	$jaobjremarks = mysql_real_escape_string(trim($_REQUEST['jaobjremarks']));
	$shipchargeint = mysql_real_escape_string(trim($_REQUEST['shipchargeint']));
	$shipchargedom = mysql_real_escape_string(trim($_REQUEST['shipchargedom']));
	$shipchargeint = mysql_real_escape_string(trim($_REQUEST['shipchargeint']));
	$shipchargedom = mysql_real_escape_string(trim($_REQUEST['shipchargedom']));
	$status	= $_REQUEST['objpublish']!=""?"Y":"N";
	$genfront	= $_REQUEST['genfront']!=""?"Y":"N";
	$gencatpic	= $_REQUEST['gencatpic']!=""?"Y":"N";
	$date = date("m-d-Y");
	 $itemecount=$_REQUEST["itemecount"];
	
	$flag = isFoundMore("product","catid='$catid' and subcatid='$subcatid' and eurl = '$eurl'");
	if($flag)
	{
		$_SESSION["msg"]="Product Already Exits";
		echo"<script>window.location.href='add-product.php';</script>";
		exit();
		//header("Location:add-product.php");
		//exit;	
	}
	else
	{
		$img = $_FILES['subimage']['name'];
		if (($_FILES['subimage']['type'] == 'image/gif')
		|| ($_FILES['subimage']['type'] == 'image/jpeg')
		|| ($_FILES['subimage']['type'] == 'image/png')
		|| ($_FILES['subimage']['type'] == 'image/pjpeg')
		&& ($_FILES['subimage']['size'] / 1024 < 2000))
		{
			$img_name=time(). $_FILES['subimage']['name'];
			if(move_uploaded_file($_FILES['subimage']['tmp_name'],$imagepath.$img_name))
			{
				$flag = resize_actual($imagepath.$img_name, $imagelist.$img_name, 328,288);
				$rowAffected=rs_insert("product","keyword,seodescription,seotitle, 	jakeyword,jaseodescription,seojatitle,adddate,catid,subcatid,title,description,`condition`,imagepath,stock,productstock,price,frontsection,catshow,brname,jehallmarks,jeperiod,jediamond,jediamondcolor,jediamondcl,jestoneweight,jestonecolor,jestonecl,jemetal,jemetailpu,jempriceweight,jedimension,jefingersize,jeselect,diaweight,diashap,dialab,diacolor,diaclarity,diacut,daipolish,diasymmetry,diafluor,diatable,diadepth,diameasurment,diaremarks,diapercarat,diatotalprice,gemcarat,gemstonetype,gemshape,gemcolor,gemclarity,gemcut,gemorigin,gemtreatment,gemlab,gemremarks,watbrand,watmodel,watgender,watage,watfeatures,watfeatures1,watfeatures2,watfeatures3,watmovement,watcase,watband,watdim,watcarat,watbox,watwarranty,watremarks,objbrandname,objhall,objperiod,objstyle,objmaterial,objdimensions,objweight,objremarks,jatitle,jadescription,`jacondition`,jastock,japrice,jabrname,jajehallmarks,jajeperiod,jajediamond,jajediamondcolor,jajediamondcl,jajestoneweight,jajestonecolor,jajestonecl,jajemetal,jajemetailpu,jajempriceweight,jajedimension,jajefingersize,jadiaweight,jadiashap,jadialab,jadiacolor,jadiaclarity,jadiacut,jadaipolish,jadiasymmetry,jadiafluor,jadiatable,jadiadepth,jadiameasurment,jadiaremarks,jadiapercarat,jadiatotalprice,jagemcarat,jagemstonetype,jagemshape,jagemcolor,jagemclarity,jagemcut,jagemorigin,jagemtreatment,jagemlab,jagemremarks,jawatbrand,jawatmodel,jawatgender,jawatage,jawatfeatures,jawatfeatures1,jawatfeatures2,jawatfeatures3,jawatmovement,jawatcase,jawatband,jawatdim,jawatcarat,jawatbox,jawatwarranty,jawatremarks,jaobjbrandname,jaobjhall,jaobjperiod,jaobjstyle,jaobjmaterial,jaobjdimensions,jaobjweight,jaobjremarks,status,shipchargeint,shipchargedom,eurl","'$keywords','$seodescription','$seotitle','$jakeywords','$jaseodescription','$seojatitle','$date','$catid','$subcatid','$title','$gendescription','$gencondiotion','$img_name','$genstock','$instock','$genprice','$genfront','$gencatpic','$brname','$jehallmarks','$jeperiod','$jediamond', '$jediamondcolor','$jediamondcl','$jestoneweight','$jestonecolor','$jestonecl','$jemetal','$jemetailpu','$jempriceweight','$jedimension','$jefingersize','$jeselect','$diaweight','$diashap','$dialab','$diacolor','$diaclarity','$diacut','$daipolish','$diasymmetry','$diafluor','$diatable','$diadepth','$diameasurment','$diaremarks','$diapercarat','$diatotalprice','$gemcarat','$gemstonetype','$gemshape','$gemcolor','$gemclarity','$gemcut','$gemorigin','$gemtreatment','$gemlab','$gemremarks','$watbrand','$watmodel','$watgender','$watage', '$watfeatures','$watfeatures1','$watfeatures2','$watfeatures3','$watmovement','$watcase','$watband','$watdim','$watcarat','$watbox','$watwarranty','$watremarks', '$objbrandname','$objhall','$objperiod', '$objstyle','$objmaterial','$objdimensions', '$objweight','$objremarks','$jatitle','$jagendescription','$jagencondiotion','$jagenstock','$jagenprice','$jabrname','$jajehallmarks','$jajeperiod','$jajediamond', '$jajediamondcolor','$jajediamondcl','$jajestoneweight','$jajestonecolor','$jajestonecl','$jajemetal','$jajemetailpu','$jajempriceweight','$jajedimension','$jajefingersize','$jadiaweight','$jadiashap','$jadialab','$jadiacolor','$jadiaclarity','$jadiacut','$jadaipolish','$jadiasymmetry','$jadiafluor','$jadiatable','$jadiadepth','$jadiameasurment','$jadiaremarks','$jadiapercarat','$jadiatotalprice','$jagemcarat','$jagemstonetype','$jagemshape','$jagemcolor','$jagemclarity','$jagemcut','$jagemorigin','$jagemtreatment','$jagemlab','$jagemremarks','$jawatbrand','$jawatmodel','$jawatgender','$jawatage',  '$jawatfeatures','$jawatfeatures1','$jawatfeatures2','$jawatfeatures3','$jawatmovement', '$jawatcase','$jawatband','$jawatdim', '$jawatcarat','$jawatbox','$jawatwarranty','$jawatremarks', '$jaobjbrandname','$jaobjhall','$jaobjperiod', '$jaobjstyle','$jaobjmaterial','$jaobjdimensions', '$jaobjweight','$jaobjremarks','$status','$shipchargeint','$shipchargedom','$eurl'");
				if(mysql_affected_rows()>0)
				{
					$_SESSION["msg"]="Product Added Successfully";
					$insertid = mysql_insert_id();
					for($i=0;$i<=$itemecount;$i++)
					{
						$order_item=mysql_real_escape_string($_REQUEST["order_item_".$i]);
						$order_value=mysql_real_escape_string($_REQUEST["order_value_".$i]);
						$jaorder_item=mysql_real_escape_string($_REQUEST["jaorder_item_".$i]);
						$jaorder_value=mysql_real_escape_string($_REQUEST["jaorder_value_".$i]);
						if($order_item!='' && $order_value!='' && $jaorder_item!='' && $jaorder_value!='')
						{
							$flag1 = isFoundMore("moreproduct","fieldname='".$order_item."' and fieldvalue='".$order_value."' and jafieldname='".$jaorder_item."' and jafieldvalue='".$jaorder_value."'and productid='".$insertid."'");
							if(!$flag1)
							{
								$rowAffected1=rs_insert("moreproduct","fieldname,fieldvalue,jafieldname,jafieldvalue,productid","'$order_item','$order_value','$jaorder_item','$jaorder_value','$insertid'");
							}
						}
					}
					//header("Location:add-product.php");	
					//exit;
					echo"<script>window.location.href='add-product.php';</script>";
					exit();
				}
				else
				{
					$_SESSION["msg"]="Product not Added Successfully";
					//header("Location:add-product.php");		
					//exit;
					echo"<script>window.location.href='add-product.php';</script>";
					exit();
				}
			}
			else
			{
				$_SESSION["msg"]="Product Image not uploaded Successfully";
				//header("Location:add-product.php");		
				//exit;
				echo"<script>window.location.href='add-product.php';</script>";
				exit();
			}
		}
		else
		{
			$_SESSION["msg"]="Image Size/Format Excecption";
			//header("Location:add-product.php");
			//exit;
			echo"<script>window.location.href='add-product.php';</script>";
			exit();
		}
	}
	echo"<script>window.location.href='add-product.php';</script>";
	exit();
}

#******************* Update Product Status(Active) **********
else if(isset($_REQUEST['publishproduct_x']))
{
	$page = $_REQUEST['page'];
	$chk = $_POST['box'];
	if(!empty($chk))
	{
		for($i=0;$i<sizeof($chk); $i++)
		{
			$del_id = $chk[$i];
			$result = rs_select("product where id = '$del_id'", "status");
			while($updateresult= mysql_fetch_assoc($result))
			{
				if($updateresult['status']=="N")
					$rowAffected=mysql_query("update product SET status = 'Y' where id = '$del_id'") or die(mysql_error());
				else
					$rowAffected=mysql_query("update product SET status = 'N' where id = '$del_id'") or die(mysql_error());
			}
			if(mysql_affected_rows()>0)
				$_SESSION["msg"]="Product Status Update Successfully";
			else
				$_SESSION["msg"]="Product Status not Update  Successfully";		
		}
	}
	else
	{
		$_SESSION['msg'] = "Tick any Checkbox";
		
	}
	//header("Location:view-products.php?page=".$page."&catname=".$_REQUEST['catname']."&subcatname=".$_REQUEST['subcatname'] );	
	//exit;	
	echo"<script>window.location.href='view-products.php?page=".$page."&catname=".$_REQUEST['catname']."&subcatname=".$_REQUEST['subcatname']."';</script>";
	exit();
}
#******************** Delete the Category *******************************
else if(isset($_REQUEST['delteproduct_x']))
{
	$page = $_REQUEST['page'];
	$chk = $_POST['box'];
	$catname = $_REQUEST['catname'];
	$subcatname = $_REQUEST['subcatname'];
	if(!empty($chk))
	{
		for($i=0;$i<sizeof($chk); $i++)
		{
			$del_id = $chk[$i];
			$res = rs_select_con("product","id='".$del_id."'");
			$imgdata = mysql_fetch_assoc($res);
			if(unlink($imagepath.$imgdata['imagepath']))
			{
				@unlink($imagelist.$imgdata['imagepath']);
				$delqr=rs_del("product","id='".$del_id."'");
				if($delqr)
					$_SESSION['msg'] = "Product Deleted Successfully";
				else
					$_SESSION['msg'] = "Product not Deleted  Sucessfully";
			}
		}
	}
	else
	{
		$_SESSION['msg'] = "Tick any Checkbox";
		
	}
	//header("Location:view-products.php?page=".$page."&catname=".$_REQUEST['catname']."&subcatname=".$_REQUEST['subcatname'] );	
	//exit;
	echo"<script>window.location.href='view-products.php?page=".$page."&catname=".$_REQUEST['catname']."&subcatname=".$_REQUEST['subcatname']."';</script>";
	exit();
}

# /////////////////////// Edit Product //////////////////////
else if(isset($_REQUEST['editProduct_x']))
{
	//////////// seo feild /////////////////
	$eurl=makeUrl(trim($_REQUEST['title']));
	$seotitle = mysql_real_escape_string(trim($_REQUEST['seotitle']));
	$keywords = mysql_real_escape_string(trim($_REQUEST['keywords']));
	$seodescription = mysql_real_escape_string(trim($_REQUEST['seodescription']));
	$seojatitle = mysql_real_escape_string(trim($_REQUEST['seojatitle']));
	$jakeywords = mysql_real_escape_string(trim($_REQUEST['jakeywords']));
	$jaseodescription = mysql_real_escape_string(trim($_REQUEST['jaseodescription']));
	//////////// End seo feild /////////////////
	$catid = mysql_real_escape_string(trim($_REQUEST['selectcat']));
	$subcatid = mysql_real_escape_string(trim($_REQUEST['selectsub']));
	$title = mysql_real_escape_string(trim($_REQUEST['title']));
	$oldtitle = mysql_real_escape_string(trim($_REQUEST['oldtitle']));
	$gendescription = mysql_real_escape_string(trim($_REQUEST['gendescription']));
	$gencondiotion = mysql_real_escape_string(trim($_REQUEST['gencondiotion']));
	$genstock = mysql_real_escape_string(trim($_REQUEST['genstock']));
	$instock = mysql_real_escape_string(trim($_REQUEST['instock']))!=""?mysql_real_escape_string(trim($_REQUEST['instock'])):"0";
	$genprice = mysql_real_escape_string(trim($_REQUEST['genprice']));
	$brname = mysql_real_escape_string(trim($_REQUEST['brname']));
	$jehallmarks = mysql_real_escape_string(trim($_REQUEST['jehallmarks']));
	$jeperiod = mysql_real_escape_string(trim($_REQUEST['jeperiod']));
	$jediamond = mysql_real_escape_string(trim($_REQUEST['jediamond']));
	$jediamondcolor = mysql_real_escape_string(trim($_REQUEST['jediamondcolor']));
	$jediamondcl = mysql_real_escape_string(trim($_REQUEST['jediamondcl']));
	$jestoneweight = mysql_real_escape_string(trim($_REQUEST['jestoneweight']));
	$jestonecolor = mysql_real_escape_string(trim($_REQUEST['jestonecolor']));
	$jestonecl = mysql_real_escape_string(trim($_REQUEST['jestonecl']));
	$jemetal = mysql_real_escape_string(trim($_REQUEST['jemetal']));
	$jemetailpu = mysql_real_escape_string(trim($_REQUEST['jemetailpu']));
	$jempriceweight = mysql_real_escape_string(trim($_REQUEST['jempriceweight']));
	$jedimension = mysql_real_escape_string(trim($_REQUEST['jedimension']));
	$jefingersize = mysql_real_escape_string(trim($_REQUEST['jefingersize']));
	$jeselect = mysql_real_escape_string(trim($_REQUEST['jeselect']));
	$diaweight = mysql_real_escape_string(trim($_REQUEST['diaweight']));
	$diashap = mysql_real_escape_string(trim($_REQUEST['diashap']));
	$dialab = mysql_real_escape_string(trim($_REQUEST['dialab']));
	$diacolor = mysql_real_escape_string(trim($_REQUEST['diacolor']));
	$diaclarity = mysql_real_escape_string(trim($_REQUEST['diaclarity']));
	$diacut = mysql_real_escape_string(trim($_REQUEST['diacut']));
	$daipolish = mysql_real_escape_string(trim($_REQUEST['daipolish']));
	$diasymmetry = mysql_real_escape_string(trim($_REQUEST['diasymmetry']));
	$diafluor = mysql_real_escape_string(trim($_REQUEST['diafluor']));
	$diatable = mysql_real_escape_string(trim($_REQUEST['diatable']));
	$diadepth = mysql_real_escape_string(trim($_REQUEST['diadepth']));
	$diameasurment = mysql_real_escape_string(trim($_REQUEST['diameasurment']));
	$diaremarks = mysql_real_escape_string(trim($_REQUEST['diaremarks']));
	$diapercarat = mysql_real_escape_string(trim($_REQUEST['diapercarat']));
	$diatotalprice = mysql_real_escape_string(trim($_REQUEST['diatotalprice']));
	$gemcarat = mysql_real_escape_string(trim($_REQUEST['gemcarat']));
	$gemstonetype = mysql_real_escape_string(trim($_REQUEST['gemstonetype']));
	$gemshape = mysql_real_escape_string(trim($_REQUEST['gemshape']));
	$gemcolor = mysql_real_escape_string(trim($_REQUEST['gemcolor']));
	$gemclarity = mysql_real_escape_string(trim($_REQUEST['gemclarity']));
	$gemcut = mysql_real_escape_string(trim($_REQUEST['gemcut']));
	$gemorigin = mysql_real_escape_string(trim($_REQUEST['gemorigin']));
	$gemtreatment = mysql_real_escape_string(trim($_REQUEST['gemtreatment']));
	$gemlab = mysql_real_escape_string(trim($_REQUEST['gemlab']));
	$gemremarks = mysql_real_escape_string(trim($_REQUEST['gemremarks']));
	$watbrand = mysql_real_escape_string(trim($_REQUEST['watbrand']));
	$watmodel = mysql_real_escape_string(trim($_REQUEST['watmodel']));
	$watgender = mysql_real_escape_string(trim($_REQUEST['watgender']));
	$watage = mysql_real_escape_string(trim($_REQUEST['watage']));
	$watfeatures = mysql_real_escape_string(trim($_REQUEST['watfeatures']));
	$watfeatures1 = mysql_real_escape_string(trim($_REQUEST['watfeatures1']));
	$watfeatures2 = mysql_real_escape_string(trim($_REQUEST['watfeatures2']));
	$watfeatures3 = mysql_real_escape_string(trim($_REQUEST['watfeatures3']));
	$watmovement = mysql_real_escape_string(trim($_REQUEST['watmovement']));
	$watcase = mysql_real_escape_string(trim($_REQUEST['watcase']));
	$watband = mysql_real_escape_string(trim($_REQUEST['watband']));
	$watdim = mysql_real_escape_string(trim($_REQUEST['watdim']));
	$watcarat = mysql_real_escape_string(trim($_REQUEST['watcarat']));
	$watbox = mysql_real_escape_string(trim($_REQUEST['watbox']));
	$watwarranty = mysql_real_escape_string(trim($_REQUEST['watwarranty']));
	$watremarks = mysql_real_escape_string(trim($_REQUEST['watremarks']));
	$objbrandname = mysql_real_escape_string(trim($_REQUEST['objbrandname']));
	$objhall = mysql_real_escape_string(trim($_REQUEST['objhall']));
	$objperiod = mysql_real_escape_string(trim($_REQUEST['objperiod']));
	$objstyle = mysql_real_escape_string(trim($_REQUEST['objstyle']));
	$objmaterial = mysql_real_escape_string(trim($_REQUEST['objmaterial']));
	$objdimensions = mysql_real_escape_string(trim($_REQUEST['objdimensions']));
	$objweight = mysql_real_escape_string(trim($_REQUEST['objweight']));
	$objremarks = mysql_real_escape_string(trim($_REQUEST['objremarks']));
	
	######################## For Japanese####################
	$jatitle = mysql_real_escape_string(trim($_REQUEST['jatitle']));
	$jagendescription = mysql_real_escape_string(trim($_REQUEST['jagendescription']));
	$jagencondiotion = mysql_real_escape_string(trim($_REQUEST['jagencondiotion']));
	$jagenstock = mysql_real_escape_string(trim($_REQUEST['jagenstock']));
	$jagenprice = mysql_real_escape_string(trim($_REQUEST['jagenprice']));
	$jabrname = mysql_real_escape_string(trim($_REQUEST['jabrname']));
	$jajehallmarks = mysql_real_escape_string(trim($_REQUEST['jajehallmarks']));
	$jajeperiod = mysql_real_escape_string(trim($_REQUEST['jajeperiod']));
	$jajediamond = mysql_real_escape_string(trim($_REQUEST['jajediamond']));
	$jajediamondcolor = mysql_real_escape_string(trim($_REQUEST['jajediamondcolor']));
	$jajediamondcl = mysql_real_escape_string(trim($_REQUEST['jajediamondcl']));
	$jajestoneweight = mysql_real_escape_string(trim($_REQUEST['jajestoneweight']));
	$jajestonecolor = mysql_real_escape_string(trim($_REQUEST['jajestonecolor']));
	$jajestonecl = mysql_real_escape_string(trim($_REQUEST['jajestonecl']));
	$jajemetal = mysql_real_escape_string(trim($_REQUEST['jajemetal']));
	$jajemetailpu = mysql_real_escape_string(trim($_REQUEST['jajemetailpu']));
	$jajempriceweight = mysql_real_escape_string(trim($_REQUEST['jajempriceweight']));
	$jajedimension = mysql_real_escape_string(trim($_REQUEST['jajedimension']));
	$jajefingersize = mysql_real_escape_string(trim($_REQUEST['jajefingersize']));
	$jajeselect = mysql_real_escape_string(trim($_REQUEST['jajeselect']));
	$jadiaweight = mysql_real_escape_string(trim($_REQUEST['jadiaweight']));
	$jadiashap = mysql_real_escape_string(trim($_REQUEST['jadiashap']));
	$jadialab = mysql_real_escape_string(trim($_REQUEST['jadialab']));
	$jadiacolor = mysql_real_escape_string(trim($_REQUEST['jadiacolor']));
	$jadiaclarity = mysql_real_escape_string(trim($_REQUEST['jadiaclarity']));
	$jadiacut = mysql_real_escape_string(trim($_REQUEST['jadiacut']));
	$jadaipolish = mysql_real_escape_string(trim($_REQUEST['jadaipolish']));
	$jadiasymmetry = mysql_real_escape_string(trim($_REQUEST['jadiasymmetry']));
	$jadiafluor = mysql_real_escape_string(trim($_REQUEST['jadiafluor']));
	$jadiatable = mysql_real_escape_string(trim($_REQUEST['jadiatable']));
	$jadiadepth = mysql_real_escape_string(trim($_REQUEST['jadiadepth']));
	$jadiameasurment = mysql_real_escape_string(trim($_REQUEST['jadiameasurment']));
	$jadiaremarks = mysql_real_escape_string(trim($_REQUEST['jadiaremarks']));
	$jadiapercarat = mysql_real_escape_string(trim($_REQUEST['jadiapercarat']));
	$jadiatotalprice = mysql_real_escape_string(trim($_REQUEST['jadiatotalprice']));
	$jagemcarat = mysql_real_escape_string(trim($_REQUEST['jagemcarat']));
	$jagemstonetype = mysql_real_escape_string(trim($_REQUEST['jagemstonetype']));
	$jagemshape = mysql_real_escape_string(trim($_REQUEST['jagemshape']));
	$jagemcolor = mysql_real_escape_string(trim($_REQUEST['jagemcolor']));
	$jagemclarity = mysql_real_escape_string(trim($_REQUEST['jagemclarity']));
	$jagemcut = mysql_real_escape_string(trim($_REQUEST['jagemcut']));
	$jagemorigin = mysql_real_escape_string(trim($_REQUEST['jagemorigin']));
	$jagemtreatment = mysql_real_escape_string(trim($_REQUEST['jagemtreatment']));
	$jagemlab = mysql_real_escape_string(trim($_REQUEST['jagemlab']));
	$jagemremarks = mysql_real_escape_string(trim($_REQUEST['jagemremarks']));
	$jawatbrand = mysql_real_escape_string(trim($_REQUEST['jawatbrand']));
	$jawatmodel = mysql_real_escape_string(trim($_REQUEST['jawatmodel']));
	$jawatgender = mysql_real_escape_string(trim($_REQUEST['jawatgender']));
	$jawatage = mysql_real_escape_string(trim($_REQUEST['jawatage']));
	$jawatfeatures = mysql_real_escape_string(trim($_REQUEST['jawatfeatures']));
	$jawatfeatures1 = mysql_real_escape_string(trim($_REQUEST['jawatfeatures1']));
	$jawatfeatures2 = mysql_real_escape_string(trim($_REQUEST['jawatfeatures2']));
	$jawatfeatures3 = mysql_real_escape_string(trim($_REQUEST['jawatfeatures3']));
	$jawatmovement = mysql_real_escape_string(trim($_REQUEST['jawatmovement']));
	$jawatcase = mysql_real_escape_string(trim($_REQUEST['jawatcase']));
	$jawatband = mysql_real_escape_string(trim($_REQUEST['jawatband']));
	$jawatdim = mysql_real_escape_string(trim($_REQUEST['jawatdim']));
	$jawatcarat = mysql_real_escape_string(trim($_REQUEST['jawatcarat']));
	$jawatbox = mysql_real_escape_string(trim($_REQUEST['jawatbox']));
	$jawatwarranty = mysql_real_escape_string(trim($_REQUEST['jawatwarranty']));
	$jawatremarks = mysql_real_escape_string(trim($_REQUEST['jawatremarks']));
	$jaobjbrandname = mysql_real_escape_string(trim($_REQUEST['jaobjbrandname']));
	$jaobjhall = mysql_real_escape_string(trim($_REQUEST['jaobjhall']));
	$jaobjperiod = mysql_real_escape_string(trim($_REQUEST['jaobjperiod']));
	$jaobjstyle = mysql_real_escape_string(trim($_REQUEST['jaobjstyle']));
	$jaobjmaterial = mysql_real_escape_string(trim($_REQUEST['jaobjmaterial']));
	$jaobjdimensions = mysql_real_escape_string(trim($_REQUEST['jaobjdimensions']));
	$jaobjweight = mysql_real_escape_string(trim($_REQUEST['jaobjweight']));
	$jaobjremarks = mysql_real_escape_string(trim($_REQUEST['jaobjremarks']));
	$shipchargeint = mysql_real_escape_string(trim($_REQUEST['shipchargeint']));
	$shipchargedom = mysql_real_escape_string(trim($_REQUEST['shipchargedom']));
	$status	= $_REQUEST['objpublish']!=""?"Y":"N";
	$genfront	= $_REQUEST['genfront']!=""?"Y":"N";
	$gencatpic	= $_REQUEST['gencatpic']!=""?"Y":"N";
	$oldimagepath = $_REQUEST['oldimagepath'];
	$editid = $_REQUEST['id'];
	$page = $_REQUEST['page'];
	$flag = isFoundMore("product","catid='$catid' and subcatid='$subcatid' and eurl = '$eurl' and title!='$oldtitle'");
	if($_FILES['subimage']['name'])
	{
		if (($_FILES['subimage']['type'] == 'image/gif')
		|| ($_FILES['subimage']['type'] == 'image/jpeg')
		|| ($_FILES['subimage']['type'] == 'image/png')
		|| ($_FILES['subimage']['type'] == 'image/pjpeg')
		&& ($_FILES['subimage']['size'] / 1024 < 2000))
		{
			@unlink($imagepath.$oldimagepath);
			@unlink($imagelist.$oldimagepath);
			$oldimagepath=time(). $_FILES['subimage']['name'];
			if(move_uploaded_file($_FILES['subimage']['tmp_name'],$imagepath.$oldimagepath))
			{
				$flag = resize_actual($imagepath.$oldimagepath, $imagelist.$oldimagepath, 328,288);
			}
			else
			{
				$_SESSION["msg"]="Product Image not uploaded Successfully";
				echo"<script>window.location.href='edit-product.php?catname=".$_REQUEST['catname']."&subcatname=".$_REQUEST['subcatname']."&productname=".$_REQUEST['id']."';</script>";
				exit();
			}
		}
		else
		{
			$_SESSION["msg"]="Product Image Size Problem Successfully";
			echo"<script>window.location.href='edit-product.php?catname=".$_REQUEST['catname']."&subcatname=".$_REQUEST['subcatname']."&productname=".$_REQUEST['id']."';</script>";
			exit();
		}
	}	
	if($flag)
	{
		$rowAffected=rs_update("product","description='$gendescription',`condition`='$gencondiotion',stock='$genstock',productstock='$instock',price='$genprice',frontsection='$genfront',catshow='$gencatpic',brname='$brname',jehallmarks='$jehallmarks',jeperiod='$jeperiod',jediamond='$jediamond',jediamondcolor='$jediamondcolor',jediamondcl='$jediamondcl',jestoneweight='$jestoneweight',jestonecolor='$jestonecolor',jestonecl='$jestonecl',jemetal='$jemetal',jemetailpu='$jemetailpu',jempriceweight='$jempriceweight',jedimension='$jedimension',jefingersize='$jefingersize',jeselect='$jeselect',diaweight='$diaweight',diashap='$diashap',dialab='$dialab',diacolor='$diacolor',diaclarity='$diaclarity',diacut='$diacut',daipolish='$daipolish',diasymmetry='$diasymmetry',diafluor='$diafluor',diatable='$diatable',diadepth='$diadepth',diameasurment='$diameasurment',diaremarks='$diaremarks',diapercarat='$diapercarat',diatotalprice='$diatotalprice',gemcarat='$gemcarat',gemstonetype='$gemstonetype',gemshape='$gemshape',gemcolor='$gemcolor',gemclarity='$gemclarity',gemcut='$gemcut',gemorigin='$gemorigin',gemtreatment='$gemtreatment',gemlab='$gemlab',gemremarks='$gemremarks',watbrand='$watbrand',watmodel='$watmodel',watgender='$watgender',watage='$watage',watfeatures='$watfeatures',watfeatures1='$watfeatures1',watfeatures2='$watfeatures2',watfeatures3='$watfeatures3',watmovement='$watmovement',watcase='$watcase',watband='$watband',watcarat='$watcarat',watbox='$watbox',watwarranty='$watwarranty',watremarks='$watremarks',objbrandname='$objbrandname',objhall='$objhall',objperiod='$objperiod',objstyle='$objstyle',objmaterial='$objmaterial',objdimensions='$objdimensions',objweight='$objweight',objremarks='$objremarks',jadescription='$jagendescription',`jacondition`='$jagencondiotion',jastock='$jagenstock',japrice='$jagenprice',jabrname='$jabrname',jajehallmarks='$jajehallmarks',jajeperiod='$jajeperiod',jajediamond='$jajediamond',jajediamondcolor='$jajediamondcolor',jajediamondcl='$jajediamondcl',jajestoneweight='$jajestoneweight',jajestonecolor='$jajestonecolor',jajestonecl='$jajestonecl',jajemetal='$jajemetal',jajemetailpu='$jajemetailpu',jajempriceweight='$jajempriceweight',jajedimension='$jajedimension',jajefingersize='$jajefingersize',jadiaweight='$jadiaweight',jadiashap='$jadiashap',jadialab='$jadialab',jadiacolor='$jadiacolor',jadiaclarity='$jadiaclarity',jadiacut='$jadiacut',jadaipolish='$jadaipolish',jadiasymmetry='$jadiasymmetry',jadiafluor='$jadiafluor',jadiatable='$jadiatable',jadiadepth='$jadiadepth',jadiameasurment='$jadiameasurment',jadiaremarks='$jadiaremarks',jadiapercarat='$jadiapercarat',jadiatotalprice='$jadiatotalprice',jagemcarat='$jagemcarat',jagemstonetype='$jagemstonetype',jagemshape='$jagemshape',jagemcolor='$jagemcolor',jagemclarity='$jagemclarity',jagemcut='$jagemcut',jagemorigin='$jagemorigin',jagemtreatment='$jagemtreatment',jagemlab='$jagemlab',jagemremarks='$jagemremarks',jawatbrand='$jawatbrand',jawatmodel='$jawatmodel',jawatgender='$jawatgender',jawatage='$jawatage',jawatfeatures='$jawatfeatures',jawatfeatures1='$jawatfeatures1',jawatfeatures2='$jawatfeatures2',jawatfeatures3='$jawatfeatures3',jawatmovement='$jawatmovement',jawatcase='$jawatcase',jawatband='$jawatband',jawatcarat='$jawatcarat',jawatbox='$jawatbox',jawatwarranty='$jawatwarranty',jawatremarks='$jawatremarks',jaobjbrandname='$jaobjbrandname',jaobjhall='$jaobjhall',jaobjperiod='$jaobjperiod',jaobjstyle='$jaobjstyle',jaobjmaterial='$jaobjmaterial',jaobjdimensions='$jaobjdimensions',jaobjweight='$jaobjweight',jaobjremarks='$jaobjremarks',watdim='$watdim',jawatdim='$jawatdim',status='$status',shipchargeint='$shipchargeint',shipchargedom='$shipchargedom',imagepath='$oldimagepath',seotitle='$seotitle',seojatitle='$seojatitle',keyword='$keywords',jakeyword='$jakeywords',seodescription='$seodescription',jaseodescription='$jaseodescription',eurl='$eurl'","id='$editid'");
		if(mysql_affected_rows()>0)
			$_SESSION["msg"]="Product Edit Successfully";
		else
			$_SESSION["msg"]="Product  not Edited Successfully";
	}
	else
	{
	 	$rowAffected=rs_update("product","catid='$catid',subcatid='$subcatid',title='$title',description='$gendescription',`condition`='$gencondiotion',stock='$genstock',productstock='$instock',price='$genprice',frontsection='$genfront',catshow='$gencatpic',brname='$brname',jehallmarks='$jehallmarks',jeperiod='$jeperiod',jediamond='$jediamond',jediamondcolor='$jediamondcolor',jediamondcl='$jediamondcl',jestoneweight='$jestoneweight',jestonecolor='$jestonecolor',jestonecl='$jestonecl',jemetal='$jemetal',jemetailpu='$jemetailpu',jempriceweight='$jempriceweight',jedimension='$jedimension',jefingersize='$jefingersize',jeselect='$jeselect',diaweight='$diaweight',diashap='$diashap',dialab='$dialab',diacolor='$diacolor',diaclarity='$diaclarity',diacut='$diacut',daipolish='$daipolish',diasymmetry='$diasymmetry',diafluor='$diafluor',diatable='$diatable',diadepth='$diadepth',diameasurment='$diameasurment',diaremarks='$diaremarks',diapercarat='$diapercarat',diatotalprice='$diatotalprice',gemcarat='$gemcarat',gemstonetype='$gemstonetype',gemshape='$gemshape',gemcolor='$gemcolor',gemclarity='$gemclarity',gemcut='$gemcut',gemorigin='$gemorigin',gemtreatment='$gemtreatment',gemlab='$gemlab',gemremarks='$gemremarks',watbrand='$watbrand',watmodel='$watmodel',watgender='$watgender',watage='$watage',watfeatures='$watfeatures',watfeatures1='$watfeatures1',watfeatures2='$watfeatures2',watfeatures3='$watfeatures3',watmovement='$watmovement',watcase='$watcase',watband='$watband',watcarat='$watcarat',watbox='$watbox',watwarranty='$watwarranty',watremarks='$watremarks',watdim='$watdim', objbrandname='$objbrandname',objhall='$objhall',objperiod='$objperiod',objstyle='$objstyle',objmaterial='$objmaterial',objdimensions='$objdimensions',objweight='$objweight',objremarks='$objremarks',jatitle='$jatitle',jadescription='$jagendescription',`jacondition`='$jagencondiotion',jastock='$jagenstock',japrice='$jagenprice',jabrname='$jabrname',jajehallmarks='$jajehallmarks',jajeperiod='$jajeperiod',jajediamond='$jajediamond',jajediamondcolor='$jajediamondcolor',jajediamondcl='$jajediamondcl',jajestoneweight='$jajestoneweight',jajestonecolor='$jajestonecolor',jajestonecl='$jajestonecl',jajemetal='$jajemetal',jajemetailpu='$jajemetailpu',jajempriceweight='$jajempriceweight',jajedimension='$jajedimension',jajefingersize='$jajefingersize',jadiaweight='$jadiaweight',jadiashap='$jadiashap',jadialab='$jadialab',jadiacolor='$jadiacolor',jadiaclarity='$jadiaclarity',jadiacut='$jadiacut',jadaipolish='$jadaipolish',jadiasymmetry='$jadiasymmetry',jadiafluor='$jadiafluor',jadiatable='$jadiatable',jadiadepth='$jadiadepth',jadiameasurment='$jadiameasurment',jadiaremarks='$jadiaremarks',jadiapercarat='$jadiapercarat',jadiatotalprice='$jadiatotalprice',jagemcarat='$jagemcarat',jagemstonetype='$jagemstonetype',jagemshape='$jagemshape',jagemcolor='$jagemcolor',jagemclarity='$jagemclarity',jagemcut='$jagemcut',jagemorigin='$jagemorigin',jagemtreatment='$jagemtreatment',jagemlab='$jagemlab',jagemremarks='$jagemremarks',jawatbrand='$jawatbrand',jawatmodel='$jawatmodel',jawatgender='$jawatgender',jawatage='$jawatage',jawatfeatures='$jawatfeatures',jawatfeatures1='$jawatfeatures1',jawatfeatures2='$jawatfeatures2',jawatfeatures3='$jawatfeatures3',jawatmovement='$jawatmovement',jawatcase='$jawatcase',jawatband='$jawatband',jawatcarat='$jawatcarat',jawatbox='$jawatbox',jawatwarranty='$jawatwarranty',jawatremarks='$jawatremarks',jaobjbrandname='$jaobjbrandname',jaobjhall='$jaobjhall',jaobjperiod='$jaobjperiod',jaobjstyle='$jaobjstyle',jaobjmaterial='$jaobjmaterial',jaobjdimensions='$jaobjdimensions',jawatdim='$jawatdim',jaobjweight='$jaobjweight',jaobjremarks='$jaobjremarks',status='$status',shipchargeint='$shipchargeint',shipchargedom='$shipchargedom',imagepath='$oldimagepath',seotitle='$seotitle',seojatitle='$seojatitle',keyword='$keywords',jakeyword='$jakeywords',seodescription='$seodescription',jaseodescription='$jaseodescription',eurl='$eurl'","id='$editid'");
	if(mysql_affected_rows()>0)
		$_SESSION["msg"]="Product Edit Successfully";
	else
		$_SESSION["msg"]="Product  not Edited Successfully";
	}
	$chk = $_POST['box'];
	if(!empty($chk))
	{
		for($i=0;$i<sizeof($chk); $i++)
		{
			$update_id = $chk[$i];
			$order_item=mysql_real_escape_string($_REQUEST["order_item_".$update_id]);
			$order_value=mysql_real_escape_string($_REQUEST["order_value_".$update_id]);
			$jaorder_item=mysql_real_escape_string($_REQUEST["jaorder_item_".$update_id]);
			$jaorder_value=mysql_real_escape_string($_REQUEST["jaorder_value_".$update_id]);
			if($order_item!='' && $order_value!='' && $jaorder_item!='' && $jaorder_value!='')
			{
				
				$flag1 = isFoundMore("moreproduct","fieldname='".$order_item."' and fieldvalue='".$order_value."' and jafieldname='".$jaorder_item."' and jafieldvalue='".$jaorder_value."' and productid='$editid'");
				if(!$flag1)
				{
					$rowAffected1=rs_update("moreproduct","fieldname='".$order_item."',fieldvalue='".$order_value."',jafieldname='".$jaorder_item."',jafieldvalue='".$jaorder_value."'","id ='".$update_id."'");
					if(mysql_affected_rows()>0)
						$_SESSION["msg"]="Product Edit Successfully";
				}
			}
			else
			{
				$rowAffected1=rs_del("moreproduct","id ='".$update_id."'");
				$_SESSION["msg"]="Product Edit Successfully";
			}
		}
	}
	//header("Location:edit-product.php?catname=".$_REQUEST['catname']."&subcatname=".$_REQUEST['subcatname']."&productname=".$_REQUEST['id']);	
	//exit;
	echo"<script>window.location.href='edit-product.php?catname=".$_REQUEST['catname']."&subcatname=".$_REQUEST['subcatname']."&productname=".$_REQUEST['id']."';</script>";
	exit();
}

#####################################################################
############ Add More Field ####################
else if(isset($_REQUEST['addMoreField_x']))
{
 	$insertid = $_REQUEST['productname'];
	$itemecount=$_REQUEST["itemecount"];
	for($i=0;$i<=$itemecount;$i++)
	{
		$order_item=mysql_real_escape_string($_REQUEST["order_item_".$i]);
		$order_value=mysql_real_escape_string($_REQUEST["order_value_".$i]);
		$jaorder_item=mysql_real_escape_string($_REQUEST["jaorder_item_".$i]);
		$jaorder_value=mysql_real_escape_string($_REQUEST["jaorder_value_".$i]);
		if($order_item!='' && $order_value!='' && $jaorder_item!='' && $jaorder_value!='')
		{
			$flag1 = isFoundMore("moreproduct","fieldname='$order_item' and fieldvalue='$order_value' and jafieldname='ja$order_item' and jafieldvalue='$jaorder_value' and productid='$insertid'");
			if(!$flag1)
			{
				$rowAffected1=rs_insert("moreproduct","fieldname,fieldvalue,jafieldname,jafieldvalue,productid","'$order_item','$order_value','$order_item','$order_value','$insertid'");
				if(mysql_affected_rows()>0)
				{
					$_SESSION["msg"]="Product Field Added Successfully";
				}
			}
			else
			{
				$_SESSION["msg"]="Product Field Already Exits";
			}
		}
	}
	//header("Location:add-morefield.php?productname=".$insertid);
	///exit;
	echo"<script>window.location.href='manage-morefield.php?productname=".$insertid."';</script>";
	exit();
}
else if(isset($_REQUEST['editMoreField_x']))
{
 	$insertid = $_REQUEST['productname'];
	$fieldid=$_REQUEST["fieldid"];
	$order_item=mysql_real_escape_string($_REQUEST["order_item_0"]);
	$order_value=mysql_real_escape_string($_REQUEST["order_value_0"]);
	$jaorder_item=mysql_real_escape_string($_REQUEST["jaorder_item_0"]);
	$jaorder_value=mysql_real_escape_string($_REQUEST["jaorder_value_0"]);
	if($order_item!='' && $order_value!='')
	{
		$flag1 = isFoundMore("moreproduct","fieldname='$order_item' and fieldvalue='$order_value' and jafieldname='ja$order_item' and jafieldvalue='$jaorder_value' and productid='$insertid'");
		if(!$flag1)
		{
			$rowAffected1=rs_update("moreproduct","fieldname='$order_item',fieldvalue='$order_value',jafieldname='$jaorder_item',jafieldvalue='$jaorder_value'","id = '".$fieldid."'");
			if(mysql_affected_rows()>0)
			{
				$_SESSION["msg"]="Product Field Updated Successfully";
			}
			else
			{
				$_SESSION["msg"]="Product Field not Updated Successfully";
			}
		}
		else
		{
			$_SESSION["msg"]="Product Field Already Exits";
		}
	}
	//header("Location:manage-morefield.php?productname=".$insertid);
	//exit;
	echo"<script>window.location.href='manage-morefield.php?productname=".$insertid."';</script>";
	exit();
}
else if(isset($_REQUEST['deltemorefield_x']))
{
 	$insertid = $_REQUEST['productname'];
	$chk = $_POST['box'];
	if(!empty($chk))
	{
		for($i=0;$i<sizeof($chk); $i++)
		{
			$del_id = $chk[$i];
			$delqr=rs_del("moreproduct","id='".$del_id."'");
			if($delqr)
				$_SESSION['msg'] = "Product Field Deleted Successfully";
			else
				$_SESSION['msg'] = "Product Field not Deleted  Sucessfully";
		}
	}
	else
	{
		$_SESSION['msg'] = "Tick any Checkbox";
		
	}
	//header("Location:manage-morefield.php?productname=".$insertid);
	//exit;
	echo"<script>window.location.href='manage-morefield.php?productname=".$insertid."';</script>";
	exit();
}

#//////////////////// ADD Product Gallery In Table db_image
else if(isset($_REQUEST['addGallery_x']))
{
	$productid = mysql_real_escape_string(trim($_REQUEST['productid']));
	if (($_FILES['subimage']['type'] == 'image/gif')
	|| ($_FILES['subimage']['type'] == 'image/jpg')
	|| ($_FILES['subimage']['type'] == 'image/jpeg')
	|| ($_FILES['subimage']['type'] == 'image/pjpeg')
	&& ($_FILES['subimage']['size'] / 1024 < 2000))
	{
		$img_name=time(). $_FILES['subimage']['name'];
		if(move_uploaded_file($_FILES['subimage']['tmp_name'],$imagepath.$img_name))
		{
			$flag1 = resize_actual($imagepath.$img_name, $imagelist.$img_name, 71,71);
			$rowAffected=rs_insert("db_image","productid,imagepath","'$productid','$img_name'");
			if(mysql_affected_rows()>0)
			{
				$_SESSION["msg"]="Image Added Successfully";
			}
			else
			{
				$_SESSION["msg"] ="Image not Added Successfully";
			}
		}
		else
		{
			$_SESSION["msg"] =" Image not uploaded Successfully";
		}
	}
	else
	{
		$_SESSION["msg"] ="Image Size/Format Excecption";
	}
	//header("Location:add-gallery.php?productname=".$productid);
	//exit;
	echo"<script>window.location.href='add-gallery.php?productname=".$productid."';</script>";
	exit();
} 
#------------------------------------------------------------------------------------------------------------------------------#
#******************** Delete the Gallery *******************************
else if(isset($_REQUEST['delteimage_x']))
{
	$chk = $_POST['box'];
	if(!empty($chk))
	{
		for($i=0;$i<sizeof($chk); $i++)
		{
			$del_id = $chk[$i];
			$res = rs_select_con("db_image","id='".$del_id."'");
			$imgdata = mysql_fetch_assoc($res);
			if(unlink($imagepath.$imgdata['imagepath']))
			{
				@unlink($imagelist.$imgdata['imagepath']);
				$delqr=rs_del("db_image","id='".$del_id."'");
				if($delqr)
				{
					$_SESSION['msg'] = "Product Gallery Image Deleted Successfully";
				}
				else
				{
					$_SESSION['msg'] = "Product Gallery Image Deleted  Sucessfully";
				}
			}
		}
	}
	else
	{
		$_SESSION['msg'] = "Tick any Checkbox";
		
	}
	//header("Location:list-subcategory.php");	
	//exit;
	echo"<script>window.location.href='list-subcategory.php';</script>";
	exit();
}

#//////////////////// ADD Product Gallery In Table db_image
else if(isset($_REQUEST['editGallery_x']))
{
	$productid = mysql_real_escape_string(trim($_REQUEST['productid']));
	$id = mysql_real_escape_string(trim($_REQUEST['imagename']));
	$res = rs_select_con("db_image","id='".$id."'");
	$imgdata = mysql_fetch_assoc($res);
	if(unlink($imagepath.$imgdata['imagepath']))
	{
		@unlink($imagelist.$imgdata['imagepath']);
		if (($_FILES['subimage']['type'] == 'image/gif')
		|| ($_FILES['subimage']['type'] == 'image/jpg')
		|| ($_FILES['subimage']['type'] == 'image/jpeg')
		|| ($_FILES['subimage']['type'] == 'image/pjpeg')
		&& ($_FILES['subimage']['size'] / 1024 < 2000))
		{
			$img_name=time(). $_FILES['subimage']['name'];
			if(move_uploaded_file($_FILES['subimage']['tmp_name'],$imagepath.$img_name))
			{
				$flag1 = resize_actual($imagepath.$img_name, $imagelist.$img_name, 71,71);
				$rowAffected=rs_update("db_image","imagepath='$img_name'","id='".$id."'");
				if(mysql_affected_rows()>0)
				{
					$_SESSION["msg"]="Image updateded Successfully";
				}
				else
				{
					$_SESSION["msg"] ="Image not updateded Successfully";
				}
			}
			else
			{
				$_SESSION["msg"] =" Image not uploaded Successfully";
			}
		}
		else
		{
			$_SESSION["msg"] ="Image Size/Format Excecption";
		}
	}
	else
	{
		$_SESSION["msg"] =" Image not Deleted Successfully";
	}
	//header("Location:manage-gallery.php?productname=".$productid);
	//exit;
	echo"<script>window.location.href='manage-gallery.php?productname=".$productid."';</script>";
	exit();
} 

#******************** Delete the User *******************************
else if(isset($_REQUEST['delteuserord_x']))
{
	$chk = $_POST['box'];
	if(!empty($chk))
	{
		for($i=0;$i<sizeof($chk); $i++)
		{
			$del_id = $chk[$i];
			$res = rs_select_con("itemorder","userid='".$del_id."'");
			while($imgdata = mysql_fetch_assoc($res))
			{
			$odrnum=$imgdata['order_number'];
			$delqr=rs_del("item_order_detail","order_number='".$odrnum."'");
			}
			$delqr=rs_del("itemorder","userid='".$del_id."'");
			$delqr=rs_del("shipbilldetail","userid='".$del_id."'");
			$delqr=rs_del("customer","id='".$del_id."'");
				if($delqr)
				{
					$_SESSION['msg'] = "User Deleted Successfully";
				}
				else
				{
					$_SESSION['msg'] = "User Not Deleted";
				}
		}
	}
	else
	{
		$_SESSION['msg'] = "Tick any Checkbox";
		
	}
	//header("Location:list-users.php");	
	//exit;
	echo"<script>window.location.href='list-users.php';</script>";
	exit();
}
else if(isset($_REQUEST['delteuserorder_x']))
{
	$chk = $_POST['box'];
	if(!empty($chk))
	{
		for($i=0;$i<sizeof($chk); $i++)
		{
			$del_id = $chk[$i];
			$delqr=rs_del("itemorder","order_number='".$del_id."'");
			$delqr=rs_del("item_order_detail","order_number='".$del_id."'");
				if($delqr)
				{
					$_SESSION['msg'] = "Order Deleted Successfully";
				}
				else
				{
					$_SESSION['msg'] = "Order Not Deleted";
				}
		}
	}
	else
	{
		$_SESSION['msg'] = "Tick any Checkbox";
		
	}
	//header("Location:list-orders.php");	
	//exit;
	echo"<script>window.location.href='list-orders.php';</script>";
	exit();
}
else if(isset($_REQUEST['query']) && $_REQUEST['query']=='shipstat')
{
	$odrnum = $_REQUEST['odrnum'];
	$statval = $_REQUEST['statval'];
			$upshiporder=mysql_query("update itemorder set shipping_staus='$statval',shipdate='".date("Y-m-d")."' where id='$odrnum'");
				if($upshiporder)
				{
					$_SESSION['msg'] = "Shipping Status Changed Successfully";
				}
				else
				{
					$_SESSION['msg'] = "Shipping Status Not Changed";
				}
	//header("Location:list-orders.php");	
	//exit;
	echo"<script>window.location.href='list-orders.php';</script>";
	exit();
}
#------------------------------------------------------------------------------------------------------------------------------#
#******************* Update mailing list Status(Active) **********
else if(isset($_REQUEST['publishmlist_x']))
{
	$chk = $_POST['box'];
	if(!empty($chk))
	{
		for($i=0;$i<sizeof($chk); $i++)
		{
			$del_id = $chk[$i];
			$result = rs_select("tbl_subscription where id = '$del_id'", "sstatus");
			while($updateresult= mysql_fetch_assoc($result))
			{
				if($updateresult['sstatus']=="N")
					$rowAffected=mysql_query("update tbl_subscription SET sstatus = 'Y' where id = '$del_id'") or die(mysql_error());
				else
					$rowAffected=mysql_query("update tbl_subscription SET sstatus = 'N' where id = '$del_id'") or die(mysql_error());
			}
			if(mysql_affected_rows()>0)
				$_SESSION["msg"]="Mailing List Status Update Successfully";
			else
				$_SESSION["msg"]="Mailing List  Status not Update  Successfully";		
		}
	}
	else
	{
		$_SESSION['msg'] = "Tick any Checkbox";
		
	}
	//header("Location: managesubscribeuser.php");	
	//exit;	
	echo"<script>window.location.href='managesubscribeuser.php';</script>";
	exit();
}
#------------------------------------------------------------------------------------------------------------------------------#
#******************** Delete the mailing list *******************************
else if(isset($_REQUEST['deltemlist_x']))
{
	$chk = $_POST['box'];
	if(!empty($chk))
	{
		for($i=0;$i<sizeof($chk); $i++)
		{
			$del_id = $chk[$i];
			$delqr=rs_del("tbl_subscription","id='".$del_id."'");
			if($delqr)
				$_SESSION['msg'] = "Mailing List Deleted Successfully";
			else
				$_SESSION['msg'] = "Mailing List not Deleted  Sucessfully";
		}
	}
	else
	{
		$_SESSION['msg'] = "Tick any Checkbox";
		
	}
	//header("Location: managesubscribeuser.php");	
	//exit;
	echo"<script>window.location.href='managesubscribeuser.php';</script>";
	exit();
}
?>
