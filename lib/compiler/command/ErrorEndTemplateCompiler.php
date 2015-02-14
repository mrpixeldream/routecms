<?php
require_once(DIRNAME.'lib/compiler/command/TemplateCompiler.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : ErrorEndTemplateCompiler.php
Beschreibung 	 : Error End Tag Template Kompilirungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 13.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class ErrorEndTemplateCompiler extends TemplateCompiler {
	/**
	 * @see TemplateCompiler::compileTag()
	 */
	public function compileTag() {
		return '<?php } ?>';
	}
}