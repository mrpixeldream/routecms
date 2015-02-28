<?php
namespace routecms\admin\pages;

use routecms\exception\IllegalLinkException;
use routecms\exception\InputException;
use routecms\exception\PermissionException;
use routecms\Input;
use routecms\pages\Page;
use routecms\Routecms;
use routecms\system\user\User;

/*--------------------------------------------------------------------------------------------------
Datei      		 : UserEdit.php
Beschreibung 	 : Seite um einen Benutzer zubearbeiten
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 21.02.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class UserEdit extends UserAdd {

	/**
	 * @see    Page::$template
	 */
	public $template = "userAdd";
	/**
	 * @see    Page::$title
	 */
	public $title = "system.page.userEdit";
	/**
	 * @see Ajax::$permissions
	 **/
	public $permissions = array('admin.can.edit.user');
	/**
	 * Die userID des Benutzers der gerade bearbeitet wird
	 *
	 * @var integer
	 **/
	public $userID = 0;
	/**
	 * Das Benutzer Objekt
	 *
	 * @var User
	 **/
	public $user = null;
	/**
	 * Der Benutzername
	 *
	 * @var string
	 **/
	public $username = "";
	/**
	 * Der Passwort
	 *
	 * @var string
	 **/
	public $password = "";
	/**
	 * Der Passwort wiederholt
	 *
	 * @var string
	 **/
	public $passwordAgain = "";
	/**
	 * Der E-Mail Adresse
	 *
	 * @var string
	 **/
	public $mail = "";
	/**
	 * Der E-Mail Adresse wiederholt
	 *
	 * @var string
	 **/
	public $mailAgain = "";

	/**
	 * @see Page::read()
	 **/
	public function read() {
		parent::read();
		$this->userID = Input::get("userID", "integer", 0);
		$this->user = new User($this->userID);
		if(!$this->user || !isset($this->user->userID) && $this->user->userID == 0) {
			throw new IllegalLinkException();
		}
		foreach($this->user->getGroupIDs() as $groupID) {
			if(!in_array($groupID, Routecms::getPermission("admin.can.mange.group"))) {
				throw new PermissionException();
			}
		}
		$this->username = $this->user->username;
		$this->mail = $this->user->email;
		$this->mailAgain = $this->user->email;
		$this->groupIDs = $this->user->getGroupIDs();
	}

	/**
	 * @see    Page::validate()
	 */
	public function validate() {
		Page::validate();
		if($this->username != $this->user->username) {
			if(User::usernameAvailable($this->username)) {
				throw new InputException('username', 'use');
			}
		}
		if(!empty($this->password)) {
			if($this->password != $this->passwordAgain) {
				throw new InputException('passwordAgain', 'false');
			}
		}
		if(!User::isValidEmail($this->mail)){
			throw new InputException('mail', 'false');
		}
		if($this->mail != $this->mailAgain) {
			throw new InputException('mailAgain', 'false');
		}
	}

	/**
	 * @see Page::assign()
	 **/
	public function assign() {
		parent::assign();
		Routecms::getTemplate()->assign(array('user' => $this->user,
			'action' => 'edit',
			'userID' => $this->userID));
	}
}