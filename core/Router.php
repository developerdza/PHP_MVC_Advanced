<?php

namespace app\core;

use app\controllers\Controller;

class Router 
{
  public static $blades_path ;
  public static $layouts_path ;
    protected $routes ;
    public Request $request ;
    public Response $response;
    public $view;
    public $layout;
    public function __construct(Request $request , Response $response)
    {

      self::$blades_path =  Application::$FileDir."/views/";
      self::$layouts_path=  Application::$FileDir."/views/layouts";
       $this->request = $request; 
       $this->response = $response;
    }
    /**
     * GET method
     */
  public function get($path , $callback)
    { 
     
        $this->routes['get'][$path] = $callback ; 
    }

    /**
     * POST method
     */
    public function post($path , $callback)
    { 
     
        $this->routes['post'][$path] = $callback ; 
    }
    /**
     * RESOLVE
     */
    public function resolve()
    {
     $path =   $this->request->get_path();

     $method = $this->request->methode();
     $callback = $this->routes[$method][$path] ?? false;
     //var_dump([$this->routes['get']]);
     if ($callback==false){
      $this->response->set_http_status(404); 
      echo 'Not Found ';}
     
     else{
       if (($callback)){
         if (is_array(($callback)))//["controller"=>"methode",.....]
         {
      //   var_dump($this->if_view_exist(call_user_func($callback )));
         Application::$app->controller = new $callback[0]();
         $callback[0] = Application::$app->controller ;
          return call_user_func($callback , $this->request);
     }
     if (is_string($callback)){
       return call_user_func($callback );
     }
    }
  }
  
   
 } /**
     * IF VIEW EXIST
     */
    public function if_view_exist($view){
      if (false){
        
        return true;}

    }
    /**
     * RENDERING VIEW
     */
    public function renderView($view ,$params){

      
   $layout = $this->get_layout();
 $view =   $this->get_only_view($view ,$params);

 //echo $view;
   $content =  str_replace('{{content}}' , $view , $layout );
   echo $content;

    }
    /**
     * RENDERING VIEW-->GETTING THE LAYOUT
     */
    public function get_layout(){
     $layout =Application::$app->controller->layout;
      ob_start();
      include_once(self::$layouts_path."/".$layout.".layout.php");
      $content = ob_get_clean();
      ob_flush();
     return $content;
    }

    /**
     * RENDERING VIEW-->GETTING THE VIEW
     */
    public function get_only_view($view , $params){
     ob_start();
     foreach ($params as $key => $value){
      $$key = $value;
}

       include_once(self::$blades_path.$view.".php");
       $content = ob_get_clean();
       ob_flush();
       return $content;
    }

}
