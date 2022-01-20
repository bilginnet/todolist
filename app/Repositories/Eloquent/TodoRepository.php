<?php

namespace App\Repositories\Eloquent;

use App\Models\Todo;
use App\Models\User;
use App\Repositories\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TodoRepository implements TodoRepositoryInterface
{
    public Todo $model;
    public User $user;

    public function __construct(Todo $model)
    {
        $this->model = $model;
        $this->user = auth()->user();
    }

    public function getModel(): Todo
    {
        return $this->model;
    }

    public function get(string $filter = 'all', string $sort = 'added-date', bool $ascending = true): Collection
    {
        $query = $this->model::query()->where('user_id', $this->user->id);

        switch ($filter) {
            case 'completed':
                $query->where('status', 1);
                break;
            case 'active':
                $query->where('status', 0)->whereDate('deadline', '>=', date('Y-m-d'));
                break;
            case 'has-due-date':
                $query->whereDate('deadline', '<', date('Y-m-d'));
                break;
        }

        switch ($sort) {
            case 'added-date':
                $query->orderBy('created_at', $ascending ? 'ASC' : 'DESC');
                break;
            case 'due-date':
                $query->orderBy('deadline', $ascending ? 'ASC' : 'DESC');
                break;
        }

        return $query->get();
    }

    public function save(Todo $todo, array $attributes): Todo
    {
        $attributes['user_id'] = $this->user->id;

        $todo->fill($attributes)->save();

        return $todo;
    }

    public function updateStatus(Todo $todo, int $status): bool
    {
        return $todo->update(['status' => $status]);
    }

    public function destroy(Todo $todo): bool
    {
        return $todo->delete();
    }
}
