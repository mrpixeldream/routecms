<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
if(!defined('DIRNAME'))
{
    define('DIRNAME', str_replace('\\', '/', dirname(__FILE__)).'/../');
} 
require_once(DIRNAME.'lib/Routecms.php');
$routecms = new Routecms();
$routecms->startTemplate();
