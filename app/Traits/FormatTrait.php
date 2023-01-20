<?php

namespace App\Traits;

trait FormatTrait
{

    /**
     * @param $money
     * @return string
     */
    protected function moneyFormat($money)
    {
        return 'R$' . number_format($money, 2, ',', '.');
    }

    /**
     * @param $date
     * @return string
     */
    protected function dateFormat($date)
    {
        return date('d/m/Y', strtotime($date));
    }

    /**
     * @param $date
     * @return string
     */
    protected function dateTimeFormat($date)
    {
        return date('d/m/Y H:i:s', strtotime($date));
    }

}
