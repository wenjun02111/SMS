<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'USERID' => 'U' . fake()->unique()->numerify('###'),
            'EMAIL' => fake()->unique()->safeEmail(),
            'PASSWORDHASH' => static::$password ??= Hash::make('password'),
            'SYSTEMROLE' => 'Dealer',
            'ISACTIVE' => true,
            'ALIAS' => fake()->firstName(),
            'COMPANY' => fake()->company(),
            'POSTCODE' => fake()->postcode(),
            'CITY' => fake()->city(),
            'LASTLOGIN' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'LASTLOGIN' => null,
        ]);
    }
}
