<?php
namespace app\core;
use app\core\DbModel;
use app\controllers\Controller;
use app\core\Database;
use app\core\Session;

class Application
{
    public static $FileDir;
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    public Database $db;
    public  Controller $controller;  
    public Session  $session;
    public ?DbModel $user;
    public  $userClass;
    public  $primarykey;
    public function __construct($path , array $config)
    {
        session_start();
        $this->userClass = ($config['userClass']); 
        self::$app = $this;
        self::$FileDir = $path;
        $this->response = new Response();
        $this->request = new Request();
        $this->router = new Router($this->request , $this->response);
        $this->db = new Database($config['web']);
        $this->session = new Session();
        
        $this->session->get("Auth_".$this->userClass);
       if(! $this->session->get("Auth_".$this->userClass)== false ){
      //  var_dump($this->session->get("Auth_".$this->userClass));
    //  var_dump($this->userClass::primarykey());
  
       $primary= $this->session->get("Auth_".$this->userClass);
           $this->user = $this->userClass::get([$this->userClass::primarykey()=>$primary],"AND");
           var_dump( $this->user);       
       }
    }

    public static function isGuest(){
        if(!isset(self::$app->user)){
         //   var_dump('guest');
            return true;
        }
     
       
    }

    public static function Auth(){
        if(isset(self::$app->user)){
       //  var_dump('auth');
        return self::$app->user;
    }
    }
    public function redirect($path){
        header( 'Location:'.$path);
    }    
    
    public function run()
    {
       $this->router->resolve();    
    }

    public function login(DbModel $user){
        $this->user = $user;
     //   var_dump($user);
       // var_dump( 'ghghghg');
        $this->primarykey = $user->primarykey();
        $primaryvalue = $user->{$this->primarykey};
        $this->session->set("Auth_".$this->userClass,$primaryvalue);
        return true;
    }

   public function logout(){
       $this->user = null;
       var_dump('rr');
       $this->session->remove("Auth_".$this->userClass);
   }    

}
