<?php

namespace Database\Seeders;

use App\Models\ConstructionType;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ConstructionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!ConstructionType::count('id')){
            ConstructionType::factory()
                ->count(7)
                ->state(new Sequence(
                    ['id' => 1, 'name' => 'Áreas verdes', 'slug' => Str::slug('Áreas verdes')],
                    ['id' => 2, 'name' => 'Centro de barrio', 'slug' => Str::slug('Centro de barrio')],
                    ['id' => 3, 'name' => 'Equipamiento', 'slug' => Str::slug('Equipamiento')],
                    ['id' => 4, 'name' => 'Habitacional', 'slug' => Str::slug('Habitacional')],
                    ['id' => 5, 'name' => 'Habitacional y comercial', 'slug' => Str::slug('Habitacional y comercial')],
                    ['id' => 6, 'name' => 'Industrial', 'slug' => Str::slug('Industrial')],
                    ['id' => 7, 'name' => 'Sin Zonificación', 'slug' => Str::slug('Sin Zonificación')],
                ))
                ->create();
        }
    }
}
