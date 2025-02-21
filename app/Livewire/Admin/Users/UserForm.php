<?php

namespace App\Livewire\Admin\Users;

use App\Enums\UserGroups;
use App\Models\User;
use Livewire\Component;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use PHPUnit\Framework\Constraint\Count;

class UserForm extends Component
{
    public $alertSession = false;
    public $rules;

    public $back = 'users-list';
    public $breadcrumb = 'Usuário: ';

    public $id;
    public $name;
    public $email;
    public $password;
    public $groups = array();
    public $accesses = [];
    public $userGroups = [];
    public $activities = [];
    public $user = false;

    public function mount(User $user)
    {
        if ($user) {
            $this->id               = $user->id;
            $this->name             = $user->name;
            $this->email            = $user->email;
            $this->userGroups       = $user->jsonGroups;
            $this->accesses         = $user->jsonAccesses;
            $this->activities       = $user->activities;

            $this->user = $user;
            $this->breadcrumb .= $user->name;
        }
        $this->groups = UserGroups::cases();

        if (!$this->userGroups) {
            $this->userGroups = [];
        }
    }
    public function render()
    {
        return view('livewire.admin.users.user-form');
    }

    public function save()
    {
        $id = $this->real_save();
        if ($id) {
            redirect()->route('user-edit', $id)->with('success', 'Registro salvo com sucesso.');
        }
    }
    public function save_out()
    {
        $this->real_save();
        redirect()->route('users-list')->with('success', 'Registro salvo com sucesso.');
    }

    public function real_save()
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
        if ($this->id) {
            User::updateOrCreate([
                'id' => $this->id,
            ], [
                'name'      => $this->name,
                'groups'    => $this->userGroups,
                'email'     => $this->email,
                'panel'     => $panel,
            ]);
            if ($this->password) {
                User::updateOrCreate([
                    'id' => $this->id,
                ], [
                    'password'  => Hash::make($this->password),
                ]);
            }
            $id = false;
        } else {
            $user = User::create([
                'active'    => 1,
                'name'      => $this->name,
                'groups'    => $this->userGroups,
                'accesses'  => ['all'],
                'activities' => ['create'],
                'email'     => $this->email,
                'panel'     => $panel,
                'dark'      => 0,
                'password'  => Hash::make($this->password),
            ]);
            $id = $user->id;
        }
        $this->openAlert('success', 'Registro salvo com sucesso.');
        return $id;
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
