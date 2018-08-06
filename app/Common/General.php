<?php

/**
 * Configure logging common
 *
 * @package App\Common
 * @author Rikkei.DungLV
 * @date 2018/07/30
*/

namespace App\Common;

use App\Repositories\Company\CompanyRepository;

/**
 * Configure logging common
 */
class General
{
    /**
     * 
     * @param type $condition
     * @return CompanyRepository
     */
    public static function getCompanyByShipOrContract($condition = array())
    {
        $compInterface = new CompanyRepository();
        
        if ($compInterface instanceof CompanyRepository) {
            return $compInterface->getCompanyByShipOrContract($condition);
        }
        
        return null;
    }
}
