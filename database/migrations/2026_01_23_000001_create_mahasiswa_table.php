<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTable extends Migration
{
    public function up()
    {
        Schema::create('mahasiswa', function ($table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('nim');
            $table->string('nama');
            $table->string('jurusan');
            $table->year('angkatan');
            $table->string('no_hp');
            $table->string('alamat');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}