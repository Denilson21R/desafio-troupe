<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'last_name' => $this->faker->lastName,
            'cpf' => $this->geraCpf(), //melhorar
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'cep' => $this->geraCep(), //melhorar
            'public_place' => $this->faker->streetAddress,
            'district' => $this->faker->streetName,
            'uf' => strtoupper(Str::random(2)),
            'city' => $this->faker->city,
        ];
    }

    private function geraCpf(){
        return $this->faker->randomNumber(3).'.'.$this->faker->randomNumber(3).'.'.$this->faker->randomNumber(3).'-'.$this->faker->randomNumber(2);
    }

    private function geraCep(){
        return $this->faker->randomNumber(2).'.'.$this->faker->randomNumber(3).'-'.$this->faker->randomNumber(3);
    }
}
