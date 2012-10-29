<?php

session_start();

// View
require_once('common/Page.php');
require_once('common/String.php');
require_once('view/NavigationView.php');
require_once('view/MasterView.php');

// Model
require_once('model/crypt/Krypter.php');
require_once('model/database/Database.php');
require_once('model/database/DBSettings.php');
require_once('model/object/User.php');
require_once('model/DAL/UserDAL.php');
require_once('model/DAL/RecipeDAL.php');
require_once('model/validate/Validator.php');
require_once('model/AuthModel.php');
require_once('model/UserModel.php');
require_once('model/AdminModel.php');

class TestController 
{
	private static $m_title = "Foodtime";	
	/**
	 * What happens in the application
	 */
	public static function DoTest() {
		
		// Page
		$page = new \Common\Page();
		$page->AddStylesheet('/frontend/css/style.css');
		$page->AddJavascript('//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js');
		$page->AddJavascript('/frontend/js/main.js');
		
      // testDatabase Settings
      // Feel free to update this ones
      $databaseDB = "foodtime_test";
      $databaseHost = "localhost";
      $databaseUser = "root";
      $databasePassword = "";
      
		// Database
		$dbSettings = new \Model\DBSettings($databaseDB, $databaseHost, $databaseUser, $databasePassword);
  		$testDB = new \Model\Database();
		$testDB->Connect($dbSettings);
		
		// Instances
		$navView = new \View\NavigationView();
		$masterView = new \View\MasterView();
      
		$bodyHeader = $masterView->DoHeader();
		$bodyNavigation = $navView->GetTestNavigation();
		
      
      $dbTest = \Model\Database::test($dbSettings);
      $bodyContentLeft = $masterView->DoTestResult($dbTest);
      
      $validateTest = \Model\Validator::test();
      $bodyContentLeft .= $masterView->DoTestResult($validateTest);
      
      $cryptTest = \Model\Krypter::test();
      $bodyContentLeft .= $masterView->DoTestResult($cryptTest);
      
      $userDALTest = \Model\UserDAL::test($testDB);
      $bodyContentLeft .= $masterView->DoTestResult($userDALTest);
		
		$recipeDALTest = \Model\RecipeDAL::test($testDB);
      $bodyContentLeft .= $masterView->DoTestResult($recipeDALTest);
      
		$loginTest = \Model\AuthModel::test($testDB);
		$bodyContentLeft .= $masterView->DoTestResult($loginTest);
		
		$userTest = \Model\UserModel::test($testDB);
		$bodyContentLeft .= $masterView->DoTestResult($userTest);
		
		$adminTest = \Model\AdminModel::test($testDB);
		$bodyContentLeft .= $masterView->DoTestResult($adminTest);
		
		$bodyFooter = $masterView->DoFooter();
		self::$m_title = $masterView->DoSiteTitle();
		$page->SetTitle(self::$m_title);
		
		$testDB->Close();
		
		return $page->GenerateHTML5Page($bodyHeader, $bodyAuth = "", $bodyNavigation, $bodyContentLeft, $bodyContentRight = "", $bodyFooter);
	}
}

echo TestController::DoTest();
