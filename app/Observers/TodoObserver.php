<?php

namespace App\Observers;

use App\Models\Log;
use App\Models\Todo;

class TodoObserver
{
    /**
     * Handle the Todo "created" event.
     *
     * @param  \App\Models\Todo  $todo
     * @return void
     */
    public function created(Todo $todo)
    {
        Log::create([
            'user_id' => auth()->user()->id,
            'loggable_type' => Todo::class,
            'loggable_id' => $todo->id,
            'action' => 'created',
            'old_values' => null,
            'new_values' => json_encode($todo->getAttributes()),
        ]);
    }

    /**
     * Handle the Todo "updated" event.
     *
     * @param  \App\Models\Todo  $todo
     * @return void
     */
    public function updated(Todo $todo)
    {
        Log::create([
            'user_id' => auth()->user()->id,
            'loggable_type' => Todo::class,
            'loggable_id' => $todo->id,
            'action' => 'updated',
            'old_values' => json_encode($todo->getOriginal()),
            'new_values' => json_encode($todo->getAttributes()),
        ]);
    }

    /**
     * Handle the Todo "deleted" event.
     *
     * @param  \App\Models\Todo  $todo
     * @return void
     */
    public function deleted(Todo $todo)
    {
        Log::create([
            'user_id' => auth()->user()->id,
            'loggable_type' => Todo::class,
            'loggable_id' => $todo->id,
            'action' => 'deleted',
            'old_values' => null,
            'new_values' => null,
        ]);
    }
}
