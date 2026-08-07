<?php

namespace Database\Factories;

use App\Models\AccountUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<AccountUser>
 */
class AccountUserFactory extends Factory
{
    protected $model = AccountUser::class;

    protected static ?string $password;

    public function definition(): array
    {
        return [
            'Name' => fake()->name(),
            'Username' => fake()->unique()->userName(),
            'Email' => fake()->unique()->safeEmail(),
            'Password' => static::$password ??= Hash::make('password'),
            'Role' => 2,
            'IsActive' => true,
        ];
    }
}