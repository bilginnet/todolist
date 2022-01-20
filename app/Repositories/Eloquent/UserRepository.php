<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getModel(): User
    {
        return $this->model;
    }

    public function register(array $attributes): User
    {
        $attributes['password'] = bcrypt($attributes['password']);
        return $this->model::create($attributes);
    }
}
