<?php
use app\core\Application;
class m001_users
{
    public function up()
    {
     
      $SQL="CREATE TABLE m001_users(  
        id int NOT NULL primary key AUTO_INCREMENT comment 'primary key',
        fname varchar(255) NOT NULL,
        lname varchar(255) NOT NULL,
        password varchar(255) NOT NULL,
        create_time DATETIME COMMENT 'create time',
        update_time DATETIME COMMENT 'update time'
       
    ) default charset utf8 ";
      Application::$app->db->pdo->exec($SQL);
    }
    public function down()
    {

    }
}
