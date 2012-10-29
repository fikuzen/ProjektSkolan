<?php

namespace Model;

require_once ('model/DAL/RecipeDAL.php');

class RecipeModel
{
	private $m_db = NULL;

	public function __construct(Database $db)
	{
		$this->m_db = $db;
	}
	
	/**
	 * Adds a recipe into the database.
	 *
	 * @param $recipe, Recipe Object
	 * @return $addStatus, Boolean
	 */
	public function DoAddRecipe(Recipe $recipe)
	{
		$addStatus = true;
		if(!RecipeDAL::AddRecipe($recipe))
		{
			$addStatus = false;			
		}

		return $addStatus;
	}
	
	/**
	 * Get a recipe from the database
	 * 
	 * @param $recipeID, user id
	 * @return the user
	 */
	public function GetRecipeByID($recipeID)
	{
		$recipe = RecipeDAL::GetRecipeByID($recipeID);
		if($recipe)
		{
			return $recipe;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * Get a recipes from the database
	 * 
	 * @return the recipes
	 */
	public function GetRecipes()
	{
		$recipes = RecipeDAL::GetAllRecipes();
		if($recipes)
		{
			return $recipes;
		}
		else
		{
			return false;
		}
	}
}
