<?php
require_once(DIRNAME.'lib/compiler/command/TemplateCompiler.php');
require_once(DIRNAME.'lib/compiler/ArgCompiler.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : ElseIfTemplateCompiler.php
Beschreibung 	 : Else If Tag Template Kompilirungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class ElseIfTemplateCompiler extends TemplateCompiler {
	/**
	 * @see TemplateCompiler::compileTag()
	 */
	public function compileTag() {
		$result = '';
		$this->args = preg_replace_callback('~\'([^\'\\\\]+|\\\\.)*\'~', array("QuoteCompiler",
			'replaceSingleQuotesCallback'), $this->args);
		$this->args = preg_replace_callback('~"([^"\\\\]+|\\\\.)*"~', array("QuoteCompiler",
			'replaceDoubleQuotesCallback'), $this->args);
		$this->args = str_replace(' ', '', $this->args);

		preg_match_all('~('.Handler::$condition.')~', $this->args, $matches);
		$operators = $matches[1];
		$values = preg_split('~(?:'.Handler::$condition.')~', $this->args);
		for($i = 0, $j = count($values); $i < $j; $i++) {
			$operator = (isset($operators[$i]) ? $operators[$i] : null);
			$value = $values[$i];
			$compiler = new ArgCompiler($value);
			$result .= $compiler->compileArgs();

			if($operator)
				$result .= ' '.$operator.' ';
		}

		$result = QuoteCompiler::insertQuotes($result);
		return '<?php elseif('.$result.') { ?>';
	}
}