<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        if (!User::where('email', 'admin@example.com')->exists()) {
            $admin = new User();
            $admin->name = 'Admin System';
            $admin->first_name = 'Admin';
            $admin->last_name = 'System';
            $admin->email = 'admin@example.com';
            $admin->password = Hash::make('password123');
            $admin->email_verified_at = now();
            $admin->save();
            // Update role after creation
            User::where('id', $admin->id)->update(['role' => 'admin']);
            $this->command->info('Admin user created: admin@example.com');
        }

        // Create Instruktur User
        if (!User::where('email', 'instruktur@example.com')->exists()) {
            $instruktur = new User();
            $instruktur->name = 'Instruktur System';
            $instruktur->first_name = 'Instruktur';
            $instruktur->last_name = 'System';
            $instruktur->email = 'instruktur@example.com';
            $instruktur->password = Hash::make('password123');
            $instruktur->email_verified_at = now();
            $instruktur->save();
            User::where('id', $instruktur->id)->update(['role' => 'instruktur']);
            $this->command->info('Instruktur user created: instruktur@example.com');
        }

        // Create Mahasiswa User
        if (!User::where('email', 'mahasiswa@example.com')->exists()) {
            $mahasiswa = new User();
            $mahasiswa->name = 'Mahasiswa System';
            $mahasiswa->first_name = 'Mahasiswa';
            $mahasiswa->last_name = 'System';
            $mahasiswa->email = 'mahasiswa@example.com';
            $mahasiswa->password = Hash::make('password123');
            $mahasiswa->email_verified_at = now();
            $mahasiswa->save();
            User::where('id', $mahasiswa->id)->update(['role' => 'mahasiswa']);
            $this->command->info('Mahasiswa user created: mahasiswa@example.com');
        }
    }
}
