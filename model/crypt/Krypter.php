<?php

namespace Model;

class Krypter
{
   public static function Crypt($password)
   {
      $salt = "Fk23s¤@@dsa";
      return md5($salt . $password);
   }
   
   public static function test()
   {
      $errorMessages = array();
      $errorMessages[] = "Kryptering Test";
      
      if(!(Krypter::Crypt('Fisk') == md5("Fk23s¤@@dsaFisk")))
      {
         $errorMessages[] = "Something is wrong with the Crypt method. (on line: " . __LINE__ . ")";
      }
      
      return $errorMessages;
   }
}
