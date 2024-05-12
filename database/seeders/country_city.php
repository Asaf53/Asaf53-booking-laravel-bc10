<?php

namespace Database\Seeders;

use App\Models\city;
use App\Models\country;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class country_city extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apiUrl = 'https://www.jsonkeeper.com/b/OST0';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Curl error: ' . curl_error($curl);
        }
        curl_close($curl);

        $cities = [];
        $data = json_decode($response, true);
        foreach ($data['countries'] as $country) {
            $newCountry = country::create(['name' => $country['name']]);

            foreach ($country['cities'] as $city) {
                $cities[] = [
                    'country_id' => $newCountry->id,
                    'name' => $city['name']
                ];
            }
        }
        city::insert($cities);
    }
}
