<?php

namespace View;

class NavigationView
{
	private static $m_admin = "admin";  
	
	public function isAdminQuery() {
		return isset($_GET[self::$m_admin]);
	}
}
