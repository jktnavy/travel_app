<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'employee_code' => 'EMP-0001',
                'name' => 'Admin Deny Trans',
                'email' => 'admin@denytrans.test',
                'phone' => '081200000001',
                'role' => 'admin',
            ],
            [
                'employee_code' => 'EMP-0002',
                'name' => 'Finance Deny Trans',
                'email' => 'finance@denytrans.test',
                'phone' => '081200000002',
                'role' => 'finance',
            ],
            [
                'employee_code' => 'EMP-0003',
                'name' => 'Owner Deny Trans',
                'email' => 'owner@denytrans.test',
                'phone' => '081200000003',
                'role' => 'owner',
            ],
        ];

        foreach ($users as $attributes) {
            $role = $attributes['role'];
            unset($attributes['role']);

            $user = User::query()->updateOrCreate(
                ['email' => $attributes['email']],
                array_merge($attributes, [
                    'password' => 'password',
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]),
            );

            $user->syncRoles([$role]);
        }
    }
}
