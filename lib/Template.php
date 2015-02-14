<?php
require_once(DIRNAME.'lib/compiler/Handler.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : Template.php
Beschreibung 	 : Template Klasse des Routecmss
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 02.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class Template {

	/**
	 * Der Name der aktuellen Template Datei
	 *
	 * @var    string
	 */
	protected $name;
	/**
	 * Der Pfad zum Template Ordner
	 *
	 * @var    string
	 */
	protected $path;
	/**
	 * Der Inhalt der aktuellen Template Datei
	 *
	 * @var    string
	 */
	protected $content;
	/**
	 * Der hash der aktuellen Template Datei
	 *
	 * @var    string
	 */
	protected $hash;
	/**
	 * Die aktuellen Template variablen
	 *
	 * @var    array
	 */
	protected $vars = array();

	/**
	 * Start Trennzeichen
	 *
	 * @var    string
	 */
	protected $start = "{";

	/**
	 * End Trennzeichen
	 *
	 * @var    string
	 */
	protected $end = "}";

	/**
	 * Inizalisiert das Template System vom Routecms
	 *
	 * @param string $name
	 * @param string $path
	 */
	public function __construct($name, $path = "lib/template/") {
		$this->name = $name;
		$this->path = $path;
		$this->start = preg_quote('{', '~').'(?=\S)';
		$this->end = '(?<=\S)'.preg_quote('}', '~');
		$this->content = file_get_contents(DIRNAME.$this->path.$this->name.".tpl");
		$this->content = self::replacePHP($this->content);
		$this->hash = sha1($this->content);
		$url = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$this->assign(array('country' => Routecms::getLanguage()->country,
			'__Routecms' => Routecms::getInstance(),
			'pageName' => Routecms::getPage(),
			'user' => Routecms::getUser(),
			'baseHref' => substr($url, 0, strrpos($url, "/") + 1)));
	}

	/**
	 * Entfernt alle php Tags
	 *
	 * @param    string $string
	 *
	 * @return    string
	 */
	public static function replacePHP($string) {
		if(mb_strpos($string, '<?') !== false) {
			$string = str_replace('<?php', '@@PHP_START_TAG@@', $string);
			$string = str_replace('<?', '@@PHP_SHORT_START_TAG@@', $string);
			$string = str_replace('?>', '@@PHP_END_TAG@@', $string);
			$string = str_replace('@@PHP_END_TAG@@', "<?php echo '?>'; ?>\n", $string);
			$string = str_replace('@@PHP_SHORT_START_TAG@@', "<?php echo '<?'; ?>\n", $string);
			$string = str_replace('@@PHP_START_TAG@@', "<?php echo '<?php'; ?>\n", $string);
		}
		return $string;
	}

	/**
	 * Speichert die Variablen in eine array
	 *
	 * @param mixed $var
	 * @param mixed $value
	 **/
	public function assign($var, $value = '') {
		if(is_array($var)) {
			foreach($var as $key => $value) {
				if(empty($key))
					continue;

				$this->assign($key, $value);
			}
		}else {
			$this->vars[$var] = $value;
		}
	}

	/**
	 * Inizalisiert ein neues Template
	 *
	 * @param string $name
	 * @param string $path
	 */
	public function fetchTemplate($name, $path = "lib/template/") {
		EventManger::event("fetchTemplate", get_class($this), $this);
		$this->name = $name;
		$this->assign(array('template' => $this->name));
		$this->path = $path;
		$this->start = preg_quote('{', '~').'(?=\S)';
		$this->end = '(?<=\S)'.preg_quote('}', '~');
		$this->content = file_get_contents(DIRNAME.$this->path.$this->name.".tpl");
		$this->content = self::replacePHP($this->content);
		$this->hash = sha1($this->content);
		$this->assign(array('country' => Routecms::getLanguage()->country));
		$this->saveTemplate();
		$this->showTemplate();
	}

	/**
	 * Speichert das aktuelle Template und gibt den Namen der Template Datei zurück
	 *
	 * @return string
	 */
	public function saveTemplate() {
		if($this->checkCompile($this->name)) {
			$this->compile();
			$this->content = '<?php
/**
 * Hash : '.$this->hash.'
 */
?>
'.$this->content;
			file_put_contents(DIRNAME.$this->path."compiled/".$this->name.".php", $this->content);
		}
		return $this->name.".php";
	}

	/**
	 * Überpürft ob die Template Datei neu kompiliert werden muss
	 *
	 * @param string $name
	 *
	 * @return boolean
	 */
	protected function checkCompile($name) {
		$compile = true;
		if(file_exists(DIRNAME.$this->path."compiled/".$name.".php")) {
			$handle = fopen(DIRNAME.$this->path."compiled/".$name.".php", "r");
			$lines = array();
			if($handle) {
				while(($line = fgets($handle)) !== false) {
					$lines[] = $line;
				}
			}
			fclose($handle);
			$content = $lines[2];
			$content = str_replace(" * Hash : ", "", $content);
			$content = str_replace("\r\n", "", $content);
			if($this->hash == $content) {
				if(file_exists(DIRNAME.$this->path."compiled/".$name.".includes")) {
					foreach(unserialize(file_get_contents(DIRNAME.$this->path."compiled/".$name.".includes")) as $include) {
						$templateCompiler = new Template($include, $this->getPath());
						$templateCompiler->saveTemplate();
					}
				}
				$compile = false;
			}
		}
		return $compile;
	}

	/**
	 * Gibt dem Pfad zurück
	 *
	 * @return    string
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * Kompiliert den aktuellen Template Inhalt
	 */
	protected function compile() {
		preg_match_all("~".$this->start."(.*?)".$this->end."~s", $this->content, $matches);
		$tags = $matches[1];
		foreach($tags as $tag) {
			$handler = new Handler($tag);
			$return = $handler->startCompiler();
			$this->content = str_replace('{'.$tag.'}', $return, $this->content);
		}
	}

	/**
	 * Gibt das aktuelle Template aus
	 */
	public function showTemplate() {
		EventManger::event("showTemplate", get_class($this), $this);
		include(DIRNAME.$this->path."compiled/".$this->name.".php");
	}

	/**
	 * Gibt dem Template Name zurück
	 *
	 * @return    string
	 */
	public function getTemplateName() {
		return $this->name;
	}
}