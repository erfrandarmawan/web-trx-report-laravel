<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\TransactionFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'business_name' => 'Test Business',
            'email' => 'test@example.com',
        ]);

        $user->transactions()->createMany(
            TransactionFactory::new()->count(20)->make()->toArray()
        );
    }
}
