<?php

class DBSettings {
	
	private static $m_host;
	private static $m_user;
	private static $m_pass;
	
	public function GetHost() { return self::$m_host; }
	public function GetUser() { return self::$m_user; }	
	public function GetPass() { return self::$m_pass; }
	public function SetHost($host) { self::$m_host = $host; }
	public function SetUser($user) { self::$m_user = $user; }
	public function SetPass($pass) { self::$m_pass = $pass; }	
	
	public function __construct($host, $user, $pass) {
		$this->SetHost($host);
		$this->SetUser($user);
		$this->SetPass($pass);
	}
}
