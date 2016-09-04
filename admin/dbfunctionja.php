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
include("../include/connect.php");
$user_id = $_SESSION['AdminId'];
$MAX_IMAGE_FILE=5;

$imagepath = "../gallery/large/";
$imagelist = "../gallery/list/";
$date = date("Y-m-d");
#************** Add new Category ****************#
/////////////////////////////////////// Add New Category ///////////////////////
if(isset($_REQUEST['catadd_x']))
{
	$catname = mysql_real_escape_string(trim($_REQUEST['textfield22']));
	$rcatname = mysql_real_escape_string(trim($_REQUEST['textfield122']));
	$status	= $_REQUEST['checkbox']!=""?"Y":"N";
	
	$flag = isFound("ja_category","catname",$catname);
	if($flag)
	{
		$_SESSION["msg"]="Product Category Already Exits";	
	}
	else
	{
		$rowAffected=rs_insert("ja_category","catname,status","'$catname','$status'");
		if(mysql_affected_rows()>0)
		{
			$_SESSION["msg"]="Product Category Added Successfully";
		}
		else
		{
			$_SESSION["msg"]="Product Category not Added Successfully";
		}
	}
	header("Location:add-category-ja.php");	
	exit;
}

else if($_REQUEST['catedit_x'])
{
	$page = $_REQUEST['page'];
	$catname = mysql_real_escape_string(trim($_REQUEST['textfield22']));
	$rcatname = mysql_real_escape_string(trim($_REQUEST['textfield122']));
	$status	= $_REQUEST['checkbox']!=""?"Y":"N";
	$id = $_REQUEST['id'];
	$flag = isFound("ja_category","catname",$catname);
	if($flag)
	{
		$rowAffected=rs_update("ja_category","status='$status' ","id = '$id'");
		if(mysql_affected_rows()>0)
		{
			$_SESSION["msg"]="Product Category Updated Successfully";
		}
		else
		{
			$_SESSION["msg"]="Product Category not Updated Successfully";
		}	
	}
	else
	{
		$rowAffected=rs_update("ja_category","catname='$catname',status='$status' ","id = '$id'");
		if(mysql_affected_rows()>0)
		{
			$_SESSION["msg"]="Product Category Updated Successfully";
		}
		else
		{
			$_SESSION["msg"]="Product Category not Updated Successfully";
		}
	}
	header("Location:list-category-ja.php?page=".$page);	
	exit;
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
			$result = rs_select("ja_category where id = '$del_id'", "status");
			while($updateresult= mysql_fetch_assoc($result))
			{
				if($updateresult['status']=="N")
					$rowAffected=mysql_query("update ja_category SET status = 'Y' where id = '$del_id'") or die(mysql_error());
				else
					$rowAffected=mysql_query("update ja_category SET status = 'N' where id = '$del_id'") or die(mysql_error());
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
	header("Location:list-category-ja.php");	
	exit;	
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
			$delqr=rs_del("ja_category","id='".$del_id."'");
			if($delqr)
				$_SESSION['msg'] = "Category Deleted Successfully";
			else
				$_SESSION['msg'] = "Category not Deleted  Sucessfully";
		}
	}
	else
	{
		$_SESSION['msg'] = "Tick any Checkbox";
		
	}
	header("Location:list-category-ja.php");	
	exit;
}

#////////////////// Add SubCategory in the database ///////////////////

