<?php

namespace View;

class AuthView
{
   public function DoLogInForm()
   {
      $html = "
               <form method=\"post\">
                  <label for=\"username\">Användarnamn</label>
                  <input type=\"text\" id=\"username\" name=\"username\" />
                  <label for=\"password\">Lösenord</label>
                  <input type=\"password\" id=\"password\" name=\"password\" />
                  <label for=\"remember\">Kom ihåg mig</label>
                  <input type=\"checkbox\" value=\"remember\" id=\"remember\" name=\"remember\" />
                  <input type=\"submit\" name=\"logInSubmit\" value=\"Logga in\" />  
                  <p class=\"small\">Har du inget konto än så <a href=\"register\">Registrera dig</a></p>
               </form>
            ";
      return $html;
   }
}
