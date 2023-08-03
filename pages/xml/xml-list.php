<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\ControlEnvio;
use App\Entidy\Destinatario;
use App\Entidy\Importacao;
use App\Entidy\NotaFiscal;
use App\Entidy\Produto;
use App\Entidy\Receber;
use App\File\Upload;
use App\Session\Login;


define('TITLE', 'Importação XML - Nota Fiscal Eletrônica');
define('BRAND', 'XML');

$usuariologado = Login::getUsuarioLogado();

$usuario_id = $usuarios_id = $usuariologado['id'];
$usuario    = $usuarios_id = $usuariologado['nome'];

$contador = 0;
$i = 0;

$chave            = "";
$chave            = "";
$cUF              = "";
$cNF              = "";
$natOp            = "";
$indPag           = "";
$mod              = "";
$serie            = "";
$nNF              = "";
$tpNF =            "";
$cMunFG =          "";
$tpImp =           "";
$tpEmis =          "";
$cDV =             "";
$tpAmb =           "";
$emit_CPF =        "";
$emit_CNPJ =       "";
$emit_xNome =      "";
$emit_xFant =      "";
$emit_xLgr =       "";
$emit_nro =        "";
$emit_xBairro =    "";
$emit_cMun =       "";
$emit_xMun =       "";
$emit_UF =         "";
$emit_CEP =        "";
$emit_cPais =      "";
$emit_xPais =      "";
$emit_fone =       "";
$emit_IE =         "";
$emit_IM =         "";
$emit_CNAE =       "";
$dest_cnpj =       "";
$dest_xNome =      "";
$dest_xLgr =       "";
$dest_nro =        "";
$dest_xBairro =    "";
$dest_cMun =       "";
$dest_xMun =       "";
$dest_UF =         "";
$dest_CEP =        "";
$dest_cPais =      "";
$dest_xPais =      "";
$dest_IE =         "";
$vBC =             "";
$vBC =             "";
$vICMS =           "";
$vICMS =           "";
$vBCST =           "";
$vBCST =           "";
$vST =             "";
$vST =             "";
$vProd =           "";
$vProd =           "";
$vNF =             "";
$vNF =             "";
$vFrete =          "";
$vSeg =            "";
$vDesc =           "";
$vIPI =            "";
$nProt =           "";

date_default_timezone_set('America/Sao_Paulo');
$data = date('Y-m-d H:i:s');

