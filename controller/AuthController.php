<?php

namespace Controller;

require_once ('view/AuthView.php');
require_once ('model/AuthModel.php');

class AuthController
{
	private $m_db;
	public function __construct(\Model\Database $db)
	{
		$this->m_db = $db;
	}

	public function doAuthControll()
	{
		$authModel = new \Model\AuthModel($this->m_db);
		$authView = new \View\AuthView();

		$user = \Model\User::GetUserSession();

		// Are you logged in?
		if($authModel->IsLoggedIn())
		{
			$html = $authView->DoAuthBox($user);
		}
		// Are you not logged in?
		else
		{
			$html = $authView->DoLogInForm();
		}

		// Did the user try to login
		if($authView->TriedToLogIn())
		{
			$username = $authView->GetUsername();
			$password = $authView->GetPassword();

			try
			{
				if($authModel->DoLogin($username, $password))
				{
					//TODO: Fix so u can login with a cookie set but with normal password
					$user = \Model\UserDAL::GetUserByUsername($username);
					// Does the user want to save login Data
					if($authView->TriedToRememberUser())
					{
						// Which username / password should be saved
						$authView->UserToRemember($user);
					}
					// If the user doesn't want to be recognized
					else
					{
						// Delete the login Cookie
						$authView->ForgetUser();
					}
					$html = $authView->DoAuthBox($user);
				}
			}
			catch (\Exception $e)
			{
				\Common\Page::AddErrorMessage($e->getMessage());
				$html = $authView->DoLogInForm();
			}
		}
		// Did the user try to logout
		else
		if($authView->TriedToLogOut())
		{
			$authModel->DoLogOut();

			$html = $authView->DoLogInForm();
		}
		return $html;
	}

	public function DoRegisterControll()
	{
		$authModel = new \Model\AuthModel($this->m_db);
		$authView = new \View\AuthView();

		$html = $authView->DoRegisterForm();

		if($authView->TriedToRegister())
		{
			if($authView->ValidateRegisterNewUser())
			{
				try
				{
					if($authModel->IsRegistered($authView->getUsername()) == false)
					{
						$userInfo = array(
							\Model\User::USERNAME => $authView->GetUsername(),
							\Model\User::EMAIL => $authView->GetEmail(),
							\Model\User::PASSWORD => $authView->GetRegisterPassword(),
							\Model\User::SKILL => $authView->GetSkill()
						);
						$user = new \Model\User($userInfo);
						if($authModel->DoRegisterUser($user))
						{
							\Common\Page::AddSuccessMessage(\Common\String::REGISTER_SUCCESS);
						}
					}
				}
				catch (\Exception $e)
				{
					$authView->AddErrorMessage($e->getMessage());
					\Common\Page::AddErrorMessage($authView->DoErrorList($authView->getErrorMessages()));
				}
			}
			else
			{
				\Common\Page::AddErrorMessage($authView->DoErrorList($authView->getErrorMessages()));
			}
		}
		return $html;
	}

}
