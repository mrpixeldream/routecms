<?php
namespace routecms\compiler;

/*--------------------------------------------------------------------------------------------------
Datei      		 : Output.php
Beschreibung 	 : Template Ausgabe Skript für Variablen Routecmss
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class Output {

	/**
	 * Template Tag zum ausgeben
	 *
	 * @var    string
	 */
	public $tag = "";
	/**
	 * Gibt an ob die Ausgabe als HTML Quellcode ausgegeben werden soll
	 *
	 * @var    boolean
	 */
	protected $HTML = false;
	/**
	 * Gibt an ob die Ausgabe Nummerisch ist
	 *
	 * @var    boolean
	 */
	protected $numeric = false;

	/**
	 * Inizalisiert das Template Ausgabe Skript System vom Routecms
	 *
	 * @param string $tag
	 */
	public function __construct($tag) {
		$this->tag = $tag;
		$this->checkOutput();
	}

	/**
	 * Überprüft wie die Variable ausgegeben werden soll
	 */
	protected function checkOutput() {
		if($this->tag[0] == '@') {
			$this->tag = mb_substr($this->tag, 1);
		}elseif($this->tag[0] == '#') {
			$this->tag = mb_substr($this->tag, 1);
			$this->numeric = true;
		}else {
			$this->HTML = true;
		}
	}

	/**
	 * Gibt den PHP Quellcode der Variable Ausgabe zurück
	 *
	 * @return string
	 */
	public function getOutput() {
		$compiler = new ArgCompiler($this->tag);
		$this->tag = '<?php echo ';
		if($this->HTML) {
			$this->tag .= 'routecms\util\String::HTMLEncode(';
		}elseif($this->numeric) {
			$this->tag .= 'intval(';
		}
		$this->tag .= $compiler->compileArgs();
		if($this->HTML || $this->numeric) {
			$this->tag .= ')';
		}
		return $this->tag.' ?>';
	}
}