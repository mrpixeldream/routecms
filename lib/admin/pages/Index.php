<?php
namespace routecms\admin\pages;
use routecms\pages\Page;

/*--------------------------------------------------------------------------------------------------
Datei      		 : Index.php
Beschreibung 	 : Startseite des Routecms
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 11.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class Index extends Page {
	/**
	 * @see    Page::$template
	 */
	public $template = "index";
	/**
	 * @see    Page::$title
	 */
	public $title = "system.page.index";
}