else if (isset($_REQUEST['addsubcat_x']))
{
	$catid = $_REQUEST['selectcat'];
	$subcat = mysql_real_escape_string(trim($_REQUEST['textfield22']));
	$rsubcat = mysql_real_escape_string(trim($_REQUEST['textfield122']));
	$status	= $_REQUEST['checkbox']!=""?"Y":"N";
	$flag = isFoundMore("ja_subcategory","catid='$catid' and subcat='$subcat'");
	if($flag)
	{
		$_SESSION["msg"]="Product Sub Category Already Exits";
		header("Location:add-subcategory-ja.php");
		exit;	
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
				$rowAffected=rs_insert("ja_subcategory","catid,subcat,status,imagepath","'$catid','$subcat','$status','$img_name'");
				if(mysql_affected_rows()>0)
				{
					$_SESSION["msg"]="Product Sub Category Added Successfully";
					header("Location:add-subcategory-ja.php");	
					exit;
				}
				else
				{
					$_SESSION["msg"]="Product Sub Category not Added Successfully";
					header("Location:add-subcategory-ja.php");		
					exit;
				}
			}
			else
			{
				$_SESSION["msg"]="Product Sub Category Image not uploaded Successfully";
				header("Location:add-subcategory-ja.php");		
				exit;
			}
		}
		else
		{
			$_SESSION["msg"]="Image Size/Format Excecption";
			header("Location:add-subcategory-ja.php");
			exit;
		}
	}
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
			$result = rs_select("ja_subcategory where id = '$del_id'", "status");
			while($updateresult= mysql_fetch_assoc($result))
			{
				if($updateresult['status']=="N")
					$rowAffected=mysql_query("update ja_subcategory SET status = 'Y' where id = '$del_id'") or die(mysql_error());
				else
					$rowAffected=mysql_query("update ja_subcategory SET status = 'N' where id = '$del_id'") or die(mysql_error());
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
	header("Location:list-subcategory-ja.php");	
	exit;	
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
			$res = rs_select_con("ja_subcategory","id='".$del_id."'");
			$imgdata = mysql_fetch_assoc($res);
			if(unlink($imagepath.$imgdata['imagepath']))
			{
				@unlink($imagelist.$imgdata['imagepath']);
				$delqr=rs_del("ja_subcategory","id='".$del_id."'");
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
	header("Location:list-subcategory-ja.php");	
	exit;
}

#////////////////// Edit SubCategory ///////////////////
else if(isset($_REQUEST['editsubcat_x']))
{
 	$editid = $_REQUEST['editid'];
	$page = $_REQUEST['page'];
	$catid = $_REQUEST['selectcat'];
	$catname = $_REQUEST['catname'];
	$subcat = mysql_real_escape_string(trim($_REQUEST['textfield22']));
	$rsubcat = mysql_real_escape_string(trim($_REQUEST['textfield122']));
	$status	= $_REQUEST['checkbox']!=""?"Y":"N";
	$flag = isFoundMore("ja_subcategory","catid='$catid' and subcat='$subcat'");
	if($flag)
	{
		$img = $_FILES['subimage']['name'];
		if($img)
		{
			$rs=mysql_query("select imagepath from ja_subcategory where id='$editid'") or die(mysql_error());
			$rsdata=mysql_fetch_array($rs);
			if (($_FILES['subimage']['type'] == 'image/gif')
			|| ($_FILES['subimage']['type'] == 'image/jpeg')
			|| ($_FILES['subimage']['type'] == 'image/png')
			|| ($_FILES['subimage']['type'] == 'image/pjpeg')
			&& ($_FILES['subimage']['size'] / 1024 < 2000))
			{
				if(unlink($imagepath.$rsdata["imagepath"]))
				{
					@unlink($imagelist.$rsdata["imagepath"]);
					$img_name=time(). $_FILES['subimage']['name'];
					if(move_uploaded_file($_FILES['subimage']['tmp_name'],$imagepath.$img_name))
					{
						$flag = resize_actual($imagepath.$img_name, $imagelist.$img_name, 200,179);
						$rowAffected=rs_update("ja_subcategory","status='$status',imagepath='$img_name'","id='$editid'");
						if(mysql_affected_rows()>0)
						{
							$_SESSION["msg"]="Product Sub Category Added Successfully";
							header("Location:view-list-subategory-ja.php?catname=".$catname);	
							exit;
						}
						else
						{
							$_SESSION["msg"]="Product Sub Category not Added Successfully";
							header("Location:edit-subcategory-ja.php?editid=".$editid."&page=".$page);		
							exit;
						}
					}
					else
					{
						$_SESSION["msg"]="Product Sub Category Image not uploaded Successfully";
						header("Location:edit-subcategory-ja.php?editid=".$editid."&page=".$page);		
						exit;
					}
				}
				else
				{
					$_SESSION["msg"]="Product Sub Category Image not Delected Successfully";
					header("Location:edit-subcategory.php-ja?editid=".$editid."&page=".$page);		
					exit;
				}
			}
			else
			{
				$_SESSION["msg"]="Image Size/Format Excecption";
				header("Location:edit-subcategory-ja.php?editid=".$editid."&page=".$page);
				exit;
			}	
		}
		else
		{
			$_SESSION["msg"]="Product Sub Category Already Exits";
			header("Location:edit-subcategory-ja.php?editid=".$editid."&page=".$page);
			exit;
		}	
	}
	else
	{
		$img = $_FILES['subimage']['name'];
		if($img)
		{
			$rs=mysql_query("select imagepath from ja_subcategory where id='$editid'") or die(mysql_error());
			$rsdata=mysql_fetch_array($rs);
			if (($_FILES['subimage']['type'] == 'image/gif')
			|| ($_FILES['subimage']['type'] == 'image/jpeg')
			|| ($_FILES['subimage']['type'] == 'image/png')
			|| ($_FILES['subimage']['type'] == 'image/pjpeg')
			&& ($_FILES['subimage']['size'] / 1024 < 2000))
			{
				if(unlink($imagepath.$rsdata["imagepath"]))
				{
					@unlink($imagelist.$rsdata["imagepath"]);
					$img_name=time(). $_FILES['subimage']['name'];
					if(move_uploaded_file($_FILES['subimage']['tmp_name'],$imagepath.$img_name))
					{
						$flag = resize_actual($imagepath.$img_name, $imagelist.$img_name, 200,179);
						$rowAffected=rs_update("ja_subcategory","catid='$catid',subcat='$subcat',status='$status',imagepath='$img_name'","id='$editid'");
						if(mysql_affected_rows()>0)
						{
							$_SESSION["msg"]="Product Sub Category Added Successfully";
							header("Location:view-list-subategory-ja.php?catname=".$catname);	
							exit;
						}
						else
						{
							$_SESSION["msg"]="Product Sub Category not Added Successfully";
							header("Location:edit-subcategory-ja.php?editid=".$editid."&page=".$page);		
							exit;
						}
					}
					else
					{
						$_SESSION["msg"]="Product Sub Category Image not uploaded Successfully";
						header("Location:edit-subcategory-ja.php?editid=".$editid."&page=".$page);		
						exit;
					}
				}
				else
				{
					$_SESSION["msg"]="Product Sub Category Image not Delected Successfully";
					header("Location:edit-subcategory-ja.php?editid=".$editid."&page=".$page);		
					exit;
				}
			}
			else
			{
				$_SESSION["msg"]="Image Size/Format Excecption";
				header("Location:edit-subcategory-ja.php?editid=".$editid."&page=".$page);
				exit;
			}	
		}
		else
		{
			$rowAffected=rs_update("ja_subcategory","catid='$catid',subcat='$subcat',status='$status'","id='$editid'");
			if(mysql_affected_rows()>0)
			{
				$_SESSION["msg"]="Product Sub Category Added Successfully";
				header("Location:edit-subcategory-ja.php?editid=".$editid."&page=".$page);	
				exit;
			}
			else
			{
				$_SESSION["msg"]="Product Sub Category not Added Successfully";
				header("Location:edit-subcategory-ja.php?editid=".$editid."&page=".$page);		
				exit;
			}
		}
	}
}

###########################################################################################################################



#*********************** ADD Home Description ************
else if(isset($_REQUEST['homesubmit_x']))
{
	$contact_us = mysql_real_escape_string(trim($_REQUEST['contact_us']));
	$contact_usr = mysql_real_escape_string(trim($_REQUEST['contact_usr']));
	$contactid = $_REQUEST['contactid'];
	$rowAffected = mysql_query("update home set homedesp = '$contact_us',ja_homedesp = '$contact_usr' where id = '".$contactid."'");// update
	if(mysql_affected_rows()>0)
	{
	 	$_SESSION["msg"] ="Home Page  Description Updated Successfully";
	}
	else
	{
		$_SESSION["msg"] ="Home page  Description Not Updated Successfully";
	}
	
	header("Location: home.php");		
	exit;
}
#*********************** ADD About us Description ************
else if(isset($_REQUEST['aboutsubmit_x']))
{
	$contact_us = mysql_real_escape_string(trim($_REQUEST['contact_us']));
	$contact_usr = mysql_real_escape_string(trim($_REQUEST['contact_usr']));
	$contactid = $_REQUEST['contactid'];
	$rowAffected = mysql_query("update aboutus set aboutdesp = '$contact_us',ja_aboutdesp = '$contact_usr' where id = '".$contactid."'");// update
	if(mysql_affected_rows()>0)
	{
	 	$_SESSION["msg"] ="About us  Description Updated Successfully";
	}
	else
	{
		$_SESSION["msg"] ="About us  Description Not Updated Successfully";
	}
	
	header("Location: about-us.php");		
	exit;
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
	
	header("Location: contact-us.php");		
	exit;
}

else if(isset($_REQUEST['addProduct_x']))
{
	$catid = mysql_real_escape_string(trim($_REQUEST['selectcat']));
	$subcatid = mysql_real_escape_string(trim($_REQUEST['selectsub']));
	$title = mysql_real_escape_string(trim($_REQUEST['title']));
	$gendescription = mysql_real_escape_string(trim($_REQUEST['gendescription']));
	$gencondiotion = mysql_real_escape_string(trim($_REQUEST['gencondiotion']));
	$genstock = mysql_real_escape_string(trim($_REQUEST['genstock']));
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
	$status	= $_REQUEST['objpublish']!=""?"Y":"N";
	$genfront	= $_REQUEST['genfront']!=""?"Y":"N";
	$gencatpic	= $_REQUEST['gencatpic']!=""?"Y":"N";
	
	 $itemecount=$_REQUEST["itemecount"];
	
	$flag = isFoundMore("ja_product","catid='$catid' and subcatid='$subcatid' and title = '$title'");
	if($flag)
	{
		$_SESSION["msg"]="Product  Already Exits";
		header("Location:add-product-ja.php");
		exit;	
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
				$rowAffected=rs_insert("ja_product","catid,subcatid,title,description,`condition`,imagepath,stock,price,frontsection,catshow,brname,jehallmarks,jeperiod,jediamond,jediamondcolor,jediamondcl,jestoneweight,jestonecolor,jestonecl,jemetal,jemetailpu,jempriceweight,jedimension,jefingersize,jeselect,diaweight,diashap,dialab,diacolor,diaclarity,diacut,daipolish,diasymmetry,diafluor,diatable,diadepth,diameasurment,diaremarks,diapercarat,diatotalprice,gemcarat,gemstonetype,gemshape,gemcolor,gemclarity,gemcut,gemorigin,gemtreatment,gemlab,gemremarks,watbrand,watmodel,watgender,watage,watfeatures,watfeatures1,watfeatures2,watfeatures3,watmovement,watcase,watband,watcarat,watbox,watwarranty,watremarks,objbrandname,objhall,objperiod,objstyle,objmaterial,objdimensions,objweight,objremarks,status","'$catid','$subcatid','$title','$gendescription','$gencondiotion','$img_name','$genstock','$genprice','$genfront','$gencatpic','$brname','$jehallmarks','$jeperiod','$jediamond', '$jediamondcolor','$jediamondcl','$jestoneweight','$jestonecolor','$jestonecl','$jemetal','$jemetailpu','$jempriceweight','$jedimension','$jefingersize','$jeselect','$diaweight','$diashap','$dialab','$diacolor','$diaclarity','$diacut','$daipolish','$diasymmetry','$diafluor','$diatable','$diadepth','$diameasurment','$diaremarks','$diapercarat','$diatotalprice','$gemcarat','$gemstonetype','$gemshape','$gemcolor','$gemclarity','$gemcut','$gemorigin','$gemtreatment','$gemlab','$gemremarks','$watbrand','$watmodel','$watgender','$watage',  '$watfeatures','$watfeatures1','$watfeatures2','$watfeatures3','$watmovement', '$watcase','$watband', '$watcarat','$watbox','$watwarranty','$watremarks', '$objbrandname','$objhall','$objperiod', '$objstyle','$objmaterial','$objdimensions', '$objweight','$objremarks','$status'");
				if(mysql_affected_rows()>0)
				{
					$_SESSION["msg"]="Product Added Successfully";
					$insertid = mysql_insert_id();
					for($i=0;$i<=$itemecount;$i++)
					{
						$order_item=mysql_real_escape_string($_REQUEST["order_item_".$i]);
						$order_value=mysql_real_escape_string($_REQUEST["order_value_".$i]);
						if($order_item!='' && $order_value!='')
						{
							$flag1 = isFoundMore("ja_moreproduct","fieldname='".$order_item."' and fieldvalue='".$order_value."' and productid='".$insertid."'");
							if(!$flag1)
							{
								$rowAffected1=rs_insert("ja_moreproduct","fieldname,fieldvalue,productid"," '".$order_item."','".$order_value."','".$insertid."'");
							}
						}
					}
					header("Location:add-product-ja.php");	
					exit;
				}
				else
				{
					$_SESSION["msg"]="Product not Added Successfully";
					header("Location:add-product-ja.php");		
					exit;
				}
			}
			else
			{
				$_SESSION["msg"]="Product Image not uploaded Successfully";
				header("Location:add-product-ja.php");		
				exit;
			}
		}
		else
		{
			$_SESSION["msg"]="Image Size/Format Excecption";
			header("Location:add-product-ja.php");
			exit;
		}
	}
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
			$result = rs_select("ja_product where id = '$del_id'", "status");
			while($updateresult= mysql_fetch_assoc($result))
			{
				if($updateresult['status']=="N")
					$rowAffected=mysql_query("update ja_product SET status = 'Y' where id = '$del_id'") or die(mysql_error());
				else
					$rowAffected=mysql_query("update ja_product SET status = 'N' where id = '$del_id'") or die(mysql_error());
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
	header("Location:view-products-ja.php?page=".$page."&catname=".$_REQUEST['catname']."&subcatname=".$_REQUEST['subcatname'] );	
	exit;	
}
#******************** Delete the Category *******************************
else if(isset($_REQUEST['delteproduct_x']))
{
	$page = $_REQUEST['page'];
	$chk = $_POST['box'];
	if(!empty($chk))
	{
		for($i=0;$i<sizeof($chk); $i++)
		{
			$del_id = $chk[$i];
			$res = rs_select_con("ja_product","id='".$del_id."'");
			$imgdata = mysql_fetch_assoc($res);
			if(unlink($imagepath.$imgdata['imagepath']))
			{
				@unlink($imagelist.$imgdata['imagepath']);
				$delqr=rs_del("ja_product","id='".$del_id."'");
				if($delqr)
				{
					$_SESSION['msg'] = "Product Deleted Successfully";
				}
				else
				{
					$_SESSION['msg'] = "Product not Deleted  Sucessfully";
				}
			}
		}
	}
	else
	{
		$_SESSION['msg'] = "Tick any Checkbox";
		
	}
	header("Location:view-products-ja.php?page=".$page."&catname=".$_REQUEST['catname']."&subcatname=".$_REQUEST['subcatname'] );	
	exit;
}

