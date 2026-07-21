<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('document_signatures', function (Blueprint $table) {
            $table->id();

            // Documento oficial assinado
            $table->foreignId('document_signed_id')
                ->nullable()
                ->constrained('document_signed')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Assinante autorizado
            $table->foreignId('document_signer_id')
                ->nullable()
                ->constrained('document_signers')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Função exercida nesta assinatura
            $table->string('role', 30);

            // Ordem da assinatura (1, 2, 3...)
            $table->unsignedTinyInteger('order')->default(1);

            // IP de quem assinou
            $table->ipAddress('ip')->nullable();

            // Data e hora da assinatura
            $table->timestamp('signed_at');

            $table->timestamps();
            $table->string('updated_by', 50)->nullable();
            $table->string('created_by', 50)->nullable();
            /*Excluido */
            $table->date('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();

            // Impede que o mesmo assinante assine duas vezes
            // na mesma função para o mesmo documento
            $table->unique(
                ['document_signed_id', 'document_signer_id', 'role'],
                'doc_sign_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_signatures');
    }
};
