<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getModel(): User;

    public function register(array $attributes): User;
}
