<div @class(['container m-5 p-2 rounded mx-auto bg-light shadow'])>
    <!-- App title section -->
    <div class="row m-1 p-4">
        <div class="col">
            <div class="p-1 h1 text-secondary text-center mx-auto display-inline-block">
                <i class="bi bi-check bg-secondary text-white rounded p-2"></i>
                <u>My Todo-List</u>
            </div>
            <div class="text-center">
                <a href="{{ route('logout') }}" class="btn btn-secondary btn-sm">Logout</a>
            </div>
        </div>
    </div>

    <!-- Create to-do section -->
    <form wire:submit.prevent="save" id="todo-form">
        @csrf
        <div class="row m-1 p-3">
            <div class="col col-11 mx-auto">
                <div class="row bg-white rounded shadow-sm p-2 add-todo-wrapper align-items-center justify-content-center">
                    <div class="col-4">
                        <input wire:model="todo.deadline" class="form-control form-control-lg border-0 shadow-none add-todo-input bg-transparent rounded" type="date" placeholder="Deadline .." aria-label="Deadline ..">
                        @error('todo.deadline') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col">
                        <input wire:model="todo.title" class="form-control form-control-lg border-0 shadow-none add-todo-input bg-transparent rounded" type="text" placeholder="Title .." aria-label="Title ..">
                        @error('todo.title') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-auto m-0 px-2 d-flex align-items-center">
                        <label class="text-secondary my-2 p-0 px-1 view-opt-label due-date-label d-none">Due date not set</label>
                        <i class="fa fa-calendar my-2 px-1 text-primary btn due-date-button" data-toggle="tooltip" data-placement="bottom" title="Set a Due date"></i>
                        <i class="fa fa-calendar-times-o my-2 px-1 text-danger btn clear-due-date-button d-none" data-toggle="tooltip" data-placement="bottom" title="Clear Due date"></i>
                    </div>
                    <div class="col-auto px-0 mx-0 mr-2">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button wire:click="resetTodo()" type="button" class="btn btn-danger">Clear</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="p-2 mx-4 border-black-25 border-bottom"></div>

    <!-- View options section -->
    <div class="row m-1 p-3 px-5 justify-content-end">
        <div class="col-auto d-flex align-items-center">
            <label class="text-secondary my-2 pr-2 view-opt-label">Filter</label>
            <select wire:model="filter" class="custom-select custom-select-sm btn my-2 text-start" aria-label="">
                <option value="all">All</option>
                <option value="completed">Completed</option>
                <option value="active">Active</option>
                <option value="has-due-date">Has due date</option>
            </select>
        </div>
        <div class="col-auto d-flex align-items-center px-1 pr-3">
            <label class="text-secondary my-2 pr-2 view-opt-label">Sort</label>
            <select wire:model="sort" class="custom-select custom-select-sm btn my-2 text-start" aria-label="">
                <option value="added-date" selected>Added date</option>
                <option value="due-date">Due date</option>
            </select>
            <i wire:click="ascending(false)" @class(['bi bi-arrow-down-short text-info btn mx-0 px-0 pl-1', 'd-none' => !$ascending]) data-toggle="tooltip" data-placement="bottom" title="Ascending"></i>
            <i wire:click="ascending(true)" @class(['bi bi-arrow-up-short text-info btn mx-0 px-0 pl-1', 'd-none' => $ascending]) data-toggle="tooltip" data-placement="bottom" title="Descending"></i>
        </div>
    </div>

    <!-- To-do list section -->
    <div class="row mx-1 px-5 pb-3 w-80">
        <div class="col mx-auto">
            @forelse($todos as $todo)
                <div class="row mb-3 bg-white px-3 align-items-center todo-item rounded">
                    <div class="col-auto m-1 p-0 d-flex align-items-center">
                        <h2 class="m-0 p-0">
                            <i
                                wire:click="markAs({{ $todo }}, {{ $todo->status == 0 ? 1 : 0 }})"
                                @class([
                                    'text-primary btn m-0 p-0',
                                    'bi bi-check-square' => $todo->status,
                                    'bi bi-square' => !$todo->status,
                                ])
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="Mark as complete/todo"></i>
                        </h2>
                    </div>
                    <div class="col px-1 m-1 d-flex align-items-center">
                        {{ $todo->title }}
{{--                        <input type="text" class="form-control form-control-lg border-0 edit-to-do-input bg-transparent rounded px-3" readonly value="Renew car insurance" title="Renew car insurance" />--}}
{{--                        <input type="text" class="form-control form-control-lg border-0 edit-to-do-input rounded px-3 d-none" value="Renew car insurance" />--}}
                    </div>
                    <div class="col-3 m-1 p-0 px-3">
                        <div class="">
                            <div @class([
                                    'col-auto d-flex justify-content-center align-items-center rounded bg-white px-2 w-100 ',
                                    'border border-danger text-danger' => date('Y-m-d', strtotime($todo->deadline)) < date('Y-m-d')
                                ])>
                                <i class="bi bi-hourglass-split me-2" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Due on date"></i>
                                <h6 class="text my-2 pr-2">{{ \Carbon\Carbon::createFromDate($todo->deadline)->translatedFormat('d M Y') }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto m-1 p-0 todo-actions">
                        <div class="d-flex align-items-center justify-content-end">
                            <h5 class="m-0 p-0 px-2 edit-button" wire:click="setTodo({{ $todo }})">
                                <i class="bi bi-pencil text-info btn m-0 p-0" data-toggle="tooltip" data-placement="bottom" title="Edit todo"></i>
                            </h5>
                            <h5 class="m-0 p-0 px-2" wire:click="delete({{ $todo }})">
                                <i class="bi bi-trash text-danger btn m-0 p-0" data-toggle="tooltip" data-placement="bottom" title="Delete todo"></i>
                            </h5>
                        </div>
                        <div class="todo-created-info">
                            <div class="d-flex align-items-center pr-2">
                                <i class="bi bi-info-circle text-black-50 me-2" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Created date"></i>
                                <label class="date-label text-black-50">{{ \Carbon\Carbon::createFromDate($todo->deadline)->translatedFormat('d M Y') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
    </div>
</div>

@push('style')
    <style>
        body {
            font-family: "Open Sans", sans-serif;
            line-height: 1.6;
        }

        .add-todo-input,
        .edit-todo-input {
            outline: none;
        }

        .add-todo-input:focus,
        .edit-todo-input:focus {
            border: none !important;
            box-shadow: none !important;
        }

        .view-opt-label,
        .date-label {
            font-size: 0.8rem;
        }

        .edit-todo-input {
            font-size: 1.7rem !important;
        }

        .todo-actions {
            visibility: hidden !important;
        }

        .todo-item:hover .todo-actions {
            visibility: visible !important;
        }

        .todo-item.editing .todo-actions .edit-icon {
            display: none !important;
        }

    </style>
@endpush

@push('javascript')
    <script>

        document.querySelectorAll('.edit-button').forEach(el => {
            el.addEventListener('click', event => {
                console.log(event);
                document.getElementById('todo-form').scrollIntoView();
            });
        });
    </script>
@endpush
