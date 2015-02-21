<?php
namespace routecms\compiler\command;

use routecms\compiler\ArgCompiler;
use routecms\compiler\QuoteCompiler;
use routecms\exception\SystemException;
use routecms\Routecms;
use routecms\system\event\template\TemplateEventManger;
use routecms\Template;

/*--------------------------------------------------------------------------------------------------
Datei      		 : EventTemplateCompiler.php
Beschreibung 	 : Template Event Tag Kompilirungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 19.02.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class EventTemplateCompiler extends TemplateCompiler {

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
		if(!isset($args["name"])) {
			throw new SystemException("Fehler beim Kompilieren des Templates '".Routecms::getTemplate()->getTemplateName()."', kein Event Name Variabel angegeben");
		}
		$name = $args["name"];
		$name = str_replace('"', '', $name);
		$name = str_replace("'", '', $name);
		$events = TemplateEventManger::event($name, Routecms::getTemplate()->getTemplateName());
		if(count($events) > 0) {
			$result = '';
			foreach($events as $templateEvent) {
				$templateCompiler = new Template($templateEvent->templateInclude, Routecms::getTemplate()->getPath());
				$this->saveIncludes($name);
				$result .= 'include("'.$templateCompiler->saveTemplate().'");'.PHP_EOL;
			}
			return '<?php '.$result.' ?>';
		}else {
			return '';
		}
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