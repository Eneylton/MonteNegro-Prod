<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class ControlEnvio
{

    public $id;
    public $data;
    public $notafiscal;
    public $serie;
    public $consultora;
    public $status;
    public $notafiscal_id;
    public $ocorrencias_id;
    public $destinatario_id;
    public $entregadores_id;


    public function cadastar()
    {


        $obdataBase = new Database('controlenvio');

        $this->id = $obdataBase->insert([

            'data'                => $this->data,
            'notafiscal'          => $this->notafiscal,
            'serie'               => $this->serie,
            'consultora'          => $this->consultora,
            'status'              => $this->status,
            'notafiscal_id'       => $this->notafiscal_id,
            'destinatario_id'     => $this->destinatario_id,
            'ocorrencias_id'      => $this->ocorrencias_id,
            'entregadores_id'     => $this->entregadores_id

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('controlenvio'))->update('id = ' . $this->id, [

            'data'                => $this->data,
            'notafiscal'          => $this->notafiscal,
            'serie'               => $this->serie,
            'consultora'          => $this->consultora,
            'status'              => $this->status,
            'notafiscal_id'       => $this->notafiscal_id,
            'destinatario_id'     => $this->destinatario_id,
            'ocorrencias_id'      => $this->ocorrencias_id,
            'entregadores_id'     => $this->entregadores_id
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('controlenvio'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('controlenvio'))->select('COUNT(*) as qtd', 'controlenvio', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('controlenvio'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('controlenvio'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('controlenvio'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
