<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Tipo
{

    public $id;
    public $nome;

    public function cadastar()
    {

        $obdataBase = new Database('tipo');

        $this->id = $obdataBase->insert([

            'nome'              => $this->nome

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('tipo'))->update('id = ' . $this->id, [

            'nome'              => $this->nome
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('tipo'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('tipo'))->select('COUNT(*) as qtd', 'tipo', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('tipo'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('tipo'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('tipo'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
