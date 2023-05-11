<?php
include_once 'sale.php';

class ApiSale{

    function errorMessage($mensaje){
        header('Content-Type: application/json');
        echo json_encode(array('Error' => $mensaje));
    }

    function printJSON($array){
        header('Content-Type: application/json');
        echo json_encode($array);
    }

    function calculateDiscount($price,$discount){
        // realizar cálculos necesarios para obtener el valor a cobrar al cliente
        $valorACobrar = round($price * (1 - ($discount / 100)),2);
        header('Content-Type: application/json');
        echo $this->printJson(['valorACobrar' => $valorACobrar]);
    }

    function getAllDiscounts(){
        $sale = new Sale();
        $sales = array();
        $sales["items"] = array();

        $res = $sale->getAllDiscounts();

        if($res->rowCount()){
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                $item=array(
                    'id' => $row['id'],
                    'console' => $row['console'],
                    'min_price' => $row['min_price'],
                    'max_price' => $row['max_price'],
                    'discount' => $row['discount'],
                );
                array_push($sales['items'], $item);
            }
            $this->printJSON($sales);
        }else{
            $this->errorMessage('There are currently no discounts available');
        }
    }
    
    function getDiscountByConsole($name,$price){
        $sale = new Sale();
        $sales = array();
        $sales["items"] = array();
        $res = $sale->getDiscountByConsole($name);
        $descuento=0;
        if($res->rowCount()){
            $row = $res->fetch(PDO::FETCH_ASSOC);
            $descuento = $row['discount'];
            // realizar cálculos necesarios para obtener el valor a cobrar al cliente
            $this->calculateDiscount($price,$descuento);
        }else{
             // Si no se encontró ningún descuento para la consola dada, se utiliza un descuento del 0%
             $this->calculateDiscount($price,$descuento);
            
        }
    }

    function getAllSales(){
        $sale = new Sale();
        $sales = array();
        $sales["items"] = array();

        $res = $sale->getAllSales();

        if($res->rowCount()){
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                $item=array(
                    'id' => $row['id'],
                    'console' => $row['console'],
                    'min_price' => $row['min_price'],
                    'max_price' => $row['max_price'],
                    'discount' => $row['discount'],
                );
                array_push($sales['items'], $item);
            }
            $this->printJSON($sales);
        }else{
            $this->errorMessage('No sales are currently registered');
        }
    }

    function InsertSale(){
        
    }
        
}
?>