<?php

namespace App\Funcao;

use App\Entidy\EntregadorQtd;

class CalcularQtd
{
    public static function calcularQtd($entregador, $receber)
    {
        $qtd_recebeda = EntregadorQtd::getIDList('*', 'entregador_qtd', 'receber_id=' . $receber . ' AND entregadores_id=' . $entregador . '');

        if ($qtd_recebeda == false) {
            $calculo = false;
            return $calculo;
        } else {
            $qtd = $qtd_recebeda->qtd;

            $calculo = $qtd - 1;

            $qtd_recebeda->qtd = $calculo;

            $qtd_recebeda->atualizar();

            $calculo = true;

            return $calculo;
        }
    }
}
