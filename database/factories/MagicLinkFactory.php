<?php

namespace Database\Factories;

use App\Models\MagicLink;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

class MagicLinkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MagicLink::class;

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
            'hash' => $this->faker->text($this->faker->numberBetween(5, 36)),
            'user_id' => $this->faker->word,
            'expires_at' => $this->faker->date('Y-m-d H:i:s'),
            'is_active' => $this->faker->boolean,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
