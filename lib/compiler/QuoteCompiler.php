<?php

/*--------------------------------------------------------------------------------------------------
Datei      		 : QuoteCompiler.php
Beschreibung 	 : Quote Kompilierungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class QuoteCompiler {

	/**
	 * Alle gespeicherten Quoten
	 *
	 * @var    array
	 */
	protected static $quotes = array();

	/**
	 * Entfernt alle Quoten
	 *
	 * @param array $matches
	 *
	 * @return string
	 */
	public static function replaceSingleQuotesCallback($matches) {
		$string = $matches[0];
		$hash = "@@".sha1(uniqid(microtime()).$string)."@@";
		self::$quotes[$hash] = $string;
		return $hash;
	}

	/**
	 *  Fügt die Quoten wieder ein
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	public static function insertQuotes($string) {
		foreach(self::$quotes as $hash => $value) {
			if(mb_strpos($string, $hash) !== false) {
				$string = str_replace($hash, $value, $string);
				unset(self::$quotes[$hash]);
			}
		}
		return $string;
	}

	/**
	 * Entfernt alle doppel Quoten
	 *
	 * @param array $matches
	 *
	 * @return string
	 */
	public static function replaceDoubleQuotesCallback($matches) {
		$string = $matches[0];
		$string = preg_replace('~(?<!\\\\)'.Handler::$var.'~', '{$this->v[\'\\1\']}', $string);
		$hash = "@@".sha1(uniqid(microtime()).$string)."@@";
		self::$quotes[$hash] = $string;
		return $hash;
	}
}