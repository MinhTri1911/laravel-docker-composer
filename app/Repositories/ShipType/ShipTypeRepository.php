<?php

namespace App\Repositories\ShipType;

use App\Models\MShipType;
use App\Repositories\EloquentRepository;

class ShipTypeRepository extends EloquentRepository implements ShipTypeInterface
{
	public function getModel()
	{
		return MShipType::class;
	}
}
