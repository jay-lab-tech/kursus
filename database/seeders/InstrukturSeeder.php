<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstrukturSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create instruktur record for User ID 4 (Azhar Noermansyah)
        \DB::table('instruktur')->insert([
            'user_id' => 4,
            'nip' => 'NIP-AZHAR-2026',
            'nama' => 'Azhar Noermansyah',
            'keahlian' => 'Pemrograman',
            'spesialisasi' => 'Web Development',
            'no_hp' => '082234567890',
            'alamat' => 'Jakarta, Indonesia',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
