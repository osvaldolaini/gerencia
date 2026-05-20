<?php

namespace App\Livewire\Settings\Companies;

use App\Models\Peoples;
use App\Models\Settings\Companies;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;


use Illuminate\Support\Str;

class CompanyForm extends Component
{
    public $rules;

    public $back = 'companies-list';
    public $route = 'company';

    public $breadcrumb = 'Companhias';
    //Fields
    public $id;
    public $name;
    public $nick;
    public $people_id;
    public $workload;
    public $email;

    public $mail_host;
    public $mail_port;
    public $mail_username;
    public $mail_password;
    public $mail_encryption;
    public $mail_from_address;
    public $mail_from_name;

    public $people;

    public $newImg = '';

    public function mount(Companies $companies)
    {
        if ($companies->getAttributes()) {
            $this->id           = $companies->id;
            $this->name         = $companies->name;
            $this->nick         = $companies->nick;
            $this->email        = $companies->email;
            $this->people_id    = $companies->people_id;
            $this->workload     = $companies->workload;

            $this->mail_host = $companies->mail_host;
            $this->mail_port = $companies->mail_port;
            $this->mail_username = $companies->mail_username;
            $this->mail_password = $companies->mail_password;
            $this->mail_encryption = $companies->mail_encryption;
            $this->mail_from_address = $companies->mail_from_address;
            $this->mail_from_name = $companies->mail_from_name;
        }
    }

    public function render()
    {
        return view('livewire.settings.companies.company-form');
    }
    #[On('updatePeople')]
    public function updatePeople($id)
    {
        $this->people_id = $id;
        $this->people = Peoples::find($id)->name;
    }

    public function save()
    {
        $id = $this->real_save();
        // if ($id) {
        //     redirect()->route($this->route . '-edit', $id)->with('success', 'Registro criado com sucesso.');
        // }
    }
    public function save_out()
    {
        $this->real_save();
        redirect()->route('companies-list')->with('success', 'Registro criado com sucesso.');
    }

    public function real_save()
    {
        $this->rules = [
            'name' => 'required|' . Rule::unique('companies')->ignore($this->id),
            'workload' => 'required',
            'email' => 'email',
        ];
        $this->validate();
        if ($this->id) {
            Companies::updateOrCreate([
                'id'    => $this->id,
            ], [
                'name' => $this->name,
                'email' => $this->email,
                'nick' => $this->nick,
                'workload' => $this->workload,
                'people_id' => $this->people_id,


                'mail_host' => $this->mail_host,
                'mail_port' => $this->mail_port,
                'mail_username' => $this->mail_username,
                'mail_password' => str_replace(' ', '', $this->mail_password),
                'mail_encryption' => $this->mail_encryption,
                'mail_from_address' => $this->mail_from_address,
                'mail_from_name' => $this->mail_from_name,
            ]);

            $id = false;
            $msg = 'Registro editado com sucesso.';
        } else {
            $companies = Companies::create([
                'active'    => 1,
                'name'      => $this->name,
                'nick'      => $this->nick,
                'workload' => $this->workload,
                'email'     => $this->email,
                'people_id' => $this->people_id,

                'mail_host' => $this->mail_host,
                'mail_port' => $this->mail_port,
                'mail_username' => $this->mail_username,
                'mail_password' => str_replace(' ', '', $this->mail_password),
                'mail_encryption' => $this->mail_encryption,
                'mail_from_address' => $this->mail_from_address,
                'mail_from_name' => $this->mail_from_name,

                'code'      => Str::uuid(),
            ]);
            $id = $companies->id;
            $msg = 'Registro criado com sucesso.';
        }

        $this->openAlert('success', $msg);
        return $id;
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
