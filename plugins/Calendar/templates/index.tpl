<div class="row-fluid">
	<div class="">
		<div class="col-md-1" style="width:99% !important;">
			<div class="dp_content">
				<div align="center">
					<select name="cal_month" id="cal_month" onchange="calendar()">
						{html_options values=$month_val selected=$month_sel output=$month_out}
					</select>
					<select name="cal_year"  id="cal_year" onchange="calendar()">
						{html_options values=$year_val selected=$year_sel output=$year_out}
					</select>
				</div>
				<div id="cal" align="center">
				</div>
				<br/><br/>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
{literal}
	calendar();
	function calendar() {
		$.get(
			'plugins/Calendar/calendar.php', 
			{cal_month: $('#cal_month').val(), cal_year: $('#cal_year').val()},
			function(data) {
				$('#cal').html(data);
			}
		);
		$('#xMonth').val($('#cal_month').val());
	}	
{/literal}		
</script>