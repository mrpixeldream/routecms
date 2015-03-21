<?php
namespace routecms\compiler\command;

use routecms\compiler\ArgCompiler;
use routecms\compiler\QuoteCompiler;
use routecms\exception\SystemException;
use routecms\Routecms;

/*--------------------------------------------------------------------------------------------------
Datei      		 : ForeachTemplateCompiler.php
Beschreibung 	 : Isset Tag Template Kompilirungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class ForeachTemplateCompiler extends TemplateCompiler {

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
		if(!isset($args["from"])) {
			throw new SystemException("Fehler beim kompilieren des Templates '".Routecms::getTemplate()->getTemplateName()."', beim Foreach Tag, keine From Variabel angegeben");
		}
		if(!isset($args["item"])) {
			throw new SystemException("Fehler beim kompilieren des Templates '".Routecms::getTemplate()->getTemplateName()."', beim Foreach Tag, keine Item Variabel angegeben");
		}
		$from = $args["from"];
		$item = $args["item"];
		if(isset($args["key"])) {
			$key = $args["key"];
			return '<?php foreach('.$from.' as $this->vars['.$item.'] => $this->vars['.$key.']){?>';
		}else {
			return '<?php foreach('.$from.' as $this->vars['.$item.']){?>';
		}
	}
}