<?php
include_once 'discount.php';

class ApiDiscount{

    function getAll(){
        $discount = new Discount();
        $discounts = array();
        $discounts["items"] = array();

        $res = $discount->getDiscounts();

        if($res->rowCount()){
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                $item=array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'discount' => $row['discount'],
                    'description' => $row['description'],
                    'image' => $row['image'],
                    'id_product' => $row['id_product']
                );
                array_push($discounts['items'], $item);
            }
        
            echo json_encode($discounts);
        }else{
            echo json_encode(array('mensaje' => 'No hay elementos'));
        }
    }
}
?>