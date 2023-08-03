<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Gaiola
{


    public $id;
    public $nome;
    public $qtd;



    public function cadastar()
    {


        $obdataBase = new Database('gaiolas');

        $this->id = $obdataBase->insert([

            'nome'                      => $this->nome,
            'qtd'                       => $this->qtd
           

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('gaiolas'))->update('id = ' . $this->id, [

            'nome'                      => $this->nome,
            'qtd'                       => $this->qtd
            
        ]);
    }



    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('gaiolas'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('gaiolas'))->select('COUNT(*) as qtd', 'gaiolas', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('gaiolas'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('gaiolas'))->delete('id = ' . $this->id);
    }


    public static function getEmail($email)
    {

        return (new Database('gaiolas'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
