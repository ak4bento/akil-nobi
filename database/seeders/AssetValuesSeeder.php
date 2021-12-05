<?php

namespace Database\Seeders;

use App\Models\AssetValues;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AssetValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i <= 40; $i++) {     
            $faker = Faker::create('id_ID');

            $model = new AssetValues;

            $user = new User;
            $totalUnit = $user->getTotalUnit();

            $model->nab = 1;
            if ($totalUnit > 0) {
                $model->nab = round($faker->numberBetween(1,3000) / $totalUnit, 4, PHP_ROUND_HALF_DOWN);
            }

            $model->current_balance = $faker->numberBetween(1,3000);
            $model->save();
            
        }
    }
}
