<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $path = $this->faker->image(storage_path('app/public/products'),640,480, null, false);
        $thumbnail = $this->faker->image(storage_path('app/public/thumbnail'),100,100, null, false);


        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(100),
            'price' => $this->faker->randomNumber(2),
            'image' => 'products/'.$path,
            'category_id' => $this->faker->numberBetween(1, 2),
            'thumbnail' => 'thumbnail/'.$thumbnail
        ];
    }
}
