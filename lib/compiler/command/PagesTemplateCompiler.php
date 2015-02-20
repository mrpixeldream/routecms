<?php
namespace routecms\compiler\command;
use routecms\compiler\ArgCompiler;
use routecms\compiler\QuoteCompiler;

/*--------------------------------------------------------------------------------------------------
Datei      		 : PagesTemplateCompiler.php
Beschreibung 	 : Pages Tag Template Kompilirungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class PagesTemplateCompiler extends TemplateCompiler {
	/**
	 * @see TemplateCompiler::compileTag()
	 */
	public function compileTag() {
		$result = '<?php';
		$this->args = preg_replace_callback('~\'([^\'\\\\]+|\\\\.)*\'~', array('routecms\compiler\QuoteCompiler',
			'replaceSingleQuotesCallback'), $this->args);
		$this->args = preg_replace_callback('~"([^"\\\\]+|\\\\.)*"~', array('routecms\compiler\QuoteCompiler',
			'replaceDoubleQuotesCallback'), $this->args);
		preg_match_all('~\s+(\w+)\s*=\s*([^=]*)(?=\s|$)~s', $this->args, $matches);
		$link = "";
		$sortOrder = "";
		$sortField = "";
		$print = false;
		for($i = 0, $j = count($matches[1]); $i < $j; $i++) {
			$name = $matches[1][$i];
			if($name == "link") {
				$compiler = new ArgCompiler($matches[2][$i]);
				$value = $compiler->compileArgs();
				$link .= $value;
			}elseif($name == "sortField") {
				$compiler = new ArgCompiler($matches[2][$i]);
				$value = $compiler->compileArgs();
				$sortField = $value;
			}elseif($name == "sortOrder") {
				$compiler = new ArgCompiler($matches[2][$i]);
				$value = $compiler->compileArgs();
				$sortOrder = $value;
			}elseif($name == "print") {
				$compiler = new ArgCompiler($matches[2][$i]);
				$value = $compiler->compileArgs();
				$print = $value;
			}
		}
		if($sortOrder != "") {
			$link .= '."&amp;sortOrder=".'.$sortOrder;
		}
		if($sortField != "") {
			$link .= '."&amp;sortField=".'.$sortField;
		}
		$result .= ' $this->vars["pageLinks"] = routecms\util\Pagination::getPagination('.$link.', $this->vars["pages"], $this->vars["pageNo"]);';
		$result = QuoteCompiler::insertQuotes($result);
		if($print == "true") {
			return $result.'
			echo $this->vars["pageLinks"];
			?>';
		}else {
			return $result.' ?>';
		}
	}
}