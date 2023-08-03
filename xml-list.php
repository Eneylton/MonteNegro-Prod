<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Session\Login;
use App\File\Xml;


define('TITLE', 'Importação XML');
define('BRAND', 'XML');


$usuariologado = Login::getUsuarioLogado();

$usuario_id = $usuarios_id = $usuariologado['id'];
$usuario    = $usuarios_id = $usuariologado['nome'];

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


if (isset($_FILES['arquivo'])) {
    $obUpload = new Xml($_FILES['arquivo']);
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


                $chave = $xml->NFe->infNFe->attributes()->Id;
                $chave = strtr(strtoupper($chave), array("NFE" => NULL));
                $cUF = $xml->NFe->infNFe->ide->cUF;
                $cNF = $xml->NFe->infNFe->ide->cNF;
                $natOp = $xml->NFe->infNFe->ide->natOp;
                $indPag = $xml->NFe->infNFe->ide->indPag;
                $mod = $xml->NFe->infNFe->ide->mod;
                $serie = $xml->NFe->infNFe->ide->serie;
                $nNF =  $xml->NFe->infNFe->ide->nNF;
                //$dEmi = $xml->NFe->infNFe->ide->dEmi;  
                //$dEmi = explode('-', $dEmi);
                //$dEmi = $dEmi[2]."/".$dEmi[1]."/".$dEmi[0];
                //$dSaiEnt = $xml->NFe->infNFe->ide->dSaiEnt; 
                //$dSaiEnt = explode('-', $dSaiEnt);
                //$dSaiEnt = $dSaiEnt[2]."/".$dSaiEnt[1]."/"
                $tpNF = $xml->NFe->infNFe->ide->tpNF;
                $cMunFG = $xml->NFe->infNFe->ide->cMunFG;
                $tpImp = $xml->NFe->infNFe->ide->tpImp;
                $tpEmis = $xml->NFe->infNFe->ide->tpEmis;
                $cDV = $xml->NFe->infNFe->ide->cDV;
                $tpAmb = $xml->NFe->infNFe->ide->tpAmb;

                $emit_CPF = $xml->NFe->infNFe->emit->CPF;
                $emit_CNPJ = $xml->NFe->infNFe->emit->CNPJ;
                $emit_xNome = $xml->NFe->infNFe->emit->xNome;
                $emit_xFant = $xml->NFe->infNFe->emit->xFant;
                //<enderEmit>
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
                //</enderEmit>
                $emit_IE = $xml->NFe->infNFe->emit->IE;
                $emit_IM = $xml->NFe->infNFe->emit->IM;
                $emit_CNAE = $xml->NFe->infNFe->emit->CNAE;

                $dest_cnpj =  $xml->NFe->infNFe->dest->CNPJ;

                $dest_xNome = $xml->NFe->infNFe->dest->xNome;

                $dest_xLgr = $xml->NFe->infNFe->dest->enderDest->xLgr;
                $dest_nro =  $xml->NFe->infNFe->dest->enderDest->nro;
                $dest_xBairro = $xml->NFe->infNFe->dest->enderDest->xBairro;
                $dest_cMun = $xml->NFe->infNFe->dest->enderDest->cMun;
                $dest_xMun = $xml->NFe->infNFe->dest->enderDest->xMun;
                $dest_UF = $xml->NFe->infNFe->dest->enderDest->UF;
                $dest_CEP = $xml->NFe->infNFe->dest->enderDest->CEP;
                $dest_cPais = $xml->NFe->infNFe->dest->enderDest->cPais;
                $dest_xPais = $xml->NFe->infNFe->dest->enderDest->xPais;

                $dest_IE = $xml->NFe->infNFe->dest->IE;

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
            }

            if ($tpAmb != 1) {
                echo "<h4>Documento emitido em ambiente de homologado!</h4>";
                exit;
            }
            $finNFe  = $xml->NFe->infNFe->ide->finNFe;
            $procEmi = $xml->NFe->infNFe->ide->procEmi;
            $verProc = $xml->NFe->infNFe->ide->verProc;

            $xMotivo = $xml->protNFe->infProt->xMotivo;
            $nProt   = $xml->protNFe->infProt->nProt;
        }
    }
}

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/xml/xml-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';
