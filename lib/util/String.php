<?php
namespace routecms\util;

use routecms\Routecms;

/*--------------------------------------------------------------------------------------------------
Datei      		 : String.php
Beschreibung 	 : Eine Hilfsklasse um String zu verwalten
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/
class String {

	/**
	 * Codirt eine zeichenfolge in einem HTML Code
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	public static function HTMLEncode($string) {
		return Routecms::encodeHTML($string);
	}
}