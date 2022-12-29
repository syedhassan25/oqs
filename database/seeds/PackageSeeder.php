<?php

use Illuminate\Database\Seeder;
use App\models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $days = 5;
        $prices = [20, 29, 39, 58, 59];
        $discounts = [30, 30, 30, 30, 40];
        $count = 1;
        for($i = 0; $i< $days; $i++){
            Package::create([
                'name' => $count.' Day Package',
                'days' => $count,
                'discount' => $discounts[$i],
                'duration' => 30,
                'amount' => $prices[$i]
            ]);
            $count++;
        }

        $days = 5;
        $prices = [16, 25, 30, 38, 39];
        $discounts = [30, 30, 30, 30, 40];
        $count = 1;
        for($i = 0; $i< $days; $i++){
            Package::create([
                'name' => $count.' Day Package',
                'days' => $count,
                'discount' => $discounts[$i],
                'duration' => 30,
                'amount' => $prices[$i],
                'currency' => "GBP"
            ]);
            $count++;
        }

        $days = 5;
        $prices = [20, 29, 39, 58, 59];
        $discounts = [30, 30, 30, 30, 40];
        $count = 1;
        for($i = 0; $i< $days; $i++){
            Package::create([
                'name' => $count.' Day Package',
                'days' => $count,
                'discount' => $discounts[$i],
                'duration' => 30,
                'amount' => $prices[$i],
                'currency' => "CAD"
            ]);
            $count++;
        }

        $days = 5;
        $prices = [18, 25, 35, 44, 45];
        $discounts = [30, 30, 30, 30, 40];
        $count = 1;
        for($i = 0; $i< $days; $i++){
            Package::create([
                'name' => $count.' Day Package',
                'days' => $count,
                'discount' => $discounts[$i],
                'duration' => 30,
                'amount' => $prices[$i],
                'currency' => "EUR"
            ]);
            $count++;
        }
    }
}
