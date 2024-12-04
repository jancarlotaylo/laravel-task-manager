
# Task Management System

This is a simple task management application that allows users to create, view, edit, and manage tasks. The application includes functionality for filtering tasks by status, assigning tasks to users, and managing task publication.

## Features

- User Authentication: Users can log in and out of the system.
- Task Management: Users can add, view, edit, and delete tasks.
- Task Filters: Tasks can be filtered by status (e.g., published or draft).
- Task Publication: Tasks can be marked as "published" or "draft."
- User-specific tasks: Each task is associated with a specific user and can be viewed and managed by that user only.
- Pagination: Tasks are paginated for easy viewing.

## Installation

### Requirements

- PHP >= 8.0
- Composer
- Laravel 10.x
- MySQL or any other supported database

### Steps

1. Clone the repository to your local machine:
   ```bashgit clone https://github.com/yourusername/task-management.git
   cd task-management```

2. Install the project dependencies using Composer:
   `composer install`

3. Copy the example environment file to `.env`:
   `cp .env.example .env`

4. Generate the application key:
   `php artisan key:generate`

5. Set up your database configuration in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=task_management
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. Run the migrations to set up the database:
   `php artisan migrate`

7. (Optional) Seed the database with sample data:
   `php artisan db:seed`

8. Serve the application:
   `php artisan serve`

   You can now access the application at `http://localhost:8000`.

## Usage

1. **Login**:
   - Navigate to `/login` and log in with your credentials.

2. **Managing Tasks**:
   - Create, edit, view, and delete tasks from the task list page.
   - Tasks can be filtered by status (e.g., "draft" or "published").
   - The tasks will only show up for the authenticated user.

3. **Task Publication**:
   - When creating or editing a task, you can mark it as "published" by selecting the appropriate toggle.

## Endpoints

### Auth

- **POST** `/login` – Login a user and start a session.
- **POST** `/logout` – Log out the authenticated user.

### Tasks

- **GET** `/tasks` – List all tasks (paginated). You can filter by `status` and search by `title`.
- **GET** `/tasks/create` – Show form to create a new task.
- **POST** `/tasks` – Create a new task.
- **GET** `/tasks/{task}` – View a specific task.
- **GET** `/tasks/{task}/edit` – Show form to edit a task.
- **PUT** `/tasks/{task}` – Update an existing task.
- **DELETE** `/tasks/{task}` – Delete a task.

## Technologies Used

- **Laravel 10.x** - PHP Framework
- **MySQL** - Database Management
- **Bootstrap 5** - Frontend Framework for responsive UI
- **Blade** - Templating Engine for views

## Contributing

1. Fork the repository.
2. Create a new branch for your feature or bugfix.
3. Commit your changes.
4. Push your changes to your forked repository.
5. Open a Pull Request to the main repository.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

**Task Management System** - A simple and efficient task management application built with Laravel.
