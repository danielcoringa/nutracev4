<?php

include(str_replace("application", "library", APPLICATION_PATH) . '/Coringa/Pdf/fpdf/fpdf.php');

class Coringa_Pdf_Fpdf extends FPDF {

    function setData($data) {
        $this->data = $data;
    }

    function setObras($data) {
        $this->obra = $data;
    }

    function setCliente($data) {
        $this->cliente = $data;
    }

    function setResponsavel($data) {
        $this->coresponsabilidade = $data;
    }

    function mHeader() {
        $empresa = new Alicerce_Model_DbTable_Empresa();
        $empresa = $empresa->getEmpresaDefault();
        $path = BASIC_FOLDER;
        $this->SetFillColor(255);
        $this->SetDrawColor(0, 160, 0);
        $this->SetFont('Arial', 'B', 11);

        $this->RoundedRect(10, 10, 190, 30, 2, '1234', 'FD');
        $this->Image($path . '/img/alicerce/logo.jpg', 11, 11, 68);
        $this->Cell(0, 5, '', 0, 1);
        $this->SetX(80);
        $this->Cell(70, 5, 'FONES: (34) 3241-0677 / 8865-4774', 0, 1, 'C');
        $this->SetX(80);
        $this->Cell(70, 5, 'AV. BAHIA, 1130 - CENTRO', 0, 1, 'C');
        $this->SetX(80);
        $this->Cell(70, 5, 'ARAGUARI - MG - CEP 38440-188', 0, 1, 'C');
        $this->SetX(80);
        $this->SetFont('Arial', '', 7);
        $this->SetX(80);
        $this->Cell(70, 3, utf8_decode(''), 0, 1, 'C');
        $this->SetX(80);
        $this->Cell(70, 3, utf8_decode('VISÃO CORRETORA LTDA'), 0, 1, 'C');
        $this->SetX(80);
        $this->Cell(70, 3, 'CNPJ 22.222.525/0001-04  INSC. EST. ISENTO', 0, 1, 'C');
        $this->SetY(10);
        $this->SetX(150);
        $this->SetFillColor(0, 200, 0);
        $this->Cell(0.1, 30, '', 0, 1, 'L', true);
        $this->SetFillColor(255);
        $this->SetY(15);
        $this->SetX(150);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(50, 5, 'CONTRATO', 0, 1, 'C');
        $this->SetX(150);
        $this->Cell(50, 5, utf8_decode('DE LOCAÇÃO'), 0, 1, 'C');
        $this->SetX(150);
        $this->Cell(50, 5, utf8_decode(''), 0, 1, 'C');
        $this->Cell(50, 3, utf8_decode(''), 0, 1, 'C');
        $this->SetX(150);
        $this->Cell(5, 5, utf8_decode('Nº'), 0, 0, 'L');
        $this->SetTextColor(200, 0, 0);
        $this->SetFont('Times', 'B', 14);
        $this->Cell(45, 5, utf8_decode($this->data['num_contrato']), 0, 1, 'C');
        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(0);
        $this->Ln();
        $this->RoundedRect(10, 42, 190, 24, 2, '1234', 'FD');
        $this->SetX(10);
        $this->SetY(42);
        $this->SetFont('Arial', '', 6);
        $this->Cell(0, 8, '', 0, 0);
        $this->SetX(10);
        $this->Cell(35, 4, utf8_decode('DATA DA LOCAÇÃO'), 0, 0, 'L');
        $this->Cell(15, 4, utf8_decode('HORA'), 0, 0, 'L');
        $this->Cell(55, 4, utf8_decode('PERÍODO DE LOCAÇÃO'), 0, 0, 'L');
        $this->Cell(30, 4, utf8_decode('VALOR DA LOCAÇÃO'), 0, 0, 'L');
        $this->Cell(40, 4, utf8_decode('TRANSPORTE INCLUSO'), 0, 0, 'L');
        $this->Cell(15, 4, utf8_decode('VALOR'), 0, 1, 'L');

        $this->SetFont('Arial', '', 8);
        $this->Cell(35, 4, utf8_decode($this->data['dta_locacao']), 0, 0, 'L');
        $this->Cell(15, 4, utf8_decode($this->data['hora_locacao']), 0, 0, 'L');
        $this->Cell(55, 4, utf8_decode($this->data['dta_locacao'] . ' À ' . $this->data['dta_devolucao'] . ' (' . $this->data['dias'] . ' dias)'), 0, 0, 'L');
        $this->Cell(30, 4, utf8_decode($this->data['vlr_total']), 0, 0, 'L');
        $this->Cell(40, 4, utf8_decode(''), 0, 0, 'L');
        $this->Cell(15, 4, utf8_decode($this->data['vlr_total']), 0, 1, 'L');

        $this->SetY(42);
        $this->SetX(45);
        $this->SetFillColor(0, 200, 0);
        $this->Cell(0.1, 8, '', 0, 1, 'L', true);
        $this->SetY(42);
        $this->SetX(60);
        $this->Cell(0.1, 8, '', 0, 1, 'L', true);
        $this->SetY(42);
        $this->SetX(115);
        $this->Cell(0.1, 8, '', 0, 1, 'L', true);
        $this->SetY(42);
        $this->SetX(145);
        $this->Cell(0.1, 8, '', 0, 1, 'L', true);
        $this->SetY(42);
        $this->SetX(185);
        $this->Cell(0.1, 8, '', 0, 1, 'L', true);

        $this->Cell(0, 0.2, '', 0, 1, '', true);
        $this->SetFillColor(255);

        $this->SetFont('Arial', '', 6);
        $this->Cell(130, 4, utf8_decode('VALOR POR EXTENSO'), 0, 0, 'L');
        $this->Cell(45, 4, utf8_decode('CONTATO'), 0, 0, 'L');
        $this->Cell(15, 4, utf8_decode('TELEFONE'), 0, 1, 'L');

        $this->SetFont('Arial', '', 8);
        $this->Cell(130, 4, utf8_decode($this->data['vlr_extenso']), 0, 0, 'L');
        $this->Cell(45, 4, utf8_decode($this->coresponsabilidade['nom_cliente']), 0, 0, 'L');
        $this->Cell(15, 4, utf8_decode($this->coresponsabilidade['num_fone']), 0, 1, 'L');



        $this->SetY(50);
        $this->SetX(140);
        $this->SetFillColor(0, 200, 0);
        $this->Cell(0.1, 8, '', 0, 1, 'L', true);
        $this->SetY(50);
        $this->SetX(185);
        $this->Cell(0.1, 8, '', 0, 1, 'L', true);
        $this->SetFillColor(0, 200, 0);
        $this->Cell(0, 0.2, '', 0, 1, '', true);
        $this->SetFillColor(255);

        $this->SetFont('Arial', '', 6);
        $this->Cell(100, 4, utf8_decode('LOCAL DA OBRA'), 0, 0, 'L');
        $this->Cell(40, 4, utf8_decode('BAIRRO'), 0, 0, 'L');
        $this->Cell(40, 4, utf8_decode('CIDADE'), 0, 0, 'L');
        $this->Cell(10, 4, utf8_decode('UF'), 0, 1, 'L');
        $this->SetFont('Arial', '', 8);
        $this->Cell(100, 4, utf8_decode($this->obra['des_endereco']), 0, 0, 'L');
        $this->Cell(40, 4, utf8_decode($this->obra['des_bairro']), 0, 0, 'L');
        $this->Cell(40, 4, utf8_decode($this->obra['des_cidade']), 0, 0, 'L');
        $this->Cell(10, 4, utf8_decode($this->obra['des_estado']), 0, 1, 'L');

        $this->SetY(58);
        $this->SetX(110);
        $this->SetFillColor(0, 200, 0);
        $this->Cell(0.1, 8, '', 0, 1, 'L', true);
        $this->SetY(58);
        $this->SetX(150);
        $this->Cell(0.1, 8, '', 0, 1, 'L', true);
        $this->SetY(58);
        $this->SetX(190);
        $this->Cell(0.1, 8, '', 0, 1, 'L', true);

        $this->SetFillColor(255);
        $this->RoundedRect(10, 68, 190, 5, 2, '12', 'FD');
        $this->SetY(68);
        $this->SetX(10);
        $this->SetFont('Arial', '', 6);
        $this->Cell(20, 5, utf8_decode('CÓDIGO'), 0, 0, 'C');
        $this->Cell(110, 5, utf8_decode('DESCRIÇÃO DO EQUIPAMENTO'), 1, 0, 'C');
        $this->Cell(20, 5, utf8_decode('QUANTIDADE'), 1, 0, 'C');
        $this->Cell(20, 5, utf8_decode('VALOR UNITÁRIO'), 1, 0, 'C');
        $this->Cell(20, 5, utf8_decode('VALOR TOTAL'), 0, 0, 'C');
        $this->Ln();
        $this->Cell(20, 80, '', 1, 0);
        $this->Cell(110, 80, '', 1, 0);
        $this->Cell(20, 80, '', 1, 0);
        $this->Cell(20, 80, '', 1, 0);
        $this->Cell(20, 80, '', 1, 1);
        $this->SetY(73);
    }

