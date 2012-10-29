<?php

namespace Controller;

require_once ('view/UserView.php');
require_once ('model/UserModel.php');

class UserController
{
	private $m_db;
	public function __construct(\Model\Database $db)
	{
		$this->m_db = $db;
	}

	public function DoControll()
	{
		$userModel = new \Model\UserModel($this->m_db);
		$userView = new \View\UserView();
		$html = "";
		if(\View\NavigationView::IsProfileQuery())
		{
			if(\View\NavigationView::GetProfileQuery() == \View\NavigationView::EDIT)
			{
				$userInSession = \Model\User::GetUserSession();
				if(isset($userInSession))
				{
					$html = $userView->DoEditProfileForm($userInSession);
					if($userView->TriedToEditProfile())
					{
						if($userView->ValidateUpdateUser())
						{
							$userInfo = array(
								\Model\User::USERID => $userInSession->GetUserID(),
								\Model\User::USERNAME => $userInSession->GetUsername(),
								\Model\User::EMAIL => $userView->GetEmail(),
								\Model\User::PASSWORD => $userView->GetPassword(),
								\Model\User::SKILL => $userView->GetSkill()
							);
							$user = new \Model\User($userInfo);
							try
							{
								if($userModel->DoUpdateUser($user, $userInSession))
								{
									\Common\Page::AddSuccessMessage(\Common\String::UPDATE_PROFILE_SUCCESS);
								}
							}
							catch (\Exception $e)
							{
								\Common\Page::AddErrorMessage($e->getMessage());
							}
						}
						else
						{
							\Common\Page::AddErrorMessage($userView->DoErrorList($userView->getErrorMessages()));
						}
					}
					else if ($userView->TriedToDeleteProfile())
					{
						try
							{
								if($userModel->DoDeleteUser($userInSession->GetUserID()))
								{
									\Common\Page::AddSuccessMessage(\Common\String::DELETE_PROFILE_SUCCESS);
								}
							}
							catch (\Exception $e)
							{
								\Common\Page::AddErrorMessage($e->getMessage());
							}
					}
				}
				else
				{
					\Common\Page::AddErrormessage(\Common\String::NORIGHTS_EDIT_PROFILE);
				}
			}
		}
		else
		if(\View\NavigationView::IsUserQuery())
		{
			$html = "";
			if(\View\NavigationView::GetUserQuery() == \View\NavigationView::START)
			{
				$users = $userModel->GetUsers();
				if($users)
				{
					$html = $userView->DoUserList($users);
				}
				else
				{
					\Common\Page::AddErrormessage(\Common\String::FAIL_GET_USERS);					
				}
			}
			else 
			{
				$userID = $userView->GetUserID();
				$user = $userModel->GetUserByID($userID);
				if($user)
				{
					$html = $userView->DoUserProfile($user);
				}
				else
				{
					\Common\Page::AddErrormessage(\Common\String::FAIL_GET_USER_PROFILE);
				}
			}
		}
		return $html;
	}

}
