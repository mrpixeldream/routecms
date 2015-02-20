<?php
namespace routecms\compiler\command;
use routecms\compiler\ArgCompiler;
use routecms\compiler\QuoteCompiler;
use routecms\exception\SystemException;
use routecms\system\option\Option;
use routecms\Routecms;
/*--------------------------------------------------------------------------------------------------
Datei      		 : OptionTemplateCompiler.php
Beschreibung 	 : Options Tag Template Kompilirungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class OptionTemplateCompiler extends TemplateCompiler {
	/**
	 * @see TemplateCompiler::compileTag()
	 */
	public function compileTag() {
		$this->args = preg_replace_callback('~\'([^\'\\\\]+|\\\\.)*\'~', array('routecms\compiler\QuoteCompiler',
			'replaceSingleQuotesCallback'), $this->args);
		$this->args = preg_replace_callback('~"([^"\\\\]+|\\\\.)*"~', array('routecms\compiler\QuoteCompiler',
			'replaceDoubleQuotesCallback'), $this->args);
		preg_match_all('~\s+(\w+)\s*=\s*([^=]*)(?=\s|$)~s', $this->args, $matches);
		$args = array();
		for($i = 0, $j = count($matches[1]); $i < $j; $i++) {
			$name = $matches[1][$i];
			$compiler = new ArgCompiler($matches[2][$i]);
			$value = $compiler->compileArgs();
			$value = QuoteCompiler::insertQuotes($value);
			$args[$name] = $value;
		}
		if(!isset($args["option"])) {
			throw new SystemException("Fehler beim Kompilieren des Templates '".Routecms::getTemplate()->getTemplateName()."', keine Option Variabel angegeben");
		}
		$name = substr($args["option"], 1, -1);
		return '<?php echo "'.Option::getOptionValue($name).'" ?>';
	}
}