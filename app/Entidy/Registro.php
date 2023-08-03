<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Registro
{


    public $id;
    public $qtd;
    public $usuarios_id;
    public $producao_id;

    public function cadastar()
    {


        $obdataBase = new Database('registros');

        $this->id = $obdataBase->insert([

            'qtd'                      => $this->qtd,
            'usuarios_id'              => $this->usuarios_id,
            'producao_id'              => $this->producao_id

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('registros'))->update('id = ' . $this->id, [

            'qtd'                      => $this->qtd,
            'usuarios_id'              => $this->usuarios_id,
            'producao_id'              => $this->producao_id
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $group = null, $order = null, $limit = null)
    {

        return (new Database('registros'))->select($fields, $table, $where, $group, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQtd($fields = null, $table = null, $where = null, $group = null, $order = null, $limit = null)
    {

        return (new Database('registros'))->select($fields, $table, $where, $group, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getTotal($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('registros'))->select($fields, $table, $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public static function getQtdGrupo($fields = null, $table = null, $where = null, $group = null, $order = null, $limit = null)
    {

        return (new Database('registros'))->select($fields, $table, $where, $group, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('registros'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('registros'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('registros'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}