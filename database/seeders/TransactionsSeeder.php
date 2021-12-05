<?php

namespace Database\Seeders;

use App\Models\AssetValues;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 400; $i++) { 
            
            $faker = Faker::create('id_ID');
            $uid = User::all()->random()->id;

            $assetValues = AssetValues::orderBy('created_at', 'desc')->first();
            $user = User::find($uid);
            $transactions = new Transactions;

            $transactions->user_id = $uid;
            $transactions->amount = $faker->numberBetween(10000, 1000000);
            $transactions->unit_value = round($transactions->amount / $assetValues->nab, 4, PHP_ROUND_HALF_DOWN);

            $transactions->type = 'Topup';
            $user->total_unit += $transactions->unit_value;
            $transactions->total_unit_value = round($user->total_unit, 4, PHP_ROUND_HALF_DOWN);
            $transactions->total_balance = round($transactions->total_unit_value * $assetValues->nab, 4, PHP_ROUND_HALF_DOWN);

            $user->save();
            $transactions->save();

        }
    }
}
