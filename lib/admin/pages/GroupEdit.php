<?php
require_once(DIRNAME.'lib/pages/class/Page.php');
require_once(DIRNAME.'lib/system/user/group/Group.php');
require_once(DIRNAME.'lib/system/user/group/GroupOptionCategory.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : Index.php
Beschreibung 	 : Startseite des Routecms
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 11.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class GroupEdit extends Page {
	/**
	 * @see    Page::$template
	 */
	public $template = "groupEdit";
	/**
	 * @see    Page::$title
	 */
	public $title = "system.page.groupEdit";
	/**
	 * @see Ajax::$permissions
	 **/
	public $permissions = array('admin.can.edit.group');
	/**
	 * Die userID des Benutzers der gelöscht werden soll
	 *
	 * @var integer
	 **/
	public $groupID = 0;
	/**
	 * Das Benutzergruppen Objekt was derzeit bearbeitet wird
	 *
	 * @var Group
	 **/
	public $group = null;
	/**
	 * Eine Liste mit allen Gruppen Optionen
	 *
	 * @var array<GroupOption>
	 **/
	public $optionList = array();

	/**
	 * @see Page::read()
	 **/
	public function read() {
		parent::read();
		$this->groupID = Input::get("groupID", "integer", 0);
		$this->group = new Group($this->groupID);
		if(!$this->group || !isset($this->group->groupID) && $this->group->groupID == 0) {
			throw new IllegalLinkException();
		}
		if(!in_array($this->groupID, Routecms::getPermission("admin.can.mange.group"))) {
			throw new PermissionException();
		}
		if(count($this->optionList) == 0) {
			$sql = "SELECT	*
			FROM	".DB_PREFIX."group_option ORDER BY position ASC, category ASC";
			$statement = Routecms::getDB()->statement($sql);
			$statement->execute();
			while($row = $statement->fetchArray()) {
				$option = new GroupOption(null, $row);
				$this->optionList[$option->optionID]["option"] = $option;
				$this->optionList[$option->optionID]["output"] = $option->getOutput($this->group);
							}
		}
	}

	/**
	 * @see Page::assign()
	 **/
	public function assign() {
		parent::assign();
		Routecms::getTemplate()->assign(array('tree' => GroupOptionCategory::getTree(),
			'groupID' => $this->groupID,
			'optionList' => $this->optionList,
			'group' => $this->group));
	}
}