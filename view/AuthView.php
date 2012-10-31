<?php

namespace View;

class AuthView
{
	private $m_username;
	private $m_password;
	private $m_errorMessages = array();
	private $m_validator;

	public function __construct()
	{
		$this->m_validator = new \Model\Validator();
	}

	public function SetErrorMessages()
	{
		foreach($this->m_validator->GetErrorMessages() as $errorMessage)
		{
			$this->AddErrorMessage($errorMessage);
		}
	}

	public function AddErrorMessage($error)
	{
		$this->m_errorMessages[] = $error;
	}

	public function GetErrorMessages()
	{
		return $this->m_errorMessages;
	}

	/**
	 * Check if the user tried to login
	 *
	 * @return boolean
	 */
	public function TriedToLogIn()
	{
		return isset($_POST[\Common\String::LOGIN_SUBMIT]);
	}

	/**
	 * Check if the user tried to logout
	 *
	 * @return boolean
	 */
	public function TriedToLogOut()
	{
		return isset($_POST[\Common\String::LOGOUT_SUBMIT]);
	}

	/**
	 * Remember me checkbox checked?
	 */
	public function TriedToRememberUser()
	{
		return isset($_POST[\Common\String::REMEMBER]);
	}

	/**
	 * Check if the user tried to register
	 *
	 * @return boolean
	 */
	public function TriedToRegister()
	{
		return isset($_POST[\Common\String::REGISTER_SUBMIT]);
	}

	/**
	 * Validate the fields in register form to a extern Validator
	 *
	 * @return boolean
	 */
	public function ValidateRegisterNewUser()
	{
		if($this->m_validator->AnyTags($this->GetUsername()) && $this->m_validator->AnyTags($this->GetEmail()))
		{
			$this->m_validator->ValidateUsername($this->GetUsername());
			$this->m_validator->ValidateEmail($this->GetEmail());
			$this->m_validator->ValidatePassword($this->GetRegisterPassword());
			$this->m_validator->ValidatePasswordMatch($this->GetRegisterPassword(), $this->GetRepeatPassword());
			$this->m_validator->ValidateSkill($this->GetSkill());
		}
		
		$this->setErrorMessages();

		if(count($this->GetErrorMessages()) != 0)
		{
			return false;
		}
		
		return true;
	}

	/**
	 * Get the username which was entered in the login form
	 *
	 * @return string, the entered username
	 */
	public function GetUsername()
	{
		return isset($_POST[\Common\String::USERNAME]) ? $_POST[\Common\String::USERNAME] : NULL;
	}

	/**
	 * Get the password which was entered in the login form
	 *
	 * @return string, the entered password
	 */
	public function GetPassword()
	{
		$password = "";
		if(isset($_COOKIE[\Common\String::COOKIE_USER]))
		{
			$password = $_POST[\Common\String::PASSWORD];
		}
		else
		{
			$password = \Model\Krypter::Crypt($_POST[\Common\String::PASSWORD]);
		}
		return $password;
	}

	/**
	 * Get the password that was entered to register
	 *
	 * @return string, emailadress
	 */
	public function GetRegisterPassword()
	{
		return isset($_POST[\Common\String::PASSWORD]) ? $_POST[\Common\String::PASSWORD] : NULL;
	}

	/**
	 * Get the repeated password that was entered to register
	 *
	 * @return string, emailadress
	 */
	public function GetRepeatPassword()
	{
		return isset($_POST[\Common\String::REPEAT_PASSWORD]) ? $_POST[\Common\String::REPEAT_PASSWORD] : NULL;
	}

	/**
	 * Get the email that was entered to register
	 *
	 * @return string, emailadress
	 */
	public function GetEmail()
	{
		return isset($_POST[\Common\String::EMAIL]) ? $_POST[\Common\String::EMAIL] : NULL;
	}

	/**
	 * Get the email that was entered to register
	 *
	 * @return string, emailadress
	 */
	public function GetSkill()
	{
		return isset($_POST[\Common\String::SKILL]) ? $_POST[\Common\String::SKILL] : NULL;
	}

	/**
	 * Set a cookie with the Username, Password.
	 */
	public function UserToRemember($user)
	{
		setcookie(\Common\String::COOKIE_USER, serialize($user), time() + \Common\String::COOKIE_LIFETIME);
	}

	/**
	 * Removes the cookie for Username, Password.
	 */
	public function ForgetUser()
	{
		setcookie(\Common\String::COOKIE_USER, "", time() - \Common\String::COOKIE_LIFETIME);
	}

