<?

	/* CMS Studio 2.0 adminTable.php */

class AdminTable
{
	// naziv tabele
	private $tableTitle;
	// heder tabele
	private $tableHeader;
	// sadrzaj tabele
	private $tableContent;
	// broj redova na ekranu
	private $tableRowCount;
	private $tableColCount;
	private $tableCountAllRows;
	// naziv sesijske promenljive za offset
	private $tableOffsetName;
	// trenutna vrednost offseta
	private $tableOffset;
	// koliko je objekata bilo prikazano u prethodnom koraku
	private $tableLastPageCount;
	// ukupan broj zapisa tabele
	private $tableRecordCount;
	// string koji se dodaje na url
	private $tableBrowseString;
	// show export links
	private $exportLinks = false;
	
	private $table_TD_attributes;
	private $table_TR_attributes;
	private $filter;
	
	function __construct()
	{
		$this->tableTitle = "";
		$this->tableHeader = array("","","","","","","","width='10%'","width='5%' align='center'","width='5%' align='center'","width='5%' align='center'","width='5%' align='center'");
		$this->tableContent = array();
		$this->tableRowCount = 30;
		$this->tableColCount = 0;
		$this->tableCountAllRows = 0;
		$this->tableBrowseString = "t=1";
		$this->table_TD_attributes = array("","","","","width='10%'","width='5%' align='center'" ,"width='5%' align='center'","width='5%' align='center'","width='5%' align='center'");
		$this->table_TR_attributes = array("onmouseover=this.className='highlight'; onmouseout=this.className='none';");
		$this->filter = "";
	}
	
	function AddTableRow($array)
	{
		$this->tableContent = array_merge($this->tableContent, $array);
	}
	
	function ShowExportLinks()
	{
		$this->exportLinks = "true";
	}
	
	function GetRowCount()
	{
		return $this->tableRowCount;	
	}
	
	function SetRowCount($cnt)
	{
		$this->tableRowCount = $cnt;
	}
	
	function SetCountAllRows($cnt)
	{
		$this->tableCountAllRows = $cnt;
	}
	function SetColCount()
	{
		$this->tableColCount = count($this->tableHeader);
	}
	
	function SetOffsetName($name)
	{
		$this->tableOffsetName = $name;	
		
		// treba zapamtiti offset ako postoji
		if(isset($_REQUEST["offset"])){
			$this->tableOffset = $_REQUEST["offset"];
			if (!isset($_SESSION[$this->tableOffsetName])) 
			{
				$_SESSION[$this->tableOffsetName] = "";
				
			}
			$_SESSION[$this->tableOffsetName] = $this->tableOffset;
		} else {
			if(isset($_SESSION[$this->tableOffsetName])){
				$this->SetOffset($_SESSION[$this->tableOffsetName]);
			}
			else 
			{
				$this->SetOffset(0);
			}
		}
	}
	function SetHeader($array)
	{
		$this->tableHeader = $array;
		$this->SetColCount();
	}
	
	function SetTitle($title)
	{
		$this->tableTitle = $title;
	}
	
	function SetFilter($filter)
	{
		$this->filter = $filter;
	}
	
	function SetOffset($offset)
	{
		$this->tableOffset = $offset;
	}
	function GetOffset()
	{		
		if(!isset($_SESSION[$this->tableOffsetName."lastcount"]))
		{
			$_SESSION[$this->tableOffsetName."lastcount"] = "";
		}
		
		if($this->tableCountAllRows%$this->tableRowCount == 0 && $_SESSION[$this->tableOffsetName."lastcount"] == 1){
			$this->tableOffset = $this->tableOffset - $this->tableRowCount*$this->tableColCount;
			if($this->tableOffset < 0) $this->tableOffset = 0;
			$_SESSION[$this->tableOffsetName] = $this->tableOffset;
		}
		return $this->tableOffset/$this->tableColCount;
	}
	function SetBrowseString($factory)
	{
		// dodaju se parametri u browse string
		// koji pripadaju filteru i sort-u
		
		// za filtere
		if(count($factory->filters)>0)
		{
			foreach ($factory->filters as $f) 
			{
				$f = str_replace("'","",$f);
				if(strpos($f," IN ") === FALSE)
				{
					$this->tableBrowseString .= "&".$f;
				}
			}
		}
	
		// za sort
		$this->tableBrowseString .= $factory->GetSortByLink();
	}
	
	function SetTdTableAttributes($value)
	{
		$this->table_TD_attributes = $value;
	}
	
	function SetTrTableAttributes($value)
	{
		$this->table_TR_attributes = $value;
	}
	
	function AddBrowseString($str)
	{
		$this->tableBrowseString .= "&".$str;
	}
	function SetRecordCount($num)
	{
		//postavljamo broj trenutnih redova koje imamo u admin tabli
		$this->tableRecordCount = $num;
		
		if(isset($_SESSION[$this->tableOffsetName."lastcount"]))
		{
			$_SESSION[$this->tableOffsetName."lastcount"] = $this->tableRecordCount;
		}
		else
		{
			$_SESSION[$this->tableOffsetName."lastcount"] = $this->tableRecordCount;
		}
	}
	
	function RegisterAdminPage($smarty)
	{
		$smarty->assign("tbl_title",$this->tableTitle);
		$smarty->assign("filter",$this->filter);		
		$smarty->assign("tbl_header",$this->tableHeader);
		$smarty->assign("tbl_content",$this->tableContent);
		$smarty->assign("tbl_row_count",$this->tableRowCount);
		$smarty->assign("tbl_all_rows_count",$this->tableCountAllRows);
		$smarty->assign("tbl_cols_count",$this->tableColCount);
		$smarty->assign("tbl_show_export_links",$this->exportLinks);
		
		$smarty->assign("tbl_offset",$this->tableOffset);
		$smarty->assign("tbl_browseString",$this->tableBrowseString);
		
		$smarty->assign("tbl_tr_attributes",$this->table_TR_attributes);
		$smarty->assign("tbl_td_attributes",$this->table_TD_attributes);
	}
	
	function RegisterAdminPageSecond($smarty)
	{
		$smarty->assign("tbl_title2",$this->tableTitle);
		$smarty->assign("filter2",$this->filter);		
		$smarty->assign("tbl_header2",$this->tableHeader);
		$smarty->assign("tbl_content2",$this->tableContent);
		$smarty->assign("tbl_row_count2",$this->tableRowCount);
		$smarty->assign("tbl_all_rows_count2",$this->tableCountAllRows);
		$smarty->assign("tbl_cols_count2",$this->tableColCount);
		$smarty->assign("tbl_show_export_links2",$this->exportLinks);
		
		$smarty->assign("tbl_offset2",$this->tableOffset);
		$smarty->assign("tbl_browseString2",$this->tableBrowseString);
		
		$smarty->assign("tbl_tr_attributes2",$this->table_TR_attributes);
		$smarty->assign("tbl_td_attributes2",$this->table_TD_attributes);
	}	
}

?>