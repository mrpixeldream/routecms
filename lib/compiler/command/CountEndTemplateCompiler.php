<?php
require_once(DIRNAME.'lib/compiler/command/TemplateCompiler.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : CountEndTemplateCompiler.php
Beschreibung 	 : Count End Tag Template Kompilirungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 20.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class CountEndTemplateCompiler extends TemplateCompiler {
	/**
	 * @see TemplateCompiler::compileTag()
	 */
	public function compileTag() {
		return '<?php } ?>';
	}
}