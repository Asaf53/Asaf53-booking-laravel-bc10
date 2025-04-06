<?php

namespace Database\Seeders;

use App\Models\property;
use App\Models\property_rooms;
use App\Models\property_images;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class properties extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all property_type IDs
        $propertyTypes = DB::table('property_types')->pluck('id', 'name');

        $propertyTypeNames = ['Villas', 'Resorts', 'Hotels', 'Apartments'];

        foreach (range(1, 10) as $i) {
            $typeName = $faker->randomElement($propertyTypeNames);
            $propertyTypeId = $propertyTypes[$typeName] ?? null;

            if (!$propertyTypeId) continue;

            $property = property::create([
                'user_id' => 3,
                'property_type_id' => $propertyTypeId,
                'name' => $faker->company . ' ' . ucfirst($typeName),
                'locations' => $faker->address,
                'country_id' => rand(1, 5),
                'city_id' => rand(1, 10),
            ]);

            // Add rooms
            foreach (range(1, rand(2, 5)) as $roomIndex) {
                property_rooms::create([
                    'property_id' => $property->id,
                    'capacity' => $faker->randomElement(['1', '2', '4']),
                    'price' => $faker->numberBetween(30, 300),
                    'number' => $roomIndex,
                    'singel_beds' => rand(1, 2),
                    'double_beds' => rand(0, 2),
                ]);
            }

            // Add images
            foreach (range(1, rand(2, 4)) as $img) {
                property_images::create([
                    'property_id' => $property->id,
                    'image' => $faker->imageUrl(800, 600, 'house', true),
                ]);
            }
        }
    }
}