    function mFooter($ext, $total) {
        $this->SetFillColor(255);
        $this->RoundedRect(10, 148, 190, 8, 2, '34', 'FD');
        $this->SetY(148);
        $this->SetX(10);
        $this->SetFont('Arial', '', 6);
        $this->Cell(150, 4, utf8_decode('VALOR POR EXTENSO'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(20, 8, utf8_decode('TOTAL GERAL'), 1, 0, 'C');
        $this->SetFont('Arial', '', 8);
//        $this->SetFillColor(200, 220, 200);
        $this->Cell(20, 8, utf8_decode($total), 0, 1, 'C');
        $this->SetY(152);
        $this->SetX(10);
        $this->Cell(150, 4, utf8_decode($ext), 0, 1, 'L');
        $this->RoundedRect(10, 158, 190, 40, 2, '1234', 'FD');
        $this->SetY(158);
        $this->SetX(10);
        $this->SetFont('Arial', '', 6);
        $this->Cell(0, 4, utf8_decode('OBSERVAÇÃO'), 0, 1, 'L');
        $this->SetFont('Arial', '', 9);
        $this->SetX(11);
        $this->MultiCell(188, 4, strtoupper(utf8_decode("Pelo presente instrumento particular de locação, como locadora e empresa Visão Corretora LTDA, Inscrita no CNPJ 22.222.525/0001-04, INSCRIÇÃO ESTADUAL ISENTO E COMO LOCATÁRIA(O) " . $this->cliente['nom_cliente'])), 0, 1, 'L');
        $this->SetX(10);
        $this->SetFillColor(0, 200, 0);
        $this->Cell(0, 0.2, '', 0, 1, '', true);
        $this->SetFillColor(255);
        $this->SetFont('Arial', '', 6);
        $this->Cell(0, 8, '', 0, 0);

        $this->SetX(10);
        $this->Cell(15, 4, utf8_decode('CÓDIGO'), 0, 0, 'L');
        $this->Cell(140, 4, utf8_decode('ENDEREÇO DA(O) LOCATÁRIA(O)'), 0, 0, 'L');
        $this->Cell(35, 4, utf8_decode('BAIRRO'), 0, 1, 'L');
        $this->SetFont('Arial', '', 8);
        $this->Cell(15, 4, utf8_decode($this->cliente['cod_cliente']), 0, 0, 'C');
        $this->Cell(140, 4, utf8_decode($this->cliente['des_endereco']), 0, 0, 'L');
        $this->Cell(35, 4, utf8_decode($this->cliente['des_bairro']), 0, 1, 'L');

        $this->SetY(174);
        $this->SetX(25);
        $this->SetFillColor(0, 200, 0);
        $this->Cell(0.1, 8, '', 0, 1, 'L', true);
        $this->SetY(174);
        $this->SetX(165);
        $this->Cell(0.1, 8, '', 0, 1, 'L', true);
        $this->SetFont('Arial', '', 6);
        $this->Cell(0, 0.2, '', 0, 1, '', true);
        $this->SetFillColor(255);
        $this->Cell(125, 4, utf8_decode('CIDADE'), 0, 0, 'L');
        $this->Cell(15, 4, utf8_decode('ESTADO'), 0, 0, 'L');
        $this->Cell(25, 4, utf8_decode('CEP'), 0, 0, 'L');
        $this->Cell(25, 4, utf8_decode('TELEFONE'), 0, 1, 'L');
        $this->SetFont('Arial', '', 8);
        $this->Cell(125, 4, utf8_decode($this->cliente['des_cidade']), 0, 0, 'L');
        $this->Cell(15, 4, utf8_decode($this->cliente['des_estado']), 0, 0, 'L');
        $this->Cell(25, 4, utf8_decode($this->cliente['num_cep']), 0, 0, 'L');
        $this->Cell(25, 4, utf8_decode($this->cliente['num_fone']), 0, 1, 'L');
        $this->SetY(182);
        $this->SetX(135);
        $this->SetFillColor(0, 200, 0);
        $this->Cell(0.1, 8, '', 0, 1, 'L', true);
        $this->SetY(182);
        $this->SetX(150);
        $this->Cell(0.1, 8, '', 0, 1, 'L', true);
        $this->SetY(182);
        $this->SetX(175);
        $this->Cell(0.1, 8, '', 0, 1, 'L', true);
        $this->Cell(0, 0.2, '', 0, 1, '', true);
        $this->SetFont('Arial', '', 6);
        $this->Cell(100, 4, utf8_decode('CNPJ (MF) / CPF'), 0, 0, 'L');
        $this->Cell(90, 4, utf8_decode('INSCRIÇÃO ESTADUAL'), 0, 1, 'L');
        $this->SetFont('Arial', '', 8);
        $this->Cell(100, 4, utf8_decode($this->cliente['num_cnpj_cpf']), 0, 0, 'L');
        $this->Cell(90, 4, utf8_decode($this->cliente['num_rg_ie']), 0, 1, 'L');
        $this->SetY(190.2);
        $this->SetX(110);
        $this->SetFillColor(0, 200, 0);
        $this->Cell(0.1, 7.8, '', 0, 1, 'L', true);
        $this->SetFillColor(255);

        $this->RoundedRect(10, 200, 190, 55, 2, '1234', 'FD');
        $this->SetY(200);
        $this->SetX(10);
        $this->SetFont('Arial', '', 6);
        $this->Cell(0, 4, utf8_decode('OBSERVAÇÕES'), 0, 1, 'L');
        $this->Cell(0, 25, utf8_decode(''), 0, 1, 'L');
        $this->Cell(100, 5, utf8_decode('DATA DO VENCIMENTO: '), 1, 0, 'L');
        $this->Cell(90, 5, utf8_decode('FORMA DE PAGAMENTO: '), 1, 1, 'L');
        $this->SetX(11);
        $this->SetFont('Arial', '', 8);
        $this->Ln();
        $this->MultiCell(188, 4, utf8_decode('QUE ASSUMEM PESSOAL E SOLIDARIAMENTE, INTEGRAL RESPONSABILIDADE CIVIL E CRIMINAL POR TODAS AS OBRIGAÇÕES DO PRESENTE CONTRATO E FICAM NOMEADOS DEPOSITÁRIOS DOS EQUIPAMENTOS LOCADOS, ATÉ O FINAL DO CONTRATO, FICANDO JUSTO E CONTRATADO O SEGUINTE, QUE MUTUAMENTE OUTORGAM E ACEITAM, A SABER, CONFORME CONDIÇÕES ESPECIFICADAS NO VERSO.'), 0, 1);
    }

    function mHeader1() {
//Dados
        $empresa = new Alicerce_Model_DbTable_Empresa();
        $empresa = $empresa->getEmpresaDefault();

//Logo
        $path = BASIC_FOLDER;

//Arial bold 15
        $this->SetFont('Arial', 'B', 11);

//
//        $this->Cell(95, 16, '', 1, 0, 'L', false);
//        $this->Cell(95, 16, '', 1, 0, 'L', false);
//        $this->setY(10);
//        $this->setX(15);
//        $this->Cell(95, 10, utf8_decode('Não recebemos Devoluções de'), 0, 0, 'L', false);
//        $this->Cell(95, 10, utf8_decode(''), 0, 0, 'L');
//        $this->Ln(3);
//        $this->setX(115);
//        $this->Cell(95, 10, utf8_decode('email:alicerce@alicerce.com.br'), 0, 0, 'L', false);
//        $this->Ln(2);
//        $this->setX(15);
//        $this->Cell(95, 10, utf8_decode('Mercadorias nos Sábados'), 0, 0, 'L', false);
//        $this->Cell(95, 10, utf8_decode(''), 0, 0, 'L');
//        $this->Ln(11);
        $this->Cell(0, 20, '', 1, 0, 'L', false);

        $this->Image($path . '/img/alicerce/logo.jpg', 11, 11, 43);
        $this->setY(10);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(20, 10, '', 0, 0);
        $this->Cell(170, 10, utf8_decode($empresa['nom_empresa']), 0, 1, 'C', false);
        $this->Cell(0, 5, utf8_decode($empresa['des_endereco'] . ' - ' . $empresa['des_bairro'] . ' - ' . $empresa['des_cidade'] . ' - ' . $empresa['des_estado']), 0, 1, 'C', false);

        $this->Cell(0, 5, utf8_decode('Fones: ' . $empresa['num_fone'] . ' / ' . $empresa['num_fone2']), 0, 1, 'C', false);

//Move to the right
        $this->Cell(0, 6, '', 1, 0, 'L', false);
        $this->setX(15);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(60, 6, utf8_decode('CONTRATO DE LOCAÇÃO'), 0, 0, 'L', false);
        $this->SetFont('Arial', 'B', 8);

        $this->Cell(60, 6, utf8_decode("Data: {$this->data['dta_locacao']}"), 0, 0, 'C', false);
        $this->Cell(60, 6, utf8_decode("Nº Contrato: {$this->data['num_contrato']}"), 0, 0, 'R', false);
        $this->Ln();
        $this->Cell(0, 6, '', 1, 0, 'L', false);
        $this->setX(15);
        $this->Cell(40, 6, utf8_decode("Início: {$this->data['dta_locacao']}"), 0, 0, 'L', false);
        $this->Cell(40, 6, utf8_decode("Final: {$this->data['dta_devolucao']}"), 0, 0, 'L', false);
        $this->Cell(40, 6, utf8_decode("Dias: {$this->data['dias']}"), 0, 0, 'L', false);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(65, 6, utf8_decode("Valor da Locação: {$this->data['vlr_total']}"), 1, 0, 'L', false);
        $this->Ln();


        $this->Cell(0, 6, '', 1, 0, 'L', false);
        $this->setX(15);
        $this->Cell(0, 6, utf8_decode("Valor por Extenso: {$this->data['vlr_extenso']}"), 0, 0, 'L', false);
        $this->Ln();
        $this->Cell(0, 12, '', 1, 0, 'L', false);
        $this->setX(15);
        $this->SetFont('Arial', 'BI', 13);
        $this->Cell(0, 6, utf8_decode("RELOCAÇÃO AUTOMÁTICA NO VENCIMENTO"), 0, 1, 'C', false);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 6, utf8_decode("Avisar com 5 dias de antecedência caso não haja necessidade."), 0, 0, 'C', false);
        $this->Ln();
        $this->SetFillColor(150, 150, 150);
        $this->Cell(0, 6, '', 1, 0, 'L', true);
        $this->SetFont('Arial', 'B', 10);
        $this->setX(15);
        $this->Cell(0, 6, utf8_decode("DADOS DA OBRA"), 0, 1, 'C', false);
        $this->Cell(0, 22, '', 1, 0, 'L', false);
        $this->SetFont('Arial', '', 10);
        $this->setX(10);
        $this->Cell(95, 5, utf8_decode("Endereço: {$this->obra['des_endereco']}"), 0, 1, 'L', false);
        $this->Cell(95, 5, utf8_decode("Bairro: {$this->obra['des_bairro']}"), 0, 0, 'L', false);
        $this->Cell(95, 5, utf8_decode("CEP: {$this->obra['num_cep']}"), 0, 1, 'L', false);
        $this->Ln(1);
        $this->Cell(95, 5, utf8_decode("Cidade: {$this->obra['des_cidade']}"), 0, 0, 'L', false);
        $this->Cell(95, 5, utf8_decode("Estado: {$this->obra['des_estado']}"), 0, 1, 'L', false);
        $this->Ln(1);
        $this->Cell(95, 5, utf8_decode("Telefone: {$this->obra['num_fone']}"), 0, 0, 'L', false);
        $this->Cell(95, 5, utf8_decode("Celular: {$this->obra['num_fone2']}"), 0, 0, 'L', false);
        $this->Ln();
        $this->Cell(0, 5, '', 1, 0, 'L', false);
        $this->setX(10);
        $this->SetFont('Arial', '', 10);
        $this->SetFillColor(150, 150, 150);
        $this->Cell(0, 5, utf8_decode("EQUIPAMENTOS LOCADOS"), 0, 1, 'C', true);
        $this->SetFillColor(190, 190, 190);
        $this->Cell(20, 5, utf8_decode("Qtde"), 1, 0, 'C', true);
        $this->Cell(110, 5, utf8_decode("Descrição do Equipamento"), 1, 0, 'C', true);
        $this->Cell(30, 5, utf8_decode("Vlr. Unitário"), 1, 0, 'C', true);
        $this->Cell(30, 5, utf8_decode("Vlr. Total"), 1, 1, 'C', true);
//Line break
    }

//Page footer
    function mFooter1() {
//Position at 1.5 cm from bottom
        //$this->setY(-96);
        $db = new Alicerce_Model_DbTable_Empresa();
        $empresa = $db->getEmpresaDefault();
        $this->Cell(0, 40, '', 1, 0, 'L', false);
        $this->setX(10);
        $this->SetFont('Arial', '', 10);
        $this->SetFillColor(150, 150, 150);
        $this->Cell(0, 5, utf8_decode("DADOS DO CLIENTE"), 1, 1, 'C', true);

        $this->setX(10);
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, utf8_decode("Pelo presente instrumento particular de locação, como locadora e empresa Visão Corretora LTDA, Inscrita no CNPJ"), 0, 1, 'L', false);
        $this->Cell(0, 5, utf8_decode("sob o Nº " . $empresa['num_cnpj_cpf'] . " e como Locatária(o):"), 0, 1, 'L', false);
        $this->Cell(0, 0, '', 1, 1);
        $this->Cell(0, 5, utf8_decode("Cliente: {$this->cliente['nom_cliente']}"), 0, 1, 'L', false);
        $this->Cell(95, 5, utf8_decode("Endereço: {$this->cliente['des_endereco']}"), 0, 0, 'L', false);
        $this->Cell(95, 5, utf8_decode("Bairro: {$this->cliente['des_bairro']}"), 0, 1, 'L', false);
        $this->Cell(95, 5, utf8_decode("CEP: {$this->cliente['num_cep']}"), 0, 0, 'L', false);
        $this->Cell(55, 5, utf8_decode("Cidade: {$this->cliente['des_cidade']}"), 0, 0, 'L', false);
        $this->Cell(40, 5, utf8_decode("UF: {$this->cliente['des_estado']}"), 0, 1, 'L', false);
        $this->Cell(95, 5, utf8_decode("CPF/CNPJ: {$this->cliente['num_cnpj_cpf']}"), 0, 0, 'L', false);
        $this->Cell(95, 5, utf8_decode("RG/IE: {$this->cliente['num_rg_ie']}"), 0, 1, 'L', false);
        $this->Cell(95, 5, utf8_decode("Telefone: {$this->cliente['num_fone']}"), 0, 0, 'L', false);
        $this->Cell(95, 5, utf8_decode("Celular: {$this->cliente['num_fone2']}"), 0, 1, 'L', false);
        $this->SetFillColor(150, 150, 150);
        $this->Cell(0, 5, utf8_decode("CO-RESPONSABILIDADE"), 0, 1, 'C', true);
        $this->Cell(0, 45, '', 1, 0, 'L', false);
        $this->setX(10);
        $this->Cell(0, 5, utf8_decode("Cliente: {$this->coresponsabilidade['nom_cliente']}"), 0, 1, 'L', false);
        $this->Cell(95, 5, utf8_decode("Endereço: {$this->coresponsabilidade['des_endereco']}"), 0, 0, 'L', false);
        $this->Cell(95, 5, utf8_decode("Bairro: {$this->coresponsabilidade['des_bairro']}"), 0, 1, 'L', false);
        $this->Cell(95, 5, utf8_decode("CEP: {$this->coresponsabilidade['num_cep']}"), 0, 0, 'L', false);
        $this->Cell(55, 5, utf8_decode("Cidade: {$this->coresponsabilidade['des_cidade']}"), 0, 0, 'L', false);
        $this->Cell(40, 5, utf8_decode("UF: {$this->coresponsabilidade['des_estado']}"), 0, 1, 'L', false);
        $this->Cell(95, 5, utf8_decode("CPF/CNPJ: {$this->coresponsabilidade['num_cnpj_cpf']}"), 0, 0, 'L', false);
        $this->Cell(95, 5, utf8_decode("RG/IE: {$this->coresponsabilidade['num_rg_ie']}"), 0, 1, 'L', false);
        $this->Cell(95, 5, utf8_decode("Telefone: {$this->coresponsabilidade['num_fone']}"), 0, 0, 'L', false);
        $this->Cell(95, 5, utf8_decode("Celular: {$this->coresponsabilidade['num_fone2']}"), 0, 1, 'L', false);

        $this->SetFillColor(150, 150, 150);
        $this->Cell(0, 5, utf8_decode("COBRANÇA"), 1, 1, 'C', true);
        $this->Cell(95, 5, utf8_decode("Endereço: {$this->cobranca['nom_cliente']}"), 0, 0, 'L', false);
        $this->Cell(95, 5, utf8_decode("Bairro: {$this->cobranca['des_bairro']}"), 0, 1, 'L', false);
        $this->Cell(95, 5, utf8_decode("CEP: {$this->cobranca['num_cep']}"), 0, 0, 'L', false);
        $this->Cell(55, 5, utf8_decode("Cidade: {$this->cobranca['des_cidade']}"), 0, 0, 'L', false);
        $this->Cell(40, 5, utf8_decode("UF: {$this->cobranca['des_estado']}"), 0, 1, 'L', false);

        $this->Cell(95, 5, utf8_decode("Telefone: {$this->cobranca['num_fone']}"), 0, 0, 'L', false);
        $this->Cell(95, 5, utf8_decode("Celular: {$this->cobranca['num_fone2']}"), 0, 1, 'L', false);

//Arial italic 8
        $this->SetFont('Arial', 'I', 8);
//Page number
        //$this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function mContrato($texto, $obs_contrato) {

        $this->SetFont('Arial', 'BU', 13);
        $this->Cell(0, 6, utf8_decode('CONTRATO DE LOCAÇÃO'), 0, 1, 'C', false);
        $this->SetFont('Arial', '', 8);
        $this->Ln(2);
        $this->MultiCell(0, 5, $texto, 0, 1);

        $this->Ln(15);
        $this->Cell(80, 0, '', 1, 0);
        $this->Cell(10, 0, '', 0, 0);
        $this->Cell(80, 0, '', 1, 1);

        $this->Cell(80, 6, utf8_decode('ALICERCE LOCAÇÃO DE EQUIPAMENTOS'), 0, 0, 'C');
        $this->Cell(10, 6, '', 0, 0, 'C');
        $this->Cell(80, 6, utf8_decode($this->cliente['nom_cliente'] . ' (Locatário)'), 0, 1, 'C');
        $this->Ln(5);
        $this->MultiCell(0, 5, $obs_contrato, 0, 1);
    }

