<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Livewire\Component;

class Register extends Component
{
    protected UserRepositoryInterface $userRepository;
    public User $user;

    public ?string $password = null;
    public ?string $password_confirmation = null;
    protected array $rules = [
        'user.name' => ['required', 'max:191'],
        'user.email' => ['required', 'max:191', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', 'unique:users,email'],
        'password' => ['required', 'confirmed', 'min:6', 'max:32'],
    ];

    public function boot(UserRepositoryInterface $userRepository, User $user)
    {
        $this->userRepository = $userRepository;
        $this->user = $user;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $attributes = $this->validate();
        try {
            $attributes['user']['password'] = $attributes['password'];
            $user = $this->userRepository->register($attributes['user']);

            auth()->login($user);

            return redirect()->route('home');
        } catch (\Exception $exception) {

        }
    }

    public function render()
    {
        return view('viewLivewire::auth.register');
    }
}
