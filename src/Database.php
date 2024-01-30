<?php 
class Database {
    public function __construct($host , $user , $db_name , $password)
    {
        $mysqli = new mysqli($host , $user , $password , $db_name);

        if($mysqli->connect_errno) {
     throw new Exception("connection error for no reason ");
      
}

return $mysqli;

    }
}

 




?>