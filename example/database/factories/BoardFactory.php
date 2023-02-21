<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Board>
 */
class BoardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $randomDigit = $this->faker->numberBetween();

        return [
            "name" => strip_tags("board{$randomDigit}"),
            "name_ko" => strip_tags("게시판{$randomDigit}"),
            "description" => strip_tags(
                "자동으로 생성한 게시판{$randomDigit} 입니다."
            ),
        ];
    }
}
