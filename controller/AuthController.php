<?php

namespace Controller;

require_once ('view/AuthView.php');
require_once ('model/AuthModel.php');

class AuthController
{
	private $m_db;
	private $m_userInSession;
	private $m_output = "";
	private $m_authView;
	private $m_authModel;
	public function __construct(\Model\Database $db)
	{
		$this->m_db = $db;
		$this->m_userInSession = \Model\User::GetUserSession();
		$this->m_authView = new \View\AuthView;
		$this->m_authModel = new \Model\AuthModel($db);
	}

	/**
	 * Do Authentication controll.
	 * Check if the user tried to login/logout. sets the user session if logged in successful,
	 * Check if the user wants to be recognized and then store a cookie with the user and the crypted password.
	 * @return $this->m_outout, the html generated code
	 */
	public function doAuthControll()
	{
		// Are you logged in?
		if($this->m_authModel->IsLoggedIn())
		{
			$this->m_output = $this->m_authView->DoAuthBox($this->m_userInSession);
		}
		// Are you not logged in?
		else
		{
			$this->m_output = $this->m_authView->DoLogInForm();
		}

		// Did the user try to login
		if($this->m_authView->TriedToLogIn())
		{
			$username = $this->m_authView->GetUsername();
			$password = $this->m_authView->GetPassword();
			// Try to login a user,
				if($this->m_authModel->DoLogin($username, $password))
				{
					$user = $this->m_authModel->GetUserByName($username);
					// Does the user want to save login Data
					if($this->m_authView->TriedToRememberUser())
					{
						// Which username / password should be saved
						$this->m_authView->UserToRemember($user);
					}
					// If the user doesn't want to be recognized
					else
					{
						// Delete the login Cookie
						$this->m_authView->ForgetUser();
					}
					$this->m_output = $this->m_authView->DoAuthBox($user);
				}
				else {
					\Common\Page::AddErrorMessage(\Common\String::WRONG_PASSWORD_OR_USERNAME);
					$this->m_output = $this->m_authView->DoLogInForm();
				}
				
		}
		// Did the user try to logout
		else if($this->m_authView->TriedToLogOut())
		{
			//logout the user
			$this->m_authModel->DoLogOut();

			$this->m_output = $this->m_authView->DoLogInForm();
		}
		return $this->m_output;
	}
}
