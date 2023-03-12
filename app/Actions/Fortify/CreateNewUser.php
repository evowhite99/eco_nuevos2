<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     * @return \App\Models\User
     */
    public function create(array $input) {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'profesion_nombre' => ['required', 'string', 'max:255'],
            'profesion_otro' => ['nullable', 'string', 'max:255'],
            'twitter' => ['nullable', 'url'],
            'biografia' => ['required', 'string', 'max:255'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();
        $profesion = $input['profesion_nombre'];
        if ($input['profesion_nombre'] === 'otro') {
            $profesion = $input['profesion_otro'] ?? 'Sin profesion';
        }
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'profesion_nombre' => $profesion,
            'twitter' => $input['twitter'],
            'biografia' => $input['biografia'],
        ]);
    }
}
