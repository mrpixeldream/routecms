<?php

/*--------------------------------------------------------------------------------------------------
Datei      		 : TemplateCompiler.php
Beschreibung 	 : Abstrakte Template Kompilirungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

abstract class TemplateCompiler {
	/**
	 * Template Tag Parameter
	 *
	 * @var    string
	 */
	public $args = "";

	/**
	 * Inizalisiert eine Tag Template Kompilirungs Klasse
	 *
	 * @param string $args
	 */
	public function __construct($args) {
		$this->args = $args;
	}

	/**
	 * Gibt den Inhalt des Auszugeben Template Befehls zurück
	 *
	 * @return string
	 */
	public function compileTag() {
		return "";
	}
}