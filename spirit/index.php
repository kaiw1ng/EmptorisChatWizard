<?php
require('DAL/Helper.php');
Helper::GetManager()->ValidateSession();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>IBM Emptoris Virtual Agent</title>
<!-- Bootstrap -->
<link href="dist/css/bootstrap.min.css" rel="stylesheet">
<link href="dist/css/emptoris_custom.css" rel="stylesheet">
<link href="dist/css/bootstrap-tagsinput.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body background="Design/night_sky.jpg">
<!--Alerts Section : Starts Here-->
<div id="AlertContainer" class="modal fade">
    <div class="modal-dialog" style="width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <button id="btnClose" name="btnClose" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="AlertTitle">Modal title</h4>
            </div>
			<div class="modal-message" id="AlertMessage" style="text-align: center;">&nbsp;</div>
            <div class="modal-body" style="max-height: calc(100vh - 150px); overflow-y: auto; min-width: 80%" id="AlertBox">One fine body</div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--Alerts Section : Starts Here-->
<!--Preloader : Starts Here-->
<div class="modal" id="Preloader" style="position: absolute; height: 50%; top: 35%; left: 25%; width: 50%; text-align: center; overflow: hidden">
    <div id="loading" class="loading" style="display: block;">
        <br /><br />
		<span class="loading-panel--description" id="PreloaderMessage" name="PreloaderMessage">Processing...</span>
        <div class="small">
            <div class="loading-panel">
            <div class="loading-panel--animation">
                <svg class="loading-panel--animation-graphics" viewBox="50 50 100 100">
                  <circle class="loading-panel--animation-circle" r="20" cy="100" cx="100"/>
                </svg>
            </div>
            </div>
        </div>
    </div>
</div>
<!--Preloader : Ends Here-->

<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
            		<span class="sr-only">Toggle navigation</span>
            		<span class="icon-bar"></span>
            		<span class="icon-bar"></span>
            		<span class="icon-bar"></span>
          		</button>
				<a class="navbar-brand" href="#"><li class="glyphicon glyphicon-home" >&nbsp;</li></a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">Powered by IBM Watson</a></li>
				</ul>
			</div>
		</div>
	</nav>
	
<div id="ContainerWrapper">
	
	<?php
	if (Helper::GetManager()->IsDebug() == TRUE)
	{?>
	<form id="frmSearch" name="frmSearch" method="post" action="ServiceCall.php">
		
	<?php }
	else 
	{?>
	<form id="frmSearch" name="frmSearch" method="post">
	<?php 
	}
	?>
		<div id="Sidebar">&nbsp;</div>
                <input type="hidden" name="LtpaToken2"					id="LtpaToken2" value="<?php echo $_COOKIE[COOKIE_LTPATOKEN]; ?>" />

			<input type="hidden" name="ConversationId"				id="ConversationId"			class="form-control" />
			<input type="hidden" name="DialogTurnCounter"			id="DialogTurnCounter"		class="form-control" />
			<input type="hidden" name="DialogRequestCounter"		id="DialogRequestCounter"	class="form-control" />
			<input type="hidden" name="DialogNode"					id="DialogNode"				class="form-control" />
			
			<input type="hidden" name="FirstName"					id="FirstName" value="<?php echo $_COOKIE[COOKIE_FIRSTNAME]; ?>" />
			<input type="hidden" name="LastName"					id="LastName" value="<?php echo $_COOKIE[COOKIE_LASTNAME]; ?>" />
			<input type="hidden" name="Agreement_Type"				id="Agreement_Type"	/>
			<input type="hidden" name="Agreement_ExtParty"			id="Agreement_ExtParty"	/>
			<input type="hidden" name="Agreement_ExtParty_Address"	id="Agreement_ExtParty_Address"/>
			<input type="hidden" name="Agreement_ExtParty_IntId"	id="Agreement_ExtParty_IntId"/>
			<input type="hidden" name="Agreement_IntParty"			id="Agreement_IntParty"	/>
			<input type="hidden" name="Agreement_Start_Date"		id="Agreement_Start_Date" />
			<input type="hidden" name="Agreement_End_Date"			id="Agreement_End_Date" />
			<input type="hidden" name="Agreement_Scope"				id="Agreement_Scope"
    
			<div id="MainSection">
				<h5 style="padding-top: 0px; padding-bottom: 0px;">
				<table border="0" width="100%">
					<tr>
						<td width="60%"><font color="white"><font color="black">_</font>IBM Emptoris Virtual Agent</font></td>
						<td  width="90%" style="text-align: right"><img alt="IBM Emptoris Virtual Agent" title="IBM Emptoris Virtual Agent" src="Design/AppLogo.png" /></td>
					</tr>
					<tr>
						<td colspan="2" style="font-size:18px">&nbsp;</td>
					</tr>
				</table>
				</h5>
				<div id="BodyPlaceHolder" name="BodyPlaceHolder" style="height: 65vh; overflow-x: auto">&nbsp;</div>
				<div class="ContentBox">
					<div class="container-fluid">
					
						<div class="row">
							<div class="col-md-12">
								<div class="clearfix">&nbsp;</div>
								
								<div class="input-group">
									<input type="text"  name="Question" spellcheck="true" id="Question" value="" class="QuestionBox" /> <span class="input-group-btn">
										<button id="btnEnter" style="visibility: hidden"	name="btnEnter" type="submit">Enter</button>
									</span>
								</div>
								<div class="clearfix">&nbsp;</div>
								<!--label id="TotalRecords"></label> <label id="WebServiceUrl"></label-->
							</div>
						</div>
					</div>
				</div>	
					
            
    </div>
