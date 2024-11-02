<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void 
    {
        // Seeding using the Qury Buidler Techniques #1
        $users = [
            [
                'id' => 1,
                'name' => "MK_student",
                'email' => "MK@gmail.com",
                'password' => hash::make("123123123"),
                'img_profile' => "",
                'user_role_id' => 1,
            ],
            [
                'id' => 2,
                'name' => "Advisor1",
                'email' => "Advisor1@gmail.com",
                'password' => hash::make("123123123"),
                'img_profile' => "",
                'user_role_id' => 2,
            ],
            [
                'id' => 3,
                'name' => "Advisor2",
                'email' => "Advisor2@gmail.com",
                'password' => hash::make("123123123"),
                'img_profile' => "",
                'user_role_id' => 2,
            ],
        ];

        DB::table('users')->insert($users);

        // Seeding using the Qury Buidler Techniques #2
        User::create([
            'id' => 4,
            'name' => "Student2",
            'email' => "Student2@gmail.com",
            'password' => hash::make("123123123"),
            'img_profile' => "profiles/lydNVBrES1eIs9m1g3A1np4A16diU6Xft2QFe1nn.png",
            'user_role_id' => 1,
        ]);

        User::create([
            'id' => 5,
            'name' => "Student3",
            'email' => "Student3@gmail.com",
            'password' => hash::make("123123123"),
            'img_profile' => "profiles/lydNVBrES1eIs9m1g3A1np4A16diU6Xft2QFe1nn.png",
            'user_role_id' => 1,
        ]);

        User::create([
            'id' => 6,
            'name' => "Advisor3",
            'email' => "Advisor3@gmail.com",
            'password' => hash::make("123123123"),
            'img_profile' => "profiles/lydNVBrES1eIs9m1g3A1np4A16diU6Xft2QFe1nn.png",
            'user_role_id' => 2,
        ]);

        User::create([
            'id' => 7,
            'name' => "Advisor4",
            'email' => "Advisor4@gmail.com",
            'password' => hash::make("123123123"),
            'img_profile' => "profiles/lydNVBrES1eIs9m1g3A1np4A16diU6Xft2QFe1nn.png",
            'user_role_id' => 2,
        ]);

        User::create([
            'id' => 8,
            'name' => "Advisor5",
            'email' => "Advisor5@gmail.com",
            'password' => hash::make("123123123"),
            'img_profile' => "profiles/lydNVBrES1eIs9m1g3A1np4A16diU6Xft2QFe1nn.png",
            'user_role_id' => 2,
        ]);

        User::create([
            'id' => 9,
            'name' => "student4",
            'email' => "student4@gmail.com",
            'password' => hash::make("123123123"),
            'img_profile' => "profiles/lydNVBrES1eIs9m1g3A1np4A16diU6Xft2QFe1nn.png",
            'user_role_id' => 1,
        ]);

        User::create([
            'id' => 10,
            'name' => "student5",
            'email' => "student5@gmail.com",
            'password' => hash::make("123123123"),
            'img_profile' => "profiles/lydNVBrES1eIs9m1g3A1np4A16diU6Xft2QFe1nn.png",
            'user_role_id' => 1,
        ]);


        // CREDENTIAL FOR LOGGING
        User::create([
            'id' => 11,
            'name' => "admin",
            'email' => "admin@admin.com",
            'password' => hash::make("123123123"),
            'img_profile' => "profiles/lydNVBrES1eIs9m1g3A1np4A16diU6Xft2QFe1nn.png",
            'user_role_id' => 5,
        ]);

        User::create([
            'id' => 12,
            'name' => "student",
            'email' => "student@student.com",
            'password' => hash::make("123123123"),
            'img_profile' => "profiles/lydNVBrES1eIs9m1g3A1np4A16diU6Xft2QFe1nn.png",
            'user_role_id' => 1,
        ]);

        User::create([
            'id' => 13,
            'name' => "advisor",
            'email' => "advisor@advisor.com",
            'password' => hash::make("123123123"),
            'img_profile' => "profiles/lydNVBrES1eIs9m1g3A1np4A16diU6Xft2QFe1nn.png",
            'user_role_id' => 2,
        ]);

        // JURY SEEDER
        User::create([
            'id' => 14,
            'name' => "J1",
            'email' => "J1@gmail.com",
            'password' => hash::make("123123123"),
            'img_profile' => "profiles/lydNVBrES1eIs9m1g3A1np4A16diU6Xft2QFe1nn.png",
            'user_role_id' => 4,
        ]);
        User::create([
            'id' => 15,
            'name' => "J2",
            'email' => "J2@gmail.com",
            'password' => hash::make("123123123"),
            'img_profile' => "profiles/lydNVBrES1eIs9m1g3A1np4A16diU6Xft2QFe1nn.png",
            'user_role_id' => 4,
        ]);

        User::create([
            'id' => 16,
            'name' => "J3",
            'email' => "J3@gmail.com",
            'password' => hash::make("123123123"),
            'img_profile' => "profiles/lydNVBrES1eIs9m1g3A1np4A16diU6Xft2QFe1nn.png",
            'user_role_id' => 4,
        ]);
        User::create([
            'id' => 17,
            'name' => "J4",
            'email' => "J4@gmail.com",
            'password' => hash::make("123123123"),
            'img_profile' => "profiles/lydNVBrES1eIs9m1g3A1np4A16diU6Xft2QFe1nn.png",
            'user_role_id' => 4,
        ]);
        User::create([
            'id' => 18,
            'name' => "J5",
            'email' => "J5@gmail.com",
            'password' => hash::make("123123123"),
            'img_profile' => "profiles/lydNVBrES1eIs9m1g3A1np4A16diU6Xft2QFe1nn.png",
            'user_role_id' => 4,
        ]);
        User::create([
            'id' => 19,
            'name' => "J6",
            'email' => "J6@gmail.com",
            'password' => hash::make("123123123"),
            'img_profile' => "profiles/lydNVBrES1eIs9m1g3A1np4A16diU6Xft2QFe1nn.png",
            'user_role_id' => 4,
        ]);

        User::create([
            'id' => 20,
            'name' => "J7",
            'email' => "J7@gmail.com",
            'password' => hash::make("123123123"),
            'img_profile' => "profiles/lydNVBrES1eIs9m1g3A1np4A16diU6Xft2QFe1nn.png",
            'user_role_id' => 4,
        ]);

        $juryUsers = [
            ['id' => 21, 'name' => "Vibol Khemara", 'email' => "vibol.khemara@gmail.com"],
            ['id' => 22, 'name' => "Serey Mealea", 'email' => "serey.mealea@gmail.com"],
            ['id' => 23, 'name' => "Sophea Chenda", 'email' => "sophea.chenda@gmail.com"],
            ['id' => 24, 'name' => "Rithy Somnang", 'email' => "rithy.somnang@gmail.com"],
            ['id' => 25, 'name' => "Chea Sokha", 'email' => "chea.sokha@gmail.com"],
            ['id' => 26, 'name' => "Piseth Dara", 'email' => "piseth.dara@gmail.com"],
            ['id' => 27, 'name' => "Sopheap Bunthoeun", 'email' => "sopheap.bunthoeun@gmail.com"],
            ['id' => 28, 'name' => "Phat Phally", 'email' => "phat.phally@gmail.com"],
            ['id' => 29, 'name' => "Rachana Sith", 'email' => "rachana.sith@gmail.com"],
            ['id' => 30, 'name' => "Sokun Vicheka", 'email' => "sokun.vicheka@gmail.com"],
            ['id' => 31, 'name' => "Sothea Pich", 'email' => "sothea.pich@gmail.com"],
            ['id' => 32, 'name' => "Veasna Samnang", 'email' => "veasna.samnang@gmail.com"],
            ['id' => 33, 'name' => "Bopha Ponnarith", 'email' => "bopha.ponnarith@gmail.com"],
            ['id' => 34, 'name' => "Chenda Sopheak", 'email' => "chenda.sopheak@gmail.com"],
            ['id' => 35, 'name' => "Sokun Rith", 'email' => "sokun.rith@gmail.com"],
            ['id' => 36, 'name' => "Dara Sophal", 'email' => "dara.sophal@gmail.com"],
            ['id' => 37, 'name' => "Pheakdey Kongkea", 'email' => "pheakdey.kongkea@gmail.com"],
            ['id' => 38, 'name' => "Meas Chanra", 'email' => "meas.chanra@gmail.com"],
            ['id' => 39, 'name' => "Vuthy Nary", 'email' => "vuthy.nary@gmail.com"],
            ['id' => 40, 'name' => "Chan Mony", 'email' => "chan.mony@gmail.com"],
        ];

        foreach ($juryUsers as $user) {
            User::create([
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make("123123123"),
                'img_profile' => "profiles/1.png",
                'user_role_id' => 4,
            ]);
        }
    }
}
