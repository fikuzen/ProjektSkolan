<?php

namespace View;

class NavigationView
{
	private static $m_admin = "admin";
	private static $m_user = "user";
	private static $m_recipe = "recipe";
	
	private static $m_recipeStart = "index";
	private static $m_recipeList = "list";
	
	private static $m_userStart = "index";
	
	public function IsAdminQuery() { return isset($_GET[self::$m_admin]); }
	public function IsUserQuery() { return isset($_GET[self::$m_user]); }
	public function IsRecipeQuery() { return isset($_GET[self::$m_recipe]); }
	
	// Start links
	public static function GetStartLink() { return "/"; }
	
	// Recipe Links
	public static function GetRecipeStartLink() { return "?" . self::$m_recipe . "=". self::$m_recipeStart; }
	public static function GetRecipeListLink() { return "?" . self::$m_recipe . "=". self::$m_recipeList; }
	
	// User Links
	public static function GetUserStartLink() { return "?" . self::$m_user . "=". self::$m_userStart; }
	
	/**
	 * Navigation for index page 
	 *
	 * @return the navigation for index page
	 */
	public function GetStartNavigation()
	{
		$navigation = "
							<ul>
								<li><a href=" . $this->GetStartLink() . ">Hem</a></li>
								<li><a href=" . $this->GetRecipeStartLink() . ">Recept</a>
									<ul>
										<li><a href=" . $this->GetRecipeListLink() . ">Lista recept</a></li>
									</ul>
								</li>
								<li><a href=" . $this->GetUserStartLink() . ">Användare</a></li>
							</ul>
						";
		return $navigation;
	}
}
