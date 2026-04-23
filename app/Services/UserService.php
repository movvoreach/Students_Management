<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;

class UserService {

        // This service can be used for user-related operations, such as creating a user when a student is created.
        public function store(array $data) : User
        {
            $user = \App\Models\User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => bcrypt($data['password']),
                'role'     => 'student',
            ]);
            return $user;
        }


}
