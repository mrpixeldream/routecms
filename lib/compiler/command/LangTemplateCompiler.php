<?php
namespace routecms\compiler\command;

use routecms\compiler\ArgCompiler;
use routecms\compiler\QuoteCompiler;

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
		$this->args = preg_replace_callback('~\'([^\'\\\\]+|\\\\.)*\'~', array('routecms\compiler\QuoteCompiler',
			'replaceSingleQuotesCallback'), $this->args);
		$this->args = preg_replace_callback('~"([^"\\\\]+|\\\\.)*"~', array('routecms\compiler\QuoteCompiler',
			'replaceDoubleQuotesCallback'), $this->args);
		$compiler = new ArgCompiler($this->args);
		$this->args = $compiler->compileArgs();
		$this->args = QuoteCompiler::insertQuotes($this->args);
		return '<?php echo routecms\Routecms::lang('.$this->args.') ?>';
	}
}