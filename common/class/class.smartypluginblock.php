<?
	class SmartyPluginBlock
	{
		private $name;
		private $position;
		private $data;
		
		public function __construct(){}
		
		public function getName()
		{
			return $this->name;
		}
		
		public function setName($value)
		{
			$this->name = $value;
		}
		
		public function getPosition()
		{
			return $this->position;
		}
		
		public function setPosition($value)
		{
			$this->position = $value;
		}
		
		public function getData()
		{
			return $this->data;
		}
		
		public function setData($value)
		{
			$this->data = $value;
		}
		
		public function toArray()
		{
			$arr = array();
			
			$arr = array_merge($arr, array("name" => $this->getName()));
			$arr = array_merge($arr, array("position" => $this->getPosition()));
			$arr = array_merge($arr, array("data" => $this->getData()));
		
			return $arr;
		}
	}
?>