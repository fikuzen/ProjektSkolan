<?php

namespace Controller;

require_once('view/AdminView.php');
require_once('model/AdminModel.php');

class AdminController
{
	private $m_db;
	public function __construct(\Model\Database $db)
	{
		$this->m_db = $db;
	}
	
	public function DoControll()
	{		
		$adminModel = new \Model\AdminModel($this->m_db);
		$adminView = new \View\AdminView();
		
		$html = "";
		if (\Model\User::GetUserSession())
		{
			$user = \Model\User::GetUserSession();
			if($adminModel->IsAdmin($user))
			{
				\Common\Page::AddSuccessMessage(\Common\String::RIGHTS_ADMIN);
				$html = $adminView->DoStart();
			}
			else 
			{
				\Common\Page::AddErrorMessage(\Common\String::NORIGHTS_ADMIN);
			}
		}
		else 
		{
			\Common\Page::AddErrorMessage(\Common\String::NORIGHTS_ADMIN);
		}
		return $html;
	}
}