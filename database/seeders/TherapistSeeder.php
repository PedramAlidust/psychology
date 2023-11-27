<?php

namespace Database\Seeders;

use App\Models\Therapist;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TherapistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all(); 
        foreach($users as $user) {
            Therapist::factory()->create([
                'user_id' => $user->id
            ]);
        }
    }
}
