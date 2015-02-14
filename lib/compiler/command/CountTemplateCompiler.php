<?php
require_once(DIRNAME.'lib/compiler/command/TemplateCompiler.php');
require_once(DIRNAME.'lib/compiler/ArgCompiler.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : CountTemplateCompiler.php
Beschreibung 	 : Count Tag Template Kompilirungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 20.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class CountTemplateCompiler extends TemplateCompiler {

	/**
	 * @see TemplateCompiler::compileTag()
	 */
	public function compileTag() {
		$result = '<?php if(count(';
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
				$result .= $value.')';
			}else {
				$compiler = new ArgCompiler($matches[2][$i]);
				$value = $compiler->compileArgs();
				if($name == "min") {
					$result .= ' > '.intval($value);
				}elseif($name == "max") {
					$result .= ' < '.intval($value);
				}elseif($name == "equal") {
					$result .= ' == '.intval($value);
				}elseif($name == "min") {
					$result .= ' > '.intval($value);
				}elseif($name == "minEqual") {
					$result .= ' >= '.intval($value);
				}elseif($name == "maxEqual") {
					$result .= ' <= '.intval($value);
				}
			}
		}
		$result = QuoteCompiler::insertQuotes($result);
		$result .= '){ ?>';
		return $result;
	}
}