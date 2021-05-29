<?php 
namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\models\UserModel;
use app\models\Login;

class AuthController extends Controller 
{
    /**
     * LOGOUT
     */
    public function logout(){
        Application::$app->logout();
      //  var_dump('logout');
        header('Location:/PHPMVCADVANCED.com/');
       
    }
    /**
     * LOG
     */
    public function login (Request $request){
        $login = new Login();
        if($request->isPost()){
        $login->load_data($request->get_body());
        if ($login->validate()){
            if($login->login()){
               // var_dump('login');
Application::$app->redirect('/PHPMVCADVANCED.com/register');
          //  header('Location:/PHPMVCADVANCED.com/');
              // exit;
            }
        }
    }
        $this->set_layout("auth");
        return $this->render('Auth/login' , ['model'=>$login]);
    }
    /**
     * REG
     * 
     * 
     * 
     */
    public function register (Request $request){
        $register = new UserModel();
     //   var_dump($register->register());
        $register->load_data($request->get_body());
    // var_dump($register->register());
        if ($request->isPost()){
         //   $register->register();
        // var_dump("vald");
         if($register->validate()){
           
            if (  $register->register() ){
               $register->Login();
            Application::$app->session->setFlash("seccess","Thanks egisteration");
               
            header('Location:/PHPMVCADVANCED.com/');
              
            }
         }
         
         $this->set_layout("auth");
           return  $this->render('Auth/register' , [
               "model" =>$register,
            
           ]); 
        }
        

        if   ($request->isGet()){
          
            $this->set_layout("auth");
            return $this->render('Auth/register', [
                "model" =>$register,
              
            ]);     
        }
       
    }
}