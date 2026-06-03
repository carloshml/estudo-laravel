<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Drop FK em locacao_item que referencia pessoas
        Schema::table('locacao_item', function (Blueprint $table) {
            $table->dropForeign(['pessoa_id']);
        });

        // Drop tabela pessoas
        Schema::dropIfExists('pessoas');

        // Criar tabela clientes com mesmos campos
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('idade');
            $table->string('documento');
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        // Renomear coluna pessoa_id → cliente_id em locacao_item
        Schema::table('locacao_item', function (Blueprint $table) {
            $table->renameColumn('pessoa_id', 'cliente_id');
        });

        // Recriar FK apontando para clientes
        Schema::table('locacao_item', function (Blueprint $table) {
            $table->foreign('cliente_id')->references('id')->on('clientes')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('locacao_item', function (Blueprint $table) {
            $table->dropForeign(['cliente_id']);
            $table->renameColumn('cliente_id', 'pessoa_id');
        });

        Schema::dropIfExists('clientes');

        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('idade');
            $table->string('documento');
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        Schema::table('locacao_item', function (Blueprint $table) {
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->cascadeOnDelete();
        });
    }
};
