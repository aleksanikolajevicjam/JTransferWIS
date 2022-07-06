<script>

    $(".timepicker").JAMTimepicker();
    //$(".timepicker").pickatime({format: 'HH:i', interval: 10});

    function toggleCheck(inputFld) {
        var checked = $("#Detail_"+inputFld).prop("checked");
        if(checked == true) $("#Det_" + inputFld).val('1');
        else $("#Det_" + inputFld).val('0');
    }



    function timeDifference(id, startFld, endFld, changeFld, week) {
        var startTime = $("#"+startFld+id).val();
        var endTime = $("#"+endFld+id).val();

        var startDate = new Date("January 1, 1970 " + startTime);
        var endDate = new Date("January 1, 1970 " + endTime);
        var timeDiff = Math.abs(startDate - endDate);

        var hh = Math.floor(timeDiff / 1000 / 60 / 60);
        if(hh < 10) {
            hh = '0' + hh;
        }
        timeDiff -= hh * 1000 * 60 * 60;
        var mm = Math.floor(timeDiff / 1000 / 60);
        if(mm < 10) {
            mm = '0' + mm;
        }
        timeDiff -= mm * 1000 * 60;
        var ss = Math.floor(timeDiff / 1000);
        if(ss < 10) {
            ss = '0' + ss;
        }
        $("#"+changeFld+id).val(hh + ":" + mm);
        timeTotal(id, week);
        //alert("Time Diff- " + hh + ":" + mm + ":" + ss);
    }

    function timeTotal(id, week) {

        
        var redovno     = $("#ukRedovno_"+id).val();
        var pauza       = $("#ukPauza_"+id).val();
        var nedjelja    = $("#ukNedjelja_"+id).val();
        var noc         = $("#ukNoc_"+id).val();
        var praznik     = $("#ukPraznik_"+id).val();

        var hour=0;
        var minute=0;
        var second=0;

        var splitTime1= redovno.split(':');
        var splitTime2= pauza.split(':');
        var splitTime3= nedjelja.split(':');
        var splitTime4= noc.split(':');
        var splitTime5= praznik.split(':');


        hour = parseInt(splitTime1[0])-parseInt(splitTime2[0])+parseInt(splitTime3[0])+parseInt(splitTime4[0])+parseInt(splitTime5[0]);
        minute = parseInt(splitTime1[1])-parseInt(splitTime2[1])+parseInt(splitTime3[1])+parseInt(splitTime4[1])+parseInt(splitTime5[1]);
        hour = hour + minute/60;

        hour = Math.abs(hour);
        minute = Math.abs(minute);

        $("#ukupno_"+id).val( parseInt(hour).pad(2) + ":" + parseInt(minute).pad(2) );


        // Ukupno redovno
        var ukupnoRedovnoTjedan = '00:00';
        $('.ukRedovno'+week).each(function(index, item) {
            ukupnoRedovnoTjedan = timeCalc(ukupnoRedovnoTjedan, $(item).val() );
        });
        $("#ukRedovno_w"+week).val(ukupnoRedovnoTjedan);

        var ukupnoRedovnoMjesec = '00:00';
        $('.ukRedovno_w').each(function(index, item) {
            ukupnoRedovnoMjesec = timeCalc(ukupnoRedovnoMjesec, $(item).val() );
        });
        $("#ukRedovno_M").val(ukupnoRedovnoMjesec);


		//Ukupno pauza
		var ukupnoPauzaTjedan = '00:00';
        $('.ukPauza'+week).each(function(index, item) {
            ukupnoPauzaTjedan = timeCalc(ukupnoPauzaTjedan, $(item).val() );
        });
        $("#ukPauza_w"+week).val(ukupnoPauzaTjedan);

        var ukupnoPauzaMjesec = '00:00';
        $('.ukPauza_w').each(function(index, item) {
            ukupnoPauzaMjesec = timeCalc(ukupnoPauzaMjesec, $(item).val() );
        });
        $("#ukPauza_M").val(ukupnoPauzaMjesec);

		//Ukupno noc
		var ukupnoNocTjedan = '00:00';
        $('.ukNoc'+week).each(function(index, item) {
            ukupnoNocTjedan = timeCalc(ukupnoNocTjedan, $(item).val() );
        });
        $("#ukNoc_w"+week).val(ukupnoNocTjedan);

        var ukupnoNocMjesec = '00:00';
        $('.ukNoc_w').each(function(index, item) {
            ukupnoNocMjesec = timeCalc(ukupnoNocMjesec, $(item).val() );
        });
        $("#ukNoc_M").val(ukupnoNocMjesec);


		//Ukupno nedjelja
		var ukupnoNedjeljaTjedan = '00:00';
        $('.ukNedjelja'+week).each(function(index, item) {
            ukupnoNedjeljaTjedan = timeCalc(ukupnoNedjeljaTjedan, $(item).val() );
        });
        $("#ukNedjelja_w"+week).val(ukupnoNedjeljaTjedan);

        var ukupnoNedjeljaMjesec = '00:00';
        $('.ukNedjelja_w').each(function(index, item) {
            ukupnoNedjeljaMjesec = timeCalc(ukupnoNedjeljaMjesec, $(item).val() );
        });
        $("#ukNedjelja_M").val(ukupnoNedjeljaMjesec);


		//Ukupno praznik
		var ukupnoPraznikTjedan = '00:00';
        $('.ukPraznik'+week).each(function(index, item) {
            ukupnoPraznikTjedan = timeCalc(ukupnoPraznikTjedan, $(item).val() );
        });
        $("#ukPraznik_w"+week).val(ukupnoPraznikTjedan);

        var ukupnoPraznikMjesec = '00:00';
        $('.ukPraznik_w').each(function(index, item) {
            ukupnoPraznikMjesec = timeCalc(ukupnoPraznikMjesec, $(item).val() );
        });
        $("#ukPraznik_M").val(ukupnoPraznikMjesec);


		//Ukupno
		var ukupnoTjedan = '00:00';
        $('.ukupnoDan'+week).each(function(index, item) {
            ukupnoTjedan = timeCalc(ukupnoTjedan, $(item).val() );
        });
        $("#ukupno_w"+week).val(ukupnoTjedan);

        var ukupnoMjesec = '00:00';
        $('.ukupno_w').each(function(index, item) {
            ukupnoMjesec = timeCalc(ukupnoMjesec, $(item).val() );
        });
        $("#ukupno_M").val(ukupnoMjesec);


    }


    function timeCalc(time1, time2) {
        var hour=0;
        var minute=0;
        var second=0;



        var splitTime1= time1.split(':');
        var splitTime2= time2.split(':');



        hour = parseInt(splitTime1[0])+parseInt(splitTime2[0]);
        minute = parseInt(splitTime1[1])+parseInt(splitTime2[1]);
        hour = hour + minute/60;

        hour = Math.abs(hour);
        minute = Math.abs(minute);

        return parseInt(hour).pad(2) + ":" + parseInt(minute).pad(2);
    }



    function addShift(id) {

        var shifts = $("#shifts").val();
        var shift1 = $("#shift1id").val();
        var shift2 = $("#shift2id").val();

        if( $("#Smjena_"+id).is(":visible") ) {

            $("#Smjena_"+id).hide('slow');
            shifts = parseInt(shifts) - parseInt(1);
            $("#shifts").val(shifts);
            if(shift1 == id) { $("#shift1id").val(0); }
            if(shift2 == id) { $("#shift2id").val(0); }

            if(shifts >= 2) {
                alert('Only 2 shifts allowed');
            }

            //return false;
        } else {

            if(shifts < 2) {
                $("#Smjena_"+id).show('slow');
                shifts = parseInt(shifts) + parseInt(1);
                $("#shifts").val(shifts);

                if(shifts == 1) { $("#shift1id").val(id); $("#shift2id").val(0);}
                if(shifts == 2 && shift2 == 0) { $("#shift2id").val(id); }
                else { $("#shift1id").val(id); }


            } else {
                alert('Dozvoljene su samo dvije smjene u danu');
                return false;
            }

            if(shifts == 0) { $("#shift1id").val(0); $("#shift2id").val(0);}
        }


        return false;
    }


    // hours and minutes padding with zeroes
    Number.prototype.pad = function(size) {
      var s = String(this);
      while (s.length < (size || 2)) {s = "0" + s;}
      return s;
    }
</script>
