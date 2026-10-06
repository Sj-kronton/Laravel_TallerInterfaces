<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('platos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->decimal('precio', 10, 2);
            $table->text('descripcion');
            $table->string('imagen'); // ruta relativa, ej: platos/2026/09/hamburguesa-artesanal.png
            $table->timestamps();
            $table->softDeletes();    // requerido por el "soft delete" del Módulo 2
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('platos');
    }
};