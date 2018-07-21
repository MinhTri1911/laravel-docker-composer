<?php

namespace App\Repositories\Classification;

use App\Models\MShipClassification;
use App\Repositories\EloquentRepository;

class ClassificationRepository extends EloquentRepository implements ClassificationInterface
{
	public function getModel()
	{
		return MShipClassification::class;
	}
}
