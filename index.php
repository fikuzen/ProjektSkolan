<?php

session_start();

// View
require_once('view/common/Page.php');
require_once('view/NavigationView.php');
require_once('view/MasterView.php');

// Model
require_once('model/database/Database.php');
require_once('model/database/DBSettings.php');

// Controller
require_once('controller/IController.php');
require_once('controller/AdminController.php');
require_once('controller/AuthController.php');
require_once('controller/RecipeController.php');
require_once('controller/UserController.php');

class MasterController 
{
	private static $m_title = "Foodtime";	
	/**
	 * What happens in the application
	 */
	public static function doControll() {
		
		// Page
		$page = new \View\Page();
		$page->AddStylesheet('/frontend/css/style.css');
		$page->AddJavascript('//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js');
		$page->AddJavascript('/frontend/js/main.js');
		
		// Database
		$dbSettings = new \Model\DBSettings();
  		$db = new \Model\Database();
		$db->Connect($dbSettings);
		
		// Instances
		$navView = new \View\NavigationView();
		$masterView = new \View\MasterView();
		$authController = new \Controller\AuthController($db);
		
		if($navView->isAdminQuery())
		{
			$adminController = new \Controller\AdminController();
			$html = $adminController->DoControll();
			$page->SetTitle("Foodtime - Adminpanelen");
		}
		else if($navView->isUserQuery())
		{
			$html = $userController->DoControll();
			$page->SetTitle("Foodtime - Användarprofil");
		}
		else 
		{
			$bodyHeader = $masterView->DoHeader();
			$bodyAuth = $authController->DoAuth();
			$bodyNavigation = $navView->GetStartNavigation();
			
			//TODO: fix content in start view.
			$bodyContentLeft = "Hej";
			$bodyContentRight = "Hej";
			
			$bodyFooter = $masterView->DoFooter();
			self::$m_title = $masterView->DoSiteTitle();
			$page->SetTitle(self::$m_title);
		}
		
		$db->Close();
		
		return $page->GenerateHTML5Page($bodyHeader, $bodyAuth, $bodyNavigation, $bodyContentLeft, $bodyContentRight, $bodyFooter);
	}
}

echo MasterController::doControll();
