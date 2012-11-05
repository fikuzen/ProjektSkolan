<?php

namespace Controller;

require_once('view/UserView.php');
require_once('model/UserModel.php');
require_once('view/NavigationView.php');
require_once('model/object/User.php');

class UserController
{
	// member variables
	private $m_output = "";
	private $m_userView;
	private $m_userModel;
	private $m_userInSession;
	
	public function __construct(\Model\Database $db)
	{
		$this->m_userView = new \View\UserView();
		$this->m_userModel = new \Model\UserModel($db);
		$this->m_userInSession = \Model\User::GetUserSession();
	}

	/**
	 * @return $this->m_output 
	 */
	public function DoControll()
	{
		/**
		 * If the user query is active will it show a list of all users or a userprofile of any member. 
		 */
		if(\View\NavigationView::IsUserQuery())
		{
			// query = start.. list all members
			if(\View\NavigationView::GetUserQuery() == \View\NavigationView::START)
			{
				$this->DoStartUserControll();
			}
			else if(\View\NavigationView::GetUserQuery() == \View\NavigationView::DELETE)
			{
				if(isset($this->m_userInSession))
					$this->DoDeleteUserControll();
				else
					\Common\Page::AddErrorMessage(\Common\String::NOT_LOGGED_IN);
			}
			// If user is editing profile
			else if(\View\NavigationView::GetUserQuery() == \View\NavigationView::EDIT)
			{
				if(isset($this->m_userInSession))
					$this->DoUpdateUserControll();
				else
					\Common\Page::AddErrorMessage(\Common\String::NOT_LOGGED_IN);
			}
			// query = something else.. detailed user view.
			else 
			{
				$this->DoShowUserControll();
			}
		}
		return $this->m_output;
	}
	
	/**
	 * Do the controll if the user is @ user startpage
	 * set the output to a userlist.
	 */
	public function DoStartUserControll()
	{
		$users = $this->m_userModel->GetUsers();
		// if there's users.
		if($users)
		{
			$this->m_output = $this->m_userView->DoUserList($users);
		}
		// if there's no users
		else
		{
			\Common\Page::AddErrormessage(\Common\String::FAIL_GET_USERS);					
		}
	}
	
	/**
	 * Show the detailed profile page
	 * set the output to a detailed profile view.
	 */
	public function DoShowUserControll()
	{
		$userID = $this->m_userView->GetUserID();
		$user = $this->m_userModel->GetUserByID($userID);
		// if the value is right show the detailed user.
		if($user)
		{
			$this->m_output = $this->m_userView->DoUserProfile($user);
		}
		// if the value is strange there's no user to show..
		else
		{
			\Common\Page::AddErrormessage(\Common\String::FAIL_GET_USER_PROFILE);
		}
	}

	/**
	 * Do this controll if the user wants to update his/her profile
	 * set the output to a updateuserform
	 */
	public function DoUpdateUserControll()
	{
		$this->m_output = $this->m_userView->DoEditProfileForm($this->m_userInSession);
		if($this->m_userView->TriedToEditProfile())
		{
			if($this->m_userView->ValidateUpdateUser())
			{
				// get the nessecary userInformation that's needed to update a user and creates the user object
				$userInfo = $this->m_userView->GetUserInformationToUpdate($this->m_userInSession);							
				$user = new \Model\User($userInfo);
				
				try
				{
					if($this->m_userModel->DoUpdateUser($user, $this->m_userInSession))
					{
						\View\NavigationView::RedirectUser(\View\NavigationView::GetUserProfileLink($user->GetUserID()), \Common\String::UPDATE_PROFILE_SUCCESS);
					}
				}
				// error in the update process.
				catch (\Exception $e)
				{
					\Common\Page::AddErrorMessage($e->getMessage());
				}
			}
			// validate errors.
			else
			{
				\Common\Page::AddErrorMessage($this->m_userView->DoErrorList($this->m_userView->GetErrorMessages()));
			}
		}
	}

	public function DoDeleteUserControll()
	{
		$this->m_output = $this->m_userView->DoDeleteUserForm();
		
		if($this->m_userView->TriedToDeleteUser())
		{
			// try to delete user
			try
			{
				if($this->m_userModel->DoDeleteUser($this->m_userInSession->GetUserID()))
				{
					\Common\Page::AddSuccessMessage(\Common\String::DELETE_PROFILE_SUCCESS);
				}
			}
			// Erorr in the delete process.
			catch (\Exception $e)
			{
				\Common\Page::AddErrorMessage($e->getMessage());
			}
		}
	}

	/**
	 * Register user controll
	 * Check if the user tries to register and validates the user...
	 * If there's any field written with bad values is a errormessages showed to the user.
	 * If the register is completed the user get informed with a success message.
	 */
	public function DoRegisterControll()
	{
		$this->m_output = $this->m_userView->DoRegisterForm();
		
		if($this->m_userView->TriedToRegister())
		{
			if($this->m_userView->ValidateRegisterNewUser())
			{
				// if there's already a user registed with the username
				if($this->m_userModel->IsRegistered($this->m_userView->GetUsername()) == false)
				{
					// get the nessecary userInformation that's needed to register a user and creates the user object
					$userInfo = $this->m_userView->GetUserInformtionToRegister();
					$user = new \Model\User($userInfo);
					
					if($this->m_userModel->DoRegisterUser($user))
					{
						$userToStoreInSession = $this->m_userModel->GetUserByUsername($user->GetUsername());
						\Model\User::SetUserSession($userToStoreInSession);
						\View\NavigationView::RedirectUser(\View\NavigationView::GetUserStartLink());
						\Common\Page::AddSuccessMessage(\Common\String::REGISTER_SUCCESS);
					}
				}
				// If the username was taken
				else
				{
					\Common\Page::AddErrorMessage(\Common\String::USERNAME_EXISTS);
				}
			}
			// If there's any validation error we show it.
			else
			{
				\Common\Page::AddErrorMessage($this->m_userView->DoErrorList($this->m_userView->GetErrorMessages()));
			}
		}
		return $this->m_output;
	}


}
