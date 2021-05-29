<?php 
namespace app\core;

use app\core\Application;

abstract class Model 
{
    public const RULE_REQUIRED = "required";
    public const RULE_EMAIL = "email";
    public const RULE_MIN = "min";
    public const RULE_MAX = "max";
    public const RULE_MATCH = "match";
    public const RULE_UNIQUE = "unique";
    public $errors = [];
    public function load_data($data)
    {
         foreach ($data as $key => $value) {
             if(property_exists($this,$key)){
                $this->{$key} = $value;
             }
          
         }
     // var_dump($this);
      
    }

    abstract  public function rules(): array ; // Must be emplimented in thz child class

   
    public function  validate() {
             foreach ($this->rules() as $attribute => $rules) {
                 $value = $this->{$attribute};
                 foreach ($rules as $rule) {
                     $ruleName = $rule;
                     if(is_array($ruleName)){
                         $ruleName = $ruleName[0];
                     }
                     if ($ruleName == self::RULE_REQUIRED && !$value) {
                        $this->add_error($attribute , self::RULE_REQUIRED ,  ['field'=>$attribute]);
                    }
                    if ($ruleName == self::RULE_UNIQUE ) {
                       $tableName = $rule["class"]::tableName();
                       $uniqueAttr = $rule["attrb"] ?? $attribute ;
                    
                       $sql = ("SELECT * FROM users WHERE email =:value");
                       $stm = Application::$app->db->pdo->prepare($sql);
                       $stm->bindValue(':value' , $value);
                       $stm->execute();
                       $record = $stm->fetchObject();
                     if($record){
                            var_dump($record);
                       $this->add_error($attribute ,self::RULE_UNIQUE , ['field'=>$attribute]);
                        }


                    }
                 }
                 
             }
          if($this->errors == null){
            return true;
          }
          else{
              return false;
          }
             

    }

    public function add_error($attribute , $rule , $params = []){
        $message = $this->error_messages()[$rule] ?? '';
        foreach($params as $key=>$value){
            $message =   str_replace("{$key}",$value,$message);
            $message =   str_replace("{",'',$message);
                $message =   str_replace("}",'',$message);
        }
        $this->errors[$attribute][] = $message;
     }

    public function addLoginError($attribute , $message){
        $this->errors[$attribute][] = $message;
    }

      public function error_messages()
     {
         return [
            self::RULE_REQUIRED=>"the {field} is required",
            self::RULE_UNIQUE=>"this  {field} is alredy valid",
             self::RULE_EMAIL  =>"this is not an email",
            self::RULE_MIN     =>"this must be more than {min}"
         ];
     }      
 public function getError($attr){ 
     if(array_key_exists($attr,$this->errors)){
         $message =   $this->errors[$attr][0];
         var_dump($this->errors);
   return  ( $message
     );
    }
    else {return ;}
 }    
}
