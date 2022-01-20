<?php

namespace App\Repositories;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;

interface TodoRepositoryInterface
{
    public function getModel(): Todo;

    public function get(string $filter = 'all', string $sort = 'added-date', bool $ascending = true): Collection;

    public function save(Todo $todo, array $attributes): Todo;

    public function updateStatus(Todo $todo, int $status): bool;

    public function destroy(Todo $todo): bool;
}
