<?php

namespace Controller;

require_once('view/RecipeView.php');
require_once('model/RecipeModel.php');
require_once('model/UserModel.php');

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
		$userModel = new \Model\UserModel($this->m_db);
		
		$userInSession = \Model\User::GetUserSession();
		
		if(\View\NavigationView::GetRecipeQuery() == \View\NavigationView::START || \View\NavigationView::GetRecipeQuery() == \View\NavigationView::LISTNING)
		{
			$html;
			$recipes = $recipeModel->GetRecipes();
			if($recipes)
			{
				$html = $recipeView->DoRecipeMenu(isset($userInSession));
				$html .= $recipeView->DoRecipeList($recipes);
				if(\View\NavigationView::IsSeverityQuery())
				{
					$severity = \View\NavigationView::GetSeverityQuery();
					$html = $recipeView->DoRecipeMenu(isset($userInSession), $severity);
					if(is_numeric($severity))
					{
						try
						{
						$html .= $recipeView->DoSelectedRecipeList($recipes, $severity);
						}
						catch (\Exception $e)
						{
							\Common\Page::AddErrormessage($e->getMessage());
						}
					}
					else if($severity == \View\NavigationView::YOUR_SEVERITY)
					{
						$severity = $userInSession->GetSkill();
						$html .= $recipeView->DoSelectedRecipeList($recipes, $severity);
					}
					else 
					{
						\Common\Page::AddErrormessage(\Common\String::FAIL_SEVERITY_MATCH);
					}
				}
			}
			else
			{
				\Common\Page::AddErrormessage(\Common\String::FAIL_GET_RECIPES);					
			}
			if(isset($userInSession))
			{
				$html .= $recipeView->DoAddRecipeButton();
			}
		}
		else if (\View\NavigationView::GetRecipeQuery() == \View\NavigationView::ADD)
		{
			$html = "";
			if(isset($userInSession))
			{
				$html = $recipeView->DoAddRecipeForm();
				if($recipeView->TriedToAddRecipe())
				{
					if($recipeView->ValidateRecipe())
					{
						try
						{
							$recipeInfo = array(
								\Model\Recipe::USERID => $userInSession->GetUserID(),
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
					else
					{
						\Common\Page::AddErrorMessage($recipeView->DoErrorList($recipeView->GetErrorMessages()));
					}
				}
			}
			else 
			{
				\Common\Page::AddErrormessage(\Common\String::NOT_LOGGED_IN);
			}
		}
		else if (\View\NavigationView::GetRecipeQuery() == \View\NavigationView::EDIT)
		{
			$html = "";
			$recipeID = \View\NavigationView::GetRecipeIDQuery();
			if(isset($recipeID) && isset($userInSession))
			{
				$recipe = $recipeModel->GetRecipeByID($recipeID);
				if($recipe->GetUserID() == $userInSession->GetUserID())
				{
					$recipeModel->StoreEditRecipe($recipe);
					$recipeInSession = \Model\Recipe::GetRecipeSession();
					$html = $recipeView->DoEditRecipeForm($recipe);
					if($recipeView->TriedToEditRecipe())
					{
						if($recipeView->ValidateRecipe())
						{
							try
							{
								$recipeInSession = \Model\Recipe::GetRecipeSession();
								$recipeInfo = array(
									\Model\Recipe::RECIPEID => $recipeInSession->GetRecipeID(),
									\Model\Recipe::RECIPENAME => $recipeView->GetRecipeName(),
									\Model\Recipe::INGREDIENT => $recipeView->GetRecipeIngredient(),
									\Model\Recipe::DESCRIPTION => $recipeView->GetRecipeDescription(),
									\Model\Recipe::SEVERITY => $recipeView->GetSeverity(),
								);
								$recipe = new \Model\Recipe($recipeInfo);
								if($recipeModel->DoUpdateRecipe($recipe))
								{
									\Common\Page::AddSuccessmessage(\Common\String::SUCCESS_EDIT_RECIPE);
								}
							}
							catch(\Exception $e)
							{
								\Common\Page::AddErrormessage($e->getMessage());
							}
						}
						else 
						{
							\Common\Page::AddErrorMessage($recipeView->DoErrorList($recipeView->GetErrorMessages()));
						}
					}
				}
				else
				{
					\Common\Page::AddErrormessage(\Common\String::UPDATE_RECIPE_NOT_YOURS);
				}
			}
			else if(!isset($recipeID))
			{
				\Common\Page::AddErrormessage(\Common\String::NO_RECIPE_ID);
			}
			else
			{
				\Common\Page::AddErrormessage(\Common\String::NOT_LOGGED_IN);
			}
		}
		else if (\View\NavigationView::GetRecipeQuery() == \View\NavigationView::DELETE)
		{
			$html = "";
			$recipeID = \View\NavigationView::GetRecipeIDQuery();
			if(isset($recipeID) && isset($userInSession))
			{
				$recipe = $recipeModel->GetRecipeByID($recipeID);
				if($recipe)
				{
					if($recipe->GetUserID() == $userInSession->GetUserID())
					{
						try
						{
							if($recipeModel->DoDeleteRecipe($recipeID))
							{
								\Common\Page::AddSuccessmessage(\Common\String::SUCCESS_DELETE_RECIPE);
							}
						}
						catch(\Exception $e)
						{
							\Common\Page::AddErrormessage($e->getMessage());
						}
					}
					else
					{
						\Common\Page::AddErrormessage(\Common\String::DELETE_RECIPE_NOT_YOURS);
					}
				}
				else 
				{
					\Common\Page::AddErrormessage(\Common\String::RECIPE_DOES_NOT_EXIST);
				}
			}
			else if(!isset($recipeID))
			{
				\Common\Page::AddErrormessage(\Common\String::NO_RECIPE_ID);
			}
			else
			{
				\Common\Page::AddErrormessage(\Common\String::NOT_LOGGED_IN);
			}
		}
		else
		{
			$html = "";
			$recipeID = $recipeView->GetRecipeID();
			$recipe = $recipeModel->GetRecipeByID($recipeID);
			
			// if the recipe Exists
			if($recipe)
			{
				if(isset($userInSession))
				{
					// store a boolean to see if the user is the author
					$isAdmin = ($userInSession->GetIsAdmin() == 1) ? true : false;
					$isAuthor = $recipeModel->IsAuthor($userInSession, $recipe->GetUserID());
				}
				else {
					// if not logged in you're defintly not the author
					$isAuthor = false;
				}
				
				// store the authors username
				$user = $userModel->GetUserByID($recipe->GetUserID());
				$recipe->SetAuthor($user->GetUsername());
				
				// make the recipe
				$html = $recipeView->DoRecipe($recipe, $isAuthor, $isAdmin);	
			}
			else
			{
				\Common\Page::AddErrormessage(\Common\String::FAIL_GET_RECIPE);				
			}
		}
		
		return $html;
	}
}