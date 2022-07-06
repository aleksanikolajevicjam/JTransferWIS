<?
#doc
#	classname:	CSV
#	scope:		PUBLIC
#
#/doc

class ExportCSV 
{
	#	internal variables
	private $csv; 
	public $delimiter = ";";
	public $File = "CSV";
	public $Extension = '.csv';
	public $totalOnCols = array(); // redni broj kolone za koju se radi total. pocinje od 1!
	public $totals = array(); // array sa totalima za kolone
	private $colsCount = 0; 

	public function addHeader($row) {
		$this->colsCount = count($row);
		foreach($row as $key => $value) {
			$this->csv .= $value . $this->delimiter;
		}
		$this->csv .= "\n";
	}	

	public function addRow($row) {

		foreach($row as $key => $value) {
			if(in_array($key+1, $this->totalOnCols)) {
				$this->totals[$key] += $value;
			}
			$this->csv .= $value . $this->delimiter;
		}
		
		$this->csv .= "\n";
	}
	
	public function addTotalRow() {
		
		for($i=0; $i< $this->colsCount; $i++) {
			
			if(in_array($i+1, $this->totalOnCols)) {
				$this->csv .= $this->totals[$i] . $this->delimiter;
			}
			else {
				$this->csv .= '' . $this->delimiter;
			}
		}
		$this->csv .= "\n";
	}
	
	public function save() {
		$fp = fopen($this->File.$this->Extension, 'w');
		fwrite($fp, $this->csv);
		fclose($fp);
	}

}
###
