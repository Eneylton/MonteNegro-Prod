<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Backlog
{


    public $id;
    public $data;
    public $qtd;
    public $entregadores_id;
    public $ocorrencias_id;
    public $producao_id;
    public $tipo_id;
    public $status;

    public function cadastar()
    {


        $obdataBase = new Database('backlog');

        $this->id = $obdataBase->insert([

            'data'                     => $this->data,
            'qtd'                      => $this->qtd,
            'entregadores_id'          => $this->entregadores_id,
            'ocorrencias_id'           => $this->ocorrencias_id,
            'producao_id'              => $this->producao_id,
            'tipo_id'                  => $this->tipo_id,
            'status'                   => $this->status

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('backlog'))->update('id = ' . $this->id, [

            'data'                     => $this->data,
            'qtd'                      => $this->qtd,
            'entregadores_id'          => $this->entregadores_id,
            'ocorrencias_id'           => $this->ocorrencias_id,
            'producao_id'              => $this->producao_id,
            'tipo_id'                  => $this->tipo_id,
            'status'                   => $this->status
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('backlog'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('backlog'))->select('COUNT(*) as qtd', 'backlog', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('backlog'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('backlog'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('backlog'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
