<?php
/**
 *  File Doc Comment
 * php version 8.0.7
 *
 * @category  Factory
 * @package   Factory
 * @author    @OxSama <mhmdtageldin@gmail.com>
 * @copyright 2021 Pharma.com.sd
 * @license   GNU General Public License version 2 or later; see LICENSE
 * @link      https://pharma.com.sd
 */
namespace Database\Factories;

use App\Models\InventoryItems;
use App\Models\PharmacyBranches;
use App\Models\Products;
use App\Models\Suppliers;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 *  Class Doc Comment
 *
 *  To create data
 *
 * @category  Class
 * @package   Factory
 * @author    @OxSama <mhmdtageldin@gmail.com>
 * @copyright 2021 Pharma.com.sd
 * @license   GNU General Public License version 2 or later; see LICENSE
 * @link      https://pharma.com.sd
 *
 * @since 0.1
 */
class InventoryItemsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InventoryItems::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id'=>Products::factory()->create(),
            'supplier_id'=>Suppliers::factory()->create(),
            'pharmacy_branch_id'=>PharmacyBranches::factory()->create(),

            'stock'=>$this->faker->numberBetween(0, 100),
            'reserved'=>$this->faker->numberBetween(0, 50),
            'price'=>$this->faker->randomFloat(5, 0, 10000),
            'cost'=>$this->faker->randomFloat(5, 0, 10000),

            'online_order' => $this->faker->boolean(90),

            'arrival_date'=>$this->faker->dateTimeThisYear(),
            'expire_date'=>$this->faker->dateTimeThisYear()
        ];
    }
}
