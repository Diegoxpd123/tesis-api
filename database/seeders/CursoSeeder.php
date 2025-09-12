<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Curso;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cursos = [
            [
                'nombre' => 'Matemática',
                'institucionid' => 1,
                'is_actived' => 1,
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Comunicación',
                'institucionid' => 1,
                'is_actived' => 1,
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ciencias',
                'institucionid' => 1,
                'is_actived' => 1,
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Matemática',
                'institucionid' => 2,
                'is_actived' => 1,
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Comunicación',
                'institucionid' => 2,
                'is_actived' => 1,
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Matemática',
                'institucionid' => 3,
                'is_actived' => 1,
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Comunicación',
                'institucionid' => 3,
                'is_actived' => 1,
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($cursos as $curso) {
            Curso::updateOrCreate(
                [
                    'nombre' => $curso['nombre'],
                    'institucionid' => $curso['institucionid']
                ],
                $curso
            );
        }
    }
}
