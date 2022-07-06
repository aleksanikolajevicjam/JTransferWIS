<form id="" class="form " method="post">	
	<div class="box-body ">
        <div class="row">
			<div class="col-md-12">

						<input type="hidden" name="ID" id="ID" class="w100" value="{$ID}" >
						<input type="hidden" name="rulesType" id="rulesType" class="w100" value="{$smarty.request.rulesType}" >
						<input type="hidden" name="OwnerID" id="OwnerID" class="w100" value="{$smarty.session.UseDriverID}" >
						{if $smarty.request.rulesType eq 'rutes'} <input type="hidden" name="DriverRouteID" id="DriverRouteID" class="w100" value="{$smarty.request.item}" readonly>{/if}
						{if $smarty.request.rulesType eq 'vehicles'} <input type="hidden" name="VehicleID" id="VehicleID" class="w100" value="{$smarty.request.item}" readonly>{/if}
						{if $smarty.request.rulesType eq 'services'} <input type="hidden" name="ServiceID" id="ServiceID" class="w100" value="{$smarty.request.item}" readonly>{/if}


				<div class="row alert alert-info">
					<div class="col-md-2">
						<label for="NightStart">{$NIGHTSTART}</label>
						<input type="text" name="NightStart" id="NightStart" class="w100 timepicker" value="{$NightStart}" >
					</div>
					<div class="col-md-2">
						<label for="NightEnd">{$NIGHTEND}</label>
						<input type="text" name="NightEnd" id="NightEnd" class="w100 timepicker" value="{$NightEnd}" >
					</div>
					<div class="col-md-2">
						<label for="NightPercent">{$NIGHTPERCENT}</label>
						<input type="text" name="NightPercent" id="NightPercent" class="w100" value="{$NightPercent}" >
					</div>
					<div class="col-md-2">
						<label for="NightAmount">{$NIGHTAMOUNT}</label>
						<input type="text" name="NightAmount" id="NightAmount" class="w100" value="{$NightAmount}" >
					</div>
				</div>

				<div class="row alert alert-warning">
					<div class="col-md-2">
						<label for="MonPercent">{$MONPERCENT}</label>
						<input type="text" name="MonPercent" id="MonPercent" class="w50" value="{$MonPercent}" >
						<label for="MonAmount">{$MONAMOUNT}</label>
						<input type="text" name="MonAmount" id="MonAmount" class="w50" value="{$MonAmount}" >
					</div>
					<div class="col-md-2">
						<label for="TuePercent">{$TUEPERCENT}</label>
						<input type="text" name="TuePercent" id="TuePercent" class="w50" value="{$TuePercent}" >
						<label for="TueAmount">{$TUEAMOUNT}</label>
						<input type="text" name="TueAmount" id="TueAmount" class="w50" value="{$TueAmount}" >
					</div>
					<div class="col-md-2">
						<label for="WedPercent">{$WEDPERCENT}</label>
						<input type="text" name="WedPercent" id="WedPercent" class="w50" value="{$WedPercent}" >
						<label for="WedAmount">{$WEDAMOUNT}</label>
						<input type="text" name="WedAmount" id="WedAmount" class="w50" value="{$WedAmount}" >
					</div>
					<div class="col-md-2">
						<label for="ThuPercent">{$THUPERCENT}</label>
						<input type="text" name="ThuPercent" id="ThuPercent" class="w50" value="{$ThuPercent}" >
						<label for="ThuAmount">{$THUAMOUNT}</label>
						<input type="text" name="ThuAmount" id="ThuAmount" class="w50" value="{$ThuAmount}" >
					</div>
					<div class="col-md-2">
						<label for="FriPercent">{$FRIPERCENT}</label>
						<input type="text" name="FriPercent" id="FriPercent" class="w50" value="{$FriPercent}" >
						<label for="FriAmount">{$FRIAMOUNT}</label>
						<input type="text" name="FriAmount" id="FriAmount" class="w50" value="{$FriAmount}" >
					</div>
					<div class="col-md-2">
						<label for="SatPercent">{$SATPERCENT}</label>
						<input type="text" name="SatPercent" id="SatPercent" class="w50" value="{$SatPercent}" >
						<label for="SatAmount">{$SATAMOUNT}</label>
						<input type="text" name="SatAmount" id="SatAmount" class="w50" value="{$SatAmount}" >
					</div>
					<div class="col-md-2">
						<label for="SunPercent">{$SUNPERCENT}</label>
						<input type="text" name="SunPercent" id="SunPercent" class="w50" value="{$SunPercent}" >
						<label for="SunAmount">{$SUNAMOUNT}</label>
						<input type="text" name="SunAmount" id="SunAmount" class="w50" value="{$SunAmount}" >
					</div>
				</div>

				<div class="row box box-info alert">
					<div class="col-md-2">
						<label for="S1Start">{$S1START}</label>
						<input type="text" name="S1Start" id="S1Start" class="w100 datepicker" value="{$S1Start}" >
					</div>
					<div class="col-md-2">
						<label for="S1End">{$S1END}</label>
						<input type="text" name="S1End" id="S1End" class="w100 datepicker" value="{$S1End}" >
					</div>
					<div class="col-md-1">
						<label for="S1Percent">{$S1PERCENT}</label>
						<input type="text" name="S1Percent" id="S1Percent" class="w100" value="{$S1Percent}" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>	-					
					<div class="col-md-2">
						<label for="S2Start">{$S2START}</label>
						<input type="text" name="S2Start" id="S2Start" class="w100 datepicker" value="{$S2Start}" >
					</div>
					<div class="col-md-2">
						<label for="S2End">{$S2END}</label>
						<input type="text" name="S2End" id="S2End" class="w100 datepicker" value="{$S2End}" >
					</div>
					<div class="col-md-1">
						<label for="S2Percent">{$S2PERCENT}</label>
						<input type="text" name="S2Percent" id="S2Percent" class="w100" value="{$S2Percent}" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>					
				</div>

				<div class="row box box-warning alert">
					<div class="col-md-2">
						<label for="S3Start">{$S3START}</label>
						<input type="text" name="S3Start" id="S3Start" class="w100 datepicker" value="{$S3Start}" >
					</div>
					<div class="col-md-2">
						<label for="S3End">{$S3END}</label>
						<input type="text" name="S3End" id="S3End" class="w100 datepicker" value="{$S3End}" >
					</div>
					<div class="col-md-1">
						<label for="S3Percent">{$S3PERCENT}</label>
						<input type="text" name="S3Percent" id="S3Percent" class="w100" value="{$S3Percent}" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>						
					<div class="col-md-2">
						<label for="S4Start">{$S4START}</label>
						<input type="text" name="S4Start" id="S4Start" class="w100 datepicker" value="{$S4Start}" >
					</div>
					<div class="col-md-2">
						<label for="S4End">{$S4END}</label>
						<input type="text" name="S4End" id="S4End" class="w100 datepicker" value="{$S4End}" >
					</div>
					<div class="col-md-1">
						<label for="S4Percent">{$S4PERCENT}</label>
						<input type="text" name="S4Percent" id="S4Percent" class="w100" value="{$S4Percent}" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>						
				</div>
				
				<div class="row box alert">
					<div class="col-md-2">
						<label for="S5Start">{$S5START}</label>
						<input type="text" name="S5Start" id="S5Start" class="w100 datepicker" value="{$S5Start}" >
					</div>
					<div class="col-md-2">
						<label for="S5End">{$S5END}</label>
						<input type="text" name="S5End" id="S5End" class="w100 datepicker" value="{$S5End}" >
					</div>
					<div class="col-md-1">
						<label for="S5Percent">{$S5PERCENT}</label>
						<input type="text" name="S5Percent" id="S5Percent" class="w100" value="{$S5Percent}" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>	
					<div class="col-md-2">
						<label for="S6Start">{$S6START}</label>
						<input type="text" name="S6Start" id="S6Start" class="w100 datepicker" value="{$S6Start}" >
					</div>
					<div class="col-md-2">
						<label for="S6End">{$S6END}</label>
						<input type="text" name="S6End" id="S6End" class="w100 datepicker" value="{$S6End}" >
					</div>
					<div class="col-md-1">
						<label for="S6Percent">{$S6PERCENT}</label>
						<input type="text" name="S6Percent" id="S6Percent" class="w100" value="{$S6Percent}" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>						
				</div>
				
				<div class="row box alert">
					<div class="col-md-2">
						<label for="S7Start">{$S7START}</label>
						<input type="text" name="S7Start" id="S7Start" class="w100 datepicker" value="{$S7Start}" >
					</div>
					<div class="col-md-2">
						<label for="S7End">{$S7END}</label>
						<input type="text" name="S7End" id="S7End" class="w100 datepicker" value="{$S7End}" >
					</div>
					<div class="col-md-1">
						<label for="S7Percent">{$S7PERCENT}</label>
						<input type="text" name="S7Percent" id="S7Percent" class="w100" value="{$S7Percent}" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>	
					<div class="col-md-2">
						<label for="S8Start">{$S8START}</label>
						<input type="text" name="S8Start" id="S8Start" class="w100 datepicker" value="{$S8Start}" >
					</div>
					<div class="col-md-2">
						<label for="S8End">{$S8END}</label>
						<input type="text" name="S8End" id="S8End" class="w100 datepicker" value="{$S8End}" >
					</div>
					<div class="col-md-1">
						<label for="S8Percent">{$S8PERCENT}</label>
						<input type="text" name="S8Percent" id="S8Percent" class="w100" value="{$S8Percent}" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>						
				</div>
				
				<div class="row box alert">
					<div class="col-md-2">
						<label for="S9Start">{$S9START}</label>
						<input type="text" name="S9Start" id="S9Start" class="w100 datepicker" value="{$S9Start}" >
					</div>
					<div class="col-md-2">
						<label for="S9End">{$S9END}</label>
						<input type="text" name="S9End" id="S9End" class="w100 datepicker" value="{$S9End}" >
					</div>
					<div class="col-md-1">
						<label for="S9Percent">{$S9PERCENT}</label>
						<input type="text" name="S9Percent" id="S9Percent" class="w100" value="{$S9Percent}" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>	
					<div class="col-md-2">
						<label for="S10Start">{$S10START}</label>
						<input type="text" name="S10Start" id="S10Start" class="w100 datepicker" value="{$S10Start}" >
					</div>
					<div class="col-md-2">
						<label for="S10End">{$S10END}</label>
						<input type="text" name="S10End" id="S10End" class="w100 datepicker" value="{$S10End}" >
					</div>
					<div class="col-md-1">
						<label for="S10Percent">{$S10PERCENT}</label>
						<input type="text" name="S10Percent" id="S10Percent" class="w100" value="{$S10Percent}" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>						
				</div>					
			</div>
	    </div>
</form>
