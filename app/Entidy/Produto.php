<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Produto
{

    public $id;
    public $data;
    public $codigo;
    public $nome;
    public $ncm;
    public $cfop;
    public $un;
    public $qtd;
    public $valor_uni;
    public $bc_icms;
    public $valor_prod;
    public $valor_icms;
    public $valor_ipi;
    public $icms;
    public $ipi;
    public $categorias_id;
    public $notafiscal_id;
    public $destinatario_id;






    public function cadastar()
    {


        $obdataBase = new Database('produtos');

        $this->id = $obdataBase->insert([

            'data'                   => $this->data,
            'codigo'                 => $this->codigo,
            'nome'                   => $this->nome,
            'ncm'                    => $this->ncm,
            'cfop'                   => $this->cfop,
            'un'                     => $this->un,
            'qtd'                    => $this->qtd,
            'valor_uni'              => $this->valor_uni,
            'bc_icms'                => $this->bc_icms,
            'valor_prod'             => $this->valor_prod,
            'valor_icms'             => $this->valor_icms,
            'valor_ipi'              => $this->valor_ipi,
            'icms'                   => $this->icms,
            'ipi'                    => $this->ipi,
            'destinatario_id'        => $this->destinatario_id,
            'categorias_id'          => $this->categorias_id,
            'notafiscal_id'          => $this->notafiscal_id

        ]);

        return true;
    }


    public function atualizar()
    {
        return (new Database('produtos'))->update('id = ' . $this->id, [

            'data'                   => $this->data,
            'codigo'                 => $this->codigo,
            'nome'                   => $this->nome,
            'ncm'                    => $this->ncm,
            'cfop'                   => $this->cfop,
            'un'                     => $this->un,
            'qtd'                    => $this->qtd,
            'valor_uni'              => $this->valor_uni,
            'bc_icms'                => $this->bc_icms,
            'valor_prod'             => $this->valor_prod,
            'valor_icms'             => $this->valor_icms,
            'valor_ipi'              => $this->valor_ipi,
            'icms'                   => $this->icms,
            'ipi'                    => $this->ipi,
            'destinatario_id'        => $this->destinatario_id,
            'categorias_id'          => $this->categorias_id,
            'notafiscal_id'          => $this->notafiscal_id

        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('produtos'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('produtos'))->select('COUNT(*) as qtd', 'produtos', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('produtos'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }
    public static function getIDProdutos($fields, $table, $where, $order, $limit)
    {
        return (new Database('produtos'))->select($fields, $table, 'notafiscal_id = ' . $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getModalID($fields, $table, $where, $order, $limit)
    {
        return (new Database('produtos'))->select($fields, $table, $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public function excluir()
    {
        return (new Database('produtos'))->delete('id = ' . $this->id);
    }

    public static function getUsuarioPorEmail($email)
    {

        return (new Database('produtos'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
