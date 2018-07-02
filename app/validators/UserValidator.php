<?php

namespace App\Validators;

use Illuminate\Contracts\Validation\Rule;

class UserValidator
{
    public function foo($attribute, $value, $parameters, $validator){
        //return true if field value is foo
        return $value == 'foo';
    }
}

