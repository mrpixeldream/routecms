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

	/**
	 * Gibt zuück ob eine String UTF-8 codiert ist
	 *
	 * @see        http://www.w3.org/International/questions/qa-forms-utf-8
	 *
	 * @param    string $string
	 *
	 * @return    boolean
	 */
	public static function isUTF8($string) {
		return preg_match('/(
				[\xC2-\xDF][\x80-\xBF]			# non-overlong 2-byte
			|	\xE0[\xA0-\xBF][\x80-\xBF]		# excluding overlongs
			|	[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}	# straight 3-byte
			|	\xED[\x80-\x9F][\x80-\xBF]		# excluding surrogates
			|	\xF0[\x90-\xBF][\x80-\xBF]{2}		# planes 1-3
			|	[\xF1-\xF3][\x80-\xBF]{3}		# planes 4-15
			|	\xF4[\x80-\x8F][\x80-\xBF]{2}		# plane 16
			)/x', $string);
	}

	/**
	 * Convertiert ein Zeichen kette
	 *
	 * @see        mb_convert_encoding()
	 *
	 * @param    string $inCharset
	 * @param    string $outCharset
	 * @param    string $string
	 *
	 * @return    string        converted string
	 */
	public static function convert($inCharset, $outCharset, $string) {
		if($inCharset == 'ISO-8859-1' && $outCharset == 'UTF-8')
			return utf8_encode($string);
		if($inCharset == 'UTF-8' && $outCharset == 'ISO-8859-1')
			return utf8_decode($string);

		return mb_convert_encoding($string, $outCharset, $inCharset);
	}
}