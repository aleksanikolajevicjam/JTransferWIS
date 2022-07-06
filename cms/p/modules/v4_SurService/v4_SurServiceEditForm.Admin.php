
<script type="text/x-handlebars-template" id="v4_SurServiceEditTemplate">
<form id="v4_SurServiceEditForm{{ID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-header">
		<div class="box-title">
			<? if ($isNew) { ?>
				<h3><?= NNEW ?></h3>
			<? } else { ?>
				<h3><?= EDIT ?> - {{ID}}</h3>
			<? } ?>
		</div>
		<div class="box-tools pull-right">
			
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>
				<? if ($inList=='true') { ?>
					<button class="btn" title="<?= CLOSE?>" 
					onclick="return editClosev4_SurService('{{ID}}', '<?= $inList ?>');">
					<i class="fa fa-arrow-up"></i>
					</button>
				<? } else { ?>
					<button class="btn btn-danger" title="<?= CANCEL ?>" 
					onclick="return deletev4_SurService('{{ID}}', '<?= $inList ?>');">
					<i class="fa fa-ban"></i>
					</button>
				<? } ?>	
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSavev4_SurService('{{ID}}', '<?= $inList ?>');">
			<i class="ic-disk"></i>
			</button>
			<? if (!$isNew) { ?>
				<button class="btn btn-danger" title="<?= PRINTIT ?>" 
				onclick="return editPrintv4_SurService('{{ID}}', '<?= $inList ?>');">
				<i class="ic-print"></i>
				</button>
			<? } ?>	
		</div>
	</div>

	<div class="box-body ">
        <div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-3">
						<label for="ID"><?=ID;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="ID" id="ID" class="w100" value="{{ID}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="SiteID"><?=SITEID;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="SiteID" id="SiteID" class="w100" value="{{SiteID}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="OwnerID"><?=OWNERID;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="OwnerID" id="OwnerID" class="w100" value="{{OwnerID}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="ServiceID"><?=SERVICEID;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="ServiceID" id="ServiceID" class="w100" value="{{ServiceID}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="NightStart"><?=NIGHTSTART;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="NightStart" id="NightStart" class="w100" value="{{NightStart}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="NightEnd"><?=NIGHTEND;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="NightEnd" id="NightEnd" class="w100" value="{{NightEnd}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="NightPercent"><?=NIGHTPERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="NightPercent" id="NightPercent" class="w100" value="{{NightPercent}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="NightAmount"><?=NIGHTAMOUNT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="NightAmount" id="NightAmount" class="w100" value="{{NightAmount}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="WeekendPercent"><?=WEEKENDPERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="WeekendPercent" id="WeekendPercent" class="w100" value="{{WeekendPercent}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="WeekendAmount"><?=WEEKENDAMOUNT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="WeekendAmount" id="WeekendAmount" class="w100" value="{{WeekendAmount}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="MonPercent"><?=MONPERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="MonPercent" id="MonPercent" class="w100" value="{{MonPercent}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="MonAmount"><?=MONAMOUNT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="MonAmount" id="MonAmount" class="w100" value="{{MonAmount}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="TuePercent"><?=TUEPERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="TuePercent" id="TuePercent" class="w100" value="{{TuePercent}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="TueAmount"><?=TUEAMOUNT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="TueAmount" id="TueAmount" class="w100" value="{{TueAmount}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="WedPercent"><?=WEDPERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="WedPercent" id="WedPercent" class="w100" value="{{WedPercent}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="WedAmount"><?=WEDAMOUNT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="WedAmount" id="WedAmount" class="w100" value="{{WedAmount}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="ThuPercent"><?=THUPERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="ThuPercent" id="ThuPercent" class="w100" value="{{ThuPercent}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="ThuAmount"><?=THUAMOUNT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="ThuAmount" id="ThuAmount" class="w100" value="{{ThuAmount}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="FriPercent"><?=FRIPERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="FriPercent" id="FriPercent" class="w100" value="{{FriPercent}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="FriAmount"><?=FRIAMOUNT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="FriAmount" id="FriAmount" class="w100" value="{{FriAmount}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="SatPercent"><?=SATPERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="SatPercent" id="SatPercent" class="w100" value="{{SatPercent}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="SatAmount"><?=SATAMOUNT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="SatAmount" id="SatAmount" class="w100" value="{{SatAmount}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="SunPercent"><?=SUNPERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="SunPercent" id="SunPercent" class="w100" value="{{SunPercent}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="SunAmount"><?=SUNAMOUNT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="SunAmount" id="SunAmount" class="w100" value="{{SunAmount}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S1Start"><?=S1START;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S1Start" id="S1Start" class="w100" value="{{S1Start}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S1End"><?=S1END;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S1End" id="S1End" class="w100" value="{{S1End}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S1Percent"><?=S1PERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S1Percent" id="S1Percent" class="w100" value="{{S1Percent}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S2Start"><?=S2START;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S2Start" id="S2Start" class="w100" value="{{S2Start}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S2End"><?=S2END;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S2End" id="S2End" class="w100" value="{{S2End}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S2Percent"><?=S2PERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S2Percent" id="S2Percent" class="w100" value="{{S2Percent}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S3Start"><?=S3START;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S3Start" id="S3Start" class="w100" value="{{S3Start}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S3End"><?=S3END;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S3End" id="S3End" class="w100" value="{{S3End}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S3Percent"><?=S3PERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S3Percent" id="S3Percent" class="w100" value="{{S3Percent}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S4Start"><?=S4START;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S4Start" id="S4Start" class="w100" value="{{S4Start}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S4End"><?=S4END;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S4End" id="S4End" class="w100" value="{{S4End}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S4Percent"><?=S4PERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S4Percent" id="S4Percent" class="w100" value="{{S4Percent}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S5Start"><?=S5START;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S5Start" id="S5Start" class="w100" value="{{S5Start}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S5End"><?=S5END;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S5End" id="S5End" class="w100" value="{{S5End}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S5Percent"><?=S5PERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S5Percent" id="S5Percent" class="w100" value="{{S5Percent}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S6Start"><?=S6START;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S6Start" id="S6Start" class="w100" value="{{S6Start}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S6End"><?=S6END;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S6End" id="S6End" class="w100" value="{{S6End}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S6Percent"><?=S6PERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S6Percent" id="S6Percent" class="w100" value="{{S6Percent}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S7Start"><?=S7START;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S7Start" id="S7Start" class="w100" value="{{S7Start}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S7End"><?=S7END;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S7End" id="S7End" class="w100" value="{{S7End}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S7Percent"><?=S7PERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S7Percent" id="S7Percent" class="w100" value="{{S7Percent}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S8Start"><?=S8START;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S8Start" id="S8Start" class="w100" value="{{S8Start}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S8End"><?=S8END;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S8End" id="S8End" class="w100" value="{{S8End}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S8Percent"><?=S8PERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S8Percent" id="S8Percent" class="w100" value="{{S8Percent}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S9Start"><?=S9START;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S9Start" id="S9Start" class="w100" value="{{S9Start}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S9End"><?=S9END;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S9End" id="S9End" class="w100" value="{{S9End}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S9Percent"><?=S9PERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S9Percent" id="S9Percent" class="w100" value="{{S9Percent}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S10Start"><?=S10START;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S10Start" id="S10Start" class="w100" value="{{S10Start}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S10End"><?=S10END;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S10End" id="S10End" class="w100" value="{{S10End}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="S10Percent"><?=S10PERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="S10Percent" id="S10Percent" class="w100" value="{{S10Percent}}">
					</div>
				</div>


			</div>
	    </div>
		    

	<!-- Statuses and messages -->
	<div class="box-footer">
		<? if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default" onclick="return deletev4_SurService('{{ID}}', '<?= $inList ?>');">
    		<i class="ic-cancel-circle"></i> <?= DELETE ?>
    	</button>
    	</div>
    	<? } ?>

	</div>
</form>


	<script>

		//bootstrap WYSIHTML5 - text editor
		$(".textarea").wysihtml5({
				"font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
				"emphasis": true, //Italics, bold, etc. Default true
				"lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
				"html": true, //Button which allows you to edit the generated HTML. Default false
				"link": true, //Button to insert a link. Default true
				"image": true, //Button to insert an image. Default true,
				"color": true //Button to change color of font 
				
		});
		
		// uklanja ikonu Saved - statusMessage sa ekrana
		$("form").change(function(){
			$("#statusMessage").html('');
		});
	
	</script>
</script>
	
