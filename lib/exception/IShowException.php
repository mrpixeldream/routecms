<?php
namespace routecms\exception;
/*--------------------------------------------------------------------------------------------------
Datei      		 : IShowException.php
Beschreibung 	 : Interface Klasse für auszugeben Fehlermeldungen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 04.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/
interface IShowException {
	/**
	 * Gibt die Fehlermeldung aus
	 */
	public function show();
}
