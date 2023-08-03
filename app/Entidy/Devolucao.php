<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Devolucao
{


    public $id;
    public $data;
    public $qtd;
    public $producao_id;
    public $entregadores_id;
    public $ocorrencias_id;
    public $boletos_id;

    public function cadastar()
    {


        $obdataBase = new Database('devolucao');

        $this->id = $obdataBase->insert([

            'data'                         => $this->data,
            'qtd'                          => $this->qtd,
            'producao_id'                  => $this->producao_id,
            'entregadores_id'              => $this->entregadores_id,
            'boletos_id'                   => $this->boletos_id,
            'ocorrencias_id'               => $this->ocorrencias_id

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('devolucao'))->update('id = ' . $this->id, [

            'data'                         => $this->data,
            'qtd'                          => $this->qtd,
            'producao_id'                  => $this->producao_id,
            'entregadores_id'              => $this->entregadores_id,
            'boletos_id'                   => $this->boletos_id,
            'ocorrencias_id'               => $this->ocorrencias_id
        ]);
    }

    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('devolucao'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('devolucao'))->select('COUNT(*) as qtd', 'devolucao', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('devolucao'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getIDProducao($fields, $table, $where, $order, $limit)
    {
        return (new Database('devolucao'))->select($fields, $table, 'producao_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getTotal($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('devolucao'))->select($fields, $table, $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getIDBoletos($fields, $table, $where, $order, $limit)
    {
        return (new Database('devolucao'))->select($fields, $table, 'boletos_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }



    public function excluir()
    {
        return (new Database('devolucao'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('devolucao'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}