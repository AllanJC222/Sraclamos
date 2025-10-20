<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Asegúrate de importar la fachada DB

class UsuariologSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usamos DB::table para insertar los datos
        DB::table('usuariolog')->insert([
            [
                'user_name' => 'admin',
                'user_pass' => '$2y$12$bJaD1xYG5XX.tHChh23jEupQ0P1UfHOvOXGKdwlLyCT3J.Yy2mXJC',
                'user_tipo' => '1',
            ],
            [
                'user_name' => 'standard',
                'user_pass' => '$2y$12$bJaD1xYG5XX.tHChh23jEupQ0P1UfHOvOXGKdwlLyCT3J.Yy2mXJC',
                'user_tipo' => '2',
            ],
        ]);
    }
}