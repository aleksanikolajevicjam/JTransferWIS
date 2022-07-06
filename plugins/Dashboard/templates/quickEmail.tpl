
    <!-- quick email widget -->
    <div class="box box-info">
        <div class="box-header">
            <i class="fa fa-envelope"></i>
            <h3 class="box-title">{$QUICK_EMAIL}</h3>
            <!-- tools box -->
            <div class="pull-right box-tools">
                
                <button class="btn btn-info btn-sm" data-widget='collapse' 
                data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                
                <button class="btn btn-info btn-sm" data-widget='remove' 
                data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                
            </div><!-- /. tools -->
        </div>
        <div class="box-body">
            <form id="quickEmail" action="#" method="post">
                <div class="form-group">
                	{$FROM}: {$smarty.session.UserEmail}<br> 
                    <input type="email" class="form-control" id="emailto" 
                    placeholder="{$EMAIL_TO}" value=""/>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="subject" 
                    placeholder="{$SUBJECT}"/>
                </div>
                <div>
                    <textarea class="textarea" placeholder="{$MESSAGE}" id="message"
                    style="width: 100%; height: 125px; font-size: 14px; 
                    line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
            </form>
        </div>
        <div class="box-footer clearfix">
        	
            <button class="pull-right btn btn-default" id="sendEmail">
            	{$SEND} <i class="fa fa-arrow-circle-right"></i>
            	<span id="messageStatus"></span>
            </button>
        </div>
    </div>
                          
<script type="text/javascript">
	$("#sendEmail").click(function(){
		var url = window.root +'/cms/api/'+
		"testEmailForNewApp.php?to=" + $("#emailto").val() +
		"&subject=" + $("#subject").val() +
		"&message=" + $("#message").val() +
		"&callback=?";
	
		$.ajax({
			type: 'POST',
			url: url,
			async: false,
			contentType: "application/json",
			dataType: 'jsonp',
			success: function(data) {
				$("#messageStatus").html(data);
				$("textarea#message").val('');
				$("#subject").val('');
			}
		});
		return false;
	});
	
</script>                            
