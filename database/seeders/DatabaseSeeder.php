<?php

namespace Database\Seeders;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@advinartec.test'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_approved' => true,
                'approved_at' => now(),
            ]
        );

        $jane = User::updateOrCreate(
            ['email' => 'jane@advinartec.test'],
            [
                'name' => 'Jane Doe',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_approved' => true,
                'approved_at' => now(),
            ]
        );

        $sammy = User::updateOrCreate(
            ['email' => 'sammy@advinartec.test'],
            [
                'name' => 'Sammy Leiton',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_approved' => true,
                'approved_at' => now(),
            ]
        );

        $tasks = [
            [
                'title' => 'Launch New Marketing Campaign',
                'description' => 'Plan and publish the cross-channel campaign for the new product launch, including email, landing page content, and launch analytics.',
                'priority' => TaskPriority::High,
                'status' => TaskStatus::InProgress,
                'due_date' => '2026-06-10',
                'assigned_to' => $jane->id,
            ],
            [
                'title' => 'Develop API Mapping',
                'description' => 'Create the REST API mapping document and align response resources with the repository layer.',
                'priority' => TaskPriority::High,
                'status' => TaskStatus::InProgress,
                'due_date' => '2026-06-14',
                'assigned_to' => $admin->id,
            ],
            [
                'title' => 'Develop API Endpoints',
                'description' => 'Build task list, create, status update, and AI summary endpoints with form request validation.',
                'priority' => TaskPriority::High,
                'status' => TaskStatus::InProgress,
                'due_date' => '2026-06-18',
                'assigned_to' => $sammy->id,
            ],
            [
                'title' => 'Refactor Task Policies',
                'description' => 'Review admin and assigned-user permissions, then cleanup minor policy naming issues.',
                'priority' => TaskPriority::Low,
                'status' => TaskStatus::Pending,
                'due_date' => '2026-06-21',
                'assigned_to' => $jane->id,
            ],
            [
                'title' => 'Complete Analytics Panel',
                'description' => 'Finish monthly completion charts and dashboard counts for total, completed, pending, and high-priority tasks.',
                'priority' => TaskPriority::Medium,
                'status' => TaskStatus::Completed,
                'due_date' => '2026-06-25',
                'assigned_to' => $admin->id,
            ],
        ];

        foreach ($tasks as $task) {
            Task::updateOrCreate(
                ['title' => $task['title']],
                [
                    ...$task,
                    'priority' => $task['priority']->value,
                    'status' => $task['status']->value,
                    'ai_summary' => $task['title'].' is ready for coordinated delivery. Mock AI recommends focusing on blockers, ownership, and due-date risk.',
                    'ai_priority' => $task['priority']->value,
                ]
            );
        }
    }
}
