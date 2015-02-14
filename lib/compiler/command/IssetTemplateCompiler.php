<?php
require_once(DIRNAME.'lib/compiler/command/TemplateCompiler.php');
require_once(DIRNAME.'lib/compiler/ArgCompiler.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : IssetTemplateCompiler.php
Beschreibung 	 : Isset Tag Template Kompilirungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class IssetTemplateCompiler extends TemplateCompiler {

	/**
	 * @see TemplateCompiler::compileTag()
	 */
	public function compileTag() {
		$result = '<?php if(';
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
				if($result == '<?php if(') {
					$result .= 'isset('.$value.')';
				}else {
					$result .= '&& isset('.$value.')';
				}
			}
		}
		$result = QuoteCompiler::insertQuotes($result);
		$result .= '){ ?>';
		return $result;
	}
}