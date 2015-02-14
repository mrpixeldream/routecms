<?php
require_once(DIRNAME."lib/system/dbObject.php");
require_once(DIRNAME."lib/system/user/User.php");
require_once(DIRNAME."lib/system/option/Option.php");

/*--------------------------------------------------------------------------------------------------
Datei      		 : Session.php
Beschreibung 	 : Session klasse des Routecms
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class Session extends dbObject {

	/**
	 * @see    dbObject::$dbName
	 */
	protected static $dbName = 'session';
	/**
	 * @see    dbObject::$dbIndex
	 */
	protected static $dbIndex = 'sessionID';
	/**
	 * Der Cookie Präfix
	 *
	 * var string
	 */
	protected static $prefix = 'routecms_';

	/**
	 * Überprüft ob der Benutzer eine gültige Session besitzt
	 *
	 * @return boolean
	 */
	public static function checkSession() {
		if(isset($_COOKIE[self::$prefix."sessionID"]) && isset($_COOKIE[self::$prefix."userID"]) && isset($_COOKIE[self::$prefix."pw"])) {
			$session = new Session($_COOKIE[self::$prefix."sessionID"]);
			$userID = $_COOKIE[self::$prefix."userID"];
			$pw = $_COOKIE[self::$prefix."pw"];
			$ip = User::getIpAddress();
			if($session && $session->sessionID != null && $session->sessionID == $_COOKIE[self::$prefix."sessionID"]) {
				if($session->userID == $userID && $session->ipAddress == $ip && $session->pw == $pw) {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Überprüft ob der Benutzer eine gültige Session besitzt
	 *
	 * @return \Session
	 */
	public static function getSession() {
		if(isset($_COOKIE[self::$prefix."sessionID"])) {
			return new Session($_COOKIE[self::$prefix."sessionID"]);

		}
		return '';
	}

	/**
	 * Erstellt eine Session für den Aktuellen Benutzer
	 *
	 * @param string $username
	 * @param string $password
	 */
	public static function createSession($username, $password) {
		$sessionID = self::generatSessionID();
		$data = array();
		$user = User::getBy("username", $username, DIRNAME."lib/system/user/User.php", "User");
		$password = User::cryptPW($password, $sessionID);
		$data['userID'] = $user->userID;
		$data['sessionID'] = $sessionID;
		$data['lastTime'] = time();
		$data['pw'] = $password;
		$data['ipAddress'] = User::getIpAddress();
		self::create($data);
		self::addCookie("sessionID", $sessionID);
		self::addCookie("userID", $user->userID);
		self::addCookie("pw", $password);
	}

	/**
	 * Gibt eine zufällige SessionID zurück
	 *
	 * @return string
	 */
	public static function generatSessionID() {
		$availableCharacters = array('abcdefghijklmnopqrstuvwxyz',
			'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
			'0123456789');
		$salat = '';
		$type = 0;
		for($i = 0; $i < 50; $i++) {
			$type = ($i % 3 == 0) ? 0 : ($type + 1);
			$salat .= substr($availableCharacters[$type], mt_rand(0, strlen($availableCharacters[$type]) - 1), 1);
		}

		return str_shuffle($salat);
	}

	/**
	 * Fügt einen Cookie hizu
	 *
	 * @param string $name
	 * @param string $value
	 */
	public static function addCookie($name, $value) {
		setcookie(self::$prefix.$name, $value, time() + Option::getOptionValue("cookie_expire"));
	}

	/**
	 * Gibt das Benutzer Object für die akteulle Sitzung zurück
	 *
	 * @return User
	 */
	public function getUser() {
		return new User($this->userID);
	}

	/**
	 * Bearbeitet die aktuelle Sitzungs Zeit
	 */
	public function updateTime() {
		EventManger::event("beforeUpdateSessionTime", get_class($this), $this);
		$this->addCookie("sessionID", $this->sessionID);
		$this->addCookie("userID", $this->userID);
		$this->addCookie("pw", $this->pw);
		$this->update(array('lastTime' => time()));
		EventManger::event("afterUpdateSessionTime", get_class($this), $this);
	}
}