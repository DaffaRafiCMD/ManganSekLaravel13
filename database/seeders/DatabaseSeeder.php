<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Data demo dari SQL asli ManganSek; hanya untuk database uji kosong.
        if (DB::table('users')->exists() || DB::table('tempat')->exists()) {
            throw new \RuntimeException('Seeder demo hanya untuk database kosong.');
        }
        DB::unprepared(file_get_contents(__DIR__.'/demo-data.sql'));
    }
}
