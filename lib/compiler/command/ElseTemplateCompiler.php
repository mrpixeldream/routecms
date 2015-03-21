<?php
namespace routecms\compiler\command;

/*--------------------------------------------------------------------------------------------------
Datei      		 : ElseTemplateCompiler.php
Beschreibung 	 : Else Tag Template Kompilirungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class ElseTemplateCompiler extends TemplateCompiler {

	/**
	 * @see TemplateCompiler::compileTag()
	 */
	public function compileTag() {
		return '<?php }else{ ?>';
	}
}