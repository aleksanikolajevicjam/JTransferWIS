<?
	require_once ROOT.'/db/v4_AuthLevels.class.php';
	$al = new v4_AuthLevels();
	$authLevels = $al->getKeysBy('AuthLevelName', 'asc');
	foreach($authLevels as $nn => $id) {
		$al->getRow($id);
		$arr_row['id']=$al->getAuthLevelID();
		$arr_row['name']=$al->getAuthLevelName();
		$arr_all[]=$arr_row;
	}
	$smarty->assign('options',$arr_all);
	$smarty->assign('selecttype',true);
	$smarty->assign('selectactive',true);	
?>	
<script type="text/x-handlebars-template" id="ItemListTemplate">

	{{#each Item}}
		<div  onclick="oneItem({{AuthUserID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="user_{{AuthUserID}}">
		
					<div class="col-sm-1 col-xs-4">
						<img src="api/showProfileImage.php?UserID={{AuthUserID}}" 
						   style="max-height:60px; max-width:60px;" 
						   class="img-thumbnail">
					</div>
					<div class="col-sm-3 col-xs-6">
						<strong>{{AuthUserName}}</strong>
						<br>
						{{#compare Active ">" 0}}
							<i class="fa fa-circle text-green"></i>
						{{else}}
							<i class="fa fa-circle text-red"></i>
						{{/compare}}
						&nbsp;
						ID: <strong>{{AuthUserID}}</strong> {{DriverID}}
						{{displayUserLevelText AuthLevelID}} 
					</div>
					<div class="col-sm-2 col-xs-12">
						<strong>{{AuthUserCompany}}</strong>
						<br>
						<small>{{AuthUserRealName}}</small>
						<br>
						<small>{{Country}} {{Terminal}}</small>						
					</div>
					<div class="col-sm-3 col-xs-12">
						<a href="index.php?p=quickEmail&EmailAddress={{AuthUserMail}}"  
						class="btn btn-default btn-sm"><i class="fa fa-envelope"></i> {{AuthUserMail}}</a>
						<br>
						<small>
						{{#if AuthUserTel}}
						<i class="fa fa-phone"></i> {{AuthUserTel}}<br>
						{{/if}}
						{{#if AuthUserMob}}
						<i class="fa fa-phone"></i> {{AuthUserMob}}<br>
						{{/if}}						
						{{#if EmergencyPhone}}
						<i class="fa fa-phone red-text"></i> {{EmergencyPhone}}
						{{/if}}
						</small>
					</div>

					<div class="col-sm-3">
						<small>{{{AuthUserNote}}}</small>
					</div>
			</div>
		</div>
		<div id="ItemWrapper{{AuthUserID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{AuthUserID}}" class="row">
				<div id="one_Item{{AuthUserID}}" >
					<?= THERE_ARE_NO_DATA ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
