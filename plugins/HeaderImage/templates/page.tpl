<form name="headerImages" method="post" action="">
<div class="container">
<div class="box box-info pad1em shadowLight">
<br>

	<div class="row">
		<div class="col-md-6">{$FIRST_IMAGE}</div>
		<div class="col-md-6"><input type="text" name="firstImage" value="{$img[0]}"></div>

		<div class="col-md-6">{$SECOND_IMAGE}</div>
		<div class="col-md-6"><input type="text" name="secondImage" value="{$img[1]}"></div>
	
		<div class="col-md-6">{$THIRD_IMAGE}</div>
		<div class="col-md-6"><input type="text" name="thirdImage" value="{$img[2]}"></div>
	
		<div class="col-md-6"></div>
		<div class="col-md-6">
			<br>
			<button name="setImages" type="submit" class="btn btn-primary" value="1">{$SET_IMAGES}</button>
		</div>		
	</div>
</div>