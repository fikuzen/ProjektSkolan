<?php

namespace Controller;

require_once('view/RecipeView.php');
require_once('model/RecipeModel.php');

class RecipeController
{
	private $m_db;
	public function __construct(\Model\Database $db)
	{
		$this->m_db = $db;
	}
	
	public function DoControll()
	{
		$recipeView = new \View\RecipeView();
		$recipeModel = new \Model\RecipeModel($this->m_db);
		
		if(\View\NavigationView::GetRecipeQuery() == \View\NavigationView::START || \View\NavigationView::GetRecipeQuery() == \View\NavigationView::LISTNING)
		{
			$recipes = $recipeModel->GetRecipes();
			if($recipes)
			{
				$html = $recipeView->DoRecipeList($recipes);
				$html .= $recipeView->DoAddRecipeButton();
			}
			else
			{
				\Common\Page::AddErrormessage(\Common\String::FAIL_GET_RECIPES);					
			}
		}
		else if (\View\NavigationView::GetRecipeQuery() == \View\NavigationView::ADD)
		{
			$html = $recipeView->DoAddRecipeForm();
			if($recipeView->TriedToAddRecipe())
			{
				try
				{
					$recipeInfo = array(
						\Model\Recipe::RECIPENAME => $recipeView->GetRecipeName(),
						\Model\Recipe::INGREDIENT => $recipeView->GetRecipeIngredient(),
						\Model\Recipe::DESCRIPTION => $recipeView->GetRecipeDescription(),
						\Model\Recipe::SEVERITY => $recipeView->GetSeverity(),
					);
					$recipe = new \Model\Recipe($recipeInfo);
					if($recipeModel->DoAddRecipe($recipe))
					{
						\Common\Page::AddSuccessmessage(\Common\String::SUCCESS_ADD_RECIPE);
					}
				}
				catch(\Exception $e)
				{
					\Common\Page::AddErrormessage($e->getMessage());
				}
			}
		}
		else
		{
			$recipeID = $recipeView->GetRecipeID();
			$recipe = $recipeModel->GetRecipeByID($recipeID);
			if($recipe)
			{
				$html = $recipeView->DoRecipe($recipe);	
			}
			else
			{
				\Common\Page::AddErrormessage(\Common\String::FAIL_GET_RECIPE);				
			}
		}
		
		return $html;
	}
}