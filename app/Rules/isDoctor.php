<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;
use App\Models\UserType;

class isDoctor implements Rule
{
    private $error_message = "";

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {   
        //Get user with type
        $user = User::find($value);
        $user_type = UserType::find($user->type_user_id);

        if($user_type->name != "Doctor"){
            $this->error_message = "El usuario no es un doctor.";
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->error_message;
    }
}