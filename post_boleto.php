<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once "lib/mercadopago.php";

$mp = new MP("TEST-7625375352946474-090614-a51a4517585fa1218244fba2538b2913__LC_LB__-272109853"); //INSIRA SEU ACCESS_TOKEN DISPONÍVEL EM: https://www.mercadopago.com/mlb/account/credentials

$payment_preference = array(
    "date_of_expiration": "2017-12-20T23:59:59.000-04:00", //CAMPO OPCIONAL ONDE SE DEFINE O PRAZO DESEJADO PARA O PAGAMENTO DO BOLETO (DATA VENCIMENTO), APÓS ESTE PRAZO O PAGAMENTO NÃO SERÁ MAIS ACEITO, O PRAZO NÃO PODE SER SUPERIOR A 29 DIAS A PARTIR DA DATA DE CRIAÇÃO DO PAGAMENTO, NÃO INFORMANDO ESTE CAMPO VALE O PADRÃO DE 3 DIAS.
    "transaction_amount"=> 200.00, //VALOR TOTAL A SER PAGO PELO COMPRADOR.
    "external_reference"=> "PEDIDO-123456", //NUMERO DO PEDIDO DE SEU SITE PARA FUTURA CONCILIAÇÃO FINANCEIRA.
    "description"=> "Boleto Registrado na CIP conforme Febraban", //DESCRIÇÃO DO CARRINHO OU ITEM VENDIDO.
    "payment_method_id"=> "bolbradesco", //MEIO DE PAGAMENTO ESCOLHIDO.
    "payer"=> array( //DADOS ESSENCIAIS PARA REGISTRO DO BOLETO
        "email"=> "comprador+272110086@mercadopago.com" //EMAIL DO COMPRADOR
        "first_name"=> "João", //PRIMEIRO NOME DO COMPRADOR
        "last_name"=> "Silva", //SOBRENOME DO COMPRADOR, OPCIONAL SE FOR PESSOA JURIDICA
        "identification"=> array( //DADOS DE IDENTIFICAÇÃO DO COMPRADOR
                "type"=>"CPF" //TIPO DE DOCUMENTO, CPF OU CNPJ CASO BRASIL
                "number"=>"19119119100" //NUMERAÇÃO DO DOCUMENTO INFORMADO
        ),
        "address"=>  array( //ENDEREÇO DO COMPRADOR
                "zip_code"=> "05303-090", //CEP DO COMPRADOR
                "street_name"=> "Av. Queiroz Filho", //RUA DO COMPRADOR
                "street_number"=> "213" //NÚMERO DO COMPRADOR
                "neighborhood"=> "Bonfim" //BAIRRO DO COMPRADOR
                "federal_unit"=> "SP" //UNIDADE FEDERATIVA RESUMIDA EM SIGLA DO COMPRADOR
        )
    ),
    "additional_info"=>  array( //DADOS ESSENCIAIS PARA ANÁLISE ANTI-FRAUDE
        "items"=> array(array( //PARA CADA ITEM QUE ESTÁ SENDO VENDIDO É CRIADO UM ARRAY DENTRO DESTE ARRAY PAI COM AS INFORMAÇÕES DESCRITAS ABAIXO
            
                "id"=> "1234", //CÓDIGO IDENTIFICADOR DO SEU PRODUTO
                "title"=> "Aqui coloca os itens do carrinho", //TÍTULO DO ITEM
                "description"=> "Produto Teste novo", //DESCRIÇÃO DO ITEM
                "picture_url"=> "https=>//google.com.br/images?image.jpg", //IMAGEM DO ITEM
                "category_id"=> "others", //CATEGORIA A QUAL O ITEM PERTENCE, LISTAGEM DISPONÍVEL EM: https://api.mercadopago.com/item_categories
                "quantity"=> 1, //QUANTIDADE A QUAL ESTA SENDO COMPRADO ESTE ITEM
                "unit_price"=> 200.00 //VALOR UNITARIO DO ITEM INDEPENDENTE DO QUANTO ESTÁ SENDO COBRADO
            )
        ),
        "payer"=>  array( //INFORMAÇÕES PESSOAIS DO COMPRADOR
            "first_name"=> "João", //NOME DO COMPRADOR
            "last_name"=> "das Neves", //SOBRENOME DO COMPRADOR
            "registration_date"=> "2014-06-28T16:53:03.176-04:00", //DATA EM QUE O COMPRADOR FOI CADASTRADO COMO CLIENTE
            "phone"=>  array( //CONTATO TELEFÔNICO DO COMPRADOR
                "area_code"=> "5511", //DDD DO TELEFONE DO COMPRADOR
                "number"=> "3222-1000" //NÚMERO DO TELEFONE DO COMPRADOR
            ),
            "address"=>  array( //ENDEREÇO DO COMPRADOR
                "zip_code"=> "05303-090", //CEP DO COMPRADOR
                "street_name"=> "Av. Queiroz Filho", //NOME DA RUA DO COMPRADOR
                "street_number"=> "213" //NUMERO DA CASA DO COMPRADOR
            )
        ),
        "shipments"=>  array( //INFORMAÇÕES DO LOCAL ONDE O ITEM SERÁ ENTREGUE
            "receiver_address"=>  array(
                "zip_code"=> "05303-090", //CEP DA ENTREGA
                "street_name"=> "Av. Queiroz Filho", //RUA DA ENTREGA
                "street_number"=> "213", //NUMERO DA ENTREGA
                "floor"=> "1", //ANDAR DA ENTREGA
                "apartment"=> "14" //APARTAMENTO DA ENTREGA
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

