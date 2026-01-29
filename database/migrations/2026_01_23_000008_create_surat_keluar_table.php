<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratKeluarTable extends Migration
{
    public function up()
    {
        Schema::create('surat_keluar', function ($table) {
            $table->id();
            $table->string('nomor_surat');
            $table->string('tujuan');
            $table->string('perihal');
            $table->date('tanggal');
            $table->string('file');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('surat_keluar');
    }
}