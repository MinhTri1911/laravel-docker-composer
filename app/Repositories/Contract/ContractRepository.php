<?php

/**
 * File contract repository
 *
 * Handle eloquent query builder contract
 * @package App\Repositories\Contract
 * @author Rikkei.trihnm
 * @date 2018/07/11
 */

namespace App\Repositories\Contract;

use App\Repositories\EloquentRepository;
use App\Models\MContract;

class ContractRepository extends EloquentRepository implements ContractInterface
{
    /**
     * Function get path model
     * @access public
     * @return string model
     */
    public function getModel()
    {
        return MContract::class;
    }
    
    /**
     * Function create
     * @access public
     * @param arr data
     * @return mixed
     */
    public function createContract($data) {
        
        $contact = new $this->_model;
        $contact->ship_id = $data['ship_id'];
        $contact->currency_id = $data['currency_id'];
        $contact->service_id = $data['service_id'];
        $contact->start_date = $data['start_date'];
        $contact->end_date = $data['end_date'];
        $contact->remark = $data['remark'];
        $contact->approved_flag = 2;
        $contact->save();

        return $contact->id;
    }

    /**
     * Function edit
     * @access public
     * @param arr data
     * @return mixed
     */
    public function editContract($data) {
        
    }
}
