<?php 
namespace app\models;
use app\core\DbModel;
use app\core\Model;
use app\core\Application;

class UserModel extends DbModel
{
 public $fname="",$lname="",$email="",$password="",$conpass="";
 
 public static function tablename():string{return "users";}
 public static function primarykey():string{return "id";}

 public static function  attributes(){
    return [
        "fname",
        'lname',
        "email",
        "password",
        
    ];
 }
 
 public function register(){
    
    $this->password = \password_hash($this->password , PASSWORD_DEFAULT);
   if( $this->save()){ 
    return true;}
 }

 public function Login(){
     $user = UserModel::get(["email"=>$this->email],"AND");
   //  var_dump($user);
    Application::$app->login($user);
 }
 public function rules(): array 
{

    return [
        'fname'=> [self::RULE_REQUIRED],
        'lname'=> [self::RULE_REQUIRED],
        'email'=> [self::RULE_REQUIRED , self::RULE_EMAIL , [self::RULE_UNIQUE , "class" =>self::class]],
        'password'=> [self::RULE_REQUIRED , self::RULE_MATCH , [self::RULE_MIN , "min" =>8] , [self::RULE_MAX , "max"=>60 ]],
        'conpass'=> [self::RULE_REQUIRED , self::RULE_MATCH],
        
        
    ];

}


   
}
