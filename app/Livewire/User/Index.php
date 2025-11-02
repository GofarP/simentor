<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\User\UserServiceInterface;


class Index extends Component
{
    use WithPagination;
    public string $search = '';
    protected UserServiceInterface $userService;


    public function boot(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users=$this->userService->getAllUsers($this->search,10, false);
        return view('livewire.user.index',[
            'users'=>$users
        ]);
    }
}
