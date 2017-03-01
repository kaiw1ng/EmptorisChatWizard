<?php
require_once 'DAL/Helper.php';
$DateValue		=  Helper::GetManager()->GetParameterValue('CheckDate');
$ArrayOfDate	= date_parse($DateValue);

$Year			= $ArrayOfDate['year'];
if (strlen($ArrayOfDate['month']) === 1)
{
	$Month = '0'.$ArrayOfDate['month'];
}
else
{
	$Month = $ArrayOfDate['month'];
}

if (strlen($ArrayOfDate['day']) === 1)
{
	$Day = '0'.$ArrayOfDate['day'];
}
else
{
	$Day = $ArrayOfDate['day'];
}

echo $Year."-".$Month."-".$Day;
//$NewDate		= date('Y-m-d', mktime($ArrayOfDate['month'], $ArrayOfDate['day'], $ArrayOfDate['year']));
//echo $NewDate;
?>