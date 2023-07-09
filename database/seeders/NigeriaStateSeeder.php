<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class NigeriaStateSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {

        $country = Country::where('name', 'Nigeria')->first();
        $country_id = $country->id;

        DB::table('states')->delete();

        $states = array(
            array('name' => 'Abuja Federal Capital Territory', 'code' => 'FCT', 'country_id' => $country_id),
            array('name' => 'Abia', 'code' => 'AB', 'country_id' => $country_id),
            array('name' => 'Adamawa', 'code' => 'AD', 'country_id' => $country_id),
            array('name' => 'Akwa Ibom', 'code' => 'AK', 'country_id' => $country_id),
            array('name' => 'Anambra', 'code' => 'AN', 'country_id' => $country_id),
            array('name' => 'Bauchi', 'code' => 'BA', 'country_id' => $country_id),
            array('name' => 'Bayelsa', 'code' => 'BY', 'country_id' => $country_id),
            array('name' => 'Benue', 'code' => 'BE', 'country_id' => $country_id),
            array('name' => 'Borno', 'code' => 'BO', 'country_id' => $country_id),
            array('name' => 'Cross River', 'code' => 'CR', 'country_id' => $country_id),
            array('name' => 'Delta', 'code' => 'DE', 'country_id' => $country_id),
            array('name' => 'Ebonyi', 'code' => 'EB', 'country_id' => $country_id),
            array('name' => 'Edo', 'code' => 'ED', 'country_id' => $country_id),
            array('name' => 'Ekiti', 'code' => 'EK', 'country_id' => $country_id),
            array('name' => 'Enugu', 'code' => 'EN', 'country_id' => $country_id),
            array('name' => 'Gombe', 'code' => 'GO', 'country_id' => $country_id),
            array('name' => 'Imo', 'code' => 'IM', 'country_id' => $country_id),
            array('name' => 'Jigawa', 'code' => 'JI', 'country_id' => $country_id),
            array('name' => 'Kaduna', 'code' => 'KD', 'country_id' => $country_id),
            array('name' => 'Kano', 'code' => 'KN', 'country_id' => $country_id),
            array('name' => 'Katsina', 'code' => 'KT', 'country_id' => $country_id),
            array('name' => 'Kebbi', 'code' => 'KE', 'country_id' => $country_id),
            array('name' => 'Kogi', 'code' => 'KO', 'country_id' => $country_id),
            array('name' => 'Kwara', 'code' => 'KW', 'country_id' => $country_id),
            array('name' => 'Lagos', 'code' => 'LA', 'country_id' => $country_id),
            array('name' => 'Nassarawa', 'code' => 'NA', 'country_id' => $country_id),
            array('name' => 'Niger', 'code' => 'NI', 'country_id' => $country_id),
            array('name' => 'Ogun', 'code' => 'OG', 'country_id' => $country_id),
            array('name' => 'Ondo', 'code' => 'ON', 'country_id' => $country_id),
            array('name' => 'Osun', 'code' => 'OS', 'country_id' => $country_id),
            array('name' => 'Oyo', 'code' => 'OY', 'country_id' => $country_id),
            array('name' => 'Plateau', 'code' => 'PL', 'country_id' => $country_id),
            array('name' => 'Rivers', 'code' => 'RI', 'country_id' => $country_id),
            array('name' => 'Sokoto', 'code' => 'SO', 'country_id' => $country_id),
            array('name' => 'Taraba', 'code' => 'TA', 'country_id' => $country_id),
            array('name' => 'Yobe', 'code' => 'YO', 'country_id' => $country_id),
            array('name' => 'Zamfara', 'code' => 'ZA', 'country_id' => $country_id)
        );


        DB::table('states')->insert($states);
    }
}