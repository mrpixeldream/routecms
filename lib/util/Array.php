<?php

/*--------------------------------------------------------------------------------------------------
Datei      		 : Array.php
Beschreibung 	 : Eine Hilfsklasse für arrays
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 16.02.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class ArrayUtil{

	/**
	 * Gibt eine array zurück in der alle inhalte zu einer zahl um gewandelt werden
	 *
	 * @param array $array
	 *
	 * @return array<integer>
	 */
	public static function toIntegerArray($array = array()){
		if (!is_array($array)) {
			return intval($array);
		}
		else {
			foreach ($array as $key => $val) {
				$array[$key] = self::toIntegerArray($val);
			}
			return $array;
		}
	}
}