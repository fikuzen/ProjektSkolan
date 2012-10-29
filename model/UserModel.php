<?php

namespace Model;

require_once ('model/DAL/UserDAL.php');

class UserModel
{
	private $m_db = NULL;

	public function __construct(Database $db)
	{
		$this->m_db = $db;
	}
	
	/**
	 * Updates a user who's in the database.
	 *
	 * @param $user, User Object
	 * @param $userInSession, The user stored in session
	 * @return $updateStatus, Boolean
	 */
	public function DoUpdateUser(\Model\User $user, \Model\User $userInSession)
	{
		$updateStatus = true;
		
		$user->SetPassword(Krypter::Crypt($user->GetPassword()));
				
		// Check if the entered password is the same as the real password
		if($user->GetPassword() == $userInSession->GetPassword())
		{
			if(UserDAL::UpdateUserProfile($user))
			{
				// set the session to the $user with new values.
				$_SESSION[\Common\String::SESSION_LOGGEDIN] = serialize($user);
			}
			else
			{
				$updateStatus = false;
			}
		}
		else 
		{
			throw new \Exception(\Common\String::PASSWORD_MATCH_UPDATE_PROFILE);
		}

		return $updateStatus;
	}
	
	/**
	 * Delete a user who's in the database.
	 *
	 * @param $userID, user id
	 * @return $updateStatus, Boolean
	 */
	public function DoDeleteUser($userID)
	{
		$deleteStatus = true;
		
		if(UserDAL::DeleteUser($userID))
		{
			// set the session to the $user with new values.
			$_SESSION[\Common\String::SESSION_LOGGEDIN] = NULL;
		}
		else
		{
			$deleteStatus = false;
		}

		return $deleteStatus;
	}
	
	/**
	 * Get a user from the database
	 * 
	 * @param $userID, user id
	 * @return the user
	 */
	public function GetUserByID($userID)
	{
		$user = UserDAL::GetUserByID($userID);
		if($user)
		{
			return $user;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * Get a user from the database
	 * 
	 * @param $userID, user id
	 * @return the user
	 */
	public function GetUsers()
	{
		$users = UserDAL::GetAllUsers();
		if($users)
		{
			return $users;
		}
		else
		{
			return false;
		}
	}
	
	public static function test(Database $db)
	{
		// Errormessages is saved in this array
		$errorMessages = array();
		$errorMessages[] = "User Test";

		$sut = new UserModel($db);
		$userDAL = new UserDAL($db);
		
		return $errorMessages;
	}
}
