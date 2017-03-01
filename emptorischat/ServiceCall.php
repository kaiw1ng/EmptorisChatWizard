<?php 
require_once 'DAL/Helper.php';

$QueryText				= Helper::GetManager()->GetParameterValue('Question');
$ConversationId			= Helper::GetManager()->GetParameterValue('ConversationId');
$DialogTurnCounter		= Helper::GetManager()->GetParameterValue('DialogTurnCounter');
$DialogRequestCounter	= Helper::GetManager()->GetParameterValue('DialogRequestCounter');
$DialogNode				= Helper::GetManager()->GetParameterValue('DialogNode');
$WS_UserName			= 'a6f668f2-9496-4193-82ad-edaf08ef7530';
$WS_Password			= 'sULxyWB3giZQ';
$WorkspaceID			= 'e7da64d1-9a7f-4dcb-89a7-a183fa19df42';

	if ($ConversationId !== "")
	{
		$QueryData = array(	'input' => array('text' => $QueryText), 'context' => array('conversation_id' => $ConversationId));
		$QueryData	= array (
							'input'		=> array( 'text' => $QueryText,),
							'context'	=> array( 'conversation_id' => $ConversationId, 'system' =>  array ('dialog_stack' =>  array ( 0 => $DialogNode,), 'dialog_turn_counter' => $DialogTurnCounter, ),),);
	}
	else
	{
		$QueryData = array('input' => array('text' => $QueryText));
	}
	$QueryData = json_encode($QueryData);
		
	$URL='https://gateway.watsonplatform.net/conversation/api/v1/workspaces/'.$WorkspaceID.'/message?version=2016-09-20';
 
    $Curl_Request = curl_init();
    curl_setopt($Curl_Request, CURLOPT_URL,$URL);
	curl_setopt($Curl_Request, CURLOPT_HEADER, false);
    curl_setopt($Curl_Request, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
    curl_setopt($Curl_Request, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($Curl_Request, CURLOPT_USERPWD, "$WS_UserName:$WS_Password");
	curl_setopt($Curl_Request, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($Curl_Request, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($Curl_Request, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($Curl_Request, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
    curl_setopt($Curl_Request, CURLOPT_POST, true);
    curl_setopt($Curl_Request, CURLOPT_POSTFIELDS, $QueryData);
	$InboundData = curl_exec($Curl_Request);		
	$JSON_Object = json_decode($InboundData,true);
	echo json_encode($JSON_Object, JSON_PRETTY_PRINT);
	 
?>