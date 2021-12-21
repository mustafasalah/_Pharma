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
use App\Models\OrdersNotifications;
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
class OrdersNotificationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrdersNotifications::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type'=>'order',
            'order_id'=>Orders::factory()->create()
        ];
    }
}
