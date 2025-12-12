<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 5),
            'first_name'  => $this->faker->firstName,
            'last_name'   => $this->faker->lastName,
            'gender'      => $this->faker->numberBetween(1, 3),
            'email'       => $this->faker->unique()->safeEmail,
            'tel'         => '0' . $this->faker->numberBetween(70, 90) . $this->faker->numberBetween(10000000, 99999999),
            'address'     => $this->faker->address,
            'building'    => $this->faker->optional()->secondaryAddress,
            'detail'      => $this->faker->realText(50),
        ];
    }
}
