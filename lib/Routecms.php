<?php
namespace routecms;

use routecms\system\db\Database;
use routecms\system\event\EventManger;
use routecms\system\event\template\TemplateEventManger;
use routecms\system\languages\Languages;
use routecms\system\menu\Menu;
use routecms\system\user\User;
use routecms\system\user\group\GroupOption;
use routecms\system\user\session\Session;
use routecms\actions\AjaxError;
use routecms\pages\Error;

spl_autoload_register(array('routecms\Routecms',
	'autoload'));



/*--------------------------------------------------------------------------------------------------
Datei      		 : Routecms.php
Beschreibung 	 : System Klasse des Routecmss
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class Routecms {

	/**
	 * Aktuelles Datenbank Objekt
	 *
	 * @var    Database
	 */
	protected static $db;
	/**
	 * Aktuelle Seiten namen
	 *
	 * @var    string
	 */
	protected static $page;
	/**
	 * Aktuelles Template Objekt
	 *
	 * @var    Template
	 */
	protected static $template;
	/**
	 * Das Aktuelle Sprach System
	 *
	 * @var    object
	 */
	protected static $language;
	/**
	 * Das Aktuelle Sitzungs Object
	 *
	 * @var    object
	 */
	protected static $session;
	/**
	 * Das Benutzer Object des Aktuelles eingelogten User´s
	 *
	 * @var    User
	 */
	protected static $user;
	/**
	 * Das Aktuelle Menü des Kontroll CMS
	 *
	 * @var    object
	 */
	protected static $menu;
	/**
	 * Das Aktuelle Menü des Kontroll CMS
	 *
	 * @var    object
	 */
	protected static $routecms;

	/**
	 * Inizalisiert das Routecms
	 */
	public function __construct() {
		$db = parse_ini_file("config.ini");
		//erstellt eine neue Datenbak Klasse
		self::$db = new Database($db["host"], $db["db"], $db["user"], $db["pw"]);
		if(!defined('DB_PREFIX'))
			define('DB_PREFIX', $db["prefix"]);
		EventManger::loadEvents();
		TemplateEventManger::loadEvents();
		self::getPage();
		if(Session::checkSession()) {
			self::$session = Session::getSession();
		}
		if(self::$session && self::$session->sessionID != '' && self::$page == "Login") {
			self::redirect("?page=Index");
		}elseif(!self::$session && self::$page != "Login") {
			self::redirect("?page=Login");
		}
		if(self::$session && self::$session->sessionID != '') {
			self::$session->updateTime();
			self::$menu = Menu::generateMenu(self::$session);
			self::$user = self::$session->getUser();
		}
		if(isset($_GET['l'])) {
			self::$language = new Languages(intval($_GET['l']));
			if(self::$language->languageID == null) {
				self::$language = Languages::getBy("isDefault", 1, 'routecms\system\languages\Languages');
			}
		}else {
			if(self::$language == null) {
				self::$language = Languages::getBy("isDefault", 1, 'routecms\system\languages\Languages');
			}
		}
		self::$routecms = $this;
		EventManger::event("afterInit", "Routecms", $this);
	}

	/**
	 * Gibt die aktuelle Seite zurück
	 */
	public static function getPage() {
		if(!empty(self::$page)) {
			//gibt die aktuelle Siete zurück
			return self::$page;
		}
		self::$page = Input::get("page", "string", "Index");
		if(!preg_match("/^[a-z_A-Z0-9]+$/s", self::$page)) {
			self::redirect("index.php?page=Index");
		}
		return self::$page;
	}

	/**
	 *
	 *
	 * @param    string $className
	 *
	 * @see        spl_autoload_register()
	 */
	public static function autoload($className) {
		$namespaces = explode('\\', $className);
		if(count($namespaces) > 1) {
			$prefix = array_shift($namespaces);
			if($prefix === '') {
				array_shift($namespaces);
			}
			$classPath = DIRNAME.'lib/'.implode('/', $namespaces).'.php';
			if(file_exists($classPath)) {
				require_once($classPath);
			}
		}
	}

	/**
	 * Gibt die aktuelle Datenbank zurück
	 *
	 * @return Database
	 */
	public static function getDB() {
		return self::$db;
	}

	/**
	 * Gibt den aktuellen Benutzer zurück
	 *
	 * @return User
	 */
	public static function getUser() {
		return self::$user;
	}

	/**
	 * Gibt die aktuelle Datenbank zurück
	 */
	public static function getSession() {
		return self::$session;
	}

	/**
	 * Leitete den Benutzer zu einer anderen Seite weiter
	 *
	 * @param string  $location
	 * @param boolean $sendStatusCode
	 */
	public static function redirect($location, $sendStatusCode = false) {
		if($sendStatusCode)
			@header('HTTP/1.1 307 Temporary Redirect');
		header('Location: '.$location);
		exit;
	}

	/**
	 * Gibt das aktuelle Sprachsystem zurück
	 */
	public static function getLanguage() {
		return self::$language;
	}

	/**
	 * Gibt das aktuelle Menü zurück
	 */
	public static function getMenu() {
		return self::$menu;
	}

	/**
	 * Codiert den angegeben String in einen UTF-8 Code um
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	public static function encodeHTML($string) {
		return @htmlspecialchars($string, ENT_COMPAT, 'UTF-8');
	}

	/**
	 * Gibt das Template System zurück
	 *
	 * @return Template
	 */
	public static function getTemplate() {
		return self::$template;
	}

	/**
	 * Start das Template System mit der Aktuellen Seite
	 */
	public function startTemplate() {
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$class = 'routecms\actions\\'.self::$page;
			if(class_exists($class)) {
				$ajax = new $class();
				$ajax->__run();
			}else {
				$ajax = new AjaxError();
				$ajax->__run();
			}
		}else {
			$class = 'routecms\pages\\'.self::$page;
			if(class_exists($class)) {
				$localPage = new $class();
				self::$template = new Template($localPage->template, "lib/template/");
				$localPage->__run();

			}else {
				$localPage = new Error();
				self::$template = new Template($localPage->template);
				$localPage->__run();
			}
		}
	}

	/**
	 * Fügt in das Template System standard Variablen ein
	 */
	public static function getInstance() {
		return self::$routecms;
	}

	/**
	 * Fragt die Berechtigungen des Aktuellen Benutzers ab
	 *
	 * @param array $permissions
	 *
	 * @return boolean
	 */
	public static function checkPermissions(array $permissions) {
		$result = true;
		foreach($permissions as $permission) {
			if(!self::checkPermission($permission)) {
				$result = false;
			}
		}
		return $result;
	}

	/**
	 * Fragt eine Berechtigung des Aktuellen Benutzers ab
	 *
	 * @param string $permission
	 *
	 * @return boolean
	 */
	public static function checkPermission($permission) {
		if(self::getPermission($permission) == 1) {
			return true;
		}
		return false;
	}

	/**
	 * Führt eine PHP Funktion aus
	 *
	 * @param string $name
	 * @param        array <mixed> $arguments
	 *
	 * @return mixed
	 */
	public function __call($name, array $arguments) {
		return call_user_func_array($name, $arguments);
	}


	/**
	 * Gibt eine Berechtigung des aktuellen Benutzers zurück
	 *
	 * @param string $permission
	 *
	 * @return mixed
	 */
	public static function getPermission($permission) {
		return GroupOption::getOptionValue($permission);
	}
	/**
	 * Gibt den Inhalt einer Sprachvariabel zurück
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	public static function lang($string) {
		return Routecms::getLanguage()->get($string);

	}
}


// definiert die escapeString methode
function escapeString($string) {
	return Routecms::getDB()->escapeString($string);
}