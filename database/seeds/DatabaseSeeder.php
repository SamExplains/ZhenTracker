<?php

use App\Alert;
use App\Association;
use App\Checklist;
use App\Company;
use App\Form;
use App\KeyDueDates;
use App\RDCredit;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @param Faker $faker
   * @return void
   */
    public function run(Faker $faker)
    {
        // $this->call(UserSeeder::class);
      // Company

      for ($i=0; $i < 5; $i++) {
        $company_name = $faker->company;
          $company = Company::create([
                    'name' => $company_name,
                    'ein' => $faker->numberBetween(100000000,999999999),
                    'business_start_date' => $faker->date('Y-m-d'),
                    'business_first_year_end_date' => $faker->date('Y-m-d'),
                    'first_income_year' => $faker->date('Y-m-d'),
                    'final_date_payroll_claim' => $faker->date('Y-m-d'),
                    'company_type' => 'C',
                    'email' => $faker->email,
                    'phone' => $faker->randomNumber(9),
                    'officer' => $faker->firstName,
                  ]);

        $user = User::create([
                              'uid' => uniqid(),
                              'name' => $faker->firstName,
                              'email' => $faker->email,
                              'photoURL' => 'some-url',
                              'description' => 'A short bio',
                              'registration_date' => time(),
                              'points' => '0',
                              'status' => ($i===0) ? 'Admin' : 'User',
                              'online' => false,
                              'signup_procedure' => 'app',
                              'disabled' => false,
                              'email_verified_at' => time(),
                            ]);

          for ($j=0; $j < 5; $j++) {

            Checklist::create([
              'company_id' => $company->id,
              'item' => $faker->sentence,
              'completed' => 0
            ]);

              if ($j === 0) {
                Association::create([
                  'user_id' => $user->id,
                  'company_name' => $company->name,
                  'company_id' => $company->id
                ]);
              }

            // RDCredit::create([
            //   'company_id' => $company->id,
            //   'return_type' => '1040',
            //   'quarter' => 'Q1',
            //   'year' => '2020',
            //   'period' => $faker->date(),
            //   'date_return_filed' => $faker->date(),
            //   'credit_amount' => $faker->numberBetween(1000,25000),
            //   'credit_claimed' => $faker->numberBetween(1000,25000),
            //   'credit_available' => $faker->numberBetween(1000,25000),
            //   'credit_received' => $faker->numberBetween(1000,25000),
            // ]);

            switch($j) {
              case 0:
                RDCredit::create([
                  'company_id' => $company->id,
                  'return_type' => '1040',
                  'quarter' => 'Q1',
                  'year' => '2020',
                  'period' => $faker->date(),
                  'date_return_filed' => $faker->date(),
                  'credit_amount' => 20000,
                  'credit_claimed' => 5000,
                  'credit_available' => 15000,
                  'credit_received' => $faker->numberBetween(1000,25000),
                ]);
              break;
              case 1:
                RDCredit::create([
                  'company_id' => $company->id,
                  'return_type' => '1040',
                  'quarter' => 'Q1',
                  'year' => '2020',
                  'period' => $faker->date(),
                  'date_return_filed' => $faker->date(),
                  'credit_amount' => 15000,
                  'credit_claimed' => 5000,
                  'credit_available' => 10000,
                  'credit_received' => $faker->numberBetween(1000,25000),
                ]);
              break;
              case 2:
                RDCredit::create([
                  'company_id' => $company->id,
                  'return_type' => '1040',
                  'quarter' => 'Q1',
                  'year' => '2020',
                  'period' => $faker->date(),
                  'date_return_filed' => $faker->date(),
                  'credit_amount' => 10000,
                  'credit_claimed' => 5000,
                  'credit_available' => 5000,
                  'credit_received' => $faker->numberBetween(1000,25000),
                ]);
              break;
              case 3:
                RDCredit::create([
                  'company_id' => $company->id,
                  'return_type' => '1040',
                  'quarter' => 'Q1',
                  'year' => '2020',
                  'period' => $faker->date(),
                  'date_return_filed' => $faker->date(),
                  'credit_amount' => 5000,
                  'credit_claimed' => 2500,
                  'credit_available' => 2500,
                  'credit_received' => $faker->numberBetween(1000,25000),
                ]);
              break;
              case 4:
                RDCredit::create([
                  'company_id' => $company->id,
                  'return_type' => '1040',
                  'quarter' => 'Q1',
                  'year' => '2020',
                  'period' => $faker->date(),
                  'date_return_filed' => $faker->date(),
                  'credit_amount' => 2500,
                  'credit_claimed' => 2500,
                  'credit_available' => 0,
                  'credit_received' => $faker->numberBetween(1000,25000),
                ]);
              break;
            }


            Form::create([
              'company_id' => $company->id,
              'quarter' => 'Q1',
              'year' => '2020',
              'form_type' => '1040',
              'period' => $faker->date(),
            ]);

            Alert::create([
              'company_id' => $company->id,
              'company_name' => $company_name,
              'company_ein' => $company->ein,
              'title' => $faker->title,
              'body' => $faker->sentence
            ]);

            KeyDueDates::create([
              'company_id' => $company->id,
              'date' => '01/01/2020',
              'title' => $faker->sentence(5),
              'description' => $faker->sentence(10),
            ]);

          }

        $company->save();
        $user->save();
      }

      // R&D Credits
      // Forms

      // Alerts

    }
}
