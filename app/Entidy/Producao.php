<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Producao
{


    public $id;
    public $data_inicio;
    public $data_fim;
    public $entregadores_id;
    public $receber_id;
    public $status;
    public $qtd;
    public $regioes_id;
    public $setores_id;
    public $servicos_id;
    public $rotas_id;
    public $usuarios_id;

    public function cadastar()
    {


        $obdataBase = new Database('producao');

        $this->id = $obdataBase->insert([

            'data_inicio'                 => $this->data_inicio,
            'data_fim'                    => $this->data_fim,
            'entregadores_id'             => $this->entregadores_id,
            'receber_id'                  => $this->receber_id,
            'status'                      => $this->status,
            'regioes_id'                  => $this->regioes_id,
            'setores_id'                  => $this->setores_id,
            'servicos_id'                 => $this->servicos_id,
            'rotas_id'                    => $this->rotas_id,
            'usuarios_id'                 => $this->usuarios_id,
            'qtd'                         => $this->qtd


        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('producao'))->update('id = ' . $this->id, [

            'data_inicio'                 => $this->data_inicio,
            'data_fim'                    => $this->data_fim,
            'entregadores_id'             => $this->entregadores_id,
            'receber_id'                  => $this->receber_id,
            'status'                      => $this->status,
            'regioes_id'                  => $this->regioes_id,
            'setores_id'                  => $this->setores_id,
            'servicos_id'                 => $this->servicos_id,
            'rotas_id'                    => $this->rotas_id,
            'usuarios_id'                 => $this->usuarios_id,
            'qtd'                         => $this->qtd

        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $group = null, $order = null, $limit = null)
    {

        return (new Database('producao'))->select($fields, $table, $where, $group, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getListIdProd($fields = null, $table = null, $where = null, $group = null, $order = null, $limit = null)
    {

        return (new Database('producao'))->select($fields, $table, $where, $group, $order, $limit)
            ->fetchObject(self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('producao'))->select('COUNT(*) as qtd', 'producao', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('producao'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getProducaoID($fields, $table, $where, $order, $limit)
    {
        return (new Database('producao'))->select($fields, $table, 'receber_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }
    public static function getProducaoListID($fields, $table, $where, $order, $limit)
    {
        return (new Database('producao'))->select($fields, $table, 'receber_id = ' . $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getReceberID($fields, $table, $where, $order, $limit)
    {
        return (new Database('producao'))->select($fields, $table, 'receber_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getentregadorID($fields, $table, $where, $order, $limit)
    {
        return (new Database('producao'))->select($fields, $table, 'entregadores_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getTotal($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('producao'))->select($fields, $table, $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('producao'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('producao'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }

    public static function getMaiorValor($entra, $saida)
    {
        if ($entra > $saida) {

            $true = true;
            return ($true);
        } else {
            $false = false;
            return ($false);
        }
    }
}