    /**
     * Função que monta o cabeçalho básico
     */
    public function bHeader() {
        $empresa = new Alicerce_Model_DbTable_Empresa();
        $empresa = $empresa->getEmpresaDefault();
        if ($this->params != null) {
            $this->SetDrawColor(230);
            $this->Cell(0, 20, '', 1, 0);
            $this->setX(10);
            $this->SetTextColor(0);
            $this->SetFont('Calligrapher', '', 14);
            $this->Cell(0, 10, utf8_decode($empresa['nom_empresa']), 0, 1, 'C', false);
            $this->SetFont('Arial', '', 9);
            $this->Cell(0, 5, utf8_decode($empresa['des_endereco'] . ' - ' . $empresa['des_bairro'] . '  -  CEP:' . $empresa['num_cep'] . '  ' . $empresa['des_cidade'] . '/' . $empresa['des_estado']), 0, 1, 'C', false);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(0, 5, "Fone: " . $empresa['num_fone'] . " Celular: " . $empresa['num_fone2'], 0, 1, 'C', false);
            $this->Ln();
            $this->SetTextColor(0);
        }
    }

    public function bFooter() {
        if ($this->params != null) {
            $this->SetY(-25);
            $this->SetDrawColor(230);
            $this->Cell(0, 0, '', 1, 1);
            $this->SetFont('Arial', 'I', 7);

            $this->Cell(0, 10, utf8_decode('Pág.:' . $this->PageNo()), 0, 1, 'R');
        }
    }

