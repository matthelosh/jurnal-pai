<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protas', function (Blueprint $table) {
            $table->id();
            $table->string('tingkat', 2);
            $table->enum('semester',['1','2']);
            $table->string('pelajaran',3);
            $table->string('ki', 100);
            $table->string('kd', 100);
            $table->text('materi');
            $table->string('alokasi_waktu', 10);
            $table->enum('mode', ['normal', 'darurat'])->default('darurat');
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
        Schema::dropIfExists('protas');
    }
}
