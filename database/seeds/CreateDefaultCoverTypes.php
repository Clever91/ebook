<?php

use App\Models\Admin\CoverType;
use App\User;
use Illuminate\Database\Seeder;

class CreateDefaultCoverTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where('is_admin', 1)->first();

        // hard cover
        $cover = CoverType::create([
            'oz' => [
                'name' => "Қаттиқ",
                'is_default' => 0
            ],
            'uz' => [
                'name' => "Qattiq",
                'is_default' => 0
            ],
            'ru' => [
                'name' => "Твердый переплет",
                'is_default' => 0
            ],
            'en' => [
                'name' => "Hardcover",
                'is_default' => 1
            ],
            'status' => CoverType::STATUS_ACTIVE,
            'created_by' => $admin->id,
        ]);

        // soft cover
        $cover = CoverType::create([
            'oz' => [
                'name' => "Юмшоқ",
                'is_default' => 0
            ],
            'uz' => [
                'name' => "Yumshoq",
                'is_default' => 0
            ],
            'ru' => [
                'name' => "Мягкий переплет",
                'is_default' => 0
            ],
            'en' => [
                'name' => "Softcover",
                'is_default' => 1
            ],
            'status' => CoverType::STATUS_ACTIVE,
            'created_by' => $admin->id,
        ]);

        // skin cover
        $cover = CoverType::create([
            'oz' => [
                'name' => "Қаттиқ (тери)",
                'is_default' => 0
            ],
            'uz' => [
                'name' => "Qattiq (teri)",
                'is_default' => 0
            ],
            'ru' => [
                'name' => "Твердый переплет (кожа)",
                'is_default' => 0
            ],
            'en' => [
                'name' => "Hardcover (leather)",
                'is_default' => 1
            ],
            'status' => CoverType::STATUS_ACTIVE,
            'created_by' => $admin->id,
        ]);
    }
}
