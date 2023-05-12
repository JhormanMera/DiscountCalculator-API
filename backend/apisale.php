<?php
include_once 'sale.php';

class ApiSale{

    const withOutDiscount=5;

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
        return $valorACobrar;
    }

    function verifyDiscountInterval($price,$min_price,$max_price,$discount){
        // verificar si el precio está dentro del intervalo de descuento
        if($price>=$min_price && ($max_price==0 || $price<=$max_price)){
            return  $this->calculateDiscount($price,$discount);
        }else{
            return $this->calculateDiscount($price,0);
        }
    }

    
    function insertSale($data){
        $sale = new Sale();
        $discount_id=99999999;
        $console = strtoupper($data['console']);
        $price = $data['price'];
        $final_price = $data['final_price'];
        if($price===$final_price){ // si no hay descuento
            $discount_id = self::withOutDiscount;
        }else{
            $res = $sale->getDiscountByConsole($data['console']);
            if($res->rowCount()){
                $row = $res->fetch(PDO::FETCH_ASSOC);
                $discount_id=$row['id'];
            }else{
                $res = $sale->getDiscountByConsole('OTRA');
                $row = $res->fetch(PDO::FETCH_ASSOC);
                $discount_id=$row['id'];
            }
        }
        $res=$sale->insertSale(0,$console,$price,$discount_id,$final_price);
        if($res->rowCount()){
            $this->printJSON(array(
                'status' => 'ok',
                'message' => 'Sale inserted successfully'
            ));
        }else{
            $this->errorMessage('Sale not inserted');
        }
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
        $valorACobrar=$price;
        $res = $sale->getDiscountByConsole($name);
        if($res->rowCount()){
            $row = $res->fetch(PDO::FETCH_ASSOC);
            $valorACobrar=$this->verifyDiscountInterval($price,$row['min_price'],$row['max_price'],$row['discount']); 
        }else{
            $res = $sale->getDiscountByConsole('OTRA');
            $row = $res->fetch(PDO::FETCH_ASSOC);
            $valorACobrar=$this->verifyDiscountInterval($price,$row['min_price'],$row['max_price'],$row['discount']);
        }
        $this->printJSON(['valorACobrar' => $valorACobrar]);
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
                    'price' => $row['price'],
                    'discount_id' => $row['discount_id'],
                    'final_price' => $row['final_price'],
                );
                array_push($sales['items'], $item);
            }
            $this->printJSON($sales);
        }else{
            $this->errorMessage('No sales are currently registered');
        }
    }

    function getSalesWithDiscount(){
        $sale = new Sale();
        $sales = array();
        $sales["items"] = array();

        $res = $sale->getSalesWithDiscount();

        if($res->rowCount()){
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                $item=array(
                    'id' => $row['id'],
                    'console' => $row['console'],
                    'price' => $row['price'],
                    'discount_id' => $row['discount_id'],
                    'final_price' => $row['final_price'],
                );
                array_push($sales['items'], $item);
            }
            $this->printJSON($sales);
        }else{
            $this->errorMessage('No sales with discount are currently registered');
        }
    }
        
}
?>