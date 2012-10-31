<?php

namespace Model;

class Recipe
{
	private $m_recipe;

	// Recipe variables
	CONST RECIPEID = "RecipeID";
	CONST USERID = "UserID";
	CONST AUTHOR = "Author";
	CONST RECIPENAME = "RecipeName";
	CONST INGREDIENT = "RecipeIngredient";
	CONST DESCRIPTION = "RecipeDescription";
	CONST SEVERITY = "Severity";

	public function __construct($recipeInfo)
	{
		if(isset($recipeInfo[self::RECIPEID]))
		{
			$this->SetRecipeID($recipeInfo[self::RECIPEID]);
		}
		else
		{
			$this->SetRecipeID(-1);
		}
		if(isset($recipeInfo[self::USERID]))
		{
			$this->SetUserID($recipeInfo[self::USERID]);
		}
		else
		{
			$this->SetUserID(-1);
		}
		$this->SetRecipeName($recipeInfo[self::RECIPENAME]);
		$this->SetRecipeIngredient($recipeInfo[self::INGREDIENT]);
		$this->SetRecipeDescription($recipeInfo[self::DESCRIPTION]);
		$this->SetSeverity($recipeInfo[self::SEVERITY]);
	}

	// Getters
	public function GetRecipeID()
	{
		return $this->m_recipe[self::RECIPEID];
	}
	
	public function GetUserID()
	{
		return $this->m_recipe[self::USERID];
	}
	
	public function GetAuthor()
	{
		return $this->m_recipe[self::AUTHOR];
	}

	public function GetRecipeName()
	{
		return $this->m_recipe[self::RECIPENAME];
	}

	public function GetRecipeIngredient()
	{
		return $this->m_recipe[self::INGREDIENT];
	}

	public function Getrecipedescription()
	{
		return $this->m_recipe[self::DESCRIPTION];
	}

	public function GetSeverity()
	{
		return $this->m_recipe[self::SEVERITY];
	}

	// Setters
	public function SetRecipeID($recipeID)
	{
		$this->m_recipe[self::RECIPEID] = $recipeID;
	}
	
	public function SetUserID($userID)
	{
		$this->m_recipe[self::USERID] = $userID;
	}
	
	public function SetAuthor($author)
	{
		$this->m_recipe[self::AUTHOR] = $author;
	}

	public function SetRecipeName($recipeName)
	{
		$this->m_recipe[self::RECIPENAME] = $recipeName;
	}

	public function SetRecipeIngredient($recipeIngredient)
	{
		$this->m_recipe[self::INGREDIENT] = $recipeIngredient;
	}

	public function SetRecipeDescription($recipeDescription)
	{
		$this->m_recipe[self::DESCRIPTION] = $recipeDescription;
	}

	public function SetSeverity($severity)
	{
		$this->m_recipe[self::SEVERITY] = $severity;
	}
	
	/**
	 * Get the the recipe stored in the session
	 *
	 * @return $recipe, the user.
	 */
	public static function GetRecipeSession()
	{
		return isset($_SESSION[\Common\String::SESSION_RECIPE]) ? unserialize($_SESSION[\Common\String::SESSION_RECIPE]) : NULL;
	}
}
