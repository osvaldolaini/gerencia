<?php

namespace App\Livewire\Signatures;

use App\Models\Signatures\DocumentSigned;
use Livewire\Component;

class OfficialDocumentViewer extends Component
{
    public DocumentSigned $document;

    public function mount(string $uuid): void
    {
        $this->document = DocumentSigned::with([
            'creator',
            'signatures.signer.user',
        ])->where('uuid', $uuid)
            ->firstOrFail();

        // if (!$this->document->isValid()) {
        //     abort(410);
        // }
    }

    public function download()
    {
        abort_unless(
            $this->document->file_path,
            404
        );

        return response()->download(
            storage_path(
                'app/public/' . $this->document->file_path
            )
        );
    }

    public function render()
    {
        return view('livewire.signatures.official-document-viewer')->layout('layouts.public');;
    }
}
