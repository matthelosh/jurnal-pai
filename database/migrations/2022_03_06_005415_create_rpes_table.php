<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRpesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rpes', function (Blueprint $table) {
            $table->id();
            $table->string('guru_id',30);
            $table->string('tapel',5);
            $table->string('bulan', 20);
            $table->string('hari', 20);
            $table->string('tanggals', 191);
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
        Schema::dropIfExists('rpes');
    }
}
