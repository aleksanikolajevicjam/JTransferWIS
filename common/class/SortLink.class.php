<?
	class SortLink 
	{
		private static $fieldname;
		private static $direction;
		private static $filename;
		private static $linktext;
		
		public static function generateLink($linktext, $fieldname=null,$filename="index.php")
		{
			self::$linktext = $linktext;
			self::$fieldname = $fieldname;
			self::$filename = $filename;
			
			if(isset($_REQUEST["direction"]))
			{
				self::$direction = $_REQUEST["direction"];
			}
			return "<a href='".self::getLinkUrl()."'></a>".self::getLinkText()."";
		}
		
		private static function getLinkUrl()
		{
			if(isset($_REQUEST["sortby"]))
			{
				if($_REQUEST["sortby"] == self::$fieldname)
				{
					self::$direction = self::getOtherDirection();
				}
				else 
				{
					self::$direction = "";
				}
			}
			
			$delimiter = strpos(self::$filename,"?") >0 ? "&" : "?";
			return self::$filename.$delimiter."sortby=".self::$fieldname."&direction=".self::$direction;
		}
		
		private static function getOtherDirection()
		{
			switch (self::$direction)
			{
				case "asc": return "desc";
					break;
				case "desc": return "asc";
					break;
				default: return "asc";
			}
		}
		
		private function getLinkText()
		{
			return self::$linktext;
		}
	}
?>