# /////////////////////// Edit Product //////////////////////
else if(isset($_REQUEST['editProduct_x']))
{
	$catid = mysql_real_escape_string(trim($_REQUEST['selectcat']));
	$subcatid = mysql_real_escape_string(trim($_REQUEST['selectsub']));
	$title = mysql_real_escape_string(trim($_REQUEST['title']));
	$gendescription = mysql_real_escape_string(trim($_REQUEST['gendescription']));
	$gencondiotion = mysql_real_escape_string(trim($_REQUEST['gencondiotion']));
	$genstock = mysql_real_escape_string(trim($_REQUEST['genstock']));
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
	$status	= $_REQUEST['objpublish']!=""?"Y":"N";
	$genfront	= $_REQUEST['genfront']!=""?"Y":"N";
	$gencatpic	= $_REQUEST['gencatpic']!=""?"Y":"N";
	
	$editid = $_REQUEST['id'];
	$page = $_REQUEST['page'];
	$flag = isFoundMore("ja_product","catid='$catid' and subcatid='$subcatid' and title = '$title'");
	if($flag)
	{
		$_SESSION["msg"]="Product Already Exits";
		$img = $_FILES['subimage']['name'];
		if($img)
		{
			$rs=mysql_query("select imagepath from ja_product where id='$editid'") or die(mysql_error());
			$rsdata=mysql_fetch_array($rs);
			if (($_FILES['subimage']['type'] == 'image/gif')
			|| ($_FILES['subimage']['type'] == 'image/jpeg')
			|| ($_FILES['subimage']['type'] == 'image/png')
			|| ($_FILES['subimage']['type'] == 'image/pjpeg')
			&& ($_FILES['subimage']['size'] / 1024 < 2000))
			{
				if(unlink($imagepath.$rsdata["imagepath"]))
				{
					@unlink($imagelist.$rsdata["imagepath"]);
					$img_name=time(). $_FILES['subimage']['name'];
					if(move_uploaded_file($_FILES['subimage']['tmp_name'],$imagepath.$img_name))
					{
						$flag = resize_actual($imagepath.$img_name, $imagelist.$img_name, 328,288);
						$rowAffected=rs_update("ja_product","description='$gendescription',`condition`='$gencondiotion',imagepath='$img_name',stock='$genstock',price='$genprice',frontsection='$genfront',catshow='$gencatpic',brname='$brname',jehallmarks='$jehallmarks',jeperiod='$jeperiod',jediamond='$jediamond',jediamondcolor='$jediamondcolor',jediamondcl='$jediamondcl',jestoneweight='$jestoneweight',jestonecolor='$jestonecolor',jestonecl='$jestonecl',jemetal='$jemetal',jemetailpu='$jemetailpu',jempriceweight='$jempriceweight',jedimension='$jedimension',jefingersize='$jefingersize',jeselect='$jeselect',diaweight='$diaweight',diashap='$diashap',dialab='$dialab',diacolor='$diacolor',diaclarity='$diaclarity',diacut='$diacut',daipolish='$daipolish',diasymmetry='$diasymmetry',diafluor='$diafluor',diatable='$diatable',diadepth='$diadepth',diameasurment='$diameasurment',diaremarks='$diaremarks',diapercarat='$diapercarat',diatotalprice='$diatotalprice',gemcarat='$gemcarat',gemstonetype='$gemstonetype',gemshape='$gemshape',gemcolor='$gemcolor',gemclarity='$gemclarity',gemcut='$gemcut',gemorigin='$gemorigin',gemtreatment='$gemtreatment',gemlab='$gemlab',gemremarks='$gemremarks',watbrand='$watbrand',watmodel='$watmodel',watgender='$watgender',watage='$watage',watfeatures='$watfeatures',watfeatures1='$watfeatures1',watfeatures2='$watfeatures2',watfeatures3='$watfeatures3',watmovement='$watmovement',watcase='$watcase',watband='$watband',watcarat='$watcarat',watbox='$watbox',watwarranty='$watwarranty',watremarks='$watremarks',objbrandname='$objbrandname',objhall='$objhall',objperiod='$objperiod',objstyle='$objstyle',objmaterial='$objmaterial',objdimensions='$objdimensions',objweight='$objweight',objremarks='$objremarks',status='$status'","id='$editid'");
						if(mysql_affected_rows()>0)
						{
							$_SESSION["msg"]="Product Edit Successfully";
						}
						else
						{
							$_SESSION["msg"]="Product not edited Successfully";
							
						}
					}
					else
					{
						$_SESSION["msg"]="Product Image not uploaded Successfully";
					}
				}
				else
				{
					$_SESSION["msg"]="Product Image not Delected Successfully";
				}
			}
			else
			{
				$_SESSION["msg"]="Image Size/Format Excecption";
			}	
		}
		else
		{
			$rowAffected=rs_update("ja_product","description='$gendescription',`condition`='$gencondiotion',stock='$genstock',price='$genprice',frontsection='$genfront',catshow='$gencatpic',brname='$brname',jehallmarks='$jehallmarks',jeperiod='$jeperiod',jediamond='$jediamond',jediamondcolor='$jediamondcolor',jediamondcl='$jediamondcl',jestoneweight='$jestoneweight',jestonecolor='$jestonecolor',jestonecl='$jestonecl',jemetal='$jemetal',jemetailpu='$jemetailpu',jempriceweight='$jempriceweight',jedimension='$jedimension',jefingersize='$jefingersize',jeselect='$jeselect',diaweight='$diaweight',diashap='$diashap',dialab='$dialab',diacolor='$diacolor',diaclarity='$diaclarity',diacut='$diacut',daipolish='$daipolish',diasymmetry='$diasymmetry',diafluor='$diafluor',diatable='$diatable',diadepth='$diadepth',diameasurment='$diameasurment',diaremarks='$diaremarks',diapercarat='$diapercarat',diatotalprice='$diatotalprice',gemcarat='$gemcarat',gemstonetype='$gemstonetype',gemshape='$gemshape',gemcolor='$gemcolor',gemclarity='$gemclarity',gemcut='$gemcut',gemorigin='$gemorigin',gemtreatment='$gemtreatment',gemlab='$gemlab',gemremarks='$gemremarks',watbrand='$watbrand',watmodel='$watmodel',watgender='$watgender',watage='$watage',watfeatures='$watfeatures',watfeatures1='$watfeatures1',watfeatures2='$watfeatures2',watfeatures3='$watfeatures3',watmovement='$watmovement',watcase='$watcase',watband='$watband',watcarat='$watcarat',watbox='$watbox',watwarranty='$watwarranty',watremarks='$watremarks',objbrandname='$objbrandname',objhall='$objhall',objperiod='$objperiod',objstyle='$objstyle',objmaterial='$objmaterial',objdimensions='$objdimensions',objweight='$objweight',objremarks='$objremarks',status='$status'","id='$editid'");
			if(mysql_affected_rows()>0)
			{
				$_SESSION["msg"]="Product Edit Successfully";
			}
			else
			{
				$_SESSION["msg"]="Product  not Edited Successfully";
			}
		}
	}
	else
	{
	 	$img = $_FILES['subimage']['name'];
		if($img)
		{
			$rs=mysql_query("select imagepath from ja_product where id='$editid'") or die(mysql_error());
			$rsdata=mysql_fetch_array($rs);
			if (($_FILES['subimage']['type'] == 'image/gif')
			|| ($_FILES['subimage']['type'] == 'image/jpeg')
			|| ($_FILES['subimage']['type'] == 'image/png')
			|| ($_FILES['subimage']['type'] == 'image/pjpeg')
			&& ($_FILES['subimage']['size'] / 1024 < 2000))
			{
				if(unlink($imagepath.$rsdata["imagepath"]))
				{
					@unlink($imagelist.$rsdata["imagepath"]);
					$img_name=time(). $_FILES['subimage']['name'];
					if(move_uploaded_file($_FILES['subimage']['tmp_name'],$imagepath.$img_name))
					{
						$rowAffected=rs_update("ja_product","catid='$catid',subcatid='$subcatid',title='$title',description='$gendescription',`condition`='$gencondiotion',imagepath='$img_name',stock='$genstock',price='$genprice',frontsection='$genfront',catshow='$gencatpic',brname='$brname',jehallmarks='$jehallmarks',jeperiod='$jeperiod',jediamond='$jediamond',jediamondcolor='$jediamondcolor',jediamondcl='$jediamondcl',jestoneweight='$jestoneweight',jestonecolor='$jestonecolor',jestonecl='$jestonecl',jemetal='$jemetal',jemetailpu='$jemetailpu',jempriceweight='$jempriceweight',jedimension='$jedimension',jefingersize='$jefingersize',jeselect='$jeselect',diaweight='$diaweight',diashap='$diashap',dialab='$dialab',diacolor='$diacolor',diaclarity='$diaclarity',diacut='$diacut',daipolish='$daipolish',diasymmetry='$diasymmetry',diafluor='$diafluor',diatable='$diatable',diadepth='$diadepth',diameasurment='$diameasurment',diaremarks='$diaremarks',diapercarat='$diapercarat',diatotalprice='$diatotalprice',gemcarat='$gemcarat',gemstonetype='$gemstonetype',gemshape='$gemshape',gemcolor='$gemcolor',gemclarity='$gemclarity',gemcut='$gemcut',gemorigin='$gemorigin',gemtreatment='$gemtreatment',gemlab='$gemlab',gemremarks='$gemremarks',watbrand='$watbrand',watmodel='$watmodel',watgender='$watgender',watage='$watage',watfeatures='$watfeatures',watfeatures1='$watfeatures1',watfeatures2='$watfeatures2',watfeatures3='$watfeatures3',watmovement='$watmovement',watcase='$watcase',watband='$watband',watcarat='$watcarat',watbox='$watbox',watwarranty='$watwarranty',watremarks='$watremarks',objbrandname='$objbrandname',objhall='$objhall',objperiod='$objperiod',objstyle='$objstyle',objmaterial='$objmaterial',objdimensions='$objdimensions',objweight='$objweight',objremarks='$objremarks',status='$status'","id='$editid'");
						if(mysql_affected_rows()>0)
						{
							$_SESSION["msg"]="Product Edit Successfully";
						}
						else
						{
							$_SESSION["msg"]="Product not edited Successfully";
							
						}
					}
					else
					{
						$_SESSION["msg"]="Product Image not uploaded Successfully";
					}
				}
				else
				{
					$_SESSION["msg"]="Product Image not Delected Successfully";
				}
			}
			else
			{
				$_SESSION["msg"]="Image Size/Format Excecption";
			}	
		}
		else
		{
			$rowAffected=rs_update("ja_product","catid='$catid',subcatid='$subcatid',title='$title',description='$gendescription',`condition`='$gencondiotion',stock='$genstock',price='$genprice',frontsection='$genfront',catshow='$gencatpic',brname='$brname',jehallmarks='$jehallmarks',jeperiod='$jeperiod',jediamond='$jediamond',jediamondcolor='$jediamondcolor',jediamondcl='$jediamondcl',jestoneweight='$jestoneweight',jestonecolor='$jestonecolor',jestonecl='$jestonecl',jemetal='$jemetal',jemetailpu='$jemetailpu',jempriceweight='$jempriceweight',jedimension='$jedimension',jefingersize='$jefingersize',jeselect='$jeselect',diaweight='$diaweight',diashap='$diashap',dialab='$dialab',diacolor='$diacolor',diaclarity='$diaclarity',diacut='$diacut',daipolish='$daipolish',diasymmetry='$diasymmetry',diafluor='$diafluor',diatable='$diatable',diadepth='$diadepth',diameasurment='$diameasurment',diaremarks='$diaremarks',diapercarat='$diapercarat',diatotalprice='$diatotalprice',gemcarat='$gemcarat',gemstonetype='$gemstonetype',gemshape='$gemshape',gemcolor='$gemcolor',gemclarity='$gemclarity',gemcut='$gemcut',gemorigin='$gemorigin',gemtreatment='$gemtreatment',gemlab='$gemlab',gemremarks='$gemremarks',watbrand='$watbrand',watmodel='$watmodel',watgender='$watgender',watage='$watage',watfeatures='$watfeatures',watfeatures1='$watfeatures1',watfeatures2='$watfeatures2',watfeatures3='$watfeatures3',watmovement='$watmovement',watcase='$watcase',watband='$watband',watcarat='$watcarat',watbox='$watbox',watwarranty='$watwarranty',watremarks='$watremarks',objbrandname='$objbrandname',objhall='$objhall',objperiod='$objperiod',objstyle='$objstyle',objmaterial='$objmaterial',objdimensions='$objdimensions',objweight='$objweight',objremarks='$objremarks',status='$status'","id='$editid'");
			if(mysql_affected_rows()>0)
			{
				$_SESSION["msg"]="Product Edit Successfully";
			}
			else
			{
				$_SESSION["msg"]="Product  not Edited Successfully";
			}
		}
	}
	$chk = $_POST['box'];
	if(!empty($chk))
	{
		for($i=0;$i<sizeof($chk); $i++)
		{
			$update_id = $chk[$i];
			$order_item=mysql_real_escape_string($_REQUEST["order_item_".$update_id]);
			$order_value=mysql_real_escape_string($_REQUEST["order_value_".$update_id]);
			if($order_item!='' && $order_value!='')
			{
				
				$flag1 = isFoundMore("ja_moreproduct","fieldname='".$order_item."' and fieldvalue='".$order_value."' and productid='$editid'");
				if(!$flag1)
				{
					$rowAffected1=rs_update("ja_moreproduct","fieldname='".$order_item."',fieldvalue='".$order_value."'","id ='".$update_id."'");
					if(mysql_affected_rows()>0)
					{
						$_SESSION["msg"]="Product Edit Successfully";
					}
				}
			}
			else
			{
				$rowAffected1=rs_del("ja_moreproduct","id ='".$update_id."'");
				$_SESSION["msg"]="Product Edit Successfully";
			}
		}
	}
	header("Location:edit-product-ja.php?catname=".$_REQUEST['catname']."&subcatname=".$_REQUEST['subcatname']."&productname=".$_REQUEST['id']);	
	exit;
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
		if($order_item!='' && $order_value!='')
		{
			$flag1 = isFoundMore("ja_moreproduct","fieldname='".$order_item."' and fieldvalue='".$order_value."' and productid='".$insertid."'");
			if(!$flag1)
			{
				$rowAffected1=rs_insert("ja_moreproduct","fieldname,fieldvalue,productid"," '".$order_item."','".$order_value."','".$insertid."'");
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
	header("Location:add-morefield-ja.php?productname=".$insertid);
	exit;
}
else if(isset($_REQUEST['editMoreField_x']))
{
 	$insertid = $_REQUEST['productname'];
	$fieldid=$_REQUEST["fieldid"];
	$order_item=mysql_real_escape_string($_REQUEST["order_item_0"]);
	$order_value=mysql_real_escape_string($_REQUEST["order_value_0"]);
	if($order_item!='' && $order_value!='')
	{
		$flag1 = isFoundMore("ja_moreproduct","fieldname='".$order_item."' and fieldvalue='".$order_value."' and productid = '".$insertid."'");
		if(!$flag1)
		{
			$rowAffected1=rs_update("ja_moreproduct","fieldname='".$order_item."',fieldvalue='".$order_value."'","id = '".$fieldid."'");
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
	header("Location:manage-morefield-ja.php?productname=".$insertid);
	exit;
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
			$delqr=rs_del("ja_moreproduct","id='".$del_id."'");
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
	header("Location:manage-morefield-ja.php?productname=".$insertid);
	exit;
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
			$rowAffected=rs_insert("ja_db_image","productid,imagepath","'$productid','$img_name'");
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
	header("Location:add-gallery-ja.php?productname=".$productid);
	exit;
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
			$res = rs_select_con("ja_db_image","id='".$del_id."'");
			$imgdata = mysql_fetch_assoc($res);
			if(unlink($imagepath.$imgdata['imagepath']))
			{
				@unlink($imagelist.$imgdata['imagepath']);
				$delqr=rs_del("ja_db_image","id='".$del_id."'");
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
	header("Location:list-subcategory-ja.php");	
	exit;
}

#//////////////////// ADD Product Gallery In Table db_image
else if(isset($_REQUEST['editGallery_x']))
{
	$productid = mysql_real_escape_string(trim($_REQUEST['productid']));
	$id = mysql_real_escape_string(trim($_REQUEST['imagename']));
	$res = rs_select_con("ja_db_image","id='".$id."'");
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
				$rowAffected=rs_update("ja_db_image","imagepath='$img_name'","id='".$id."'");
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
	header("Location:manage-gallery-ja.php?productname=".$productid);
	exit;
} 
#------------------------------------------------------------------------------------------------------------------------------#
?>
