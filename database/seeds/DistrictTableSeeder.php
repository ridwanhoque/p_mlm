<?php

use App\Models\District;
use Illuminate\Database\Seeder;

class DistrictTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $districts = '{
          "Barisal":   ["Barguna",  "Barisal",        "Bhola",    "Jhalokati",  "Patuakhali", "Pirojpur"],
          "Chittagong":["Bandarban","Brahmanbaria",   "Chandpur", "Chittagong", "Comilla",    "Cox\'s Bazar","Feni",     "Khagrachhari","Lakshmipur", "Noakhali", "Rangamati"],
          "Dhaka":     ["Dhaka",    "Faridpur",       "Gazipur",  "Gopalganj",  "Kishoreganj","Madaripur",  "Manikganj","Munshiganj",  "Narayanganj","Narsingdi","Rajbari","Shariatpur","Tangail"],
          "Khulna":    ["Bagerhat", "Chuadanga",      "Jessore",  "Jhenaidah",  "Khulna",     "Kushtia",    "Magura",   "Meherpur",    "Narail",     "Satkhira"],
          "Mymensingh":["Jamalpur", "Mymensingh",     "Netrakona","Sherpur"],
          "Rajshahi"  :["Bogra",    "Chapainawabganj","Joypurhat","Naogaon",    "Natore",     "Pabna",      "Rajshahi", "Sirajganj"],
          "Rangpur"   :["Dinajpur", "Gaibandha",      "Kurigram", "Lalmonirhat","Nilphamari", "Panchagarh", "Rangpur",  "Thakurgaon"],
          "Sylhet"    :["Habiganj", "Moulvibazar",    "Sunamganj","Sylhet"]
        }';

        foreach (json_decode($districts) as $key => $district){
            foreach ($district as $d){
                District::query()->forceCreate([
                    'name' => $d,
                    'is_outside_dhaka' => ($key == 'Dhaka') ? 1 : 0
                ]);
            }

        }
    }
}
