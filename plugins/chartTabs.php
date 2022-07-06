
                            <!-- solid sales graph -->
                            <div class="box box-danger">
                                <div class="box-header">
                                    <i class="fa fa-th"></i>
                                    <h3 class="box-title">Commision Graph - Total</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body border-radius-none">
                                    <div class="chart" id="month-chart" style="height: 250px;"></div>
                                    <div class="chart" id="year-chart" style="height: 200px;"></div>
                                </div><!-- /.box-body -->

                            </div><!-- /.box -->  



<script>

$.ajax({
	 type: 'GET',
	  url: window.root + '/cms/api/lineChartData.php?range=month&callback=?',
	  async: false,
	  contentType: "application/json",
	  dataType: 'jsonp',
	  success: function(data) {

			new Morris.Area({
				element: 'month-chart',
				resize: true,
				data: data,
				xkey: 'y',
				ykeys: ['Total'],
				labels: ['Total'],
				lineColors: ['#a0d0e0'],
				hideHover: 'auto'
			});
	  	}
});


var area={};
$.ajax({
	 type: 'GET',
	  url: window.root + '/cms/api/lineChartData.php?range=year&callback=?',
	  async: false,
	  contentType: "application/json",
	  dataType: 'jsonp',
	  success: function(data) {

			area = new Morris.Area({
				element: 'year-chart',
				resize: true,
				data: data,
				xkey: 'y',
				ykeys: ['Total'],
				labels: ['Total'],
				lineColors: ['#a0d0e0'],
				hideHover: 'auto'
			});
			
	  	}
});

    /* Morris.js Charts */
    // Sales chart
/*
    //Donut Chart
    var donut = new Morris.Donut({
        element: 'sales-chart',
        resize: true,
        colors: ["#3c8dbc", "#f56954", "#00a65a"],
        data: [
            {label: "Site", value: 12},
            {label: "Agents", value: 30},
            {label: "Email", value: 20}
        ],
        hideHover: 'auto'
    });
*/   
        //Fix for charts under tabs
    $('.box ul.nav a').on('shown.bs.tab', function(e) {
        area.redraw();
        //donut.redraw();
    });

</script>					                          
