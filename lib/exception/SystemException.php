<?php
/*--------------------------------------------------------------------------------------------------
Datei      		 : SystemException.php
Beschreibung 	 : Fehler Klasse für die Berechtigungen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 04.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class SystemException extends Exception {
	/**
	 * Ruft eine Fehlerseite auf, die anzeigt das der Benutzer nicht die nötigen Rechte hat
	 *
	 * @param string $message
	 * @param integer $code
	 * @param \Exception $previous
	 *
	 */
	public function __construct($message = "" ,$code = 0, \Exception $previous = null ) {
		parent::__construct($message,$code, $previous);
		echo $this->_getMessage();
		exit;
	}
	/**
	 *
	 */
	public function _getMessage() {
		$e = ($this->getPrevious() ?: $this);
		return $e->getMessage();
	}
}
