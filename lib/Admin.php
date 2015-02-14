<?php
require_once(DIRNAME.'lib/Routecms.php');

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
			require_once(DIRNAME."lib/admin/pages/ErrorLogin.php");
			$localPage = new ErrorLogin();
			self::$template = new Template($localPage->template, "lib/admin/template/");
			$localPage->__run();
		}else {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				if(file_exists(DIRNAME."lib/admin/actions/".self::$page.".php")) {
					require_once(DIRNAME."lib/admin/actions/".self::$page.".php");
					$ajax = new self::$page();
					$ajax->__run();
				}else {
					require_once(DIRNAME."lib/admin/actions/AjaxIllegalLink.php");
					$ajax = new AjaxIllegalLink();
					$ajax->__run();
				}
			}else {
				{
					if(file_exists(DIRNAME."lib/admin/pages/".self::$page.".php")) {
						require_once(DIRNAME."lib/admin/pages/".self::$page.".php");
						$localPage = new self::$page();
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