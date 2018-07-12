<?php

/**
 * Ship management Interface
 *
 * @package App\Repositories\TShipSpot
 * @author Rikkei.DatPDT
 * @date 2018/07/05
 */

namespace App\Repositories\TShipSpot;

interface TShipSpotInterface {

    /**
     * Create
     * @access public
     * @param arr $data
     * @param int $typeInsert
     * @return mixed Illuminate\Support\Collection
     */
    public function createTShipSpot($data,$typeInsert);
}
