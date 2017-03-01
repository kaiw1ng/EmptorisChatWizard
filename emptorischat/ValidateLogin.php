<?php
require ("DAL/Helper.php");

$Username = Helper::GetManager()->GetParameterValue('Username');
$Password = Helper::GetManager()->GetParameterValue('Password');
$TableName 	= "tblusers";
$Filters 	= array('Username' => $Username, 'Password'=> $Password);
$Resultset 	= Helper::GetManager()->SelectQuick($Filters, $TableName);

if(count($Resultset)>0)
{
	foreach ($Resultset as $Fields)
	{
		$IsActive 	= $Fields['IsActive'];
		$FirstName	= $Fields['FirstName'];
		$LastName	= $Fields['LastName'];
		$UserId 	= $Fields['UserId'];
		setcookie (COOKIE_USERID,	$UserId,	time()+336000);
		setcookie (COOKIE_FIRSTNAME,$FirstName,	time()+336000);
		setcookie (COOKIE_LASTNAME,	$LastName,	time()+336000);
		$Response['UserId'] 	= $UserId;
		$Response['IsActive'] 	= $IsActive;
		$Response['FirstName'] 	= $FirstName;
		$Response['LastName'] 	= $LastName;
	}
	echo json_encode($Response);
} 
else 
{
	$Response['IsActive']="Invalid username and/or password, please retry.";
	echo json_encode($Response);
}