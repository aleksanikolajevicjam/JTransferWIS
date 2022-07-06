<style>
.updatedTransferTile {
	display: block;
}
.updatedTransferTile:hover {
	color: black;
	background: #BBDEFB;
}
.fa-jam {
	width: 30px;
	height: 30px;
	border-radius: 50%;
	text-align: center;
	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
	font-size: 15px;
	line-height: 30px;
}
.update-icon {
	text-align: center;
	line-height: 60px;
}
</style>

<script type="text/x-handlebars-template" id="v4_OrderLogListTemplate">
	{{#each v4_OrderLog}}
		<a href="/cms/index.php?p=editActiveTransfer&rec_no={{DetailsID}}"
		class="row {{color}} pad1em listTile updatedTransferTile" 
		id="t_{{ID}}">

			<div class="col-md-2">
				<i class="fa fa-user"></i> <strong>{{PaxName}}</strong>
			</div>
	
			<div class="col-md-2">
				<strong>{{OrderID}} - {{TNo}}</strong><br>
				{{addNumbers DetailPrice ExtraCharge}} €<br>
				<small>{{displayTransferStatusText TransferStatus}}</small>
			</div>

			<div class="col-md-4">
				<strong>{{PickupName}} - {{DropName}}</strong><br>
				<small>{{PickupDate}} {{PickupTime}}</small>
			</div>

			<div class="col-md-4">
				<div class="row">
					<div class="col-md-2 update-icon">
						<i class="{{Icon}} fa-jam"></i>
					</div>
					<div class="col-md-10">
						{{Title}}<br>
						{{AuthUserRealName}} - {{Action}}<br>
						<small><i class="fa fa-clock-o"></i> {{DateAdded}} {{TimeAdded}}</small>
					</div>
				</div>
			</div>
		</a>
	{{/each}}
</script>

