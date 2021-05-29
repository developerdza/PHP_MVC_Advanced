<?php
namespace app\core\Form;
use app\core\DbModel;
use app\core\Model;

class Form
{
    public static $test = 'hghg';
    public static function begin($action , $methode){
       echo printf(  " <form action='%S' method='%s' >" , $action , $methode);
       return new Form();
    }
    public static function end(){
        echo "   </form>";
    }

    public function field(Model $model , $attribute){
           return new Field($model , $attribute);
    }
}
