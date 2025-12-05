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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            // Clave Foránea a la tabla users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('bio')->nullable();

            $table->timestamps();

            // Aseguramos que un usuario solo tenga un perfil
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
