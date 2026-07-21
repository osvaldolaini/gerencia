<?php

namespace App\Traits\Signatures;

use App\Enums\SignedDocumentStatus;
use App\Models\Signatures\DocumentSigned;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

trait PdfSignatureTrait
{

    /**
     * Gera o bloco de autenticação do documento.
     */
    protected function generateQrCode(DocumentSigned $document): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(70),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);

        $svg = $writer->writeString(
            route('documents.show', $document->uuid)
        );

        // Remove a declaração XML
        return preg_replace('/<\?xml.*?\?>\s*/', '', $svg);
    }

    /**
     * Adiciona o bloco de assinaturas ao final do PDF.
     */
    protected function appendSignatureBlock(
        Mpdf $mpdf,
        DocumentSigned $document
    ): void {

        $document->loadMissing([
            'signatures.signer.user',
        ]);

        $html = view(
            'components.pdf.signatures.signature-block',
            [
                'document' => $document,
                'authenticationBlock'   => $this->generateQrCode($document),
            ]
        )->render();

        $mpdf->WriteHTML($html);
    }

    /**
     * Salva o PDF oficial no armazenamento público,
     * registra o caminho do arquivo no documento e
     * atualiza o hash SHA-256 para garantir a integridade
     * do documento assinado.
     */
    protected function saveSignedPdf(
        Mpdf $mpdf,
        DocumentSigned $document,
        string $filename
    ): string {

        $directory = 'documents/signed';

        Storage::disk('public')->makeDirectory($directory);

        $path = $directory . '/' . $filename;

        $fullPath = Storage::disk('public')->path($path);

        // Salva o PDF
        $mpdf->Output(
            $fullPath,
            \Mpdf\Output\Destination::FILE
        );

        // Calcula a hash do arquivo gerado
        $hash = hash_file('sha256', $fullPath);

        // Atualiza o documento
        $document->update([
            'file_path' => $path,
            'hash'      => $hash,
            'signed_at' => now(),
            'status'    => SignedDocumentStatus::Completed,
        ]);

        $this->linkPreviousDocument($document);

        return $path;
    }

    /**
     * Vincula o último documento revogado ao novo documento oficial.
     *
     * Deve ser chamada após a geração do novo PDF oficial.
     */
    protected function linkPreviousDocument(DocumentSigned $newDocument): void
    {
        $previousDocument = DocumentSigned::where([
            'document_model' => $newDocument->document_model,
            'document_id'    => $newDocument->document_id,
            'status'         => SignedDocumentStatus::Cancelled,
        ])
            ->whereNull('replaced_by')
            ->where('id', '<>', $newDocument->id)
            ->latest('revoked_at')
            ->first();

        if (!$previousDocument) {
            return;
        }

        $previousDocument->update([
            'replaced_by' => $newDocument->id,
        ]);
    }


    /**
     * Verifica se já existe PDF oficial.
     */
    protected function hasOfficialPdf(
        DocumentSigned $document
    ): bool {

        if (!$document->file_path) {
            return false;
        }

        return Storage::disk('public')
            ->exists($document->file_path);
    }

    /**
     * Retorna o caminho absoluto do PDF oficial.
     */
    protected function officialPdfPath(
        DocumentSigned $document
    ): ?string {

        if (!$this->hasOfficialPdf($document)) {
            return null;
        }

        return Storage::disk('public')
            ->path($document->file_path);
    }

    /**
     * Retorna a URL pública do PDF oficial.
     */
    protected function officialPdfUrl(
        DocumentSigned $document
    ): ?string {

        if (!$this->hasOfficialPdf($document)) {
            return null;
        }

        return Storage::url($document->file_path);
    }

    /**
     * Remove o PDF oficial.
     */
    protected function deleteOfficialPdf(
        DocumentSigned $document
    ): void {

        if (
            $document->file_path &&
            Storage::disk('public')->exists($document->file_path)
        ) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->update([
            'file_path' => null,
        ]);
    }
}
