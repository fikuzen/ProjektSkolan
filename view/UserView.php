<?php

namespace View;

class UserView
{
	private $m_errorMessages = array();
	private $m_validator;
	
	public function __construct()
	{
		$this->m_validator = new \Model\Validator();
	}
	
	/**
	 * Sets the errormessages array with the validator errorMessages
	 * 
	 */
	public function SetErrorMessages()
	{
		foreach($this->m_validator->GetErrorMessages() as $errorMessage)
		{
			$this->m_errorMessages[] = $errorMessage;
		}
	}

	/**
	 * Get the errormessages array
	 * 
	 * @return array string
	 */
	public function GetErrorMessages()
	{
		return $this->m_errorMessages;
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
	
	public function GetUserID()
	{
		return NavigationView::IsUserQuery() ? NavigationView::GetUserQuery() : NULL;
	}
	
	/**
	 * Get the email that was entered to update the information
	 *
	 * @return string, emailadress
	 */
	public function GetEmail()
	{
		return isset($_POST[\Common\String::EMAIL]) ? $_POST[\Common\String::EMAIL] : NULL;
	}
	
	/**
	 * Get the email that was entered to update the information
	 *
	 * @return string, password
	 */
	public function GetPassword()
	{
		return isset($_POST[\Common\String::PASSWORD]) ? $_POST[\Common\String::PASSWORD] : NULL;
	}

	/**
	 * Get the repeated password that was entered to register
	 *
	 * @return string, repeatedPassword
	 */
	public function GetRepeatPassword()
	{
		return isset($_POST[\Common\String::REPEAT_PASSWORD]) ? $_POST[\Common\String::REPEAT_PASSWORD] : NULL;
	}

	/**
	 * Get the email that was entered to update the information
	 *
	 * @return string, emailadress
	 */
	public function GetSkill()
	{
		return isset($_POST[\Common\String::SKILL]) ? $_POST[\Common\String::SKILL] : NULL;
	}
	
	/**
	 * Get all the information to reigster a user
	 * 
	 * @return Array Userinfo
	 */
	public function GetUserInformtionToRegister()
	{
		return array(
			\Model\User::USERNAME => $this->GetUsername(),
			\Model\User::EMAIL => $this->GetEmail(),
			\Model\User::PASSWORD => $this->GetPassword(),
			\Model\User::SKILL => $this->GetSkill()
		);
	}

	/**
	 * Get all the information to update a user
	 * 
	 * @return Array Userinfo
	 */	
	public function GetUserInformationToUpdate($user)
	{
		return array(
			\Model\User::USERID => $user->GetUserID(),
			\Model\User::USERNAME => $user->GetUsername(),
			\Model\User::EMAIL => $this->GetEmail(),
			\Model\User::PASSWORD => $this->GetPassword(),
			\Model\User::SKILL => $this->GetSkill()
		);
	}
	
	/**
	 * Check if the user tried to update his/her profile
	 *
	 * @return boolean
	 */
	public function TriedToEditProfile()
	{
		return isset($_POST[\Common\String::EDIT_PROFILE_SUBMIT]);
	}
	
	/**
	 * Check if the user tried to delete his/her profile
	 *
	 * @return boolean
	 */
	public function TriedToDeleteUser()
	{
		return isset($_POST[\Common\String::DELETE_PROFILE_SUBMIT]);
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
	public function ValidateUpdateUser()
	{
		$this->m_validator->ValidateEmail($this->GetEmail());
		$this->m_validator->ValidateSkill($this->GetSkill());
		
		$this->SetErrorMessages();
		
		if(count($this->GetErrorMessages()) != 0) {
			return false;
		}
		return true;
	}
	
	/**
	 * Validate the fields in register form to the Validator
	 *
	 * @return boolean
	 */
	public function ValidateRegisterNewUser()
	{
		if($this->m_validator->AnyTags($this->GetUsername()) && $this->m_validator->AnyTags($this->GetEmail()))
		{
			$this->m_validator->ValidateUsername($this->GetUsername());
			$this->m_validator->ValidateEmail($this->GetEmail());
			$this->m_validator->ValidatePassword($this->GetPassword());
			$this->m_validator->ValidatePasswordMatch($this->GetPassword(), $this->GetRepeatPassword());
			$this->m_validator->ValidateSkill($this->GetSkill());
		}
		
		$this->SetErrorMessages();

		if(count($this->GetErrorMessages()) != 0)
			return false;
		
		return true;
	}
	
	/**
	 * Edit a user form
	 *
	 * @return $html, generated html code
	 */
	public function DoEditProfileForm(\Model\User $user)
	{
		$html = "
			<form class=\"editProfile\" method=\"post\">
				<h3>" . $user->GetUsername() . "</h3>
				<label for=\"" . \Common\String::EMAIL . "\">Email</label>
				<input type=\"email\" id=\"" . \Common\String::EMAIL . "\" name=\"" . \Common\String::EMAIL . "\" value=\"" . $user->GetEmail() . "\" />
				<label for=\"" . \Common\String::SKILL . "\">Kunskapsnivå</label>
				<select id=\"" . \Common\String::SKILL . "\" name=\"" . \Common\String::SKILL . "\" />";
		for($skill = \Common\String::SKILL_MIN; $skill <= \Common\String::SKILL_MAX; $skill++)
		{
			if($user->GetSkill() == $skill)
				$html .= "<option selected=\"selected\" value=\"$skill\">" . \Common\String::$skillText[$skill] . "</option>";
			else
				$html .= "<option value=\"$skill\">" . \Common\String::$skillText[$skill] . "</option>";
		}
		$html .= "
				</select>
				<label for=\"" . \Common\String::PASSWORD . "\">Lösenord</label>
				<input type=\"password\" id=\"" . \Common\String::PASSWORD . "\" name=\"" . \Common\String::PASSWORD . "\" /><br />
				<input class=\"left\" type=\"submit\" name=\"" . \Common\String::EDIT_PROFILE_SUBMIT . "\" value=\"" . \Common\String::EDIT_PROFILE_SUBMIT_TEXT . "\" />
			</form>
			<a href=\"" . \View\NavigationView::GetUserDeleteLink() . "\"><button class=\"left secondButton\">Avregistrera mig</button></a>
		";
		return $html;
	}

	/**
	 * Delete a user form
	 * 
	 * @return String, generated html code. 
	 */
	public function DoDeleteUserForm()
	{
		$html = "
			<p>" . \Common\String::DELETE_PROFILE_TEXT . "</p>
			<form method=\"post\">
				<input type=\"submit\" class=\"left\" name=\"" . \Common\String::DELETE_PROFILE_SUBMIT . "\" value=\"" . \Common\String::DELETE_PROFILE_SUBMIT_TEXT . "\" />
			</form>
		";
		return $html;
	}

	/**
	 * User profile
	 *
	 * @return $html, generated html code
	 */
	public function DoUserProfile(\Model\User $user)
	{
		$html = "
			<h2>" . $user->GetUsername() . "</h2>
			<dl>
				<dt>Mailadress</dt>
				<dd>" . $user->GetEmail() . "</dd>
				<dt>Kunskapsnivå för matlagning är</dt>
					<dd><meter value=\"" . $user->GetSkill() . "\" min=\"0\" max=\"5\">/meter></dd>
			</dl>
		";
		return $html;
	}
	
	/**
	 * List all users
	 *
	 * @return $html, generated html code
	 */
	public function DoUserlist($users)
	{
		$html = "
			<ul>";
		foreach ($users as $user) {
			$html .= "<li><a class=\"userLink\" href=\"" . NavigationView::GetUserProfileLink($user->GetUserID()) . "\">" . $user->GetUsername() . "</a></li>";	
		}
		$html .= "
			</ul>
		";
		return $html;
	}
	
	/**
	 * Register a new user form
	 *
	 * @return $html, generated html code
	 */
	public function DoRegisterForm()
	{
		$usernameValue = $this->GetUsername() == null ? "" : $this->GetUsername();
		$emailValue = $this->GetEmail() == null ? "" : $this->GetEmail();
		
		$html = "
					<form method=\"post\">
						<label for=\"" . \Common\String::USERNAME . "\">" . \Common\String::USERNAME_TEXT . "</label>
						<input type=\"text\" id=\"" . \Common\String::USERNAME . "\" value=\"$usernameValue\" name=\"" . \Common\String::USERNAME . "\" />
						<label for=\"" . \Common\String::EMAIL . "\">" . \Common\String::EMAIL_TEXT . "</label>
						<input type=\"email\" id=\"" . \Common\String::EMAIL . "\" value=\"$emailValue\" name=\"" . \Common\String::EMAIL . "\" />
						<label for=\"" . \Common\String::PASSWORD . "\">" . \Common\String::PASSWORD_TEXT . "</label>
						<input type=\"password\" id=\"" . \Common\String::PASSWORD . "\" name=\"" . \Common\String::PASSWORD . "\" />
						<label for=\"" . \Common\String::REPEAT_PASSWORD . "\">" . \Common\String::PASSWORD_REPEAT_TEXT . "</label>
						<input type=\"password\" id=\"" . \Common\String::REPEAT_PASSWORD . "\" name=\"" . \Common\String::REPEAT_PASSWORD . "\" />
						<label for=\"" . \Common\String::SKILL . "\">" . \Common\String::SKILL_TEXT . "</label>
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
		foreach ($errorMessages as $message ) {
			\Common\Page::AddErrorMessage($message);
		}
	}
}
