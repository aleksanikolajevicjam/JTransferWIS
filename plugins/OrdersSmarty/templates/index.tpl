<div class="ibox float-e-margins">
	<div class="ibox-title">
		
		<div class="ibox-tools">
			<a class="collapse-link">
					<i class="fa fa-chevron-up"></i>
			</a>
			<a class="fullscreen-link">
                <i class="fa fa-expand"></i>
            </a>

			<a class="close-link">
				<i class="fa fa-times"></i>
			</a>
		</div>
	</div>
	<div class="ibox-content">
		<div class="table-responsive">
		   <div id="content">
	   
				{html_table_advanced 
					filter=$filter		  
					browseString=$tbl_browseString 
					scriptName=$scriptName 
					cnt_rows=$tbl_row_count 
					rowOffset=$tbl_offset 
					tr_attr=$tbl_tr_attributes 
					td_attr=$tbl_td_attributes 
					loop=$tbl_content 
					cols=$tbl_cols_count 
					tableheader=$tbl_header 
					table_attr='cellspacing=0 class="index" id="normal"'
					message=$poruka 
					}
			</div>
		</div>	
	</div>
</div>