<?php
require_once(DIRNAME.'lib/system/dbObject.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : Languages.php
Beschreibung 	 : Sprache System
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class Languages extends dbObject {

	/**
	 * @see    dbObject::$dbName
	 */
	protected static $dbName = 'languages';
	/**
	 * @see    dbObject::$dbIndex
	 */
	protected static $dbIndex = 'languageID';
	/**
	 * Cached languages files
	 *
	 * var array
	 */
	protected $cachedFiles = array();
	/**
	 * Cached languages vars
	 *
	 * var array
	 */
	protected $cachedVars = array();

	/**
	 * @see    dbObject::__construct()
	 */
	public function __construct($ID, array $row = null) {
		parent::__construct($ID, $row);
		$list = scandir(DIRNAME."lib/languages");
		if(in_array($this->languageCode, $list)) {
			$this->cachedFiles = scandir(DIRNAME."lib/languages/".$this->languageCode);
			foreach($this->cachedFiles as $id => $file) {
				if($file == "." || $file == "..") {
					unset($this->cachedFiles[$id]);
				}else {
					$this->cachedVars = array_merge($this->cachedVars, json_decode(file_get_contents(DIRNAME."lib/languages/".$this->languageCode."/".$file), true));
				}
			}
		}
	}

	/**
	 * Gibt eine Sprachvariablen aus dem Cache zurück
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	public function get($name) {
		if(isset($this->cachedVars[$name])) {
			return $this->cachedVars[$name];
		}
		return $name;
	}
}