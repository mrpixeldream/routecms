<?php
namespace routecms\system\event\events;

use routecms\Routecms;
use routecms\system\menu\AdminMenu;

/*--------------------------------------------------------------------------------------------------
Datei      		 : AbstractEvent.php
Beschreibung 	 : Abstrakte Klasse für die Events
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 11.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class AdminAddMenuEvent extends AbstractEvent {
	/**
	 * @see AbstractEvent::__construct();
	 **/
	public function __construct($event, $class, $object) {
		if(defined('ADMIN') && Routecms::getPage() != "Login") {
			Routecms::getTemplate()->assign(array('menuTree' => AdminMenu::generateMenu(Routecms::getSession())));
		}
	}
}