</div>
		</form>
	</div>
	
<?php require('inclFooterJS.php'); ?>


        
<script>
	<?php 
	if (Helper::GetManager()->IsDebug() == FALSE)
	{?>
	$("#btnEnter").click(function()
{
	if ($("#Question").val() !== "")
	{
		var Question= $("#Question").val();
		var QDT		= new Date(Date.now()).toString();
		var	fQDT	= QDT.substring(4, QDT.indexOf('GMT') );
		var Message	= '<div class="container-fluid width:97%">';
			Message+= '	<div class="row">';
			Message+= '		<div class="col-xs-6 ChatQuestion" ><strong>You:&nbsp;&nbsp;</strong>'+Question+'</div>';
			Message+= '		<div class="col-xs-5" >&nbsp;</div>';
			Message+= '	</div>';
			Message+= '	<div class="row">';
			Message+= '		<div class="col-xs-6" style="font-size:xx-small; color:#999; text-align:right">'+fQDT+'</div>';
			Message+= '		<div class="col-xs-6">&nbsp;</div>';
			Message+= '	</div>'
			Message+= '</div>'
		$("#BodyPlaceHolder").append(Message);
		var FormData = $('#frmSearch').serializeArray();
		$("#Question").val("");
		$("#Question").attr('readonly','readonly');
		$.post('ServiceCall.php', FormData, function(JSONResponse) 
		{
			var Intent = JSONResponse.intents[0].intent;
			var Response = JSONResponse.output.text[0];
			if (Intent === 'greetings')
			{
				Response = Response.replace('Nauman',$("#FirstName").val())
			}
			if (Intent === 'int_agreement_start_date')
			{
				$('#Preloader').modal( { show: true, backdrop: 'static', keyboard: false, opacity:1 });
				$.post('ParseDate.php', {CheckDate:Question}, function(ResponseData)
				{
					$("#Agreement_Start_Date").val(ResponseData);
					$('#Preloader').modal('toggle');
				});
			}
			else if (Intent === 'int_agreement_end_date')
			{
				$('#Preloader').modal( { show: true, backdrop: 'static', keyboard: false, opacity:1 });
				$.post('ParseDate.php', {CheckDate:Question}, function(ResponseData)
				{
					$("#Agreement_End_Date").val(ResponseData);
					$('#Preloader').modal('toggle');
				});
				
			}
			else if (Intent === 'int_otherAgreement_sla')
			{
				$("#Agreement_Type").val("91bfd8f5eed6432e9ee18d25fca1defe");//Hard coding for the demo - MSLA template uid on SE Pilot  
			}
			else if (Intent === 'int_agreement_type')
			{
				$("#Agreement_Type").val("df181d2272244fdd805d2ab6de66ea90");//Hard coding for the demo - MPA template uid on SE Pilot  
			}
			else if (Intent === 'int_otherAgreement_msa')
			{
				$("#Agreement_Type").val("edb62d30aa454670bb9cdab5058c23ba");//Hard coding for the demo - MSA template uid on SE Pilot  
			}
			else if (Intent === 'int_otherAgreementCSA')
			{
				$("#Agreement_Type").val("1547f46052f34110b47582f48eeee7db");//Hard coding for the demo - MCSA template uid on SE Pilot  
			}
			else if (Intent === 'int_confirmTransfer')//intent when tranfer confirmed - below lines are not being used to search suppliers, just need to fail the check so the response returns link to stan :)
			{
				var DivHtml= "";
				$('#Preloader').modal( { show: true, backdrop: 'static', keyboard: false, opacity:1 });
                                var ltpa = $('#LtpaToken2').val();//$.cookie("LtpaToken2");
                                console.log("ltpa:" + ltpa);
				$.post('SoapClientSuppliers.php', {SupplierName:Question, LtpaToken:ltpa}, function(JSONResponseSuppliers)
				{
					var TotalResponses	= JSONResponseSuppliers.length;
					DivHtml= "";
					if (TotalResponses > 1)
					{
						$.each(JSONResponseSuppliers , function (objIndex, objValue)
						{
							var InternalId	= objValue['Id'];
							var SupplierName= objValue['Name'];
							var AddressId	= (objValue['Address'] === undefined ? '' : objValue['Address']);
							DivHtml+= '<div class="container-fluid">';
							DivHtml+= '	<div class="row" id="'+InternalId+'">';
							DivHtml+= '		<div class="col-xs-12" style="padding:5px 0px;">Did you mean '+SupplierName+'?';
							DivHtml+= '			<button type="button" name="'+SupplierName+'"  class="btn btn-sm btn-primary SupplierList" style="float:right; padding:2px 5px;" rel="'+AddressId+'" data="'+InternalId+'">Yes</button>';
							DivHtml+= '		</div>';
							DivHtml+= '	</div>';//row
							DivHtml+= '</div>';
						});
						$("#AlertTitle").html("Potential Suppliers");
						$("#AlertTitle").addClass("text-success");
						$("#btnClose").css('visibility','hidden');
						$('#AlertBox').addClass("text-success");
						$('#AlertBox').html(DivHtml);
						$('#AlertContainer').modal(
						{
							show: true,
							backdrop: 'static',
							keyboard: false
						});
					}
					else if (TotalResponses === 1)
					{
						$.each(JSONResponseSuppliers , function (objIndex, objValue)
						{
							var InternalId	= objValue['Id'];
							var SupplierName= objValue['Name'];
							var AddressId	= (objValue['Address'] === undefined ? '' : objValue['Address']);
							$("#Agreement_ExtParty").val(SupplierName);
							$("#Agreement_ExtParty_Address").val(AddressId);
							$("#Agreement_ExtParty_IntId").val(InternalId);
						});
					}
					else if (TotalResponses === 0)
					{
						var QDT			= new Date(Date.now()).toString();
						var	fQDT		= QDT.substring(4, QDT.indexOf('GMT') );
						var Response	= 'All set!  Please click on the following link to speak with my colleague about an NDA.';
						Response+= '<br /> <br/><a href="https://emptorischatwizard.mybluemix.net/emptoris-master/index.php" target="_blank">Stan can help!</a>'
						var MessageResp	= '<div class="container-fluid" style="width:97%">';
						MessageResp+= '	<div class="row">';
						MessageResp+= '		<div class="col-xs-6">&nbsp;</div>';
						MessageResp+= '		<div class="col-xs-6 ChatResponse"><strong>Watson:&nbsp;&nbsp;</strong>'+Response+'</div>';
						MessageResp+= '	</div>';
						MessageResp+= '	<div class="row">';
						MessageResp+= '		<div class="col-xs-6">&nbsp;</div>';
						MessageResp+= '		<div class="col-xs-6" style="font-size:xx-small; color:#999; text-align:right">'+fQDT+'</div>';
						MessageResp+= '	</div>'
						MessageResp+= '</div>';
						$("#BodyPlaceHolder").append(MessageResp);
						$("#ConversationId").val(JSONResponse.context.conversation_id);
						$("#DialogTurnCounter").val(JSONResponse.context.system.dialog_turn_counter);
						$("#DialogRequestCounter").val(JSONResponse.context.system.dialog_request_counter);
						$("#DialogNode").val(JSONResponse.context.system.dialog_stack[0].dialog_node);
						$("#Question").removeAttr('readonly');
						$('#Preloader').modal('toggle');
						return false;
					}
					$('#Preloader').modal('toggle');
				}, 'json');
			}
			else if (Intent === 'int_agreement_primext_party')
			{
				var DivHtml= "";
				$('#Preloader').modal( { show: true, backdrop: 'static', keyboard: false, opacity:1 });
                                var ltpa = $('#LtpaToken2').val();//$.cookie("LtpaToken2");
                                console.log("ltpa:" + ltpa);
				$.post('SoapClientSuppliers.php', {SupplierName:Question, LtpaToken:ltpa}, function(JSONResponseSuppliers)
				{
					var TotalResponses	= JSONResponseSuppliers.length;
					DivHtml= "";
					if (TotalResponses > 1)
					{
						$.each(JSONResponseSuppliers , function (objIndex, objValue)
						{
							var InternalId	= objValue['Id'];
							var SupplierName= objValue['Name'];
							var AddressId	= (objValue['Address'] === undefined ? '' : objValue['Address']);
							DivHtml+= '<div class="container-fluid">';
							DivHtml+= '	<div class="row" id="'+InternalId+'">';
							DivHtml+= '		<div class="col-xs-12" style="padding:5px 0px;">Did you mean '+SupplierName+'?';
							DivHtml+= '			<button type="button" name="'+SupplierName+'"  class="btn btn-sm btn-primary SupplierList" style="float:right; padding:2px 5px;" rel="'+AddressId+'" data="'+InternalId+'">Yes</button>';
							DivHtml+= '		</div>';
							DivHtml+= '	</div>';//row
							DivHtml+= '</div>';
						});
						$("#AlertTitle").html("Potential Suppliers");
						$("#AlertTitle").addClass("text-success");
						$("#btnClose").css('visibility','hidden');
						$('#AlertBox').addClass("text-success");
						$('#AlertBox').html(DivHtml);
						$('#AlertContainer').modal(
						{
							show: true,
							backdrop: 'static',
							keyboard: false
						});
					}
					else if (TotalResponses === 1)
					{
						$.each(JSONResponseSuppliers , function (objIndex, objValue)
						{
							var InternalId	= objValue['Id'];
							var SupplierName= objValue['Name'];
							var AddressId	= (objValue['Address'] === undefined ? '' : objValue['Address']);
							$("#Agreement_ExtParty").val(SupplierName);
							$("#Agreement_ExtParty_Address").val(AddressId);
							$("#Agreement_ExtParty_IntId").val(InternalId);
						});
					}
					else if (TotalResponses === 0)
					{
						var QDT			= new Date(Date.now()).toString();
						var	fQDT		= QDT.substring(4, QDT.indexOf('GMT') );
						var Response	= 'Sorry, there is no supplier record found for "'+Question+'". You may follow the URL below to add a Supplier record inline with your corporate policies.';
						Response+= '<br /> <a href="https://sepilot.ssmcloud.com/srm-app/ux/selfreg.html#/self-reg/" target="_blank">Supplier Self-Registration</a>'
						var MessageResp	= '<div class="container-fluid" style="width:97%">';
						MessageResp+= '	<div class="row">';
						MessageResp+= '		<div class="col-xs-6">&nbsp;</div>';
						MessageResp+= '		<div class="col-xs-6 ChatResponse"><strong>Watson:&nbsp;&nbsp;</strong>'+Response+'</div>';
						MessageResp+= '	</div>';
						MessageResp+= '	<div class="row">';
						MessageResp+= '		<div class="col-xs-6">&nbsp;</div>';
						MessageResp+= '		<div class="col-xs-6" style="font-size:xx-small; color:#999; text-align:right">'+fQDT+'</div>';
						MessageResp+= '	</div>'
						MessageResp+= '</div>';
						$("#BodyPlaceHolder").append(MessageResp);
						$("#ConversationId").val(JSONResponse.context.conversation_id);
						$("#DialogTurnCounter").val(JSONResponse.context.system.dialog_turn_counter);
						$("#DialogRequestCounter").val(JSONResponse.context.system.dialog_request_counter);
						$("#DialogNode").val(JSONResponse.context.system.dialog_stack[0].dialog_node);
						$("#Question").removeAttr('readonly');
						$('#Preloader').modal('toggle');
						return false;
					}
					$('#Preloader').modal('toggle');
				}, 'json');
			}
			else if (Intent === 'int_agreement_primint_contact')
			{
				
			}
			else if (Intent === 'int_agreement_scope')
			{
				var FormData = $('#frmSearch').serializeArray();
				$('#Preloader').modal( { show: true, backdrop: 'static', keyboard: false, opacity:1 });
				$.post('SoapClientContracts.php', FormData, function(JsonRecord) 
				{
						var QDT			= new Date(Date.now()).toString();
						var	fQDT		= QDT.substring(4, QDT.indexOf('GMT') );
						var ContractURL	= "https://sepilot.ssmcloud.com/dicarta/servereq?hname=cs_load_cs&summary=true&contractID="+JsonRecord['ns2:id'];
						var Response	= 'Success!, a new contract '+ JsonRecord['ns2:contract-number'] +' has been created as per the details provided. You may directly access this contract by clicking <a href="'+ContractURL+'" target="_blank">here</a>';
						var MessageResp	= '<div class="container-fluid" style="width:97%">';
							MessageResp+= '	<div class="row">';
							MessageResp+= '		<div class="col-xs-6">&nbsp;</div>';
							MessageResp+= '		<div class="col-xs-6 ChatResponse"><strong>Watson:&nbsp;&nbsp;</strong>'+Response+'</div>';
							MessageResp+= '	</div>';
							MessageResp+= '	<div class="row">';
							MessageResp+= '		<div class="col-xs-6">&nbsp;</div>';
							MessageResp+= '		<div class="col-xs-6" style="font-size:xx-small; color:#999; text-align:right">'+fQDT+'</div>';
							MessageResp+= '	</div>'
							MessageResp+= '</div>';
						$("#BodyPlaceHolder").append(MessageResp);
						$("#Question").attr('readonly','readonly');
						$('#Preloader').modal('toggle');
						return false;
				}, 'json');
			}
			
			var QDT			= new Date(Date.now()).toString();
			var	fQDT		= QDT.substring(4, QDT.indexOf('GMT') );
			var MessageResp	= '<div class="container-fluid" style="width:97%">';
				MessageResp+= '	<div class="row">';
				MessageResp+= '		<div class="col-xs-6">&nbsp;</div>';
				MessageResp+= '		<div class="col-xs-6 ChatResponse"><strong>Watson:&nbsp;&nbsp;</strong>'+Response+'</div>';
				MessageResp+= '	</div>';
				MessageResp+= '	<div class="row">';
				MessageResp+= '		<div class="col-xs-6">&nbsp;</div>';
				MessageResp+= '		<div class="col-xs-6" style="font-size:xx-small; color:#999; text-align:right">'+fQDT+'</div>';
				MessageResp+= '	</div>'
				MessageResp+= '</div>';
			$("#BodyPlaceHolder").append(MessageResp);
			$("#ConversationId").val(JSONResponse.context.conversation_id);
			$("#DialogTurnCounter").val(JSONResponse.context.system.dialog_turn_counter);
			$("#DialogRequestCounter").val(JSONResponse.context.system.dialog_request_counter);
			$("#DialogNode").val(JSONResponse.context.system.dialog_stack[0].dialog_node);
			$("#Question").removeAttr('readonly');
			
		}, 'json');
		
		
		return false; // Will stop the reloading of the page
	}
	else // Question Bar is Empty.
	{
		$("#AlertTitle").html("Validation Failed");
		$("#AlertTitle").addClass("text-danger");
		$('#AlertBox').addClass("text-danger");
		$('#AlertBox').html('Invalid input(s), please try again.');
		$('#AlertContainer').modal(
		{
			show: true,
			backdrop: 'static',
			keyboard: false
		});
		return false; // Will stop the reloading of the page
	}		
});

			
$(document).on("click", ".SupplierList", function () 
{
	var AddressId	= $(this).attr('rel');
	var InternalId	= $(this).attr('data');
	var SupplierName= $(this).attr('name');
	$("#Agreement_ExtParty").val(SupplierName);
	$("#Agreement_ExtParty_Address").val(AddressId);
	$("#Agreement_ExtParty_IntId").val(InternalId);
	$('#AlertContainer').modal('toggle');
});

$('#BodyPlaceHolder').bind("DOMSubtreeModified",function(){
  $("#BodyPlaceHolder").animate({scrollTop: $('#BodyPlaceHolder').prop("scrollHeight")}, 1000);
});
<?php
	}
	?>
</script>
</body>
</html>