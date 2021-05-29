<?php 
namespace app\controllers;

use app\core\Application;

class Controller
{
    public $layout = 'main';
   
    public function set_layout($layout){
         $this->layout = $layout;
            }
  
    public function render($view , $params =[]){
       Application::$app->router->renderView($view ,$params);
    }
    
}
