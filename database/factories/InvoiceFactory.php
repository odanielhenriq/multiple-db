<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id'            => Str::uuid(),
            'user_id'       => null,
            'due_date'      => $this->faker->dateTimeBetween('-3 months', '+3 months'),
            'value'         => $this->faker->randomFloat(2, 100, 1000),
            'payment_date'  => $this->faker->optional()->dateTimeBetween('-2 months', 'now'),
            'payment_value' => $this->faker->optional()->randomFloat(2, 100, 1000),
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }
}
