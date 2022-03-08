<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaldiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kaldiks', function (Blueprint $table) {
            $table->id();
            $table->string('guru_id', 50);
            $table->string('tapel', 5);
            $table->string('name', 150);
            $table->string('start', 20);
            $table->string('end', 20);
            $table->text('detail');
            $table->string('location', 100);
            $table->boolean('isEfektif')->default(0);
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
        Schema::dropIfExists('kaldiks');
    }
}
