<?php

namespace View;

class MasterView
{
	public function DoSiteTitle()
	{
		$title = "Foodtime - Start";
		return $title;
	}
	
	public function DoHeader() 
	{		
		$html = "Foodtime";
		
		return $html;
	}
	
	public function DoFooter()
	{
		return "&copy; Copyright Christoffer Rydberg 2012";
	}
}
