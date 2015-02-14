<?php
if(!defined('DIRNAME'))
	define('DIRNAME', str_replace('\\', '/', dirname(__FILE__)).'/../');
if(!defined('ADMIN'))
	define('ADMIN', true);
require_once(DIRNAME.'lib/Admin.php');
$admin = new Admin();
$admin->startTemplate();