<?
	/* CMS Studio 2.0 factoryBase.php */

abstract class factoryBase
{
	private $DBBR;
	private $sortby;
	private $direction;
	
	public $filters; // ???? why public 
	private $offset;
	private $limit;
	
	function AddLimit($limit)
	{
		$this->limit = $limit;
	}
	function GetLimit()
	{
		return $this->limit;
	}
	function AddOffset($offset)
	{
		$this->offset = $offset;
	}
	
	function GetOffset()
	{
		return $this->offset;		
	}
	function AddFilter($f)
	{
		array_push($this->filters,$f);
	}
	
	function AddSort($f)
	{
		$this->sortby = $f;		
	}
	
	function GetFilters()
	{
		$ret_value ="";
			
		foreach ($this->filters as $filter) 
		{
			if($filter == "") continue;
			$ret_value .= " AND ".$filter;
		}	
		return $ret_value;	
	}
	function ResetFilters()
	{
		$this->filters = array();		
	}
	function ResetLimitOffset()
	{
		$this->limit = 0;
		$this->offset =0;
		$this->sortby ="";
		$this->direction ="";
	}
	
	function Reset()
	{
		$this->filters = array();
		$this->limit = 0;
		$this->offset =0;
		$this->sortby ="";
		$this->direction ="";	
	}
	
	function SetSortBy($sort,$dir = "")
	{
		$this->sortby = $sort;
		$this->direction = $dir;
		
	}
	function GetSortBy()
	{
		if($this->sortby != "")
		{
			return $this->sortby . " " . $this->direction;
		}
		
		return "";
	}
	function ResetSortBy()
	{
		$this->sortby = "";
		$this->direction = "";
	}
	
	function GetSortByLink()
	{
		if($this->sortby != "")
			return "&sortby=".$this->sortby."&"."direction=". $this->direction;
		else 
			return "";
	}
	
	// concrete factory must override this functions
	function createObject($name,$id){}
	function createObjects($name){}
}
?>