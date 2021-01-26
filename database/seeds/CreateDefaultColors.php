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
            [ 'name' => "Red", 'short' => "🔴", 'hex' => "#FF0000" ],
            [ 'name' => "White", 'short' => "⚪️", 'hex' => "#FFFFFF" ],
            [ 'name' => "Silver", 'short' => "silver", 'hex' => "#Silver" ],
            [ 'name' => "Gray", 'short' => "gray", 'hex' => "#808080" ],
            [ 'name' => "Black", 'short' => "⚫️", 'hex' => "#000000" ],
            [ 'name' => "Maroon", 'short' => "maroon", 'hex' => "#800000" ],
            [ 'name' => "Yellow", 'short' => "🟡", 'hex' => "#FFFF00" ],
            [ 'name' => "Olive", 'short' => "olive", 'hex' => "#808000" ],
            [ 'name' => "Lime", 'short' => "lime", 'hex' => "#00FF00" ],
            [ 'name' => "Green", 'short' => "🟢", 'hex' => "#008000" ],
            [ 'name' => "Aqua", 'short' => "aqua", 'hex' => "#00FFFF" ],
            [ 'name' => "Teal", 'short' => "teal", 'hex' => "#008080" ],
            [ 'name' => "Blue", 'short' => "🔵", 'hex' => "#0000FF" ],
            [ 'name' => "Navy", 'short' => "navy", 'hex' => "#000080" ],
            [ 'name' => "Fuchsia", 'short' => "fuchsia", 'hex' => "#FF00FF" ],
            [ 'name' => "Purple", 'short' => "🟣", 'hex' => "#800080" ],
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
