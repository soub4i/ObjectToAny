<?php
/**
 * @package ObjectToAny
 * @author Abderrahim Soubai Elidrissi
 * @license https://opensource.org/licenses/MIT MIT
 *
 * ObjectToAny is a simple php class that can allow you to make a lot of Conversion :
 * From Object  To Array
 * From Object  To XML
 * From Object  To JSON
 * From Object  To Binary
 * From Array  To Object
 * From XML    To Object
 * From JSON   To Object
 * From Binary To Object
 */

namespace Soubai\ObjectToAny;

use Exception;
use XMLWriter;

class ObjectToAny
{
    /**
     * Convert Array To Object
     *
     * @param Array $array Array that can be Converted To Object
     * @return object
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
     *
     * @param  Object $object Any Object of Class that can be Converted To Array
     * @return array
     */
    public static function ToArray($object)
    {
        self::_isObj($object);
        return (array) $object;
    }

    /**
     * Convert an Object To JSON
     *
     * @param Object $object Any Object of Class that can be Converted To JSON
     * @return string
     */
    public static function ToJSON($object)
    {
        self::_isObj($object);
        return json_encode($object);
    }

    /**
     * Convert JSON To Object
     *
     * @param String $value JSON Code that can be Converted To Object
     * @return mixed
     */
    public static function FromJSON($value)
    {
        return json_decode($value);
    }

    /**
     * Convert a Object To CSV
     *
     * @param Object $object Any Object of Class that can be Converted To YAML
     * @param string $delimiter default ","
     * @param string $enclosure default '"'
     * @return bool|string
     */
    public static function ToCSV($object, $delimiter = ',', $enclosure = '"')
    {
        self::_isObj($object);
        $arr = array();
        $data ="";
        if (self::_isAssociative(static::ToArray($object))) {
            $arr[] = array_keys(static::ToArray($object));
            $arr[] = array_values(static::ToArray($object));
            foreach ($arr as $a) {
                foreach ($a as $value) {
                    $data .= $enclosure.$value.$enclosure.$delimiter;
                }
            }
        }
        else {
            $arr = static::ToArray($object);
            foreach ($arr as $value) {
                $data .= $enclosure.$value.$enclosure.$delimiter;
            }
        }

        $data=substr($data, 1, count($data)-4);
        return $data;
    }

    /**
     * Convert CSV To Object
     *
     * @param String $value CVS Code that can be Converted To Object
     * @return object
     */
    public static function FromCSV($value)
    {
        return static::FromArray(str_getcsv($value));
    }

    /**
     * Convert an Object To Binary
     *
     * @param Object $object Any Object of Class that can be Converted To Binary
     * @return string
     */
    public static function ToBinary($object)
    {
        self::_isObj($object);
        return serialize($object);
    }

    /**
     * Convert Binary To Object
     *
     * @param String $value Binary Code that can be Converted To Object
     * @return mixed
     */
    public static function FromBinary($value)
    {
        return unserialize($value);
    }

    /**
     * Convert XML To Object
     *
     * @param String $value XML Code that can be Converted To Object
     * @return \SimpleXMLElement
     */
    public static function FromXML($value)
    {
        return simplexml_load_string(html_entity_decode($value));
    }

    /**
     * Convert Object To XML
     *
     * @param Object $object Any Object of Class that can be Converted To XML
     * @return string
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
     *
     * @param  Object $object
     * @return bool
     * @throws Exception
     */
    private static function _isObj($object)
    {
        if (!is_object($object)) {
            throw new Exception("Be Sure than current object is an Object");
        }
        return true;
    }

    /**
     * Check if $array is Associative or Not
     * 
     * @param $array
     * @return boolean
     */
    private static function _isAssociative($array)
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
