<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHariTable extends Migration
{
    public function up()
    {
        Schema::create('hari', function ($table) {
            $table->id();
            $table->string('nama_hari');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hari');
    }
}