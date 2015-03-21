<?php
namespace routecms\admin\pages;

use routecms\pages\SortPage;

/*--------------------------------------------------------------------------------------------------
Datei      		 : MemberLst.php
Beschreibung 	 : Mitglieder Verwaltungs Seite
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 31.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class MemberList extends SortPage {
	/**
	 * @see    Page::$template
	 */
	public $template = "memberList";
	/**
	 * @see    Page::$title
	 */
	public $title = "system.admin.page.members";
	/**
	 * @see    SortPage::$class
	 */
	public $class = 'routecms\system\user\User';

	/**
	 * @see    SortPage::$defaultField
	 */
	public $defaultField = 'userID';

	/**
	 * @see    SortPage::$defaultOrder
	 */
	public $defaultOrder = 'ASC';

	/**
	 * @see   SortPage::$validFields
	 */
	public $validFields = array('userID',
		'username',
		'email');

	/**
	 * @see    Page::read()
	 */
	public function read() {
		$this->sqlCount = "SELECT COUNT(*) AS count FROM ".DB_PREFIX."user";
		$this->sql = "SELECT * FROM ".DB_PREFIX."user";
		parent::read();
	}
}