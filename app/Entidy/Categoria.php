<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Categoria
{


    public $id;
    public $nome;
    public $foto;

    public function cadastar()
    {


        $obdataBase = new Database('categorias');

        $this->id = $obdataBase->insert([

            'nome'              => $this->nome,
            'foto'              => $this->foto
            

        ]);

        return true;
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('categorias'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('categorias'))->select('COUNT(*) as qtd', 'categorias', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('categorias'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public function atualizar()
    {
        return (new Database('categorias'))->update('id = ' . $this->id, [

            'nome'              => $this->nome,
            'foto'              => $this->foto
        ]);
    }

    public function excluir()
    {
        return (new Database('categorias'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('categorias'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
