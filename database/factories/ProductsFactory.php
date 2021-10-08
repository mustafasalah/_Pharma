<?php

namespace Database\Factories;

use App\Models\Categories;
use App\Models\Company;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Products::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name(),
            'barcode'=>$this->faker->ean13(),
            'unit'=>$this->faker->name(),
            'category'=>Categories::factory()->create(),
            'company'=>Company::factory()->create(),
            'ingredient'=>$this->faker->text(),
            'need_prescreption'=>$this->faker->boolean(20),
            'description'=>$this->faker->paragraph(),
            'usage_instructions'=>$this->faker->paragraphs(2),
            'warnings'=>$this->faker->paragraphs(),
            'side_effects'=>$this->faker->paragraph(),
            'photo'=>$this->faker->sentence()
        ];
    }
}
