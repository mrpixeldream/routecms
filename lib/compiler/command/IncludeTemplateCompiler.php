<?php
namespace routecms\compiler\command;

use routecms\compiler\ArgCompiler;
use routecms\compiler\QuoteCompiler;
use routecms\exception\SystemException;
use routecms\Routecms;
use routecms\Template;

/*--------------------------------------------------------------------------------------------------
Datei      		 : IncludeTemplateCompiler.php
Beschreibung 	 : Include Tag Template Kompilirungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class IncludeTemplateCompiler extends TemplateCompiler {

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
		if(!isset($args["file"])) {
			throw new SystemException("Fehler beim Kompilieren des Templates '".Routecms::getTemplate()->getTemplateName()."', keine File Variabel angegeben");
		}
		$name = substr($args["file"], 1, -1);
		$templateCompiler = new Template($name, Routecms::getTemplate()->getPath());
		$this->saveIncludes($name);
		return '<?php include("'.$templateCompiler->saveTemplate().'") ?>';
	}

	/**
	 * Speichert die Einzufügen Dateien in eine Array.
	 *
	 * @param string $name
	 */
	protected function saveIncludes($name) {
		$path = DIRNAME.Routecms::getTemplate()->getPath()."compiled/".Routecms::getTemplate()->getTemplateName().".includes";
		if(!file_exists($path)) {
			file_put_contents($path, serialize(array($name)));
		}else {
			$content = unserialize(file_get_contents($path));
			if(!in_array($name, $content)) {
				array_push($content, $name);
			}
			file_put_contents($path, serialize($content));
		}
	}
}