<?php
require_once(DIRNAME.'lib/compiler/command/TemplateCompiler.php');
require_once(DIRNAME.'lib/compiler/ArgCompiler.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : ForeachEndTemplateCompiler.php
Beschreibung 	 : Foreach End Tag Template Kompilirungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class ForeachEndTemplateCompiler extends TemplateCompiler {

	/**
	 * @see TemplateCompiler::compileTag()
	 */
	public function compileTag() {
		return '<?php } ?>';
	}
}