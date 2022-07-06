<? require_once 'f/functions.php' ;

echo $_SERVER['PATH'];

?>

<div class="lgray">
	<div class="xblue-1  pad1em center">
		<h1><?= BOOKING_WIZZARD ?></h1><hr>
		<?= PLEASE_FILL_IN_ALL_DATA ?>
	</div>

	<form id="bookingForm" action="t/final.php" method="post" onsubmit="return validateBookingForm();" style="min-height:800px" >
		<div class="grid">
			<div class="xcol-2-12"></div>
			<div class="col-1-1">

				<div class="pad1em">

						<input type="hidden" id="pleaseSelect" value="<?= PLEASE_SELECT?>"/>
						<input type="hidden" id="loading" value="<?= LOADING ?>"/>

						<label class="w25"><?= COUNTRY ?></label>
						<div class="selWrap w75">
							<span id="countrySelectorSpan"></span>
							<select id="countrySelector" name="CountryID" class="w100" onchange="selectFrom();"
									value="<?= s('countryID');?>">
								<option><?= LOADING ?></option>
							</select>
						</div>

						<label class="w25"><?= FROM ?></label>
						<div class="selWrap w75">
							<span id="fromSelectorSpan"></span>
							<select id="fromSelector" name="FromID"class="w100" onchange="selectTo();">
								<option> --- </option>
							</select>
						</div>

						<label class="w25"><?= TO ?></label>
						<div class="selWrap w75">
							<span id="toSelectorSpan"></span>
							<select id="toSelector" name="ToID" class="w100">
								<option> --- </option>
							</select>
						</div>


					<label class="w25"><?= PICKUP_DATE ?></label>
					<input type="text"  id="transferDate" class="w25 datepicker" name="transferDate" readonly >
					<br>



					<label class="w25"><?= PICKUP_TIME?></label>
					<span>
					<input type="text" id="transferTime" class=" w25 timepick" name="transferTime">
					</span>
					<br>

					<label class="w25"><?= PASSENGERS_NO ?></label>
					<div class="selWrap w25">
						<span id="paxSelectorSpan">---</span>
						<select id="paxSelector" class="w100" name="PaxNo">
							<option value="0"> --- </option>
							<option value="1"> 1 </option>
							<option value="2"> 2 </option>
							<option value="3"> 3 </option>
							<option value="4"> 4 </option>
							<option value="5"> 5 </option>
							<option value="6"> 6 </option>
							<option value="7"> 7 </option>
							<option value="8"> 8 </option>
							<option value="9"> 9 </option>
						</select>
					</div>
					<br>

					<label class="w25"><?= RETURN_TRANSFER ?></label>
					<div class="selWrap w25">
						<span id="returnSpan"><?= NO ?></span>
						<select id="returnTransfer" class="w100" name="returnTransfer">
							<option value="0"> <?= NO ?> </option>
							<option value="1"> <?= YES ?> </option>
						</select>

					</div>
					<br>
					<div id="showReturn" style="display:none">
						<label class="w25"><?= RETURN_DATE ?></label>
						<input type="text"  id="returnDate" class="w25 datepicker" name="returnDate" readonly >
						<br>
						<label class="w25"><?= RETURN_TIME ?></label>
						<span>
						<input type="text" id="returnTime" name="returnTime" class=" w25 timepick">
						</span>
					</div>


					<label class="w25"><?= YOUR.' '.NAME ?></label>
					<div class="w75">
						<input type="text" id="PaxFirstName" name="PaxFirstName" class="w50" placeholder="First name">
						<input type="text" id="PaxLastName" name="PaxLastName" class="w50" placeholder="Last name">
					</div>

					<label class="w25"><?= YOUR.' '.EMAIL?></label>
					<input type="text" id="PaxEmail" name="PaxEmail" class="w75" placeholder="myemail@mysite.com">
					<br><br>

					<p class="push-right">
						<button id="btnContinue" type="submit" class="btn blue-1 w100">
							<h3><i class="ic-checkmark-circle"></i> <?= SELECT_CAR ?></h3>
						</button>
					</p>

				</div>

			</div>

		</div>

		<div id="selectCar" class="hidden"></div>
		<div id="selectExtras" class="hidden"></div>
		<div id="paymentData" class="hidden"></div>
	</form>


</div>
<script src="../js/ztest.js" type="text/javascript"></script>
<script>
    selectCountry('<?= $_SESSION['countryID'] ?>');

    $("#btnContinue").click(function(){

/* privremeno izbaceno

        if (validateBookingForm() == false) {
            return false;
        }
*/
        var bookingFormData = $("#bookingForm").serialize();

        $.ajax({
          type: "POST",
          url: "./bf/a/test.php",
          data: bookingFormData
        }).done(function( msg ) {
                    $("#selectCar").html( msg );
                    $('#selectCar').slideDown('slow');
                    $('html, body').animate({scrollTop: $('#selectCar').offset().top }, 1500);

                    $("#selectExtras").slideUp('slow');
                    $("#paymentData").slideUp('slow');
        });
        return false;
    });


</script>

