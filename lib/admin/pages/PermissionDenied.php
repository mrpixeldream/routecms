<?php
namespace routecms\admin\pages;
use routecms\pages\Page;
/*--------------------------------------------------------------------------------------------------
Datei      		 : PermissionDenied.php
Beschreibung 	 : Startseite des Routecms
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 11.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class PermissionDenied extends Page {
	/**
	 * @see    Page::$template
	 */
	public $template = "permissionDenied";
	/**
	 * @see    Page::$title
	 */
	public $title = "exception.permission.denied";
}