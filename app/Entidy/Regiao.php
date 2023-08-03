<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Regiao
{

    public $id;
    public $nome;

    public function cadastar()
    {


        $obdataBase = new Database('regioes');

        $this->id = $obdataBase->insert([

            'nome'                  => $this->nome
        
        ]);

        return true;
    }


    public static function getList($fields = null,$table = null,$where = null, $order = null, $limit = null)
    {

        return (new Database('regioes'))->select($fields,$table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('regioes'))->select('COUNT(*) as qtd', 'regioes',null,null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('regioes'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public static function getBarra($fields, $table, $where, $order, $limit)
    {
        return (new Database('regioes'))->select($fields, $table, 'barra = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public function atualizar()
    {
        return (new Database('regioes'))->update('id = ' . $this->id, [

            'nome'                  => $this->nome
        ]);
    }

    public function excluir()
    {
        return (new Database('regioes'))->delete('id = ' . $this->id);
    }

    
}
