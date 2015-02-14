<?php
require_once(DIRNAME.'lib/actions/class/Ajax.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : DeleteUser.php
Beschreibung 	 : Ajax Anfrage Seiten um Benutzer zu löschen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 25.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class DeleteUser extends Ajax {
	/**
	 * @see Ajax::$permissions
	 **/
	public $permissions = array('admin.can.delete.user');
	/**
	 * Die userID des Benutzers der gelöscht werden soll
	 *
	 * @var integer
	 **/
	public $userID = 0;

	/**
	 * @see Ajax::read()
	 **/
	public function read() {
		parent::read();
		$this->userID = Input::get("userID", "integer", 0);
		if(!User::canMangedUserByUserID($this->userID)) {
			throw new PermissionExceptionAjax();
		}
	}

	/**
	 * @see Ajax::getData()
	 **/
	public function getData() {
		return array('action' => 'success', 'userID' => $this->userID);
	}

	/**
	 * @see Ajax::action()
	 **/
	public function action() {
		$sql = "DELETE FROM ".DB_PREFIX."user WHERE userID = ?";
		$statement = Routecms::getDB()->statement($sql);
		$statement->execute(array($this->userID));
	}
}