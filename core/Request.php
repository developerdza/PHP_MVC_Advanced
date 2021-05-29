<?php
namespace app\core;



class Request
{
  

   public function get_path(){
      $_SERVER['REQUEST_URI']=  $_SERVER['REQUEST_URI'] ?? "" ;
           $path = str_replace("/PHPMVCADVANCED.com",'' ,$_SERVER['REQUEST_URI'] );
          $path = str_replace("/index.php",'' ,$path );
           
         //  var_dump($path);
           $path =  $path ?? '/' ;
           $position = strpos($path , '?');
           if ($position == false){return $path;}

           else{
              $path = substr($path , 0 , $position);
              return $path;
           }
   }

   public function methode()
   
   {
      $_SERVER['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'] ?? "";
      return strtolower( $_SERVER['REQUEST_METHOD']);
   }

   public function isGet(){
      if ($this->methode() == "get")
      {
         return true;
      }
      else{
         return false;
      }
   }
   public function isPost(){
      if ($this->methode() == "post")
      {
         return true;
      }
      else{
         return false;
      }
   }
   public function get_body(){
      $body=[];
      if($this->methode() == 'get'){
         foreach($_GET as $key => $value){
              $body[$key] = filter_input(INPUT_GET , $value , FILTER_SANITIZE_SPECIAL_CHARS);
         } 
      }
      //var_dump($_POST);
      if($this->methode() == 'post'){
         foreach($_POST as $key => $value){
              $body[$key] = filter_input(INPUT_POST , $key , FILTER_SANITIZE_SPECIAL_CHARS);
         } 
      }
      return $body;
   }
}
