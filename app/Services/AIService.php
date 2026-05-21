<?php

namespace App\Services;

use App\Enums\TaskPriority;
use App\Models\Task;
use Throwable;

class AIService
{
    public function generateSummary(Task $task): array
    {
        try {
            return $this->mockResponse($task);
        } catch (Throwable) {
            return [
                'ai_summary' => 'AI summary is temporarily unavailable. Please refresh again later.',
                'ai_priority' => $task->priority->value,
            ];
        }
    }

    public function prompt(Task $task): string
    {
        return <<<PROMPT
Summarize this task for a project manager in two short sentences.
Return JSON with keys: ai_summary and ai_priority.
Allowed priorities: low, medium, high.
Title: {$task->title}
Description: {$task->description}
Current priority: {$task->priority->value}
Status: {$task->status->value}
PROMPT;
    }

    private function mockResponse(Task $task): array
    {
        $description = strtolower($task->description);
        $priority = match (true) {
            str_contains($description, 'urgent') || str_contains($description, 'launch') => TaskPriority::High,
            str_contains($description, 'minor') || str_contains($description, 'cleanup') => TaskPriority::Low,
            default => $task->priority,
        };

        return [
            'ai_summary' => sprintf(
                '%s focuses on %s. Suggested next step: keep ownership clear, watch the due date, and move the task through review promptly.',
                $task->title,
                str($task->description)->squish()->limit(120)->lower()
            ),
            'ai_priority' => $priority->value,
        ];
    }
}
