<?php
require_once 'DAL/Helper.php';
$SupplierName_Query = trim( Helper::GetManager()->GetParameterValue('SupplierName') );
$SupplierName = trim ( str_ireplace ('supplier is', '', $SupplierName_Query) );

$URL='https://sepilot.ssmcloud.com/emptoris-ws/v10_1_0_0/auth-token/SupplierService';
	$PostString='<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sup="http://supplier.v10_1_0_0.service.ssm.emptoris.ibm.com">
		<SOAP-ENV:Header/>
		<SOAP-ENV:Body>
			<sup:getSuppliers>
				<criteria>
					<returnBlockSize>100</returnBlockSize>
					<startingRow>0</startingRow>
					<wheres>
						<where xmlns:ns="http://criteria.type.v10_1_0_0.service.ssm.emptoris.ibm.com" xmlns:ns0="http://www.w3.org/2001/XMLSchema-instance" ns0:type="ns:whereMatchesString">
							<attribute>dataSource.name</attribute>
							<value>ECM</value>
						</where>
						<where xmlns:ns="http://criteria.type.v10_1_0_0.service.ssm.emptoris.ibm.com" xmlns:ns0="http://www.w3.org/2001/XMLSchema-instance" ns0:type="ns:whereContainsString">
							<attribute>companyName</attribute>
							<value>'.$SupplierName.'</value>
						</where>
					</wheres>
				</criteria>
			</sup:getSuppliers>
		</SOAP-ENV:Body>
	</SOAP-ENV:Envelope>';

$headers = array(
                 "Content-type: text/xml;charset=\"utf-8\"",
                 "Accept: text/xml",
                 "Cache-Control: no-cache",
                 "Pragma: no-cache",
                 "SOAPAction:;", 
                 "Content-length: ".strlen($PostString),
                 "Cookie: LtpaToken2=dMgGIHLQZ6nvgE36zJWv12gmi26WZGrjSB9MYSMnVGHABzj/lBQXiDSLUqkZiIr+XEOmjI3Q02308a5/RyI7gsIOqn2Gyk9VVyLen8dKnpPYTKNVgiWXBVw/NTnBFi5uWO4ulxUG0hFSI6ZYdPCc0rYIx23hEoGrxEk32RNFq+ofaLPp5ApZ0QpO/L6/fFgnNM66CuzubAHSTRDgP8x3fqZra/RAzYvdBbT3kAQ3gD9PQiTPU9nM5y+XJ8P3eHZ0x0RGpyY5ALqNm2UE/O4OSjRkM+16Z/cbtAVqp8LNZKOuoHw69i5HZdr+8JTT8TMs;  Domain=sepilot.ssmcloud.com;  Path=/; HttpOnly;Secure",
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

curl_setopt($SoapRequest, CURLOPT_HTTPHEADER, $headers); 
$SoapResponseXML	= curl_exec($SoapRequest);
curl_close($SoapRequest);

$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->loadXML($SoapResponseXML);

$i=0;
$arSupplierList = array();
while(is_object($elmSuppliers = $doc->getElementsByTagName("suppliers")->item($i)))
{
	foreach($elmSuppliers->childNodes as $Index=>$ndSupplier)
	{
		if($ndSupplier->nodeName=='supplier')
		{
			foreach($ndSupplier->childNodes as $subNodes)
			{
				$_COMPANY_NAME;
				$_INTERNAL_ID;
				$_ADDRESS_INTERNAL_ID;
				
				if ($subNodes->nodeName == "companyName")
				{
					$_COMPANY_NAME		= $subNodes->nodeValue;
					$arSupplierList[$Index]['Name']		= $_COMPANY_NAME;
				}
				else if ($subNodes->nodeName == "internalId")
				{
					$_INTERNAL_ID		= $subNodes->nodeValue;
					$arSupplierList[$Index]['Id']	= $_INTERNAL_ID;
				}
				else if ($subNodes->nodeName == "addresses")
				{
					foreach ($subNodes->childNodes as $ndAddresses)
					{
						foreach($ndAddresses->childNodes as $ndAddress)
						{
							if($ndAddress->nodeName == "internalId")
							{
								$_ADDRESS_INTERNAL_ID	= $ndAddress->nodeValue;
								$arSupplierList[$Index]['Address']		= $_ADDRESS_INTERNAL_ID;
							}
						}
					}
				}
			}
		}
	}
	$i++;
}
$JSON_CODE = json_encode( array_values( $arSupplierList ));
echo $JSON_CODE;
