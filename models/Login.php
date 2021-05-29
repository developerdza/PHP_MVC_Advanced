<?php 
namespace app\models;
use app\core\DbModel;
use app\core\Model;

use app\core\Application;

class Login extends Model{
  public $email , $password;
  
    public function rules(): array 
    {
    
        return [
            'email'=> [self::RULE_REQUIRED , self::RULE_EMAIL ],
            'password'=> [self::RULE_REQUIRED , self::RULE_MATCH , [self::RULE_MIN , "min" =>8] , [self::RULE_MAX , "max"=>60 ]],
        ];
    
    }
    
    public function login(){
    //  var_dump($this->email);
      $user = UserModel::get(["email"=>$this->email]  , "AND",['email','id','password'] );

     var_dump($user);
      if(!$user){ 
          $this->addLoginError("email" , "This  email  not found");
      }
      else{
          if(!password_verify($this->password,$user->password)){ 
               $this->addLoginError("password" , "This password is not correct");
               return false;
            }
          else{Application::$app->login($user);return true;}
      }

    }
}
