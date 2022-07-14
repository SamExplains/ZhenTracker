<?php

use App\Event;
use App\Registration;
use App\StandardSignup;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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
        // Create some users and push IDs to array to use when generating Events
        $userIds = [];
        $eventIds = [];
        for ($i = 0; $i < 50; $i++) {
            $user = StandardSignup::create([
                'email' => $faker->email,
                'zip' => $faker->text(5),
                'name' => $faker->name(),
                'password' => '$2y$10$VunW6DeDy/pfPAtA.5ZrBeTHbucb75rdD0QR8dUUn5MmTbsCt0oQS',
                'uuid' => Str::random(15),
                'qrcode_src' => 'https://momsinla-storage.s3.us-west-1.amazonaws.com/partybemine/partybemine/user_qr_codes/a5b7199a-2630-40b9-bf41-89c1818070af.png',
                'profile_image_src' => "https://momsinla-storage.s3.us-west-1.amazonaws.com/partybemine/profile/default.png",
                'token' => Str::random(60),
                'role' => 'USER',
            ]);
            // Push IDs for use down below
            array_push($userIds, $user->id);
        }

        for ($i = 0; $i < 100; $i++) {
            // Create new events
            $CREATOR_ID = $userIds[rand(0, 49)];

            $event = Event::create([
                'description' => $faker->paragraph(),
                'start_time' => Carbon::now()->subDays(random_int(0, 55))->format('Y/m/d H:i'),
                'end_time' => Carbon::now()->subDays(random_int(0, 55))->format('Y/m/d H:i'),
                'first_image' => 'https://momsinla-storage.s3.us-west-1.amazonaws.com/partybemine/event_images/' . rand(1, 6) . '.jpg',
                'second_image' => 'https://momsinla-storage.s3.us-west-1.amazonaws.com/partybemine/event_images/' . rand(1, 6) . '.jpg',
                'address' => $faker->text(12),
                'city' => $faker->text(5),
                'zip' => $faker->numberBetween(10000, 99999),
                'public_private' => rand(0, 1),
                'private_authentication_code' => Str::random(13),
                'on_off_line' => rand(0, 1),
                'check_in' => rand(0, 1),
                'capacity' => rand(1, 250),
                'additional_items' => '[{"id":957,"name":"Peanuts","taken":null,"checked":false},{"id":152,"name":"Cake","taken":null,"checked":false},{"id":337,"name":"Chocolate","taken":null,"checked":false}]',
                'title' => $faker->text(15),
                'url' => $faker->url,
                'email' => $faker->email,
                'phone' => $faker->text(7),
                'qrcode' => "https://momsinla-storage.s3.us-west-1.amazonaws.com/partybemine/event_qr_codes/levzkoBjCnmXlyNAZnweDcc9bF4Mca38TiTeCPkpufS2kvoPMEqJkPxq78yh.png",
                'creator_id' => $CREATOR_ID,
                'event_key' => Str::random(6),
            ]);
            array_push($eventIds, $event->id);
            // Create Registration seeds
            Registration::create([
                'creator_id' => $CREATOR_ID,
                'event_id' => $eventIds[count($eventIds) - 1],
            ]);

        }

        // for ($i=0; $i < 5; $i++) {
        //   $company_name = $faker->company;
        //     $company = Company::create([
        //               'name' => $company_name,
        //               'ein' => $faker->numberBetween(100000000,999999999),
        //               'business_start_date' => $faker->date('Y-m-d'),
        //               'business_first_year_end_date' => $faker->date('Y-m-d'),
        //               'first_income_year' => $faker->date('Y-m-d'),
        //               'final_date_payroll_claim' => $faker->date('Y-m-d'),
        //               'company_type' => 'C',
        //               'email' => $faker->email,
        //               'phone' => $faker->randomNumber(9),
        //               'officer' => $faker->firstName,
        //             ]);

        //   $user = User::create([
        //                         'uid' => uniqid(),
        //                         'name' => $faker->firstName,
        //                         'email' => $faker->email,
        //                         'photoURL' => 'some-url',
        //                         'description' => 'A short bio',
        //                         'registration_date' => time(),
        //                         'points' => '0',
        //                         'status' => ($i===0) ? 'Admin' : 'User',
        //                         'online' => false,
        //                         'signup_procedure' => 'app',
        //                         'disabled' => false,
        //                         'email_verified_at' => time(),
        //                       ]);

        //     for ($j=0; $j < 5; $j++) {

        //       Checklist::create([
        //         'company_id' => $company->id,
        //         'item' => $faker->sentence,
        //         'completed' => 0
        //       ]);

        //         if ($j === 0) {
        //           Association::create([
        //             'user_id' => $user->id,
        //             'company_name' => $company->name,
        //             'company_id' => $company->id
        //           ]);
        //         }

        //       // RDCredit::create([
        //       //   'company_id' => $company->id,
        //       //   'return_type' => '1040',
        //       //   'quarter' => 'Q1',
        //       //   'year' => '2020',
        //       //   'period' => $faker->date(),
        //       //   'date_return_filed' => $faker->date(),
        //       //   'credit_amount' => $faker->numberBetween(1000,25000),
        //       //   'credit_claimed' => $faker->numberBetween(1000,25000),
        //       //   'credit_available' => $faker->numberBetween(1000,25000),
        //       //   'credit_received' => $faker->numberBetween(1000,25000),
        //       // ]);

        //       switch($j) {
        //         case 0:
        //           RDCredit::create([
        //             'company_id' => $company->id,
        //             'return_type' => '1040',
        //             'quarter' => 'Q1',
        //             'year' => '2020',
        //             'period' => $faker->date(),
        //             'date_return_filed' => $faker->date(),
        //             'credit_amount' => 20000,
        //             'credit_claimed' => 5000,
        //             'credit_available' => 15000,
        //             'credit_received' => $faker->numberBetween(1000,25000),
        //           ]);
        //         break;
        //         case 1:
        //           RDCredit::create([
        //             'company_id' => $company->id,
        //             'return_type' => '1040',
        //             'quarter' => 'Q1',
        //             'year' => '2020',
        //             'period' => $faker->date(),
        //             'date_return_filed' => $faker->date(),
        //             'credit_amount' => 15000,
        //             'credit_claimed' => 5000,
        //             'credit_available' => 10000,
        //             'credit_received' => $faker->numberBetween(1000,25000),
        //           ]);
        //         break;
        //         case 2:
        //           RDCredit::create([
        //             'company_id' => $company->id,
        //             'return_type' => '1040',
        //             'quarter' => 'Q1',
        //             'year' => '2020',
        //             'period' => $faker->date(),
        //             'date_return_filed' => $faker->date(),
        //             'credit_amount' => 10000,
        //             'credit_claimed' => 5000,
        //             'credit_available' => 5000,
        //             'credit_received' => $faker->numberBetween(1000,25000),
        //           ]);
        //         break;
        //         case 3:
        //           RDCredit::create([
        //             'company_id' => $company->id,
        //             'return_type' => '1040',
        //             'quarter' => 'Q1',
        //             'year' => '2020',
        //             'period' => $faker->date(),
        //             'date_return_filed' => $faker->date(),
        //             'credit_amount' => 5000,
        //             'credit_claimed' => 2500,
        //             'credit_available' => 2500,
        //             'credit_received' => $faker->numberBetween(1000,25000),
        //           ]);
        //         break;
        //         case 4:
        //           RDCredit::create([
        //             'company_id' => $company->id,
        //             'return_type' => '1040',
        //             'quarter' => 'Q1',
        //             'year' => '2020',
        //             'period' => $faker->date(),
        //             'date_return_filed' => $faker->date(),
        //             'credit_amount' => 2500,
        //             'credit_claimed' => 2500,
        //             'credit_available' => 0,
        //             'credit_received' => $faker->numberBetween(1000,25000),
        //           ]);
        //         break;
        //       }

        //       Form::create([
        //         'company_id' => $company->id,
        //         'quarter' => 'Q1',
        //         'year' => '2020',
        //         'form_type' => '1040',
        //         'period' => $faker->date(),
        //       ]);

        //       Alert::create([
        //         'company_id' => $company->id,
        //         'company_name' => $company_name,
        //         'company_ein' => $company->ein,
        //         'title' => $faker->title,
        //         'body' => $faker->sentence
        //       ]);

        //       KeyDueDates::create([
        //         'company_id' => $company->id,
        //         'date' => '01/01/2020',
        //         'title' => $faker->sentence(5),
        //         'description' => $faker->sentence(10),
        //       ]);

        //     }

        //   $company->save();
        //   $user->save();
        // }

    }
}