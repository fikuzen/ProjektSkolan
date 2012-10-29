<?php

namespace View;

class NavigationView
{
	private static $m_admin = "admin";
	private static $m_user = "user";
	private static $m_recipe = "recipe";
	private static $m_register = "register";
	private static $m_profile = "profile";
	
	CONST START = "index";
	CONST LISTNING = "list";
	CONST ADD = "add";
	CONST DELETE = "delete";
	CONST EDIT = "edit";
   
   private static $m_testURL = "/test.php";
	
	public static function IsAdminQuery() { return isset($_GET[self::$m_admin]); }
	public static function IsUserQuery() { return isset($_GET[self::$m_user]); }
	public static function IsRecipeQuery() { return isset($_GET[self::$m_recipe]); }
	public static function IsRegisterQuery() { return isset($_GET[self::$m_register]); }
	public static function IsProfileQuery() { return isset($_GET[self::$m_profile]); }
	
	public static function GetAdminQuery() { return $_GET[self::$m_admin]; }
	public static function GetUserQuery() { return $_GET[self::$m_user]; }
	public static function GetRecipeQuery() { return $_GET[self::$m_recipe]; }
	public static function GetRegisterQuery() { return $_GET[self::$m_register]; }
	public static function GetProfileQuery() { return $_GET[self::$m_profile]; }
   
   // Test URL
   public static function GetTestURL() { return self::$m_testURL; }
	
	// Start links
	public static function GetStartLink() { return "/"; }
	
	// Recipe Links
	public static function GetRecipeStartLink() { return "?" . self::$m_recipe . "=". self::START; }
	public static function GetRecipeListLink() { return "?" . self::$m_recipe . "=". self::LISTNING; }
	public static function GetRecipeAddLink() { return "?" . self::$m_recipe . "=". self::ADD; }
	public static function GetRecipeDeleteLink() { return "?" . self::$m_recipe . "=". self::DELETE; }
	public static function GetRecipeUpdateLink() { return "?" . self::$m_recipe . "=". self::EDIT; }
	public static function GetRecipeLink($recipeID) { return "?" . self::$m_recipe . "=" . $recipeID; }
	
	// User Links
	public static function GetUserStartLink() { return "?" . self::$m_user . "=". self::START; }
	public static function GetUserListLink() { return "?" . self::$m_user . "=". self::LISTNING; }
	public static function GetUserAddLink() { return "?" . self::$m_user . "=". self::ADD; }
	public static function GetUserDeleteLink() { return "?" . self::$m_user . "=". self::DELETE; }
	public static function GetUserUpdateLink() { return "?" . self::$m_user . "=". self::EDIT; }
	public static function GetUserProfileLink($userID) { return "?" . self::$m_user . "=" . $userID; }
	
	// Profile Links
	public static function GetEditProfileLink($userID) { return "?" . self::$m_profile . "=" . self::EDIT; }
	
	// Register Link
	public static function GetRegisterLink() { return "?" . self::$m_register . "=" . self::START; }
	
	// Admin Link
	public static function GetAdminStartLink() { return "?" . self::$m_admin . "=". self::START; }
	
	/**
	 * Navigation for index page 
	 *
	 * @return the navigation for index page
	 */
	public static function GetStartNavigation()
	{
		$navigation = "
							<ul>
								<li><a class=\"active\" href=" . self::GetStartLink() . ">Hem</a></li>
								<li><a href=" . self::GetRecipeStartLink() . ">Recept</a>
									<ul>
										<li><a href=" . self::GetRecipeListLink() . ">Lista recept</a></li>
									</ul>
								</li>
								<li><a href=" . self::GetUserStartLink() . ">Användare</a></li>
							</ul>
						";
		
		return $navigation;
	}
   
	/**
	 * Navigation for recipe page 
	 *
	 * @return the navigation for index page
	 */
	public static function GetRecipeNavigation()
	{
		$navigation = "
							<ul>
								<li><a href=" . self::GetStartLink() . ">Hem</a></li>
								<li><a class=\"active\"  href=" . self::GetRecipeStartLink() . ">Recept</a>
									<ul>
										<li><a href=" . self::GetRecipeListLink() . ">Lista recept</a></li>
									</ul>
								</li>
								<li><a href=" . self::GetUserStartLink() . ">Användare</a></li>
							</ul>
						";
		return $navigation;
	}
	
	/**
	 * Navigation for admin page 
	 *
	 * @return the navigation for admin page
	 */
	public static function GetAdminNavigation()
	{
		$navigation = "
							<ul>
								<li><a href=" . self::GetStartLink() . ">Hem</a></li>
								<li><a href=" . self::GetRecipeStartLink() . ">Recept</a>
									<ul>
										<li><a href=" . self::GetRecipeListLink() . ">Lista recept</a></li>
										<li><a href=" . self::GetRecipeAddLink() . ">Lägg till recept</a></li>
									</ul>
								</li>
								<li><a href=" . self::GetUserStartLink() . ">Användare</a>
									<ul>
										<li><a href=" . self::GetUserListLink() . ">Lista användare</a></li>
										<li><a href=" . self::GetUserAddLink() . ">Lägg till användare</a></li>
									</ul>
								</li>
								<li><a class=\"active\" href=" . self::GetAdminStartLink() . ">Admin</a></li>
							</ul>
						";
		return $navigation;
	}
	
	/**
	 * Navigation for user page 
	 *
	 * @return the navigation for index page
	 */
	public static function GetUserNavigation()
	{
		$navigation = "
							<ul>
								<li><a href=" . self::GetStartLink() . ">Hem</a></li>
								<li><a href=" . self::GetRecipeStartLink() . ">Recept</a>
									<ul>
										<li><a href=" . self::GetRecipeListLink() . ">Lista recept</a></li>
									</ul>
								</li>
								<li><a class=\"active\" href=" . self::GetUserStartLink() . ">Användare</a></li>
							</ul>
						";
		return $navigation;
	}
	
   /**
    * Navigation for test page 
    *
    * @return the navigation for test page
    */
   public static function GetTestNavigation()
   {
      $navigation = "
                     <ul>
                        <li><a href=" . self::GetStartLink() . ">Hem</a></li>
                     </ul>
                  ";
      return $navigation;
   }
}
