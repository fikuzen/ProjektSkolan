<?php

namespace View;

class RecipeView
{
	/**
	 * Get the recipeID from the query
	 * @return $recipeID .. the value of the query
	 */
	public function GetRecipeID()
	{
		return NavigationView::IsRecipeQuery() ? NavigationView::GetRecipeQuery() : NULL;
	}
	
	/**
	 * Check if the user tried to add a recipe
	 *
	 * @return boolean
	 */
	public function TriedToAddRecipe()
	{
		return isset($_POST[\Common\String::ADD_RECIPE_SUBMIT]);
	}
	
	/**
	 * Get recipe name
	 */
	public function GetRecipeName()
	{
		return isset($_POST[\Common\String::RECIPE_NAME]) ? $_POST[\Common\String::RECIPE_NAME] : NULL;
	}
	
	/**
	 * Get recipe ingredients
	 */
	public function GetRecipeIngredient()
	{
		return isset($_POST[\Common\String::RECIPE_INGREDIENT]) ? $_POST[\Common\String::RECIPE_INGREDIENT] : NULL;
	}
	
	/**
	 * Get recipe description
	 */
	public function GetRecipeDescription()
	{
		return isset($_POST[\Common\String::RECIPE_DESCRIPTION]) ? $_POST[\Common\String::RECIPE_DESCRIPTION] : NULL;
	}
	
	/**
	 * Get recipe severity
	 */
	public function GetSeverity()
	{
		return isset($_POST[\Common\String::RECIPE_SEVERITY]) ? $_POST[\Common\String::RECIPE_SEVERITY] : NULL;
	}
	
	/**
	 * Recipe layout
	 *
	 * @return $html, generated html code
	 */
	public function DoRecipe(\Model\Recipe $recipe)
	{
		$html = "
			<h2>" . $recipe->GetRecipeName() . "</h2>
			<dl>
				<dt>Ingredienser</dt>
				<dd>" . nl2br($recipe->GetRecipeIngredient()) . "</dd>
				<dt>Instruktioner</dt>
				<dd>" . nl2br($recipe->GetRecipeDescription()) . "</dd>
				<dt>Svårighetsgrad</dt>
					<dd><meter value=\"" . $recipe->GetSeverity() . "\" min=\"0\" max=\"5\">/meter></dd>
			</dl>
		";
		return $html;
	}
	
	/**
	 * Form to add a recipe
	 * 
	 * @return $html, generated html code.
	 */
	public function DoAddRecipeForm()
	{
		$html = "
			<form class=\"addRecipe\" method=\"post\">
				<label for=\"" . \Common\String::RECIPE_NAME . "\">" . \Common\String::RECIPE_NAME_TEXT . "</label>
				<input type=\"text\" id=\"" . \Common\String::RECIPE_NAME . "\" name=\"" . \Common\String::RECIPE_NAME . "\" />
				<label for=\"" . \Common\String::RECIPE_INGREDIENT . "\">" . \Common\String::RECIPE_INGREDIENT_TEXT . "</label>
				<textarea id=\"" . \Common\String::RECIPE_INGREDIENT . "\" name=\"" . \Common\String::RECIPE_INGREDIENT . "\"></textarea>
				<label for=\"" . \Common\String::RECIPE_DESCRIPTION . "\">" . \Common\String::RECIPE_DESCRIPTION_TEXT . "</label>
				<textarea id=\"" . \Common\String::RECIPE_DESCRIPTION . "\" name=\"" . \Common\String::RECIPE_DESCRIPTION . "\"></textarea>
				<label for=\"" . \Common\String::RECIPE_SEVERITY . "\">" . \Common\String::RECIPE_SEVERITY_TEXT . "</label>
				<input type=\"number\" min=\"" . \Common\String::SEVERITY_MIN . "\" max=\"" . \Common\String::SEVERITY_MAX . "\" id=\"" . \Common\String::RECIPE_SEVERITY . "\" name=\"" . \Common\String::RECIPE_SEVERITY . "\" /><br />
				<input class=\"left\" type=\"submit\" name=\"" . \Common\String::ADD_RECIPE_SUBMIT . "\" value=\"" . \Common\String::ADD_RECIPE_TEXT . "\" />
			</form>";
		return $html;
	}
	
	/**
	 * Make HTML for a recipe add button
	 * 
	 * @return $html, generated html code.
	 */
	public function DoAddRecipeButton()
	{
		$html = "<a href=\"" . NavigationView::GetRecipeAddLink() . "\"><button class=\"left\">" . \Common\String::ADD_RECIPE_TEXT . "</button></a>";
		return $html;
	}
	
	/**
	 * List all recipes
	 *
	 * @return $html, generated html code
	 */
	public function DoRecipeList($recipes)
	{
		$html = "
			<ul>";
		foreach ($recipes as $recipe) {
			$html .= "<li><a href=\"" . NavigationView::GetRecipeLink($recipe->GetRecipeID()) . "\">" . $recipe->GetRecipeName() . "</a></li>";	
		}
		$html .= "
			</ul>
		";
		return $html;
	}
}
