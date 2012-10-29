<?php

namespace Model;

require_once ('model/DAL/UserDAL.php');

class AuthModel
{
	private $m_db = NULL;

	public function __construct(Database $db)
	{
		$this->m_db = $db;
	}

	public function IsRegistered($username)
	{
		$user = UserDAL::GetUserByUsername($username);
		if($user->GetUsername() == null)
		{
			return false;
		}
		else
		{
			throw new \Exception(\Common\String::USERNAME_EXISTS);
		}
	}

	/**
	 * Register a user into the database.
	 *
	 * @param $user, User Object
	 * @return $registerStatus, Boolean
	 */
	public function DoRegisterUser(User $user)
	{
		$registerStatus = true;
		$user->SetPassword(Krypter::Crypt($user->GetPassword()));
		if(!UserDAL::AddUser($user))
		{
			$registerStatus = false;			
		}

		return $registerStatus;
	}

	/**
	 * Any user logged in?
	 *
	 * @return BOOLEAN, True = logged in, False = not logged in
	 */
	public static function IsLoggedIn()
	{
		return isset($_SESSION[\Common\String::SESSION_LOGGEDIN]) ? true : false;
	}

	/**
	 * Logging in a user if password is right
	 *
	 * @param $tryUser String, posted username
	 * @param $tryPassword String, posted password
	 * @return Boolean, true = login success, false = login failed.
	 */
	public function DoLogin($tryUser, $tryPassword)
	{
		$acceptedUser = false;
		$user = UserDAL::GetUserByUsername($tryUser);
		if(isset($user))
		{
			if($user->GetPassword() == $tryPassword)
			{
				$_SESSION[\Common\String::SESSION_LOGGEDIN] = serialize($user);
				$acceptedUser = true;
			}
		}
		if(isset($acceptedUser))
		{
			if(!$acceptedUser)
			{
				throw new \Exception(\Common\String::WRONG_PASSWORD_OR_USERNAME);
			}
			return $acceptedUser;
		}
	}

	/**
	 * Logging out a user
	 */
	public function DoLogOut()
	{
		if(isset($_SESSION[\Common\String::SESSION_LOGGEDIN]))
		{
			unset($_SESSION[\Common\String::SESSION_LOGGEDIN]);
		}
	}

	public static function test(Database $db)
	{
		// Errormessages is saved in this array
		$errorMessages = array();
		$errorMessages[] = "Authentication Test";

		$sut = new AuthModel($db);
		$userDAL = new UserDAL($db);

		if($sut->IsLoggedIn())
		{
			$errorMessages[] = 'Something is wrong with the IsLoggedIn() function "When you shouldn\'t be logged in" (on line: ' . __LINE__ . ")";
		}

		// DoLogin fail user
		try
		{
			$sut->DoLogin("Fiskpinne", "Fläskpannkaka");
			// Test failed.
			$errorMessages[] = 'Something is wrong with the DoLogin("Fiskpinne", "Fläskpannkaka") function (on line: ' . __LINE__ . ")";
		}
		catch (\Exception $e)
		{
			// Test success
		}

		// DoLogin success user
		if(!($sut->DoLogin("Fisk", Krypter::Crypt("Fisk22"))))
		{
			$errorMessages[] = 'Something is wrong with the DoLogin("Fisk", "Fisk22") function (on line: ' . __LINE__ . ")";
		}

		// Should be logged in.
		if(!$sut->IsLoggedIn())
		{
			$errorMessages[] = 'Something is wrong with the IsLoggedIn() function "When you should be logged in (on line: ' . __LINE__ . ")";
		}

		// Logging out the inlogged test user.
		$sut->DoLogout();
		if($sut->isLoggedIn())
		{
			$errorMessages[] = 'Something is wrong with the DoLogout() function (on line: ' . __LINE__ . ")";
		}

		// DoLogin right username, fail password
		try
		{
			$sut->DoLogin("Fisk", "Fisken22");
			// Test failed.
			$errorMessages[] = 'Something is wrong with the DoLogin("Fisk", "Fisken22") function (on line: ' . __LINE__ . ")";
		}
		catch (\Exception $e)
		{
			// Test success.
		}

		// DoLogin fail username, right password
		try
		{
			$sut->DoLogin("Fisken", "Fisk22");
			// Test failed.
			$errorMessages[] = 'Something is wrong with the DoLogin("Fisken", "Fisk22") function (on line: ' . __LINE__ . ")";
		}
		catch (\Exception $e)
		{
			// Test success.
		}

		return $errorMessages;
	}

}
