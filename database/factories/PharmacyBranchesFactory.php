<?php
/**
 * PharmacyBranchesFactory File Doc Comment
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
use App\Models\AtmCards;
use App\Models\BankAccounts;
use App\Models\Pharmacies;
use App\Models\PharmacyBranches;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * PharmacyBranchesFactory Class Doc Comment
 *
 * PharmacyBranchesFactory to create data
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
class PharmacyBranchesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PharmacyBranches::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pharmacy_id'=>Pharmacies::factory()->create(),
            'address_id'=>Addresses::factory()->create(),
            'atm_card_id'=>AtmCards::factory()->create(),
            'bank_account_id'=>BankAccounts::factory()->create(),


            'name'=>$this->faker->randomElement(
                ['Bahry branch',
                'Khartoum branch',
                'Umdurman branch',
                '']
            ),
            'email'=>$this->faker->unique()->safeEmail,
            'support_delivery'=>$this->faker->boolean(90),

            'status'=>$this->faker->randomElement(["pending","active","rejected"]),

            'created_at'=>$this->faker->dateTimeThisYear()
        ];
    }
}
