<?php

/*--------------------------------------------------------------------------------------------------
Datei      		 : AbstractEvent.php
Beschreibung 	 : Abstrakte Klasse für die Events
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 11.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

abstract class AbstractEvent {
	/**
	 * Überprüft die gesendeten Parameter
	 *
	 * @param string $event
	 * @param string $class
	 * @param mixed  $object
	 **/
	public function __construct($event, $class, $object) {

	}
}
