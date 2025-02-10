<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            [
                "name" => "Bay",
                "province_id" => 34, // İstanbul
                "color" => "#FFFFFF",
                "is_active" => 0
            ],
            [
                "name" => "Fenerbahçe SK",
                "province_id" => 34, // İstanbul
                "color" => "#0000FF",
                "is_active" => 1
            ],
            [
                "name" => "Galatasaray SK",
                "province_id" => 34, // İstanbul
                "color" => "#FF0000",
                "is_active" => 1
            ],
            [
                "name" => "Beşiktaş JK",
                "province_id" => 34, // İstanbul
                "color" => "#000000",
                "is_active" => 1
            ],
            [
                "name" => "Trabzonspor",
                "province_id" => 61, // Trabzon
                "color" => "#6C0D45",
                "is_active" => 1
            ],
            [
                "name" => "Adana Demirspor",
                "province_id" => 1, // Adana
                "color" => "#007FFF",
                "is_active" => 1
            ],
            [
                "name" => "Kayserispor",
                "province_id" => 38, // Kayseri
                "color" => "#FFD700",
                "is_active" => 1
            ],
            [
                "name" => "Antalyaspor",
                "province_id" => 7, // Antalya
                "color" => "#FF0000",
                "is_active" => 1
            ],
            [
                "name" => "Gaziantep FK",
                "province_id" => 27, // Gaziantep
                "color" => "#FF4500",
                "is_active" => 1
            ],
            [
                "name" => "Konyaspor",
                "province_id" => 42, // Konya
                "color" => "#008000",
                "is_active" => 1
            ],
            [
                "name" => "Sivasspor",
                "province_id" => 58, // Sivas
                "color" => "#FF0000",
                "is_active" => 1
            ],
            [
                "name" => "Başakşehir FK",
                "province_id" => 34, // İstanbul
                "color" => "#FF4500",
                "is_active" => 1
            ],
            [
                "name" => "Alanyaspor",
                "province_id" => 7, // Antalya (Alanya)
                "color" => "#FFA500",
                "is_active" => 1
            ],
            [
                "name" => "Kasımpaşa SK",
                "province_id" => 34, // İstanbul
                "color" => "#0000FF",
                "is_active" => 1
            ],
            [
                "name" => "Hatayspor",
                "province_id" => 31, // Hatay
                "color" => "#800000",
                "is_active" => 1
            ],
            [
                "name" => "Pendikspor",
                "province_id" => 34, // İstanbul
                "color" => "#FFFFFF",
                "is_active" => 1
            ],
            [
                "name" => "Çaykur Rizespor",
                "province_id" => 53, // Rize
                "color" => "#008000",
                "is_active" => 1
            ],
            [
                "name" => "MKE Ankaragücü",
                "province_id" => 6, // Ankara
                "color" => "#FFD700",
                "is_active" => 1
            ],
            [
                "name" => "İstanbulspor",
                "province_id" => 34, // İstanbul
                "color" => "#FFD700",
                "is_active" => 1
            ],
        ];

        foreach ($teams as $team) {
            Team::query()->updateOrCreate(['name' => $team['name']], $team);
        }
    }
}
