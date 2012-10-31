<?php

namespace Model;

require_once ('model/object/Recipe.php');

class RecipeDAL
{
	const table_name = "Recipe";

	private static $m_db;

	public function __construct(Database $db)
	{
		self::$m_db = $db;
	}

	public static function GetAllRecipes()
	{
		$table = RecipeDAL::table_name;

		$query = "SELECT * FROM $table";
		$stmt = self::$m_db->Prepare($query);

		try
		{
			$recipesInfo = self::$m_db->SelectAllTable($stmt);
		}
		catch (exception $e)
		{
			return false;
		}

		$recipes = array();
		foreach($recipesInfo as $recipeInfo)
		{
			$recipes[] = new Recipe($recipeInfo);
		}

		return $recipes;
	}

	public static function GetRecipeByID($recipeID)
	{
		$table = RecipeDAL::table_name;
		$query = "SELECT * FROM $table WHERE " . Recipe::RECIPEID . " = ?";

		$stmt = self::$m_db->Prepare($query);

		$stmt->bind_param("i", $recipeID);

		$userInfo = array();

		try
		{
			$recipeInfo = self::$m_db->SelectAll($stmt);
			if(!isset($recipeInfo))
			{
				return false;
			}
		}
		catch (exception $e)
		{
			return false;
		}

		return new Recipe($recipeInfo);
	}

	public static function GetRecipeByName($recipename)
	{
		$table = RecipeDAL::table_name;
		$query = "SELECT * FROM $table WHERE " . Recipe::RECIPENAME . " = ?";

		$stmt = self::$m_db->Prepare($query);

		$stmt->bind_param("s", $recipename);

		$userInfo = array();

		try
		{
			$recipeInfo = self::$m_db->SelectAll($stmt);
		}
		catch (exception $e)
		{
			return false;
		}

		return new Recipe($recipeInfo);
	}

	/**
	 * Adds an recipe to the database
	 *
	 * @param $recipe , Recipe object
	 * @return bool
	 */
	public static function AddRecipe(Recipe $recipe)
	{
		$table = RecipeDAL::table_name;
		$sqlQuery = "INSERT INTO $table ("
							. Recipe::USERID . ", "
							. Recipe::RECIPENAME . ", " 
							. Recipe::INGREDIENT . ", " 
							. Recipe::DESCRIPTION . ", " 
							. Recipe::SEVERITY . ") 
						VALUES (?, ?, ?, ?, ?)";

		$stmt = self::$m_db->Prepare($sqlQuery);

		$userId = $recipe->GetUserID();
		$recipeName = $recipe->GetRecipeName();
		$recipeIngredient = $recipe->GetRecipeIngredient();
		$recipeDescription = $recipe->GetRecipeDescription();
		$severity = $recipe->GetSeverity();

		$stmt->bind_param("isssi", $userId, $recipeName, $recipeIngredient, $recipeDescription, $severity);

		try
		{
			$recipeID = self::$m_db->Insert($stmt);
		}
		catch (exception $e)
		{
			return false;
		}

		return $recipeID;
	}

	/**
	 * Update a recipes information
	 * 
	 * @return bool
	 */
	public static function UpdateRecipe(Recipe $recipe)
	{
		$table = RecipeDAL::table_name;
		
		$sqlQuery = "UPDATE $table SET " 
						. Recipe::RECIPENAME . "=?, " 
						. Recipe::INGREDIENT . "=?, " 
						. Recipe::DESCRIPTION . "=?, " 
						. Recipe::SEVERITY . "=? 
						WHERE " . Recipe::RECIPEID . "=?";
		
		$stmt = self::$m_db->Prepare($sqlQuery);
		
		$recipeName = $recipe->GetRecipeName();
		$recipeIngredient = $recipe->GetRecipeIngredient();
		$recipeDescription = $recipe->GetRecipeDescription();
		$severity = $recipe->GetSeverity();
		$recipeID = $recipe->GetRecipeID();
		
		$stmt->bind_param("sssii", $recipeName, $recipeIngredient, $recipeDescription, $severity, $recipeID);
		
		try
		{
			self::$m_db->Update($stmt);
		}
		catch (exception $e)
		{
			return false;
		}
		
		return true;
	}
	
	/**
	 * Delete a recipe from the database
	 *
	 * @return bool
	 */
	public static function DeleteRecipe($recipeID)
	{
		var_dump($recipeID);
		$table = RecipeDAL::table_name;
		$sqlQuery = "DELETE FROM $table WHERE " . Recipe::RECIPEID . "=?";

		$stmt = self::$m_db->Prepare($sqlQuery);

		$stmt->bind_param("i", $recipeID);

		$return = true;

		try
		{
			$return = self::$m_db->Remove($stmt);
		}
		catch (exception $e)
		{
			return false;
		}

		return $return;
	}
	
	public static function test(Database $db)
	{
		$errorMessages = array();
		$errorMessages[] = "RecipeDAL Test";

		//TODO: Write more test for RecipeDAL
		$sut = new RecipeDAL($db);		

		return $errorMessages;
	}

}
