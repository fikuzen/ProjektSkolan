<?php

namespace View;

class MasterView
{
	public function DoSiteTitle()
	{
	   if($_SERVER['REQUEST_URI'] == NavigationView::GetTestURL())
      {
         $title = "Foodtime - Enhetstest";
      }
		else if(NavigationView::IsAdminQuery())
      {
         $title = "Foodtime - Adminpanel";
      }
		else if(NavigationView::IsRecipeQuery())
      {
         $title = "Foodtime - Recept";
      }
		else if(NavigationView::IsUserQuery())
      {
         $title = "Foodtime - Användare";
      }
      else
      {
         $title = "Foodtime - Start";  
      }
		return $title;
	}
	
	public function DoHeader() 
	{
	   if($_SERVER['REQUEST_URI'] == NavigationView::GetTestURL())
      {
         $html = "Foodtime test";
      }
      else
      {
         $html = "Foodtime";  
      }
		
		return $html;
	}
   
   public function DoTestResult($testResult)
   {
      if(count($testResult) == 1)
      {
         $html = "<h2 class=\"success\">" . $testResult[0] . " lyckades</h2>";
         $html .= "<hr />";
      }
      else
      {
         $html = "<h2 class=\"error\">" . $testResult[0] . " misslyckades</h2>";
         $html .= "<ul class='errorList'>";
         // Add every error to the html
         for ($i = 1; $i < count($testResult); $i++) {
            $html .= "<li>" . $testResult[$i] . "</li>";
         }
         $html .= "</ul>";
         $html .= "<hr />";
      }
      return $html;
   }
	
	public function DoMainContent()
	{
		$html = "MainContent";
		return $html;
	}
	
	public function DoSidebar()
	{
		$html = "Sidebar";
		return $html;
	}
	
	public function DoFooter()
	{
		$user = \Model\User::GetUserSession();
		$isAdmin = false;
		if(isset($user))
		{
			$isAdmin = ($user->GetIsAdmin() === \Common\String::IS_ADMIN) ? true : false;
		}
		
		if($isAdmin)
		{
			$html = "&copy; Copyright Christoffer Rydberg 2012, WE USE COOKIES. <a href=\"" . NavigationView::GetAdminStartLink() . "\">Adminpanel</a>";
		}
		else
		{
			$html = "&copy; Copyright Christoffer Rydberg 2012, WE USE COOKIES";
		}
		return $html;
	}
}
