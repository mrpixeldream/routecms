<?php
/*--------------------------------------------------------------------------------------------------
Datei      		 : PermissionException.php
Beschreibung 	 : Fehler Klasse für die Berechtigungen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 04.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class PermissionException extends Exception {
	/**
	 * Ruft eine Fehlerseite auf, die anzeigt das der Benutzer nicht die nötigen Rechte hat
	 */
	public function __construct() {
		ob_clean();
		@header('HTTP/1.0 403 Forbidden');
		Routecms::getTemplate()->assign('title', 'system.page.permission.denied');
		Routecms::getTemplate()->assign('permissionDenied', 'system.page.permission.denied');
		if(defined('ADMIN')) {
			Routecms::getTemplate()->fetchTemplate('permissionDenied', 'lib/admin/template/');
		}else {
			Routecms::getTemplate()->fetchTemplate('permissionDenied');
		}
		exit;
	}

}
