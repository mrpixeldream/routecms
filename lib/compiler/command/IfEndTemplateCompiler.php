<?php
namespace routecms\compiler\command;

/*--------------------------------------------------------------------------------------------------
Datei      		 : IfEndTemplateCompiler.php
Beschreibung 	 : Ende des If Tag Template Kompilirungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class IfEndTemplateCompiler extends TemplateCompiler {

	/**
	 * @see TemplateCompiler::compileTag()
	 */
	public function compileTag() {
		return '<?php } ?>';
	}
}