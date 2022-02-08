<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'username' => 'required',
            'hp' => 'required',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'userid' => $input['userid'] ?? Str::random(5),
            'name' => $input['name'],
            'email' => $input['email'],
            'username' => $input['username'],
            'role' => $input['role']?? 'guru',
            'password' => Hash::make($input['password']),
            'userable_id' => $input['userable_id'],
            'userable_type' => $input['userable_type']
        ]);
    }
}
