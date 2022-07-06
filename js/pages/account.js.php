<script type="text/javascript">

// final form validation
	jQuery.validator.setDefaults({
	  errorElement: "div"
	});
	$("#signupForm").validate({
		errorPlacement: function(error, element) {
    error.appendTo( element.parent("div") );
  },
		rules: {
			CustFirstName: {required:true, minlength:1},
			CustLastName: {required:true, minlength:2},
			CustEmail: {required:true, email:true},
			CustAddress: {required:true, minlength: 5},
			CustCity: {required:true, minlength: 5},
			CustZip: {required:true, minlength: 4},
			CustMobile: {required:true, minlength: 12},
			CustPass: {required:true, minlength:8}
		}
	});
	
</script>	
