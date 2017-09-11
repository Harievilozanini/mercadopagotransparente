<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once "lib/mercadopago.php";

$mp = new MP("TEST-7625375352946474-090614-a51a4517585fa1218244fba2538b2913__LC_LB__-272109853"); //INSIRA SEU ACCESS_TOKEN DISPONÍVEL EM: https://www.mercadopago.com/mlb/account/credentials


$payment_preference = array(
    "token"=> $_REQUEST['token'], // DADOS DO CARTÃO TOKENIZADO NO FORMULÁRIO EM INDEX.PHP
    "installments"=> (int)$_REQUEST['installmentsOption'], // QUANTIDADE DE PARCELAS ESCOLHIDAS PELO COMPRADOR.
    "transaction_amount"=> round((float)$_REQUEST['amount'],2), // VALOR TOTAL A SER PAGO PELO COMPRADOR.
    "external_reference"=> "PEDIDO-123456", // NUMERO DO PEDIDO DE SEU SITE PARA FUTURA CONCILIAÇÃO FINANCEIRA.
    "binary_mode" => false, // SE DEFINIDO true DESLIGA PROCESSO DE ANÁLISE MANUAL DE RISCO, PODE REDUZIR APROVAÇÃO DAS VENDAS SE NÃO CALIBRADO PREVIAMENTE.
    "description"=> "MINHA LOJA - PEDIDO-123456", // DESCRIÇÃO DO CARRINHO OU ITEM VENDIDO.
    "payment_method_id"=> $_REQUEST['paymentMethodId'], // MEIO DE PAGAMENTO ESCOLHIDO.
    "statement_descriptor" => "MEUSITE", // ESTE CAMPO IRÁ NA APARECER NA FATURA DO CARTÃO DO CLIENTE, LIMITADO A 10 CARACTERES.
    "notification_url"=> "http://www.minhaloja.com.br/webhooks", //ENDEREÇO EM SEU SISTEMA POR ONDE DESEJA RECEBER AS NOTIFICAÇÕES DE STATUS: https://www.mercadopago.com.br/developers/pt/solutions/payments/custom-checkout/webhooks/
    /*"sponsor_id"=>12345678*/ //SOMENTE PARA DEVS/PLATAFORMAS QUE FOREM ADMINISTRAR MÚLTIPLAS LOJAS, INFORMANDO NESTE CAMPO O ID DE SUA CONTA MERCADO PAGO, TORNARÁ FACILMENTE RASTREAVEL AS VENDAS DE TODOS OS SEUS CLIENTES LOJISTAS.
    "payer"=> array(
        "email"=> "comprador+272110086@mercadopago.com" //E-MAIL DO COMPRADOR
    ),
    "additional_info"=>  array(  // DADOS ESSENCIAIS PARA ANÁLISE ANTI-FRAUDE
        "items"=> array(array( //PARA CADA ITEM QUE ESTÁ SENDO VENDIDO É CRIADO UM ARRAY DENTRO DESTE ARRAY PAI COM AS INFORMAÇÕES DESCRITAS ABAIXO
            
                "id"=> "1234", //CÓDIGO IDENTIFICADOR DO SEU PRODUTO
                "title"=> "Aqui coloca os itens do carrinho", //TÍTULO DO ITEM
                "description"=> "Produto Teste novo", //DESCRIÇÃO DO ITEM
                "picture_url"=> "https=>//google.com.br/images?image.jpg", //IMAGEM DO ITEM
                "category_id"=> "fashion", //CATEGORIA A QUAL O ITEM PERTENCE, LISTAGEM DISPONÍVEL EM: https://api.mercadopago.com/item_categories
                "quantity"=> 1, //QUANTIDADE A QUAL ESTA SENDO COMPRADO ESTE ITEM
                "unit_price"=> round((float)$_REQUEST['amount'],2) //VALOR UNITARIO DO ITEM INDEPENDENTE DO QUANTO ESTÁ SENDO COBRADO
            )
        ),
        "payer"=>  array( //INFORMAÇÕES PESSOAIS DO COMPRADOR
            "first_name"=> "João",
            "last_name"=> "das Neves",
            "registration_date"=> "2014-06-28T16:53:03.176-04:00",
            "phone"=>  array(
                "area_code"=> "11",
                "number"=> "3222-1000"
            ),
            "address"=>  array(
                "zip_code"=> "05303-090",
                "street_name"=> "Av. Queiroz Filho",
                "street_number"=> "213"
            )
        ),
        "shipments"=>  array( //INFORMAÇÕES DO LOCAL ONDE O ITEM SERÁ ENTREGUE
            "receiver_address"=>  array(
                "zip_code"=> "05303-090",
                "street_name"=> "Av. Queiroz Filho",
                "street_number"=> "213",
                "floor"=> "1",
                "apartment"=> "20"
            )
        )
    )
  );

$response_payment = $mp->post("/v1/payments/", $payment_preference);

//IMPRESSÃO DO RETORNO DA API SOBRE A REQUISIÇÃO DE PAGAMENTO FEITA
echo "<pre>";
print_r($response_payment);
echo "</pre>";
?>

