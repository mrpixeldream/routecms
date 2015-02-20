<?php
namespace routecms\compiler;
use routecms\exception\SystemException;
/*--------------------------------------------------------------------------------------------------
Datei      		 : Handler.php
Beschreibung 	 : Handler Template Skript Kompiler Klasse des Routecmss
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/


class Handler {

	/**
	 * Regex String um zu prüfen ob es eine doppelte Quote ist
	 *
	 * @var    string
	 */
	public static $quoteDouble = '"(?:[^"\\\\]+|\\\\.)*"';
	/**
	 * Regex String um zu prüfen ob es eine Quote ist
	 *
	 * @var    string
	 */
	public static $quoteSingle = '\'(?:[^\'\\\\]+|\\\\.)*\'';
	/**
	 * Regex String um zu prüfen ob es eine Quote ist
	 *
	 * @var    string
	 */
	public static $quote;
	/**
	 * Regex String um zu prüfen ob es eine Const Variabel ist
	 *
	 * @var    string
	 */
	public static $const = '(?:[A-Z_][A-Z_0-9]*)';

	/**
	 * Regex String um zu prüfen ob es eine Variablename ist
	 *
	 * @var    string
	 */
	public static $name = '(?:[a-zA-Z_][a-zA-Z_0-9]*)';

	/**
	 * Regex String um zu prüfen ob es Numerische Variable ist
	 *
	 * @var    string
	 */
	public static $numeric = '(?i)(?:(?:\-?\d+(?:\.\d+)?)|true|false|null)';

	/**
	 * Regex String um zu prüfen ob es gültiger Variablename ist
	 *
	 * @var    string
	 */
	public static $variable = '\-\>|\.|\(|\)|\[|\]|\||\:|\+|\-|\*|\/|\%|\^|\,';

	/**
	 * Regex String für Operatoren
	 *
	 * @var    string
	 */
	public static $condition = '===|!==|==|!=|<=|<|>=|(?<!-)>|\|\||&&|!|=';

	/**
	 * Regex String um zu prüfen ob es Variable ist
	 *
	 * @var    string
	 */
	public static $var;

	/**
	 * Regex String um zu prüfen ob es Ausgabe Tag ist
	 *
	 * @var    string
	 */
	public static $output;
	/**
	 * Template Tag zum kompilieren
	 *
	 * @var    string
	 */
	public $tag = "";

	/**
	 * Inizalisiert den Handler Template Skript Kompiler System vom Routecms
	 *
	 * @param string $tag
	 */
	public function __construct($tag) {
		$this->tag = $tag;
		self::$quote = '(?:'.self::$quoteDouble.'|'.self::$quoteSingle.')';
		self::$var = '(?:\$('.self::$name.'))';
		self::$output = '(?:(?:@|#)?(?:'.self::$const.'|'.self::$quote.'|'.self::$numeric.'|'.self::$var.'|\())';
	}

	/**
	 * Beginnt mit der Kompilierung des Template Codes
	 *
	 * @throws SystemException
	 * @return string
	 */
	public function startCompiler() {
		if(preg_match('~^'.self::$output.'~s', $this->tag)) {
			$output = new Output($this->tag);
			return $output->getOutput();
		}

		$match = array();

		$this->tag = preg_replace('~^else\s+if(?=\s)~i', 'elseif', $this->tag);
		if(preg_match('~^(/?\w+)~', $this->tag, $match)) {
			$command = $match[1];
			$args = mb_substr($this->tag, mb_strlen($command));
			$command = ucfirst($command);
			if(substr($command, 0, 1) == '/') {
				$class = $this->buildClassString(substr($command, 1), true);
			}else {
				$class = $this->buildClassString($command);
			}
			if(class_exists($class)) {
				$output = new $class($args);
				return $output->compileTag();
			}else {
				throw new SystemException("Undefinierter Template Befehl = '".$command."'");
			}
		}
		return "";
	}

	/**
	 * Gibt den Klassen Namen zur Kompilierung eines Template Befehl
	 *
	 * @param string  $command
	 * @param boolean $end
	 *
	 * @return string
	 */

	protected function buildClassString($command, $end = false) {
		$command = 'routecms\compiler\command\\'.$command;
		if($end) {
			return $command."EndTemplateCompiler";
		}
		return $command."TemplateCompiler";
	}
}