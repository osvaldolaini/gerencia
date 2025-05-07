<?php

namespace App\Livewire\App;

use App\Enums\UserGroups;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use PHPUnit\Framework\Constraint\Count;

use Illuminate\Support\Str;

class UserProfile extends Component
{
    public $alertSession = false;
    public $rules;
    public $user;
    public $id;
    public $name;
    public $email;
    public $password;
    public $groups = array();
    public $accesses = [];
    public $userGroups = [];
    public $activities = [];
    public $people;

    //People fields
    public $nick;
    public $posto_grad;
    public $function;
    public $sex;

    public function mount()
    {
        $this->user = Auth::user();
        if ($this->user) {
            // dd($this->user->people);
            $this->people           = $this->user->people;
            $this->id               = $this->user->id;
            $this->name             = $this->user->name;
            $this->email            = $this->user->email;
            $this->userGroups       = $this->user->jsonGroups;
            $this->accesses         = $this->user->jsonAccesses;
            $this->activities       = $this->user->activities;

            // $this->name = $this->user->name;
            if ($this->user->people) {
                $this->nick         = $this->user->people->nick;
                $this->posto_grad   = $this->user->people->posto_grad;
                $this->function     = $this->user->people->function;
                $this->sex          = $this->user->people->sex;
            }
        }
        $this->groups = UserGroups::cases();

        if (!$this->userGroups) {
            $this->userGroups = [];
        }
    }
    public function render()
    {
        return view('livewire.app.user-profile');
    }

    public function save()
    {
        $this->rules = [
            'name'          => 'required',
            'userGroups'    => 'required',
            'email'         => 'required|email|' . Rule::unique('users')->ignore($this->id),
        ];
        if ($this->id == '') {
            $this->rules['password'] = 'required|string';
        }

        if (count($this->userGroups) >= 1) {
            $panel = $this->userGroups[0];
        } else {
            $panel = 'user';
        }

        $this->validate();
        // dd($this->user->people);
        $this->user->name   = $this->name;
        $this->user->email  = $this->email;
        $this->user->save();

        // $this->nick         = $this->nick;
        // $this->posto_grad   = $this->user->people->posto_grad;
        // $this->function     = $this->user->people->function;
        // $this->sex          = $this->user->people->sex;

        if ($this->password) {
            $this->user->email  = Hash::make($this->password);
        }
        $this->people->name         = $this->name;
        $this->people->nick         = $this->nick;
        $this->people->posto_grad   = $this->posto_grad;
        $this->people->function     = $this->function;
        $this->people->sex          = $this->sex;
        $this->people->save();

        $id = false;

        $this->openAlert('success', 'Registro salvo com sucesso.');
        return $id;
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
