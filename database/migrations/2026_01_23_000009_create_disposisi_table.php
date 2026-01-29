<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisposisiTable extends Migration
{
    public function up()
    {
        Schema::create('disposisi', function ($table) {
            $table->id();
            $table->foreignId('surat_masuk_id')->constrained('surat_masuk');
            $table->string('tujuan');
            $table->text('isi');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('disposisi');
    }
}