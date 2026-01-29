<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeDeskripsiNullableInKelas extends Migration
{
    public function up()
    {
        Schema::table('kelas', function (Blueprint $table) {
            if (Schema::hasColumn('kelas', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->change();
            }
        });
    }

    public function down()
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->text('deskripsi')->nullable(false)->change();
        });
    }
}
