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
        // $username = $this->faker->userName() . random_int(0,1000);
        // $ = $this->faker->() . random_int(0,1000);
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'username' => $this->faker->unique()->userName,
            'password' =>$this->faker->password(),
            'gender'=>$this->faker->randomElement(['m','f']),
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' =>$this->faker->numerify('+249##########'),
            'address_id'=> Addresses::factory(),
            'role'=>$this->faker->randomElement(['admin','pharmacy_owner','user']),
            'status'=>$this->faker->randomElement(
                ['activated',
                'non-activated',
                'banned']
            ),
            'last_seen'=>$this->faker->dateTimeThisYear(),
            'create_time'=>$this->faker->dateTimeThisYear()
            // 'email_verified_at' => now(),
            // 'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(
            function (array $attributes) {
                return [
                'email_verified_at' => null,
                ];
            }
        );
    }
}
