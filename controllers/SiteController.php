<?php 
namespace app\controllers;

use app\core\Application;
use app\core\Request;

class SiteController extends Controller 
{
  

    public function contact(){
        return "handelind";
    }

    public function contactView(){

        $params =[
            'name'=>"saad",
        ];
     return    $this->render('contact' ,$params);
    }
   

    public function home(){

        $params =[
            'name'=>"saad",
        ];
     return    $this->render('Home' ,$params);
    }
   

     public function data_handeling(Request $request){
      var_dump(   $request->get_body());
       echo  'handelind';
    }

    
}
