<?php
require_once(DIRNAME.'lib/compiler/QuoteCompiler.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : IfTemplateCompiler.php
Beschreibung 	 : If Tag Template Kompilirungs Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class ArgCompiler {

	/**
	 * Die Parameter Zeichenkette
	 *
	 * @var    string
	 */
	protected $args;

	/**
	 * Inizalisiert einen Parameter Template Kompiler
	 */
	public function __construct($args) {
		$this->args = $args;
	}

	/**
	 * Gibt einen kompilierte Zeichenkette der Parameter
	 *
	 * @throws Exception
	 * @return string
	 */
	public function compileArgs() {
		preg_match_all('~('.Handler::$variable.')~', $this->args, $matches);
		$operators = $matches[1];
		$values = preg_split('~(?:'.Handler::$variable.')~', $this->args);
		$result = '';
		$status = "start";
		for($i = 0, $j = count($values); $i < $j; $i++) {
			$value = $values[$i];
			$value = trim($value);
			$operator = (isset($operators[$i]) ? $operators[$i] : null);
			if($value !== '') {
				$type = $this->getVariableType($value);
				if($status == "start") {
					$result .= $this->getVar($value, $type);
				}elseif("operator") {
					if($type == "variable") {
						$result .= $this->getVar($value, $type);
					}else {
						$result .= $value;
					}
				}
			}
			if($operator !== null) {
				$status = "operator";
				$result .= $operator;
			}
		}
		return $result;
	}

	/**
	 * Gibt den Variabeln Type zurück
	 *
	 * @param    string $var
	 *
	 * @return    string
	 */
	protected function getVariableType($var) {
		if(substr($var, 0, 1) == '$')
			return 'variable';else if(substr($var, 0, 2) == '@@')
			return 'string';else return 'constant';
	}

	/**
	 * Gibt eine Kompilierte Variabel zurück
	 *
	 * @param    string $value
	 * @param    string $type
	 *
	 * @return    string
	 */
	protected function getVar($value, $type) {
		if($type == 'variable') {
			return '$this->vars[\''.substr($value, 1).'\']';
		}elseif($type == 'string') {
			return $value;
		}elseif(($value == 'true' || $value == 'false' || $value == 'null' || preg_match('/^[A-Z0-9_]*$/', $value))) {
			return $value;
		}else return "'".$value."'";
	}

}