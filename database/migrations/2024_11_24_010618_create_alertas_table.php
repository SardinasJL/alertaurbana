<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alertas', function (Blueprint $table) {
            $table->id();
            $table->string("descripcion", 200);
            $table->string("direccion", 100);
            $table->decimal("latitud", 10, 8);
            $table->decimal("longitud", 10, 8);
            $table->string("foto", 30);
            $table->foreignId("users_id")->references("id")->on("users");
            $table->foreignId("estados_id")->references("id")->on("estados");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alertas');
    }
};
