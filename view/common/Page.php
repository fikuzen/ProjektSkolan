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
	 * @param $language, string language
	 * @param $charset, string encoding
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
	public function GenerateBody($bodyContent)
	{
		$body = "
					<body>
						<div class='wrapper'>
							$bodyContent
						</div>
				";
		foreach ($this->m_scripts as $script)
		{
			$body .= $script;
		}
		$body .= "</body>";
		
		return $body;
	}
	
	/**
	 * Generate the title of the page in a h1 tagg.
	 * 
	 * @param $bodyHeader, the title
	 * @return string, htmlcode
	 */
	public function GenerateHeader($bodyHeader)
	{
		$body = "
				<body>
					<div id=\"wrapper\">
						<div id=\"headerLogin\" class=\"container_12\">
							<div id=\"header\" class=\"grid_8\">
								<h1>$bodyHeader</h1>
							</div>
				";
		return $body;
	}
	
	/**
	 * Generate the Auth section of the page, can be a login form or if logged in the user information
	 * 
	 * @param $bodyAuth, the auth context
	 * @return string, htmlcode
	 */
	public function GenerateAuth($bodyAuth)
	{
		$body = "
							<div id=\"logIn\" class=\"grid_4\">
								$bodyAuth
							</div>
						</div>
				";
		return $body;
	}
	
	/**
	 * Generate the main navigation bar, should be an ul list
	 * 
	 * @param $bodyNavigation, the main navigation context
	 * @return string, htmlcode
	 */
	public function GenerateNavigation($bodyNavigation)
	{
		$body = "
						<div id=\"navigation\" class=\"container_12\">
							$bodyNavigation
						</div>
				";
		return $body;
	}
	
	/**
	 * Generate the context for the left column
	 * 
	 * @param $bodyContentLeft, the main contents context
	 * @return string, htmlcode
	 */
	public function GenerateBodyLeft($bodyContentLeft)
	{
		$body = "
						<div id=\"mainContent\" class=\"container_12\">
							<div id=\"content\" class=\"grid_8\">
								$bodyContentLeft
							</div>
				";
		return $body;
	}
	
	/**
	 * Generate the context for the right column
	 * 
	 * @param $bodyContentRight, the main contents sidebar
	 * @return string, htmlcode
	 */
	public function GenerateBodyRight($bodyContentRight)
	{
		$body = "
							<div id=\"sidebar\" class=\"grid_4\">
								$bodyContentRight
							</div>
						</div>
				";
		return $body;
	}
	
	/**
	 * Generate the footer
	 * 
	 * @param $bodyFooter, should be a p with the footer contect
	 * @return string, htmlcode
	 */
	public function GenerateBodyFooter($bodyFooter)
	{
		$body = "
						<div id=\"footer\" class=\"container_12\">
							$bodyFooter
						</div>
					</div>
				</body>
				";
		return $body;
	}
	
	/**
	 * The HTML5 Page
	 *
	 * @param $bodyHeader, the language, default SV
	 * @param $bodyLogIn, the content
	 * @param $bodyNavigation, the navigation bar, default NULL
	 * @param $bodyContentLeft, the navigation bar, default NULL
	 * @param $bodyContentRight, the navigation bar, default NULL
	 * @param $bodyFooter, the navigation bar, default NULL
	 * @return $html, a html generated page.
	 */
	public function GenerateHTML5Page($bodyHeader = "", $bodyAuth = "", $bodyNavigation = "", $bodyContentLeft = "", $bodyContentRight = "", $bodyFooter = "")
	{
		$html = "";
		$html .= "<html lang='$this->m_language'>";
		$html .= $this->GenerateHead();
		$html .= $this->GenerateHeader($bodyHeader);
		$html .= $this->GenerateAuth($bodyAuth);
		$html .= $this->GenerateNavigation($bodyNavigation);
		$html .= $this->GenerateBodyLeft($bodyContentLeft);
		$html .= $this->GenerateBodyRight($bodyContentRight);
		$html .= $this->GenerateBodyFooter($bodyFooter);
		$html .= "</html>";
		
		return $html;
	}
}