<?php use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKelasTableAddColumns extends Migration
{
    public function up()
    {
        Schema::table('kelas', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('kelas', 'kode_kelas')) {
                $table->string('kode_kelas')->unique()->after('id');
            }
            if (!Schema::hasColumn('kelas', 'kapasitas')) {
                $table->integer('kapasitas')->nullable()->after('nama_kelas');
            }
            if (!Schema::hasColumn('kelas', 'tahun_akademik')) {
                $table->string('tahun_akademik')->nullable()->after('kapasitas');
            }
            if (!Schema::hasColumn('kelas', 'instruktur_id')) {
                $table->unsignedBigInteger('instruktur_id')->nullable()->after('tahun_akademik');
            }
        });
    }

    public function down()
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn(['kode_kelas', 'kapasitas', 'tahun_akademik', 'instruktur_id']);
        });
    }
}
