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

use App\Models\Orders;
use App\Models\OrdersProducts;
use App\Models\Products;
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
class OrdersProductsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrdersProducts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id'=>Products::factory()->create(),
            'order_id'=>Orders::factory()->create(),
            'quantity'=>$this->faker->randomDigit(),
            'price'=>$this->faker->numberBetween(0, 12345),
            'cost'=>$this->faker->numberBetween(0, 12345)
        ];
    }
}
