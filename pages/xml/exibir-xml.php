<?php

require __DIR__.'../../../vendor/autoload.php';

use App\Session\Login;
use App\File\Xml;

$usuariologado = Login:: getUsuarioLogado();

$usuario_id = $usuarios_id = $usuariologado['id'];
$usuario    = $usuarios_id = $usuariologado['nome'];

if(isset($_FILES['arquivo'])){
    $obUpload = new Xml ($_FILES['arquivo']);
    $sucesso = $obUpload->upload(__DIR__.'../../../xml',false);
    $obUpload->gerarNovoNome();
    
    $xml = $obUpload->getBasename();

    if($sucesso){

    $chave = $xml;

	if (isset($_POST['chave']))
		$chave = $_POST['chave'];
	if (isset($_GET['chave']))
		$chave = $_GET['chave'];
	
	
	if ($chave)
	{
		if ($chave == '')
		{
			echo "<h4>Informe a chave de acesso!</h4>";
			exit;	
		}	
		$arquivo = "../../xml/".$chave;	
		if (file_exists($arquivo)) 
		{
			 $arquivo = $arquivo;
			$xml = simplexml_load_file($arquivo);
			// imprime os atributos do objeto criado
			
			if (empty($xml->protNFe->infProt->nProt))
			{
				echo "<h4>Arquivo sem dados de autorizao!</h4>";
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
            

        }

	if ($tpAmb != 1)
	{
		echo "<h4>Documento emitido em ambiente de homologao!</h4>";
		exit;	
	}
	$finNFe = $xml->NFe->infNFe->ide->finNFe;     //<finNFe>1</finNFe>
	$procEmi = $xml->NFe->infNFe->ide->procEmi;   //<procEmi>0</procEmi>
	$verProc = $xml->NFe->infNFe->ide->verProc;   //<verProc>2.0.0</verProc>
//</ide>
	$xMotivo = $xml->protNFe->infProt->xMotivo;	
	$nProt = $xml->protNFe->infProt->nProt;
	
}

}

}

?>



