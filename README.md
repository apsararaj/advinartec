# Advinartec Machine Test

AI-assisted task management system built with Laravel 12, Blade, Tailwind CSS, repository pattern, service layer, policies, REST APIs, and a mocked AI integration.

## Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

The project is configured for MySQL. Create a local database named `advinartec_machine_test` before running migrations, or update `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env`.

If you are already serving the project locally, open:

```text
http://127.0.0.1:8001/
```

## Authentication

The app uses Laravel session authentication with a custom lightweight login/logout/registration flow.

Seeded accounts:

- Admin: `admin@advinartec.test` / `password`
- User: `jane@advinartec.test` / `password`
- User: `sammy@advinartec.test` / `password`

Roles:

- Admin: can view, create, update, assign, and delete all tasks.
- User: can view and update only tasks assigned to them. Users can create tasks only for themselves after approval.

New user registration:

- Guests can register from `/register`.
- New accounts are created as `role=user` and `is_approved=false`.
- Pending users cannot log in.
- Admins approve users from the sidebar Users section.

## Architecture

Controllers do not call Eloquent directly for task persistence. The task flow is:

`TaskController` -> Form Request validation and policy authorization -> `TaskService` -> `TaskRepositoryInterface` -> `TaskRepository` -> `Task` model.

Important files:

- `app/Repositories/Contracts/TaskRepositoryInterface.php`
- `app/Repositories/Eloquent/TaskRepository.php`
- `app/Services/TaskService.php`
- `app/Services/AIService.php`
- `app/Policies/TaskPolicy.php`
- `app/Http/Resources/TaskResource.php`
- `app/Providers/RepositoryServiceProvider.php`

## Security And Validation

Task access is enforced in `app/Policies/TaskPolicy.php`:

- `viewAny`: authenticated users can reach task listing.
- `view`: admin or assigned user only.
- `create`: authenticated admin/user roles.
- `update`: admin or assigned user only.
- `delete`: admin only.

User access is enforced in `app/Policies/UserPolicy.php`:

- `viewAny`: admin only.
- `approve`: admin only, and admin accounts cannot be approved through the pending-user action.

Form requests validate all task writes:

- `StoreTaskRequest`
- `UpdateTaskRequest`
- `UpdateTaskStatusRequest`

Validation includes required title/description, enum-backed status and priority, future or today due date, approved/allowed assignee, and role-aware assignment checks. A regular user cannot submit another user's id in `assigned_to`, even if they tamper with the form or API request.

## Mock AI

`AIService` owns prompt creation, response shaping, priority inference, and fallback handling. It is intentionally mocked, so no external API key is needed.

Documented AI prompt:

```text
Summarize this task for a project manager in two short sentences.
Return JSON with keys: ai_summary and ai_priority.
Allowed priorities: low, medium, high.
Title: {task title}
Description: {task description}
Current priority: {priority}
Status: {status}
```

The mock fallback returns:

- `ai_summary`: concise manager-facing task summary
- `ai_priority`: inferred from task text, with high priority for urgent/launch language and low priority for cleanup/minor work

## REST API

All API routes are protected by `auth`, use validation, policy checks, API resources, and proper status codes.

- `GET /api/tasks`
- `POST /api/tasks`
- `PATCH /api/tasks/{task}/status`
- `GET /api/tasks/{task}/ai-summary`

Example authenticated task payload:

```json
{
  "title": "Launch Sales Campaign",
  "description": "Urgent launch campaign across email and content channels.",
  "priority": "medium",
  "status": "in_progress",
  "due_date": "2026-06-30",
  "assigned_to": 1
}
```

## UI

The Blade UI implements the three requested screens from the supplied images:

- Task List
- Create/Edit Task
- Task Detail + AI Summary

The layout is responsive and uses stylesheet classes only, with no inline CSS.

## Tests

```bash
php artisan test
```

Feature coverage includes task creation with mock AI, unauthorized task access prevention, assignment tampering prevention, status API updates, pending registration, blocked pending login, admin approval, and non-admin denial for the Users section.
