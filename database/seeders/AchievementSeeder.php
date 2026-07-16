<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            [
                'name' => 'First Login',
                'slug' => 'first-login',
                'description' => 'Access the ISA system for the first time.',
                'icon' => 'login',
                'xp_reward' => 25,
                'hidden' => false,
            ],
            [
                'name' => 'First Case Assigned',
                'slug' => 'first-case-assigned',
                'description' => 'Receive the first assigned investigation case.',
                'icon' => 'briefcase',
                'xp_reward' => 50,
                'hidden' => false,
            ],
            [
                'name' => 'First Case Solved',
                'slug' => 'first-case-solved',
                'description' => 'Complete the first investigation successfully.',
                'icon' => 'check-badge',
                'xp_reward' => 150,
                'hidden' => true,
            ],
            [
                'name' => 'First Report Submitted',
                'slug' => 'first-report-submitted',
                'description' => 'Submit the first official investigation report.',
                'icon' => 'document-report',
                'xp_reward' => 75,
                'hidden' => true,
            ],
            [
                'name' => 'First 100 XP',
                'slug' => 'first-100-xp',
                'description' => 'Reach 100 total current XP.',
                'icon' => 'sparkles',
                'xp_reward' => 25,
                'hidden' => false,
            ],
            [
                'name' => 'Reach Level 5',
                'slug' => 'reach-level-5',
                'description' => 'Reach personnel level 5.',
                'icon' => 'chart-bar',
                'xp_reward' => 100,
                'hidden' => false,
            ],
            [
                'name' => 'Reach Level 10',
                'slug' => 'reach-level-10',
                'description' => 'Reach personnel level 10.',
                'icon' => 'arrow-trending-up',
                'xp_reward' => 250,
                'hidden' => false,
            ],
            [
                'name' => 'Reach Clearance Level 2',
                'slug' => 'reach-clearance-level-2',
                'description' => 'Be granted ISA Clearance Level 2.',
                'icon' => 'shield-check',
                'xp_reward' => 100,
                'hidden' => false,
            ],
            [
                'name' => 'Reach Clearance Level 3',
                'slug' => 'reach-clearance-level-3',
                'description' => 'Be granted ISA Clearance Level 3.',
                'icon' => 'shield-exclamation',
                'xp_reward' => 150,
                'hidden' => false,
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::query()->updateOrCreate(
                ['slug' => $achievement['slug']],
                $achievement
            );
        }
    }
}