<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Scopes\SoftDeletes\SoftDeleteCustoms;

class User extends Authenticatable
{
    use Notifiable, SoftDeleteCustoms;
    
    // Setting column in database is delete_at
    const DELETED_AT = 'flag_delete';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
