<?php
/*--------------------------------------------------------------------------------------------------
Datei      		 : AutoLoad.php
Beschreibung 	 : Lädt automatisch einige Klassen in das System ein
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/
/**
 * Lädt automatisch eine Klasse ein
 *
 * @param string $pfad
 */
function loadClass($pfad) {
	if(file_exists($pfad)) {
		require_once($pfad);
		return;
	}
}

/**
 * Lädt automatisch alle Klassen aus erforderlichen Ordnern ein
 */
function autoLoad() {
	loadDir(DIRNAME."lib/util/");
	loadDir(DIRNAME."lib/compiler/command/");
	loadDir(DIRNAME."lib/exception/");
	return;
}
/**
 * Lädt alle PHP Dateien aus ein bestimmten Ordner ein
 */
function loadDir($path){
	$list = scandir($path);
	foreach($list as $id => $file) {
		if($file != "." && $file != "..") {
			require_once($path.$file);
		}
	}
}