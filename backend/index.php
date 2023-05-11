<?php
include_once 'apisale.php';
$api = new ApiSale();
$arrayRoutes = explode('/',$_SERVER['REQUEST_URI']);

if(count(array_filter($arrayRoutes))<3){
        $api->errorMessage('Endpoint not found');
}else{
    if(count(array_filter($arrayRoutes))==3){
            if($arrayRoutes[3]=='discounts'){
                if(isset($_SERVER['REQUEST_METHOD'])&&$_SERVER['REQUEST_METHOD']=='GET'){
                    $api->getAllDiscounts();
                }else if(isset($_SERVER['REQUEST_METHOD'])&&$_SERVER['REQUEST_METHOD']=='POST'){
                    $data = json_decode(file_get_contents('php://input'), true);
                    $console = $data['console'];
                    $valor = $data['price'];
                    $api->getDiscountByConsole($console,$valor);                    
                }
            }else if($arrayRoutes[3]=='sales'){
                if(isset($_SERVER['REQUEST_METHOD'])&&$_SERVER['REQUEST_METHOD']=='GET'){
                    $api->getAllSales();
                }
        }else{
            $api->errorMessage('Endpoint not found');
        }
    }
}
?>
