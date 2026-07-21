<?php

namespace App\Services\Signatures;

use App\Enums\DocumentType;
use App\Enums\SignedDocumentStatus;
use App\Models\Signatures\DocumentSigned;
use App\Models\Signatures\DocumentSignature;
use App\Models\Signatures\DocumentSigner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DocumentSigningService
{
    public function sign(
        DocumentSigner $signer,
        string $documentModel,
        int $documentId,
        DocumentType $documentType,
    ): DocumentSigned {

        return DB::transaction(function () use (
            $signer,
            $documentModel,
            $documentId,
            $documentType
        ) {

            /*
            |--------------------------------------------------------------------------
            | Recupera ou cria o documento vigente
            |--------------------------------------------------------------------------
            */

            $document = DocumentSigned::where([
                'document_model' => $documentModel,
                'document_id'    => $documentId,
                'document_type'    => $documentType,
            ])->whereIn('status', [
                SignedDocumentStatus::Current,
                SignedDocumentStatus::Completed,
            ])
                ->latest('id')
                ->first();

            // $document = DocumentSigned::where([
            //     'document_model' => $documentModel,
            //     'document_id'    => $documentId,
            //     'document_type'    => $documentType,
            // ])
            //     ->latest('id')
            //     ->first();


            if ($document?->status === SignedDocumentStatus::Cancelled) {
                $document = null;
            }

            if (!$document) {

                $document = DocumentSigned::create([
                    'uuid'           => (string) Str::uuid(),
                    'document_type'     => $documentType,
                    'document_model' => $documentModel,
                    'document_id'    => $documentId,
                    'status'         => SignedDocumentStatus::Current,
                    'hash'           => '',
                    'created_by'     => Auth::id(),
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Evita assinatura duplicada
            |--------------------------------------------------------------------------
            */

            $alreadySigned = $document
                ->signatures()
                ->where('role', $signer->role)
                ->exists();

            if (!$alreadySigned) {

                DocumentSignature::create([
                    'document_signed_id' => $document->id,
                    'document_signer_id' => $signer->id,
                    'role' => $signer->role,
                    'signed_at' => now(),
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Atualiza relacionamento
            |--------------------------------------------------------------------------
            */

            $document->load('signatures');

            /*
            |--------------------------------------------------------------------------
            | Documento totalmente assinado?
            |--------------------------------------------------------------------------
            */

            if ($document->isFullySigned()) {
                $document->update([
                    'status'    => SignedDocumentStatus::Completed,
                    'signed_at' => now(),
                ]);
            }

            return $document;
        });
    }
}
