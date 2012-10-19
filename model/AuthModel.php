<?php

namespace Model;

class AuthModel
{
   private static $m_sessionLoggedIn = "loggedIn";
   
   private $m_db = NULL;
   
   public function __construct(Database $db)
   {
      $this->m_db = $db;
   }
   /**
    * Any user logged in?
    * 
    * @return BOOLEAN, True = logged in, False = not logged in
    */
   public static function IsLoggedIn() {
      return false;
      //TODO: Fix this..
      return isset($_SESSION[self::$m_sessionLoggedIn]) ? true : false;
   }
   
   private static function test(Database $db)
   {
      $errorMessages = array();
      
      
      
      return $errorMessages;
   }
}
