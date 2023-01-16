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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('portada')->nullable();
            $table->string('titulo');
            $table->string('descripcion')->nullable();
            $table->string('url')->nullable();
            $table->string('categoria')->nullable();
            $table->enum('estado',[1,2])->default(2);
            $table->date('fecha_publicacion');
            $table->softDeletes('deleted_at')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
