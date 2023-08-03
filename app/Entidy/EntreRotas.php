<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class EntreRotas
{

    public $id;
    public $entregadores_id;
    public $regioes_id;
    public $rotas_id;

    public function cadastar()
    {


        $obdataBase = new Database('entregador_rota');

        $this->id = $obdataBase->insert([

            'entregadores_id'                   => $this->entregadores_id,
            'regioes_id'                        => $this->regioes_id,
            'rotas_id'                          => $this->rotas_id

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('entregador_rota'))->update('id = ' . $this->id, [

            'entregadores_id'                   => $this->entregadores_id,
            'regioes_id'                        => $this->regioes_id,
            'rotas_id'                          => $this->rotas_id
        ]);
    }

    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entregador_rota'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }


    public static function getEntregadorID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_rota'))->select($fields, $table, 'er.entregadores_id = ' . $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('entregador_rota'))->select('COUNT(*) as qtd', 'entregador_rota', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_rota'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public static function getRotaID($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_rota'))->select($fields, $table, 'rotas_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public static function getIDListEntregador($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_rota'))->select($fields, $table, 'entregadores_id = ' . $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public function excluir()
    {
        return (new Database('entregador_rota'))->delete('id = ' . $this->id);
    }


    public static function getIDRotas($fields, $table, $where, $order, $limit)
    {
        return (new Database('entregador_setores'))->select($fields, $table, 'rotas_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('entregador_rota'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}