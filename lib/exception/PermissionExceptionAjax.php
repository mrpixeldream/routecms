<?php
namespace routecms\exception;
/*--------------------------------------------------------------------------------------------------
Datei      		 : PermissionException.php
Beschreibung 	 : Fehler Klasse für die Berechtigungen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 04.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class PermissionExceptionAjax extends \Exception {
	/**
	 * Ruft eine Fehlerseite auf, die anzeigt das der Benutzer nicht die nötigen Rechte hat
	 */
	public function __construct() {
		ob_clean();
		@header('HTTP/1.0 403 Forbidden');
		header('Content-type: application/json');
		echo json_encode(array('title' => lang('exception.permission.denied'), 'description' => lang('exception.permission.denied.description')));
		exit;
	}

}
