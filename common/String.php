<?php

namespace Common;

class String
{
	// Sessions & Cookies
	const SESSION_LOGGEDIN = "loggedin";
	const COOKIE_USER = "cookie_user";
	const COOKIE_LIFETIME = "1800";
	
	// User
	const USERNAME = "username";
	const EMAIL = "email";
	const PASSWORD = "password";
	const REPEAT_PASSWORD = "repeatPassword";
	const REMEMBER = "remember";
	const SKILL = "skill";
	
		const SKILL_MAX = "5";
		const SKILL_MIN = "1";
	const IS_ADMIN = 1;
	const IS_NOT_ADMIN = 0;
	
	// Recipe
	const RECIPE_NAME = "recipeName";
	const RECIPE_INGREDIENT = "recipeIngredient";
	const RECIPE_DESCRIPTION = "recipeDescription";
	const RECIPE_SEVERITY = "severity";
		const SEVERITY_MIN = 1;
		const SEVERITY_MAX = 5;
	
	// Submits
	const LOGIN_SUBMIT = "logInSubmit";
	const LOGOUT_SUBMIT = "logOutSubmit";
	const REGISTER_SUBMIT = "registerSubmit";
	const EDIT_PROFILE_SUBMIT = "editProfileSubmit";
	const DELETE_PROFILE_SUBMIT = "deleteProfileSubmit";
	const ADD_RECIPE_SUBMIT = "addRecipeSubmit";
	
	// Strings a user can see
	const LOGIN_SUBMIT_TEXT = "Logga in";
	const LOGOUT_SUBMIT_TEXT = "Logga ut";
	const REGISTER_SUBMIT_TEXT = "Registrera";
	const EDIT_PROFILE_SUBMIT_TEXT = "Spara Profil";
	const DELETE_PROFILE_SUBMIT_TEXT = "Avregistrera mig";
	const ADD_RECIPE_TEXT = "Lägg till recept";
		// Recipe labels
		const RECIPE_NAME_TEXT = "Receptnamn";
		const RECIPE_INGREDIENT_TEXT = "Ingredienser";
		const RECIPE_DESCRIPTION_TEXT = "Instruktioner";
		const RECIPE_SEVERITY_TEXT = "Svårighetsgrad";
		// Error messages
		const NORIGHTS_ADMIN = "Du är inte administratör.";
		const NORIGHTS_EDIT_PROFILE = "Du är inte inloggad och kan därför inte editera din profil.";
		const WRONG_PASSWORD_OR_USERNAME = "Felaktigt lösenord eller användarnamn";
		const FAIL_GET_USER_PROFILE = "Någonting gick fel med visningen av profil";
		const FAIL_GET_USERS = "Det gick inte att hämta alla användare.";
		const FAIL_GET_RECIPE = "Det gick inte att visa de valda receptet";
		const FAIL_GET_RECIPES = "Det gick inte att hämta alla recepten";
		// Success Messages
		const LOGIN_SUCCESS = "Du loggades in.";
		const REGISTER_SUCCESS = "Du registrerades.";
		const UPDATE_PROFILE_SUCCESS = "Du uppdaterade din profil.";
		const DELETE_PROFILE_SUCCESS = "Du avregistrerades.";
		const RIGHTS_ADMIN = "Du är administratör.";
		const SUCCESS_ADD_RECIPE = "Du skapade ett recept";
		// Validator errors
		const USERNAME_OR_EMAIL_WITH_TAG = "Ditt användarnamn eller email innehåller ogiltiga tecken.";
		const EMAIL_FORMAT = "Felaktigt inmatad Emailadress";
		const USERNAME_EXISTS = "Användarnamnet finns redan";
		const USERNAME_NOT_NULL = "Användarnamnet får inte vara null.";
		const USERNAME_LENGTH = "Användarnamnet måste vara längre än tre tecken och kortare än 51 tecken";
		const PASSWORD_FORMAT = "Lösenordet måste innehålla minst en versal, en gemen och en siffra och vara minst åtta tecken långt.";
		const REPEAT_PASSWORD_NOT_MATCH = "Lösenorden matchar inte varandra";
		const PASSWORD_MATCH_UPDATE_PROFILE = "Lösenordet matchar inte det som du loggade in med.";
		const SKILL_NAN = "Värdet för din kunskapsnivå är inte en siffra.";
		const SKILL_TO_HIGH = "Värde för din kunskapsnivå är för högt (Max: 1).";
		const SKILL_TO_LOW = "Värde för din kunskapsnivå är för lågt (Min: 1).";
		// Links
		const MY_PROFILE_LINK = "Min profil";
		const EDIT_MY_PROFILE_LINK = "Inställningar";
}
