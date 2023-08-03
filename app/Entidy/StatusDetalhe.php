<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class StatusDetalhe
{


    public $id;
    public $nome;

    public function cadastar()
    {


        $obdataBase = new Database('status_detalhe');

        $this->id = $obdataBase->insert([


            'nome'                  => $this->nome

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('status_detalhe'))->update('id = ' . $this->id, [

            'nome'              => $this->nome
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('status_detalhe'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('status_detalhe'))->select('COUNT(*) as qtd', 'status_detalhe', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('status_detalhe'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('status_detalhe'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('status_detalhe'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
