<?php 
include_once 'db.php';

class Sale extends DB{

    function getAllDiscounts(){
        $query = $this->connect()->query('SELECT * FROM current_discounts');
        return $query;
    }

    function getDiscountByConsole($console){
        $query = $this->connect()->prepare('SELECT * FROM current_discounts WHERE console = :console');
        $query->execute(['console' => $console]);
        return $query;
    }

    function getAllSales(){
        $query = $this->connect()->query('SELECT * FROM sales_history');
        return $query;
    }

    function getSalesWithDiscount(){
        $query = $this->connect()->query('SELECT * FROM sales_history WHERE final_price != price');
        return $query;
    }

    function getTotalDiscount(){
        $query = $this->connect()->query('SELECT `price`, `final_price` FROM sales_history WHERE final_price != price');
        return $query;
    }

    function insertSale($id,$console,$price,$discount_id,$final_price){
        $query = $this->connect()->query('INSERT INTO `sales_history`(`id`, `console`, `price`, `discount_id`, `final_price`) VALUES ('.$id.',"'.$console.'",'.$price.','.$discount_id.','.$final_price.')');
        return $query;
    }
}
?>