<?php
require_once(DIRNAME.'lib/system/option/Option.php');
require_once(DIRNAME.'lib/compiler/ArgCompiler.php');

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
		$this->args = preg_replace_callback('~\'([^\'\\\\]+|\\\\.)*\'~', array("QuoteCompiler",
			'replaceSingleQuotesCallback'), $this->args);
		$this->args = preg_replace_callback('~"([^"\\\\]+|\\\\.)*"~', array("QuoteCompiler",
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
			throw new Exception("Fehler beim Kompilieren des Templates '".Routecms::getTemplate()->getTemplateName()."', keine Option Variabel angegeben");
		}
		$name = substr($args["option"], 1, -1);
		return '<?php echo "'.Option::getOptionValue($name).'" ?>';
	}
}