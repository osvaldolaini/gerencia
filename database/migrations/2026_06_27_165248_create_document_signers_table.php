<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_signers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('signature_password');
            $table->string('role', 30);

            $table->string('certificate_path')->nullable();

            $table->text('certificate_password')->nullable();

            $table->boolean('active')->default(true);

            $table->timestamps();
            $table->string('updated_by', 50)->nullable();
            $table->string('created_by', 50)->nullable();
            /*Excluido */
            $table->date('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();

            // $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_signers');
    }
};
