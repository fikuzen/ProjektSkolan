<?php

namespace Model;

class User
{
	private $m_user;

	// User variables
	CONST USERID = "UserID";
	CONST USERNAME = "Username";
	CONST PASSWORD = "Password";
	CONST EMAIL = "Email";
	CONST SKILL = "Skill";
	CONST UPDATED = "UpdatedAt";
	CONST ISADMIN = "IsAdmin";

	public function __construct($userInfo)
	{
		if(isset($userInfo[self::USERID]))
		{
			$this->SetUserID($userInfo[self::USERID]);
		}
		else
		{
			$this->SetUserID(-1);
		}
		$this->SetUsername($userInfo[self::USERNAME]);
		$this->SetPassword($userInfo[self::PASSWORD]);
		$this->SetEmail($userInfo[self::EMAIL]);
		$this->SetSkill($userInfo[self::SKILL]);
		if(isset($userInfo[self::UPDATED]))
		{
			$this->SetUpdated($userInfo[self::UPDATED]);
		}
		else
		{
			$this->SetUpdated(-1);
		}
		if(isset($userInfo[self::ISADMIN]))
		{
			$this->SetIsAdmin($userInfo[self::ISADMIN]);
		}
		else
		{
			$this->SetIsAdmin(-1);
		}
	}

	// Getters
	public function GetUserID()
	{
		return $this->m_user[self::USERID];
	}

	public function GetUsername()
	{
		return $this->m_user[self::USERNAME];
	}

	public function GetPassword()
	{
		return $this->m_user[self::PASSWORD];
	}

	public function GetEmail()
	{
		return $this->m_user[self::EMAIL];
	}

	public function GetSkill()
	{
		return $this->m_user[self::SKILL];
	}

	public function GetUpdated()
	{
		return $this->m_user[self::UPDATED];
	}

	public function GetIsAdmin()
	{
		return $this->m_user[self::ISADMIN];
	}

	// Setters
	public function SetUserID($userID)
	{
		$this->m_user[self::USERID] = $userID;
	}

	public function SetUsername($username)
	{
		$this->m_user[self::USERNAME] = $username;
	}

	public function SetPassword($password)
	{
		$this->m_user[self::PASSWORD] = $password;
	}

	public function SetEmail($email)
	{
		$this->m_user[self::EMAIL] = $email;
	}

	public function SetSkill($skill)
	{
		$this->m_user[self::SKILL] = $skill;
	}

	public function SetUpdated($updated)
	{
		$this->m_user[self::UPDATED] = $updated;
	}

	public function SetIsAdmin($isAdmin)
	{
		$this->m_user[self::ISADMIN] = $isAdmin;
	}
	
	/**
	 * Get the the user stored in the session
	 *
	 * @return $user, the user.
	 */
	public static function GetUserSession()
	{
		return isset($_SESSION[\Common\String::SESSION_LOGGEDIN]) ? unserialize($_SESSION[\Common\String::SESSION_LOGGEDIN]) : NULL;
	}

}
