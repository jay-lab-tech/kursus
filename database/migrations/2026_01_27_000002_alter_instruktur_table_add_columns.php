<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInstrukturTableAddColumns extends Migration
{
    public function up()
    {
        Schema::table('instruktur', function (Blueprint $table) {
            // Make keahlian nullable if it exists
            if (Schema::hasColumn('instruktur', 'keahlian')) {
                $table->string('keahlian')->nullable()->change();
            }
            if (!Schema::hasColumn('instruktur', 'nip')) {
                $table->string('nip')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('instruktur', 'spesialisasi')) {
                $table->string('spesialisasi')->nullable()->after('keahlian');
            }
            if (!Schema::hasColumn('instruktur', 'alamat')) {
                $table->text('alamat')->nullable()->after('no_hp');
            }
        });
    }

    public function down()
    {
        Schema::table('instruktur', function (Blueprint $table) {
            $table->dropColumn(['nip', 'spesialisasi', 'alamat']);
        });
    }
}
