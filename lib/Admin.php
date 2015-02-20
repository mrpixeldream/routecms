<?php
namespace routecms;

use routecms\admin\actions\AjaxIllegalLink;
use routecms\admin\pages\ErrorLogin;
use routecms\exception\IllegalLinkException;

/*--------------------------------------------------------------------------------------------------
Datei      		 : Admin.php
Beschreibung 	 : Admin System Klasse des Routecmss
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 02.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class Admin extends Routecms {
	/**
	 * @see    Routecms::startTemplate()
	 */
	public function startTemplate() {
		if(self::$page != "Login" && !self::getUser()->isAdmin()) {
			$localPage = new ErrorLogin();
			self::$template = new Template($localPage->template, "lib/admin/template/");
			$localPage->__run();
		}else {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				$class = 'routecms\admin\actions\\'.self::$page;
				if(class_exists($class)) {
					$ajax = new $class();
					$ajax->__run();
				}else {
					$ajax = new AjaxIllegalLink();
					$ajax->__run();
				}
			}else {
				{
					$class = 'routecms\admin\pages\\'.self::$page;
					if(class_exists($class)) {
						$localPage = new $class();
						self::$template = new Template($localPage->template, "lib/admin/template/");
						$localPage->__run();

					}else {
						self::$template = new Template("illegalLink", "lib/admin/template/");
						throw new IllegalLinkException();
					}
				}
			}
		}
	}
}