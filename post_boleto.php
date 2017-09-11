<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once "lib/mercadopago.php";

$mp = new MP("TEST-7625375352946474-090614-a51a4517585fa1218244fba2538b2913__LC_LB__-272109853"); //INSIRA SEU ACCESS_TOKEN DISPONÍVEL EM: https://www.mercadopago.com/mlb/account/credentials

$payment_preference = array(
    "transaction_amount"=> 200.00,
    "external_reference"=> "PEDIDO-123456",
    "description"=> "Boleto Registrado na CIP conforme Febraban",
    "payment_method_id"=> "bolbradesco",
    "payer"=> array(
        "email"=> "comprador+272110086@mercadopago.com"
        "first_name"=> "João",
        "last_name"=> "Silva",
        "identification"=> array(
                "type"=>"CPF"
                "number"=>"19119119100"
        ),
        "address"=>  array(
                "zip_code"=> "05303-090",
                "street_name"=> "Av. Queiroz Filho",
                "street_number"=> "213"
                "neighborhood"=> "Bonfim"
                "federal_unit"=> "SP"
        )
    ),
    "additional_info"=>  array(
        "items"=> array(array(
            
                "id"=> "1234",
                "title"=> "Aqui coloca os itens do carrinho",
                "description"=> "Produto Teste novo",
                "picture_url"=> "https=>//google.com.br/images?image.jpg",
                "category_id"=> "others",
                "quantity"=> 1,
                "unit_price"=> 200.00
            )
        ),
        "payer"=>  array(
            "first_name"=> "João",
            "last_name"=> "das Neves",
            "registration_date"=> "2014-06-28T16:53:03.176-04:00",
            "phone"=>  array(
                "area_code"=> "5511",
                "number"=> "3222-1000"
            ),
            "address"=>  array(
                "zip_code"=> "05303-090",
                "street_name"=> "Av. Queiroz Filho",
                "street_number"=> "213"
            )
        ),
        "shipments"=>  array(
            "receiver_address"=>  array(
                "zip_code"=> "05303-090",
                "street_name"=> "Av. Queiroz Filho",
                "street_number"=> "213",
                "floor"=> "0",
                "apartment"=> "0"
            )
        )
    )
  );

  
$response_payment = $mp->post("/v1/payments/", $payment_preference);

echo "<pre>";
print_r($response_payment);
echo "</pre>";

echo "<iframe src='". $response_payment["response"]["transaction_details"]["external_resource_url"] . "' >";
?>

