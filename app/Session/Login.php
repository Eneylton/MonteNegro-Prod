<?php

namespace App\Session;

class Login
{

    public static function getUsuarioLogado()
    {

        self::init();

        return self::isLogget() ? $_SESSION['usuario'] : null;
    }

    private static function init()
    {

        if (session_status() !== PHP_SESSION_ACTIVE) {

            session_start();
        }
    }

    public static function isLogget()
    {

        self::init();

        return isset($_SESSION['usuario']['id']);
    }

    public static function login($obUsuario)
    {

        self::init();


        $_SESSION['usuario'] = [

            'id'          => $obUsuario->id,
            'nome'        => $obUsuario->nome,
            'acessos_id'  => $obUsuario->acessos_id,
            'email'       => $obUsuario->email
        ];

        header('location: pages/home/home.php');
        exit;
    }

    public static function logout()
    {

        self::init();

        unset($_SESSION['usuario']);

        header('location: index.php');
        exit;
    }


    public static function requireLogin()
    {

        if (!self::isLogget()) {

            header('location: login.php');
            exit;
        }
    }

    public static function requireLogout()
    {

        if (self::isLogget()) {

            header('location: index.php');
            exit;
        }
    }
}
