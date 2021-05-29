<?php
namespace app\core;



class Response
{
 
   
    public function set_http_status(int $code)
    {
      return http_response_code($code);
    }


}
