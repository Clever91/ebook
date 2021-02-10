<?php

use App\Models\Admin\Color;
use App\User;
use Google\Auth\Cache\Item;
use Illuminate\Database\Seeder;

class CreateDefaultColors extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = [
            [ 'name' => "Qizil", 'short' => "🔴", 'hex' => "#FF0000" ],
            [ 'name' => "Orange", 'short' => "🟠", 'hex' => "#e17d01" ],
            [ 'name' => "Oq", 'short' => "⚪️", 'hex' => "#FFFFFF" ],
            [ 'name' => "Qora", 'short' => "⚫️", 'hex' => "#000000" ],
            [ 'name' => "Sariq", 'short' => "🟡", 'hex' => "#FFFF00" ],
            [ 'name' => "Yashil", 'short' => "🟢", 'hex' => "#008000" ],
            [ 'name' => "Ko'k", 'short' => "🔵", 'hex' => "#0000FF" ],
            [ 'name' => "Fioletoviy", 'short' => "🟣", 'hex' => "#ab26ff" ],
            [ 'name' => "Jigarrang", 'short' => "🟤", 'hex' => "#76401b" ],
        ];

        foreach($colors as $item) {
            $color = Color::create([
                'name' => $item['name'],
                'short' => $item['short'],
                'hex' => $item['hex'],
                'status' => Color::STATUS_ACTIVE
            ]);
        }
    }
}
