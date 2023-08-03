<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class NotaFiscal
{

    public $id;
    public $valoricms;
    public $data;
    public $chave;
    public $autorizacao;
    public $notafiscal;
    public $serie;
    public $razaosocial;
    public $cnpj;
    public $inscricaoestadual;
    public $bcicms;
    public $totalproduto;
    public $frete;
    public $desconto;
    public $totalipi;
    public $totalnota;
    public $usuarios_id;

    public function cadastar()
    {


        $obdataBase = new Database('notafiscal');

        $this->id = $obdataBase->insert([

            'id'                      => $this->id,
            'valoricms'               => $this->valoricms,
            'data'                    => $this->data,
            'chave'                   => $this->chave,
            'autorizacao'             => $this->autorizacao,
            'notafiscal'              => $this->notafiscal,
            'serie'                   => $this->serie,
            'razaosocial'             => $this->razaosocial,
            'cnpj'                    => $this->cnpj,
            'inscricaoestadual'       => $this->inscricaoestadual,
            'bcicms'                  => $this->bcicms,
            'totalproduto'            => $this->totalproduto,
            'frete'                   => $this->frete,
            'desconto'                => $this->desconto,
            'totalipi'                => $this->totalipi,
            'totalnota'               => $this->totalnota,
            'usuarios_id'             => $this->usuarios_id

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('notafiscal'))->update('id = ' . $this->id, [

            'id'                      => $this->id,
            'valoricms'               => $this->valoricms,
            'data'                    => $this->data,
            'chave'                   => $this->chave,
            'autorizacao'             => $this->autorizacao,
            'notafiscal'              => $this->notafiscal,
            'serie'                   => $this->serie,
            'razaosocial'             => $this->razaosocial,
            'cnpj'                    => $this->cnpj,
            'inscricaoestadual'       => $this->inscricaoestadual,
            'bcicms'                  => $this->bcicms,
            'totalproduto'            => $this->totalproduto,
            'frete'                   => $this->frete,
            'desconto'                => $this->desconto,
            'totalipi'                => $this->totalipi,
            'totalnota'               => $this->totalnota,
            'usuarios_id'             => $this->usuarios_id
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('notafiscal'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('notafiscal'))->select('COUNT(*) as qtd', 'notafiscal', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('notafiscal'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }
    public static function getIDChave($fields, $table, $where, $order, $limit)
    {
        return (new Database('notafiscal'))->select($fields, $table, 'chave = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('notafiscal'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('notafiscal'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
