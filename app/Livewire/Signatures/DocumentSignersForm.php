<?php

namespace App\Livewire\Signatures;

use App\Enums\SignatureRole;
use App\Models\Peoples;
use App\Models\Signatures\DocumentSigner;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

class DocumentSignersForm extends Component

{
    public $rules;

    public $back = 'document-signers-list';
    public $route = 'document-signers';

    public $breadcrumb = 'Assinador';
    //Fields
    public $id;
    public $role;
    public $user_id;
    public $signature_password;

    public function mount(DocumentSigner $document_signer)
    {
        if ($document_signer->getAttributes()) {
            $this->id           = $document_signer->id;
            $this->role         = $document_signer->role;
            $this->user_id      = $document_signer->user_id;
            $this->signature_password   = $document_signer->signature_password;
        }
    }

    public function render()
    {
        return view('livewire.signatures.document-signers-form');
    }

    public function save()
    {
        $id = $this->real_save();
        if ($id) {
            redirect()->route($this->route . '-edit', $id)->with('success', 'Registro criado com sucesso.');
        }
    }
    public function save_out()
    {
        $this->real_save();
        redirect()->route($this->route . '-list')->with('success', 'Registro criado com sucesso.');
    }

    #[On('updatePeople')]
    public function updatePeople($id)
    {
        $people = Peoples::find($id);
        $this->user_id = $people?->user->id;
    }

    public function real_save()
    {
        $this->rules = [
            'role'   => 'required',
            // 'role'         => 'required|' . Rule::unique('document_signers')->ignore($this->id),
            'user_id'   => 'required',
            'signature_password'   => 'required',
        ];
        $this->validate();

        $signers = DocumentSigner::where('active', 1)->where('role', $this->role)->get();

        if ($signers->count() > 0) {
            dd($signers->count());
            $this->openAlert('error', SignatureRole::fromDb($this->role)->msg() . ', favor exclui-lo primeiro.');
            return;
        }
        DocumentSigner::updateOrCreate([
            'id'    => $this->id,
        ], [
            'active' => 1,
            'role' => $this->role,
            'user_id' => $this->user_id,
            'signature_password'  => $this->signature_password,
            // 'signature_password' => $this->signature_password,
        ]);
        $id = false;
        $msg = 'Registro editado com sucesso.';

        $this->openAlert('success', $msg);
        return $id;
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
