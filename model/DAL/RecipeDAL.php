<?php

namespace Model;

require_once ('model/object/Recipe.php');

class RecipeDAL
{
	const table_name = "Recipe";
	private static $m_fields = array("id" => "RecipeID", "name" => "RecipeName", "ingredient" => "RecipeIngredient", "description" => "RecipeDescription", "severity" => "Severity");
	private static $m_recipdID = "id";
	private static $m_recipeName = "name";
	private static $m_recipeIngredient = "ingredient";
	private static $m_recipeDescription = "description";
	private static $m_severity = "severity";

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
		$fieldToMatch = "RecipeID";
		$query = "SELECT * FROM $table WHERE $fieldToMatch = ?";

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
		$fieldToMatch = "RecipeName";
		$query = "SELECT * FROM $table WHERE $fieldToMatch = ?";

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
	static public function AddRecipe(Recipe $recipe)
	{
		$table = RecipeDAL::table_name;
		$sqlQuery = "INSERT INTO $table ("
							. self::$m_fields[self::$m_recipeName] . ", " 
							. self::$m_fields[self::$m_recipeIngredient] . ", " 
							. self::$m_fields[self::$m_recipeDescription] . ", " 
							. self::$m_fields[self::$m_severity] . ") 
						VALUES (?, ?, ?, ?)";

		$stmt = self::$m_db->Prepare($sqlQuery);

		$recipeName = $recipe->GetRecipeName();
		$recipeIngredient = $recipe->GetRecipeIngredient();
		$recipeDescription = $recipe->GetRecipeDescription();
		$severity = $recipe->GetSeverity();

		$stmt->bind_param("sssi", $recipeName, $recipeIngredient, $recipeDescription, $severity);

		try
		{
			// Execute the query and return the USERID
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
	static public function UpdateRecipe(Recipe $recipe)
	{
		$table = RecipeDAL::table_name;
		
		$sqlQuery = "UPDATE $table SET " 
						. self::$m_fields[self::$m_recipeName] . "=?, " 
						. self::$m_fields[self::$m_recipeIngredient] . "=?, " 
						. self::$m_fields[self::$m_recipeDescription] . "=?, " 
						. self::$m_fields[self::$m_severity] . " 
						WHERE " . self::$m_fields[self::$m_recipeID] . "=?";
		
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
	static public function DeleteRecipe($recipeID)
	{
		$table = RecipeDAL::table_name;
		$sqlQuery = "DELETE FROM $table WHERE " . self::$m_fields[self::$m_recipdID] . "=?";

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
