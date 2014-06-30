<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_PdfController extends Coringa_Controller_Alicerce_Action {

    public function init() {
        parent::init();
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
    }

    public function contratoAction() {
        $db = new Alicerce_Model_DbTable_Locacao();
        $params = $this->getRequest()->getParams();
        $sel = $db->select();
        $sel->setIntegrityCheck(false);
        $sel->from(array("tal" => "tab_web_locacao"));
        $sel->where("tal.cod_locacao=?", $params['id']);
        $retorno = $db->fetchRow($sel);
        $pdf = new Coringa_Pdf_Fpdf();
        $pdf->setData(array(
            "dta_locacao" => $this->dataFormat($retorno['dta_locacao']),
            "hora_locacao" => $this->dataFormat($retorno['dta_locacao'], 1),
            "dta_devolucao" => $this->dataFormat($retorno['dta_devolucao']),
            "dias" => $this->returnDias($retorno['dta_locacao'], $retorno['dta_devolucao']),
            "vlr_total" => $retorno['vlr_total'],
            "vlr_extenso" => ucwords($this->valorPorExtenso($retorno['vlr_total'])),
            "num_contrato" => str_pad($retorno['cod_locacao'], 6, '0', STR_PAD_LEFT)
        ));
        $dbc = new Alicerce_Model_DbTable_Cliente();
        $selc = $dbc->select();
        $cocliente = $dbc->getCliente($retorno['cod_responsabilidade']);
        $pdf->setResponsavel(array(
            "nom_cliente" => $cocliente['nom_cliente'],
            "num_cnpj_cpf" => $cocliente['num_cnpj_cpf'],
            "num_rg_ie" => $cocliente['num_rg_ie'],
            "des_endereco" => $cocliente['des_endereco'],
            "des_bairro" => $cocliente['des_bairro'],
            "des_cidade" => $cocliente['des_cidade'],
            "des_estado" => $cocliente['des_estado'],
            "num_cep" => $cocliente['num_cep'],
            "num_fone" => $cocliente['num_fone'],
            "num_fone2" => $cocliente['num_fone2']
        ));
        $selc->where("cod_cliente=?", $retorno['cod_cliente']);
        $retcli = $dbc->fetchRow($selc);
        $pdf->setCliente(array(
            "cod_cliente" => str_pad($retcli['cod_cliente'], 2, '0', 0),
            "nom_cliente" => $retcli['nom_cliente'],
            "num_cnpj_cpf" => $retcli['num_cnpj_cpf'],
            "num_rg_ie" => $retcli['num_rg_ie'],
            "des_endereco" => $retcli['des_endereco'],
            "des_bairro" => $retcli['des_bairro'],
            "des_cidade" => $retcli['des_cidade'],
            "des_estado" => $retcli['des_estado'],
            "num_cep" => $retcli['num_cep'],
            "num_fone" => $retcli['num_fone'],
            "num_fone2" => $retcli['num_fone2']
        ));
        if ($retorno['cod_obra'] > 0) {
            $dbo = new Alicerce_Model_DbTable_Obra();
            $resulto = $dbo->fetchRow('cod_obra=' . $retorno['cod_obra']);
            if ($resulto['des_endereo'] != '') {
                $pdf->setObras(array(
                    "des_endereco" => $resulto['des_endereco'],
                    "des_bairro" => $resulto['des_bairro'],
                    "des_cidade" => $resulto['des_cidade'],
                    "des_estado" => $resulto['des_estado'],
                    "num_cep" => $resulto['num_cep'],
                    "num_fone" => $retcli['num_fone'],
                    "num_fone2" => $retcli['num_fone2']
                ));
            }
            else {

                $pdf->setObras(array(
                    "des_endereco" => $retcli['des_endereco'],
                    "des_bairro" => $retcli['des_bairro'],
                    "des_cidade" => $retcli['des_cidade'],
                    "des_estado" => $retcli['des_estado'],
                    "num_cep" => $retcli['num_cep'],
                    "num_fone" => $retcli['num_fone'],
                    "num_fone2" => $retcli['num_fone2']
                ));
            }
        }
        else {
            $pdf->setObras(array(
                "des_endereco" => $retcli['des_endereco'],
                "des_bairro" => $retcli['des_bairro'],
                "des_cidade" => $retcli['des_cidade'],
                "des_estado" => $retcli['des_estado'],
                "num_cep" => $retcli['num_cep'],
                "num_fone" => $retcli['num_fone'],
                "num_fone2" => $retcli['num_fone2']
            ));
        }

        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->mHeader();

        $dbel = new Alicerce_Model_DbTable_EquipamentoLocacao();
        $selel = $dbel->select();
        $selel->setIntegrityCheck(false);
        $selel->from(array('twel' => "tab_web_equipamento_locacao"), array("status_atual" => "twel.ind_status", "qtd_equipamento", "dta_devolucao", "dta_locacao", "ind_acessorio"));
        $selel->joinInner(array("twe" => "tab_web_equipamento"), "twe.cod_equipamento=twel.cod_equipamento");
        $pdf->SetFont('Arial', '', 8);
        $selel->where("twel.cod_locacao=?", $retorno['cod_locacao']);
//$selel->where("twel.ind_status=?", $retorno['ind_status']);
        $retel = $dbel->fetchAll($selel);
        foreach ($retel as $row) {
            if ($row['status_atual'] != 'C') {

                $pdf->Cell(20, 5, $row['qtd_equipamento'], 1, 0, 'C');
                $pdf->Cell(110, 5, $row['nom_equipamento'], 1, 0, 'L');
                $pdf->Cell(20, 5, str_pad($row['qtd_equipamento'], 2, '0', 0), 1, 0, 'C');
                $pdf->Cell(20, 5, number_format($row['vlr_equipamento'], 2, ',', '.'), 1, 0, 'R');
                $pdf->Cell(20, 5, number_format(($row['qtd_equipamento'] * $row['vlr_equipamento']), 2, ',', '.'), 1, 1, 'R');
                $total = $total + ($row['qtd_equipamento'] * $row['vlr_equipamento']);
                if ($row['ind_acessorio'] == 'S') {
                    $dba = new Alicerce_Model_DbTable_Acessorio();
                    $acess_data = $dba->getAcessorios($row['cod_equipamento']);
                    if (count($acess_data) > 0) {
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->SetFillColor(230);
                        $pdf->Cell(0, 4, 'Acessorios Inclusos', 1, 1, 'C', true);
                        foreach ($acess_data as $rowa) {
                            $pdf->Cell(20, 4, $rowa['qtd_acessorio'], 1, 0, 'C');
                            $pdf->Cell(110, 4, utf8_decode($rowa['nom_acessorio']), 1, 0, 'L');
                            $pdf->Cell(30, 4, number_format($rowa['vlr_acessorio'], 2, ',', '.'), 1, 0, 'R');
                            $pdf->Cell(30, 4, number_format(($rowa['qtd_acessorio'] * $rowa['vlr_acessorio']), 2, ',', '.'), 1, 1, 'R');
                            $total = $total + ($rowa['qtd_acessorio'] * $rowa['vlr_acessorio']);
                        }
                    }
                }
            }
            else {
                $pdf->Cell(20, 6, $row['qtd_equipamento'], 1, 0, 'C');
                $pdf->Cell(70, 6, $row['nom_equipamento'], 1, 0, 'L');
                $pdf->SetFont('Arial', '', 6);
                $pdf->SetFillColor(230);
                $pdf->Cell(40, 6, ' -- Equipamento Devolvido ' . $this->dataFormat($row['dta_devolucao']), 1, 0, 'L', 1);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(20, 6, str_pad($row['qtd_equipamento'], 2, '0', 0), 1, 0, 'R');
                $pdf->Cell(20, 6, number_format($row['vlr_equipamento'], 2, ',', '.'), 1, 0, 'R');
                $pdf->Cell(20, 6, number_format(($row['qtd_equipamento'] * $row['vlr_equipamento']), 2, ',', '.'), 1, 1, 'R');
                $total = $total + ($row['qtd_equipamento'] * $row['vlr_equipamento']);
            }
        }

//        $pdf->Cell(130, 12, '', 1, 0);
//        $pdf->Cell(60, 12, '', 1, 0);
//        $pdf->setX(10);
//        $pdf->Cell(130, 6, "VALOR TOTAL POR EXTENSO:", 0, 0, "L");
//        $pdf->Cell(60, 6, "VALOR TOTAL:", 0, 1, "L");
//        $pdf->SetFont('Times', '', 12);
//        $pdf->Cell(130, 6, "{$this->valorPorExtenso($total)}", 0, 0, "L");
//        $pdf->Cell(60, 6, number_format($total, 2, ',', '.'), 0, 1, "R");

        $pdf->mFooter($this->valorPorExtenso($total), number_format($total, 2, ',', '.'));
        $pdf->AddPage();

        $contrato = str_replace("  ", "", $this->config['termo_contrato']);
        $contrato = str_replace("<div>", "\n", $contrato);
        $contrato = str_replace("<br>", "\n", $contrato);
        $contrato = str_replace("</div>", "", $contrato);
        $contrato = strip_tags($contrato, '\n');
        $contrato = str_replace("[data]", $this->dataExtenso(date("Y-m-d")), $contrato);
        $obs_contrato = str_replace("  ", "", $this->config['obs_contrato']);
        $obs_contrato = str_replace("<div>", "\n", $obs_contrato);
        $obs_contrato = str_replace("<br>", "\n", $obs_contrato);
        $obs_contrato = str_replace("</div>", "", $obs_contrato);
        $obs_contrato = strip_tags($obs_contrato, '\n');
        $obs_contrato = str_replace("[data]", $this->dataExtenso(date("Y-m-d")), $obs_contrato);
        $pdf->mContrato(utf8_decode($contrato), utf8_decode($obs_contrato));
        $pdf->Output();
    }

    public function comprovanteAction() {

        $params = $this->getRequest()->getParams();
        $db = new Alicerce_Model_DbTable_Locacao();
        $dados_locacao = $db->getDadosPdf($params['pedido']);

        $pdf = new Coringa_Pdf_Fpdf();
        $pdf->params = 'true';
        $pdf->AliasNbPages();

        $pdf->AddPage();
        $pdf->comprovante($dados_locacao);

        $pdf->SetX(10);
        $dbel = new Alicerce_Model_DbTable_EquipamentoLocacao();
        $retdev = $dbel->getDevolvidos($params['pedido']);
        foreach ($retdev as $row) {
            $pdf->Cell(20, 5, utf8_decode($row['cod_equipamento']), 1, 0);
            $pdf->Cell(110, 5, utf8_decode($row['nom_equipamento']), 1, 0);
            $pdf->Cell(30, 5, utf8_decode($row['qtd_equipamento']), 1, 0);
            $pdf->Cell(30, 5, $this->dataFormat($row['dta_devolucao']), 1, 1);
        }
        $pdf->Ln(10);
        $pdf->MultiCell(0, 5, utf8_decode("Confirmo a devolução e o recebimento dos Equipamentos e Acessórios descritos àcima."), 0, 1);
        $pdf->Ln(10);
        $pdf->Cell(0, 5, utf8_decode($this->dataExtenso(Date("Y-m-d"))), 0, 1);
        $pdf->Ln(20);
        $pdf->Cell(80, 0, '', 1, 0);
        $pdf->Cell(10, 0, '', 0, 0);
        $pdf->Cell(80, 0, '', 1, 1);
        $pdf->Cell(80, 6, utf8_decode('ALICERCE LOCAÇÃO DE EQUIPAMENTOS'), 0, 0, 'C');
        $pdf->Cell(10, 6, '', 0, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode($dados_locacao['nom_cliente'] . ' (Locatário)'), 0, 1, 'C');
        $pdf->bFooter();
        $pdf->Output();
    }

    private function dataExtenso($data) {
        $dw = array("", "Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado");
        $m = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
        $gdw = date('w', strtotime($data));
        $gd = date('d', strtotime($data));
        $gm = date('m', strtotime($data)) + 0;
        $gy = date('Y', strtotime($data));
        return $dw[$gdw] . ', ' . $gd . ' de ' . $m[$gm] . ' de ' . $gy;
    }

    private function returnDias($data1, $data2) {
//Instancia a classe, atribuindo a data inicial
        list($d1, $h1) = explode(' ', $data1);
        list($d2, $h2) = explode(' ', $data2);
        $dataInicio = new DateTime($d1);
        $dataFim = new DateTime($d2);
//Retorna a diferença entre dois objetos DateTime, no caso um objeto DataInterval
        $intervalo = $dataInicio->diff($dataFim);
//Agora formatamos a data em dias
        if ($intervalo->format('%d') == 0 && $intervalo->format('%m') > 0) {
            return 'Mensal';
        }
        else {
            return $intervalo->format('%d');
        }
    }

    private function valorPorExtenso($valor = 0, $complemento = true) {
        $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
        $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");

        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");

        $z = 0;

        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);
        for ($i = 0; $i < count($inteiro); $i++)
            for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
                $inteiro[$i] = "0" . $inteiro[$i];

// $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
        for ($i = 0; $i < count($inteiro); $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count($inteiro) - 1 - $i;
            if ($complemento == true) {
                $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
                if ($valor == "000")
                    $z++;
                elseif ($z > 0)
                    $z--;
                if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
                    $r .= (($z > 1) ? " de " : "") . $plural[$t];
            }
            if ($r)
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        return ucwords($rt ? $rt : "zero");
    }

    private function dataFormat($d, $t = 0) {
        $dt = explode(" ", $d);
        $dh = $dt[1];
        $dt = explode("-", $dt[0]);
        if ($t == 0) {
            return $dt[2] . '/' . $dt[1] . '/' . $dt[0];
        }
        else {
            return $dh;
        }
    }

    public function coringaContratoAction() {
        exit;
        $pdf = new Coringa_Pdf_Fpdf();
        $texto = $this->config['contrato_coringa'];
        $dbe = new Alicerce_Model_DbTable_Empresa();
        $empresa = $dbe->getEmpresaDefault();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'BU', 13);
        $pdf->Cell(0, 6, utf8_decode('CONTRATO DE USO DE SOFTWARE'), 0, 1, 'C', false);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Ln(5);
        $pdf->Cell(0, 5, utf8_decode('IDENTIFICAÇÃO DAS PARTES CONTRATANTES'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 9);

        $pdf->MultiCell(0, 5, utf8_decode('Contratante: ' . $empresa['nom_empresa'] . ', inscrita no CNPJ sob Nº:' . $empresa['num_cnpj_cpf'] . ', neste ato representado por ' . $empresa['nom_responsavel'] . '.'), 0, 1);
        $pdf->Ln(2);
        $pdf->MultiCell(0, 5, utf8_decode('Contratado: Rodrigo Daniel Andrade, brasileiro, solteiro, programador, portador da Carteira de Identidade RG. Nº 10.341.359-SSP/MG e CPF Nº: 010.739.391-38.'), 0, 1);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Ln(2);
        $pdf->MultiCell(0, 5, utf8_decode('As partes acima identificadas têm, entre si, justas e acertadas o presente Contrato de Uso de Software que se regerá pelas cláusulas seguintes e pelas condições descritas no presente.'), 0, 1);
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, utf8_decode('DO OBJETO DO CONTRATO'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(0, 5, utf8_decode('Claúsula 1ª. O presente contrato tem como OBJETO, o uso do software em ambiente de comodata, realizado pela CONTRATADA à CONTRATANTE, do Software Locação de Materiais para Construção instalado na CONTRATANTE.'), 0, 1);
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, utf8_decode('DA MANUTENÇÃO'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(0, 5, utf8_decode('Claúsula 2ª. A manutenção do software, acertada neste instrumento, compreende atualização mensal de:'), 0, 1);
        $pdf->MultiCell(0, 5, utf8_decode('- Manutenção no Banco de Dados :: 2 horas'), 0, 1);
        $pdf->MultiCell(0, 5, utf8_decode('- Criação de Relatórios por sugestão do cliente :: 4 horas'), 0, 1);
        $pdf->MultiCell(0, 5, utf8_decode('- Alterações nas Estruturas dos Bancos de Dados, Cadastros ou Operações :: 4 horas'), 0, 1);
        $pdf->MultiCell(0, 5, utf8_decode('- Suportes ou Dúvidas :: 3 horas'), 0, 1);
        $pdf->Ln(2);
        $pdf->MultiCell(0, 5, utf8_decode('Totalizando 12 horas mensais.'), 0, 1);
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, utf8_decode('DAS OBRIGAÇÕES DAS PARTES'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(0, 5, utf8_decode('Claúsula 3ª. A CONTRATADA se responsabiliza pela entrega da manutenção pronta em até 4 dias úteis após o pedido de manutenção e/ou suporte pela CONTRATANTE.'), 0, 1);
        $pdf->Ln(2);
        $pdf->MultiCell(0, 5, utf8_decode('Claúsula 4ª. A CONTRATADA também se responsabilizará pelos problemas decorrentes de bugs, falhas e inoperatividades causadas no sistemas por quaisquer funcionário ou representante da CONTRATADA.'), 0, 1);
        $pdf->Ln(2);
        $pdf->MultiCell(0, 5, utf8_decode('Claúsula 5ª. A CONTRATANTE deverá informar imediatamente à CONTRATADA todos os problemas que visualizar no Software em questão, a fim de que esta possa prestar um serviço mais ágil e de melhor qualidade.'), 0, 1);
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, utf8_decode('DO PAGAMENTO'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(0, 5, utf8_decode('Claúsula 6ª. Pela prestação dos serviços acertados nesse instrumento, a CONTRATANTE pagará à CONTRATADA a quantia única de R$ 1.200,00 (um mil e duzentos reais), correspondente ao uso do Software.'), 0, 1);
        $pdf->Ln(2);
        $pdf->MultiCell(0, 5, utf8_decode('Parágrafo único. O não pagamento da quantia acertada neste instrumento no ato da assinatura do mesmo provocará a invalidade do contrato.'), 0, 1);
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, utf8_decode('DA RECISÃO'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(0, 5, utf8_decode('Cláusula 7ª. Este contrato será rescindido por vontade das partes ou por desrespeito a qualquer das cláusulas pactuadas, neste caso sob pena de responder por perdas e danos a parte que der causa à rescisão.'), 0, 1);
        $pdf->Ln(2);
        $pdf->MultiCell(0, 5, utf8_decode('Cláusula 8ª. Caso haja interesse na rescisão do contrato, a parte interessada notificará a outra, por escrito, com antecedência de 15 dias¹. Para isso, todos os vencimentos e serviços deverão estar previamente quitados de ambos os lados.'), 0, 1);
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, utf8_decode('DO PRAZO'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(0, 5, utf8_decode('Cláusula 9ª. O presente contrato é válido por 1 ano podendo ser renovado mediante novo acordo entre as partes.'), 0, 1);
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, utf8_decode('CONDIÇÕES GERAIS'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(0, 5, utf8_decode('Cláusula 10ª. Não será considerada manutenção, para os efeitos deste contrato, as alterações realizadas no software por interesse da CONTRATANTE, sendo tais serviços cobrados separadamente ao contrato.'), 0, 1);


        $pdf->Ln(2);
        $pdf->MultiCell(0, 5, utf8_decode('E por estarem assim justos e contratados, firmam o presente instrumento, em duas vias de igual teor.'), 0, 1);
        $pdf->Cell(0, 5, utf8_decode('Araguari, 25 de Setembro de 2013'), 0, 1, 'R');
        $pdf->Ln(10);
        $pdf->Cell(80, 0, '', 1, 0);
        $pdf->Cell(10, 0, '', 0, 0);
        $pdf->Cell(80, 0, '', 1, 1);
        $pdf->Cell(80, 6, utf8_decode('RODRIGO DANIEL ANDRADE'), 0, 0, 'C');
        $pdf->Cell(10, 6, '', 0, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode($empresa['nom_empresa']), 0, 1, 'C');
        $pdf->Output();
    }

}

?>
