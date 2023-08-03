<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Parcela
{
     
    public $id;
    public $titulo;
    public $parcela;
    public $vencimento;
    public $notafiscal_id;

    public function cadastar()
    {


        $obdataBase = new Database('parcelas');

        $this->id = $obdataBase->insert([

            'titulo'               => $this->titulo,
            'parcela'              => $this->parcela,
            'vencimento'           => $this->vencimento,
            'notafiscal_id'        => $this->notafiscal_id

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('parcelas'))->update('id = ' . $this->id, [

            'titulo'               => $this->titulo,
            'parcela'              => $this->parcela,
            'vencimento'           => $this->vencimento,
            'notafiscal_id'        => $this->notafiscal_id
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('parcelas'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('parcelas'))->select('COUNT(*) as qtd', 'parcelas', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('parcelas'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('parcelas'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('parcelas'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
