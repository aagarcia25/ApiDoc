<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correos_foro', function (Blueprint $table) {
                $table->uuid('id')->primary();

                $table->string('nombre', 200);
                $table->string('apellido_paterno', 200);
                $table->string('apellido_materno', 200)->nullable();
                $table->string('cargo');
                $table->string('ente');

                $table->dateTime('acceso_jueves')->nullable();
                $table->dateTime('acceso_viernes')->nullable();

                $table->string('correo')->unique();
                $table->string('telefono', 20)->nullable();
                $table->enum('status_envio', ['OK', 'ERR'])->default('OK');

                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('correos_foro');
    }
};
