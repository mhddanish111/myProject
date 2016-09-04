<?php
session_start();
#include("db.php");
#include("../include/connect.php");
# **************** Insert the Records from the Poll*******#
if(isset($_REQUEST['poll_summit_x']))
{
	$expire=time()+60*60*24;
	$poll_text_id = $_REQUEST['poll_text_id']; 
	$poll_text = stripslashes($_REQUEST['poll_text']);
	 $cook = split(" ", $poll_text);
	$cookie_new = $cook[0];
	$datetime = date("d-m-Y H:i:s");
	$radio_value=$_REQUEST['poll_ans'];
	#setcookie("vote", '$poll_text', $expire);
	# $_COOKIE[$cookie_new];
	
	if(!isset($_COOKIE[$cookie_new]) && !$_COOKIE[$cookie_new]==$cookie_new)
	{
		setcookie($cookie_new, $cookie_new, $expire);
		if($radio_value=="yes")
		{
			$rowAffected=mysql_query("update qa_poll_data set poll_yes= poll_yes+1, poll_ending_date = '$datetime' where poll_name_id='$poll_text_id'")or die('failed');
		}
		else if($radio_value=="no")
		{
			$rowAffected=mysql_query("update qa_poll_data set poll_no= poll_no+1, poll_ending_date = '$datetime' where poll_name_id='$poll_text_id'")or die('failed');
		}
		else 
		{
			$rowAffected=mysql_query("update qa_poll_data set poll_not= poll_not+1,poll_ending_date = '$datetime' where poll_name_id='$poll_text_id'")or die('failed');
		}
	}
	else
	{
		$_SESSION['select_vote_msg'] = "You have Already Voted ";
	}
	$_SESSION['select_poll_id'] = $poll_text_id;
	$_SESSION['select_poll'] = $poll_text;
	header("location:../poll.php");
}
?>