<?php
namespace routecms\admin\pages;

use routecms\exception\InputException;
use routecms\Input;
use routecms\pages\Page;
use routecms\Routecms;
use routecms\system\user\User;
use routecms\system\user\group\Group;
use routecms\util\ArrayUtil;

/*--------------------------------------------------------------------------------------------------
Datei      		 : UserAdd.php
Beschreibung 	 : Seite um einen Benutzer hinzu zufügen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 21.02.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class UserAdd extends Page {

	/**
	 * @see    Page::$template
	 */
	public $template = "userAdd";
	/**
	 * @see    Page::$title
	 */
	public $title = "system.page.userAdd";
	/**
	 * @see Ajax::$permissions
	 **/
	public $permissions = array('admin.can.add.user');
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
	 * Liste mit allen verfügbaren Gruppen
	 *
	 * @var array<\routecms\system\user\group\Group>
	 **/
	public $groups = array();
	/**
	 * Liste mit den Gruppen ID´s der Gruppen für den User
	 *
	 * @var array<integer>
	 **/
	public $groupIDs = array();
	/**
	 * @see    Page::read()
	 */
	public function read() {
		parent::read();
		foreach(Routecms::getPermission("admin.can.mange.group") as $groupID){
			if($groupID != 1 && $groupID != 2){
				$this->groups[$groupID] = new Group($groupID);
			}
		}
	}

	/**
	 * @see    Page::validate()
	 */
	public function validate() {
		parent::validate();
		if(empty($this->username)){
			throw new InputException('username');
		}
		if(!User::usernameAvailable($this->username)) {
			throw new InputException('username', 'use');
		}
		if($this->password != $this->passwordAgain) {
			throw new InputException('passwordAgain', 'false');
		}
		if(empty($this->password)){
			throw new InputException('password');
		}
		if(!User::isValidEmail($this->mail)) {
			throw new InputException('mail', 'false');
		}
		if(empty($this->mail)){
			throw new InputException('mail');
		}
		if($this->mail != $this->mailAgain) {
			throw new InputException('mailAgain', 'false');
		}
		if(!User::emailAvailable($this->mail)){
			throw new InputException('mail', 'use');
		}
		foreach($this->groupIDs as $key => $groupID){
			if($groupID == 1 || $groupID == 2){
				unset($this->groupIDs[$key]);
			}
		}
	}
	/**
	 * @see    Page::save()
	 */
	public function save() {
		parent::save();
		$salt = User::generateSalt();
		$pw = User::cryptPW($this->password, $salt);
		User::create(array_merge($this->additional, array('password' => $pw, 'salt' => $salt,'username' => $this->username,'email' => $this->mail)));
		$user = new User(null,  User::getLast());
		$user->addToGroups($this->groupIDs, true);

		$this->saved();

		$this->username = $this->password = $this->passwordAgain = $this->mail = $this->mailAgain = "";
		$this->groupIDs = array();
		Routecms::getTemplate()->assign(array('success' => true));
	}
	/**
	 * @see    Page::postRead()
	 */
	public function postRead() {
		parent::postRead();
		$this->username = Input::post('username', 'string', '');
		$this->password = Input::post('password', 'string', '');
		$this->passwordAgain = Input::post('passwordAgain', 'string', '');
		$this->mail = Input::post('mail', 'string', '');
		$this->mailAgain = Input::post('mailAgain', 'string', '');
		foreach(ArrayUtil::toIntegerArray(Input::post('groupIDs', 'array', array())) as $groupID => $value){
			if($value == 1){
				$this->groupIDs[] = $groupID;
			}
		}
	}

	/**
	 * @see Page::assign()
	 **/
	public function assign() {
		parent::assign();
		Routecms::getTemplate()->assign(array('username' => $this->username,
			'action' => 'add',
			'groups' => $this->groups,
			'groupIDs' => $this->groupIDs,
			'mail' => $this->mail,
			'mailAgain' => $this->mailAgain));
	}
}