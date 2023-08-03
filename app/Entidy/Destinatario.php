<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Destinatario
{

    public $id;
    public $cpf;
    public $nome;
    public $logradouro;
    public $numero;
    public $bairro;
    public $municipio;
    public $uf;
    public $cep;
    public $pais;
    public $telefone;
    public $email;
    public $notafiscal_id;
    public $complemento;
    public $telefone2;
    public $flag;


    public function cadastar()
    {


        $obdataBase = new Database('destinatario');

        $this->id = $obdataBase->insert([

            'cpf'                   => $this->cpf,
            'nome'                  => $this->nome,
            'logradouro'            => $this->logradouro,
            'numero'                => $this->numero,
            'bairro'                => $this->bairro,
            'municipio'             => $this->municipio,
            'uf'                    => $this->uf,
            'cep'                   => $this->cep,
            'pais'                  => $this->pais,
            'telefone'              => $this->telefone,
            'email'                 => $this->email,
            'complemento'           => $this->complemento,
            'telefone2'             => $this->telefone2,
            'flag'                  => $this->flag,
            'notafiscal_id'         => $this->notafiscal_id

        ]);

        return true;
    }


    public function atualizar()
    {
        return (new Database('destinatario'))->update('id = ' . $this->id, [
            'cpf'                   => $this->cpf,
            'nome'                  => $this->nome,
            'logradouro'            => $this->logradouro,
            'numero'                => $this->numero,
            'bairro'                => $this->bairro,
            'municipio'             => $this->municipio,
            'uf'                    => $this->uf,
            'cep'                   => $this->cep,
            'pais'                  => $this->pais,
            'telefone'              => $this->telefone,
            'email'                 => $this->email,
            'complemento'           => $this->complemento,
            'telefone2'             => $this->telefone2,
            'flag'                  => $this->flag,
            'notafiscal_id'         => $this->notafiscal_id
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $group = null, $order = null, $limit = null)
    {

        return (new Database('destinatario'))->select($fields, $table, $where, $group, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('destinatario'))->select('COUNT(*) as qtd', 'destinatario', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('destinatario'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getIDNota($fields, $table, $where, $order, $limit)
    {
        return (new Database('destinatario'))->select($fields, $table, 'notafiscal_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getIDCpf($fields, $table, $where, $order, $limit)
    {
        return (new Database('destinatario'))->select($fields, $table, 'cpf = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

    public static function getTotal($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('destinatario'))->select($fields, $table, $where, $order, $limit)
            ->fetchObject(self::class);
    }



    public function excluir()
    {
        return (new Database('destinatario'))->delete('id = ' . $this->id);
    }


    public static function getEmail($email)
    {

        return (new Database('destinatario'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
