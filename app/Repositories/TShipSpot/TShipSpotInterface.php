<?php

/**
 * Ship management Interface
 *
 * @package App\Repositories\TShipSpot
 * @author Rikkei.DatPDT
 * @date 2018/07/05
 */

namespace App\Repositories\TShipSpot;

interface TShipSpotInterface 
{
    /**
     * Create
     * @access public
     * @param array $data
     * @param int $typeInsert
     * @return mixed Illuminate\Support\Collection
     */
    public function createTShipSpot($data, $typeInsert);

    /**
     * Create
     * @access public
     * @param array $data
     * @return mixed Illuminate\Support\Collection
     */
    public function createTShipSpotByCurrencyId($data);

    /**
     * Get edit spot data
     *
     * @param int $spotId
     * @return mixed Laravel collection
     */
    public function getEditShipSpotData($spotId);

    /**
     * Update spot
     *
     * @param int $shipSpotId
     * @param array $updateData
     * @return bool
     */
    public function updateShipSpot($shipSpotId, $updateData);
}