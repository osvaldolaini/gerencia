<?php

namespace App\Livewire\Signatures;

use App\Enums\SignatureRole;
use App\Enums\DocumentType;
use App\Enums\SignedDocumentStatus;
use App\Models\Signatures\DocumentSigned;
use App\Models\Signatures\DocumentSigner;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Livewire\Component;

use App\Traits\Signatures\PdfSignatureTrait;
use App\Services\Signatures\DocumentSigningService;
use Livewire\Attributes\On;

class DocumentSignModal extends Component
{
    use PdfSignatureTrait;
    public bool $showModal = false;

    public bool $showJetModal = false;

    public string $documentModel;

    public int $documentId;

    public ?DocumentSigned $currentDocument = null;

    public DocumentType $documentType;

    /**
     * Próxima assinatura obrigatória.
     */
    public ?SignatureRole $nextRole = null;

    /**
     * Todas as assinaturas exigidas pelo documento.
     *
     * @var SignatureRole[]
     */
    public array $requiredRoles = [];

    /**
     * Roles já assinadas.
     *
     * @var string[]
     */
    public array $signedRoles = [];

    /**
     * Assinaturas disponíveis para o usuário logado.
     */
    public $userSignatures = [];

    /**
     * Assinatura escolhida.
     */
    public ?int $selectedSigner = null;

    public string $password = '';

    public function mount(string $documentModel, int $documentId, DocumentType $documentType): void
    {
        $this->documentModel = $documentModel;
        $this->documentId = $documentId;
        $this->documentType = $documentType;

        $this->userSignatures = Auth::user()->documentSigners;

        $this->loadContext();
    }

    public function openModal(): void
    {
        $this->showModal = true;
        $this->loadContext();
    }

    public function closeModal(): void
    {
        $this->showModal = false;

        $this->reset([
            'password',
            'selectedSigner',
        ]);
    }

    /**
     * Carrega todas as informações necessárias.
     */
    protected function loadContext(): void
    {
        $this->currentDocument = DocumentSigned::where([
            'document_model' => $this->documentModel,
            'document_id' => $this->documentId,
            'document_type' => $this->documentType,
        ])
            ->with('signatures')
            ->whereIn('status', [
                SignedDocumentStatus::Current,
                SignedDocumentStatus::Completed,
            ])
            ->latest('id')
            ->first();

        $document = app($this->documentModel)->find($this->documentId);

        if (!$document) {
            return;
        }

        $this->requiredRoles = $document->requiredSignatures();

        $this->signedRoles = $this->currentDocument
            ? $this->currentDocument
            ->signatures
            ->pluck('role')
            ->toArray()
            : [];


        $this->nextRole = $this->resolveNextRole();

        $this->userSignatures = Auth::user()->documentSigners;

        if ($this->userSignatures->count() === 1) {
            $this->selectedSigner = $this->userSignatures->first()->id;
        }
    }

    public function loadCurrentDocument(): void
    {
        $this->currentDocument = DocumentSigned::where([
            'document_model' => $this->documentModel,
            'document_id'    => $this->documentId,
        ])
            ->whereIn('status', ['current', 'completed'])
            ->latest('id')
            ->with('signatures')
            ->first();
    }


    protected function resolveNextRole(): ?SignatureRole
    {
        foreach ($this->requiredRoles as $role) {

            if (!in_array($role, $this->signedRoles, true)) {
                return $role;
            }
        }

        return null;
    }

    /**
     * O usuário pode assinar?
     */
    public function canCurrentUserSign(): bool
    {
        if (!$this->nextRole) {
            return false;
        }

        return collect($this->userSignatures)
            ->contains(fn($signature) => $signature->role === $this->nextRole);
    }

