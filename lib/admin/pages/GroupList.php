<?php
namespace routecms\admin\pages;
use routecms\pages\SortPage;

/*--------------------------------------------------------------------------------------------------
Datei      		 : GroupList.php
Beschreibung 	 : Benutzergruppen Verwaltungs Seite
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 29.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class GroupList extends SortPage {
	/**
	 * @see    Page::$template
	 */
	public $template = "groupList";
	/**
	 * @see    Page::$title
	 */
	public $title = "system.admin.page.members";
	/**
	 * @see    SortPage::$class
	 */
	public $class = 'routecms\system\user\group\Group';

	/**
	 * @see    SortPage::$defaultField
	 */
	public $defaultField = 'groupID';

	/**
	 * @see    SortPage::$defaultOrder
	 */
	public $defaultOrder = 'ASC';

	/**
	 * @see   SortPage::$validFields
	 */
	public $validFields = array('groupID',
		'name');

	/**
	 * @see    Page::read()
	 */
	public function read() {
		$this->sqlCount = "SELECT COUNT(*) AS count FROM ".DB_PREFIX."group";
		$this->sql = "SELECT * FROM ".DB_PREFIX."group";
		parent::read();
	}
}