if (isset($_FILES['arquivo'])) {

    $uploads = Upload::createMultpleUpload($_FILES['arquivo']);

    foreach ($uploads as $obUpload) {
        $i += 1;
        $sucesso = $obUpload->upload(__DIR__ . '../../../xml', false);
        $obUpload->gerarNovoNome();

        $param = $obUpload->getBasename();

        if ($sucesso) {

            $chave = $param;

            if (isset($_POST['chave']))
                $chave = $_POST['chave'];
            if (isset($_GET['chave']))
                $chave = $_GET['chave'];


            if ($chave) {
                if ($chave == '') {
                    echo "<h4>Informe a chave de acesso!</h4>";
                    exit;
                }
                $arquivo = "../../xml/" . $chave;
                if (file_exists($arquivo)) {
                    $arquivo = $arquivo;
                    $xml = simplexml_load_file($arquivo);
                    // imprime os atributos do objeto criado

                    if (empty($xml->protNFe->infProt->nProt)) {
                        echo "<h1>ACESSO NEGADO ARQUIVO CT-e ... ADICIONE UM ARQUIVO NF-e!</h1>";

                        exit;
                    }

                    //NOTAFISCAL// 

                    $chave = $xml->NFe->infNFe->attributes()->Id;
                    $chave = strtr(strtoupper($chave), array("NFE" => NULL));
                    $cUF = $xml->NFe->infNFe->ide->cUF;
                    $cNF = $xml->NFe->infNFe->ide->cNF;
                    $natOp = $xml->NFe->infNFe->ide->natOp;
                    $indPag = $xml->NFe->infNFe->ide->indPag;
                    $mod = $xml->NFe->infNFe->ide->mod;
                    $serie = $xml->NFe->infNFe->ide->serie;
                    $nNF =  $xml->NFe->infNFe->ide->nNF;
                    $tpNF = $xml->NFe->infNFe->ide->tpNF;
                    $cMunFG = $xml->NFe->infNFe->ide->cMunFG;
                    $tpImp = $xml->NFe->infNFe->ide->tpImp;
                    $tpEmis = $xml->NFe->infNFe->ide->tpEmis;
                    $cDV = $xml->NFe->infNFe->ide->cDV;
                    $tpAmb = $xml->NFe->infNFe->ide->tpAmb;
                    $vBC = $xml->NFe->infNFe->total->ICMSTot->vBC;
                    $vBC = number_format((float) $vBC, 2, ",", ".");
                    $vICMS = $xml->NFe->infNFe->total->ICMSTot->vICMS;
                    $vICMS = number_format((float) $vICMS, 2, ",", ".");
                    $vBCST = $xml->NFe->infNFe->total->ICMSTot->vBCST;
                    $vBCST = number_format((float) $vBCST, 2, ",", ".");
                    $vST = $xml->NFe->infNFe->total->ICMSTot->vST;
                    $vST = number_format((float) $vST, 2, ",", ".");
                    $vProd = $xml->NFe->infNFe->total->ICMSTot->vProd;
                    $vProd = number_format((float) $vProd, 2, ",", ".");
                    $vNF = $xml->NFe->infNFe->total->ICMSTot->vNF;
                    $vNF = number_format((float) $vNF, 2, ",", ".");
                    $vFrete = number_format((float) $xml->NFe->infNFe->total->ICMSTot->vFrete, 2, ",", ".");
                    $vSeg = number_format((float)   $xml->NFe->infNFe->total->ICMSTot->vSeg, 2, ",", ".");
                    $vDesc = number_format((float) $xml->NFe->infNFe->total->ICMSTot->vDesc, 2, ",", ".");
                    $vIPI = number_format((float) $xml->NFe->infNFe->total->ICMSTot->vIPI, 2, ",", ".");

                    //EMISSOR //

                    $emit_CNPJ = $xml->NFe->infNFe->emit->CNPJ;
                    $emit_xNome = $xml->NFe->infNFe->emit->xNome;
                    $emit_xFant = $xml->NFe->infNFe->emit->xFant;
                    $emit_xLgr = $xml->NFe->infNFe->emit->enderEmit->xLgr;
                    $emit_nro = $xml->NFe->infNFe->emit->enderEmit->nro;
                    $emit_xBairro = $xml->NFe->infNFe->emit->enderEmit->xBairro;
                    $emit_cMun = $xml->NFe->infNFe->emit->enderEmit->cMun;
                    $emit_xMun = $xml->NFe->infNFe->emit->enderEmit->xMun;
                    $emit_UF = $xml->NFe->infNFe->emit->enderEmit->UF;
                    $emit_CEP = $xml->NFe->infNFe->emit->enderEmit->CEP;
                    $emit_cPais = $xml->NFe->infNFe->emit->enderEmit->cPais;
                    $emit_xPais = $xml->NFe->infNFe->emit->enderEmit->xPais;
                    $emit_fone = $xml->NFe->infNFe->emit->enderEmit->fone;
                    $emit_IE = $xml->NFe->infNFe->emit->IE;
                    $emit_IM = $xml->NFe->infNFe->emit->IM;
                    $emit_CNAE = $xml->NFe->infNFe->emit->CNAE;

                    //DESTINATÁRIO//

                    $dest_xNome = $xml->NFe->infNFe->dest->xNome;
                    $dest_xLgr = $xml->NFe->infNFe->dest->enderDest->xLgr;
                    $dest_nro =  $xml->NFe->infNFe->dest->enderDest->nro;
                    $dest_cpf =  $xml->NFe->infNFe->dest->CPF;
                    $dest_xBairro = $xml->NFe->infNFe->dest->enderDest->xBairro;
                    $dest_cMun = $xml->NFe->infNFe->dest->enderDest->cMun;
                    $dest_xMun = $xml->NFe->infNFe->dest->enderDest->xMun;
                    $dest_UF = $xml->NFe->infNFe->dest->enderDest->UF;
                    $dest_CEP = $xml->NFe->infNFe->dest->enderDest->CEP;
                    $dest_cPais = $xml->NFe->infNFe->dest->enderDest->cPais;
                    $dest_xPais = $xml->NFe->infNFe->dest->enderDest->xPais;
                    $dest_xTelefonw = $xml->NFe->infNFe->dest->enderDest->fone;
                    $dest_email = $xml->NFe->infNFe->dest->email;
                    $dest_IE = $xml->NFe->infNFe->dest->IE;

                    // PRODUTOS //

                    $finNFe  = $xml->NFe->infNFe->ide->finNFe;
                    $procEmi = $xml->NFe->infNFe->ide->procEmi;
                    $verProc = $xml->NFe->infNFe->ide->verProc;
                    $xMotivo = $xml->protNFe->infProt->xMotivo;
                    $nProt   = $xml->protNFe->infProt->nProt;
                }

                if (isset($chave)) {

                    $item = new NotaFiscal;
                    $item->valoricms            = $vICMS;
                    $item->data                 = $data;
                    $item->chave                = $chave;
                    $item->autorizacao          = $nProt;
                    $item->notafiscal           = $nNF;
                    $item->serie                = $serie;
                    $item->razaosocial          = $emit_xFant;
                    $item->cnpj                 = $emit_CNPJ;
                    $item->inscricaoestadual    = $emit_IE;
                    $item->bcicms               = $vBCST;
                    $item->totalproduto         = $vProd;
                    $item->frete                = $vFrete;
                    $item->desconto             = $vFrete;
                    $item->totalipi             = $vIPI;
                    $item->totalnota            = $vNF;
                    $item->usuarios_id          = $usuario_id;

                    $item->cadastar();

                    $notaID = $item->id;

                    $import = new Importacao;
                    $import->data                 = $data;
                    $import->notafiscal           = $chave;
                    $import->serie                = $serie;
                    $import->razaosocial          = $emit_xFant;
                    $import->notafiscal_id        = $notaID;
                    $import->cadastar();
                }

                $consultor = Destinatario::getIDCpf('*', 'destinatario', $dest_cpf, null, null, null);

                if ($consultor != false) {

                    $destID = $consultor->id;
                } else {
                    $dest = new Destinatario;
                    $dest->cpf            = $dest_cpf;
                    $dest->nome           = $dest_xNome;
                    $dest->logradouro     = $dest_xLgr;
                    $dest->numero         = $dest_nro;
                    $dest->bairro         = $dest_xBairro;
                    $dest->municipio      = $dest_xMun;
                    $dest->uf             = $dest_UF;
                    $dest->cep            = $dest_CEP;
                    $dest->pais           = $dest_xPais;
                    $dest->telefone       = $dest_xTelefonw;
                    $dest->email          = $dest_email;
                    $dest->notafiscal_id  = $notaID;
                    $dest->cadastar();

                    $destID = $dest->id;
                }


                $control = new ControlEnvio;
                $control->data               = $data;
                $control->notafiscal         = $nNF;
                $control->serie              = $serie;
                $control->consultora         = $dest_xNome;
                $control->status             = 1;
                $control->notafiscal_id      = $notaID;
                $control->destinatario_id    = $destID;
                $control->ocorrencias_id     = 29;
                $control->entregadores_id    = 195;

                $control->cadastar();

                $controlID = $control->id;


                if (isset($xml->NFe->infNFe->det) != "") {

                    $listar = $xml->NFe->infNFe->det;

                    if (isset($listar) != "") {

                        foreach ($listar as $item) {
                            $contador += 1;

                            $codigo       = strval($item->prod->cProd);
                            $xProd        = strval($item->prod->xProd);
                            $NCM          = strval($item->prod->NCM);
                            $CFOP         = strval($item->prod->CFOP);
                            $uCom         = strval($item->prod->uCom);
                            $qCom         = strval($item->prod->qCom);
                            $qCom         = number_format((float) $qCom, 2, ",", ".");
                            $vUnCom       = strval($item->prod->vUnCom);
                            $vUnCom       = number_format((float) $vUnCom, 2, ",", ".");
                            $vProd        = strval($item->prod->vProd);
                            $vProd        = number_format((float) $vProd, 2, ",", ".");
                            $vBC_item     = $item->imposto->ICMS->ICMS00->vBC;
                            $icms00       = $item->imposto->ICMS->ICMS00;
                            $icms10       = $item->imposto->ICMS->ICMS10;
                            $icms20       = $item->imposto->ICMS->ICMS20;
                            $icms30       = $item->imposto->ICMS->ICMS30;
                            $icms40       = $item->imposto->ICMS->ICMS40;
                            $icms50       = $item->imposto->ICMS->ICMS50;
                            $icms51       = $item->imposto->ICMS->ICMS51;
                            $icms60       = $item->imposto->ICMS->ICMS60;
                            $ICMSSN102    = $item->imposto->ICMS->ICMSSN102;

                            $itemproduto = new Produto;
                            $itemproduto->data              = $data;
                            $itemproduto->codigo            = $codigo;
                            $itemproduto->nome              = $xProd;
                            $itemproduto->ncm               = $NCM;
                            $itemproduto->cfop              = $CFOP;
                            $itemproduto->un                = $vUnCom;
                            $itemproduto->qtd               = $qCom;
                            $itemproduto->valor_uni         = $uCom;
                            $itemproduto->bc_icms           = 0;
                            $itemproduto->valor_prod        = $vProd;
                            $itemproduto->valor_icms        = 0;
                            $itemproduto->valor_ipi         = 0;
                            $itemproduto->ipi               = 0;
                            $itemproduto->icms              = 0;
                            $itemproduto->categorias_id     = 1;
                            $itemproduto->notafiscal_id     = $notaID;
                            $itemproduto->destinatario_id   = $destID;

                            $itemproduto->cadastar();
                        }
                    }
                }
            }
        }
    }

    $numero_de_bytes = 4;

    $restultado_bytes = random_bytes($numero_de_bytes);
    $codigo = bin2hex($restultado_bytes);


    $receber = new Receber;
    $receber->data          =  $data;
    $receber->vencimento    =  $data;
    $receber->coleta        =  null;
    $receber->qtd           =  $i;
    $receber->disponivel    =  $i;
    $receber->numero        =  "Remessa - " . $codigo;
    $receber->clientes_id   =  25;
    $receber->gaiolas_id    =  117;
    $receber->usuarios_id   =  $usuario_id;
    $receber->servicos_id   =  7;
    $receber->setores_id    =  1;

    $receber->cadastar();

    header('location: xml-list.php');

    exit;
}

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/xml/xml-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';