    //CRIA O DOCUMENTO
    public function sign(): void
    {

        $this->validate([
            'selectedSigner' => ['required', 'exists:document_signers,id'],
            'password' => ['required'],
        ], [
            'selectedSigner.required' => 'Selecione uma assinatura.',
            'password.required' => 'Informe a senha da assinatura.',
        ]);

        $signer = DocumentSigner::findOrFail($this->selectedSigner);


        /*
        |--------------------------------------------------------------------------
        | A assinatura pertence ao usuário logado?
        |--------------------------------------------------------------------------
        */
        if ($signer->user_id !== Auth::id()) {

            $this->addError(
                'selectedSigner',
                'Esta assinatura não pertence ao usuário logado.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Assinatura ativa?
        |--------------------------------------------------------------------------
        */
        if (!$signer->active) {

            $this->addError(
                'selectedSigner',
                'Esta assinatura está desativada.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Confere a senha da assinatura
        |--------------------------------------------------------------------------
        | Como o campo possui cast "encrypted", o Laravel já devolve o valor
        | descriptografado. Basta comparar.
        |--------------------------------------------------------------------------
        */
        if ($signer->signature_password !== $this->password) {

            $this->addError(
                'password',
                'Senha de assinatura incorreta.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Verifica se esta é a próxima assinatura obrigatória
        |--------------------------------------------------------------------------
        */
        if (!$this->nextRole) {

            $this->addError(
                'selectedSigner',
                'Este documento já possui todas as assinaturas.'
            );

            return;
        }

        if ($signer->role !== $this->nextRole) {

            $this->addError(
                'selectedSigner',
                'A próxima assinatura obrigatória é: ' . $this->nextRole->label()
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Até aqui todas as validações passaram.
        | Na próxima etapa chamaremos o DocumentSigningService.
        |--------------------------------------------------------------------------
        */

        $document = app(DocumentSigningService::class)
            ->sign(
                signer: $signer,
                documentModel: $this->documentModel,
                documentId: $this->documentId,
                documentType: $this->documentType,
            );

        /*
        |--------------------------------------------------------------------------
        | Se o documento já possui todas as assinaturas,
        | avisa o componente responsável para gerar o PDF oficial.
        |--------------------------------------------------------------------------
        */
        if ($document->isFullySigned()) {
            $this->dispatch(
                'document-signed',
                documentSignedId: $document->id,
            );
            // $this->loadContext();
            // dd($this->currentDocument?->file_path);
        }


        $this->loadContext();

        $this->openAlert('success', 'Validações realizadas com sucesso.');

        $this->closeModal();
    }

    #[On('official-document-generated')]
    public function refresh()
    {
        $this->loadContext();
    }

    //MESSAGE
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }

    public function render()
    {
        $this->loadContext();
        return view('livewire.signatures.document-sign-modal');
    }
    /**
     * Verifica se todas as assinaturas obrigatórias foram realizadas.
     */
    public function isFullySigned(): bool
    {
        $model = app($this->document_model)->find($this->document_id);

        if (!$model || !method_exists($model, 'requiredSignatures')) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Assinaturas obrigatórias do documento
        |--------------------------------------------------------------------------
        */
        $requiredRoles = collect($model->requiredSignatures())
            ->map(fn(SignatureRole $role) => $role->value);

        /*
        |--------------------------------------------------------------------------
        | Assinaturas já realizadas
        |--------------------------------------------------------------------------
        */
        $signedRoles = $this->signatures
            ->pluck('role')
            ->map(fn($role) => $role instanceof SignatureRole ? $role->value : $role);

        /*
        |--------------------------------------------------------------------------
        | Todas as roles obrigatórias estão presentes?
        |--------------------------------------------------------------------------
        */
        return $requiredRoles
            ->diff($signedRoles)
            ->isEmpty();
    }

    //DELETE
    public function showModalDelete()
    {
        $this->showJetModal = true;
    }

    //Revoga o documento
    public function revokeDocument(): void
    {
        if (!$this->currentDocument) {

            $this->openAlert(
                'error',
                'Documento não encontrado.'
            );

            return;
        }

        DB::transaction(function () {

            /*
            |--------------------------------------------------------------------------
            | Remove o PDF oficial
            |--------------------------------------------------------------------------
            */

            $this->deleteOfficialPdf(
                $this->currentDocument
            );

            /*
            |--------------------------------------------------------------------------
            | Revoga o documento
            |--------------------------------------------------------------------------
            */

            $this->currentDocument->update([
                'status' => SignedDocumentStatus::Cancelled,
                'revoked_at' => now(),
                'revocation_reason' => 'Substituído por uma nova versão.',
            ]);
        });

        $this->loadContext();

        $this->openAlert(
            'success',
            'Documento oficial revogado com sucesso.'
        );

        $this->showJetModal = false;
    }

    //Baixar o documento 
    public function download(string $uuid)
    {
        $document = DocumentSigned::where(
            'uuid',
            $uuid
        )
            ->with([
                'signatures.signer.user',
            ])
            ->firstOrFail();
        abort_unless(
            $document->file_path,
            404
        );


        return response()->download(
            storage_path(
                'app/public/' . $document->file_path
            )
        );
    }
}
