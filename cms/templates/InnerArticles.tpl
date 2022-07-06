<!DOCTYPE html>

	<div class="container white">

	{section name=pom loop=$data}
		<a  id="header" onclick="show({$data[pom].id});">
		
			<div class="row xbox-solid xbg-light-blue  pad1em listTile" 
			style="border-top:1px solid #eee;border-bottom:0px solid #eee">
				<h3>{$data[pom].header}</h3>
			</div>
		</a>
		
		<div id="transferWrapper{$data[pom].id}" class="editFrame" style="display:none">
			<div id="inlineContent" class="row ">
				<div  class="xcol-md-12">
					{$data[pom].html}
				</div>
			</div>
		</div>

	{/section}			 
    
	
	</div>
	
<script>	
function show(id) {
	id ="#transferWrapper"+id;
	if($(id).css('display') == 'none') $(id).show(500);
	else $(id).hide(500);

}
</script> 