<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterJadwalTableAddColumns extends Migration
{
    public function up()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            if (!Schema::hasColumn('jadwal', 'ruangan')) {
                $table->string('ruangan')->nullable()->after('jam_selesai');
            }
        });
    }

    public function down()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropColumn(['ruangan']);
        });
    }
}
