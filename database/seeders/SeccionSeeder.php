<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seccion;

class SeccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $secciones = [
            [
                'nombre' => 'A',
                'institucionid' => 1,
                'is_actived' => 1,
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'B',
                'institucionid' => 1,
                'is_actived' => 1,
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'C',
                'institucionid' => 1,
                'is_actived' => 1,
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'A',
                'institucionid' => 2,
                'is_actived' => 1,
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'B',
                'institucionid' => 2,
                'is_actived' => 1,
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'A',
                'institucionid' => 3,
                'is_actived' => 1,
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'B',
                'institucionid' => 3,
                'is_actived' => 1,
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($secciones as $seccion) {
            Seccion::updateOrCreate(
                [
                    'nombre' => $seccion['nombre'],
                    'institucionid' => $seccion['institucionid']
                ],
                $seccion
            );
        }
    }
}
