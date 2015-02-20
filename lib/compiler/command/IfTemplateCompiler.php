<?php
namespace routecms\compiler\command;
use routecms\compiler\ArgCompiler;
use routecms\compiler\QuoteCompiler;
use routecms\compiler\Handler;
/*--------------------------------------------------------------------------------------------------
Datei      		 : IfTemplateCompiler.php
Beschreibung 	 : If Tag Template Kompilirungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class IfTemplateCompiler extends TemplateCompiler {
	/**
	 * @see TemplateCompiler::compileTag()
	 */
	public function compileTag() {
		$result = '';
		$this->args = preg_replace_callback('~\'([^\'\\\\]+|\\\\.)*\'~', array('routecms\compiler\QuoteCompiler',
			'replaceSingleQuotesCallback'), $this->args);
		$this->args = preg_replace_callback('~"([^"\\\\]+|\\\\.)*"~', array('routecms\compiler\QuoteCompiler',
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
		return '<?php if('.$result.') { ?>';
	}
}