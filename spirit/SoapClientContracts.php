<?php
require_once 'DAL/Helper.php';

$Agreement_Type				= Helper::GetManager()->GetParameterValue('Agreement_Type');
$Agreement_ExtParty			= Helper::GetManager()->GetParameterValue('Agreement_ExtParty');
$Agreement_ExtParty_Address	= Helper::GetManager()->GetParameterValue('Agreement_ExtParty_Address');
$Agreement_ExtParty_IntId	= Helper::GetManager()->GetParameterValue('Agreement_ExtParty_IntId');
$Agreement_IntParty			= Helper::GetManager()->GetParameterValue('Agreement_IntParty');
$Agreement_Start_Date		= Helper::GetManager()->GetParameterValue('Agreement_Start_Date');
$Agreement_End_Date			= Helper::GetManager()->GetParameterValue('Agreement_End_Date');
$Agreement_Scope			= Helper::GetManager()->GetParameterValue('Agreement_Scope');
$Agreement_FirstLetter		= substr(Helper::GetManager()->GetParameterValue('FirstName'), 0,1);
$Agreement_SecondLetter		= substr(Helper::GetManager()->GetParameterValue('LastName'), 0,1);
$objCurrentDateTime			= new DateTime();
$ContractNameTitle			= $Agreement_FirstLetter.$Agreement_SecondLetter." - contractRQ - ". $objCurrentDateTime->format('Y-m-d His');
$LtpaToken					= Helper::GetManager()->GetParameterValue('LtpaToken2');


$URL='https://sepilot.ssmcloud.com/webservices/services/ContractServices';
/*
$PostString='<?xml version="1.0" encoding="utf-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:con="http://www.dicarta.com/contracts/services/contract" xmlns:auth="http://www.dicarta.com/contracts/types/auth" xmlns:con1="http://www.dicarta.com/contracts/types/domain/contract">
   <soapenv:Header/>
   <soapenv:Body>
      <con:get-request>
         <con:authentication>
            <auth:user>nqureshi</auth:user>
            <auth:credential>
               <!--Optional:-->
               <auth:password>namnam1234</auth:password>
               <!--Optional:-->
             </auth:credential>
         </con:authentication>
         <con:request-data>
            <con1:id>2c07a5a80d384161beca6929cd94e0e9</con1:id>
         </con:request-data>
      </con:get-request>
   </soapenv:Body>
</soapenv:Envelope>';*/

