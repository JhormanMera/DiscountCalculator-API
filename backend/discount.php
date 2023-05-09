<?php 
include_once 'db.php';

class Discount extends DB{

    function getDiscounts(){
        $query = $this->connect()->query('SELECT * FROM ');
        return $query;
    }

    function getDiscountByConsole($console){
        $query = $this->connect()->prepare('SELECT * FROM  WHERE console = :console');
        $query->execute(['console' => $console]);
        return $query;
    }
}
?>