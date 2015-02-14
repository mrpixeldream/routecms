<?php
/*--------------------------------------------------------------------------------------------------
Datei      		 : PermissionException.php
Beschreibung 	 : Fehler Klasse für die Berechtigungen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 04.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class IllegalLinkException extends Exception {
	/**
	 * Ruft eine Fehlerseite auf, die anzeigt das der Benutzer nicht die nötigen Rechte hat
	 */
	public function __construct() {
		ob_clean();
		@header('HTTP/1.0 404 Not Found');
		Routecms::getTemplate()->assign('title', 'exception.illegal.link');
		Routecms::getTemplate()->assign('illegalLink', 'system.page.permission.denied');
		if(defined('ADMIN')) {
			Routecms::getTemplate()->fetchTemplate('illegalLink', 'lib/admin/template/');
		}else {
			Routecms::getTemplate()->fetchTemplate('illegalLink');
		}
		exit;
	}

}
