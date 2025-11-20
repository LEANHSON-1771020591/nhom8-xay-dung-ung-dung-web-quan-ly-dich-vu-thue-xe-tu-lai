<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Car;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('migrate');
    $this->seed(Database\Seeders\DatabaseSeeder::class);
});

it('loads home and about pages', function () {
    $this->get('/')->assertStatus(200);
    $this->get('/about')->assertStatus(200);
});

it('filters cars by location', function () {
    $car = Car::first();
    expect($car)->not()->toBeNull();
    $this->get('/filter/' . $car->location)->assertStatus(200);
});

it('shows car detail page', function () {
    $car = Car::first();
    expect($car)->not()->toBeNull();
    $this->get('/car/' . $car->slug)->assertStatus(200);
});

it('registers user and accesses owner page', function () {
    $res = $this->post('/register', [
        'username' => 'testuser',
        'email' => 'testuser@example.com',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ]);
    $res->assertRedirect('/my-trips');
    $this->get('/owner')->assertStatus(200);
});

it('books and cancels a trip', function () {
    // Register renter
    $this->post('/register', [
        'username' => 'renter',
        'email' => 'renter@example.com',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ])->assertRedirect('/my-trips');

    $renter = User::where('email', 'renter@example.com')->first();
    expect($renter)->not()->toBeNull();

    // Pick a car not owned by renter
    $car = Car::where('owner_id', '!=', $renter->id)->first();
    expect($car)->not()->toBeNull();

    $end = Carbon::today()->addDays(2)->toDateString();
    $this->post('/book/' . $car->id, [
        'end_date' => $end,
    ])->assertRedirect('/my-trips');

    $booking = Booking::where('user_id', $renter->id)->where('car_id', $car->id)->first();
    expect($booking)->not()->toBeNull();
    expect($booking->status)->toBe('confirmed');

    // Cancel
    $this->post('/bookings/' . $booking->id . '/cancel')->assertRedirect('/my-trips');
    $booking->refresh();
    expect($booking->status)->toBe('cancelled');
});

it('registers admin and sees dashboard', function () {
    $this->post('/admin/register', [
        'username' => 'adminuser',
        'email' => 'admin@example.com',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ])->assertRedirect('/admin');

    $this->get('/admin')->assertStatus(200);
});