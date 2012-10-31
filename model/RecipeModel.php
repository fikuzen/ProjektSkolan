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
	 * Store a recipe in a session
	 */
	public function StoreEditRecipe(Recipe $recipe)
	{
		$_SESSION[\Common\String::SESSION_RECIPE] = serialize($recipe);
	}
	
	/**
	 * update a recipe in the database.
	 *
	 * @param $recipe, Recipe Object
	 * @return $editStatus, Boolean
	 */
	public function DoUpdateRecipe(Recipe $recipe)
	{
		$editStatus = true;
		if(!RecipeDAL::UpdateRecipe($recipe))
		{
			$editStatus = false;			
		}

		return $editStatus;
	}
	
	/**
	 * Delete a recipe that's in the database.
	 *
	 * @param $recipeID, user id
	 * @return $deleteStatus, Boolean
	 */
	public function DoDeleteRecipe($recipeID)
	{
		$deleteStatus = true;
		
		if(!RecipeDAL::DeleteRecipe($recipeID))
		{
			$deleteStatus = false;
		}

		return $deleteStatus;
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
	
	/**
	 * look up if the inlogged user is the author of the recipe
	 * 
	 * @param $userInSession, the inlogged user
	 * @param $recipeAuthor, the recipe to look up
	 * @return boolean
	 */
	public function IsAuthor(User $userInSession, $recipeAuthor)
	{
		if($userInSession->GetUserID() == $recipeAuthor)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
}











