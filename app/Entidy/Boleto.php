<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Boleto
{

    public $id;
    public $data;
    public $sequencia;
    public $vencimento;
    public $codigo;
    public $tipo;
    public $status;
    public $obs;
    public $receber_id;
    public $ocorrencias_id;
    public $coleta;
    public $entregadores_id;
    public $data_inicio;
    public $data_fim;
    public $nota;
    public $cliente;
    public $telefone;
    public $email;
    public $notafiscal_id;
    public $desdinatario_id;
    

    public function cadastar()
    {


        $obdataBase = new Database('boletos');

        $this->id = $obdataBase->insert([

            'data'                    => $this->data,
            'sequencia'               => $this->sequencia,
            'vencimento'              => $this->vencimento,
            'codigo'                  => $this->codigo,
            'tipo'                    => $this->tipo,
            'status'                  => $this->status,
            'obs'                     => $this->obs,
            'ocorrencias_id'          => $this->ocorrencias_id,
            'entregadores_id'         => $this->entregadores_id,
            'coleta'                  => $this->coleta,
            'data_inicio'             => $this->data_inicio,
            'data_fim'                => $this->data_fim,
            'nota'                    => $this->nota,
            'cliente'                 => $this->cliente,
            'telefone'                => $this->telefone,
            'email'                   => $this->email,
            'notafiscal_id'           => $this->notafiscal_id,
            'desdinatario_id'         => $this->desdinatario_id,
            'receber_id'              => $this->receber_id

        ]);

        return true;
    }


    public function atualizar()
    {
        return (new Database('boletos'))->update('id = ' . $this->id, [

            'data'                    => $this->data,
            'sequencia'               => $this->sequencia,
            'vencimento'              => $this->vencimento,
            'codigo'                  => $this->codigo,
            'tipo'                    => $this->tipo,
            'status'                  => $this->status,
            'obs'                     => $this->obs,
            'ocorrencias_id'          => $this->ocorrencias_id,
            'entregadores_id'         => $this->entregadores_id,
            'coleta'                  => $this->coleta,
            'data_inicio'             => $this->data_inicio,
            'data_fim'                => $this->data_fim,
            'nota'                    => $this->nota,
            'cliente'                 => $this->cliente,
            'telefone'                => $this->telefone,
            'email'                   => $this->email,
            'notafiscal_id'           => $this->notafiscal_id,
            'receber_id'              => $this->receber_id

        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $group = null, $order = null, $limit = null)
    {

        return (new Database('boletos'))->select($fields, $table, $where, $group, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getListReceber($fields = null, $table = null, $where = null, $group = null, $order = null, $limit = null)
    {

        return (new Database('boletos'))->select($fields, $table, $where, $group, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getListEntregador($fields = null, $table = null, $where = null, $group = null, $order = null, $limit = null)
    {

        return (new Database('boletos'))->select($fields, $table, $where, $group, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getListView($fields = null, $table = null, $where = null, $group = null, $order = null, $limit = null)
    {

        return (new Database('view_boletos'))->select($fields, $table, $where, $group, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('boletos'))->select('COUNT(*) as qtd', 'boletos', null, null)
            ->fetchObject()
            ->qtd;
    }

    public static function getQtdSequencia($fields = null, $table = null, $where = null, $group = null, $order = null, $limit = null)
    {

        return (new Database('boletos'))->select($fields, $table, $where, $group, $order, $limit)
            ->fetchObject(self::class);
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('boletos'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getBoletosID($fields, $table, $where, $order, $limit)
    {
        return (new Database('boletos'))->select($fields, $table, 'receber_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getCodigo($fields, $table, $where, $order, $limit)
    {
        return (new Database('boletos'))->select($fields, $table, 'codigo = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public static function getCpf($fields, $table, $where, $order, $limit)
    {
        return (new Database('boletos'))->select($fields, $table, 'cpf = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getTotal($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('boletos'))->select($fields, $table, $where, $order, $limit)
            ->fetchObject(self::class);
    }



    public function excluir()
    {
        return (new Database('boletos'))->delete('id = ' . $this->id);
    }


    public static function getEmail($email)
    {

        return (new Database('boletos'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
