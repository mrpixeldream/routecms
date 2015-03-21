<?php
namespace routecms\pages;

/*--------------------------------------------------------------------------------------------------
Datei      		 : Login.php
Beschreibung 	 : Login Seite des Routecms
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class Login extends Page {

	/**
	 * @see    Page::$template
	 */
	public $template = "login";
	/**
	 * @see    Page::$title
	 */
	public $title = "Login";

	/**
	 * @see    Page::assign()
	 */
	public function assign() {
		parent::assign();
	}
}