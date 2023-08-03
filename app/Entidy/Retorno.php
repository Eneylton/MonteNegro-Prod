<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Retorno
{

    public $id;
    public $data;
    public $qtd;
    public $producao_id;
    public $entregadores_id;
    public $ocorrencias_id;
    public $tipo_id;
    public $status;
    public $boletos_id;

    public function cadastar()
    {


        $obdataBase = new Database('retorno');

        $this->id = $obdataBase->insert([

            'data'                     => $this->data,
            'qtd'                      => $this->qtd,
            'producao_id'              => $this->producao_id,
            'entregadores_id'          => $this->entregadores_id,
            'ocorrencias_id'           => $this->ocorrencias_id,
            'tipo_id'                  => $this->tipo_id,
            'boletos_id'               => $this->boletos_id,
            'status'                   => $this->status

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('retorno'))->update('id = ' . $this->id, [

            'data'                     => $this->data,
            'qtd'                      => $this->qtd,
            'producao_id'              => $this->producao_id,
            'entregadores_id'          => $this->entregadores_id,
            'ocorrencias_id'           => $this->ocorrencias_id,
            'tipo_id'                  => $this->tipo_id,
            'boletos_id'               => $this->boletos_id,
            'status'                   => $this->status

        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('retorno'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('retorno'))->select('COUNT(*) as qtd', 'retorno', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('retorno'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('retorno'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('retorno'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}