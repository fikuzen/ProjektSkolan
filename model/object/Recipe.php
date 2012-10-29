<?php

namespace Model;

class Recipe
{
	private $m_recipe;

	// Recipe variables
	CONST RECIPEID = "RecipeID";
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
}
