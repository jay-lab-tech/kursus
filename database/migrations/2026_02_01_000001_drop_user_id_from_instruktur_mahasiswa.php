<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUserIdFromInstrukturMahasiswa extends Migration
{
    public function up()
    {
        // Drop user_id from instruktur
        Schema::table('instruktur', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        // Drop user_id from mahasiswa
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }

    public function down()
    {
        // Restore user_id to instruktur
        Schema::table('instruktur', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained('users');
        });

        // Restore user_id to mahasiswa
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained('users');
        });
    }
}
