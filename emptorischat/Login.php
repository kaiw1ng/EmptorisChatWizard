<?php
require('DAL/Helper.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>IBM Emptoris Procurement Advisor</title>
<!-- Bootstrap -->
<link href="dist/css/bootstrap.min.css" rel="stylesheet">
<link href="dist/css/emptoris_custom.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<style type="text/css">
input[type="email"], input[type="text"], input[type="password"]
{
    border: 1px solid #f0f0f0;
    height: 50px;
    line-height: 16px;
    margin-bottom: 0;
    text-indent: 16px;
    width: 100%;
    outline: none;
	border-radius: 0px;
}
button
{
    -webkit-border-radius: 0 !important;
    -moz-border-radius: 0 !important;
    border-radius: 0 !important;
	border: 1px solid #f0f0f0;
    height: 60px;
    margin-bottom: 0;
    width: 100%;
    outline: none;
	border-radius: 0px;
	text-align: center;
	
}
label
{
	display: block;
    font-size: 14px;
    line-height: 12px;
    margin: 30px 0 10px;
	font-weight:normal;
}
.form-control{
    border-color: #f0f0f0;
    -webkit-box-shadow: none;
    box-shadow: none;
	outline: none;
	
}
.form-control:focus{
	background: #f0f0f0;
    border-color: #f0f0f0;
    -webkit-box-shadow: none;
    box-shadow: none;
	outline: none;
}
h3
{
    font-size:28px;
	text-align: center;
}
@media (max-width: 600px) 
{
    h3
    {
	    font-size:20px;
    }
}
@media (max-width: 460px) 
{
    h3
    {
	    font-size:16px;
    }
}
body 
{
    background-image: url("Design/Background.svg");
	background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: right bottom;
	background-size: 40%;	
}
@media only screen and (min-width: 400px) {
    body 
    {
        
	background-size: 25%;
    }
}
</style>
</head>
<body>
<!--Alerts Section : Starts Here-->
	<div id="AlertContainer" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="AlertTitle">Modal title</h4>
				</div>
				<div class="modal-body" id="AlertBox">One fine body</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-1 col-sm-2 col-md-3">&nbsp;</div>
            <div class="col-xs-10 col-sm-8 col-md-6">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12"><h3>IBM Emptoris Procurement Advisor</h3></div>
                    </div>
                    <div class="clear-fix">&nbsp;</div>
                    <div class="row">
                        <div class="col-xs-12 text-center"><span class="text-danger" id="ErrorMessage">&nbsp;</span></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12" style="padding:0% 10%;">
                        <form id="frmLogin" name="frmLogin" method="post">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email Address</label>
                                <input type="email" class="form-control" id="Username" name="Username" value="mqureshi@ae.ibm.com" placeholder="username@domain.com" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="Password" name="Password" value="emptoris" placeholder="Password" />
                            </div>
                            <div class="clear-fix">&nbsp;</div>
                            <button type="button" id="btnLogin" name="btnLogin" class="btn btn-primary" style="font-size: 18px; font-weight:bold;">Sign in</button>
                        </form>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-xs-12 text-center"><h5>Powered by IBM Watson</h5></div>
                    </div>
                </div>
            <div class="col-xs-1 col-sm-2 col-md-3">&nbsp;</div>
        </div>
    </div>
    </div>
<?php require('inclFooterJS.php'); ?>
<script>
$("#btnLogin").click(function()
{
	var FormData = $('#frmLogin').serializeArray();
	$('#Preloader').modal( { show: true, backdrop: 'static', keyboard: false, opacity:1 });
			
	$.post('ValidateLogin.php', FormData, function(Response) 
	{
		$('#Preloader').modal('toggle');
		if ( Response.UserId > 0 && Response.IsActive > 0 )
		{
			setTimeout( location.href='index.php', 1000);
		}
		else
		{
		    $("#ErrorMessage").html("Invalid Username and/or Password, please retry.");
		}
		return false;
	},'json');
});
				
</script>
</body>
</html>