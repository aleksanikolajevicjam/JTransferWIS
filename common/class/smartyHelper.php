<?

class SmartyHtmlSelection 
{
	private $smarty;
	private $name;
	private $values;
	private $output;
	private $selected;
	
	function __construct($name, & $smarty)
	{
		$this->name	= $name;
		$this->smarty = $smarty;
		$this->values = array();
		$this->output = array();
		$this->selected = array();
	}

	function AddValue($val)
	{
		array_push($this->values, $val);
	}
	
	function AddOutput($out)
	{
		array_push($this->output, $out);
	}
	
	function GetOutput()
	{
		return $this->output;
	}
	
	function AddSelected($sel)
	{
		array_push($this->selected, $sel);
	}
	
	function SmartyAssign()
	{
		$this->smarty->assign($this->name."_out",$this->output);
		$this->smarty->assign($this->name."_sel",$this->selected);
		$this->smarty->assign($this->name."_val",$this->values);
		
	}
} 
?>