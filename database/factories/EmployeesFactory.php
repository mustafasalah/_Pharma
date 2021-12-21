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

use App\Models\Employees;
use App\Models\PharmacyBranches;
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
class EmployeesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employees::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $username = $this->faker->userName() . random_int(0,1000);
        return [
            'fullname'=>$this->faker->name(),
            'username'=>$this->faker->unique()->userName,
            'password'=>$this->faker->password(),
            'role'=>$this->faker->randomElement(['pharmacist','branch_manager']),
            'pharmacy_branch_id'=>PharmacyBranches::factory()->create(),
            'phone_number'=>$this->faker->numerify('+249##########'),
            'gender'=>$this->faker->randomElement(['m','f']),
            'work_from'=>$this->faker->time(),
            'work_to'=>$this->faker->time(),
        ];
    }
}
