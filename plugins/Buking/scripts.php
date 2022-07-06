<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://<?= $_SERVER['HTTP_HOST'] ?>/all.css" media="screen">
<link rel="stylesheet" type="text/css" href="../js/jQuery/jquery-ui-1.8.9.custom.css">
<link rel="stylesheet" type="text/css" href="../js/jQuery/jquery.ui.datepicker.css">
<link rel="stylesheet" type="text/css" href="../js/jQuery/jquery-ui-timepicker.css">

<script>
    var WEBPATH = "https://<?= $_SERVER['HTTP_HOST'] ?>";
</script>

<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/all.js"></script>
<script src="../js/jQuery/jquery.ui.core.js"></script>
<script src="../js/jQuery/jquery.ui.timepicker.js"></script>

<script type="text/javascript">

    $(document).ready(function(){

        <?
        $AuthUserID = $_SESSION['AuthUserID'];
        $local = isLocalAgent($AuthUserID);
        //$local=1;
        if ($local == 1) {
        ?>

        <? 	# LIMIT BOOKING DATE & TIME
        # UNIJETI dateLimit ili hourLimit, a onaj drugi staviti na nulu
        # ako se unesu oba onda se limitira i broj dana i broj sati nakon toga
        ?>
        <? 	# LIMIT BOOKING DATE & TIME
        # UNIJETI dateLimit ili hourLimit, a onaj drugi staviti na nulu
        # ako se unesu oba onda se limitira i broj dana i broj sati nakon toga
        ?>
        var currentDate 	= new Date();
        var currentTime 	= currentDate.getHours();
        var dateLimit 		= 0;
        var hourLimit   	= currentTime-1;

        var limitDate = new Date(currentDate.getFullYear(),currentDate.getMonth(),currentDate.getDate()
            +dateLimit);

        $("#transferDate").datepicker({
            dateFormat: 'yy-mm-dd',
            showOtherMonths: true,
            selectOtherMonths: true,
            minDate: dateLimit,
            onSelect: function(dateStr) {
                $("#returnDate").datepicker('option', 'minDate', dateStr);
                $("#transferTime").val('');
            }
        });

        $("#returnDate").datepicker({
            dateFormat: 'yy-mm-dd',
            showOtherMonths: true,
            selectOtherMonths: true,
            minDate: dateLimit,
            onSelect: function(dateStr) {
                $("#returnTime").val('');
            }
        });

        $('#transferTime').timepicker({
            onHourShow: function( hour ) {
                if ( $('#transferDate').val() == $.datepicker.formatDate ( 'yy-mm-dd', limitDate ) ) {
                    if ( hour <= hourLimit ) {
                        return false;
                    }
                }
                return true;
            }

        });

        $('#returnTime').timepicker({
            onHourShow: function( hour ) {
                if ( $('#returnDate').val() == $.datepicker.formatDate ( 'yy-mm-dd', limitDate ) ) {
                    if ( hour <= hourLimit ) {
                        return false;
                    }
                }
                if( $("#returnDate").val() == $("#transferDate").val() ) {
                    limit = parseInt( $("#transferTime").val() +1, 10);
                    if ( hour <= limit ) {
                        return false;
                    }
                }
                return true;
            }
        });

        <? } else { ?>

        <? 	# LIMIT BOOKING DATE & TIME
        # UNIJETI dateLimit ili hourLimit, a onaj drugi staviti na nulu
        # ako se unesu oba onda se limitira i broj dana i broj sati nakon toga
        ?>
        var currentDate 	= new Date();
        var currentTime 	= currentDate.getHours();
        var dateLimit 		= 0;
        var hourLimit   	= 6;
        var limitT			= parseInt(currentTime + hourLimit, 10);

        if( limitT > 24 ) {
            dateLimit += 1;
            limitT = limitT - 24;
        }
        var limitDate = new Date(currentDate.getFullYear(),currentDate.getMonth(),currentDate.getDate()
            +dateLimit);

        $("#transferDate").datepicker({
            dateFormat: 'yy-mm-dd',
            showOtherMonths: true,
            selectOtherMonths: true,
            minDate: dateLimit,
            onSelect: function(dateStr) {
                $("#returnDate").datepicker('option', 'minDate', dateStr);
                $("#transferTime").val('');
                $("#transferDate").removeClass("fldError");
            }
        });

        $("#returnDate").datepicker({
            dateFormat: 'yy-mm-dd',
            showOtherMonths: true,
            selectOtherMonths: true,
            minDate: dateLimit,
            onSelect: function(dateStr) {
                $("#returnTime").val('');
            }
        });

        $('#transferTime').timepicker({
            onHourShow: function( hour ) {
                if ( $('#transferDate').val() == $.datepicker.formatDate ( 'yy-mm-dd', limitDate ) ) {
                    if ( hour <= limitT ) {
                        return false;
                    }
                }
                $("#transferTime").removeClass("fldError");
                return true;
            }
        });

        $('#returnTime').timepicker({
            onHourShow: function( hour ) {
                if ( $('#returnDate').val() == $.datepicker.formatDate ( 'yy-mm-dd', limitDate ) ) {
                    if ( hour <= limit ) {
                        return false;
                    }
                }
                if( $("#returnDate").val() == $("#transferDate").val() ) {
                    limit = parseInt( $("#transferTime").val() +1, 10);
                    if ( hour <= limit ) {
                        return false;
                    }
                }
                return true;
            }
        });

        <? } ?>

    }); // end doc ready
</script>

