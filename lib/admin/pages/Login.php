<?php
namespace routecms\admin\pages;
use routecms\pages\Page;
use routecms\exception\InputException;
use routecms\system\user\User;
use routecms\system\user\session\Session;
use routecms\Routecms;
use routecms\Input;

/*--------------------------------------------------------------------------------------------------
Datei      		 : Login.php
Beschreibung 	 : Admin Login Seite des Routecms
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 10.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class Login extends Page {
	/**
	 * Username Variabel zum Einloggen
	 *
	 * @var string
	 */
	public $username = '';
	/**
	 * Passwort das zum Einloggen mit dem Username verglichen wird
	 *
	 * @var string
	 */
	public $password = '';
	/**
	 * @see    Page::$template
	 */
	public $template = "login";
	/**
	 * @see    Page::$title
	 */
	public $title = "system.page.login";

	/**
	 * @see    Page::validate()
	 */
	public function validate() {
		parent::validate();
		if(empty($this->username)) {
			throw new InputException('username');
		}
		if(empty($this->password)) {
			throw new InputException('password');
		}
		if(User::usernameAvailable($this->username)) {
			throw new InputException('username', 'not.registered');
		}
		if(!User::checkLogin($this->username, $this->password)) {
			throw new InputException('password', 'false');
		}
	}

	/**
	 * @see    Page::save()
	 */
	public function save() {
		parent::save();
		Session::createSession($this->username, $this->password);
		Routecms::redirect("?page=Index");
		exit;
	}

	/**
	 * @see    Page::postRead()
	 */
	public function postRead() {
		parent::postRead();
		$this->username = Input::post('username', 'string', '');
		$this->password = Input::post('password', 'string', '');
	}

	/**
	 * @see    Page::assign()
	 */
	public function assign() {
		parent::assign();
		Routecms::getTemplate()->assign(array('username' => $this->username));
	}
}