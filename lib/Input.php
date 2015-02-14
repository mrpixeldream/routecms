<?php

/*--------------------------------------------------------------------------------------------------
Datei      		 : Input.php
Beschreibung 	 : Input Class für gesendete Informationen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class Input {

	/**
	 * Fragt ab ob der Benutzer an die Seite etwas sendet
	 *
	 * @return boolean
	 */
	public static function isPost() {
		if(!empty($_POST) && count($_POST)) {
			return true;
		}
		return false;
	}

	/**
	 * Gibt eine GET Variabel zurück
	 *
	 * @param string $var
	 * @param string $type
	 * @param string $default
	 *
	 * @return object
	 */
	static public function get($var, $type = '', $default = null) {
		return self::checkInput($_GET, $var, $type, $default);
	}

	/**
	 * Gibt die Variabel aus dem input formatiert zurück
	 *
	 * @param string $input
	 * @param string $var
	 * @param string $type
	 * @param string $default
	 *
	 * @return object
	 */
	public static function checkInput($input, $var, $type, $default = null) {
		if(isset($input[$var])) {
			return self::format($input[$var], $type);
		}
		return $default;
	}

	/**
	 * Formatiert die variabel
	 *
	 * @param string $var
	 * @param string $type
	 *
	 * @return object
	 */
	public static function format($var, $type = '') {
		switch($type) {
			case 'bool':
			case 'boolean':
				return (boolean)$var;

			case 'int':
			case 'interger':
				return (int)$var;

			case 'double':
				return (double)$var;

			case 'float':
				return (float)$var;

			case 'string':
				return (string)$var;

			case 'object':
				return (object)$var;

			case 'array':
				return (empty($var)) ? [] : (array)$var;

			case '':
				return $var;
		}
		return $var;
	}

	/**
	 * Gibt eine POST Variabel zurück
	 *
	 * @param string $var
	 * @param string $type
	 * @param string $default
	 *
	 * @return object
	 */
	static public function post($var, $type = '', $default = null) {
		return self::checkInput($_POST, $var, $type, $default);
	}

	/**
	 * Gibt eine FILES Variabel zurück
	 *
	 * @param string $var
	 * @param string $type
	 * @param string $default
	 *
	 * @return object
	 */
	static public function files($var, $type = '', $default = null) {
		return self::checkInput($_FILES, $var, $type, $default);
	}

	/**
	 * Gibt eine COOKIE Variabel zurück
	 *
	 * @param string $var
	 * @param string $type
	 * @param string $default
	 *
	 * @return object
	 */
	static public function cookie($var, $type = '', $default = null) {
		return self::checkInput($_COOKIE, $var, $type, $default);
	}

	/**
	 * Gibt eine SERVER Variabel zurück
	 *
	 * @param string $var
	 * @param string $type
	 * @param string $default
	 *
	 * @return object
	 */
	static public function server($var, $type = '', $default = null) {
		return self::checkInput($_SERVER, $var, $type, $default);
	}
}