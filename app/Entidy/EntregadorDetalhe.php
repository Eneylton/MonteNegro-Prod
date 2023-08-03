<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class EntregadorDetalhe
{

    public $id;
    public $data;
    public $status;
    public $obs;
    public $ocorrencias_id;
    public $entregadores_id;
    public $boletos_id;

    public function cadastar()
    {


        $obdataBase = new Database('entregador_detalhe');

        $this->id = $obdataBase->insert([


            'data'                 => $this->data,
            'status'               => $this->status,
            'obs'                  => $this->obs,
            'ocorrencias_id'       => $this->ocorrencias_id,
            'entregadores_id'      => $this->entregadores_id,
            'boletos_id'      => $this->boletos_id

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('entregador_detalhe'))->update('id = ' . $this->id, [


            'data'                 => $this->data,
            'status'               => $this->status,
            'obs'                  => $this->obs,
            'ocorrencias_id'       => $this->ocorrencias_id,
            'entregadores_id'      => $this->entregadores_id,
            'boletos_id'      => $this->boletos_id
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entregador_detalhe'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entregador_detalhe'))->select('COUNT(*) as qtd', 'entregador_detalhe', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_detalhe'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }



    public static function getIDDetalhe($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_detalhe'))->select($fields, $table, 'boletos_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }
    public static function getIDDetalheList($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_detalhe'))->select($fields, $table, 'boletos_id = ' . $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }


    public function excluir()
    {
        return (new Database('entregador_detalhe'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('entregador_detalhe'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}