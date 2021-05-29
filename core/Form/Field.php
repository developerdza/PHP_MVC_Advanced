<?php
namespace app\core\Form;


use app\core\DbModel;
use app\core\Model;

class Field
{
    public const INPUT_TYPE= 'text';
    public Model $model;
    public $attribute;
    public $type;

    public function __construct(Model $model , $attribute){
         $this->model = $model;
         $this->attribute =$attribute;
         $this->type = self::INPUT_TYPE;
    }

    public function __toString()
    {
        if( $this->type == 'password'){
            return sprintf("

            <div class='form-group'>
            <label for='input' class='col-sm-2 control-label'>%s</label>
            <div class='col-sm-10'>
           <input type='%s' name= '%s'  class='form-control ' id='exampleInputAmount'>
       </div>
       </div>
    
       ", 
      $this->label ()[$this->attribute] ?? $this->attribute,
       $this->type,
       $this->attribute,
    
       $this->attribute,
    );}
    else{    return sprintf("

        <div class='form-group'>
        <label for='input' class='col-sm-2 control-label'>%s</label>
        <div class='col-sm-10'>
       <input type='%s' name= '%s' value='%s' class='form-control ' id='exampleInputAmount'>
   </div>
   </div>

   ", 
  $this->label ()[$this->attribute] ?? $this->attribute,
   $this->type,
   $this->attribute,
   $this->model->{$this->attribute},
   $this->attribute,
);
     } }
public function label()
{
    return[
        'fname'=>"first name",
        'password'=>"password"
    ];
}
public function password_field(){
    $this->type = "password";
    return $this;
}
}
