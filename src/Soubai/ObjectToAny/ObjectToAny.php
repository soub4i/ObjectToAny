<?php
/** 
 * @package ObjectToAny
 * @author Abderrahim Soubai Elidrissi
 * @license https://opensource.org/licenses/MIT MIT
 * 
 * ObjectToAny is a simple php class that can allow you to make a lot of Conversion : 
 * From Objet  To Array
 * From Objet  To XML
 * From Objet  To JSON
 * From Objet  To Binary
 * From Array  To Object
 * From XML    To Object
 * From JSON   To Object
 * From Binary To Object
 */

 namespace Soubai\ObjectToAny;

 class ObjectToAny 
	{
		/**
		* Convert Array To Object
	 	* @param Array $array Array that can be Converted To Object
	 	*/
		public static function FromArray($array)
			{
				$object = new \stdClass();
				foreach ($array as $key => $value) {
					$object->$key = $value;
				}
				return (Object) $array;
			}

		/**
		 * Convert Object To Array
		 * @param  Object $object Any Object of Class that can be Converted To Array
		 */
		
		public static function ToArray($object)
			{
				self::_isObj($object);
				return (Object) $object;
			}

		/**
		 * Convert a Object To JSON
		 * @param Object $object Any Object of Class that can be Converted To JSON
		 */
	
		public static function ToJSON($object)
			{
				self::_isObj($object);
				return json_encode($object);
			}

		/**
		 * Convert JSON To Object
		 * @param String $value JSON Code that can be Converted To Object
		 */
		
		public static function FromJSON($value)
			{
				return json_decode($value);
			}

		/**
		 * Convert a Object To Binary
		 * @param Object $object Any Object of Class that can be Converted To Binary
		 */
		
		public static function ToBinary($object)
			{
				self::_isObj($object);
				return serialize($object);
			}

		/**
		 * Convert Binary To Object
		 * @param String $value Binary Code that can be Converted To Object
		 */
		
		public static function FromBinary($value)
			{
				return unserialize($value);
			}

		/**
		 * Convert XML To Object
		 * @param String $value XML Code that can be Converted To Object
		 */
		
		public static function FromXML($value)
			{
				$object =simplexml_load_string(html_entity_decode($value));
				return $object;
			}

		/**
		 * Convert Object To XML
		 * @param Object $object Any Object of Class that can be Converted To XML
		 */
		
		public static function ToXML($object)
			{
				self::_isObj($object);
				$xml = new XMLWriter(); 
				$xml->openMemory(); 
				$xml->setIndent(true);
				$xml->startDocument(); 
				$xml->startElement(get_class($object)); 
				foreach (self::ToArray($object) as $k=>$v) {
					if (is_array($v)) {
					$xml->startElement($k); 
					foreach ($v as $key => $value) {
						if (self::_isAssociative($v)) {
							$xml->writeElement($key, $value);
						}
						else{
							$xml->writeElement("Key".$key, $value);

						}
					}

					$xml->endElement();
					}
					else {
					$xml->writeElement($k, $v);

					}
				}
				$xml->endElement();
				 
			 	 return htmlentities($xml->outputMemory()); 
			}


		/**
		 * Check if $object is an Real object of Class
		 * @param  Object  $object 
		 * @return boolean         
		 */
		
		private static function _isObj($object)
			{
				if (!is_object($object)) {

					throw new Exception("Be Sure than current object is an Object");
					return;
				}
			}
		/**
		 * Check if $array is Associative or Not
		 * @param  Array  $arr 
		 * @return boolean      
		 */
		
		private static function _isAssociative($array)
			{
	   			return array_keys($array) !== range(0, count($array) - 1);
			}
	}
