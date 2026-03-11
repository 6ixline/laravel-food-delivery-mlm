<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\PerformanceBonus;
use App\Models\PlanSetting;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Default Admin
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'username'=> "admin@example",
            "password"=> "123456",
            "type"=> "admin"
        ]);

        // Default Admin Member
        Member::create([
            'membership_id' => "K3K001", 
            'membership_id_value' => 1, 
            'sponsor_id' => "", 
            'sponsor_name' => "", 
            'planid' => 0, 
            'rewardid' => 0, 
            'name' => 'Admin', 
            'father_name' => "", 
            'username' => "admin", 
            'relation_name' => "", 
            'date_of_birth' => null, 
            'gender' => "male", 
            'email' => "admin@gmail.com", 
            'password' => '123456', 
            'password_text' => '123456', 
            'mobile' => "0000000000", 
            'mobile_alter' => "", 
            'address' => "", 
            'pincode' => "110085", 
            'nominee_name' => "", 
            'kycdoc' => "", 
            'panImage' => "", 
            'bankdoc' => "", 
            'nominee_relation' => "", 
            'nominee_age' => "", 
            'bank_name' => "", 
            'branch_name' => "", 
            'account_number' => "", 
            'ifsc_code' => "", 
            'account_name' => "", 
            'pan_card' => "", 
            'aadhar_card' => "", 
            'imgName' => "", 
            'remarks' => "", 
            'status' => "active", 
            'deleted_at' => null, 
            'created_at' => now()->format('Y-m-d H:i:s'), 
            'updated_at' => null
        ]);

        // Default Plan Settings
        PlanSetting::create([
            'title' => "Plan 1",
            'tds' => "5",
            'activation_reward_point' => "200",
            'direct_referral_per'=> "50",
            'minimum_order' => "500"
        ]);


        // Default Performance Bonus Settings
        PerformanceBonus::create([
            "title" => "Executive",
            "bv_range_start" => 1,
            "bv_range_end"=> 5000,
            "incentive"=> 6,
            "monthly_self_bv"=> 200
        ]);
        PerformanceBonus::create([
            "title" => "Star",
            "bv_range_start" => 5001,
            "bv_range_end"=> 15000,
            "incentive"=> 10,
            "monthly_self_bv"=> 200
        ]);
        PerformanceBonus::create([
            "title" => "Super Star",
            "bv_range_start" => 15001,
            "bv_range_end"=> 35000,
            "incentive"=> 14,
            "monthly_self_bv"=> 200
        ]);
        PerformanceBonus::create([
            "title" => "Silver Star",
            "bv_range_start" => 35001,
            "bv_range_end"=> 70000,
            "incentive"=> 18,
            "monthly_self_bv"=> 200
        ]);
        PerformanceBonus::create([
            "title" => "Gold Star",
            "bv_range_start" => 70001,
            "bv_range_end"=> 120000,
            "incentive"=> 22,
            "monthly_self_bv"=> 200
        ]);
        PerformanceBonus::create([
            "title" => "Diamond Star",
            "bv_range_start" => 120000,
            "bv_range_end"=> 0,
            "incentive"=> 26,
            "monthly_self_bv"=> 200
        ]);
    }
}
