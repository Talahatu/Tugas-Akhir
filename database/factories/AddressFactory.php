<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = FakerFactory::create('id_ID');
        return [
            "user_id" => $faker->numberBetween(1, 5),
            "name" => $faker->address(),
            "lat" => $faker->latitude,
            "long" => $faker->longitude,
            "current" => 1
        ];
    }
}