<?php

namespace Controller;

interface IController
{
	public function DoSiteTitle();
	public function DoHeader();
	public function DoAuth();
	public function DoNavigation();
	public function DoContentLeft();
	public function DoContentRight();
	public function DoFooter();
}
