<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Importacao
{



    public $id;
    public $data;
    public $notafiscal;
    public $serie;
    public $razaosocial;
    public $notafiscal_id;


    public function cadastar()
    {


        $obdataBase = new Database('importacao');

        $this->id = $obdataBase->insert([


            'data'                  => $this->data,
            'notafiscal'            => $this->notafiscal,
            'serie'                 => $this->serie,
            'razaosocial'           => $this->razaosocial,
            'notafiscal_id'         => $this->notafiscal_id

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('importacao'))->update('id = ' . $this->id, [

            'data'                  => $this->data,
            'notafiscal'            => $this->notafiscal,
            'serie'                 => $this->serie,
            'razaosocial'           => $this->razaosocial,
            'notafiscal_id'         => $this->notafiscal_id
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('importacao'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('importacao'))->select('COUNT(*) as qtd', 'importacao', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('importacao'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('importacao'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('importacao'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
