<?php

namespace Database\Factories;

use App\Models\LuckyDraw;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

class LuckyDrawFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LuckyDraw::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create();
        }

        return [
            'user_id' => $this->faker->word,
            'random_number' => $this->faker->word,
            'result' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'win_amount' => $this->faker->numberBetween(0, 9223372036854775807),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
