<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Acesso
{


    public $id;
    public $nivel;

    public function cadastar()
    {


        $obdataBase = new Database('acessos');

        $this->id = $obdataBase->insert([


            'nivel'                  => $this->nivel

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('acessos'))->update('id = ' . $this->id, [

            'nivel'              => $this->nivel
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('acessos'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('acessos'))->select('COUNT(*) as qtd', 'acessos', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('acessos'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('acessos'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('acessos'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
