<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Distribuicao
{


    public $id;
    public $qtd;
    public $gaiolas_id;
    public $receber_id;
  
    public function cadastar()
    {

        $obdataBase = new Database('divgaiolas');

        $this->id = $obdataBase->insert([

            'qtd'                   => $this->qtd, 
            'gaiolas_id'            => $this->gaiolas_id, 
            'receber_id'            => $this->receber_id 
        
        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('divgaiolas'))->update('id = ' . $this->id, [
            
            'qtd'                   => $this->qtd, 
            'gaiolas_id'            => $this->gaiolas_id, 
            'receber_id'            => $this->receber_id
        
            ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('divgaiolas'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('divgaiolas'))->select('COUNT(*) as qtd', 'divgaiolas', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('divgaiolas'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    
    public function excluir()
    {
        return (new Database('divgaiolas'))->delete('id = ' . $this->id);
    }


    public static function getEmail($email)
    {

        return (new Database('divgaiolas'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
