<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 2,
                'name' => 'User 1',
                'email' => 'user1@igsprotech.com.my',
                'password' => Hash::make('1234567890'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'User 2',
                'email' => 'user2@igsprotech.com.my',
                'password' => Hash::make('1234567890'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('user_details')->insert([
            [
                'user_id' => 2,
                'approver_id' =>  23,
                'ic' =>  '880423-05-5280',
                'gender_id' => 2,
                'phoneNum' =>  '+(60)17 692-7966',
                'date_joined' => Carbon::create('2018','08','01'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
            'user_id' => 3,
            'approver_id' =>  22,
            'ic' =>  '590201-04-5321',
            'gender_id' =>  1,
            'phoneNum' =>  '+(60)12 247-1287',
            'date_joined' =>  Carbon::create('2019','01','15'),
            'last_carry_over' => Carbon::now()->year,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('leave_details')->insert([
            [
                'user_id' => 2,
                'annual_e' => 14,
                'carry_over' => 0,
                'total_leaves' => 14,
                'taken_so_far' => 10,
                'balance_leaves' => 4,
                'replacement_leaves' => 0,
                'special_leaves' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 3,
                'annual_e' => 14,
                'carry_over' => 0,
                'total_leaves' => 14,
                'taken_so_far' => 14,
                'balance_leaves' => 0,
                'replacement_leaves' => 0,
                'special_leaves' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
