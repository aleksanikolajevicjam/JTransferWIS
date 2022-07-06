<!DOCTYPE html>
<html>
	<head>
		<base href="{$root_home}">	
		
		<meta charset="UTF-8">
		<title>WIS {$title}</title>

		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

		<!-- STYLES -->
		<!-- bootstrap 3.0.2 -->
		<!-- <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all"/>-->

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

		<!-- font Awesome -->
		<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

		<!-- Ionicons -->
		<link href="css/ionicons.min.css" rel="stylesheet" type="text/css"/>

		<!-- Morris chart -->
		<link href="css/morris/morris.css" rel="stylesheet" type="text/css"/>

		<!-- bootstrap wysihtml5 - text editor -->
		<link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="css/bootstrap-slider/slider.css" rel="stylesheet" type="text/css"/>
		<link href="js/summernote/summernote.css" rel="stylesheet" type="text/css" media="screen"/>
		<!-- Theme style WORKING !!!-->
		<link href="css/theme.css" rel="stylesheet" type="text/css" media="screen"/>
		<!-- Preuzeto za novu administraciju -->
		<link href="css/admin.css" rel="stylesheet">

		<!-- Misc -->
		<link rel="stylesheet" href="css/jquery-ui-1.8.9.custom.css" type="text/css" />

		<link rel="stylesheet" href="js/pickadate/themes/default.css" type="text/css" media="screen"/>
		<link rel="stylesheet" href="js/pickadate/themes/default.date.css" type="text/css" media="screen"/>
		<link rel="stylesheet" href="js/pickadate/themes/default.time.css" type="text/css" media="screen"/>
		<link rel="stylesheet" href="css/colors.css" media="all">
		<!--<link rel="stylesheet" href="css/simplegrid.css" media="all">!-->
		<link rel="stylesheet" type="text/css" href="css/JAMTimepicker.css">
		<link rel="stylesheet" type="text/css" href="js/select/css/select2.css">		

		<style type="text/css" media="print">
			body {
				font-family: 'Roboto', sans-serif;
				font-size: 10px !important;
			}
			.nav, .footer { display:none; }
			@page { margin: 0.5cm; }
			@media print {
				div [class*='col-'] { display: table-cell !important; }
				div [class*='row'] { display: table-row !important; width: 100%; }
				div [class*='grid'] { display: table-row !important; width: 100%; }
				div [class*='w25'] { display: inline-block !important; width: 30%; }
				div [class*='w75'] { display: inline-block !important; width: 69%; }
				div [class*='w100'] { display: inline-block !important; width: 99%; }
				button, .btn { display:none; }
			}
		</style>
		<!-- SCRIPTS -->
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->


		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-2.0.2.js"></script>
		<!-- <script src="cms/js/jquery/2.0.2/jquery.min.js"></script> -->
		<!-- jQuery UI 1.10.3 -->
		<script src="js/jQuery/ui/1.10.3/jquery-ui.min.js" type="text/javascript"></script>

		<!-- Mainly scripts -->
		<script src="js/main.admin.js"></script>

		<!-- Bootstrap -->
		<!-- <script src="js/bootstrap.js" type="text/javascript"></script>-->
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>        

		<!-- Morris.js charts -->
		<script src="js/plugins/raphael/2.1.0/raphael-min.js"></script>
		<script src="js/plugins/morris/morris.min.js" type="text/javascript"></script>

		<!-- Sparkline -->
		<script src="js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>

		<!-- jQuery Knob Chart -->
		<script src="js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>

		<!-- Bootstrap WYSIHTML5 -->
		<script src="js/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
		<script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
		<script src="js/plugins/bootstrap-slider/bootstrap-slider.js" type="text/javascript"></script>

		<!-- iCheck -->
		<script xsrc="js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

		<!-- Validation -->
		<script src="js/jquery.validate.min.js"></script>

		<!-- Date / Time Picker -->
		<script src="js/pickadate/picker.js" type="text/javascript"></script>
		<script src="js/pickadate/picker.date.js" type="text/javascript"></script>
		<script src="js/pickadate/picker.time.js" type="text/javascript"></script>
		<script src="js/JAMTimepicker.js"></script>
		<script src="js/select/js/select2.js"></script>

		<!-- Moment -->
		<script src="js/moment.min.js" type="text/javascript"></script>

		<!-- App -->
		<script src="js/theme/app.js" type="text/javascript"></script>

		<!-- Misc -->
		<script src="js/handlebars-v1.3.0.js"></script>
		<script src="js/jquery.slugify.js"></script>
		<script src="js/summernote/summernote.js"></script>
		<script src="js/jquery.toaster.js"></script>
		<script src="lng/{$language}_init.js"></script>	
		<script src="js/cms.jquery.js"></script>
		{if isset($pageList)}
		<script src="js/list.js"></script>
		{literal}		
		<script type="text/javascript">
		window.root = 'plugins/{/literal}{$base}{literal}/';
		window.currenturl = '{/literal}{$currenturl}{literal}';
		</script>
		{/literal}
			{if $isNew}
			<script type="text/javascript">
				$(document).ready(function(){
					new_Item(); 
				});	
			</script>
			{else}
			{literal}
			<script type="text/javascript">
				$(document).ready(function(){
					allItems(); 
					oneItem({/literal}{$item}{literal});
				});	
			</script>
			{/literal}
			{/if}
		{/if}		
	</head>		
	<body class="fixed-top" style="height:100%!important;font-size:16px">
		<div id="wrapper">
			<nav class="navbar-static-side" role="navigation">
				<div class="sidebar-collapse">
					<ul class="nav metismenu" id="side-menu">
						<li class="nav-header">
							<div class="dropdown profile-element">
								<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<span class="clear"> 
								<span class="block m-t-xs">
									<a href="profile" >
										<img src="api/showProfileImage.php?UserID={$smarty.session.AuthUserID}" class="img-circle" alt="User Image" style="height:2em;padding:-.5em;margin:-.5em" />
										<strong class="font-bold">{$smarty.session.UserRealName}</strong>
									</a>
								</span>
								<ul class="dropdown-menu animated fadeInRight m-t-xs">
									<li><a href="profile" data-param="">Profile</a></li>
									<li class="divider"></li>
									<li><a href='logout'>Logout</a></li>
								</ul>
							</div>
						</li>
						{if isset($smarty.session.UseDriverName)}
						<li class="nav-header">
							<strong class="font-bold">{$smarty.session.UseDriverName}</strong>
							<a href="setout.php">Setout</a>
						</li>
						{/if}
						{section name=index loop=$menu1}
						<li class="{$menu1[index].active}">
							<a href='{$menu1[index].link}' >
								<i class="fa {$menu1[index].icon}"></i> 
								<span class="nav-label">{$menu1[index].title}</span> 
								<span class="{$menu1[index].arrow}"></span>
							</a>
							{if $menu1[index].menu}
							<ul class="nav nav-second-level collapse" >
								{section name=index1 loop=$menu1[index].menu}	
								<li class="{$menu1[index].menu[index1].active}">
									<a href="{$menu1[index].menu[index1].link}"><span class="nav-label">{$menu1[index].menu[index1].title}</span></a>
										{if $menu1[index].menu[index1].title eq 'Orders'}
										<ul class="nav nav-third-level collapse" >
											<li><a href="{$menu1[index].menu[index1].link}"><span class="nav-label">All</span></a></li>
											{section name=pom loop=$transfersFilters}
												<li {if $transfersFilters[pom].id eq $transfersFilter} class="active" {/if}>
													<a href="{$menu1[index].menu[index1].link}/{$transfersFilters[pom].id}"><span class="nav-label">{$transfersFilters[pom].name}</span></a>
												</li>
											{/section}
										</select>						
										</ul>
										{/if}
								</li>
								{/section}	
							</ul>
							{/if}
						</li>
						{/section}
				   </ul>
				</div>
			</nav>

			<style type="text/css" >
				.content {
					height: 100%;
					overflow: hidden;
					display: grid;

				}

				.header {
					grid-row: 1; 
				}
				.body{
					grid-row: 2;
					padding: 10px;
					overflow-y: auto;
					overflow-x: hidden;
				}
				.footer{
					grid-row: 3;
				}		
			</style>			
			<div id="page-wrapper" class="content gray-bg dashbard-1" style="height: 100%;
					display: flex;
					flex-direction: column;
					flex-wrap: nowrap;
					overflow: hidden;">
				<div class="header row border-bottom">
				   <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
					  <div class="navbar-header">
						 <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
					  </div>
					  <div class="navbar-header">
						 <button type="button" class="minimalize-styl-2 btn btn-primary " id="cashe"><i class="fa fa-refresh"></i></button>
					  </div>					  					  						
					  <ul class="nav navbar-top-links navbar-right">
						 <li>
							<h2><span class="m-r-sm text-muted">{$title}</span></h2>
						 </li>
						 <li>
							<a href='logout'>
							<i class="fa fa-sign-out"></i>Logout
							</a>
						 </li>
					  </ul>
				   </nav>
				</div>   
			
				{if not $isNew and isset($pageList)}
				<div class="header">  
					{include file="pageListHeader.tpl"} 				   
				</div>
				{/if}
				{if $page eq 'Price Rules'}	
				<div class="header row"> 
					<div class="pull-left">
						<span>Rule: <strong>{$smarty.request.rulesType}</strong></span>
						{if $routeName}<span>Route:<strong>{$routeName}</strong></span>{/if}
						{if $vehicleName}<span>Vehicle:<strong>{$vehicleName}</strong></span>{/if}

					</div>
					<div class="pull-right">
						<button type="submit" class="btn btn-info" title="{$SAVE_CHANGES}" >
							<i class="fa fa-save"></i>
						</button>					
					</div>
				</div>	
				{/if}
					
				<div class="body row white-bg">
					{if isset($pageOLD)}
						NOT MODEL VIEW CONTROL
					{elseif isset($page)}
						{include file="{$root}/plugins/{$base}/templates/{$includefiletpl}"}
						MODEL VIEW CONTROL SMARTY		
					{elseif isset($pageList)}
						{include file="pageList.tpl"} 
						MODEL VIEW CONTROL HANDLEBARS
					{else}
						{$page_render}
						SEMI MODEL VIEW CONTROL via OB_GET_CONTENTS
					{/if}				  
				</div>
				<div class="footer row">
					{if not $isNew and isset($pageList)}				
					<div id="pageSelect" class="pull-left"></div>
					{/if}
					<div class="pull-right">
					  Powered by <strong>Jamtransfer</strong>
					</div>
					<div class="backdrop"><div class="spiner"></div></div>
				</div>
			</div>
		</div>
		<input type='hidden' id='local' value='{$local}' name='local'>
	</body>
</html>
	{literal}
	<script>
		document.addEventListener("keydown", function(event) {
		  //event.preventDefault();
		  if (event.which==121) window.open(window.location.href+'/help','_blank');
		})	
		$(document).ready(function() {
			$(".datepicker").pickadate({format{/literal}:{literal} 'yyyy-mm-dd'});
			$(".timepicker").JAMTimepicker();
		});
		
		$.ajaxSetup({
			beforeSend: function (xhr,settings) {
			   return settings;
			}
		});
	</script>
	{/literal}
	