    function Header() {
        $this->AddFont('Calligrapher', '', 'calligra.php');
        $this->bHeader();
    }

    function Footer() {
        $this->bFooter();
    }

    function comprovante($dados_locacao) {
        $this->Ln(2);
        $this->SetFillColor(200);

        $this->Cell(0, 6, utf8_decode('Comprovante de Devolução'), 1, 1, 'C', true);
        $this->Cell(0, 37, '', 1, 0);
        $this->SetX(15);
        $this->Ln(2);

        $this->SetFont('Helvetica', '', 9);
        $this->Cell(25, 5, utf8_decode("Nº do Contrato:"), 0, 0, 'L');
        $this->Cell(25, 5, utf8_decode(str_pad($dados_locacao['cod_locacao'], 8, '0', STR_PAD_LEFT)), 0, 0, 'L');


        $this->Cell(25, 5, utf8_decode("Data do Pedido:"), 0, 0, 'L');
        $this->Cell(20, 5, utf8_decode($this->dataFormat($dados_locacao['dta_locacao'])), 0, 0, 'L');
        $this->Cell(25, 5, utf8_decode("Data da Saída:"), 0, 0, 'L');
        $this->Cell(20, 5, utf8_decode($this->dataFormat($dados_locacao['dta_locacao'])), 0, 0, 'L');
        $this->Cell(25, 5, utf8_decode("Data do Retorno:"), 0, 0, 'L');
        $this->Cell(20, 5, utf8_decode($this->dataFormat($dados_locacao['dta_devolucao'])), 0, 1, 'L');
        $this->Cell(0, 0, '', 1, 1);
        $this->Cell(0, 5, utf8_decode("DADOS DO CLIENTE"), 1, 1, 'C', true);
        $this->setX(10);
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 5, utf8_decode("Cliente: {$dados_locacao['nom_cliente']}"), 0, 1, 'L', false);
        $this->Cell(95, 5, utf8_decode("Endereço: {$dados_locacao['des_endereco']}"), 0, 0, 'L', false);
        $this->Cell(95, 5, utf8_decode("Bairro: {$dados_locacao['des_bairro']}"), 0, 1, 'L', false);
        $this->Cell(95, 5, utf8_decode("CEP: {$dados_locacao['num_cep']}"), 0, 0, 'L', false);
        $this->Cell(55, 5, utf8_decode("Cidade: {$dados_locacao['des_cidade']}"), 0, 0, 'L', false);
        $this->Cell(40, 5, utf8_decode("UF: {$dados_locacao['des_estado']}"), 0, 1, 'L', false);
        $this->Cell(95, 5, utf8_decode("CPF/CNPJ: {$dados_locacao['num_cnpj_cpf']}"), 0, 0, 'L', false);
        $this->Cell(95, 5, utf8_decode("RG/IE: {$dados_locacao['num_rg_ie']}"), 0, 1, 'L', false);
        $this->Cell(95, 5, utf8_decode("Telefone: {$dados_locacao['num_fone']}"), 0, 0, 'L', false);
        $this->Cell(95, 5, utf8_decode("Celular: {$dados_locacao['num_fone2']}"), 0, 1, 'L', false);
        $this->Cell(0, 5, utf8_decode("DADOS DA OBRA"), 1, 1, 'C', true);
        $this->Cell(0, 16, '', 1, 0, 'L', false);
        $this->SetFont('Arial', '', 10);
        $this->setX(10);
        $this->Cell(95, 5, utf8_decode("Endereço: {$dados_locacao['des_endereco_obra']}"), 0, 1, 'L', false);
        $this->Cell(95, 5, utf8_decode("Bairro: {$dados_locacao['des_bairro_obra']}"), 0, 0, 'L', false);
        $this->Cell(95, 5, utf8_decode("CEP: {$dados_locacao['num_cep_obra']}"), 0, 1, 'L', false);
        $this->Cell(95, 5, utf8_decode("Cidade: {$dados_locacao['des_cidade_obra']}"), 0, 0, 'L', false);
        $this->Cell(95, 5, utf8_decode("Estado: {$dados_locacao['des_estado_obra']}"), 0, 1, 'L', false);
        $this->Cell(0, 5, utf8_decode("EQUIPAMENTOS DEVOLVIDOS"), 1, 1, 'C', true);
        $this->SetFillColor(230);
        $this->Cell(20, 5, utf8_decode("Cód"), 1, 0, 'C', true);
        $this->Cell(110, 5, utf8_decode("Descrição do Equipamento"), 1, 0, 'C', true);
        $this->Cell(30, 5, utf8_decode("Qtd. Devolvida"), 1, 0, 'C', true);
        $this->Cell(30, 5, utf8_decode("Data Devolução"), 1, 1, 'C', true);
    }

    public function dataExtenso($data) {
        setlocale(LC_TIME, 'pt_BR.utf8');
        return ucfirst(strftime("%A, %d de %B de %Y", strtotime($data)));
    }

    public function valorPorExtenso($valor = 0, $complemento = true) {
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
                    $z++; elseif ($z > 0)
                    $z--;
                if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
                    $r .= (($z > 1) ? " de " : "") . $plural[$t];
            }
            if ($r)
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        return ucwords($rt ? $rt : "zero");
    }

    private function dataFormat($d) {
        if ($d != '') {
            $dt = explode(" ", $d);
            $dt = explode("-", $dt[0]);
            return $dt[2] . '/' . $dt[1] . '/' . $dt[0];
        }
        else {
            return false;
        }
    }

    public function setResults($result) {
        $this->result = $result;
    }

    public function relatorioCliente($params) {
        $this->params = 'true';
        $this->AliasNbPages();
        $this->AddPage('R');
        $status = array("A" => "Ativos", "I" => "Excluídos", "D" => "Inadimplentes");
        $this->SetFont('Arial', 'I', 8);
        if ($params['cod_cliente'] != '') {
            $this->Cell(50, 5, 'Filtro por Codigo de Cliente: ' . $params['cod_cliente'], 0, 0, 'L');
        }

        if ($params['dta_inicio'] != '') {
            $this->Cell(50, 5, 'Filtro por Data Inicial: ' . $params['dta_inicio'], 0, 0, 'L');
        }
        if ($params['dta_final'] != '') {
            $this->Cell(50, 5, 'Filtro por Data Final: ' . $params['dta_final'], 0, 0, 'L');
        }
        if ($params['ind_status'] != '') {
            $this->Cell(50, 5, utf8_decode('Filtro por Status: ' . $status[$params['ind_status']]), 0, 0, 'L');
        }
        $this->Cell(0, 5, $this->dataExtenso(Date("Y-m-d")), 0, 0, 'R');
        $this->SetX(10);
        $this->Cell(0, 5, '', 1, 1);
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(200);
        $this->Cell(0, 7, utf8_decode('RELATÓRIO DE CLIENTES'), 1, 1, 'C', true);
        $this->SetFillColor(230);
        $this->SetFont('Arial', '', 8);
        $this->Cell(8, 5, '#', 1, 0, 'C', true);
        $this->Cell(55, 5, utf8_decode('Nome/Razão Social'), 1, 0, 'C', true);
        $this->Cell(30, 5, 'CPF/CNPJ', 1, 0, 'C', true);

        $this->Cell(55, 5, utf8_decode('Endereço'), 1, 0, 'C', true);
        $this->Cell(25, 5, utf8_decode('Bairro'), 1, 0, 'C', true);

        $this->Cell(44, 5, utf8_decode('Cidade/UF'), 1, 0, 'C', true);
        $this->Cell(20, 5, utf8_decode('Telefone'), 1, 0, 'C', true);
        $this->Cell(20, 5, utf8_decode('Celular'), 1, 0, 'C', true);
        $this->Cell(20, 5, 'Cadastro', 1, 1, 'C', true);
        if (count($this->result) > 0) {

            foreach ($this->result as $row) {
                if ($row['ind_status'] == 'I') {
                    $this->SetFillColor(200, 160, 150);
                    $this->SetTextColor(255);
                    $fill = true;
                    $cliente++;
                }
                else {
                    $this->SetTextColor(0);
                    $fill = false;
                }
                $total = count($this->result) - $cliente;
                $this->Cell(8, 5, str_pad($row['cod_cliente'], 4, '0', 0), 1, 0, 'L', $fill);
                $this->Cell(55, 5, utf8_decode($row['nom_cliente']), 1, 0, 'L', $fill);
                $this->Cell(30, 5, $row['num_cnpj_cpf'], 1, 0, 'L', $fill);

                $this->Cell(55, 5, utf8_decode($row['des_endereco']), 1, 0, 'L', $fill);
                $this->Cell(25, 5, utf8_decode($row['des_bairro']), 1, 0, 'L', $fill);

                $this->Cell(44, 5, utf8_decode($row['des_cidade'] . '/' . $row['des_estado']), 1, 0, 'L', $fill);
                $this->Cell(20, 5, utf8_decode($row['num_fone'] ? $row['num_fone'] : '-'), 1, 0, 'C', $fill);
                $this->Cell(20, 5, utf8_decode($row['num_fone2'] ? $row['num_fone2'] : '-'), 1, 0, 'C', $fill);
                $this->Cell(20, 5, $this->dataFormat($row['dta_cadastro']), 1, 1, 'C', $fill);
            }
            $this->SetTextColor(0);
            $this->Cell(0, 5, utf8_decode('Total de Clientes: ') . str_pad(count($this->result), 2, '0', 0) . ' | Ativos: ' . str_pad($total, 2, '0', 0), 1, 1, 'R');
        }
        else {
            $this->SetFillColor(200, 10, 10);
            $this->SetTextColor(255);
            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 10, utf8_decode('Não foi encontrado nenhum registro com o filtro especificado!'), 1, 1, C, true);
        }

        $this->Output();
    }

    public function relatorioCoResponsabilidade($params) {
        $this->params = 'true';
        $this->AliasNbPages();
        $this->AddPage('R');
        $status = array("A" => "Ativos", "I" => "Excluídos", "D" => "Inadimplentes");
        $this->SetFont('Arial', 'I', 8);
        if ($params['cod_cliente'] != '') {
            $this->Cell(50, 5, 'Filtro por Codigo de Cliente: ' . $params['cod_cliente'], 0, 0, 'L');
        }
        if ($params['cod_co_responsabilidade'] != '') {
            $this->Cell(50, 5, 'Filtro por Codigo de Responsavel: ' . $params['cod_co_responsabilidade'], 0, 0, 'L');
        }
        if ($params['dta_inicio'] != '') {
            $this->Cell(50, 5, 'Filtro por Data Inicial: ' . $params['dta_inicio'], 0, 0, 'L');
        }
        if ($params['dta_final'] != '') {
            $this->Cell(50, 5, 'Filtro por Data Final: ' . $params['dta_final'], 0, 0, 'L');
        }
        if ($params['ind_status'] != '') {
            $this->Cell(50, 5, utf8_decode('Filtro por Status: ' . $status[$params['ind_status']]), 0, 0, 'L');
        }
        $this->Cell(0, 5, $this->dataExtenso(Date("Y-m-d")), 0, 0, 'R');
        $this->SetX(10);
        $this->Cell(0, 5, '', 1, 1);
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(200);
        $this->Cell(0, 7, utf8_decode('RELATÓRIO DE CO-RESPONSABILIDADE'), 1, 1, 'C', true);
        $this->SetFillColor(230);
        $this->SetFont('Arial', '', 8);
        $this->Cell(8, 5, '#', 1, 0, 'C', true);
        $this->Cell(50, 5, utf8_decode('Nome/Razão Social'), 1, 0, 'C', true);
        $this->Cell(30, 5, 'CPF/CNPJ', 1, 0, 'C', true);

        $this->Cell(55, 5, utf8_decode('Endereço'), 1, 0, 'C', true);


        $this->Cell(44, 5, utf8_decode('Cidade/UF'), 1, 0, 'C', true);
        $this->Cell(20, 5, utf8_decode('Telefone'), 1, 0, 'C', true);
        $this->Cell(50, 5, utf8_decode('Resposável Por'), 1, 0, 'C', true);
        $this->Cell(20, 5, 'Cadastro', 1, 1, 'C', true);
        if (count($this->result) > 0) {
            foreach ($this->result as $row) {


                if ($row['ind_status'] == 'I') {
                    $this->SetFillColor(200, 160, 150);
                    $this->SetTextColor(255);
                    $fill = true;
                }
                else {
                    $this->SetTextColor(0);
                    $fill = false;
                }
                $this->Cell(8, 5, str_pad($row['cod_cliente'], 4, '0', 0), 1, 0, 'L', $fill);
                $this->Cell(50, 5, utf8_decode($row['nom_cliente']), 1, 0, 'L', $fill);
                $this->Cell(30, 5, $row['num_cnpj_cpf'], 1, 0, 'L', $fill);

                $this->Cell(55, 5, utf8_decode($row['des_endereco']), 1, 0, 'L', $fill);


                $this->Cell(44, 5, utf8_decode($row['des_cidade'] . '/' . $row['des_estado']), 1, 0, 'L', $fill);
                $this->Cell(20, 5, utf8_decode($row['num_fone'] ? $row['num_fone'] : '-'), 1, 0, 'C', $fill);
                $this->Cell(50, 5, utf8_decode($row['nom_cliente_responsavel']), 1, 0, 'C', $fill);
                $this->Cell(20, 5, $this->dataFormat($row['dta_cadastro']), 1, 1, 'C', $fill);
            }
            $this->SetTextColor(0);
            $this->Cell(0, 5, utf8_decode('Total de Clientes Responsáveis: ') . str_pad(count($this->result), 4, '0', 0), 1, 1, 'R');
        }
        else {
            $this->SetFillColor(200, 10, 10);
            $this->SetTextColor(255);
            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 10, utf8_decode('Não foi encontrado nenhum registro com o filtro especificado!'), 1, 1, C, true);
        }

        $this->Output();
    }

    public function relatorioCobranca($params) {
        $this->params = 'true';
        $this->AliasNbPages();
        $this->AddPage('R');
        $status = array("A" => "Ativos", "I" => "Excluídos");
        $this->SetFont('Arial', 'I', 8);
        if ($params['cod_cliente'] != '')
            $this->Cell(50, 5, 'Filtro por Codigo de Cliente: ' . $params['cod_cliente'], 0, 0, 'L');
        if ($params['ind_status'] != '')
            $this->Cell(50, 5, utf8_decode('Filtro por Status: ' . $status[$params['ind_status']]), 0, 0, 'L');
        $this->Cell(0, 5, $this->dataExtenso(Date("Y-m-d")), 0, 0, 'R');
        $this->SetX(10);
        $this->Cell(0, 5, '', 1, 1);
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(200);
        $this->Cell(0, 7, utf8_decode('RELATÓRIO DE ENDEREÇO DE COBRANÇA'), 1, 1, 'C', true);
        $this->SetFillColor(230);
        $this->SetFont('Arial', '', 8);
        $this->Cell(8, 5, '#', 1, 0, 'C', true);
        $this->Cell(60, 5, utf8_decode('Nome/Razão Social'), 1, 0, 'C', true);
        $this->Cell(60, 5, utf8_decode('Endereço'), 1, 0, 'C', true);
        $this->Cell(40, 5, utf8_decode('Bairro'), 1, 0, 'C', true);
        $this->Cell(25, 5, utf8_decode('CEP'), 1, 0, 'C', true);
        $this->Cell(44, 5, utf8_decode('Cidade/UF'), 1, 0, 'C', true);
        $this->Cell(20, 5, utf8_decode('Telefone'), 1, 0, 'C', true);
        $this->Cell(20, 5, utf8_decode('Celular'), 1, 1, 'C', true);

        if (count($this->result) > 0) {
            foreach ($this->result as $row) {
                $this->Cell(8, 5, str_pad($row['cod_cliente'], 4, '0', 0), 1, 0, 'L', false);
                $this->Cell(60, 5, utf8_decode($row['nom_cliente']), 1, 0, 'L', false);
                $this->Cell(60, 5, utf8_decode($row['des_endereco']), 1, 0, 'L', false);
                $this->Cell(40, 5, utf8_decode($row['des_bairro']), 1, 0, 'L', false);
                $this->Cell(25, 5, utf8_decode($row['num_cep']), 1, 0, 'C', false);

                $this->Cell(44, 5, utf8_decode($row['des_cidade'] . '/' . $row['des_estado']), 1, 0, 'L', false);
                $this->Cell(20, 5, utf8_decode($row['num_fone'] ? $row['num_fone'] : '-'), 1, 0, 'C', false);
                $this->Cell(20, 5, utf8_decode($row['num_fone2'] ? $row['num_fone2'] : '-'), 1, 1, 'C', false);
            }
            $this->Cell(0, 5, utf8_decode('Total de Endereços: ') . str_pad(count($this->result), 4, '0', 0), 1, 1, 'R');
        }
        else {
            $this->SetFillColor(200, 10, 10);
            $this->SetTextColor(255);
            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 10, utf8_decode('Não foi encontrado nenhum registro com o filtro especificado!'), 1, 1, C, true);
        }

        $this->Output();
    }

    public function relatorioObra($params) {
        $this->params = 'true';
        $this->AliasNbPages();
        $this->AddPage('R');
        $status = array("A" => "Ativos", "I" => "Excluídos", "C" => "Concluídos");
        $this->SetFont('Arial', 'I', 8);
        if ($params['cod_cliente'] != '')
            $this->Cell(50, 5, 'Filtro por Codigo de Cliente: ' . $params['cod_cliente'], 0, 0, 'L');

        if ($params['cod_co_responsabilidade'] != '')
            $this->Cell(50, 5, 'Filtro por Codigo de Responsavel: ' . $params['cod_co_responsabilidade'], 0, 0, 'L');

        if ($params['dta_inicio'] != '')
            $this->Cell(50, 5, 'Filtro por Data Inicial: ' . $params['dta_inicio'], 0, 0, 'L');

        if ($params['dta_final'] != '')
            $this->Cell(50, 5, 'Filtro por Data Final: ' . $params['dta_final'], 0, 0, 'L');

        if ($params['ind_status'] != '')
            $this->Cell(50, 5, utf8_decode('Filtro por Status: ' . $status[$params['ind_status']]), 0, 0, 'L');

        $this->Cell(0, 5, $this->dataExtenso(Date("Y-m-d")), 0, 0, 'R');
        $this->SetX(10);
        $this->Cell(0, 5, '', 1, 1);
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(200);
        $this->Cell(0, 7, utf8_decode('RELATÓRIO DE OBRAS'), 1, 1, 'C', true);
        $this->SetFillColor(230);
        $this->SetFont('Arial', '', 8);
        $this->Cell(8, 5, '#', 1, 0, 'C', true);
        $this->Cell(55, 5, utf8_decode('Cliente'), 1, 0, 'C', true);
        $this->Cell(30, 5, utf8_decode('Obra'), 1, 0, 'C', true);
        $this->Cell(50, 5, utf8_decode('Endereço'), 1, 0, 'C', true);
        $this->Cell(30, 5, utf8_decode('Bairro'), 1, 0, 'C', true);
        $this->Cell(25, 5, utf8_decode('CEP'), 1, 0, 'C', true);
        $this->Cell(39, 5, utf8_decode('Cidade/UF'), 1, 0, 'C', true);
        $this->Cell(20, 5, utf8_decode('Data Inicio'), 1, 0, 'C', true);
        $this->Cell(20, 5, utf8_decode('Data Término'), 1, 1, 'C', true);

        if (count($this->result) > 0) {
            foreach ($this->result as $row) {
                $this->Cell(8, 5, str_pad($row['cod_cliente'], 4, '0', 0), 1, 0, 'L', false);
                $this->Cell(55, 5, utf8_decode($row['nom_cliente']), 1, 0, 'L', false);
                $this->Cell(30, 5, utf8_decode($row['des_obra']), 1, 0, 'L', false);
                $this->Cell(50, 5, utf8_decode($row['des_endereco']), 1, 0, 'L', false);
                $this->Cell(30, 5, utf8_decode($row['des_bairro']), 1, 0, 'L', false);
                $this->Cell(25, 5, utf8_decode($row['num_cep']), 1, 0, 'C', false);

                $this->Cell(39, 5, utf8_decode($row['des_cidade'] . '/' . $row['des_estado']), 1, 0, 'L', false);
                $this->Cell(20, 5, utf8_decode($this->dataFormat($row['dta_inicio']) ? $this->dataFormat($row['dta_inicio']) : '-'), 1, 0, 'C', false);
                $this->Cell(20, 5, utf8_decode($this->dataFormat($row['dta_termino']) ? $this->dataFormat($row['dta_termino']) : '-'), 1, 1, 'C', false);
            }
            $this->Cell(0, 5, utf8_decode('Total de Obras: ') . str_pad(count($this->result), 4, '0', 0), 1, 1, 'R');
        }
        else {
            $this->SetFillColor(200, 10, 10);
            $this->SetTextColor(255);
            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 10, utf8_decode('Não foi encontrado nenhum registro com o filtro especificado!'), 1, 1, C, true);
        }

        $this->Output();
    }

    function RoundedRect($x, $y, $w, $h, $r, $corners = '1234', $style = '') {
        $k = $this->k;
        $hp = $this->h;
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));

        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));
        if (strpos($corners, '2') === false)
            $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $y) * $k));
        else
            $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);

        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
        if (strpos($corners, '3') === false)
            $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - ($y + $h)) * $k));
        else
            $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
        if (strpos($corners, '4') === false)
            $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - ($y + $h)) * $k));
        else
            $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);

        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k));
        if (strpos($corners, '1') === false) {
            $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $y) * $k));
            $this->_out(sprintf('%.2F %.2F l', ($x + $r) * $k, ($hp - $y) * $k));
        }
        else
            $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3) {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1 * $this->k, ($h - $y1) * $this->k, $x2 * $this->k, ($h - $y2) * $this->k, $x3 * $this->k, ($h - $y3) * $this->k));
    }

}

?>