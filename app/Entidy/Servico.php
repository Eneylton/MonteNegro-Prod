<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Servico
{


    public $id;
    public $nome;
   

    public function cadastar()
    {


        $obdataBase = new Database('servicos');

        $this->id = $obdataBase->insert([

            'nome'              => $this->nome
        
        ]);

        return true;
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('servicos'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('servicos'))->select('COUNT(*) as qtd', 'servicos', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('servicos'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public function atualizar()
    {
        return (new Database('servicos'))->update('id = ' . $this->id, [

            'nome'              => $this->nome
        ]);
    }

    public function excluir()
    {
        return (new Database('servicos'))->delete('id = ' . $this->id);
    }


    public static function getEmail($email)
    {

        return (new Database('servicos'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
