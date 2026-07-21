<?php

namespace App\Livewire\Signatures;

use App\Models\Signatures\DocumentSigned;
use Livewire\Component;
use Livewire\WithFileUploads;

class DocumentFileValidator extends Component
{
    use WithFileUploads;

    public $file;
    public bool $verifying = false;

    /**
     * null = ainda não verificou
     * true = documento autêntico
     * false = documento alterado ou desconhecido
     */
    public ?bool $result = null;

    protected function rules(): array
    {
        return [
            'file' => 'required|file|mimes:pdf|max:20480',
        ];
    }

    /**
     * Verifica se o PDF enviado corresponde exatamente
     * a um documento oficial emitido pelo sistema.
     */
    public function validateDocument(): void
    {
        $this->validate();

        $hash = hash_file(
            'sha256',
            $this->file->getRealPath()
        );

        $this->result = DocumentSigned::where(
            'hash',
            $hash
        )->exists();

        $this->reset('file');
    }
    public function updatedFile()
    {
        $this->verifying = true;
        $this->result = true;

        $this->validateDocument();

        $this->verifying = false;
    }

    public function resetVerification(): void
    {
        $this->reset([
            'file',
            'result',
            'verifying',
        ]);
    }

    public function render()
    {
        return view(
            'livewire.signatures.document-file-validator'
        );
    }
}
