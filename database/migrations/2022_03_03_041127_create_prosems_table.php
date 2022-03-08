<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProsemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prosems', function (Blueprint $table) {
            $table->id();
            $table->string('sekolah_id', 30);
            $table->string('guru_id', 30);
            $table->string('periode', 10);
            $table->string('hari', 30);
            $table->string('rombel_id', 30);
            $table->string('pelajaran', 3);
            $table->string('kds', 100);
            $table->string('bulan', 5);
            $table->string('minggu', 5);
            $table->enum('mode', ['normal','darurat'])->default('darurat');
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
        Schema::dropIfExists('prosems');
    }
}
