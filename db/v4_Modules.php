<?
require_once 'db.class.php';

Class v4_Modules {

	public $ModulID; //int(11)
	public $Name; //varchar(20)
	public $Code; //varchar(20)
	public $Base; //varchar(20)
	public $ParentID; //int(11)
	public $MenuOrder; //int(11)
	public $Icon; //int(11)
	public $connection;

	function __construct(){
		$this->connection = new DataBaseMysql();
	}	
	public function myreal_escape_string($string){
		return $this->connection->real_escape_string($string);
	}

	public function fieldValues(){
		$fieldValues = array(
			'ModulID' => $this->getModulID(),
			'Name' => $this->getName(),
			'Code' => $this->getCode(),
			'Base' => $this->getBase(),
			'ParentID' => $this->getParentID(),
			'MenuOrder' => $this->getMenuOrder(),
			'Icon' => $this->getIcon()		);
		return $fieldValues;
	}
	public function fieldNames(){
		$fieldNames = array('ModulID','Name','Code','Base','ParentID','MenuOrder','Icon');
		return $fieldNames;
	}
	
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Modules where ModulID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ModulID = $row["ModulID"];
			$this->Name = $row["Name"];
			$this->Code = $row["Code"];
			$this->Base = $row["Base"];
			$this->ParentID = $row["ParentID"];
			$this->MenuOrder = $row["MenuOrder"];
			$this->Icon = $row["Icon"];
		}
	}

	public function getKeysBy($column, $order, $where = NULL){
		$keys = array(); $i = 0;
		$result = $this->connection->RunQuery("SELECT ModulID from v4_Modules $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["ModulID"];
				$i++;
			}
		return $keys;
	}

	public function getModulID(){
		return $this->ModulID;
	}
	public function getName(){
		return $this->Name;
	}
	public function getCode(){
		return $this->Code;
	}	
	public function getBase(){
		return $this->Base;
	}	
	public function getParentID(){
		return $this->ParentID;
	}	
	public function getMenuOrder(){
		return $this->MenuOrder;
	}	
	public function getIcon(){
		return $this->Icon;
	}

	public function endv4_Modules(){
		$this->connection->CloseMysql();
	}
}