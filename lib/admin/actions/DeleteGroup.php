<?php
namespace routecms\admin\actions;
use routecms\actions\Ajax;
use routecms\exception\PermissionExceptionAjax;
use routecms\Routecms;
use routecms\Input;
/*--------------------------------------------------------------------------------------------------
Datei      		 : DeleteGroup.php
Beschreibung 	 : Ajax Anfrage Seiten um Benutzergruppen zu löschen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 25.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class DeleteGroup extends Ajax {
	/**
	 * @see Ajax::$permissions
	 **/
	public $permissions = array('admin.can.delete.group');
	/**
	 * Die userID des Benutzers der gelöscht werden soll
	 *
	 * @var integer
	 **/
	public $groupID = 0;

	/**
	 * @see Ajax::read()
	 **/
	public function read() {
		parent::read();
		$this->groupID = Input::get("groupID", "integer", 0);
		if(!in_array($this->groupID, Routecms::getPermission("admin.can.mange.group"))){
			throw new PermissionExceptionAjax();
		}
	}

	/**
	 * @see Ajax::getData()
	 **/
	public function getData() {
		return array('action' => 'success', 'groupID' => $this->groupID);
	}

	/**
	 * @see Ajax::action()
	 **/
	public function action() {
		$sql = "DELETE FROM ".DB_PREFIX."group WHERE groupID = ?";
		$statement = Routecms::getDB()->statement($sql);
		$statement->execute(array($this->groupID));
	}
}