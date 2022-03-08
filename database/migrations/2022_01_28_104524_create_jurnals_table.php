<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnals', function (Blueprint $table) {
            $table->id();
            $table->string('periode_id', 20);
            $table->string('sekolah_id', 20);
            $table->string('guru_id', 30);
            $table->string('rombel_id', 20);
            $table->string('kd_id', 100);
            $table->string('hari', 10);
            $table->date('tanggal');
            $table->string('tema', 191);
            $table->string('absensi_siswa', 100);
            $table->string('catatan', 191);
            $table->text('teks');
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
        Schema::dropIfExists('jurnals');
    }
}
