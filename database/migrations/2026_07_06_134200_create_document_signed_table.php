<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_signed', function (Blueprint $table) {
            $table->id();

            // UUID utilizado no QR Code
            $table->uuid('uuid')->unique();

            // Ex.: history, second_call...
            $table->string('document_type', 50);

            // Model responsável pelo documento
            $table->string('document_model');

            // ID do registro original
            $table->unsignedBigInteger('document_id');

            $table->index(['document_model', 'document_id']);

            // Caminho do PDF oficial
            $table->string('file_path')->nullable();

            // SHA-256 do PDF
            $table->string('hash', 64)->nullable();



            // Quem iniciou o processo de assinatura
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            // Status do documento
            $table->string('status', 20)->default('current');

            // Motivo da revogação
            $table->text('revocation_reason')->nullable();

            // Documento que substituiu este
            $table->unsignedBigInteger('replaced_by')->nullable();

            // Data da assinatura
            $table->timestamp('signed_at')->nullable();

            // Data da revogação
            $table->timestamp('revoked_at')->nullable();

            $table->timestamps();
            $table->string('updated_by', 50)->nullable();
            /*Excluido */
            $table->date('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();
        });

        // Adiciona a FK após a criação da tabela
        Schema::table('document_signed', function (Blueprint $table) {
            $table->foreign('replaced_by')
                ->references('id')
                ->on('document_signed')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('document_signed', function (Blueprint $table) {
            $table->dropForeign(['replaced_by']);
        });

        Schema::dropIfExists('document_signed');
    }
};
