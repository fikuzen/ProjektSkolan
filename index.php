<?php

// View
require_once('view/common/Page.php');
require_once('view/NavigationView.php');

// Model
require_once('model/database/Database.php');
require_once('model/database/DBSettings.php');

class MasterController 
{	
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
		
		// NavigationView
		$navView = new \View\NavigationView();
		
		if($navView->isAdminQuery())
		{
			$content = "Adminpanelen";
			$navigationBar = NULL;
		}
		else 
		{
			$content = "Start";
			$navigationBar = NULL;
		}
		
		$db->Close();
		
		return $page->GenerateHTML5Page($content, $navigationBar);
	}
}

echo MasterController::doControll();
