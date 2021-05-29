<?php
namespace app\core;

class Session  
{
   public  const FLASH_KEY = "flash_messages";
    public function __construct(){
     
       $flash_messages =[];
      $flash_messages = $_SESSION[self::FLASH_KEY] ?? [] ;
       foreach($flash_messages as $key => &$message){
            $message["remove"] = true;
       }
       $this->__destruct();
       $_SESSION[self::FLASH_KEY] = $flash_messages;
    }
    public function getFlash($key){
        if((!$_SESSION[self::FLASH_KEY]==null)){
        $val =  $_SESSION[self::FLASH_KEY][$key]["remove"] ?? false;
        var_dump($val);
        if (!$val){
            $message =  $_SESSION[self::FLASH_KEY][$key]["value"];
            return ($message);
        }
    }
        
    }
     public function setFlash($key , $message){
        $_SESSION[self::FLASH_KEY][$key] = [
            "remove"=>"false",
            "value" =>$message,
        ];
    }

    public function __destruct()
    {
        $flash_messages =[];
        $flash_messages = $_SESSION[self::FLASH_KEY] ?? [] ;
         foreach($flash_messages as $key => &$message){
             if(isset($message["remove"])){
                   unset($message["value"]);
                  // var_dump($message);
             }
       }
     
    }


    public function set($key,$val){
        $_SESSION[$key] = $val;
        var_dump($_SESSION[$key]);
 }
 public function get($key){
  //var_dump ($_SESSION[$key]) ;
  $val =$_SESSION[$key] ?? null;
  if(!$val ==null){
  return ($_SESSION[$key]);
}
  else{return false;}
}

public function remove($key){
    unset($_SESSION[$key]);
}
}
