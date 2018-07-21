<?php

namespace App\Repositories\Nation;

use App\Models\MNation;
use App\Repositories\EloquentRepository;

class NationRepository extends EloquentRepository implements NationInterface
{
	public function getModel()
	{
		return MNation::class;
	}
}
