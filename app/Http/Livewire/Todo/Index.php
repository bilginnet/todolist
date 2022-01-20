<?php

namespace App\Http\Livewire\Todo;

use App\Models\Todo;
use App\Repositories\TodoRepositoryInterface;
use Livewire\Component;

class Index extends Component
{
    protected TodoRepositoryInterface $todoRepository;
    public Todo $todo;

    public string $filter = 'all';
    public string $sort = 'added-date';
    public bool $ascending = true;

    protected $queryString = ['filter', 'sort', 'ascending'];

    protected array $rules = [
        'todo.title' => ['required', 'max:191'],
        'todo.deadline' => ['required', 'date'],
    ];

    public function boot(TodoRepositoryInterface $todoRepository, Todo $todo)
    {
         $this->todoRepository = $todoRepository;
         $this->todo = $todo;
    }

    public function ascending(bool $ascending)
    {
        $this->ascending = $ascending;
    }

    public function markAs(Todo $todo, int $completed)
    {
        $this->todoRepository->updateStatus($todo, $completed);
    }

    public function resetTodo()
    {
        $this->todo = $this->todoRepository->getModel();
    }

    public function setTodo(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function save()
    {
        $attributes = $this->validate();
        try {
            $this->todoRepository->save($this->todo, $attributes['todo']);

            $this->resetErrorBag();
            $this->resetTodo();

            $this->emit('make-toast', [
                'type' => 'success',
                'title' => 'Saved',
                'message' => 'Your todo has been saved successfully',
            ]);
        } catch (\Exception $exception) {
            $this->emit('make-toast', [
                'type' => 'danger',
                'title' => 'Error',
                'message' => 'An error occurred during save: '. $exception->getMessage(),
            ]);
        }
    }

    public function delete(Todo $todo)
    {
        if ($this->todoRepository->destroy($todo)) {
            $this->emit('make-toast', [
                'type' => 'success',
                'title' => 'Destroyed',
                'message' => 'Your todo has been destroyed successfully',
            ]);
        } else {
            $this->emit('make-toast', [
                'type' => 'danger',
                'title' => 'Error',
                'message' => 'An error occurred during destroy',
            ]);
        }
    }

    public function render()
    {
        return view('viewLivewire::todo.index', [
            'todos' => $this->todoRepository->get($this->filter, $this->sort, $this->ascending),
        ]);
    }
}
