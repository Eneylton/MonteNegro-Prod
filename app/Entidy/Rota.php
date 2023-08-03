<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Rota
{


    public $id;
    public $nome;
    public $regioes_id;
    public $gaiolas_id;


    public function cadastar()
    {


        $obdataBase = new Database('rotas');

        $this->id = $obdataBase->insert([

            'nome'                      => $this->nome,
            'regioes_id'                => $this->regioes_id,
            'gaiolas_id'                => $this->gaiolas_id

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('rotas'))->update('id = ' . $this->id, [
            'nome'                      => $this->nome,
            'regioes_id'                => $this->regioes_id,
            'gaiolas_id'                => $this->gaiolas_id
        ]);
    }



    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('rotas'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('rotas'))->select('COUNT(*) as qtd', 'rotas', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('rotas'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getEntregardorID($fields, $table, $where, $order, $limit)
    {
        return (new Database('rotas'))->select($fields, $table, 'entregadores_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getEntregadorID($fields, $table, $where, $order, $limit)
    {
        return (new Database('rotas'))->select($fields, $table, 'entregadores_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('rotas'))->delete('id = ' . $this->id);
    }


    public static function getEmail($email)
    {

        return (new Database('rotas'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
