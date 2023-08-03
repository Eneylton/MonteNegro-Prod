<?php 

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Ocorrencia {
    

    public $id;
    public $nome;
    
    public function cadastar(){


        $obdataBase = new Database('ocorrencias');  
        
        $this->id = $obdataBase->insert([
          
            'nome'                         => $this->nome
        ]);

        return true;

    }

    public function atualizar(){
        return (new Database ('ocorrencias'))->update('id = ' .$this-> id, [
    
            'nome'                         => $this->nome
        ]);
      
    }

    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('ocorrencias'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('ocorrencias'))->select('COUNT(*) as qtd', 'ocorrencias', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('ocorrencias'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }



public function excluir(){
    return (new Database ('ocorrencias'))->delete('id = ' .$this->id);
  
}


public static function getUsuarioPorEmail($email){

    return (new Database ('ocorrencias'))->select('email = "'.$email.'"')-> fetchObject(self::class);

}



}