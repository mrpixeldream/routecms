<?php
namespace routecms\system\user;

use routecms\Input;
use routecms\Routecms;
use routecms\system\DBObject;

/*--------------------------------------------------------------------------------------------------
Datei      		 : User.php
Beschreibung 	 : User class
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class User extends dbObject {

	/**
	 * @see    dbObject::$dbName
	 */
	protected static $dbName = 'user';
	/**
	 * @see    dbObject::$dbIndex
	 */
	protected static $dbIndex = 'userID';
	/**
	 * Alle Gruppen ID´s von dem Aktuellen benutzer
	 *
	 * array<integer>
	 */
	protected $groupIDs = null;

	/**
	 * Prüft ob die Login Daten richtig sind
	 *
	 * @param string $username
	 * @param string $password
	 *
	 * @return boolean
	 */
	public static function checkLogin($username, $password) {
		$sql = "SELECT * FROM ".DB_PREFIX."user WHERE username = ?";
		$statement = Routecms::getDB()->statement($sql);
		$statement->execute(array($username));
		$row = $statement->fetchArray();
		if($row) {
			$salt = $row["salt"];
			if(self::cryptPW($password, $salt) == $row["password"]) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Gibt ein gehashtes password zurück
	 *
	 * @param string $pw
	 * @param string $salt
	 *
	 * @return string
	 */
	public static function cryptPW($pw, $salt) {
		return sha1($pw.$salt);
	}

	/**
	 * Gibt einen zufälligen string zurück
	 *
	 * @param integer $length
	 *
	 * @return string
	 */
	public static function generateSalat($length = 20) {
		$availableCharacters = array('abcdefghijklmnopqrstuvwxyz',
			'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
			'0123456789');

		$salt = '';
		$type = 0;
		for($i = 0; $i < $length; $i++) {
			$type = ($i % 3 == 0) ? 0 : ($type + 1);
			$salt .= substr($availableCharacters[$type], mt_rand(0, strlen($availableCharacters[$type]) - 1), 1);
		}

		return str_shuffle($salt);
	}


	/**
	 * Gibt die aktuelle IP Adresse des Benutzer zurück
	 *
	 * @return string
	 */
	public static function getIpAddress() {
		$ip = '';
		if(isset($_SERVER['REMOTE_ADDR']))
			$ip = $_SERVER['REMOTE_ADDR'];

		if($ip == '::1' || $ip == 'fe80::1') {
			$ip = '127.0.0.1';
		}

		$ip = self::IPv4To6($ip);

		return $ip;
	}

	/**
	 * Konvertiert die IPv4 Adresse zu einer IPv6 Adresse
	 *
	 * @param string $ip
	 *
	 * @return string
	 */
	public static function IPv4To6($ip) {
		if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false) {
			return $ip;
		}

		if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false) {
			return '';
		}

		$array = array_pad(explode('.', $ip), 4, 0);
		$ipPart = base_convert(($array[0] * 256) + $array[1], 10, 16);
		$ipPart2 = base_convert(($array[2] * 256) + $array[3], 10, 16);

		return '::ffff:'.$ipPart.':'.$ipPart2;
	}

	/**
	 * Gibt die Gruppen ID´s des Aktuellen Benutzers zurück
	 *
	 * @return array<integer>
	 */
	public function getGroupIDs() {
		if($this->groupIDs == null) {
			$this->groupIDs = array();
			$sql = "SELECT	groupID
			FROM	".DB_PREFIX."user_to_group
			WHERE	userID = ?";
			$statement = Routecms::getDB()->statement($sql);
			$statement->execute(array($this->userID));
			while($row = $statement->fetchArray()) {
				$this->groupIDs[] = $row["groupID"];
			}
		}
		return $this->groupIDs;
	}

	/**
	 * Gibt den aktuellen User Agenten zurück
	 *
	 * @return string
	 */
	public static function getUserAgent() {
		if(isset($_SERVER['HTTP_USER_AGENT'])) {
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
			if(!preg_match('/^[\x00-\x7F]*$/', $userAgent) && !stringUtil::isUTF8($userAgent)) {
				$userAgent = stringUtil::convertEncoding('ISO-8859-1', 'UTF-8', $userAgent);
			}

			return mb_substr($userAgent, 0, 255);
		}
		return '';
	}

	/**
	 * Überpürft ob der Aktuelle Benutzer einen User mit gegeben user Objekt
	 *
	 * @param User $user
	 *
	 * @return bool
	 * @throws SystemException
	 */
	public static function canMangedUser($user) {
		$result = true;
		if(!$user && !isset($user->userID) || $user->userID == 0) {
			throw new SystemException(lang("exception.input.user.false"));
		}
		foreach($user->getGroupIDs() as $groupID) {
			if(!in_array($groupID, Routecms::getPermission("admin.can.mange.group"))) {
				$result = false;
				break;
			}
		}
		return $result;
	}

	/**
	 * Überpürft ob der Aktuelle Benutzer einen User mit gegeben UserID löschen darf
	 *
	 * @param integer $userID
	 *
	 * @return boolean
	 */
	public static function canMangedUserByUserID($userID) {
		return self::canMangedUser(new User($userID));
	}

	/**
	 * Gibt die vom Benutzer aufgerufene URL zurück
	 *
	 * @return string
	 */
	public static function getUrl() {
		$url = '';
		if(Input::server("REQUEST_URI", 'string') != '') {
			$url = Input::server("REQUEST_URI", 'string');
		}elseif(Input::server("QUERY_STRING", 'string') != '' && (Input::server("SCRIPT_NAME", 'string') != '' || Input::server("PHP_SELF", 'string') != '')) {
			if(Input::server("SCRIPT_NAME", 'string') != '') {
				$url = Input::server("PHP_SELF", 'string').'?'.Input::server("QUERY_STRING", 'string');
			}else {
				$url = Input::server("PHP_SELF", 'string').'?'.Input::server("QUERY_STRING", 'string');
			}
		}
		//ändert die Kodierung
		if(!preg_match('/^[\x00-\x7F]*$/', $url) && !stringUtil::isUTF8($url)) {
			$url = stringUtil::covert('ISO-8859-1', 'UTF-8', $url);
		}

		return mb_substr($url, 0, 255);
	}


	/**
	 * Gibt ein 'true' zurück wenn die E-Mail gültig ist
	 *
	 * @param    string $mail
	 *
	 * @return    boolean
	 */
	public static function isValidEmail($mail) {
		$c = '!#\$%&\'\*\+\-\/0-9=\?a-z\^_`\{\}\|~';
		$string = '['.$c.']*(?:\\\\[\x00-\x7F]['.$c.']*)*';
		$localPart = $string.'(?:\.'.$string.')*';

		$name = '[a-z0-9](?:[a-z0-9-]*[a-z0-9])?';
		$domain = $name.'(?:\.'.$name.')*\.[a-z]{2,}';

		$mailbox = $localPart.'@'.$domain;

		return preg_match('/^'.$mailbox.'$/i', $mail);
	}


	/**
	 * Gibt ein 'true' zurück wenn der Benutzername noch nicht vergeben ist
	 *
	 * @param    string $username
	 *
	 * @return    boolean
	 */
	public static function usernameAvailable($username) {
		$sql = "SELECT	COUNT(username) AS count
			FROM	".DB_PREFIX."user
			WHERE	username = ?";
		$statement = Routecms::getDB()->statement($sql);
		$statement->execute(array($username));
		$row = $statement->fetchArray();
		return $row['count'] == 0;
	}

	/**
	 * Gibt ein 'true' zurück wenn die E-Mail Adresse noch nicht vergeben ist
	 *
	 * @param    string $email
	 *
	 * @return    boolean
	 */
	public static function emailAvailable($email) {
		$sql = "SELECT	COUNT(email) AS count
			FROM	".DB_PREFIX."user
			WHERE	email = ?";
		$statement = Routecms::getDB()->statement($sql);
		$statement->execute(array($email));
		$row = $statement->fetchArray();
		return $row['count'] == 0;
	}

	/**
	 * Gibt an ob der Benutzer den Admin Bereich bzw. Rechte hat
	 *
	 * @return    boolean
	 */
	public function isAdmin() {
		return Routecms::getPermission("admin.can.use.admin");
	}
}