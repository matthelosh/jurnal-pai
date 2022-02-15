<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSilabusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('silabuses', function (Blueprint $table) {
            $table->id();
            $table->string('kelas', 5);
            $table->string('semester', 20);
            $table->string('tapel', 30);
            $table->string('pertemuan', 60);
            $table->string('kd_id', 100);
            $table->text('indikator');
            $table->integer('pembelajaran_id');
            $table->text('proses');
            $table->text('media');
            $table->string('waktu', 100);
            $table->string('penilaian', 191);
            $table->string('karakter', 191);
            $table->string('keterangan', 30);
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
        Schema::dropIfExists('silabuses');
    }
}