	/**
	 * Make the login form
	 *
	 * @return $html, generated html code
	 */
	public function DoLogInForm()
	{
		$user = isset($_COOKIE[\Common\String::COOKIE_USER]) ? unserialize($_COOKIE[\Common\String::COOKIE_USER]) : "";

		// Check if there's a cookie if there's a cookie load the login form with data for Username, Password.
		$this->m_username = isset($_COOKIE[\Common\String::COOKIE_USER]) ? $user->GetUsername() : "";
		$this->m_password = isset($_COOKIE[\Common\String::COOKIE_USER]) ? $user->GetPassword() : "";

		$html = "
               <form method=\"post\">
                  <label for=\"" . \Common\String::USERNAME . "\">Användarnamn</label>
                  <input type=\"text\" id=\"" . \Common\String::USERNAME . "\" value=\"" . $this->m_username . "\" name=\"" . \Common\String::USERNAME . "\" />
                  <label for=\"" . \Common\String::PASSWORD . "\">Lösenord</label>
                  <input type=\"password\" id=\"" . \Common\String::PASSWORD . "\" value=\"" . $this->m_password . "\" name=\"" . \Common\String::PASSWORD . "\" />
                  <label for=\"" . \Common\String::REMEMBER . "\">Kom ihåg mig</label>
                  <input type=\"checkbox\"";
		// If there's a cookie check the checkbox
		if(isset($_COOKIE[\Common\String::COOKIE_USER]))
		{
			$html .= "checked=\"checked\"";
		}
		$html .= "
      												value=\"remember\" id=\"" . \Common\String::REMEMBER . "\" name=\"" . \Common\String::REMEMBER . "\" />
                  <input type=\"submit\" name=\"" . \Common\String::LOGIN_SUBMIT . "\" value=\"" . \Common\String::LOGIN_SUBMIT_TEXT . "\" />  
                  <p class=\"small\">Har du inget konto än så <a href=\"" . NavigationView::GetRegisterLink() . "\">Registrera dig</a></p>
               </form>
            ";
		return $html;
	}

	/**
	 * Write the AuthBox and information
	 *
	 * @return $html, generated html code
	 */
	public function DoAuthBox($user)
	{
		$html = "
					<div class=\"authBox\">
						<p>Välkommen <span>" . $user->GetUsername() . "</span></p>
						<p><a href=\"" . NavigationView::GetUserProfileLink($user->GetUserID()) . "\">" . \Common\String::MY_PROFILE_LINK . "</a>
						<p><a href=\"" . NavigationView::GetEditProfileLink($user->GetUserID()) . "\">" . \Common\String::EDIT_MY_PROFILE_LINK . "</a>
						<form method=\"post\">
							<input type=\"submit\" name=\"" . \Common\String::LOGOUT_SUBMIT . "\" value=\"" . \Common\String::LOGOUT_SUBMIT_TEXT . "\" />
						</form>
					</div>";
		return $html;
	}

	/**
	 * Register a new user form
	 *
	 * @return $html, generated html code
	 */
	public function DoRegisterForm()
	{
		$html = "
					<form method=\"post\">
						<label for=\"" . \Common\String::USERNAME . "\">Användarnamn</label>
						<input type=\"text\" id=\"" . \Common\String::USERNAME . "\" name=\"" . \Common\String::USERNAME . "\" />
						<label for=\"" . \Common\String::EMAIL . "\">Email</label>
						<input type=\"email\" id=\"" . \Common\String::EMAIL . "\" name=\"" . \Common\String::EMAIL . "\" />
						<label for=\"" . \Common\String::PASSWORD . "\">Lösenord</label>
						<input type=\"password\" id=\"" . \Common\String::PASSWORD . "\" name=\"" . \Common\String::PASSWORD . "\" />
						<label for=\"" . \Common\String::REPEAT_PASSWORD . "\">Lösenord igen</label>
						<input type=\"password\" id=\"" . \Common\String::REPEAT_PASSWORD . "\" name=\"" . \Common\String::REPEAT_PASSWORD . "\" />
						<label for=\"" . \Common\String::SKILL . "\">Kunskapsnivå</label>
						<select id=\"" . \Common\String::SKILL . "\" name=\"" . \Common\String::SKILL . "\" />";
		for($skill = \Common\String::SKILL_MIN; $skill <= \Common\String::SKILL_MAX; $skill++)
		{
			$html .= "<option value=\"$skill\">" . \Common\String::$skillText[$skill] . "</option>";
		}
		$html .= "
						</select><br />
						<input class=\"left\" type=\"submit\" name=\"" . \Common\String::REGISTER_SUBMIT . "\" value=\"" . \Common\String::REGISTER_SUBMIT_TEXT . "\" />
					</form>
				";
		return $html;
	}

	/**
	 * Do errorlist
	 *
	 * @param $errorMessages, string array
	 */
	public function DoErrorList($errorMessages)
	{
		foreach($errorMessages as $message)
		{
			\Common\Page::AddErrorMessage($message);
		}
	}

}
