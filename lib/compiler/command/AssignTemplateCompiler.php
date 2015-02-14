<?php
require_once(DIRNAME.'lib/compiler/command/TemplateCompiler.php');
require_once(DIRNAME.'lib/compiler/ArgCompiler.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : AssignTemplateCompiler.php
Beschreibung 	 : Assign Tag Template Kompilirungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 07.02.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class AssignTemplateCompiler extends TemplateCompiler {

	/**
	 * @see TemplateCompiler::compileTag()
	 */
	public function compileTag() {
		$result = '<?php $this->vars[';
		$this->args = preg_replace_callback('~\'([^\'\\\\]+|\\\\.)*\'~', array("QuoteCompiler",
			'replaceSingleQuotesCallback'), $this->args);
		$this->args = preg_replace_callback('~"([^"\\\\]+|\\\\.)*"~', array("QuoteCompiler",
			'replaceDoubleQuotesCallback'), $this->args);
		preg_match_all('~\s+(\w+)\s*=\s*([^=]*)(?=\s|$)~s', $this->args, $matches);
		for($i = 0, $j = count($matches[1]); $i < $j; $i++) {
			$name = $matches[1][$i];
			if($name == "var") {
				$compiler = new ArgCompiler($matches[2][$i]);
				$value = $compiler->compileArgs();
				$result .= $value.'] =';
			}elseif($name == "value"){
				$compiler = new ArgCompiler($matches[2][$i]);
				$value = $compiler->compileArgs();
				$result .= $value;
			}
		}
		$result = QuoteCompiler::insertQuotes($result);
		$result .= '; ?>';
		return $result;
	}
}