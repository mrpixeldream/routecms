<?php
require_once(DIRNAME.'lib/admin/pages/class/AdminPage.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : PermissionDenied.php
Beschreibung 	 : Startseite des Routecms
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 11.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class PermissionDenied extends AdminPage {
	/**
	 * @see    Page::$template
	 */
	public $template = "permissionDenied";
	/**
	 * @see    Page::$title
	 */
	public $title = "exception.permission.denied";
}