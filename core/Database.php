<?php
namespace app\core;

class Database
{
    public \PDO $pdo;

    public function __construct(array $config)
    {
        $bd_dsn = $config['dsn'] ?? "";
        $root = $config['root'] ?? "";
        $pass = $config['pass'] ?? "";
     //   var_dump($config);
        $this->pdo = new \PDO("mysql:host=127.0.0.1;port=3306;dbname=mvcframework", "root" ,"");
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE  , \PDO::ERRMODE_EXCEPTION);
    }

    public function upply_migration()
    {
        $this->create_migration_table();
       $upplied =  $this->get_upplied_migations();
        $created = scandir(Application::$FileDir."/migrations");
        
        $migrations_to_upply = array_diff( $created, $upplied );
   //  var_dump($migrations_to_upply );
     
       $new_migrations = [];
         foreach($migrations_to_upply as $migration){
            if ( $migration== "." ||  $migration== ".."  ){
         
            }
            else{
                $class_name = pathinfo($migration , PATHINFO_FILENAME);
              //  var_dump($class_name);
            require_once (Application::$FileDir."/migrations/".$migration);
            $class_name = new $class_name; 
            $class_name->up();
            $new_migrations[]=$migration;
            //var_dump($new_migrations);
            if (!empty($new_migrations)){

                $this->save_migrations($new_migrations);
            }
            else{
                echo "All the migration are upplied";
            }



            }
         }
         
   
    }

    public function save_migrations(array $migrations){
       $migrations_stm ="";
       foreach ($migrations as $migrations) {
           $migrations_stm .= "".$migrations."";
       }
       $migrations_stm = trim($migrations_stm , ',');
       var_dump($migrations_stm);
      $stm =   $this->pdo->prepare('
      INSERT INTO `migrations` (`migration`) VALUES (?) 
        ');

       $stm->execute([$migrations_stm]);
    }
    public function create_migration_table()
    {
          $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
              id INT AUTO_INCREMENT PRIMARY KEY,
              migration VARCHAR(255),
              created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
          )  ENGINE=INNODB ;");
         
    }
    public function get_upplied_migations(){
        $stm = $this->pdo->prepare("SELECT migration FROM migrations");
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_COLUMN);

    }
}
