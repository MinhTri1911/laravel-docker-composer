<?php

namespace App\Repositories\User;

use App\Repositories\EloquentRepository;
use App\Repositories\User\UserRepositoryInterface;
use \App\Models\User;

class UserEloquentRepository extends EloquentRepository implements UserRepositoryInterface
{
    /**
     * Set model user for interface
     * 
     * @return \App\Models\User $user
     */
    public function getModel(){
        return User::class;
    }
    
    /**
     * Get all posts only published
     * @return mixed
     */
    public function getAllPublished()
    {
        $result = $this->where('is_published', 1)->get();
        
        return $result;
    }
 
    /**
     * Get post only published
     * @param $id int Post ID
     * @return mixed
     */
    public function findOnlyPublished($id)
    {
        $result = $this
            ->where('id', $id)
            ->where('is_published', 1)
            ->first();
            
        return $result;
    }
}
