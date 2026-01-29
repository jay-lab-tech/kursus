<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRisalahTable extends Migration
{
    public function up()
    {
        Schema::create('risalah', function ($table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('instruktur_id')->constrained('instruktur')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('judul');
            $table->text('isi');
            $table->text('catatan_penting')->nullable();
            $table->integer('peserta_hadir')->default(0);
            $table->text('file')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('risalah');
    }
}