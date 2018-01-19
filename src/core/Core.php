<?php

// %{}% basic var from conf->attributes
// %{()}% system var
// %{[]}% replaced by function

namespace Core;

class Core {

	private $conf;
	private $lang;

	private $page;
	private $template;

	private $getContent;
	private $postContent;
	
	public function __construct() {
		$confFile = APP . DS . 'json' . DS . 'conf.json';

		if(!file_exists($confFile)) {
			echo 'Configuration file not found.';
			die();
		}

		// Load configuration
		$this->conf = json_decode(file_get_contents($confFile));

		// Get get and post vars
		$this->getContent = new \stdClass();
		$this->postContent = new \stdClass();

		foreach ($_GET as $k => $v)
			$this->getContent->$k = $v;

		foreach ($_POST as $k => $v)
			$this->postContent->$k = $v;

		// Set language
		$this->lang = $this->conf->languages->default;
		if(!empty($this->getContent->lang) && in_array($this->getContent->lang, $this->conf->languages->available))
			$this->lang = $this->getContent->lang;
			

		// Define page to load
		$this->page = $this->conf->templates->defaultPage;
		if(!empty($this->getContent->page)) {
			if(!file_exists(JSON . DS . "pages" . DS . $this->getContent->page . '.json')) {
				echo 'Page file not found.';
				die();
			}
			$this->page = $this->getContent->page;
		}
			
		// Define templaate to use
		$this->template =  $this->conf->templates->defaultTemplate;
		if(!empty($this->page->conf->template) && in_array($this->page->conf->template, $this->conf->template->available)){
			if(!file_exists(JSON . DS . "templates" . DS . $this->page->conf->template . DS . 'template.html')) {
				echo 'Template not found.';
				die();
			}
			$this->page = $this->getContent->page;
		}

		$this->render();
	}

	private function render() {
		$templateFile = file_get_contents(APP . DS . "templates" . DS . $this->template . DS . 'template.html');

		$templateFile = str_replace('%{(lang)}%', $this->lang, $templateFile);

		foreach($this->conf->attributes as $name => $value) {
			$templateFile = str_replace('%{' . $name . '}%', $value->{$this->lang}, $templateFile);
		}

		if(preg_match_all('/%{\[date\(\'([a-zA-Z\-\/\:\ ]+)\'\)\]}%/', $templateFile, $matches)) {
			foreach($matches[0] as $i => $match) {
				$templateFile = str_replace($match, date($matches[1][$i]), $templateFile);
			}
		}

		$pageDefinition = json_decode(file_get_contents(JSON . DS . "pages" . DS . $this->page . '.json'));

		$contentForTemplate = $this->prepareContent(clone $pageDefinition);

		$templateFile = str_replace('%{(content_for_template)}%', $contentForTemplate, $templateFile);

		echo $templateFile;
	}

	private function prepareContent($json) {
		$conf = $json->conf;
		unset($json->conf);

		$generatedFile = '';
		
		foreach($json as $type => $content) {
			
			$generatedFile .= $this->generateCode($content, null, $type);

			// $contentFilePath = APP . DS . "templates" . DS . $this->template . DS . $type . DS . 'main.html';
			// if(file_exists($contentFilePath)) {
			// 	$contentFile = \file_get_contents($contentFilePath);

			// 	foreach($contents as $name => $content){
			// 		$tempContent = str_replace('%[name]%', $name, $contentFile);

			// 		$generatedFile .= str_replace('%[content]%', '', $tempContent);
			// 	}

			// }
		}

		return $generatedFile;
	}

	private function generateCode($content, $subpath = null, $type = null) {
		$contentFilePath = APP . DS . "templates" . DS . $this->template . DS . $subpath . ($type ?? $content->type) . DS . 'main.html';

		$generatedFile = '';

		if(file_exists($contentFilePath)) {
			$contentFile = \file_get_contents($contentFilePath);

			foreach($content as $block){
				debug($block);
				$blockType = $block->type;

				foreach($block as $name => $value) {

					if($name == 'content') {
						// Call to itself
						$subContent = $this->generateCode($value, $subpath . ((!is_null($blockType))?DS . $blockType:'') . DS);
						$contentFile = str_replace('%[content]%', $subContent, $contentFile);
					}
					else {
						$contentFile = str_replace('%[' . $name . ']%', $value, $contentFile);
					}
				}

			}
			debug($generatedFile);
			$generatedFile .= $contentFile;

		}

		return $generatedFile;
	}

}

?>