$PostString='<?xml version="1.0" encoding="utf-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:con="http://www.dicarta.com/contracts/services/contract" xmlns:auth="http://www.dicarta.com/contracts/types/auth" xmlns:par="http://www.dicarta.com/contracts/types/domain/party" xmlns:add="http://www.dicarta.com/contracts/types/domain/address" xmlns:ind="http://www.dicarta.com/contracts/types/domain/individual" xmlns:cla="http://www.dicarta.com/contracts/types/domain/clause-template" xmlns:com="http://www.dicarta.com/contracts/types/domain/common" xmlns:cp="http://www.dicarta.com/contracts/types/domain/cp" xmlns:line="http://www.dicarta.com/contracts/types/domain/line" xmlns:con1="http://www.dicarta.com/contracts/types/domain/contract-template" xmlns:con2="http://www.dicarta.com/contracts/types/domain/contract">
   <soapenv:Header/>
   <soapenv:Body>
      <con:create-authored-contract-request>
         <con:authentication>
            <auth:user>kai</auth:user>
            <auth:credential>
               <auth:password>win3demo</auth:password>
            </auth:credential>
         </con:authentication>
         <con:request-data>
         	  <con:name>'.$ContractNameTitle.'</con:name>
            <con:title>'.$ContractNameTitle.'</con:title>
            <con:currency>USD</con:currency>
            <con:notes>Cognitive Contract Creation</con:notes>
            <con:effective-start-date>'.$Agreement_Start_Date.'</con:effective-start-date>
            <con:effective-end-date>'.$Agreement_End_Date.'</con:effective-end-date>
            <con:execution-date>'.$Agreement_Start_Date.'</con:execution-date>
            <con:region>North America</con:region>
            <con:internal-contact-id>684832e0848a4db4a1262ed596ab79a1</con:internal-contact-id>
            <con:internal-parties>
               <par:internal-party>
                  <par:party-id>dabaf1e8e6e54c7593f6c056d2493be6</par:party-id>
                  <par:party-name>Emptoris</par:party-name>
                  <par:role>Primary</par:role>
                  <par:primary-contact-id>684832e0848a4db4a1262ed596ab79a1</par:primary-contact-id>
                  <par:addresses>
                     <add:address-reference>
                        <add:id>c86bd4b56e804a279a3c8941583069d6</add:id>
                        <add:vsm-id>0</add:vsm-id>
                     </add:address-reference>
                  </par:addresses>
               </par:internal-party>
            </con:internal-parties>
            <con:external-parties>
               <par:external-party>
                  <par:party-type>Organization</par:party-type>
                  <par:external-party-unique-id>'.$Agreement_ExtParty_IntId.'</par:external-party-unique-id> <!-- SHOULD COME FROM <internalId>10141</internalId> -->
                  <par:party-name>'.$Agreement_ExtParty.'</par:party-name> <!--SHOULD COME FROM <companyName>Lenovo</companyName> -->
                  <par:role>Primary</par:role>
                  <par:addresses>
                     <add:address-reference>
                        <add:vsm-id>'.$Agreement_ExtParty_Address.'</add:vsm-id> <!-- SHOULD COME FROM <internalId>1801</internalId> -->
                     </add:address-reference>
                  </par:addresses>
               </par:external-party>
            </con:external-parties>
            <con:template-reference>
               <con1:id>'.$Agreement_Type.'</con1:id><!--Should come from hard code value in index.php> -->
            </con:template-reference>
            <con:category>Buy</con:category>
         </con:request-data>
      </con:create-authored-contract-request>
   </soapenv:Body>
</soapenv:Envelope>';

//echo $PostString;

// Ltpa token for tahir virk
$headers = array(
                 "Content-type: text/xml;charset=\"utf-8\"",
                 "Accept: text/xml",
                 "Cache-Control: no-cache",
                 "Pragma: no-cache",
                 "SOAPAction:;", 
                 "Content-length: ".strlen($PostString),
                 "Cookie: LtpaToken2=".$LtpaToken,
                 "Host: sepilot.ssmcloud.com"
    ); //SOAPAction: your op URL

$SoapRequest = curl_init(); 
curl_setopt($SoapRequest, CURLOPT_URL,            $URL );   
curl_setopt($SoapRequest, CURLOPT_CONNECTTIMEOUT, 10); 
curl_setopt($SoapRequest, CURLOPT_TIMEOUT,        10); 
curl_setopt($SoapRequest, CURLOPT_RETURNTRANSFER, true );
curl_setopt($SoapRequest, CURLOPT_SSL_VERIFYPEER, false);  
curl_setopt($SoapRequest, CURLOPT_SSL_VERIFYHOST, false); 
curl_setopt($SoapRequest, CURLOPT_POST,           true ); 
curl_setopt($SoapRequest, CURLOPT_POSTFIELDS,    $PostString);

//curl_setopt($SoapRequest, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml; charset=utf-8','SOAPAction:;', 'Content-Length: '.strlen($PostString) )); 

curl_setopt($SoapRequest, CURLOPT_HTTPHEADER, $headers); 

//curl_setopt($SoapRequest, CURLOPT_USERPWD, $Username . ":" . $Password);
$SoapResponseXML	= curl_exec($SoapRequest);
curl_close($SoapRequest);

$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->loadXML($SoapResponseXML);

$i=0;
$arResponse = array();
while(is_object($elmResponse = $doc->getElementsByTagName("response-data")->item($i)))
{
	foreach($elmResponse->childNodes as $Index=>$ndResponse)
	{
		$arResponse [$ndResponse->nodeName] = $ndResponse->nodeValue;
	}
	$i++;
}
$JSON_CODE = json_encode($arResponse);
echo $JSON_CODE;