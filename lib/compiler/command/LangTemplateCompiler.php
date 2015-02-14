<?php
require_once(DIRNAME.'lib/compiler/command/TemplateCompiler.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : LangTemplateCompiler.php
Beschreibung 	 : Sprach Variabel Tag Template Kompilirungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class LangTemplateCompiler extends TemplateCompiler {

	/**
	 * @see TemplateCompiler::compileTag()
	 */
	public function compileTag() {
		$this->args = preg_replace_callback('~\'([^\'\\\\]+|\\\\.)*\'~', array("QuoteCompiler",
			'replaceSingleQuotesCallback'), $this->args);
		$this->args = preg_replace_callback('~"([^"\\\\]+|\\\\.)*"~', array("QuoteCompiler",
			'replaceDoubleQuotesCallback'), $this->args);
		$compiler = new ArgCompiler($this->args);
		$this->args = $compiler->compileArgs();
		$this->args = QuoteCompiler::insertQuotes($this->args);
		return '<?php echo lang('.$this->args.') ?>';
	}
}