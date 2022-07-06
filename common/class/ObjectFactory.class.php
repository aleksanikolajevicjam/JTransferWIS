<?

include_once("MetaClasses.class.php");

class ObjectFactory extends factoryBase 
{
	private $object;
	private $metaClasses;
	private $debug;
	
	// for measuring time
	private $timeStart;
	private $timeEnd;
	
	public $DBBR;
	private static $instance;
	
	public static function getInstance()
	{
		if(!isset(self::$instance))
		{
			$object= __CLASS__;
			self::$instance=new $object;
		}
		
		return self::$instance;
	}
	
	function __construct()
	{
		//$this->DBBR = DatabaseBroker::getInstance();
		
		$this->metaClasses = new MetaClasses();
		$this->metaClasses->LoadXMLData(ROOT_HOME."config/classes.xml");
		
		$this->sortBy = "";
		$this->filters = array();
		$this->limit = 0;
		$this->offset = 0;
		
		$this->debug = false;
	}
	
	function createObject($class_name, $id=-1, $class_array=array(), $selectAttributes = "*")
	{
		try
		{
			$this->timeStart = explode( ' ', microtime() );
	
			$meta_class_info = $this->metaClasses->GetMetaClassByName($class_name);
			$this->loadIfNotExists($class_name);
			$this->object = new $class_name;

			if($id == -1) return $this->object;

			eval("\$this->object->set".$meta_class_info->getPrimaryKeyAttr()."('".$id."');");
			$this->DBBR->nadjiSlogVratiGa($this->object, $selectAttributes);
			
			if($this->debug) $this->DBBR->Debug();
			if($this->object->DbStatus != "Found") return $this->object;
	
			foreach ($class_array as $relation_class)
			{
				$this->loadIfNotExists($relation_class);
				$meta_class_info = $this->metaClasses->GetMetaClassByName($class_name);
				$relation_type = $meta_class_info->getRelationType($relation_class);
				
				if($relation_type == "") break;
				
				switch($relation_type)
				{
					case "1-1":
							eval("\$tmpobj1 = \$this->object->".$relation_class.";");
							$this->DBBR->poveziSaJednim($this->object, $tmpobj1);
							if($this->debug) $this->DBBR->Debug();
						break;
					case "1-M": 
					case "M-M": 
							// kreiranje novih objekata moze izazvati gazenje $this->object-a jer
							// je klasa ObjectFactory staticka pa su i njegovi atributi staticki bar se tako ponasaju	
							$inner_object = clone $this->object;
							if(strpos($relation_class,"List") !== false)
							{
								$relation_class = substr($relation_class,0,strlen($relation_class)-4);
							}
							eval("\$tmpobj2 = new ".$relation_class."();");	
							$this->DBBR->poveziSaVise($inner_object, $tmpobj2,"*",$this->GetFilters(),$this->GetSortBy());
							$this->object = $inner_object;
							if($this->debug) $this->DBBR->Debug();
						break;
					default:
				}
			}
			$this->timeEnd= explode( ' ', microtime() );
			return clone $this->object;
		}
		catch (Exception $ex)
		{
			echo "GRESKA BATO".$ex;
		}
	}
	
	function createObjects($class_name, $class_array=array(), $selectAttributes="*")
	{
		try
		{
			$this->timeStart = explode( ' ', microtime() );
			$back_array = array();
			$back_array_tmp = array();
			
			$this->loadIfNotExists($class_name);
			
			$this->object = new $class_name;
			
			$this->DBBR->vratiSveSlogove($this->object,$back_array_tmp,$selectAttributes,$this->GetFilters(),$this->GetSortBy(),$this->GetLimit(),$this->GetOffset());
					
			if($this->debug) $this->DBBR->Debug();
			if(count($back_array_tmp) == 0) return null;
			
			foreach ($back_array_tmp as $ba)
			{
				if(count($class_array)>0)
				{
					foreach ($class_array as $relation_class)
					{
						$this->loadIfNotExists($relation_class);
						$meta_class_info = $this->metaClasses->GetMetaClassByName($class_name);
						$relation_type = $meta_class_info->getRelationType($relation_class);
						if($relation_type == "") break;
						switch($relation_type)
						{
							case "1-1":
									eval("\$tmpobj1 = \$ba->".$relation_class.";");
									$this->DBBR->poveziSaJednim( $ba, $tmpobj1);
									if($this->debug) $this->DBBR->Debug();
								break;
							case "1-M":
							case "M-M":
									if(strpos($relation_class,"List") !== false)
									{
										$relation_class = substr($relation_class,0,strlen($relation_class)-4);
									}
									$tmpobj2 = new $relation_class;
									$this->DBBR->poveziSaVise( $ba, $tmpobj2);
									if($this->debug) $this->DBBR->Debug();
								break;
							default:
						}
					}
				}
				array_push($back_array,$ba);
			}
			$this->timeEnd= explode( ' ', microtime() );
			return $back_array;
		}
		catch (Exception $ex)
		{
			echo $ex;
		}
	}
	
	public function ManageSort()
	{
		$direction = "asc";
		$sortby = "";
		
		if(isset($_REQUEST["sortby"]))
		{
			if(isset($_REQUEST["direction"]) && (strtolower($_REQUEST["direction"]) == "asc" || strtolower($_REQUEST["direction"]) == "desc"))
			{
				$direction = $_REQUEST["direction"];
				$_SESSION["direction"]=$direction;
			}
			
			//$sortby = $this->quote_smart($_REQUEST["sortby"]);
			$sortby = $_REQUEST["sortby"];
			$_SESSION["sortby"]=$sortby;
			
			$this->SetSortBy($sortby,$direction);
		}
		else if(isset($_SESSION["sortby"])) 
		{
			if(isset($_SESSION["direction"]) && (strtolower($_SESSION["direction"]) == "asc" || strtolower($_SESSION["direction"]) == "desc"))
			{
				$direction = $_SESSION["direction"];
			}
			
			//$sortby = $this->quote_smart($_REQUEST["sortby"]);
			$sortby = $_SESSION["sortby"];
			
			$this->SetSortBy($sortby,$direction);				
		}
	}
	
	function quote_smart($value)
	{
		if (get_magic_quotes_gpc()) 
		{
			$value = stripslashes($value);
		}
		if (!is_numeric($value)) 
		{
			$db = new ezSQL_mysql;
			//$value = "'" . mysql_real_escape_string($value) . "'";
			$value = "'" . mysqli_real_escape_string($db->links,$value) . "'";	
		}
		if($value == -1)
		{
			$value = "NULL";
		}
		return $value;
	}
	
	function loadRelation(&$object, $class_array)
	{
		$this->timeStart = explode( ' ', microtime() );
		$this->object = & $object;
		
		$this->timeEnd= explode( ' ', microtime() );
		return $back_array_tmp;
	}	
	
	function getLastExectionTime()
	{
		$startTime = $this->timeStart[0] + $this->timeStart[1];
		$endTime = $this->timeEnd[0] + $this->timeEnd[1];
		return $endTime - $startTime;
	}
	
	function loadIfNotExists($class_name)
	{
		try
		{
			$meta_class_info = $this->metaClasses->GetMetaClassByName($class_name);
			//	echo $class_name."<br/>";
			if(!class_exists($meta_class_info->Name))
			{
				$path = ROOT_HOME."common/". $meta_class_info->getFile();
				include_once($path);
			}	
		}
		catch (Exception $ex)
		{
			throw $ex;
		}
	}
	
	function setDebugOn()
	{
		$this->debug = true;		
	}
	
	function setDebugOff()
	{
		$this->debug = false;		
	}
}
?>