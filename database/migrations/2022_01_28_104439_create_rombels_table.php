<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRombelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rombels', function (Blueprint $table) {
            $table->id();
            $table->string('periode_id', 15);
            $table->string('sekolah_id', 30);
            $table->string('guru_id', 30);
            $table->string('kode_rombel', 30);
            $table->string('nama_rombel', 20);
            $table->string('tingkat', 2);
            $table->integer('siswa');
            $table->integer('siswi');
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('rombels');
    }
}
