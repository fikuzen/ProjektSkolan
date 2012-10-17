<?php

namespace View;

/*
	Generates a HTML page with head and body as well as structure.
	It also handles all meta-tags, stylesheets, scripts and charsets etc. 
*/
class Page
{
	/* Member variables */
	private $m_stylesheets = array();
	private $m_scripts = array();
	private $m_charset = "";
	private $m_language = "";
	private $m_title = "";
	
	/**
	 * @param $charset, string tecken encoding
	 */ 
	public function __construct($language = "sv", $charset = "utf-8")
	{
		$this->m_language = $language;
		$this->m_charset = $charset;
	}
	
	public function SetTitle($title) { $this->m_title = $title; }
	
	/**
	 * @param $stylesheet, URL to stylesheet
	 */
	public function AddStylesheet($stylesheet)
	{
		$this->m_stylesheets[] = "<link rel='stylesheet' href='$stylesheet' type='text/css' />";
	}
	
	/**
	 * @param $javascript, URL to script
	 */
	public function AddJavascript($javascript)
	{
		$this->m_scripts[] = "<script src='$javascript'></script>";
	}
	
	/* Generates the content of the head */
	public function GenerateHead()
	{
		$head = "<head>";
		$head .= "<title>" . $this->m_title . "</title>";
		$head .= "<meta charset='utf-8' />";
			
		foreach ($this->m_stylesheets as $stylesheet)
			$head .= $stylesheet;
			
		$head .= "</head>";
		
		return $head;
	}
	
	/* Generates the content of the body */
	public function GenerateBody($bodyContent, $navigationBar = NULL)
	{
		$body = "<body>";
		$body .= "<div class='wrapper'>";
		$body .= "<div class='content'>";
		if ($navigationBar != NULL)
		{
			$body .= "<div class='navigationBar'>";
			$body .= $navigationBar;
			$body .= "</div>";
		}
		$body .= $bodyContent;
		$body .= "</div>";
		foreach ($this->m_scripts as $script)
			$body .= $script;
		$body .= "</div>";
		$body .= "</body>";
		
		return $body;
	}
	
	/**
	 * The HTML5 Page
	 *
	 * @param $language, the language, default SV
	 * @param $bodyContent, the content
	 * @param $navigationbar, the navigation bar, default NULL
	 * @return $html, a html generated page.
	 */
	public function GenerateHTML5Page($bodyContent, $navigationBar = NULL)
	{
		$html = "";
		$html .= "<html lang='$this->m_language'>";
		$html .= $this->GenerateHead();
		$html .= $navigationBar == NULL ? $this->GenerateBody($bodyContent) : $this->GenerateBody($bodyContent, $navigationBar);
		$html .= "</html>";
		
		return $html;
	}
}