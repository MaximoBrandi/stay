<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Team;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('horario_cursos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Team::class);
            $table->string('day', 30);
            $table->time('aperturaClases');
            $table->time('inicioClases');
            $table->time('tardeClases');
            $table->time('ausenteClases');
            $table->time('finClases');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario_cursos');
    }
};
