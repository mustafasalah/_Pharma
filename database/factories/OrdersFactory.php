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

use App\Models\Addresses;
use App\Models\Employees;
use App\Models\Orders;
use App\Models\PharmacyBranches;
use App\Models\User;
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
class OrdersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Orders::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employees::factory()->create(),
            'user_id' => User::factory()->create(),
            'pharmacy_branch_id'=>PharmacyBranches::factory()->create(),
            'address_id'=> Addresses::factory()->create(),


            'products_amount'=>$this->faker->numberBetween(0, 10),
            'discount' => $this->faker->randomFloat(5, 0, 10000),
            'vat' => $this->faker->randomFloat(5, 0, 10000),
            'delivery' => $this->faker->randomFloat(5, 0, 10000),

            // 'payment_proof_screenshot'=>$this->faker->sentence(),

            'type'=>$this->faker->randomElement(['local','online']),
            'status'=>$this->faker->randomElement(
                ['finished',
                'waiting',
                'payment_confirmed',
                'rejected']
            ),
            'payment_method'=>$this->faker->randomElement(
                ['MBOK',
                'ATM Card',
                'Cash']
            ),

            'created_at'=>$this->faker->dateTimeThisYear(),
            // 'users_id'=>User::factory()->create(),
        ];
    }
}
