{if $isNew}
<div id="ItemWrapperNew" class="editFrame container-fluid" style="display:none" ">
	<div id="inlineContentNew" class="row">
		<div id="new_Item"></div>
	</div>
</div>	
{else}
	<div id="show_Items">{$THERE_ARE_NO_DATA}</div>
{/if}