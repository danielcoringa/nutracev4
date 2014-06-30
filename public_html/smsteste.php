<?php
$SESSAO = false;

//$_SESSION['debug'] = SQL;

if (!defined('WWW_ROOT'))
    define("WWW_ROOT", "../");
include(WWW_ROOT . "_inc/_php/geral.inc.php");

$url = 'http://200.186.94.165:8080/smsIntegrationCenter/soap/messageService?wsdl';
//$client = new SoapClient($url);
$client = new SoapClient($url, array("trace"=>1,"debug"=>1));
//echo "passou aqui";
// Tabela de SMS
/*$objSms = new TabSms();
$agora = Date("Y-m-d");
$querySms = $objSms->consulta("A.*", null, null, "(A.dat_inicio_envio <='" . $agora . "' AND (A.dat_fim_envio >='" . $agora . "' or A.dat_fim_envio IS NULL) )");
$resultSms = $querySms->getDados();

// Tabela de Envio Sms
$objEnvioSms = new TabEnvioSms();
$queryEnvioSms = $objEnvioSms->consulta("A.*", null, array(
    "B" => array(TTABPESSOA, 'B.cod_pessoa=A.cod_pessoa', 'B.*', 'joinLeft')
        ), 'bol_enviada_sucesso IS NULL'
);
$resultEnvioSms = $queryEnvioSms->getDados();
foreach ($resultEnvioSms as $row_envio) {
 * 
 */
//    $phones[] = array(
//        "phone" => "3491724788",
//        "datSchedule" => date('d/m/Y'));
    $phones[] = array(
        "phone" => "3488127312",
        "datSchedule" => date('d/m/Y'));
//}

/*if (count($resultEnvioSms) > 0) {
    
    foreach ($resultSms as $row_sms) {*/
        $dados = array(
            'message' => array(
                'textMessage' => "teste de envio novo servidor",
                'datSchedule' => date('d/m/Y'),
                'listPhone' => $phones
            ),
            'idProject' => 226,
            'login' => 'goonrisk_cota',
            'password' => 'voxgoon2014',
            'datSchedule' => date('d/m/Y')
        );
        //$objEnvioSms->atualizar(array("bol_enviada_sucesso" => 1), "cod_sms=" . $row_sms['cod_sms']);
        
        
        //try {
            $order_return = $client->sendSingleMessage($dados);
            
            print_r($order_return);
        /*} catch (SoapFault $exception) {
            var_dump(get_class($exception));
            var_dump($exception);
        }
    }
}*/
