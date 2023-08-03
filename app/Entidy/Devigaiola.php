<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Devigaiola
{


    public $id;
    public $data;
    public $qtd;
    public $entregadores_id;
    public $ocorrencias_id;
    public $tipo_id;
    public $status;

    public function cadastar()
    {


        $obdataBase = new Database('retorno_gaiola');

        $this->id = $obdataBase->insert([

            'data'                     => $this->data,
            'qtd'                      => $this->qtd,
            'entregadores_id'          => $this->entregadores_id,
            'ocorrencias_id'           => $this->ocorrencias_id,
            'tipo_id'                  => $this->tipo_id,
            'status'                   => $this->status

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('retorno_gaiola'))->update('id = ' . $this->id, [

            'data'                     => $this->data,
            'qtd'                      => $this->qtd,
            'entregadores_id'          => $this->entregadores_id,
            'ocorrencias_id'           => $this->ocorrencias_id,
            'tipo_id'                  => $this->tipo_id,
            'status'                   => $this->status
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('retorno_gaiola'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('retorno_gaiola'))->select('COUNT(*) as qtd', 'retorno_gaiola', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('retorno_gaiola'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('retorno_gaiola'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('retorno_gaiola'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
