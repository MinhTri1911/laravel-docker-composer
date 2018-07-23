<?php

/**
 * NationRepository.php
 *
 * Hanlde eloquent query builder nation
 *
 * @package    App\Repositories\Nation
 * @author     Rikkei.Trihnm
 * @date       2018/07/23
 */

namespace App\Repositories\Nation;

use App\Models\MNation;
use App\Common\Constant;
use App\Repositories\EloquentRepository;

class NationRepository extends EloquentRepository implements NationInterface
{
    public function getModel()
    {
        return MNation::class;
    }

    /**
     * Function get all nation
     * @param array columns
     * @return Collection
     */
    public function getAllNation($columns = ['*'])
    {
        // Get all nation with del_flag is false
        return $this->where('del_flag', Constant::DELETE_FLAG_FALSE)->get($columns);
    }

    /**
     * Function get nation by id or name
     * @param int id
     * @param string name
     * @param array columns
     * @return Collection
     */
    public function getNationByIdOrName($id = 0, $name = '', $columns = ['*'])
    {
        return $this
            ->select($columns)
            ->where(function ($query) use ($id) {
                return $query->where('id', $id)
                ->where('del_flag', Constant::DELETE_FLAG_FALSE);
            })
            ->orWhere(function ($query) use ($id, $name) {
                if (!$id) {
                    return $query->where('del_flag', Constant::DELETE_FLAG_FALSE)
                        ->where(function ($sub) use ($name) {
                            return $sub->where('name_jp', 'LIKE', '%' . $name . '%')
                                ->orWhere('name_en', 'LIKE', '%' . $name . '%');
                        });
                }
            })
            ->where(function ($query) use ($id, $name) {
                if ($id && $name) {
                    return $query->where('name_jp', 'LIKE', '%' . $name . '%')
                        ->orWhere('name_en', 'LIKE', '%' . $name . '%');
                }
            })
            ->get();
    }
}
