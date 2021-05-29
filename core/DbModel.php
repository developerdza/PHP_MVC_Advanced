<?php 
namespace app\core;

use app\core\Application;

abstract class DbModel extends Model
{
   abstract public static function tablename():string ;
   abstract public static function primarykey():string ;
   abstract public static function attributes();
   public function __construct(){
  
   }
   public static function buildParamsNames(){
    $params = '';
        foreach(static::attributes()  as $coulomName)
        {
           // var_dump( $this->{$coulomName});
           $params .=':'.$coulomName.','; 
        }
    return trim($params , ', ');
    }

    private  function prepareParams(\PDOStatement &$stm){
        $ar =[];
        $attributes =  static::attributes();
        
        foreach( $attributes as  $coulomName){
         //   var_dump(":$coulomName " . $this->{$coulomName});
          $stm->bindValue(":$coulomName" , $this->{$coulomName});
         }
    }

   public  function save(){
  //  var_dump($this->tableName());
//    var_dump($this->fname);
    $sql = "INSERT INTO ". static::tableName() . " (".implode(',' , static::attributes()  ).")  VALUES (".static::buildParamsNames()  .")";
  // $sql = 'INSERT INTO'.' '.$this->tableName().'  '.'SET'.'  '.$this->buildParamsNames();
    $stm =Application::$app->db->pdo->prepare($sql);
 //   $ar= '';
  // var_dump($sql);
  $this->prepareParams($stm);
    $stm->execute();
   return true;
}

/**
 * GET . WHERE
 */

public static function get( $options , $closure,$Coulomns=['*']){
    global $conn;
    $conn = Application::$app->db->pdo;
    $params = '';
    foreach($options  as $coulomName=> $value)
    {
       $params .= $coulomName .'=:'.$coulomName.' '.$closure.' '; 
    }
    $params= trim($params ,' '.$closure.' ');
    $gettingCoulomns = '';
    if ($Coulomns == '*'){$gettingCoulomns = '*';}
    else{
    foreach($Coulomns  as $coulomName)
    {
        $gettingCoulomns .= $coulomName.','; 
    }
    $gettingCoulomns = trim($gettingCoulomns , ',');
   }

   
    
    $sql = 'SELECT '. $gettingCoulomns.'  FROM'.' '.static::tablename().' WHERE (' . $params .' )' ;
    var_dump($sql);
    $stm = $conn->prepare($sql);

    foreach($options as  $coulomName => $value){
      // var_dump($value);
        $stm->bindValue(":{$coulomName}" , $value);
   
     }
   
     if($stm->execute()){
       // $objs = $stm->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE , get_called_class() , array_keys($options));
   //    var_dump($objs);
   $objs = $stm->fetchObject(static::class);
        if(!empty($objs)){
           return $objs;
        }
        else{
            return false;
        }
      
     }
     else{
       return False;
   } 


}
}