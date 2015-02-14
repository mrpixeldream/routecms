<?php

/*--------------------------------------------------------------------------------------------------
Datei      		 : InputException.php
Beschreibung 	 : Eingabe Fehlermeldungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 04.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class InputException extends Exception {
	/**
	 * Gibt die Fehlermeldung aus
	 *
	 * @param string $input
	 * @param string $type
	 */
	public function __construct($input, $type = 'empty') {
		Routecms::getTemplate()->assign(array('errorInput' => $input,
			'errorType' => $type));
	}

}
