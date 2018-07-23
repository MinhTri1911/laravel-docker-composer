<?php

/**
 * NationBusiness.php
 *
 * Handle business process nation
 *
 * @package    App\Business
 * @author     Rikkei.Trihnm
 * @date       2018/07/23
 */

namespace App\Business;

use App\Common\Constant;
use App\Repositories\Nation\NationInterface;

class NationBusiness
{
    protected $nationRepository;

    public function __construct(NationInterface $nation)
    {
        $this->nationRepository = $nation;
    }

    /**
     * Function search nation
     * @param int id
     * @param string name
     * @return Collection
     */
    public function searchNationByIdOrName($id = 0, $name = '')
    {
        return $this->nationRepository->getNationByIdOrName($id, $name, [
            'id',
            'name_jp',
            'name_en',
        ]);
    }
}
