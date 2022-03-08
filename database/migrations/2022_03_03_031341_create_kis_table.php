<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kis', function (Blueprint $table) {
            $table->id();
            $table->string('tingkat', 2);
            $table->string('kode_ki', 5);
            $table->text('teks');
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
        Schema::dropIfExists('kis');
    }
}
