<?php

namespace Controller;

require_once('/view/AuthView.php');
require_once('/Model/AuthModel.php');

class AuthController
{
   public static $m_db;
   public function __construct(\Model\Database $db)
   {
      $this->m_db = $db;
   }
   
	public function doAuth()
	{
	   $authModel = new \Model\AuthModel($this->m_db);
      $authView = new \View\AuthView();
      
	   if ( $authModel->IsLoggedIn() )
      {
         $html = "Du är inloggad";
      }
      else 
      {
         $html = $authView->DoLogInForm();
      }
      return $html;
	}
}
