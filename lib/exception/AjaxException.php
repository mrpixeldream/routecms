<?php

/*--------------------------------------------------------------------------------------------------
Datei      		 : AjaxException.php
Beschreibung 	 : Ajax Fehler Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 25.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class AjaxException extends Exception {
	/**
	 * Ruft eine Fehlerseite auf, die anzeigt das der Benutzer nicht die nötigen Rechte hat
	 */
	public function __construct($errorCode, $title, $description) {
		ob_clean();
		$header = '';
		$response = array(
			'code' => $errorCode,
			'title' => $title,
			'description' => $description
		);
		switch ($errorCode) {
			case 400:
				$header = 'HTTP/1.0 400 Bad Request';
				break;
			case 401:
				$header = 'HTTP/1.0 430 Session Expired';
				break;
			case 403:
				$header = 'HTTP/1.0 403 Forbidden';
				break;
			case 404:
				$header = 'HTTP/1.0 400 Bad Request';
				break;
			case 412:
				$header = 'HTTP/1.0 431 Bad Parameters';
				break;
			default:
				$header = 'HTTP/1.0 503 Service Unavailable';
				break;
		}
		header($header);
		header('Content-type: application/json');
		echo json_encode($response);
		exit;
	}

}
