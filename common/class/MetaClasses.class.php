<?
include_once("parseXML.php");
class MetaClasses
{
	var $Classes;
	
	var $XmlParser;
	
	function __construct()
	{
		$this->Classes = array();
		$this->XmlParser = new ParseXML;
	}
	
	function LoadXMLData($xmlfile)
	{
		//procedura koja cita xml fajl i kreira objekte
		//za rad sa xml konfiguracijom 
		$xmltree = $this->XmlParser->GetXMLTree($xmlfile);
		foreach($xmltree["CLASSES"][0]["CLASS"] as $xmlClass)
		{
			$Class = new MetaClass();
			$Class->setName($xmlClass["ATTRIBUTES"]["NAME"]);
			$Class->setFile($xmlClass["ATTRIBUTES"]["FILE"]);
			if(isset($xmlClass["ATTR"][0]["ATTRS"]))
			{
				foreach ($xmlClass["ATTR"][0]["ATTRS"] as $xmlAttributes)
				{
					$Attribute = new Attribute();
					
					$Attribute->setName($xmlAttributes["VALUE"]);
					$Attribute->setType($xmlAttributes["ATTRIBUTES"]["TYPE"]);
					$Attribute->setValue($xmlAttributes["ATTRIBUTES"]["VALUE"]);
					$Attribute->setKey($xmlAttributes["ATTRIBUTES"]["KEY"]);
					
					$Class->addAttribute($Attribute);
				}
			}
			
			if(isset($xmlClass["RELATIONS"][0]["RELATION"]))
			{
				foreach ($xmlClass["RELATIONS"][0]["RELATION"] as $xmlAttributes)
				{
					if(isset($xmlAttributes["ATTRIBUTES"]["CLASS"]))
					{
						$Relation = new Relations();
					
						$Relation->setClass($xmlAttributes["ATTRIBUTES"]["CLASS"]);
						$Relation->setType($xmlAttributes["ATTRIBUTES"]["TYPE"]);
					
						$Class->addRealtion($Relation);
					}
				}
			}
			$this->addClass($Class);
		}
	}
	
	function addClass($Class)
	{
		array_push($this->Classes,array($Class->getName() => $Class));
	}
	
	function GetMetaClassByName($className)
	{	
		foreach ($this->Classes as $Class) 
		{
			foreach ($Class as $key => $value) 
			{
				if($key == $className)
				{
					return $value;
				}
			}
		}
		return null;
	}
	
}

class MetaClass
{
	var $Name;
	var $File;
	
	var $Attributes;
	var $Relations;
	
	function __construct($Name="",$File="")
	{
		$this->Name = $Name;
		$this->File = $File;
		$this->Attributes = array();
		$this->Relations = array();
	}
	
	function getName()
	{
		return $this->Name;
	}
	
	function setName($val)
	{
		$this->Name = $val;
	}
	
	function getFile()
	{
		return $this->File;
	}
	
	function setFile($val)
	{
		$this->File = $val;
	}
	
	function getPrimaryKeyAttr()
	{
		foreach ($this->Attributes as $Attributes) 
		{
			foreach ($Attributes as $key => $value) 
			{
				if($value->Key == "pk") return $key;
				
			}
		}
		return null;
	}
	
	function getRelationType($rel_class)
	{
		foreach ($this->Relations as $Relations) 
		{
			foreach ($Relations as $key => $value) 
			{
				if($rel_class == $value->Class)	return $value->Type;
				
			}
		}
		return null;
	}
	
	function addAttribute($Attribute)
	{
		array_push($this->Attributes, array($Attribute->Name => $Attribute));
	}
	
	function addRealtion($Relation)
	{
		array_push($this->Relations, array($Relation->Class => $Relation));
	}
}

class Attribute 
{
	var $Name;
	var $Type;
	var $Value;
	var $Key;
	
	function __construct($Name="",$Type="",$Value="",$Key="")
	{
		$this->Name = $Name;
		$this->Type = $Type;
		$this->Value = $Value;
		$this->Key = $Key;
	}
	
	function getName()
	{
		return $this->Name;
	}
	
	function setName($val)
	{
		$this->Name = $val;
	}
	function getKey()
	{
		return $this->Key;
	}
	
	function setKey($val)
	{
		$this->Key = $val;
	}
	function getType()
	{
		return $this->Type;
	}
	
	function setType($val)
	{
		$this->Type = $val;
	}
	function getValue()
	{
		return $this->Value;
	}
	
	function setValue($val)
	{
		$this->Value = $val;
	}
}

class Relations
{
	var $Class;
	var $Type;
	
	function __construct($Class="",$Type="")
	{
		$this->Class = $Class;
		$this->Type = $Type;
	}
	
	function getClass()
	{
		return $this->Class;
	}
	
	function setClass($val)
	{
		$this->Class = $val;
	}
	
	function getType()
	{
		return $this->Type;
	}
	
	function setType($val)
	{
		$this->Type = $val;
	}
}

?>