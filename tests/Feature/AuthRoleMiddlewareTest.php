<?php

use App\Models\AccountUser;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    /** @var TestCase $this */
    if (! Schema::hasTable('AccountUser')) {
        Schema::create('AccountUser', function (Blueprint $table): void {
            $table->increments('UserId');
            $table->string('Name')->nullable();
            $table->string('Username')->unique();
            $table->string('Email')->unique();
            $table->string('Password');
            $table->unsignedTinyInteger('Role')->default(2);
            $table->boolean('IsActive')->default(true);
            $table->dateTime('CreatedAt')->nullable();
        });
    }
});

it('redirects guests away from patient routes', function (): void {
    /** @var TestCase $this */
    $this->get(route('patient.appointment'))->assertRedirect(route('login'));
});

it('allows patients to access patient routes', function (): void {
    /** @var TestCase $this */
    $user = AccountUser::factory()->create([
        'Name' => fake()->name(),
        'Role' => 2,
        'IsActive' => true,
    ]);

    $this->actingAs($user)->get(route('patient.appointment'))->assertOk();
});

it('blocks patients from doctor routes', function (): void {
    /** @var TestCase $this */
    $user = AccountUser::factory()->create([
        'Name' => fake()->name(),
        'Role' => 2,
        'IsActive' => true,
    ]);

    $this->actingAs($user)->get(route('doctor.dashboard'))->assertRedirect(route('login'));
});

it('allows doctor sessions to access doctor routes', function (): void {
    /** @var TestCase $this */
    $this->withSession([
        'auth_type' => 'doctor',
        'doctor_id' => 1,
        'doctor_name' => 'Doctor Test',
    ])->get(route('doctor.dashboard'))->assertOk();
});
